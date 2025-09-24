<?php

namespace App\Controllers\Api;

use Framework\Response;

abstract class BaseApiController
{
    /**
     * Return a successful JSON response.
     */
    protected function success(array $data = [], string $message = 'Success', int $statusCode = 200): Response
    {
        return (new Response())->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Return an error JSON response.
     */
    protected function error(string $message = 'An error occurred', int $statusCode = 500, array $errors = []): Response
    {
        return (new Response())->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * Return a validation error JSON response.
     */
    protected function validationError(array $errors, string $message = 'Validation failed'): Response
    {
        return $this->error($message, 422, $errors);
    }

    /**
     * Return an unauthorized JSON response.
     */
    protected function unauthorized(string $message = 'Unauthorized'): Response
    {
        return $this->error($message, 401);
    }

    /**
     * Return a forbidden JSON response.
     */
    protected function forbidden(string $message = 'Forbidden'): Response
    {
        return $this->error($message, 403);
    }

    /**
     * Return a not found JSON response.
     */
    protected function notFound(string $message = 'Not found'): Response
    {
        return $this->error($message, 404);
    }

    /**
     * Validate required fields
     */
    protected function validateRequired(?array $data, array $requiredFields): ?array
    {
        if ($data === null) {
            $errors = [];
            foreach ($requiredFields as $field) {
                $errors[$field] = "The {$field} field is required.";
            }
            return $errors;
        }
        
        $errors = [];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $errors[$field] = "The {$field} field is required.";
            }
        }

        return empty($errors) ? null : $errors;
    }
}
