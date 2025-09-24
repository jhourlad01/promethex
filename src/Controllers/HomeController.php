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

    public function dashboard()
    {
        return $this->view('dashboard', [
            'title' => 'Dashboard - Promethex E-Commerce'
        ], 'layout');
    }

    public function profile()
    {
        return $this->view('profile', [
            'title' => 'Profile - Promethex E-Commerce'
        ], 'layout');
    }

    public function account()
    {
        return $this->view('account', [
            'title' => 'Account - Promethex E-Commerce'
        ], 'layout');
    }
}
