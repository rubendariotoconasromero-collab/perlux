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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    // 'mercadopago' => [
    //     'access_token' => env('MP_ACCESS_TOKEN'),
    //     'public_key' => env('MP_PUBLIC_KEY'),
    // ],
    'mercadopago' => [
        'access_token' => env('MERCADO_PAGO_ACCESS_TOKEN'),
        'public_key' => env('MERCADO_PAGO_PUBLIC_KEY'),
        'environment' => env('MERCADO_PAGO_ENV', 'sandbox'), // sandbox o production
        'success_url' => env('MERCADO_PAGO_SUCCESS_URL', env('APP_URL') . '/pago-exitoso'),
        'failure_url' => env('MERCADO_PAGO_FAILURE_URL', env('APP_URL') . '/pago-fallido'),
        'pending_url' => env('MERCADO_PAGO_PENDING_URL', env('APP_URL') . '/pago-pendiente'),
        'webhook_url' => env('MERCADO_PAGO_WEBHOOK_URL', env('APP_URL') . '/mercadopago/webhook'),
    ],

];
