<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Dynamically configure database based on environment
        if (app()->environment('production')) {
            // For Railway deployment, detect database type from environment
            $this->configureDatabaseForProduction();
        }
    }

    private function configureDatabaseForProduction(): void
    {
        // Check if we have PostgreSQL environment variables
        if (getenv('PGHOST') || getenv('POSTGRES_HOST')) {
            Config::set([
                'database.connections.pgsql.host' => getenv('PGHOST') ?: getenv('POSTGRES_HOST'),
                'database.connections.pgsql.port' => getenv('PGPORT') ?: getenv('POSTGRES_PORT') ?: 5432,
                'database.connections.pgsql.database' => getenv('PGDATABASE') ?: getenv('POSTGRES_DB'),
                'database.connections.pgsql.username' => getenv('PGUSER') ?: getenv('POSTGRES_USER'),
                'database.connections.pgsql.password' => getenv('PGPASSWORD') ?: getenv('POSTGRES_PASSWORD'),
            ]);

            // Set default connection to PostgreSQL
            Config::set('database.default', 'pgsql');
        }
        // Check if we have MySQL environment variables
        elseif (getenv('MYSQL_HOST') || getenv('DB_HOST')) {
            Config::set([
                'database.connections.mysql.host' => getenv('MYSQL_HOST') ?: getenv('DB_HOST'),
                'database.connections.mysql.port' => getenv('MYSQL_PORT') ?: getenv('DB_PORT') ?: 3306,
                'database.connections.mysql.database' => getenv('MYSQL_DATABASE') ?: getenv('DB_DATABASE'),
                'database.connections.mysql.username' => getenv('MYSQL_USER') ?: getenv('DB_USERNAME'),
                'database.connections.mysql.password' => getenv('MYSQL_PASSWORD') ?: getenv('DB_PASSWORD'),
            ]);

            // Set default connection to MySQL
            Config::set('database.default', 'mysql');
        }
    }
}