<?php

// Production-specific configuration for Railway deployment
if (isset($_SERVER['RAILWAY_DEPLOYMENT_ID'])) {
    // When running on Railway, ensure PostgreSQL is used
    return [
        'database' => [
            'default' => 'pgsql',
            'connections' => [
                'pgsql' => [
                    'driver' => 'pgsql',
                    'host' => env('PGHOST', env('POSTGRES_HOST', '127.0.0.1')),
                    'port' => env('PGPORT', env('POSTGRES_PORT', '5432')),
                    'database' => env('PGDATABASE', env('POSTGRES_DB', 'forge')),
                    'username' => env('PGUSER', env('POSTGRES_USER', 'forge')),
                    'password' => env('PGPASSWORD', env('POSTGRES_PASSWORD', '')),
                    'charset' => 'utf8',
                    'prefix' => '',
                    'prefix_indexes' => true,
                    'search_path' => 'public',
                    'sslmode' => 'prefer',
                ],
            ],
        ],
    ];
}

return [];