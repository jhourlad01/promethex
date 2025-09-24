<?php

namespace Framework;

class ExceptionHandler
{
    private static bool $registered = false;
    private static bool $debugMode = false;

    public static function register(bool $debugMode = false): void
    {
        if (self::$registered) {
            return;
        }

        self::$debugMode = $debugMode;
        self::$registered = true;

        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    public static function handleException(\Throwable $exception): void
    {
        Logger::logException($exception);

        if (self::$debugMode) {
            self::renderDebugResponse($exception);
        } else {
            self::renderProductionResponse($exception);
        }
    }

    public static function handleError(int $severity, string $message, string $file, int $line): bool
    {
        if (!(error_reporting() & $severity)) {
            return false;
        }

        $exception = new \ErrorException($message, 0, $severity, $file, $line);
        self::handleException($exception);

        return true;
    }

    public static function handleShutdown(): void
    {
        $error = error_get_last();
        
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            $exception = new \ErrorException(
                $error['message'],
                0,
                $error['type'],
                $error['file'],
                $error['line']
            );
            self::handleException($exception);
        }
    }

    private static function renderDebugResponse(\Throwable $exception): void
    {
        $response = new Response('', 500);
        $response->header('Content-Type', 'text/html');
        
        $html = '<!DOCTYPE html>
<html>
<head>
    <title>Framework Error</title>
    <style>
        body { font-family: monospace; margin: 20px; background: #f5f5f5; }
        .error { background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .error-type { color: #d32f2f; font-weight: bold; }
        .error-message { color: #333; margin: 10px 0; }
        .error-file { color: #666; font-size: 0.9em; }
        pre { background: #f8f8f8; padding: 10px; border-radius: 3px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="error">
        <div class="error-type">' . get_class($exception) . '</div>
        <div class="error-message">' . htmlspecialchars($exception->getMessage()) . '</div>
        <div class="error-file">' . $exception->getFile() . ':' . $exception->getLine() . '</div>
        <pre>' . htmlspecialchars($exception->getTraceAsString()) . '</pre>
    </div>
</body>
</html>';
        
        $response = new Response($html, 500);
        $response->send();
    }

    private static function renderProductionResponse(\Throwable $exception): void
    {
        $response = new Response();
        
        if ($exception instanceof \ErrorException && $exception->getSeverity() >= E_ERROR) {
            $response->status(500);
        } elseif ($exception instanceof \InvalidArgumentException) {
            $response->status(400);
        } elseif ($exception instanceof \RuntimeException) {
            $response->status(500);
        } else {
            $response->status(500);
        }

        if (self::isJsonRequest()) {
            $response->json([
                'error' => 'Internal Server Error',
                'message' => 'An unexpected error occurred'
            ]);
        } else {
            $response->header('Content-Type', 'text/html');
            $response = new Response('<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
</head>
<body>
    <h1>Something went wrong</h1>
    <p>We apologize for the inconvenience. Please try again later.</p>
</body>
</html>', $response->getStatusCode());
        }

        $response->send();
    }

    private static function isJsonRequest(): bool
    {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        return strpos($accept, 'application/json') !== false;
    }
}
