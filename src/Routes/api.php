<?php

use Framework\App;
use Framework\Middleware;
use App\Controllers\Api\AuthApiController;

return function(App $app) {
    $authApiController = new AuthApiController();
    
    // Authentication API routes
    $app->post('/api/auth/login', [$authApiController, 'login']);
    $app->post('/api/auth/logout', [$authApiController, 'logout']);
    $app->get('/api/auth/user', [$authApiController, 'user']);
    $app->post('/api/auth/refresh', [$authApiController, 'refresh']);
    
    // Protected API routes (require authentication)
    $app->get('/api/user/profile', [$authApiController, 'user'], [Middleware::authApi()]);
    $app->get('/api/user/orders', function($request) {
        return (new \Framework\Response())->json([
            'success' => true,
            'message' => 'User orders retrieved',
            'data' => ['orders' => []]
        ]);
    }, [Middleware::authApi()]);
};
