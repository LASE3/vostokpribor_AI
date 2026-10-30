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
                Response::redirect(\App\Core\AppUrl::to('login.php') . '?redirect=' . $returnUrl);
            }
        }
        if (!empty($user['must_change_password'])) {
            $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';
            $allowed = $isApi
                ? preg_match('#/api/v1/auth/(me|change-password|logout)/?$#D', $path)
                : in_array(basename($path), ['change-password.php', 'logout.php'], true);
            if (!$allowed) {
                if ($isApi) {
                    Response::error('Change your initial password before continuing.', 'PASSWORD_CHANGE_REQUIRED', 403);
                }
                Response::redirect(\App\Core\AppUrl::to('change-password.php'));
            }
        }
        return $user;
    }
}
