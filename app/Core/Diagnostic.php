<?php
declare(strict_types=1);
namespace App\Core;

/** Operational diagnostics omit exception messages, argument values and traces. */
final class Diagnostic
{
    public static function status(\Throwable $exception): int
    {
        if ($exception instanceof NotFoundException) return 404;
        if ($exception instanceof AccessDeniedException) return 403;
        if ($exception instanceof \InvalidArgumentException) return 422;
        if ($exception instanceof \DomainException) return 503;
        if ($exception instanceof \RuntimeException && $exception->getCode()===409) return 409;
        return 500;
    }

    public static function publicMessage(\Throwable $exception): string
    {
        if (self::status($exception)!==500) return $exception->getMessage();
        self::exception($exception);
        return 'An internal server error occurred. Your changes could not be confirmed.';
    }

    public static function exception(\Throwable $exception): void
    {
        $code=(string)$exception->getCode();
        if (!preg_match('/^[A-Za-z0-9_-]{1,20}$/D', $code)) $code='UNAVAILABLE';
        error_log('Application failure ['.get_class($exception).'] at '.$exception->getFile().':'.$exception->getLine().' code='.$code);
    }
}
