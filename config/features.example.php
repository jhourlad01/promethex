<?php

// Example feature configuration
// Copy this file to features.php and customize

return [
    // Core features (always enabled - cannot be disabled)
    'core' => [
        'router',
        'request', 
        'response',
        'app'
    ],

    // Optional features (user can enable/disable)
    'optional' => [
        // Database features
        'database' => true,        // Basic database functionality
        'eloquent' => false,       // Eloquent ORM (requires database)
        
        // Validation features  
        'validation' => true,      // Basic validation
        'respect_validation' => false, // Respect\Validation library
        
        // Logging features
        'logging' => true,         // Basic logging
        'monolog' => false,        // Monolog library (requires logging)
        
        // Authentication features
        'auth' => true,            // Basic authentication
        'jwt_auth' => false,       // JWT authentication (requires auth)
        
        // Caching features
        'cache' => false,          // Basic caching
        'symfony_cache' => false,  // Symfony cache (requires cache)
        
        // Templating features
        'templates' => false,      // Basic templating
        'twig' => false,           // Twig template engine (requires templates)
        
        // File handling features
        'files' => false,          // Basic file handling
        'flysystem' => false,      // Flysystem (requires files)
        
        // Email features
        'mail' => false,           // Basic email
        'phpmailer' => false,      // PHPMailer (requires mail)
        
        // API features
        'api' => true,             // Basic API responses
        'fractal' => false,        // Fractal API transformer (requires api)
        
        // Session features
        'session' => true,         // Session handling
        
        // Middleware features
        'middleware' => true,      // Basic middleware
        'cors' => false,           // CORS middleware (requires middleware)
        'rate_limiting' => false,  // Rate limiting (requires middleware)
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
