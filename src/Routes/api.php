<?php

use Framework\{App, Response, Validator, Logger};

return function(App $app) {
    // Simple API test routes
    $app->get('/api/status', function($request) {
        return (new Response())->json([
            'status' => 'ok',
            'framework' => 'Promethex',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    });

    // Test validation (if validation feature is enabled)
    if ($app->hasFeature('validation')) {
        $app->post('/api/test-validation', function($request) {
            $data = $request->getJson();
            
            $validator = Validator::make($data, [
                'name' => 'required|string',
                'email' => 'required|email'
            ]);
            
            if ($validator->fails()) {
                return (new Response())->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return (new Response())->json([
                'success' => true,
                'message' => 'Validation passed',
                'data' => $data
            ]);
        });
    }

    // Test logging (if logging feature is enabled)
    if ($app->hasFeature('logging')) {
        $app->post('/api/test-logging', function($request) {
            Logger::info('API test logging', ['endpoint' => '/api/test-logging']);
            return (new Response())->json(['message' => 'Log entry created']);
        });
    }
};
