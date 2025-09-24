<?php

namespace App\Controllers;

use Framework\Request;
use Framework\Response;
use Framework\View;
use Framework\Auth;
use Illuminate\Database\Capsule\Manager as Capsule;

class AuthController
{
    public function showLogin(Request $request): Response
    {
        return View::render('auth/login', [
            'title' => 'Login - Promethex E-Commerce'
        ], 'layout');
    }

    public function login(Request $request): Response
    {
        $email = $request->getInput('email');
        $password = $request->getInput('password');
        $remember = $request->getInput('remember') === 'on';

        // Validate input
        if (empty($email) || empty($password)) {
            return View::render('auth/login', [
                'title' => 'Login - Promethex E-Commerce',
                'error' => 'Email and password are required.'
            ], 'layout');
        }

        // Find user by email
        $user = Capsule::table('users')
            ->where('email', $email)
            ->where('is_active', true)
            ->first();

        if (!$user || !password_verify($password, $user->password)) {
            return View::render('auth/login', [
                'title' => 'Login - Promethex E-Commerce',
                'error' => 'Invalid email or password.'
            ], 'layout');
        }

        // Login successful - set session
        Auth::login($user, $remember);

        // Redirect to dashboard or home
        return (new Response())->redirect('/');
    }

    public function logout(Request $request): Response
    {
        Auth::logout();
        return (new Response())->redirect('/');
    }
}
