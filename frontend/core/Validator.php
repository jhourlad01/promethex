<?php

namespace Framework;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class Validator
{
    private array $data;
    private array $rules;
    private array $errors = [];
    private array $messages = [];

    public function __construct(array $data, array $rules = [], array $messages = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->messages = $messages;
    }

    public static function make(array $data, array $rules = [], array $messages = []): self
    {
        return new self($data, $rules, $messages);
    }

    public function validate(): bool
    {
        foreach ($this->rules as $field => $ruleString) {
            $this->validateField($field, $ruleString);
        }

        return empty($this->errors);
    }

    public function fails(): bool
    {
        return !$this->validate();
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function getFirstError(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }

    private function validateField(string $field, string $rules): void
    {
        $value = $this->data[$field] ?? null;
        $ruleArray = explode('|', $rules);
        $validator = v::create();

        foreach ($ruleArray as $rule) {
            $validator = $this->addRule($validator, $rule);
        }

        try {
            $validator->assert($value);
        } catch (ValidationException $e) {
            $this->errors[$field] = $e->getMessages();
        }
    }

    private function addRule($validator, string $rule)
    {
        if (strpos($rule, ':') !== false) {
            [$ruleName, $parameter] = explode(':', $rule, 2);
        } else {
            $ruleName = $rule;
            $parameter = null;
        }

        return match ($ruleName) {
            'required' => $validator->notEmpty(),
            'email' => $validator->email(),
            'numeric' => $validator->numericVal(),
            'string' => $validator->stringType(),
            'min' => $validator->min((int)$parameter),
            'max' => $validator->max((int)$parameter),
            'confirmed' => $validator->equals($this->data[$parameter . '_confirmation'] ?? null),
            'unique' => $validator->callback(function($value) use ($parameter) {
                // Check if database feature is enabled
                if (!app() || !app()->hasFeature('database')) {
                    return true; // Skip validation if database not available
                }
                
                // Parse table.column format
                $parts = explode('.', $parameter);
                if (count($parts) !== 2) {
                    return false; // Invalid format
                }
                
                [$table, $column] = $parts;
                
                // Use Eloquent to check uniqueness
                $count = \Illuminate\Support\Facades\DB::table($table)
                    ->where($column, $value)
                    ->count();
                    
                return $count === 0; // True if unique (count is 0)
            }),
            default => $validator
        };
    }

    // Backward compatibility methods
    public function validateRequired($value): bool
    {
        return v::notEmpty()->validate($value);
    }

    public function validateEmail($value): bool
    {
        return v::email()->validate($value);
    }

    public function validateMin($value, $parameter): bool
    {
        return v::min((int)$parameter)->validate($value);
    }

    public function validateMax($value, $parameter): bool
    {
        return v::max((int)$parameter)->validate($value);
    }

    public function validateNumeric($value): bool
    {
        return v::numericVal()->validate($value);
    }

    public function validateString($value): bool
    {
        return v::stringType()->validate($value);
    }

    public function validateConfirmed($value, $parameter): bool
    {
        $confirmationField = $parameter ?? $value . '_confirmation';
        return $value === ($this->data[$confirmationField] ?? null);
    }
}
