<?php

use Framework\Response;

return function(\Framework\App $app) {
    // DataDog dashboard route (built-in framework feature)
    $app->get('/datadog', function($request) {
        $datadogEnabled = env('DATADOG_ENABLED', '0');
        $datadogApiKey = env('DD_API_KEY', '');
        
        if ($datadogEnabled === '1' && !empty($datadogApiKey)) {
            // Redirect to DataDog dashboard
            $datadogUrl = 'https://app.datadoghq.com/dashboard';
            return new Response('', 302, ['Location' => $datadogUrl]);
        } else {
            return new Response('<h1>DataDog Not Enabled</h1><p>DataDog monitoring is not configured or enabled.</p>', 404);
        }
    });
};
