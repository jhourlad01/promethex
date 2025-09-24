<?php

namespace Framework;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class Logger
{
    private static ?MonologLogger $logger = null;
    private static string $level = 'info';

    public static function configure(string $logPath, string $level = 'info'): void
    {
        self::$level = $level;
        
        // Ensure log directory exists
        $logDir = dirname($logPath);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        self::$logger = new MonologLogger('framework');
        
        // Rotating file handler (daily rotation)
        $handler = new RotatingFileHandler($logPath, 30, self::getMonologLevel($level));
        $handler->setFormatter(new LineFormatter(
            "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
            'Y-m-d H:i:s'
        ));
        
        self::$logger->pushHandler($handler);
    }

    public static function debug(string $message, array $context = []): void
    {
        self::log('debug', $message, $context);
    }

    public static function info(string $message, array $context = []): void
    {
        self::log('info', $message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::log('warning', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::log('error', $message, $context);
    }

    public static function critical(string $message, array $context = []): void
    {
        self::log('critical', $message, $context);
    }

    private static function log(string $level, string $message, array $context = []): void
    {
        if (self::$logger === null) {
            // Fallback to basic logging
            $timestamp = date('Y-m-d H:i:s');
            $contextStr = !empty($context) ? ' ' . json_encode($context) : '';
            $logEntry = "[{$timestamp}] {$level}: {$message}{$contextStr}" . PHP_EOL;
            error_log($logEntry);
            return;
        }

        $monologLevel = self::getMonologLevel($level);
        self::$logger->addRecord($monologLevel, $message, $context);
    }

    private static function getMonologLevel(string $level): int
    {
        return match ($level) {
            'debug' => MonologLogger::DEBUG,
            'info' => MonologLogger::INFO,
            'warning' => MonologLogger::WARNING,
            'error' => MonologLogger::ERROR,
            'critical' => MonologLogger::CRITICAL,
            default => MonologLogger::INFO
        };
    }

    public static function logException(\Throwable $exception): void
    {
        self::error('Uncaught exception: ' . $exception->getMessage(), [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ]);
    }

    public static function getLogger(): ?MonologLogger
    {
        return self::$logger;
    }
}
