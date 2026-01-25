<?php

// config/sqlite_persistent.php
// Configuration for persistent SQLite in Railway (not recommended, but possible)

return [
    'persistent' => [
        'driver' => 'sqlite',
        'database' => env('DB_DATABASE', '/tmp/database.sqlite'), // Use /tmp for Railway
        'prefix' => '',
        'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
    ],
];