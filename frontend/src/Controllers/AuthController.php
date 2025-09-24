<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Request;
use Framework\Response;
use Framework\View;
use Framework\Auth;
use Illuminate\Database\Capsule\Manager as Capsule;

class AuthController extends Controller
{
    public function showLogin(): Response
    {
        return $this->view('auth/login', [
            'title' => 'Login - Promethex E-Commerce'
        ], 'layout');
    }

    public function login(): Response
    {
        $email = $this->request->getInput('email');
        $password = $this->request->getInput('password');
        $remember = $this->request->getInput('remember') === 'on';

        // Validate input
        if (empty($email) || empty($password)) {
            return $this->view('auth/login', [
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
            return $this->view('auth/login', [
                'title' => 'Login - Promethex E-Commerce',
                'error' => 'Invalid email or password.'
            ], 'layout');
        }

        // Login successful - set session
        Auth::login($user, $remember);

        // Redirect to dashboard or home
        return $this->redirect('/');
    }

    public function logout(): Response
    {
        Auth::logout();
        return $this->redirect('/');
    }
}
