<?php
/**
 * Configuración de API: Credenciales
 */

 return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'), 
    'sandbox' => [
        'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
        'app_id'            => env('PAYPAL_SANDBOX_APP_ID', ''),
    ],
    'live' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'            => env('PAYPAL_LIVE_APP_ID', ''),
    ],

    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),  
    'currency'       => env('PAYPAL_CURRENCY', 'MXN'), //Pagos realizados en pesos mexicanos
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), 
    'locale'         => env('PAYPAL_LOCALE', 'en_US'), // Pagos realizados en inglés
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Credenciales SSL
];