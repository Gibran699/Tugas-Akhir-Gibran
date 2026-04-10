<?php

return [
    'base_url' => env('EXTERNAL_API_URL'),
    'credentials' => [
        'email' => env('EXTERNAL_API_EMAIL'),
        'password' => env('EXTERNAL_API_PASSWORD'),
    ],
    'token_key' => env('EXTERNAL_API_TOKEN_KEY'),

    'ktp_api' => [
        'base_uri' => env('KTP_API_URL', 'http://ektp.samarindakota.go.id/'),
        'username' => env('KTP_API_USERNAME'),
        'password' => env('KTP_API_PASSWORD')
    ],
];
