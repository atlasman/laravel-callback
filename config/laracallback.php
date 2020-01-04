<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel callback config
    |--------------------------------------------------------------------------
    |
    */

    'path' => env('LARACB_PATH', '/callback/{type}/{subtype?}'),

    'provider' => [

        'prefix' => env('LARACB_PROVIDER_PREFIX', 'callback'),

        'separator' => env('LARACB_PROVIDER_SEPARATOR', '.')

    ]
];