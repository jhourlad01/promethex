<?php

use Framework\{App, Env};

if (!function_exists('app')) {
    function app(): ?App
    {
        return App::getInstance();
    }
}

if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        return Env::get($key, $default);
    }
}

if (!function_exists('view')) {
    function view(string $template, array $data = []): string
    {
        return \Framework\View::make($template, $data);
    }
}

if (!function_exists('config')) {
    function config(string $key, $default = null)
    {
        return \Framework\Config::get($key, $default);
    }
}

if (!function_exists('route')) {
    function route(string $name, array $params = []): string
    {
        // Simple route generation - can be enhanced
        $url = $name;
        foreach ($params as $key => $value) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }
        return $url;
    }
}
