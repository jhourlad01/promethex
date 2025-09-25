<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Request;
use Framework\Response;
use Framework\View;
use Framework\Auth;
use App\Services\GraphQLClient;

class AuthController extends Controller
{
    private $graphqlClient;
    
    public function __construct(Request $request, array $params = [])
    {
        parent::__construct($request, $params);
        $this->graphqlClient = new GraphQLClient();
    }
    
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

        try {
            // Use GraphQL API for authentication
            $token = $this->graphqlClient->login($email, $password, $remember);
            
            if ($token) {
                // Store JWT token in session
                $_SESSION['jwt_token'] = $token;
                
                // Redirect to dashboard or home
                return $this->redirect('/');
            } else {
                throw new \Exception('Login failed');
            }
        } catch (\Exception $e) {
            return $this->view('auth/login', [
                'title' => 'Login - Promethex E-Commerce',
                'error' => 'Invalid email or password.'
            ], 'layout');
        }
    }

    public function logout(): Response
    {
        try {
            // Use GraphQL API for logout
            $this->graphqlClient->logout();
        } catch (\Exception $e) {
            // Continue with logout even if API call fails
        }
        
        // Clear session
        unset($_SESSION['jwt_token']);
        session_destroy();
        
        return $this->redirect('/');
    }
}
