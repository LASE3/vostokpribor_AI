<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
if (!in_array('--confirm-local-dev', $argv, true)) {
    fwrite(STDERR, "REFUSED: --confirm-local-dev is required.\n"); exit(1);
}
require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/lib/setup.php';
try {
    setupRequireLocal((string)\App\Core\Env::get('DB_NAME', ''));
    setupCreateAdmin(\App\Core\Database::getConnection(), 'admin@vostokpribor.local', 'Super Administrator', 'admin', 'admin');
    echo "Created exactly one local administrator: identifier admin, initial password admin. Mandatory password change enabled. No work or audit records created.\n";
} catch (Throwable $e) { fwrite(STDERR, $e->getMessage() . "\n"); exit(1); }
