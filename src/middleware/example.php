<?php

use Framework\Request;
use Framework\Response;

// Example middleware file - register custom middleware here

return [
    'custom_auth' => function(Request $request, $next) {
        // Custom authentication logic
        if (!isset($_SESSION['custom_user'])) {
            return (new Response())->json(['message' => 'Custom auth required'], 401);
        }
        return $next($request);
    },

    'admin_only' => function(Request $request, $next) {
        // Admin-only middleware
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            return (new Response())->json(['message' => 'Admin access required'], 403);
        }
        return $next($request);
    },

    'api_key' => function(Request $request, $next) {
        // API key validation
        $apiKey = $request->getHeader('X-API-Key');
        if (!$apiKey || $apiKey !== 'your-secret-api-key') {
            return (new Response())->json(['message' => 'Valid API key required'], 401);
        }
        return $next($request);
    }
];
