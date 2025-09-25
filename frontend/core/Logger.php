<?php

namespace Framework;

class Logger
{
    private static $logDir;
    private static $initialized = false;
    
    public static function init($logDir = null)
    {
        if (self::$initialized) {
            return;
        }
        
        self::$logDir = $logDir ?: __DIR__ . '/../logs';
        
        // Create logs directory if it doesn't exist
        if (!is_dir(self::$logDir)) {
            mkdir(self::$logDir, 0755, true);
        }
        
        // Debug: Log that logger is initialized
        // error_log("Logger initialized with directory: " . self::$logDir);
        
        self::$initialized = true;
    }
    
    public static function log($level, $message, $context = [])
    {
        self::init();
        
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' ' . json_encode($context) : '';
        $logEntry = "[{$timestamp}] [{$level}] {$message}{$contextStr}" . PHP_EOL;
        
        // Log to file
        $logFile = self::$logDir . '/app.log';
        
        // Debug: Log that we're writing to file
        // file_put_contents(__DIR__ . '/../logs/debug.log', "Logger::log writing to: " . $logFile . "\n", FILE_APPEND);
        // file_put_contents(__DIR__ . '/../logs/debug.log', "Logger::log writing: " . $logEntry, FILE_APPEND);
        
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
        
        // Also log errors to separate error file
        if (in_array(strtoupper($level), ['ERROR', 'CRITICAL', 'EMERGENCY'])) {
            $errorFile = self::$logDir . '/error.log';
            file_put_contents($errorFile, $logEntry, FILE_APPEND | LOCK_EX);
        }
        
        // Log to PHP error log as well for development
        if (strtoupper($level) === 'ERROR') {
            error_log($message . $contextStr);
        }
    }
    
    public static function info($message, $context = [])
    {
        self::log('INFO', $message, $context);
    }
    
    public static function warning($message, $context = [])
    {
        self::log('WARNING', $message, $context);
    }
    
    public static function error($message, $context = [])
    {
        self::log('ERROR', $message, $context);
    }
    
    public static function debug($message, $context = [])
    {
        self::log('DEBUG', $message, $context);
    }
    
    public static function logRequest($method, $uri, $statusCode, $duration, $userAgent = null, $ip = null)
    {
        $context = [
            'method' => $method,
            'uri' => $uri,
            'status' => $statusCode,
            'duration' => $duration . 'ms',
            'user_agent' => $userAgent,
            'ip' => $ip
        ];
        
        // Debug: Log that we're logging a request
        // file_put_contents(__DIR__ . '/../logs/debug.log', "Logger::logRequest called with: " . json_encode($context) . "\n", FILE_APPEND);
        
        if ($statusCode >= 400) {
            self::error("HTTP {$statusCode} {$method} {$uri}", $context);
        } else {
            self::info("HTTP {$statusCode} {$method} {$uri}", $context);
        }
    }
    
    public static function logException(\Throwable $exception, $context = [])
    {
        $errorContext = array_merge($context, [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ]);

        self::error($exception->getMessage(), $errorContext);
    }
    
    public static function logGraphQLError($message, $context = [])
    {
        self::error("GraphQL Error: {$message}", $context);
    }
    
    public static function configure($logFile = null, $level = 'info')
    {
        // This method is called from index.php but we don't need special configuration
        // Just initialize the logger with the directory (not the file)
        if ($logFile) {
            $logDir = dirname($logFile);
            self::init($logDir);
        } else {
            self::init();
        }
    }
}