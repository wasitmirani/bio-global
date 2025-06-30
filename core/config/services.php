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

    'persantage-range' => [
        '0-39' => 0,
        '40-199' => 6,
        '200-999' => 9,
        '1000-3999' => 12,
        '4000-9999' => 15,
        '10000-19999' => 18,
        '20000-29999' => 21,
        '30000-10000000' => 24
    ],


    'leader_reward_amount' => 630,
    'last_reward' => 24,

    'reward-level' => [
        0 => [
            'name' => 'N/A',
            'amount' => 0,
            'pv' => 0,
            'rank_reward' => 0,
            'car_reward' => 0,
        ],
        2 => [
            'name' => 'Director',
            'amount' => 630,
            'pv' => 300000,
            'rank_reward' => '$900',
            'car_reward' => '$900',
        ],
        4 => [
            'name' => 'Gold Director',
            'amount' => 3520,
            'pv' => 600000,
            'rank_reward' => '$2,880',
            'car_reward' => '$2,880',
        ],
        8 => [
            'name' => 'Diamond Director',
            'amount' => 4160,
            'pv' => 900000,
            'rank_reward' => '$5,040',
            'car_reward' => '$5,040',
        ],
    ],

];
