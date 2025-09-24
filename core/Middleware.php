<?php

namespace Framework;

class Middleware
{
    public static function cors(): callable
    {
        return function(Request $request, $next) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');

            if ($request->getMethod() === 'OPTIONS') {
                return new Response('', 200);
            }

            return $next($request);
        };
    }

    public static function json(): callable
    {
        return function(Request $request, $next) {
            header('Content-Type: application/json');
            return $next($request);
        };
    }

    public static function rateLimit(int $maxRequests = 100, int $windowMinutes = 1): callable
    {
        return function(Request $request, $next) use ($maxRequests, $windowMinutes) {
            $key = md5($request->getHeader('X-Forwarded-For') ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown');
            $file = sys_get_temp_dir() . "/rate_limit_{$key}.json";
            
            $data = [];
            if (file_exists($file)) {
                $data = json_decode(file_get_contents($file), true) ?: [];
            }

            $now = time();
            $window = $windowMinutes * 60;
            
            // Remove old requests outside the window
            $data = array_filter($data, function($timestamp) use ($now, $window) {
                return ($now - $timestamp) < $window;
            });

            if (count($data) >= $maxRequests) {
                return (new Response())->json(['message' => 'Too Many Requests'], 429);
            }

            // Add current request
            $data[] = $now;
            file_put_contents($file, json_encode($data));

            return $next($request);
        };
    }

    public static function auth(): callable
    {
        return function(Request $request, $next) {
            if (!Auth::check()) {
                return (new Response())->json(['message' => 'Unauthorized'], 401);
            }
            return $next($request);
        };
    }

    public static function guest(): callable
    {
        return function(Request $request, $next) {
            if (Auth::check()) {
                return (new Response())->json(['message' => 'Already authenticated'], 403);
            }
            return $next($request);
        };
    }
}
