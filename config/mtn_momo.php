<?php

return [
    'base_url' => env('MTN_MOMO_BASE_URL', 'https://sandbox.momodeveloper.mtn.com'),
    'api_user' => env('MTN_MOMO_API_USER'),
    'api_key' => env('MTN_MOMO_API_KEY'),
    'subscription_key' => env('MTN_MOMO_SUBSCRIPTION_KEY'),
    'account_id' => env('MTN_MOMO_ACCOUNT_ID'),
    'environment' => env('MTN_MOMO_ENVIRONMENT', 'sandbox'),
    'currency' => env('MTN_MOMO_CURRENCY', 'EUR'),
];
