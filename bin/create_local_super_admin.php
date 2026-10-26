<?php
/**
 * VOSTOKPRIBOR LOCAL DEVELOPMENT ONLY: one-time admin login initializer.
 * Save as bin/create_local_super_admin.php and run from PHP CLI.
 * NEVER expose through HTTP or run against a publicly accessible deployment.
 */
declare(strict_types=1);

if (PHP_SAPI !== 'cli' || !in_array('--confirm-local-dev', $argv, true)) {
    fwrite(STDERR, "Run from CLI with --confirm-local-dev on a LOCAL development installation only.\n");
    exit(1);
}
require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;
use App\Core\Env;

$environment = strtolower((string)Env::get('APP_ENV', ''));
$host = strtolower((string)Env::get('DB_HOST', ''));
$debug = Env::get('APP_DEBUG', false);
if (!in_array($environment, ['local', 'development', 'dev'], true)
    || $debug !== true
    || !in_array($host, ['localhost', '127.0.0.1', '::1'], true)) {
    fwrite(STDERR, "REFUSED: APP_ENV must be local/development, APP_DEBUG=true, and DB_HOST must be localhost.\n");
    exit(1);
}

$db = Database::getConnection();
$adminCount = (int)$db->query("SELECT COUNT(*) FROM users WHERE role = 'ADMIN'")->fetchColumn();
if ($adminCount > 1) {
    fwrite(STDERR, "REFUSED: multiple administrators exist; choose an account manually.\n");
    exit(1);
}
$conflict = Database::queryOne("SELECT id, role FROM users WHERE identifier = :identifier LIMIT 1", ['identifier' => 'admin']);
if ($conflict && $conflict['role'] !== 'ADMIN') {
    fwrite(STDERR, "REFUSED: the identifier 'admin' belongs to a non-admin account.\n");
    exit(1);
}

$hash = password_hash('admin', PASSWORD_DEFAULT);
$existing = Database::queryOne("SELECT id, email FROM users WHERE role = 'ADMIN' LIMIT 1");
if ($existing) {
    Database::execute(
        "UPDATE users SET identifier = :identifier, full_name = 'Super Administrator', password_hash = :hash, status = 'ACTIVE', must_change_password = 1, updated_at = NOW() WHERE id = :id AND role = 'ADMIN'",
        ['identifier' => 'admin', 'hash' => $hash, 'id' => (int)$existing['id']]
    );
    $accountEmail = $existing['email'];
} else {
    $accountEmail = 'admin@vostokpribor.local';
    if (Database::queryOne("SELECT id FROM users WHERE email = :email", ['email' => $accountEmail])) {
        fwrite(STDERR, "REFUSED: bootstrap email already exists on a non-admin account.\n");
        exit(1);
    }
    Database::execute(
        "INSERT INTO users (role, email, password_hash, full_name, identifier, cohort, department, status, must_change_password, created_at)
         VALUES ('ADMIN', :email, :hash, :name, 'admin', 'Local Development', 'AI Operations Center', 'ACTIVE', 1, NOW())",
        ['email' => $accountEmail, 'hash' => $hash, 'name' => 'Super Administrator']
    );
}

echo "LOCAL DEVELOPMENT ADMIN READY\n";
echo "Login identifier: admin\nPassword: admin\n";
echo "Associated email: {$accountEmail}\n";
echo "WARNING: Change the password immediately. Never deploy this account with the password 'admin'.\n";
echo "DELETE this bootstrap script after local testing.\n";
