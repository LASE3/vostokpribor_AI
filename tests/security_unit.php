<?php
declare(strict_types=1);
// These checks have no database connection and cannot mutate installation data.
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
foreach (['Env', 'Database', 'Auth', 'Csrf'] as $class) {
    require_once __DIR__ . '/../app/Core/' . $class . '.php';
}
use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Database;
use App\Core\Env;

$checks = [];
$check = function (bool $condition, string $label) use (&$checks): void {
    if (!$condition) throw new RuntimeException('FAIL: ' . $label);
    $checks[] = $label;
};
$throws = function (callable $callback, string $label) use ($check): void {
    try { $callback(); } catch (InvalidArgumentException $e) { $check(true, $label); return; }
    $check(false, $label);
};
putenv('APP_ENV=testing');
putenv('DB_NAME=security_unit_test');
putenv('DB_USER=security_unit'); // no connection is ever attempted
putenv('APP_URL=http://localhost/vostokpribor_AI');
Env::load(__DIR__ . '/../.env');
$check(Env::get('APP_ENV') === 'testing' && Env::get('DB_NAME') === 'security_unit_test', 'Process testing environment overrides .env');
putenv('DB_NAME=security_unit_live');
try { Database::getConnection(); $check(false, 'Testing must not attach a live database'); }
catch (RuntimeException $e) { $check(str_contains($e->getMessage(), 'ending in _test'), 'Testing database suffix enforced before connecting'); }
putenv('DB_NAME=security_unit_test');
$db = Database::getInstance();
$throws(fn() => $db->insert('INSERT INTO users (id) VALUES (1)', []), 'Raw SQL rejected by insert');
$throws(fn() => $db->insert('users', ['id; DROP TABLE users' => 1]), 'Invalid column rejected');
$throws(fn() => $db->update('users', ['id' => 1]), 'Update requires explicit WHERE');
$throws(fn() => $db->delete('users'), 'Delete requires explicit WHERE');
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['SERVER_ADDR'] = '127.0.0.1';
$_SERVER['HTTP_HOST'] = 'localhost';
$check(Auth::isLocalDevelopmentRequest(), 'Loopback testing permits local initializer credential');
foreach (['localhost:8080', '127.0.0.1', '127.0.0.1:80', '[::1]', '[::1]:8080'] as $host) {
    $_SERVER['HTTP_HOST'] = $host;
    $check(Auth::isLocalDevelopmentRequest(), 'Strict loopback Host accepted: ' . $host);
}
foreach (['range.example.com', 'localhost.example.com', 'localhost@range.example.com', 'range.example.com@localhost', '127.0.0.1.evil.invalid', 'localhost:0', 'localhost:65536', 'localhost:80,range.example.com', ''] as $host) {
    $_SERVER['HTTP_HOST'] = $host;
    $check(!Auth::isLocalDevelopmentRequest(), 'Public or malformed Host rejected: ' . ($host ?: '(missing)'));
}
$_SERVER['HTTP_HOST'] = 'localhost';
foreach (['HTTP_FORWARDED', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED_HOST', 'HTTP_X_FORWARDED_PROTO', 'HTTP_X_FORWARDED_PORT', 'HTTP_X_REAL_IP'] as $header) {
    $_SERVER[$header] = '127.0.0.1';
    $check(!Auth::isLocalDevelopmentRequest(), 'Forwarding header rejects development credential: ' . $header);
    unset($_SERVER[$header]);
}
putenv('APP_URL=https://range.example.com/vostokpribor_AI');
$check(!Auth::isLocalDevelopmentRequest(), 'Public configured APP_URL rejects development credential');
putenv('APP_URL=http://range.example.com@localhost/vostokpribor_AI');
$check(!Auth::isLocalDevelopmentRequest(), 'Userinfo in configured APP_URL rejected');
putenv('APP_URL=http://localhost/vostokpribor_AI');
$_SERVER['REMOTE_ADDR'] = '192.0.2.44';
$check(!Auth::isLocalDevelopmentRequest(), 'Nonloopback client cannot use local credential');
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['SERVER_ADDR'] = '192.0.2.10';
$check(!Auth::isLocalDevelopmentRequest(), 'Nonloopback server cannot use local credential');
$_SERVER['SERVER_ADDR'] = '';
$check(!Auth::isLocalDevelopmentRequest(), 'Missing server address cannot use local credential');
$_SERVER['SERVER_ADDR'] = '127.0.0.1';
putenv('APP_ENV=production');
$check(!Auth::isLocalDevelopmentRequest(), 'Production environment cannot use development credential');
putenv('APP_ENV=testing');
$token = Csrf::getToken();
$check(strlen($token) === 64 && Csrf::validate($token), 'Session token generated and accepted');
$check(!Csrf::validate(null) && !Csrf::validate('wrong'), 'Absent and incorrect tokens rejected');
$check(!Csrf::validate([]) && !Csrf::validate(42) && !Csrf::validate(true), 'Malformed token types rejected safely');
$html = Csrf::protectHtml('<html><head></head><body><form method="post"><button>Save</button></form></body></html>');
$check(substr_count($html, 'name="csrf_token"') === 1 && str_contains($html, $token), 'Server HTML POST form receives token');
$check(str_contains($html, 'name="csrf-token"'), 'CSRF meta available to authenticated API client');
$check(Csrf::protectHtml($html) === $html, 'Existing form token and meta are not duplicated');
$check(Csrf::protectHtml('{"success":true}') === '{"success":true}', 'JSON responses are unchanged');
session_write_close();
foreach ($checks as $label) echo 'PASS: ' . $label . PHP_EOL;
echo count($checks) . " security checks passed; no database connection made.\n";
