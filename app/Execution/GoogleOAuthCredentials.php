<?php
declare(strict_types=1);

namespace App\Execution;

use RuntimeException;
use Throwable;

/** Explicit outside-webroot Google credentials; no ADC discovery, metadata access or disk token cache. */
final class GoogleOAuthCredentials
{
    private const TOKEN_ENDPOINT = 'https://oauth2.googleapis.com/token';
    private array $credentials;
    private $transport;
    private $clock;
    private string $scope;
    private ?string $accessToken = null;
    private int $expiresAt = 0;

    public function __construct(string $file, ?callable $transport = null, ?callable $clock = null, string $scope = 'https://www.googleapis.com/auth/cloud-platform')
    {
        $this->credentials = self::readFile($file);
        $scopes = explode(' ', $scope);
        $allowed = ['https://www.googleapis.com/auth/cloud-platform', 'https://www.googleapis.com/auth/colaboratory', 'https://www.googleapis.com/auth/colaboratory.readonly'];
        if (strlen($scope) > 512 || !$scopes || array_diff($scopes, $allowed)) {
            throw new RuntimeException('Google provider OAuth scope is not permitted.', 503);
        }
        $this->scope = $scope;
        $this->transport = $transport ?? [GoogleHttpTransport::class, 'request'];
        $this->clock = $clock ?? static fn(): int => time();
        $this->validateCredentials();
    }

    public function getAccessToken(): string
    {
        $now = ($this->clock)();
        if (!is_int($now) || $now < 0 || $now > 4102444800) {
            throw new RuntimeException('Google provider credential clock is unavailable.', 503);
        }
        if ($this->accessToken !== null && $this->expiresAt > $now + 60) {
            return $this->accessToken;
        }
        // Clear expired state before a refresh; a failed refresh must not reuse a stale token.
        $this->accessToken = null;
        $this->expiresAt = 0;
        try {
            if ($this->credentials['type'] === 'authorized_user') {
                $parameters = [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $this->credentials['refresh_token'],
                    'client_id' => $this->credentials['client_id'],
                    'client_secret' => $this->credentials['client_secret'],
                ];
            } else {
                $parameters = ['grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer', 'assertion' => $this->assertion($now)];
            }
            $response = ($this->transport)('POST', self::TOKEN_ENDPOINT, ['Content-Type' => 'application/x-www-form-urlencoded', 'Accept' => 'application/json'], http_build_query($parameters, '', '&', PHP_QUERY_RFC3986));
            if (!is_array($response) || ($response['status'] ?? null) !== 200 || !is_string($response['body'] ?? null)
                || strlen($response['body']) > GoogleHttpTransport::MAX_RESPONSE_BYTES) {
                throw new RuntimeException('OAuth response rejected.');
            }
            $data = json_decode($response['body'], true, 16, JSON_THROW_ON_ERROR);
            if (!is_array($data) || !is_string($data['access_token'] ?? null)
                || !preg_match('/^[A-Za-z0-9._~+\/-]{1,8192}={0,2}$/D', $data['access_token'])
                || !is_string($data['token_type'] ?? null) || strcasecmp($data['token_type'], 'Bearer') !== 0
                || !(is_int($data['expires_in'] ?? null) || (is_string($data['expires_in'] ?? null) && preg_match('/^[0-9]{1,5}$/D', $data['expires_in'])))
                || (int)$data['expires_in'] < 1 || (int)$data['expires_in'] > 43200) {
                throw new RuntimeException('OAuth token rejected.');
            }
            $this->accessToken = $data['access_token'];
            $this->expiresAt = $now + (int)$data['expires_in'];
            return $this->accessToken;
        } catch (Throwable) {
            // No response body, filesystem path, assertion, refresh token or chained exception is disclosed.
            throw new RuntimeException('Google provider credentials could not be refreshed.', 503);
        }
    }

    private static function readFile(string $file): array
    {
        $normalized = str_replace('\\', '/', $file);
        $root = str_replace('\\', '/', dirname(__DIR__, 2));
        if ($file === '' || str_contains($file, "\0") || str_contains($normalized, '://') || str_starts_with($normalized, '//')
            || !preg_match('~^(?:[A-Za-z]:/|/)~', $normalized)) {
            throw new RuntimeException('An explicit private Google credential file is required.', 503);
        }
        $real = realpath($file);
        if ($real === false || is_link($file) || !is_file($real) || !is_readable($real)) {
            throw new RuntimeException('An explicit private Google credential file is required.', 503);
        }
        foreach ([$normalized, str_replace('\\', '/', $real)] as $candidate) {
            if (self::inside($candidate, $root) || self::inside($candidate, 'C:/xampp/htdocs')
                || preg_match('~/(?:htdocs|public_html|wwwroot)(?:/|$)~i', $candidate)) {
                throw new RuntimeException('Google credential files must remain outside source and web roots.', 503);
            }
        }
        $size = @filesize($real);
        if ($size === false || $size < 2 || $size > 131072) {
            throw new RuntimeException('Google credential file is invalid.', 503);
        }
        try {
            $contents = @file_get_contents($real, false, null, 0, 131073);
            if ($contents === false || strlen($contents) > 131072) {
                throw new RuntimeException('Credential read failed.');
            }
            $data = json_decode($contents, true, 16, JSON_THROW_ON_ERROR);
            if (!is_array($data) || array_is_list($data)) {
                throw new RuntimeException('Credential format rejected.');
            }
            return $data;
        } catch (Throwable) {
            throw new RuntimeException('Google credential file is invalid.', 503);
        }
    }

    private static function inside(string $path, string $root): bool
    {
        return str_starts_with(strtolower(rtrim($path, '/') . '/'), strtolower(rtrim($root, '/') . '/'));
    }

    private function validateCredentials(): void
    {
        $type = $this->credentials['type'] ?? null;
        if (($this->credentials['universe_domain'] ?? 'googleapis.com') !== 'googleapis.com') {
            throw new RuntimeException('Google credential universe is not supported.', 503);
        }
        if ($type === 'authorized_user') {
            foreach (['client_id', 'client_secret', 'refresh_token'] as $key) {
                if (!is_string($this->credentials[$key] ?? null) || strlen($this->credentials[$key]) < 1
                    || strlen($this->credentials[$key]) > 8192 || preg_match('/[^\x21-\x7e]/', $this->credentials[$key])) {
                    throw new RuntimeException('Google user credentials are invalid.', 503);
                }
            }
            if (!preg_match('/^[A-Za-z0-9_.-]{5,256}\.apps\.googleusercontent\.com$/D', $this->credentials['client_id'])) {
                throw new RuntimeException('Google OAuth client identity is invalid.', 503);
            }
        } elseif ($type === 'service_account') {
            if (!function_exists('openssl_pkey_get_private') || !function_exists('openssl_sign')) {
                throw new RuntimeException('Google service account signing is unavailable.', 503);
            }
            if (($this->credentials['token_uri'] ?? null) !== self::TOKEN_ENDPOINT
                || !is_string($this->credentials['client_email'] ?? null)
                || !preg_match('/^[A-Za-z0-9._-]+@[a-z][a-z0-9-]{1,62}\.iam\.gserviceaccount\.com$/D', $this->credentials['client_email'])
                || !is_string($this->credentials['private_key'] ?? null)) {
                throw new RuntimeException('Google service account credentials are invalid.', 503);
            }
            $key = @openssl_pkey_get_private($this->credentials['private_key']);
            $details = $key !== false ? openssl_pkey_get_details($key) : false;
            if (!$details || $details['type'] !== OPENSSL_KEYTYPE_RSA || $details['bits'] < 2048) {
                throw new RuntimeException('Google service account signing key is invalid.', 503);
            }
        } else {
            throw new RuntimeException('Google credential type is not supported.', 503);
        }
    }

    private function assertion(int $now): string
    {
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        if (isset($this->credentials['private_key_id']) && is_string($this->credentials['private_key_id'])
            && preg_match('/^[A-Za-z0-9_-]{1,128}$/D', $this->credentials['private_key_id'])) {
            $header['kid'] = $this->credentials['private_key_id'];
        }
        $claims = ['iss' => $this->credentials['client_email'], 'scope' => $this->scope, 'aud' => self::TOKEN_ENDPOINT, 'iat' => $now, 'exp' => $now + 3600];
        $unsigned = self::base64url(json_encode($header, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR)) . '.'
            . self::base64url(json_encode($claims, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
        if (!@openssl_sign($unsigned, $signature, $this->credentials['private_key'], OPENSSL_ALGO_SHA256)) {
            throw new RuntimeException('Google provider assertion could not be signed.', 503);
        }
        return $unsigned . '.' . self::base64url($signature);
    }

    private static function base64url(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
