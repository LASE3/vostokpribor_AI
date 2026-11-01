<?php

declare(strict_types=1);

namespace App\Core;

/** Shared response policy; same-origin APIs never grant cross-origin credentials. */
final class SecurityPolicy
{
    public static function isHttps(): bool
    {
        // Forwarded headers are attacker supplied unless the webserver itself
        // validates a trusted proxy and sets HTTPS. Do not trust them here.
        return strtolower((string)($_SERVER['HTTPS'] ?? '')) === 'on'
            || (string)($_SERVER['HTTPS'] ?? '') === '1';
    }

    public static function headers(): array
    {
        $headers = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-XSS-Protection' => '0',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), payment=(), usb=()',
            'Cache-Control' => 'private, no-store, max-age=0',
            'Content-Security-Policy' => "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: blob:; connect-src 'self'; object-src 'none'; base-uri 'self'; form-action 'self'; frame-ancestors 'self'; worker-src 'none'",
        ];
        // Approved forms use inline handlers/styles. They remain supported;
        // eval, external executable scripts, plugins and cross-origin API calls
        // are disallowed. This is not a nonce-based strict CSP.
        if (Env::isProduction() && self::isHttps()) {
            $headers['Strict-Transport-Security'] = 'max-age=31536000';
        }
        return $headers;
    }

    private static function origin(string $url): ?string
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) return null;
        $parts = parse_url($url);
        if (!$parts || !in_array($parts['scheme'] ?? '', ['http', 'https'], true)
            || isset($parts['user']) || isset($parts['pass']) || isset($parts['query']) || isset($parts['fragment'])
            || (isset($parts['path']) && $parts['path'] !== '')) return null;
        $scheme = strtolower($parts['scheme']);
        $port = (int)($parts['port'] ?? ($scheme === 'https' ? 443 : 80));
        return $scheme . '://' . strtolower($parts['host']) . ':' . $port;
    }

    /** Browser origins are checked in addition to mandatory CSRF on writes. */
    public static function sameOriginWrite(): bool
    {
        if (in_array(strtoupper((string)($_SERVER['REQUEST_METHOD'] ?? 'GET')), ['GET', 'HEAD', 'OPTIONS'], true)
            || !isset($_SERVER['HTTP_ORIGIN'])) return true;
        $actual = self::origin((self::isHttps() ? 'https' : 'http') . '://' . (string)($_SERVER['HTTP_HOST'] ?? ''));
        $supplied = self::origin((string)$_SERVER['HTTP_ORIGIN']);
        return $actual !== null && $supplied !== null && hash_equals($actual, $supplied);
    }

    public static function apply(): void
    {
        if (PHP_SAPI === 'cli') return;
        foreach (self::headers() as $key => $value) header($key . ': ' . $value);
        header_remove('X-Powered-By');
    }
}
