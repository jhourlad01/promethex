<?php

namespace App\Controllers;

use Framework\Controller;
use Framework\Request;
use Framework\Response;
use Framework\View;
use Framework\Auth;
use Framework\Validator;
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
        return $this->view('auth/index', [
            'title' => 'Login - Promethex E-Commerce'
        ], 'layout');
    }

    public function login(): Response
    {
        $email = $this->request->getInput('email');
        $password = $this->request->getInput('password');
        $remember = $this->request->getInput('remember') === 'on';

        // Validate input using Framework\Validator
        $validator = Validator::make([
            'email' => $email,
            'password' => $password
        ], [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.'
        ]);

        if ($validator->fails()) {
            return $this->view('auth/index', [
                'title' => 'Login - Promethex E-Commerce',
                'error' => $validator->getFirstError('email') ?? $validator->getFirstError('password')
            ], 'layout');
        }

        try {
            // Use GraphQL API for authentication
            $token = $this->graphqlClient->login($email, $password, $remember);
            
            if ($token) {
                // Store JWT token in session
                $_SESSION['jwt_token'] = $token;
                
                // Decode JWT token to get user info and login via Framework\Auth
                $userData = $this->decodeJWTToken($token);
                if ($userData) {
                    Auth::login($userData, $remember);
                }
                
                // Redirect to dashboard or home
                return $this->redirect('/');
            } else {
                throw new \Exception('Login failed');
            }
        } catch (\Exception $e) {
            return $this->view('auth/index', [
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
        
        // Use Framework\Auth for logout
        Auth::logout();
        
        return $this->redirect('/');
    }
    
    /**
     * Simple JWT token decoder (without external dependencies)
     */
    private function decodeJWTToken(string $token): ?array
    {
        try {
            // Split the token
            $parts = explode('.', $token);
            if (count($parts) !== 3) {
                return null;
            }
            
            // Decode the payload (middle part)
            $payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1]));
            $data = json_decode($payload, true);
            
            if (!$data) {
                return null;
            }
            
            return [
                'id' => $data['id'] ?? null,
                'name' => $data['name'] ?? null,
                'email' => $data['email'] ?? null
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
