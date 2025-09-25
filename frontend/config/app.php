<?php

return [
    'app' => [
        'name' => 'Promethex E-Commerce',
        'url' => 'http://localhost:8000',
        'debug' => true,
    ],
    
    'api' => [
        'url' => 'http://localhost:4000',
        'timeout' => 30,
    ],
    
    'auth' => [
        'jwt_secret' => 'your-secret-key',
        'remember_days' => 30,
        'session_lifetime' => 24,
    ],
    
    'database' => [
        'default' => 'mysql',
        'connections' => [
            'mysql' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'port' => '3306',
                'database' => 'promethex',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ]
        ]
    ],
    
    'logging' => [
        'level' => 'debug',
        'path' => 'logs/',
        'max_files' => 5,
    ],
    
    'features' => [
        'database' => true,
        'logging' => true,
        'datadog' => false,
    ]
];