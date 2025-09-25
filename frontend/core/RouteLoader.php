<?php

namespace Framework;

use Framework\Logger;

class RouteLoader
{
    private App $app;
    private string $routesPath;

    public function __construct(App $app, string $routesPath = 'src/routes/')
    {
        $this->app = $app;
        $this->routesPath = rtrim($routesPath, '/') . '/';
    }

    public function loadRoutes(): void
    {
        Logger::debug("RouteLoader: Loading routes from " . $this->routesPath);
        
        if (!is_dir($this->routesPath)) {
            Logger::warning("RouteLoader: Directory does not exist: " . $this->routesPath);
            return;
        }

        $routeFiles = glob($this->routesPath . '*.php');
        Logger::debug("RouteLoader: Found " . count($routeFiles) . " route files");
        
        foreach ($routeFiles as $file) {
            Logger::debug("RouteLoader: Loading route file: " . $file);
            $this->loadRouteFile($file);
        }
    }

    public function loadRouteFile(string $file): void
    {
        if (!file_exists($file)) {
            return;
        }

        $routeLoader = require $file;
        
        if (is_callable($routeLoader)) {
            $routeLoader($this->app);
        }
    }

    public function loadSpecificRoutes(array $files): void
    {
        foreach ($files as $file) {
            $fullPath = $this->routesPath . $file;
            $this->loadRouteFile($fullPath);
        }
    }

    public function setRoutesPath(string $path): self
    {
        $this->routesPath = rtrim($path, '/') . '/';
        return $this;
    }
}
