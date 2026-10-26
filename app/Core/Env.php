<?php

namespace App\Core;

class Env
{
    private static array $variables = [];
    private static bool $loaded = false;

    public static function load(string $filePath): void
    {
        if (self::$loaded || !file_exists($filePath)) {
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Process configuration wins over the optional developer file.
                // This makes APP_ENV=testing + DB_NAME=..._test reliable.
                if (getenv($key) !== false) {
                    continue;
                }

                // Strip surrounding quotes
                if ((str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                    (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
                    $value = substr($value, 1, -1);
                }

                self::$variables[$key] = $value;
                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }

        self::$loaded = true;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, self::$variables)) {
            $val = self::$variables[$key];
            if (strtolower($val) === 'true') return true;
            if (strtolower($val) === 'false') return false;
            if (strtolower($val) === 'null') return null;
            return $val;
        }

        $envVal = getenv($key);
        if ($envVal !== false) {
            if (strtolower($envVal) === 'true') return true;
            if (strtolower($envVal) === 'false') return false;
            if (strtolower($envVal) === 'null') return null;
            return $envVal;
        }

        return $default;
    }
}
