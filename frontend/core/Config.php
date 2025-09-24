<?php

namespace Framework;

class Config
{
    private static $config = [];

    public static function load(array $config): void
    {
        self::$config = array_merge(self::$config, $config);
    }

    public static function get(string $key, $default = null)
    {
        $keys = explode('.', $key);
        $value = self::$config;

        foreach ($keys as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    public static function set(string $key, $value): void
    {
        $keys = explode('.', $key);
        $config = &self::$config;

        foreach ($keys as $segment) {
            if (!is_array($config)) {
                $config = [];
            }
            if (!array_key_exists($segment, $config)) {
                $config[$segment] = [];
            }
            $config = &$config[$segment];
        }

        $config = $value;
    }

    public static function all(): array
    {
        return self::$config;
    }

    public static function exists(string $key): bool
    {
        return self::get($key) !== null;
    }
}
