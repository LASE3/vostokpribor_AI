<?php

namespace App\Core;

class Response
{
    public static function json(array $data, int $statusCode = 200, array $headers = []): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');

        foreach ($headers as $key => $value) {
            header("$key: $value");
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        exit;
    }

    public static function success(mixed $data = [], string $message = 'Operation completed successfully', int $statusCode = 200): void
    {
        self::json([
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ], $statusCode);
    }

    public static function error(string $message, string $code = 'ERROR', int $statusCode = 400, mixed $details = null): void
    {
        if ($statusCode >= 500 && $statusCode !== 503 && !Env::get('APP_DEBUG', false)) {
            $message = 'An internal server error occurred.';
            $details = null;
        }
        $payload = [
            'success' => false,
            'error'   => [
                'code'    => $code,
                'message' => $message,
            ],
        ];

        if ($details !== null) {
            $payload['error']['details'] = $details;
        }

        self::json($payload, $statusCode);
    }

    public static function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
