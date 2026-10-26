<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\RateLimiter;
use App\Core\Logger;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;

class AuthController
{
    public function csrf(Request $request): void
    {
        header('Cache-Control: no-store');
        Response::success(['csrf_token' => Csrf::getToken()]);
    }

    public function changePassword(Request $request): void
    {
        AuthenticationMiddleware::handle(true);
        try {
            Auth::changePassword((string)$request->body('current_password', ''), (string)$request->body('new_password', ''));
            Response::success(['csrf_token' => Csrf::getToken()], 'Password changed successfully');
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        }
    }

    public function login(Request $request): void
    {
        $login = trim((string)$request->body('login', ''));
        $password = (string)$request->body('password', '');
        if (!Csrf::validate($request->header('x-csrf-token') ?? $request->body('csrf_token'))) {
            Response::error('Invalid or expired CSRF security token.', 'CSRF_MISMATCH', 403);
        }

        $clientIp = $request->clientIp();
        $rateKey = "api_login_attempt_{$clientIp}";

        if (!RateLimiter::check($rateKey, 5, 120)) {
            Response::error('Too many failed attempts. Ingress throttled.', 'RATE_LIMITED', 429);
        }

        if (empty($login) || empty($password)) {
            Response::error('Login and password are required.', 'VALIDATION_ERROR', 422);
        }

        $user = Auth::attempt($login, $password);
        if ($user === null) {
            RateLimiter::hit($rateKey, 120);
            Logger::audit('LOGIN_FAILED', 'users', $login, 'FAILURE', ['ip' => $clientIp]);
            Response::error('Invalid credentials.', 'INVALID_CREDENTIALS', 401);
        }

        if (isset($user['status_error'])) {
            Response::error('Account is deactivated or suspended.', 'ACCOUNT_INACTIVE', 403);
        }

        RateLimiter::clear($rateKey);
        Logger::audit('LOGIN_SUCCESS', 'users', (string)$user['id'], 'SUCCESS', [
            'role' => $user['role'],
            'ip'   => $clientIp
        ]);

        Response::success([
            'id'         => (int)$user['id'],
            'role'       => $user['role'],
            'email'      => $user['email'],
            'full_name'  => $user['full_name'],
            'identifier' => $user['identifier'],
            'must_change_password' => (bool)$user['must_change_password'],
            'csrf_token' => Csrf::getToken()
        ], 'Authenticated successfully');
    }

    public function logout(Request $request): void
    {
        $user = Auth::user();
        if ($user) {
            Logger::audit('LOGOUT', 'users', (string)$user['id'], 'SUCCESS');
        }
        Auth::logout();
        Response::success(null, 'Logged out successfully');
    }

    public function me(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        Response::success([
            'id'                   => (int)$user['id'],
            'role'                 => $user['role'],
            'email'                => $user['email'],
            'full_name'            => $user['full_name'],
            'identifier'           => $user['identifier'],
            'cohort'               => $user['cohort'],
            'department'           => $user['department'],
            'status'               => $user['status'],
            'must_change_password' => (bool)$user['must_change_password'],
            'csrf_token'           => Csrf::getToken()
        ]);
    }
}
