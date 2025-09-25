<?php

namespace Framework;

// Removed Firebase JWT dependency - using simple session storage

class Auth
{
    private static $user = null;
    private static $sessionKey = 'auth_user';

    public static function attempt(array $credentials): bool
    {
        $email = $credentials['email'] ?? '';
        $password = $credentials['password'] ?? '';

        if (empty($email) || empty($password)) {
            return false;
        }

        // Find user by email in database
        $user = \Illuminate\Database\Capsule\Manager::table('users')
            ->where('email', $email)
            ->where('is_active', true)
            ->first();

        if (!$user || !password_verify($password, $user->password)) {
            return false;
        }

        // Convert to array and login
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
            'phone' => $user->phone,
            'address' => $user->address,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];

        self::login($userData);
        return true;
    }

    public static function login($user, bool $remember = false): void
    {
        // Convert object to array if needed
        if (is_object($user)) {
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'is_active' => $user->is_active,
                'phone' => $user->phone,
                'address' => $user->address,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ];
        } else {
            $userData = $user;
        }
        
        $_SESSION[self::$sessionKey] = $userData;
        self::$user = $userData;
        
        // Handle remember me functionality
        if ($remember) {
            // Store remember me flag in session
            $_SESSION['remember_me'] = true;
            // In a real app, you'd implement remember tokens here
            // For now, we'll just store the flag
        }
    }

    public static function logout(): void
    {
        unset($_SESSION[self::$sessionKey]);
        unset($_SESSION['jwt_token']);
        unset($_SESSION['remember_me']);
        self::$user = null;
    }

    public static function user(): ?array
    {
        if (self::$user === null && isset($_SESSION[self::$sessionKey])) {
            self::$user = $_SESSION[self::$sessionKey];
        }
        return self::$user;
    }

    public static function id(): ?int
    {
        return self::user()['id'] ?? null;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function guest(): bool
    {
        return !self::check();
    }

    public static function middleware(): callable
    {
        return function(Request $request, $next) {
            if (!self::check()) {
                return (new Response())->json(['message' => 'Unauthorized'], 401);
            }
            return $next($request);
        };
    }
}
