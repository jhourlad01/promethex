<?php

return [
    'name' => env('APP_NAME', 'Promethex Framework'),
    'debug' => env('APP_DEBUG', '0') === '1',
    'timezone' => 'UTC',
    'url' => env('APP_URL', 'http://localhost:8000'),
    
    'database' => [
        'driver' => env('DB_CONNECTION', 'sqlite'),
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', '3306'),
        'database' => env('DB_DATABASE', __DIR__ . '/../database/app.sqlite'),
        'username' => env('DB_USERNAME', ''),
        'password' => env('DB_PASSWORD', ''),
    ],
    
    'session' => [
        'lifetime' => env('SESSION_LIFETIME', 120),
        'secure' => env('SESSION_SECURE', false),
        'httponly' => true,
    ],
    
    'rate_limit' => [
        'max_requests' => 100,
        'window_minutes' => 1,
    ],
    
    'logging' => [
        'level' => env('LOG_LEVEL', 'info'),
        'file' => env('LOG_FILE', __DIR__ . '/../logs/app.log'),
    ],
    
    'cache' => [
        'driver' => env('CACHE_DRIVER', 'file'),
        'lifetime' => env('CACHE_LIFETIME', 3600),
    ],
    
    'mail' => [
        'driver' => env('MAIL_DRIVER', 'smtp'),
        'host' => env('MAIL_HOST', 'localhost'),
        'port' => env('MAIL_PORT', 587),
        'username' => env('MAIL_USERNAME', ''),
        'password' => env('MAIL_PASSWORD', ''),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        'from_address' => env('MAIL_FROM_ADDRESS', 'noreply@promethex.com'),
        'from_name' => env('MAIL_FROM_NAME', 'Promethex'),
    ],
];
