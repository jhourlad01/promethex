<?php

namespace Framework;

class DataDog
{
    private static bool $enabled = false;
    private static string $apiKey = '';
    private static string $appKey = '';
    private static string $site = 'datadoghq.com';
    private static string $env = 'dev';
    private static bool $apmEnabled = false;
    private static bool $profilingEnabled = false;
    private static bool $dataStreamsEnabled = false;

    public static function configure(): void
    {
        self::$enabled = env('DATADOG_ENABLED', '0') === '1';
        self::$apiKey = env('DD_API_KEY', '');
        self::$appKey = env('DD_APP_KEY', '');
        self::$site = env('DD_SITE', 'us5.datadoghq.com');
        self::$env = env('DD_ENV', 'dev');
        self::$apmEnabled = env('DD_APM_INSTRUMENTATION_ENABLED', '') !== '';
        self::$profilingEnabled = env('DD_PROFILING_ENABLED', '') !== '';
        self::$dataStreamsEnabled = env('DD_DATA_STREAMS_ENABLED', '0') === '1';
    }

    public static function isEnabled(): bool
    {
        return self::$enabled && !empty(self::$apiKey);
    }

    public static function getApiKey(): string
    {
        return self::$apiKey;
    }

    public static function getSite(): string
    {
        return self::$site;
    }

    public static function getEnvironment(): string
    {
        return self::$env;
    }

    public static function isApmEnabled(): bool
    {
        return self::$apmEnabled;
    }

    public static function isProfilingEnabled(): bool
    {
        return self::$profilingEnabled;
    }

    public static function isDataStreamsEnabled(): bool
    {
        return self::$dataStreamsEnabled;
    }

    public static function track(string $metric, float $value, array $tags = []): void
    {
        if (!self::isEnabled()) {
            return;
        }

        // Add environment context to tags
        $tags['env'] = self::$env;
        $tags['service'] = env('APP_NAME', 'promethex');

        // Send metric to DataDog
        self::sendMetric($metric, $value, $tags);
    }

    public static function event(string $title, string $text, array $tags = []): void
    {
        if (!self::isEnabled()) {
            return;
        }

        // Send event to DataDog
        self::sendEvent($title, $text, $tags);
    }

    public static function log(string $message, string $level = 'info', array $context = []): void
    {
        if (!self::isEnabled()) {
            return;
        }

        // Send log to DataDog
        self::sendLog($message, $level, $context);
    }

    private static function sendMetric(string $metric, float $value, array $tags): void
    {
        // In real implementation, you'd use the DataDog StatsD client
        // For now, this is a placeholder
        error_log("DataDog Metric: $metric = $value");
    }

    private static function sendEvent(string $title, string $text, array $tags): void
    {
        // In real implementation, you'd use the DataDog API
        // For now, this is a placeholder
        error_log("DataDog Event: $title - $text");
    }

    private static function sendLog(string $message, string $level, array $context): void
    {
        // In real implementation, you'd use the DataDog Logs API
        // For now, this is a placeholder
        error_log("DataDog Log [$level]: $message");
    }

    public static function trackRequest(string $method, string $route, float $duration, int $statusCode): void
    {
        self::track('framework.request.duration', $duration, [
            'method' => $method,
            'route' => $route,
            'status_code' => (string)$statusCode
        ]);

        self::track('framework.request.count', 1, [
            'method' => $method,
            'route' => $route,
            'status_code' => (string)$statusCode
        ]);
    }

    public static function trackDatabaseQuery(string $query, float $duration): void
    {
        self::track('framework.database.query.duration', $duration, [
            'query_hash' => md5($query)
        ]);
    }

    public static function trackError(string $error, array $context = []): void
    {
        self::event('Framework Error', $error, [
            'error_type' => 'framework_error'
        ]);

        self::track('framework.error.count', 1, [
            'error_type' => 'framework_error'
        ]);
    }
}
