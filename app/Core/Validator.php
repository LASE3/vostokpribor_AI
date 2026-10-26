<?php

namespace App\Core;

class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $fieldRules) {
            $ruleList = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);
            $value = $data[$field] ?? null;

            foreach ($ruleList as $rule) {
                $params = [];
                if (str_contains($rule, ':')) {
                    [$rule, $paramStr] = explode(':', $rule, 2);
                    $params = explode(',', $paramStr);
                }

                switch ($rule) {
                    case 'required':
                        if ($value === null || $value === '' || (is_array($value) && empty($value))) {
                            $this->addError($field, "The {$field} field is required.");
                        }
                        break;

                    case 'string':
                        if ($value !== null && !is_string($value)) {
                            $this->addError($field, "The {$field} must be a string.");
                        }
                        break;

                    case 'email':
                        if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $this->addError($field, "The {$field} must be a valid email address.");
                        }
                        break;

                    case 'integer':
                    case 'int':
                        if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_INT)) {
                            $this->addError($field, "The {$field} must be an integer.");
                        }
                        break;

                    case 'numeric':
                        if ($value !== null && $value !== '' && !is_numeric($value)) {
                            $this->addError($field, "The {$field} must be a number.");
                        }
                        break;

                    case 'min':
                        $min = (int)($params[0] ?? 0);
                        if (is_string($value) && mb_strlen($value) < $min) {
                            $this->addError($field, "The {$field} must be at least {$min} characters.");
                        } elseif (is_numeric($value) && $value < $min) {
                            $this->addError($field, "The {$field} must be at least {$min}.");
                        }
                        break;

                    case 'max':
                        $max = (int)($params[0] ?? 0);
                        if (is_string($value) && mb_strlen($value) > $max) {
                            $this->addError($field, "The {$field} may not be greater than {$max} characters.");
                        } elseif (is_numeric($value) && $value > $max) {
                            $this->addError($field, "The {$field} may not be greater than {$max}.");
                        }
                        break;

                    case 'in':
                        if ($value !== null && $value !== '' && !in_array($value, $params)) {
                            $allowed = implode(', ', $params);
                            $this->addError($field, "The {$field} must be one of: {$allowed}.");
                        }
                        break;
                }
            }
        }

        return empty($this->errors);
    }

    private function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstError(): ?string
    {
        foreach ($this->errors as $fieldErrors) {
            if (!empty($fieldErrors)) {
                return $fieldErrors[0];
            }
        }
        return null;
    }
}
