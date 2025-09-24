<?php

use Framework\{App, Response, Auth, Middleware};
use App\Controllers\HomeController;

return function(\Framework\App $app) {
    $homeController = new HomeController();
    
    $app->get('/', [$homeController, 'index']);
    $app->get('/about', [$homeController, 'about']);
};
