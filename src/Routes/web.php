<?php

use Framework\{App, Response, Auth, Middleware};

return function(\Framework\App $app) {
    // Public routes
    $app->get('/', 'HomeController@index');
    $app->get('/product/{slug}', 'ProductController@show');
    $app->get('/category/{slug}', 'CategoryController@show');
    $app->get('/categories', 'CategoryController@index');
    
    // GraphQL routes
    $app->post('/graphql', 'GraphQLController@query');
    $app->get('/graphql-playground', 'GraphQLController@playground');
    
    // Authentication view routes (API handles the actual auth)
    $app->get('/login', 'AuthController@showLogin');
    
    // Protected web routes (require authentication)
    $app->get('/dashboard', 'HomeController@dashboard', [Middleware::authWeb()]);
    $app->get('/profile', 'HomeController@profile', [Middleware::authWeb()]);
    $app->get('/account', 'HomeController@account', [Middleware::authWeb()]);
};
