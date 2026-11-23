<?php

return [
    'api_key' => env('PAYMOB_API_KEY'),
    'secret_key' => env('PAYMOB_SECRET_KEY'),
    'public_key' => env('PAYMOB_PUBLIC_KEY'),
    'integration_id' => env('PAYMOB_INTEGRATION_ID'),
    'hmac_secret' => env('PAYMOB_HMAC_SECRET'),
    'base_url' => env('PAYMOB_BASE_URL', 'https://accept.paymob.com'),
    'hmac_secret' => env('PAYMOB_HMAC_SECRET'),
];
