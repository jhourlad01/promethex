<?php

namespace Framework;

use Dotenv\Dotenv;

class Env
{
    private static array $variables = [];
    private static bool $loaded = false;

    public static function load(string $path = '.env'): void
    {
        if (self::$loaded) {
            return;
        }

        if (!file_exists($path)) {
            return;
        }

        // Use the vlucas/phpdotenv library
        $dotenv = Dotenv::createImmutable(dirname($path), basename($path));
        $dotenv->load();

        // Store loaded variables for our custom methods
        self::$variables = $_ENV;
        self::$loaded = true;
    }

    public static function get(string $key, $default = null)
    {
        return self::$variables[$key] ?? $_ENV[$key] ?? getenv($key) ?: $default;
    }

    public static function set(string $key, $value): void
    {
        self::$variables[$key] = $value;
        $_ENV[$key] = $value;
        putenv("$key=$value");
    }

    public static function has(string $key): bool
    {
        return isset(self::$variables[$key]) || array_key_exists($key, $_ENV) || getenv($key) !== false;
    }

    public static function all(): array
    {
        return array_merge(self::$variables, $_ENV);
    }

    public static function isLoaded(): bool
    {
        return self::$loaded;
    }

    public static function getAppName(): string
    {
        return self::get('APP_NAME', 'Promethex');
    }

    public static function getAppUrl(): string
    {
        return self::get('APP_URL', 'http://localhost');
    }

    public static function getAppEnv(): string
    {
        return self::get('APP_ENV', 'production');
    }

    public static function isDebug(): bool
    {
        $debug = self::get('APP_DEBUG', '0');
        return $debug === 'true' || $debug === '1' || $debug === true;
    }

    public static function getDatabaseConfig(): array
    {
        return [
            'driver' => self::get('DB_CONNECTION', 'sqlite'),
            'host' => self::get('DB_HOST', 'localhost'),
            'port' => self::get('DB_PORT', '3306'),
            'database' => self::get('DB_DATABASE', 'promethex'),
            'username' => self::get('DB_USERNAME', ''),
            'password' => self::get('DB_PASSWORD', ''),
        ];
    }
}
