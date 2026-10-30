<?php

declare(strict_types=1);

// PSR-4 Autoloader for App namespace
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Load Environment Configuration
$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile)) {
    \App\Core\Env::load($envFile);
}

// Error Reporting Configuration
$appDebug = (bool)\App\Core\Env::get('APP_DEBUG', false);
if ($appDebug) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Global Exception Handler
set_exception_handler(function (\Throwable $e) use ($appDebug) {
    error_log("Unhandled exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());

    $isApi = str_contains($_SERVER['REQUEST_URI'] ?? '', '/api/');
    if ($isApi) {
        if ($e instanceof \App\Core\AccessDeniedException) \App\Core\Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        if ($e instanceof \JsonException) \App\Core\Response::error('Malformed JSON request body.', 'INVALID_JSON', 400);
        if ($e instanceof \InvalidArgumentException) \App\Core\Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        \App\Core\Response::error(
            $appDebug ? $e->getMessage() : 'An internal server error occurred',
            'INTERNAL_ERROR',
            500,
            $appDebug ? ['file' => $e->getFile(), 'line' => $e->getLine()] : null
        );
    } else {
        http_response_code(500);
        if ($appDebug) {
            echo "<h1>Application Error</h1><p>" . htmlspecialchars($e->getMessage()) . "</p><pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
        } else {
            echo "<h1>500 - Internal Server Error</h1><p>The mission control system encountered an unexpected condition.</p>";
        }
        exit;
    }
});

// Session initialization
\App\Core\Auth::initSession();

// Protect every HTML form endpoint, including legacy pages. API requests have
// their own JSON middleware. Never let a page-specific handler omit this check.
if (PHP_SAPI !== 'cli') {
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
    $isApi = preg_match('#/api(?:/|$)#', $requestPath) === 1;
    if (!$isApi) {
        if (!in_array(strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET'), ['GET', 'HEAD', 'OPTIONS'], true)
            && !\App\Core\Csrf::validate($_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? null)) {
            http_response_code(403);
            header('Content-Type: text/plain; charset=utf-8');
            exit('Invalid or expired CSRF security token. Refresh the form and try again.');
        }
        ob_start([\App\Core\Csrf::class, 'protectHtml']);
    }
}
