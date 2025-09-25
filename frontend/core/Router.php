<?php

namespace Framework;

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use Framework\Logger;

class Router
{
    private array $routes = [];
    private array $middleware = [];
    private array $groupMiddleware = [];
    private ?Dispatcher $dispatcher = null;

    public function get(string $path, $handler, array $middleware = []): self
    {
        return $this->addRoute('GET', $path, $handler, $middleware);
    }

    public function post(string $path, $handler, array $middleware = []): self
    {
        return $this->addRoute('POST', $path, $handler, $middleware);
    }

    public function put(string $path, $handler): self
    {
        return $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, $handler): self
    {
        return $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute(string $method, string $path, $handler, array $middleware = []): self
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'middleware' => array_merge($this->middleware, $this->groupMiddleware, $middleware)
        ];
        return $this;
    }

    public function middleware(array $middleware): self
    {
        $this->middleware = $middleware;
        return $this;
    }

    public function group(array $attributes, callable $callback): self
    {
        $originalMiddleware = $this->groupMiddleware;
        
        if (isset($attributes['middleware'])) {
            $this->groupMiddleware = array_merge($this->groupMiddleware, $attributes['middleware']);
        }

        $callback($this);

        $this->groupMiddleware = $originalMiddleware;
        return $this;
    }

    public function dispatch(Request $request): Response
    {
        $startTime = microtime(true);
        
        Logger::debug("Router dispatch started", [
            'method' => $request->getMethod(),
            'path' => $request->getPath()
        ]);
        
        if ($this->dispatcher === null) {
            Logger::debug("Creating dispatcher");
            $this->dispatcher = \FastRoute\simpleDispatcher(function(RouteCollector $r) {
                foreach ($this->routes as $route) {
                    Logger::debug("Adding route", [
                        'method' => $route['method'],
                        'path' => $route['path']
                    ]);
                    $r->addRoute($route['method'], $route['path'], $route);
                }
            });
        }

        $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getPath());
        
        Logger::debug("Route dispatch result", [
            'route_info' => $routeInfo,
            'request_path' => $request->getPath()
        ]);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                Logger::warning("Route not found", [
                    'method' => $request->getMethod(),
                    'path' => $request->getPath()
                ]);
                return new Response('Not Found', 404);
            case Dispatcher::METHOD_NOT_ALLOWED:
                Logger::warning("Method not allowed", [
                    'method' => $request->getMethod(),
                    'path' => $request->getPath()
                ]);
                return new Response('Method Not Allowed', 405);
            case Dispatcher::FOUND:
                $route = $routeInfo[1];
                $vars = $routeInfo[2];
                Logger::debug("Route found", [
                    'route' => $route,
                    'vars' => $vars
                ]);
                return $this->executeHandler($route['handler'], $request, $route['middleware'], $vars);
        }
    }

    private function executeHandler($handler, Request $request, array $middleware = [], array $vars = []): Response
    {
        $next = function($request) use ($handler, $vars) {
            if (is_callable($handler)) {
                return $handler($request, $vars);
            }

            if (is_string($handler) && strpos($handler, '@') !== false) {
                [$controller, $method] = explode('@', $handler);
                $controllerClass = "App\\Controllers\\{$controller}";
                
                if (class_exists($controllerClass)) {
                    Logger::debug("Creating controller", [
                        'controller' => $controllerClass,
                        'method' => $method,
                        'vars' => $vars
                    ]);
                    $controllerInstance = new $controllerClass($request, $vars);
                    return $controllerInstance->$method();
                }
            }

            return new Response('Handler not found', 500);
        };

        foreach (array_reverse($middleware) as $middleware) {
            $next = function($request) use ($middleware, $next) {
                return $middleware($request, $next);
            };
        }

        return $next($request);
    }
}
