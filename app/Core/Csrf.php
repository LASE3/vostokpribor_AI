<?php

namespace App\Core;

class Csrf
{
    public static function getToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            Auth::initSession();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function validate(mixed $token): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            Auth::initSession();
        }

        if (empty($_SESSION['csrf_token']) || !is_string($token) || $token === '') {
            return false;
        }

        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /** Add tokens to the existing server-rendered forms without changing layout. */
    public static function protectHtml(string $html): string
    {
        if (!str_contains(strtolower($html), '<html')) return $html;
        $token = htmlspecialchars(self::getToken(), ENT_QUOTES, 'UTF-8');
        if (!preg_match('/<meta\s+[^>]*name=["\']csrf-token["\']/i', $html)) {
            $html = preg_replace('/<head\b[^>]*>/i', '$0<meta name="csrf-token" content="' . $token . '">', $html, 1);
        }
        return preg_replace_callback('/(<form\b[^>]*\bmethod\s*=\s*["\']?post["\']?[^>]*>)(.*?)(<\/form>)/is', function ($match) use ($token) {
            if (preg_match('/name\s*=\s*["\']csrf_token["\']/i', $match[2])) return $match[0];
            return $match[1] . '<input type="hidden" name="csrf_token" value="' . $token . '">' . $match[2] . $match[3];
        }, $html);
    }
}
