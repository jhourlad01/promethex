<?php

namespace App\Controllers\Api;

use Framework\Request;
use Framework\Response;
use Framework\Auth;
use Illuminate\Database\Capsule\Manager as Capsule;

class AuthApiController extends BaseApiController
{
    /**
     * Login user via API
     */
    public function login(Request $request): Response
    {
        // Only accept JSON data
        $data = $request->getJson();
        
        if ($data === null) {
            return $this->error('Invalid JSON data or Content-Type must be application/json', 400);
        }
        
        // Validate required fields
        $errors = $this->validateRequired($data, ['email', 'password']);
        if ($errors) {
            return $this->validationError($errors);
        }

        $email = $data['email'];
        $password = $data['password'];
        $remember = $data['remember'] ?? false;

        // Find user by email
        $user = Capsule::table('users')
            ->where('email', $email)
            ->where('is_active', true)
            ->first();

        if (!$user || !password_verify($password, $user->password)) {
            return $this->error('Invalid email or password.', 401);
        }

        // Login successful
        Auth::login($user, $remember);

        return $this->success([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]
        ], 'Login successful');
    }

    /**
     * Logout user via API
     */
    public function logout(Request $request): Response
    {
        Auth::logout();
        return $this->success([], 'Logout successful');
    }

    /**
     * Get current authenticated user
     */
    public function user(Request $request): Response
    {
        if (!Auth::check()) {
            return $this->unauthorized('Not authenticated');
        }

        $user = Auth::user();
        return $this->success([
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ]
        ]);
    }

    /**
     * Refresh authentication token/session
     */
    public function refresh(Request $request): Response
    {
        if (!Auth::check()) {
            return $this->unauthorized('Not authenticated');
        }

        // For now, just return current user data
        // In a real app, you might refresh tokens here
        $user = Auth::user();
        return $this->success([
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ]
        ], 'Token refreshed');
    }
}
