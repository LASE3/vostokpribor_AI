<?php

namespace App\Core;

class Request
{
    private string $method;
    private string $uri;
    private array $queryParams;
    private array $bodyParams;
    private array $headers;
    private array $files;

    public function __construct()
    {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $rawUri = $_SERVER['REQUEST_URI'] ?? '/';
        $this->uri = parse_url($rawUri, PHP_URL_PATH) ?? '/';
        $this->queryParams = $_GET;
        $this->files = $_FILES;

        // Parse JSON or standard post body
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            $rawBody = file_get_contents('php://input');
            $decoded = json_decode($rawBody, true, 64, JSON_THROW_ON_ERROR);
            if (!is_array($decoded) || !str_starts_with(ltrim($rawBody), '{')) {
                throw new \InvalidArgumentException('The JSON request body must be an object.');
            }
            $this->bodyParams = $decoded;
        } else {
            $this->bodyParams = $_POST;
        }

        // Parse headers
        $this->headers = [];
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $headerName = strtolower(str_replace('_', '-', substr($key, 5)));
                $this->headers[$headerName] = $value;
            } elseif (in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH'])) {
                $headerName = strtolower(str_replace('_', '-', $key));
                $this->headers[$headerName] = $value;
            }
        }
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function query(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) return $this->queryParams;
        return $this->queryParams[$key] ?? $default;
    }

    public function body(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) return $this->bodyParams;
        return $this->bodyParams[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->queryParams, $this->bodyParams);
    }

    public function file(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }

    public function header(string $name, ?string $default = null): ?string
    {
        $normalized = strtolower($name);
        return $this->headers[$normalized] ?? $default;
    }

    public function bearerToken(): ?string
    {
        $auth = $this->header('authorization');
        if ($auth && preg_match('/Bearer\s+(\S+)/i', $auth, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function clientIp(): string
    {
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    public function userAgent(): string
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    }
}
