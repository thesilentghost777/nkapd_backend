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
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
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

    'moneyfusion' => [
        'payin_url' => env('MONEYFUSION_PAYIN_URL'),
        'payout_url' => env('MONEYFUSION_PAYOUT_URL'),
        'payout_api_key' => env('MONEYFUSION_PAYOUT_API_KEY'),
        'status_url' => env('MONEYFUSION_STATUS_URL'),
        'return_url' => env('MONEYFUSION_RETURN_URL'),
        'webhook_url' => env('MONEYFUSION_WEBHOOK_URL'),
        'payout_webhook_url' => env('MONEYFUSION_PAYOUT_WEBHOOK_URL'),
    ],

];
