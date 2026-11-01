<?php
declare(strict_types=1);
/** Offline contract tests. Synthetic credentials/responses only; no Google request, session or database. */
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__ . '/../app/Execution/GoogleHttpTransport.php';
require_once __DIR__ . '/../app/Execution/GoogleOAuthCredentials.php';

use App\Execution\GoogleHttpTransport;
use App\Execution\GoogleOAuthCredentials;

$passed = 0;
$check = static function (bool $condition, string $label) use (&$passed): void {
    if (!$condition) { throw new RuntimeException('FAIL ' . $label); }
    $passed++;
    echo 'PASS ' . $label . PHP_EOL;
};
$reject = static function (callable $call, string $label) use ($check): void {
    try { $call(); } catch (RuntimeException $error) {
        $check($error->getCode() >= 500 && !str_contains($error->getMessage(), 'sensitive-provider-error'), $label);
        return;
    }
    $check(false, $label);
};
$directory = sys_get_temp_dir() . '/vostok_google_auth_contract_' . bin2hex(random_bytes(8));
if (!mkdir($directory, 0700)) { throw new RuntimeException('Could not create own isolated credential fixture directory.'); }
$ownedFiles = [];
$fixture = static function (array|string $data) use ($directory, &$ownedFiles): string {
    $file = $directory . '/' . bin2hex(random_bytes(8)) . '.json';
    if (file_put_contents($file, is_array($data) ? json_encode($data, JSON_THROW_ON_ERROR) : $data, LOCK_EX) === false) {
        throw new RuntimeException('Could not write synthetic credential fixture.');
    }
    chmod($file, 0600);
    $ownedFiles[] = $file;
    return $file;
};
try {
    $user = [
        'type' => 'authorized_user',
        'client_id' => '1234567890-contract.apps.googleusercontent.com',
        'client_secret' => bin2hex(random_bytes(24)),
        'refresh_token' => bin2hex(random_bytes(32)),
    ];
    $file = $fixture($user);
    $now = 1800000000;
    $clock = static function () use (&$now): int { return $now; };
    $requests = [];
    $tokens = [bin2hex(random_bytes(32)), bin2hex(random_bytes(32))];
    $transport = static function (string $method, string $url, array $headers, ?string $body) use (&$requests, $tokens): array {
        $requests[] = compact('method', 'url', 'headers', 'body');
        return ['status' => 200, 'body' => json_encode(['access_token' => $tokens[count($requests) - 1], 'token_type' => 'Bearer', 'expires_in' => 3600], JSON_THROW_ON_ERROR)];
    };
    $credentials = new GoogleOAuthCredentials($file, $transport, $clock);
    $check(count($requests) === 0, 'loading explicit synthetic credentials causes no network request');
    $check($credentials->getAccessToken() === $tokens[0], 'OAuth refresh contract returns actual synthetic response token');
    $request = $requests[0];
    parse_str($request['body'], $parameters);
    $check($request['method'] === 'POST' && $request['url'] === 'https://oauth2.googleapis.com/token', 'refresh targets fixed documented token endpoint');
    $check($request['headers']['Content-Type'] === 'application/x-www-form-urlencoded', 'refresh uses form-encoded OAuth request');
    $check($parameters === ['grant_type' => 'refresh_token', 'refresh_token' => $user['refresh_token'], 'client_id' => $user['client_id'], 'client_secret' => $user['client_secret']], 'refresh sends intended credential fields only');
    $check($credentials->getAccessToken() === $tokens[0] && count($requests) === 1, 'unexpired access token is cached in memory');
    $now += 3539;
    $check($credentials->getAccessToken() === $tokens[0] && count($requests) === 1, 'token remains usable before sixty-second refresh margin');
    $now += 1;
    $check($credentials->getAccessToken() === $tokens[1] && count($requests) === 2, 'token refreshes at sixty-second expiry margin');
    $check(count(glob($directory . '/*')) === 1, 'refresh creates no disk token cache');

    foreach ([
        ['status' => 401, 'body' => '{"error":"sensitive-provider-error"}'],
        ['status' => 429, 'body' => '{"error":"quota_exceeded"}'],
        ['status' => 500, 'body' => 'sensitive-provider-error'],
        ['status' => 200, 'body' => '{'],
        ['status' => 200, 'body' => '[]'],
        ['status' => 200, 'body' => json_encode(['access_token' => 'invalid token', 'token_type' => 'Bearer', 'expires_in' => 3600])],
        ['status' => 200, 'body' => json_encode(['access_token' => $tokens[0], 'token_type' => 'Basic', 'expires_in' => 3600])],
        ['status' => 200, 'body' => json_encode(['access_token' => $tokens[0], 'token_type' => 'Bearer', 'expires_in' => 0])],
        ['status' => 200, 'body' => json_encode(['access_token' => $tokens[0], 'token_type' => 'Bearer', 'expires_in' => 999999])],
        ['status' => 200, 'body' => str_repeat('x', GoogleHttpTransport::MAX_RESPONSE_BYTES + 1)],
    ] as $index => $response) {
        $reject(static fn() => (new GoogleOAuthCredentials($file, static fn() => $response, $clock))->getAccessToken(), 'invalid OAuth response ' . $index . ' is rejected without provider detail disclosure');
    }
    $reject(static fn() => (new GoogleOAuthCredentials($file, static function (): array { throw new RuntimeException('sensitive-provider-error'); }, $clock))->getAccessToken(), 'transport exception is sanitized without chained provider error');
    $refreshCount = 0;
    $flaky = new GoogleOAuthCredentials($file, static function () use (&$refreshCount, $tokens): array {
        $refreshCount++;
        return $refreshCount === 1
            ? ['status' => 200, 'body' => json_encode(['access_token' => $tokens[0], 'token_type' => 'Bearer', 'expires_in' => 120])]
            : ['status' => 401, 'body' => '{"error":"revoked"}'];
    }, $clock);
    $check($flaky->getAccessToken() === $tokens[0], 'synthetic short-lived token initially accepted');
    $now += 60;
    $reject(static fn() => $flaky->getAccessToken(), 'revoked refresh does not return cached token');
    $reject(static fn() => $flaky->getAccessToken(), 'failed refresh leaves no reusable stale token');
    $check($refreshCount === 3, 'each attempt after failed refresh must obtain fresh credentials');

    $reject(static fn() => new GoogleOAuthCredentials(dirname(__DIR__) . '/.env', $transport), 'actual source credential/configuration path refused before reading');
    $reject(static fn() => new GoogleOAuthCredentials('C:/xampp/htdocs/nonexistent-private.json', $transport), 'webroot credential path refused');
    $reject(static fn() => new GoogleOAuthCredentials('php://memory', $transport), 'stream-wrapper credential source refused');
    $reject(static fn() => new GoogleOAuthCredentials('relative-credentials.json', $transport), 'relative credential source refused');
    $reject(static fn() => new GoogleOAuthCredentials($file . "\0", $transport), 'null-byte credential path refused with safe provider error');
    $reject(static fn() => new GoogleOAuthCredentials($fixture(str_repeat('x', 131073)), $transport), 'credential file larger than128KiB refused');
    $reject(static fn() => new GoogleOAuthCredentials($fixture('{'), $transport), 'malformed credential JSON refused');
    $reject(static fn() => new GoogleOAuthCredentials($fixture(['type' => 'external_account', 'credential_source' => ['url' => 'http://169.254.169.254/']]), $transport), 'external/metadata credential discovery refused');
    $reject(static fn() => new GoogleOAuthCredentials($fixture(array_merge($user, ['universe_domain' => 'attacker.invalid'])), $transport), 'alternate credential universe refused');
    $reject(static fn() => new GoogleOAuthCredentials($fixture(array_merge($user, ['refresh_token' => "bad\r\nvalue"])), $transport), 'credential newline injection refused');
    $reject(static fn() => new GoogleOAuthCredentials($file, $transport, $clock, 'https://attacker.invalid/scope'), 'unknown OAuth scope refused');

    $opensslConfig = $directory . '/openssl.cnf';
    file_put_contents($opensslConfig, "[req]\ndistinguished_name = req_distinguished_name\n[req_distinguished_name]\n");
    $ownedFiles[] = $opensslConfig;
    $keyOptions = ['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA, 'config' => $opensslConfig];
    $privateKey = openssl_pkey_new($keyOptions);
    if ($privateKey === false || !openssl_pkey_export($privateKey, $pem, null, $keyOptions)) { throw new RuntimeException('Could not create ephemeral synthetic RSA key.'); }
    $service = ['type' => 'service_account', 'client_email' => 'execution-contract@vostok-contract.iam.gserviceaccount.com', 'private_key_id' => bin2hex(random_bytes(20)), 'private_key' => $pem, 'token_uri' => 'https://oauth2.googleapis.com/token'];
    $jwtRequests = [];
    $jwtCredentials = new GoogleOAuthCredentials($fixture($service), static function (string $method, string $url, array $headers, ?string $body) use (&$jwtRequests, $tokens): array {
        $jwtRequests[] = compact('method', 'url', 'headers', 'body');
        return ['status' => 200, 'body' => json_encode(['access_token' => $tokens[0], 'token_type' => 'Bearer', 'expires_in' => '3600'])];
    }, $clock);
    $check($jwtCredentials->getAccessToken() === $tokens[0], 'service-account OAuth response accepted from offline fixture');
    parse_str($jwtRequests[0]['body'], $jwtParameters);
    $check($jwtParameters['grant_type'] === 'urn:ietf:params:oauth:grant-type:jwt-bearer', 'service-account request uses documented JWT bearer grant');
    [$encodedHeader, $encodedClaims, $encodedSignature] = explode('.', $jwtParameters['assertion']);
    $decode = static fn(string $value): string => base64_decode(strtr($value, '-_', '+/'), true);
    $jwtHeader = json_decode($decode($encodedHeader), true, 16, JSON_THROW_ON_ERROR);
    $claims = json_decode($decode($encodedClaims), true, 16, JSON_THROW_ON_ERROR);
    $check($jwtHeader['alg'] === 'RS256' && $jwtHeader['kid'] === $service['private_key_id'], 'JWT uses RS256 and the configured key identifier');
    $check($claims === ['iss' => $service['client_email'], 'scope' => 'https://www.googleapis.com/auth/cloud-platform', 'aud' => 'https://oauth2.googleapis.com/token', 'iat' => $now, 'exp' => $now + 3600], 'JWT binds intended identity scope audience and one-hour lifetime without delegated subject');
    $publicKey = openssl_pkey_get_details($privateKey)['key'];
    $check(openssl_verify($encodedHeader . '.' . $encodedClaims, $decode($encodedSignature), $publicKey, OPENSSL_ALGO_SHA256) === 1, 'actual ephemeral RSA public key verifies generated JWT signature');
    $reject(static fn() => new GoogleOAuthCredentials($fixture(array_merge($service, ['token_uri' => 'https://attacker.invalid/token'])), $transport), 'service-account credential cannot redirect JWT to arbitrary token endpoint');
    $reject(static fn() => new GoogleOAuthCredentials($fixture(array_merge($service, ['private_key' => 'invalid key'])), $transport), 'invalid signing key refused');

    // Exercise the production target validator without making any network connection.
    $target = new ReflectionMethod(GoogleHttpTransport::class, 'validateTarget');
    foreach ([
        ['POST', 'https://oauth2.googleapis.com/token', 'grant_type=fixture'],
        ['GET', 'https://us-central1-aiplatform.googleapis.com/v1/projects/contract/locations/us-central1/notebookExecutionJobs/job', null],
        ['GET', 'https://storage.googleapis.com/storage/v1/b/contract/o/output.ipynb?alt=media', null],
    ] as $arguments) {
        $target->invoke(null, ...$arguments);
        $check(true, 'documented fixed Google target accepted offline: ' . $arguments[0] . ' ' . parse_url($arguments[1], PHP_URL_HOST));
    }
    foreach ([
        ['POST', 'http://oauth2.googleapis.com/token', null],
        ['POST', 'https://oauth2.googleapis.com/token?redirect=1', null],
        ['POST', 'https://oauth2.googleapis.com.attacker.invalid/token', null],
        ['POST', 'https://user:secret@oauth2.googleapis.com/token', null],
        ['POST', 'https://oauth2.googleapis.com:443/token', null],
        ['POST', 'https://oauth2.googleapis.com/token#fragment', null],
        ['GET', 'https://169.254.169.254/computeMetadata/v1/', null],
        ['GET', 'https://localhost/private', null],
        ['GET', 'https://aiplatform.googleapis.com/v1/projects/contract', null],
        ['GET', 'https://us-central1-aiplatform.googleapis.com.attacker.invalid/v1/projects/contract', null],
        ['POST', 'https://storage.googleapis.com/storage/v1/b/contract/o', '{}'],
        ['DELETE', 'https://storage.googleapis.com/storage/v1/b/contract/o/output', null],
        ['GET', 'https://us-central1-aiplatform.googleapis.com/v1/projects/contract', '{}'],
        ['POST', 'https://us-central1-aiplatform.googleapis.com/v1/projects/contract', str_repeat('x', GoogleHttpTransport::MAX_REQUEST_BYTES + 1)],
    ] as $index => $arguments) {
        $reject(static fn() => GoogleHttpTransport::request($arguments[0], $arguments[1], [], $arguments[2]), 'disallowed transport target/body ' . $index . ' rejected before network');
    }
    $reject(static fn() => GoogleHttpTransport::request('POST', 'https://oauth2.googleapis.com/token', ['Authorization' => "Bearer value\r\nInjected: yes"], ''), 'outbound header injection refused before network');
    $reject(static fn() => GoogleHttpTransport::request('POST', 'https://oauth2.googleapis.com/token', ['Host' => 'attacker.invalid'], ''), 'caller cannot override TLS destination through Host header');
    $reject(static fn() => GoogleHttpTransport::request('POST', 'https://oauth2.googleapis.com/token', ['Cookie' => 'session=fixture'], ''), 'browser cookies cannot be sent to Google provider');
    echo 'PASS ALL ' . $passed . ' offline Google OAuth/HTTPS contracts; synthetic credentials only; no Google call, database or application session.' . PHP_EOL;
} finally {
    foreach ($ownedFiles as $owned) {
        if (dirname($owned) === $directory && is_file($owned)) { unlink($owned); }
    }
    if (is_dir($directory)) { rmdir($directory); }
}
