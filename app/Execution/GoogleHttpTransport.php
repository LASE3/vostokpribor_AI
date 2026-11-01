<?php
declare(strict_types=1);

namespace App\Execution;

use RuntimeException;

/** Small, bounded server-side Google transport. It never follows redirects or uses a proxy. */
final class GoogleHttpTransport
{
    public const MAX_RESPONSE_BYTES = 2097152;
    public const MAX_REQUEST_BYTES = 2097152;

    /** @return array{status:int,body:string} */
    public static function request(string $method, string $url, array $headers = [], ?string $body = null): array
    {
        self::validateTarget($method, $url, $body);
        $httpHeaders = self::headers($headers);
        if (!function_exists('curl_init')) {
            throw new RuntimeException('Google provider HTTPS transport is unavailable.', 503);
        }
        $handle = curl_init($url);
        if ($handle === false) {
            throw new RuntimeException('Google provider HTTPS transport is unavailable.', 503);
        }
        $response = '';
        $oversized = false;
        try {
            curl_setopt_array($handle, [
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_HTTPHEADER => $httpHeaders,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_MAXREDIRS => 0,
                CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,
                CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTPS,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_PROXY => '',
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FAILONERROR => false,
                CURLOPT_HEADER => false,
                CURLOPT_WRITEFUNCTION => static function ($unused, string $chunk) use (&$response, &$oversized): int {
                    if (strlen($response) + strlen($chunk) > self::MAX_RESPONSE_BYTES) {
                        $oversized = true;
                        return 0;
                    }
                    $response .= $chunk;
                    return strlen($chunk);
                },
            ]);
            if ($body !== null) {
                curl_setopt($handle, CURLOPT_POSTFIELDS, $body);
            }
            if ($method === 'HEAD') {
                curl_setopt($handle, CURLOPT_NOBODY, true);
            }
            $complete = curl_exec($handle);
            $status = (int)curl_getinfo($handle, CURLINFO_RESPONSE_CODE);
            if ($oversized) {
                throw new RuntimeException('Google provider response exceeds the permitted size.', 502);
            }
            if ($complete === false || $status < 100 || $status > 599) {
                // curl_error may contain addresses or authentication material: do not propagate it.
                throw new RuntimeException('Google provider HTTPS request did not complete.', 503);
            }
            return ['status' => $status, 'body' => $response];
        } finally {
            curl_close($handle);
        }
    }

    private static function validateTarget(string $method, string $url, ?string $body): void
    {
        $parts = parse_url($url);
        if (!in_array($method, ['GET', 'HEAD', 'POST', 'DELETE'], true)
            || strlen($url) > 8192 || preg_match('/[\x00-\x20\x7f]/', $url)
            || !$parts || ($parts['scheme'] ?? '') !== 'https'
            || isset($parts['user']) || isset($parts['pass']) || isset($parts['fragment']) || isset($parts['port'])) {
            throw new RuntimeException('Google provider request target is not permitted.', 503);
        }
        $host = $parts['host'] ?? '';
        $path = $parts['path'] ?? '';
        $token = $host === 'oauth2.googleapis.com' && $path === '/token' && !isset($parts['query']) && $method === 'POST';
        $enterprise = preg_match('/^[a-z][a-z0-9-]{0,62}-aiplatform\.googleapis\.com$/D', $host) === 1
            && str_starts_with($path, '/v1/');
        $storage = $host === 'storage.googleapis.com' && str_starts_with($path, '/storage/v1/b/')
            && in_array($method, ['GET', 'HEAD'], true);
        if (!$token && !$enterprise && !$storage) {
            throw new RuntimeException('Google provider request target is not permitted.', 503);
        }
        if (($body !== null && strlen($body) > self::MAX_REQUEST_BYTES)
            || ($body !== null && in_array($method, ['GET', 'HEAD', 'DELETE'], true))) {
            throw new RuntimeException('Google provider request body is not permitted.', 503);
        }
    }

    /** Accept associative headers or ordinary curl header lines without allowing CRLF injection. */
    private static function headers(array $headers): array
    {
        $result = [];
        foreach ($headers as $key => $value) {
            if (!is_string($value) || strlen($value) > 16384 || strpbrk($value, "\r\n\0") !== false) {
                throw new RuntimeException('Google provider request headers are not permitted.', 503);
            }
            if (is_int($key)) {
                $pair = explode(':', $value, 2);
                if (count($pair) !== 2) {
                    throw new RuntimeException('Google provider request headers are not permitted.', 503);
                }
                [$key, $value] = $pair;
                $value = ltrim($value);
            }
            if (!is_string($key) || !preg_match('/^[A-Za-z][A-Za-z0-9-]*$/D', $key)
                || !in_array(strtolower($key), ['authorization', 'content-type', 'accept', 'user-agent', 'x-goog-user-project', 'x-goog-request-params', 'if-match', 'if-none-match'], true)) {
                throw new RuntimeException('Google provider request headers are not permitted.', 503);
            }
            $result[] = $key . ': ' . $value;
        }
        return $result;
    }
}
