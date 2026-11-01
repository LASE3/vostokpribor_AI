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
$appDebug = \App\Core\Env::debugEnabled();
if ($appDebug) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    // Keep warnings/errors available to protected server-side diagnostics.
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
}

// Global Exception Handler
set_exception_handler(function (\Throwable $e) use ($appDebug) {
    // Trace arguments and exception messages may contain credentials or student
    // source. Keep operational diagnostics without publishing those values.
    error_log('Unhandled exception [' . get_class($e) . '] at ' . $e->getFile() . ':' . $e->getLine() . ' code=' . $e->getCode());
    if (PHP_SAPI === 'cli') exit(1);

    $exceptionPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
    $isApi = preg_match('#/api(?:/|$)#i', $exceptionPath) === 1;
    if ($isApi) {
        if ($e instanceof \App\Core\NotFoundException) \App\Core\Response::error($e->getMessage(), 'NOT_FOUND', 404);
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

// Shared HTML/API headers and fail-closed HTTP configuration validation.
\App\Core\SecurityPolicy::apply();
if (PHP_SAPI !== 'cli') {
    $configurationErrors = \App\Core\Env::configurationErrors();
    if (\App\Core\Env::isProduction() && !\App\Core\SecurityPolicy::isHttps()) {
        $configurationErrors[] = 'Production HTTP requests require HTTPS.';
    }
    if ($configurationErrors) {
        // Names/reasons only, never secrets or full configuration values.
        error_log('Application configuration rejected: ' . implode(' ', $configurationErrors));
        $configurationPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
        if (preg_match('#/api(?:/|$)#i', $configurationPath) === 1) {
            \App\Core\Response::error('Application configuration is unavailable. Contact the administrator.', 'CONFIGURATION_UNAVAILABLE', 503);
        }
        http_response_code(503);
        header('Content-Type: text/plain; charset=utf-8');
        exit('Application configuration is unavailable. Contact the administrator.');
    }
    if (!\App\Core\SecurityPolicy::sameOriginWrite()) {
        $originPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
        if (preg_match('#/api(?:/|$)#i', $originPath) === 1) {
            \App\Core\Response::error('Cross-origin writes are not permitted.', 'ORIGIN_DENIED', 403);
        }
        http_response_code(403);
        header('Content-Type: text/plain; charset=utf-8');
        exit('Cross-origin writes are not permitted.');
    }
}

// Session initialization
\App\Core\Auth::initSession();

// Protect every HTML form endpoint, including legacy pages. API requests have
// their own JSON middleware. Never let a page-specific handler omit this check.
if (PHP_SAPI !== 'cli') {
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
    $isApi = preg_match('#/api(?:/|$)#i', $requestPath) === 1;
    // The same admission bucket covers central API, legacy API and HTML aliases.
    // Public auth/recovery and ordinary GET/HEAD/OPTIONS are not rate-written.
    if (\App\Core\RateLimiter::isExpensiveRead($_SERVER['REQUEST_METHOD'] ?? 'GET', $requestPath)
        && ($readActor = \App\Core\Auth::user())) {
        \App\Core\RateLimiter::expensiveRead((int)$readActor['id'], $isApi);
    }
    if (!$isApi) {
        if (!in_array(strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET'), ['GET', 'HEAD', 'OPTIONS'], true)
            && !\App\Core\Csrf::validate($_SERVER['HTTP_X_CSRF_TOKEN'] ?? $_POST['csrf_token'] ?? null)) {
            http_response_code(403);
            header('Content-Type: text/plain; charset=utf-8');
            exit('Invalid or expired CSRF security token. Refresh the form and try again.');
        }
        $isLogout=strtoupper($_SERVER['REQUEST_METHOD']??'GET')==='POST'&&rawurldecode($requestPath)===rawurldecode(\App\Core\AppUrl::to('logout.php'));
        if(!$isLogout&&!in_array(strtoupper($_SERVER['REQUEST_METHOD']??'GET'),['GET','HEAD','OPTIONS'],true)&&($actor=\App\Core\Auth::user())){
            \App\Core\RateLimiter::authenticatedMutation((int)$actor['id'],false);
        }
        ob_start([\App\Core\Csrf::class, 'protectHtml']);
    }
}
