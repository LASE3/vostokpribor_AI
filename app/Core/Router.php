<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $handler, array $middleware = []): void
    {
        $this->addRoute('GET', $path, $handler, $middleware);
    }

    public function post(string $path, callable|array $handler, array $middleware = []): void
    {
        $this->addRoute('POST', $path, $handler, $middleware);
    }

    public function patch(string $path, callable|array $handler, array $middleware = []): void
    {
        $this->addRoute('PATCH', $path, $handler, $middleware);
    }

    public function put(string $path, callable|array $handler, array $middleware = []): void
    {
        $this->addRoute('PUT', $path, $handler, $middleware);
    }

    public function delete(string $path, callable|array $handler, array $middleware = []): void
    {
        $this->addRoute('DELETE', $path, $handler, $middleware);
    }

    private function addRoute(string $method, string $path, callable|array $handler, array $middleware): void
    {
        // Normalize path
        $trimmed = trim($path, '/');
        // Convert placeholders {param} into regex
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $trimmed);
        $regex = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method'     => $method,
            'path'       => $trimmed,
            'regex'      => $regex,
            'handler'    => $handler,
            'middleware' => $middleware
        ];
    }

    /** Read-only route metadata for contract coverage; never exposed anonymously. */
    public function definitions(): array
    {
        return array_map(fn($route) => ['method' => $route['method'], 'path' => $route['path'], 'handler' => is_array($route['handler']) ? implode('::', $route['handler']) : 'callable', 'middleware_count'=>count($route['middleware'])], $this->routes);
    }

    public function dispatch(Request $request): void
    {
        $method = $request->getMethod();
        $uri = trim($request->getUri(), '/');

        // Strip prefix if needed (e.g. /vostokpribor_AI/api/v1)
        if (preg_match('#api/v1/?(.*)$#', $uri, $matches)) {
            $uri = trim($matches[1], '/');
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['regex'], $uri, $matches)) {
                // Extract named params
                $params = [];
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $params[$k] = $v;
                    }
                }

                // Execute route middleware
                foreach ($route['middleware'] as $mw) {
                    if (is_callable($mw)) {
                        $mw($request);
                    }
                }

                // Invoke handler
                $handler = $route['handler'];
                if (is_array($handler)) {
                    [$class, $action] = $handler;
                    $controller = new $class();
                    $controller->$action($request, $params);
                    return;
                } elseif (is_callable($handler)) {
                    $handler($request, $params);
                    return;
                }
            }
        }

        Response::error("Endpoint [{$method} /{$uri}] not found", 'NOT_FOUND', 404);
    }
}
