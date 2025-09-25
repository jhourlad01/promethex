<?php

use Framework\{App, Response, Auth, Middleware, Logger};

return function(\Framework\App $app) {
    // Debug: Log that routes are being loaded
    Logger::info("Loading web routes...");
    
    // Public routes
    $app->get('/', 'HomeController@index');
    $app->get('/product/{slug}', 'ProductController@show');
    $app->get('/category/{slug}', 'CategoryController@show');
    $app->get('/categories', 'CategoryController@index');
    
    // Cart routes
    $app->get('/cart', 'CartController@index');
    $app->post('/cart/add', 'CartController@add');
    $app->post('/cart/update', 'CartController@update');
    $app->post('/cart/remove', 'CartController@remove');
    $app->post('/cart/clear', 'CartController@clear');
    $app->get('/cart/summary', 'CartController@summary');
    
    // Authentication routes
    $app->get('/login', 'AuthController@showLogin');
    $app->post('/login', 'AuthController@login');
    $app->post('/logout', 'AuthController@logout');
    
    // Protected web routes (require authentication)
    $app->get('/dashboard', 'HomeController@dashboard', [Middleware::authWeb()]);
    $app->get('/profile', 'HomeController@profile', [Middleware::authWeb()]);
    $app->get('/account', 'HomeController@account', [Middleware::authWeb()]);
    
    Logger::info("Web routes loaded successfully");
};
