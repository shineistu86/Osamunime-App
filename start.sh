#!/bin/bash

# Railway startup script for Osamunime App

set -e  # Exit immediately if a command exits with a non-zero status

# Set the application URL to the Railway-provided URL
export APP_URL="https://${RAILWAY_PUBLIC_URL:-localhost}"

# Check if we're using Railway's PostgreSQL (using the variables provided by Railway)
# Railway provides these variables as references like ${{Postgres.PGHOST}}
if [ ! -z "$PGHOST" ] || [[ "$PGHOST" == *"*"* ]]; then
    # If PGHOST contains special characters (like ${{Postgres.PGHOST}}), Railway hasn't substituted them
    # In this case, we'll use the Railway-specific variables directly
    if [[ "$RAILWAY_POSTGRES_HOST" != "" ]]; then
        export DB_CONNECTION=pgsql
        export DB_HOST=$RAILWAY_POSTGRES_HOST
        export DB_PORT=${RAILWAY_POSTGRES_PORT:-5432}
        export DB_DATABASE=$RAILWAY_POSTGRES_DATABASE
        export DB_USERNAME=$RAILWAY_POSTGRES_USER
        export DB_PASSWORD=$RAILWAY_POSTGRES_PASSWORD
    else
        # Fallback to standard PG_* variables if Railway-specific ones aren't available
        export DB_CONNECTION=pgsql
        export DB_HOST=$PGHOST
        export DB_PORT=$PGPORT
        export DB_DATABASE=$PGDATABASE
        export DB_USERNAME=$PGUSER
        export DB_PASSWORD=$PGPASSWORD
    fi
elif [ ! -z "$POSTGRES_HOST" ]; then
    # Fallback to POSTGRES_* variables if PG_* are not available
    export DB_CONNECTION=pgsql
    export DB_HOST=$POSTGRES_HOST
    export DB_PORT=$POSTGRES_PORT
    export DB_DATABASE=$POSTGRES_DB
    export DB_USERNAME=$POSTGRES_USER
    export DB_PASSWORD=$POSTGRES_PASSWORD
elif [ ! -z "$MYSQL_HOST" ]; then
    # Check if we're using MySQL
    export DB_CONNECTION=mysql
    export DB_HOST=$MYSQL_HOST
    export DB_PORT=$MYSQL_PORT
    export DB_DATABASE=$MYSQL_DATABASE
    export DB_USERNAME=$MYSQL_USER
    export DB_PASSWORD=$MYSQL_PASSWORD
else
    # Fallback to SQLite if no external database is configured
    export DB_CONNECTION=sqlite
    export DB_DATABASE=/tmp/database.sqlite
fi

echo "Database configuration set:"
echo "DB_HOST: $DB_HOST"
echo "DB_PORT: $DB_PORT"
echo "DB_DATABASE: $DB_DATABASE"
echo "DB_USERNAME: $DB_USERNAME"

# Generate application key if not present
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Clear and cache configuration
php artisan config:clear

# Wait a bit for the database to be ready
sleep 5

# Test database connection before proceeding
echo "Testing database connection..."
php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connected successfully';" || {
    echo "Database connection failed!"
    exit 1
}

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force --no-interaction

# Publish assets and build for production
echo "Publishing assets..."
php artisan vendor:publish --tag=laravel-assets --force

# Build frontend assets if needed
if [ -f "package.json" ] && command -v npm &> /dev/null; then
    echo "Building frontend assets..."
    npm ci --only=production
    npm run build
fi

# Clear and cache configuration for better performance after migrations
echo "Caching configuration..."
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting application..."
# Start the Laravel application
exec php artisan serve --host=0.0.0.0 --port=$PORT