<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/lib/setup.php';
try {
    $count = setupMigrate(\App\Core\Database::getConnection());
    echo "Migrations complete: $count applied. No demo records are created.\n";
} catch (Throwable $e) { fwrite(STDERR, $e->getMessage() . "\n"); exit(1); }
