<?php

namespace Framework;

class MiddlewareRegistry
{
    private static array $middleware = [];

    public static function register(string $name, callable $middleware): void
    {
        self::$middleware[$name] = $middleware;
    }

    public static function get(string $name): ?callable
    {
        return self::$middleware[$name] ?? null;
    }

    public static function getAll(): array
    {
        return self::$middleware;
    }

    public static function loadFromDirectory(string $path): void
    {
        if (!is_dir($path)) {
            return;
        }

        $files = glob($path . '*.php');
        
        foreach ($files as $file) {
            $middleware = require $file;
            
            if (is_array($middleware)) {
                foreach ($middleware as $name => $handler) {
                    if (is_callable($handler)) {
                        self::register($name, $handler);
                    }
                }
            }
        }
    }

    public static function alias(string $alias, string $original): void
    {
        if (isset(self::$middleware[$original])) {
            self::$middleware[$alias] = self::$middleware[$original];
        }
    }

    public static function group(array $names): array
    {
        $group = [];
        foreach ($names as $name) {
            if (isset(self::$middleware[$name])) {
                $group[] = self::$middleware[$name];
            }
        }
        return $group;
    }
}
