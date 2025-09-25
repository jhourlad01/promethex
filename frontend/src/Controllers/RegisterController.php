<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Request;
use Framework\Response;
use App\Services\GraphQLClient;

class RegisterController extends Controller
{
    private GraphQLClient $graphqlClient;

    public function __construct(Request $request, array $params = [])
    {
        parent::__construct($request, $params);
        $this->graphqlClient = new GraphQLClient();
    }

    public function show(): Response
    {
        // If user is already logged in, redirect to home
        if (isset($_SESSION['user'])) {
            return $this->redirect('/');
        }

        return $this->view('auth/register', [
            'title' => 'Create Account',
            'header_title' => 'Create Account',
            'header_subtitle' => 'Join Promethex today',
            'header_icon' => 'fas fa-user-plus'
        ], 'clean');
    }

    public function register(): Response
    {
        // If user is already logged in, redirect to home
        if (isset($_SESSION['user'])) {
            return $this->redirect('/');
        }

        $name = trim($this->request->getInput('name'));
        $email = trim($this->request->getInput('email'));
        $password = $this->request->getInput('password');
        $passwordConfirm = $this->request->getInput('password_confirm');

        // Validation
        $errors = $this->validateRegistration($name, $email, $password, $passwordConfirm);

        if (!empty($errors)) {
            return $this->view('auth/register', [
                'title' => 'Create Account',
                'header_title' => 'Create Account',
                'header_subtitle' => 'Join Promethex today',
                'header_icon' => 'fas fa-user-plus',
                'errors' => $errors,
                'old' => [
                    'name' => $name,
                    'email' => $email
                ]
            ], 'clean');
        }

        try {
            $result = $this->graphqlClient->register($name, $email, $password);

            if ($result && isset($result['user']) && isset($result['message'])) {
                // Show verification message instead of auto-login
                return $this->view('auth/verify-email', [
                    'title' => 'Check Your Email',
                    'header_title' => 'Verify Your Email',
                    'header_subtitle' => 'Account created successfully!',
                    'header_icon' => 'fas fa-envelope-open-text',
                    'email' => $email,
                    'message' => $result['message']
                ], 'clean');
            } else {
                throw new \Exception('Registration failed');
            }

        } catch (\Exception $e) {
            $errors = ['general' => $e->getMessage()];
            
            return $this->view('auth/register', [
                'title' => 'Create Account',
                'header_title' => 'Create Account',
                'header_subtitle' => 'Join Promethex today',
                'header_icon' => 'fas fa-user-plus',
                'errors' => $errors,
                'old' => [
                    'name' => $name,
                    'email' => $email
                ]
            ], 'clean');
        }
    }

    private function validateRegistration(string $name, string $email, string $password, string $passwordConfirm): array
    {
        $errors = [];

        // Name validation
        if (empty($name)) {
            $errors['name'] = 'Name is required';
        } elseif (strlen($name) < 2) {
            $errors['name'] = 'Name must be at least 2 characters';
        } elseif (strlen($name) > 50) {
            $errors['name'] = 'Name must not exceed 50 characters';
        }

        // Email validation
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address';
        }

        // Password validation
        if (empty($password)) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($password) < 8) {
            $errors['password'] = 'Password must be at least 8 characters';
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $password)) {
            $errors['password'] = 'Password must contain at least one uppercase letter, one lowercase letter, and one number';
        }

        // Password confirmation validation
        if (empty($passwordConfirm)) {
            $errors['password_confirm'] = 'Please confirm your password';
        } elseif ($password !== $passwordConfirm) {
            $errors['password_confirm'] = 'Passwords do not match';
        }

        return $errors;
    }
}
