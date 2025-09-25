<?php

namespace Framework;

use Framework\Logger;
use Framework\Config;

class App
{
    private static ?App $instance = null;
    private Router $router;
    private RouteLoader $routeLoader;
    private array $features = [];
    private string $viewPath = 'src/views/';
    private string $controllerPath = 'src/controllers/';

    public function __construct()
    {
        // Load configuration
        $this->loadConfig();
        
        $this->router = new Router();
        $this->routeLoader = new RouteLoader($this, __DIR__ . '/../src/Routes/');
        self::$instance = $this;
    }
    
    private function loadConfig(): void
    {
        $configPath = __DIR__ . '/../config/app.php';
        if (file_exists($configPath)) {
            Config::load(require $configPath);
        }
    }

    public static function getInstance(): ?App
    {
        return self::$instance;
    }

    public function getViewPath(): string
    {
        return $this->viewPath;
    }

    public function setViewPath(string $path): self
    {
        $this->viewPath = $path;
        return $this;
    }

    public function getControllerPath(): string
    {
        return $this->controllerPath;
    }

    public function setControllerPath(string $path): self
    {
        $this->controllerPath = $path;
        return $this;
    }

    public function configure(array $config = []): self
    {
        // Load feature configuration
        $features = $config['features'] ?? [];
        
        // Enable features
        FeatureManager::initialize($features);
        
        // Store enabled features
        $this->features = FeatureManager::getEnabledFeatures();
        
        return $this;
    }

    public function enableFeature(string $feature): self
    {
        FeatureManager::enable($feature);
        $this->features = FeatureManager::getEnabledFeatures();
        return $this;
    }

    public function disableFeature(string $feature): self
    {
        FeatureManager::disable($feature);
        $this->features = FeatureManager::getEnabledFeatures();
        return $this;
    }

    public function hasFeature(string $feature): bool
    {
        return FeatureManager::isEnabled($feature);
    }

    public function getEnabledFeatures(): array
    {
        return array_keys($this->features);
    }

    public function get(string $path, $handler, array $middleware = []): self
    {
        $this->router->get($path, $handler, $middleware);
        return $this;
    }

    public function post(string $path, $handler, array $middleware = []): self
    {
        $this->router->post($path, $handler, $middleware);
        return $this;
    }

    public function put(string $path, $handler): self
    {
        $this->router->put($path, $handler);
        return $this;
    }

    public function delete(string $path, $handler): self
    {
        $this->router->delete($path, $handler);
        return $this;
    }

    public function middleware(array $middleware): self
    {
        $this->router->middleware($middleware);
        return $this;
    }

    public function group(array $attributes, callable $callback): self
    {
        $this->router->group($attributes, $callback);
        return $this;
    }

    public function loadRoutes(): self
    {
        // Load built-in framework routes first
        $this->loadBuiltInRoutes();
        
        // Load user-defined routes
        $this->routeLoader->loadRoutes();
        
        return $this;
    }
    
    private function loadBuiltInRoutes(): void
    {
        $builtInRoutesPath = __DIR__ . '/routes/';
        if (is_dir($builtInRoutesPath)) {
            $routeFiles = glob($builtInRoutesPath . '*.php');
            foreach ($routeFiles as $file) {
                $routes = require $file;
                if (is_callable($routes)) {
                    $routes($this);
                }
            }
        }
    }

    public function loadRouteFile(string $file): self
    {
        $this->routeLoader->loadRouteFile($file);
        return $this;
    }

    public function loadSpecificRoutes(array $files): self
    {
        $this->routeLoader->loadSpecificRoutes($files);
        return $this;
    }

    public function setRoutesPath(string $path): self
    {
        $this->routeLoader->setRoutesPath($path);
        return $this;
    }

    public function run(): void
    {
        $startTime = microtime(true);
        
        // Initialize logger
        Logger::init();
        // file_put_contents(__DIR__ . '/../logs/debug.log', "App::run() - Logger initialized\n", FILE_APPEND);
        
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $request = new Request();
        $response = $this->router->dispatch($request);
        
        // Log the request
        $duration = round((microtime(true) - $startTime) * 1000, 2);
        // file_put_contents(__DIR__ . '/../logs/debug.log', "App::run() - About to log request\n", FILE_APPEND);
        Logger::logRequest(
            $request->getMethod(),
            $request->getPath(),
            $response->getStatusCode(),
            $duration,
            $_SERVER['HTTP_USER_AGENT'] ?? null,
            $_SERVER['REMOTE_ADDR'] ?? null
        );
        // file_put_contents(__DIR__ . '/../logs/debug.log', "App::run() - Request logged\n", FILE_APPEND);
        
        $response->send();
    }

    public function getRouter(): Router
    {
        return $this->router;
    }
}