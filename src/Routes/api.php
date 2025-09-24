<?php

use Framework\App;
use App\Controllers\Api\AuthApiController;

return function(App $app) {
    $authApiController = new AuthApiController();
    
    // Authentication API routes
    $app->post('/api/auth/login', [$authApiController, 'login']);
    $app->post('/api/auth/logout', [$authApiController, 'logout']);
    $app->get('/api/auth/user', [$authApiController, 'user']);
    $app->post('/api/auth/refresh', [$authApiController, 'refresh']);
};
