<?php

return [
    // Core features (always enabled)
    'core' => [
        'router',
        'request',
        'response',
        'app'
    ],

    // Optional features (user can enable/disable)
    'optional' => [
        // Database
        'database' => true,
        'eloquent' => false,
        
        // Validation
        'validation' => true,
        'respect_validation' => false,
        
        // Logging
        'logging' => true,
        'monolog' => false,
        
        // Authentication
        'auth' => true,
        'jwt_auth' => false,
        
        // Caching
        'cache' => false,
        'symfony_cache' => false,
        
        // Templating
        'templates' => true,
        'twig' => false,
        
        // File handling
        'files' => false,
        'flysystem' => false,
        
        // Email
        'mail' => false,
        'phpmailer' => false,
        
        // API
        'api' => true,
        'fractal' => false,
        
        // Session
        'session' => true,
        
        // Middleware
        'middleware' => true,
        'cors' => false,
        'rate_limiting' => false,
    ],

    // Feature groups (convenience for enabling multiple features)
    'groups' => [
        'minimal' => ['database', 'validation', 'logging', 'auth'],
        'api' => ['database', 'validation', 'logging', 'auth', 'api', 'cors', 'rate_limiting'],
        'web' => ['database', 'validation', 'logging', 'auth', 'templates', 'session'],
        'full' => ['database', 'eloquent', 'validation', 'respect_validation', 'logging', 'monolog', 
                  'auth', 'jwt_auth', 'cache', 'symfony_cache', 'templates', 'twig', 
                  'files', 'flysystem', 'mail', 'phpmailer', 'api', 'fractal', 'session', 
                  'middleware', 'cors', 'rate_limiting']
    ]
];
