<?php

namespace Framework;

class Request
{
    private $method;
    private $path;
    private $headers;
    private $body;
    private $query;
    private $post;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $this->headers = $this->getAllHeaders();
        $this->body = file_get_contents('php://input');
        $this->query = $_GET;
        $this->post = $_POST;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Set HTTP method (for testing)
     */
    public function setMethod(string $method): void
    {
        $this->method = strtoupper($method);
    }

    /**
     * Set request body (for testing)
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * Set header (for testing)
     */
    public function setHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getJson(): ?array
    {
        $data = json_decode($this->body, true);
        return json_last_error() === JSON_ERROR_NONE ? $data : null;
    }

    public function getQuery(string $key = null): mixed
    {
        if ($key === null) {
            return $this->query;
        }
        return $this->query[$key] ?? null;
    }

    public function getPost(string $key = null): mixed
    {
        if ($key === null) {
            return $this->post;
        }
        return $this->post[$key] ?? null;
    }

    public function getInput(string $key = null): mixed
    {
        $input = array_merge($this->query, $this->post);
        if ($key === null) {
            return $input;
        }
        return $input[$key] ?? null;
    }

    public function sanitizeInput(mixed $input): mixed
    {
        if (is_string($input)) {
            return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
        }
        
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        
        return $input;
    }

    public function getSanitizedInput(string $key = null): mixed
    {
        $input = $this->getInput($key);
        return $this->sanitizeInput($input);
    }

    public function hasFile(string $key): bool
    {
        return isset($_FILES[$key]) && $_FILES[$key]['error'] !== UPLOAD_ERR_NO_FILE;
    }

    public function getFile(string $key): ?array
    {
        return $_FILES[$key] ?? null;
    }

    public function isAjax(): bool
    {
        return $this->getHeader('X-Requested-With') === 'XMLHttpRequest';
    }

    public function wantsJson(): bool
    {
        $accept = $this->getHeader('Accept') ?? '';
        return strpos($accept, 'application/json') !== false || $this->isAjax();
    }

    /**
     * Get all headers with Windows compatibility
     */
    private function getAllHeaders(): array
    {
        if (function_exists('getallheaders')) {
            return getallheaders() ?: [];
        }
        
        // Fallback for Windows/Apache
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = str_replace('_', '-', substr($key, 5));
                $header = ucwords(strtolower($header), '-');
                $headers[$header] = $value;
            }
        }
        
        return $headers;
    }
}
