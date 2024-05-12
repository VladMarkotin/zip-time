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
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => env('FACEBOOK_URL'),
    ],

    'gpt' => [
        'openai_secret'       => env('GPT_OPENAI_SECRET'),
        'openai_model'        => env('GPT_OPENAI_MODEL'),
        'openai_tokens'       => env('GPT_OPENAI_TOKENS'),
        'openai_temperature'  => env('GPT_OPENAI_TEMPERATURE'),
    ],

    'device_token' => [
        'device_private_key'       => env('DEVICE_PRIVATE_KEY'),
        'device_public_key'        => env('DEVICE_PUBLIC_KEY'),
   
    ],
];
