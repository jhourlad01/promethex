<?php

namespace App\Controllers;

use Framework\Request;
use Framework\Response;
use Framework\View;

class HomeController
{
    public function index(Request $request): Response
    {
        return View::render('home', [
            'title' => 'Promethex E-Commerce',
            'message' => 'Welcome to our e-commerce platform!',
            'features' => [
                'Modern Design',
                'Secure Shopping',
                'Fast Checkout',
                '24/7 Support'
            ]
        ], 'layout');
    }

    public function about(Request $request): Response
    {
        return View::render('about', [
            'title' => 'About Us - Promethex E-Commerce',
            'content' => 'This is a modern e-commerce platform built with a custom PHP framework.'
        ], 'layout');
    }

    public function dashboard(Request $request): Response
    {
        return View::render('dashboard', [
            'title' => 'Dashboard - Promethex E-Commerce',
            'user' => \Framework\Auth::user()
        ], 'layout');
    }

    public function profile(Request $request): Response
    {
        return View::render('profile', [
            'title' => 'Profile - Promethex E-Commerce',
            'user' => \Framework\Auth::user()
        ], 'layout');
    }

    public function account(Request $request): Response
    {
        return View::render('account', [
            'title' => 'Account Settings - Promethex E-Commerce',
            'user' => \Framework\Auth::user()
        ], 'layout');
    }
}
