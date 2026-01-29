#!/bin/bash

# Railway startup script for Osamunime App

# Set the application URL to the Railway-provided URL
export APP_URL="https://${RAILWAY_PUBLIC_URL:-localhost}"

# Check if we're using Railway's PostgreSQL
if [ ! -z "$POSTGRES_HOST" ]; then
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

# Generate application key if not present
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Wait a bit for the database to be ready
sleep 5

# Run database migrations
php artisan migrate --force --no-interaction

# Publish assets and build for production
php artisan vendor:publish --tag=laravel-assets --force
npm run build

# Cache configuration for better performance
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the Laravel application
exec php artisan serve --host=0.0.0.0 --port=$PORT