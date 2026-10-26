<?php

namespace App\Middleware;

use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;

class CsrfMiddleware
{
    public static function handle(Request $request): void
    {
        $method = $request->getMethod();
        if (in_array($method, ['GET', 'HEAD', 'OPTIONS'])) {
            return;
        }

        $token = $request->header('x-csrf-token') ?? $request->body('csrf_token');

        if (!Csrf::validate($token)) {
            Response::error('Invalid or expired CSRF security token.', 'CSRF_MISMATCH', 403);
        }
    }
}
