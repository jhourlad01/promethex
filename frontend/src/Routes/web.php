<?php

use Framework\{App, Response, Auth, Middleware};

return function(\Framework\App $app) {
    // Debug: Log that routes are being loaded
    error_log("Loading web routes...");
    
    // Public routes
    $app->get('/', 'HomeController@index');
    $app->get('/product/{slug}', 'ProductController@show');
    $app->get('/category/{slug}', 'CategoryController@show');
    $app->get('/categories', 'CategoryController@index');
    
    // Authentication view routes (API handles the actual auth)
    $app->get('/login', 'AuthController@showLogin');
    
    // Protected web routes (require authentication)
    $app->get('/dashboard', 'HomeController@dashboard', [Middleware::authWeb()]);
    $app->get('/profile', 'HomeController@profile', [Middleware::authWeb()]);
    $app->get('/account', 'HomeController@account', [Middleware::authWeb()]);
    
    error_log("Web routes loaded successfully");
};
