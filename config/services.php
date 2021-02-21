<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'facebook' => [
        'client_id' => '542413709982825',
        'client_secret' => '704af9cc9237235b1e297635e952ddad',
        'redirect' => 'https://www.localhost/projects/laravel-socialite/public/login/facebook/callback',
    ],

    'twitter' => [
        'client_id' => env('TWITTER_ID'),
        'client_secret' => env('TWITTER_SECRET_KEY'),
        'redirect' => 'https://www.localhost/projects/laravel-socialite/public/login/twitter/callback',
    ],
];
