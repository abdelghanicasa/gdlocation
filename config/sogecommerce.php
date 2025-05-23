<?php

return [
    'merchant_id' => env('SOGECOMMERCE_MERCHANT_ID'),
    'test_password' => env('SOGECOMMERCE_TEST_PASSWORD'),
    'public_key_test' => env('SOGECOMMERCE_PUBLIC_KEY_TEST'),
    'hmac_key_test' => env('SOGECOMMERCE_HMAC_KEY_TEST'),
    'public_key_prod' => env('SOGECOMMERCE_PUBLIC_KEY_PROD'),
    'hmac_key_prod' => env('SOGECOMMERCE_HMAC_KEY_PROD'),
    'api_url' => env('SOGECOMMERCE_API_URL'),
    'js_url' => env('SOGECOMMERCE_JS_URL'),
    'environment' => env('SOGECOMMERCE_ENVIRONMENT', 'TEST'),
    
    'urls' => [
        'test' => 'https://sogecommerce.societegenerale.eu/webpayment/',
        'production' => 'https://sogecommerce.societegenerale.eu/webpayment/'
    ],
];