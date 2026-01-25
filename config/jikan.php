<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Jikan API Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for the Jikan API service.
    | Jikan is an unofficial MyAnimeList API.
    |
    */

    'base_url' => env('JIKAN_API_BASE_URL', 'https://api.jikan.moe/v4'),

    /*
    |--------------------------------------------------------------------------
    | API Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configure rate limiting for API requests to avoid exceeding limits.
    |
    */
    'rate_limiting' => [
        'enabled' => true,
        'requests_per_minute' => 60, // Jikan API allows 60 requests per minute
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | Configure caching for API responses to reduce API calls.
    |
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 3600, // Cache for 1 hour
    ],
];