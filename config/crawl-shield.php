<?php

return [

    /*
    |--------------------------------------------------------------------------
    | URL parameter and password
    |--------------------------------------------------------------------------
    |
    | This is the password in the URL that is required to access your application.
    | The default values result in https://example.com/?pass=abc123, you can
    | change the query parameter and password if needed.
    |
    */

    'parameter' => env('CRAWL_SHIELD_PARAMETER', 'pass'),
    'password' => env('CRAWL_SHIELD_PASSWORD', 'abc123'),

    /*
    |--------------------------------------------------------------------------
    | Enabled status
    |--------------------------------------------------------------------------
    |
    | These values indicate whether the mechanism is enabled at all, and whether
    | it's enabled in a production environment.
    |
    */

    'enabled' => env('CRAWL_SHIELD_ENABLED', true),
    'enabled_in_production' => env('CRAWL_SHIELD_ENABLED_IN_PRODUCTION', false),
];
