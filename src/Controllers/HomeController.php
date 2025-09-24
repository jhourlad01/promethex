<?php

namespace App\Controllers;

use Framework\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('home', [
            'title' => 'Framework Test',
            'message' => 'MVC Controller is working!',
            'features' => app()->getEnabledFeatures()
        ], 'layout');
    }
}
