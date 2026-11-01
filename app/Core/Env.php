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
                // Keep developer configuration local to this request. putenv()
                // changes the Apache process environment and can race another
                // request (or another installation) on a threaded PHP server.
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

    public static function isProduction(): bool
    {
        return strtolower((string)self::get('APP_ENV', 'production')) === 'production';
    }

    /** A production request never exposes diagnostics, including with a bad flag. */
    public static function debugEnabled(): bool
    {
        return !self::isProduction() && self::get('APP_DEBUG', false) === true;
    }

    /** Return configuration keys/reasons only. Never include configured values. */
    public static function configurationErrors(): array
    {
        $errors = [];
        $environment = strtolower((string)self::get('APP_ENV', 'production'));
        if (!in_array(self::get('APP_ENV', 'production'), ['production', 'local', 'development', 'dev', 'testing'], true)) {
            $errors[] = 'APP_ENV must identify a supported environment.';
        }
        foreach (['APP_DEBUG' => false, 'SESSION_SECURE' => false] as $key => $default) {
            if (!is_bool(self::get($key, $default))) $errors[] = $key . ' must be true or false.';
        }
        foreach (['DB_HOST', 'DB_NAME', 'DB_USER'] as $key) {
            $value = self::get($key, '');
            if (!is_string($value) || $value === '' || strpbrk($value, ";\r\n\0") !== false) {
                $errors[] = $key . ' must be explicitly configured without connection separators.';
            }
        }
        if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', (string)self::get('DB_NAME', ''))) {
            $errors[] = 'DB_NAME must be a valid database identifier.';
        }
        if (self::get('DB_CHARSET', 'utf8mb4') !== 'utf8mb4') $errors[] = 'DB_CHARSET must be utf8mb4.';
        $integerRanges = [
            'DB_PORT' => [3306, 1, 65535],
            'SESSION_LIFETIME' => [7200, 60, 604800],
            'MAX_UPLOAD_SIZE_MB' => [50, 1, 1024],
            'API_MUTATION_LIMIT' => [120, 1, 1000000],
            'API_UPLOAD_LIMIT' => [20, 1, 1000000],
            'API_EXPENSIVE_READ_LIMIT' => [60, 1, 1000000],
            'API_RATE_WINDOW_SECONDS' => [60, 1, 86400],
        ];
        foreach ($integerRanges as $key => [$default, $minimum, $maximum]) {
            $value = self::get($key, $default);
            if (!(is_int($value) || (is_string($value) && preg_match('/^[0-9]+$/D', $value)))
                || (int)$value < $minimum || (int)$value > $maximum) {
                $errors[] = $key . ' must be an integer within its supported range.';
            }
        }
        if (!preg_match('/^[A-Za-z][A-Za-z0-9_-]{0,127}$/D', (string)self::get('SESSION_COOKIE_NAME', 'vostok_ai_session'))) {
            $errors[] = 'SESSION_COOKIE_NAME must be a valid application cookie name.';
        }
        $url = self::get('APP_URL', '');
        $parts = is_string($url) && filter_var($url, FILTER_VALIDATE_URL) ? parse_url($url) : false;
        if (!$parts || empty($parts['host']) || !in_array($parts['scheme'] ?? '', ['http', 'https'], true)
            || isset($parts['user']) || isset($parts['pass']) || isset($parts['query']) || isset($parts['fragment'])
            || preg_match('/[\r\n\x00]/', (string)$url)) {
            $errors[] = 'APP_URL must be an absolute HTTP(S) URL without credentials, query or fragment.';
        }
        if ($environment === 'production') {
            if (self::get('APP_DEBUG', false) !== false) $errors[] = 'APP_DEBUG must be false in production.';
            if (self::get('SESSION_SECURE', false) !== true) $errors[] = 'SESSION_SECURE must be true in production.';
            if (($parts['scheme'] ?? '') !== 'https') $errors[] = 'APP_URL must use HTTPS in production.';
            if (!is_string(self::get('DB_PASS')) || self::get('DB_PASS') === '') $errors[] = 'DB_PASS must be configured in production.';
            if (strtolower((string)self::get('DB_USER', '')) === 'root') $errors[] = 'DB_USER must be a restricted runtime account in production.';
        }
        return array_values(array_unique($errors));
    }

}
