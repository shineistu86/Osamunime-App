<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Check if we're running on Railway with PostgreSQL
        if (isset($_SERVER['RAILWAY_PROJECT_ID']) || !empty(getenv('PGHOST'))) {
            // Use PostgreSQL when running on Railway
            if (config('database.default') !== 'pgsql') {
                config(['database.default' => 'pgsql']);
            }
        }
        // Otherwise, use the default configuration from .env
    }
}
