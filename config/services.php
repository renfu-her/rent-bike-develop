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

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // 綠界金流設定
    'ecpay' => [
        'merchant_id' => env('ECPAY_MERCHANT_ID', '2000132'), // 測試環境特店編號
        'hash_key' => env('ECPAY_HASH_KEY', '5294y06JbISpM5x9'), // 測試環境 HashKey
        'hash_iv' => env('ECPAY_HASH_IV', 'v77hoKGq4kWxNNIS'), // 測試環境 HashIV
        'payment_url' => env('ECPAY_PAYMENT_URL', 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5'), // 測試環境付款網址
        'query_url' => env('ECPAY_QUERY_URL', 'https://payment-stage.ecpay.com.tw/Cashier/QueryTradeInfo/V5'), // 測試環境查詢網址
    ],

];
