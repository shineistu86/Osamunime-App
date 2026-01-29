<?php

// testing-specific configuration
return [
    'cache' => [
        'default' => 'array',
    ],
    'database' => [
        'default' => 'sqlite',
        'connections' => [
            'sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ],
    ],
];