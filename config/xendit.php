<?php

return [
    'secret_key' => env('XENDIT_SECRET_KEY'),
    'public_key' => env('XENDIT_PUBLIC_KEY'),
    'webhook_verification_token' => env('XENDIT_WEBHOOK_TOKEN'),
    'base_url' => env('XENDIT_BASE_URL', 'https://api.xendit.co'),
    'is_production' => env('XENDIT_IS_PRODUCTION', false),
    
    // Supported payment methods
    'payment_methods' => [
        'credit_card' => true,
        'bank_transfer' => true,
        'ewallet' => true,
        'retail_outlet' => true,
        'qr_code' => true,
    ],
    
    // Bank transfer channels
    'bank_channels' => [
        'BCA',
        'BNI',
        'BRI',
        'MANDIRI',
        'PERMATA',
        'BSI',
        'SAHABAT_SAMPOERNA',
    ],
    
    // E-wallet channels
    'ewallet_channels' => [
        'OVO',
        'DANA',
        'LINKAJA',
        'SHOPEEPAY',
        'JENIUSPAY',
        'ASTRAPAY',
    ],
    
    // Retail outlets
    'retail_outlets' => [
        'ALFAMART',
        'INDOMARET',
    ],
];
