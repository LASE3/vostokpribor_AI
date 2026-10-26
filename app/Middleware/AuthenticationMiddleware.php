<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Response;

class AuthenticationMiddleware
{
    public static function handle(bool $isApi = false): ?array
    {
        $user = Auth::user();
        if (!$user) {
            if ($isApi) {
                Response::error('Authentication required. Please log in.', 'UNAUTHORIZED', 401);
            } else {
                $returnUrl = urlencode($_SERVER['REQUEST_URI'] ?? '/vostokpribor_AI/index.php');
                Response::redirect('/vostokpribor_AI/login.php?redirect=' . $returnUrl);
            }
        }
        return $user;
    }
}
