<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__ . '/../app/bootstrap.php';
use App\Core\Database;
try {
    $pdo = Database::getConnection();
    $users = $pdo->query('SELECT * FROM users')->fetchAll();
    if (count($users) !== 1 || $users[0]['role'] !== 'ADMIN' || $users[0]['identifier'] !== 'admin' || $users[0]['status'] !== 'ACTIVE'
        || (int)$users[0]['must_change_password'] !== 1 || !password_verify('admin', $users[0]['password_hash'])) {
        throw new RuntimeException('FAIL: expected exactly one active ADMIN identifier admin with hashed initial local credential and mandatory rotation.');
    }
    echo "PASS users: exactly one ADMIN, identifier admin; password_hash verifies; must_change_password=1\n";
    foreach ($pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN) as $table) {
        if (in_array($table, ['users','migrations'], true)) continue;
        if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $table)) throw new RuntimeException('Unexpected table identifier.');
        $count = (int)$pdo->query('SELECT COUNT(*) FROM `' . $table . '`')->fetchColumn();
        if ($count !== 0) throw new RuntimeException("FAIL $table: $count records; expected zero");
        echo "PASS $table: 0\n";
    }
    echo "VERIFIED EMPTY LOCAL INSTALLATION. No records were changed.\n";
} catch (Throwable $e) { fwrite(STDERR, $e->getMessage() . "\n"); exit(1); }
