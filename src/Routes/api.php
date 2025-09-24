<?php

use Framework\App;
use Framework\Middleware;
use App\Controllers\Api\AuthApiController;
use App\Controllers\Api\ReviewApiController;

return function(App $app) {
    // Authentication API routes
    $app->post('/api/auth/login', 'AuthApiController@login');
    $app->post('/api/auth/logout', 'AuthApiController@logout');
    $app->get('/api/auth/user', 'AuthApiController@user');
    $app->post('/api/auth/refresh', 'AuthApiController@refresh');
    
    // Review API routes
    $app->get('/api/products/{productId}/reviews', 'ReviewApiController@getProductReviews');
    $app->get('/api/products/{productId}/reviews/stats', 'ReviewApiController@getProductReviewStats');
    $app->post('/api/reviews', 'ReviewApiController@createReview', [Middleware::authApi()]);
    $app->put('/api/reviews/{reviewId}', 'ReviewApiController@updateReview', [Middleware::authApi()]);
    $app->delete('/api/reviews/{reviewId}', 'ReviewApiController@deleteReview', [Middleware::authApi()]);
    $app->post('/api/reviews/{reviewId}/helpful', 'ReviewApiController@markHelpful', [Middleware::authApi()]);
    $app->delete('/api/reviews/{reviewId}/helpful', 'ReviewApiController@removeHelpful', [Middleware::authApi()]);
    
    // Protected API routes (require authentication)
    $app->get('/api/user/profile', 'AuthApiController@user', [Middleware::authApi()]);
    $app->get('/api/user/orders', function($request) {
        return (new \Framework\Response())->json([
            'success' => true,
            'message' => 'User orders retrieved',
            'data' => ['orders' => []]
        ]);
    }, [Middleware::authApi()]);
};
