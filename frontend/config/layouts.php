<?php

return [
    // Default layout for all views
    'default' => 'layout',
    
    // Specific layout mappings for templates
    'mappings' => [
        // Admin area uses admin layout
        'admin/dashboard' => 'admin-layout',
        'admin/users' => 'admin-layout',
        'admin/products' => 'admin-layout',
        
        // API responses don't use layouts
        'api/response' => null,
        'api/error' => null,
        
        // Auth pages use auth layout
        'auth/login' => 'auth-layout',
        'auth/register' => 'auth-layout',
        
        // Email templates use email layout
        'emails/welcome' => 'email-layout',
        'emails/notification' => 'email-layout',
        
        // Print-friendly layouts
        'reports/invoice' => 'print-layout',
        'reports/receipt' => 'print-layout',
    ]
];
