<?php

use Framework\{App, Response, Auth, Middleware};
use App\Controllers\HomeController;
use App\Controllers\AuthController;

return function(\Framework\App $app) {
    $homeController = new HomeController();
    $authController = new AuthController();
    
    // Public routes
    $app->get('/', [$homeController, 'index']);
    $app->get('/about', [$homeController, 'about']);
    
    // Authentication view routes (API handles the actual auth)
    $app->get('/login', [$authController, 'showLogin']);
    
    // Protected web routes (require authentication)
    $app->get('/dashboard', [$homeController, 'dashboard'], [Middleware::authWeb()]);
    $app->get('/profile', [$homeController, 'profile'], [Middleware::authWeb()]);
    $app->get('/account', [$homeController, 'account'], [Middleware::authWeb()]);
};
