<?php

require_once 'vendor/autoload.php';
require_once 'core/helpers.php';

use Framework\{App, Config, FeatureManager, Env};

// Load environment variables
Env::load('.env');

// Load configuration
Config::load(require 'config/app.php');

// Load layout configuration
$layoutConfig = require 'config/layouts.php';
\Framework\View::setDefaultLayout($layoutConfig['default']);
\Framework\View::setLayoutMap($layoutConfig['mappings']);

// Configure DataDog monitoring
\Framework\DataDog::configure();


// Load feature configuration
$features = require 'config/features.php';

// Create logs directory if it doesn't exist
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}

$app = new App();

// Configure features based on user preferences
$enabledFeatures = [];
foreach ($features['optional'] as $feature => $enabled) {
    if ($enabled) {
        $enabledFeatures[] = $feature;
    }
}

$app->configure(['features' => $enabledFeatures]);

// Configure logging with environment variables
if ($app->hasFeature('logging')) {
    \Framework\Logger::configure(
        config('logging.file'),
        config('logging.level')
    );
}

// Configure database with environment variables
if ($app->hasFeature('database')) {
    \Framework\Database::configure(config('database'));
}

// Load custom middleware from src/middleware/ (if middleware feature is enabled)
if ($app->hasFeature('middleware')) {
    \Framework\MiddlewareRegistry::loadFromDirectory(__DIR__ . '/src/middleware/');
}

// Load all route files from src/routes/
$app->loadRoutes();

$app->run();