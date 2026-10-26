<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Response;
use App\Core\Logger;

class AuthorizationMiddleware
{
    public static function requireRole(string|array $roles, bool $isApi = false): void
    {
        $user = AuthenticationMiddleware::handle($isApi);
        $userRole = strtoupper((string)($user['role'] ?? ''));
        $allowed = array_map('strtoupper', is_array($roles) ? $roles : [$roles]);

        if (!in_array($userRole, $allowed, true)) {
            Logger::audit(
                'ACCESS_DENIED',
                'route',
                $_SERVER['REQUEST_URI'] ?? '',
                'DENIED',
                ['user_role' => $user['role'], 'required_roles' => $allowed]
            );

            if ($isApi) {
                Response::error('Access denied. Insufficient privileges.', 'FORBIDDEN', 403);
            } else {
                http_response_code(403);
                header('Content-Type: text/html; charset=utf-8');
                exit('<!doctype html><html><head><title>Access denied</title></head><body><h1>Access denied</h1><p>This system requires an administrator account.</p><a href="/vostokpribor_AI/index.php">Return to the range</a></body></html>');
            }
        }
    }

    public static function requireAdmin(bool $isApi = false): void
    {
        self::requireRole('ADMIN', $isApi);
    }

    public static function requireStudent(bool $isApi = false): void
    {
        self::requireRole('STUDENT', $isApi);
    }

    public static function assertOwnership(int $resourceOwnerId, bool $isApi = false): void
    {
        $user = AuthenticationMiddleware::handle($isApi);

        // Admins can inspect any student resource
        if (strtoupper((string)($user['role'] ?? '')) === 'ADMIN') {
            return;
        }

        if ((int)$user['id'] !== $resourceOwnerId) {
            Logger::audit(
                'OBJECT_ACCESS_DENIED',
                'resource',
                (string)$resourceOwnerId,
                'DENIED',
                ['requesting_user_id' => $user['id'], 'owner_id' => $resourceOwnerId]
            );

            if ($isApi) {
                Response::error('Access denied. You do not have permission to access this resource.', 'FORBIDDEN', 403);
            } else {
                http_response_code(403);
                header('Content-Type: text/plain; charset=utf-8');
                exit('Access denied. You do not have permission to access this resource.');
            }
        }
    }
}
