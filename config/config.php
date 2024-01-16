<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'database' => [
        'connection' => env('DB_AMAZON_SP_API_CLIENT_CONNECTION'),
    ],
    'app' => [
        'id' => env('AMAZON_SP_API_CLIENT_APP_ID', 'eoLabs Amazon SP-API Client'),
        'version' => env('AMAZON_SP_API_CLIENT_APP_VERSION', '1.0.0'),
    ]
];
