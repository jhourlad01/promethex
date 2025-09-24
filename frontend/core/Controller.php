<?php

namespace Framework;

abstract class Controller
{
    protected Request $request;
    protected array $params = [];

    public function __construct(Request $request, array $params = [])
    {
        $this->request = $request;
        $this->params = $params;
    }

    protected function view(string $template, array $data = [], string $layout = null): Response
    {
        return \Framework\View::render($template, $data, $layout);
    }

    protected function viewWithoutLayout(string $template, array $data = []): Response
    {
        return \Framework\View::withoutLayout($template, $data);
    }

    protected function json(array $data, int $statusCode = 200): Response
    {
        return (new Response())->json($data, $statusCode);
    }

    protected function redirect(string $url, int $statusCode = 302): Response
    {
        $response = new Response('', $statusCode);
        $response->header('Location', $url);
        return $response;
    }

    protected function validate(array $data, array $rules): Validator
    {
        $app = App::getInstance();
        if (!$app || !$app->hasFeature('validation')) {
            throw new \RuntimeException('Validation feature is not enabled');
        }

        return Validator::make($data, $rules);
    }

    protected function model(string $model): mixed
    {
        $app = App::getInstance();
        if (!$app || !$app->hasFeature('database')) {
            throw new \RuntimeException('Database feature is not enabled');
        }

        $modelClass = "App\\Models\\{$model}";
        
        if (!class_exists($modelClass)) {
            throw new \RuntimeException("Model '{$model}' not found");
        }

        return new $modelClass();
    }

    protected function auth(): Auth
    {
        $app = App::getInstance();
        if (!$app || !$app->hasFeature('auth')) {
            throw new \RuntimeException('Authentication feature is not enabled');
        }

        return new Auth();
    }

    protected function log(string $level, string $message, array $context = []): void
    {
        $app = App::getInstance();
        if (!$app || !$app->hasFeature('logging')) {
            return; // Silently ignore if logging is not enabled
        }

        Logger::$level($message, $context);
    }

    protected function getParam(string $key, $default = null): mixed
    {
        return $this->params[$key] ?? $default;
    }

    protected function getInput(string $key = null): mixed
    {
        return $this->request->getInput($key);
    }

    protected function getJson(): ?array
    {
        return $this->request->getJson();
    }
}
