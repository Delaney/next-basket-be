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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'rabbitmq' => [
        'host' => env('MQ_HOST'),
        'port' => env('MQ_PORT'),
        'user' => env('MQ_USER'),
        'password' => env('MQ_PASSWORD'),
        'vhost' => env('MQ_VHOST'),
        'queue' => env('MQ_QUEUE', ''),
        'exchange' => env('MQ_EXCHANGE', ''),
        'key' => env('MQ_KEY', ''),
        'log' => env('MQ_LOG_DRIVER', ''),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
