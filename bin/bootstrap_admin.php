<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/lib/setup.php';
$options = getopt('', ['email:', 'name:', 'identifier:']);
// Password comes from stdin rather than command-line arguments or hardcoded data.
try {
    $email = trim((string)($options['email'] ?? ''));
    $name = trim((string)($options['name'] ?? ''));
    $identifier = trim((string)($options['identifier'] ?? 'admin'));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($name) < 2 || strlen($name) > 120 || !preg_match('/^[A-Za-z0-9_.@-]{3,64}$/D', $identifier)) {
        throw new RuntimeException('Usage: php bin/bootstrap_admin.php --email=you@example.com --name="Administrator" --identifier=admin; supply a strong password on stdin.');
    }
    fwrite(STDERR, "Enter administrator password (12 to 72 characters; terminal may echo input): ");
    $password = rtrim((string)fgets(STDIN), "\r\n");
    if (strlen($password) < 12 || strlen($password) > 72) throw new RuntimeException('Password must contain 12 to 72 characters.');
    setupCreateAdmin(\App\Core\Database::getConnection(), $email, $name, $identifier, $password);
    echo "Administrator created once with mandatory password change. No work or audit records created.\n";
} catch (Throwable $e) { fwrite(STDERR, $e->getMessage() . "\n"); exit(1); }
