<?php

namespace App\Controllers\Api;

use Framework\Request;
use Framework\Response;

abstract class BaseApiController
{
    /**
     * Return a successful JSON response
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
     * Return an error JSON response
     */
    protected function error(string $message = 'Error', int $statusCode = 400, array $errors = []): Response
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return (new Response())->json($response, $statusCode);
    }

    /**
     * Return a validation error response
     */
    protected function validationError(array $errors): Response
    {
        return $this->error('Validation failed', 422, $errors);
    }

    /**
     * Return an unauthorized response
     */
    protected function unauthorized(string $message = 'Unauthorized'): Response
    {
        return $this->error($message, 401);
    }

    /**
     * Return a forbidden response
     */
    protected function forbidden(string $message = 'Forbidden'): Response
    {
        return $this->error($message, 403);
    }

    /**
     * Return a not found response
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
