<?php

namespace Framework;

class Auth
{
    private static $user = null;
    private static $sessionKey = 'auth_user';

    public static function attempt(array $credentials): bool
    {
        // This is a basic implementation - in real apps, you'd check against database
        $email = $credentials['email'] ?? '';
        $password = $credentials['password'] ?? '';

        // Example: Check against hardcoded user (replace with database lookup)
        if ($email === 'admin@example.com' && $password === 'password') {
            $user = [
                'id' => 1,
                'email' => 'admin@example.com',
                'name' => 'Administrator'
            ];
            
            self::login($user);
            return true;
        }

        return false;
    }

    public static function login(array $user): void
    {
        $_SESSION[self::$sessionKey] = $user;
        self::$user = $user;
    }

    public static function logout(): void
    {
        unset($_SESSION[self::$sessionKey]);
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
