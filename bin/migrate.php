<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;

echo "=== VOSTOKPRIBOR AI • Database Migration Runner ===\n";

try {
    $db = Database::getConnection();

    // Ensure migrations table exists
    $db->exec("CREATE TABLE IF NOT EXISTS `migrations` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `migration` VARCHAR(255) NOT NULL UNIQUE,
        `applied_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    $applied = Database::query("SELECT migration FROM migrations");
    $appliedList = array_column($applied, 'migration');

    $migrationsDir = __DIR__ . '/../database/migrations';
    $files = glob($migrationsDir . '/*.sql');
    sort($files);

    $count = 0;
    foreach ($files as $file) {
        $filename = basename($file);
        if (in_array($filename, $appliedList)) {
            echo "[SKIP] Already applied: $filename\n";
            continue;
        }

        echo "[APPLY] Executing: $filename ... ";
        $sql = file_get_contents($file);

        // Execute queries
        $db->exec($sql);

        // Record migration
        $stmt = $db->prepare("INSERT INTO migrations (migration) VALUES (:m)");
        $stmt->execute(['m' => $filename]);

        echo "SUCCESS\n";
        $count++;
    }

    echo "=== Migrations finished. $count migration(s) applied. ===\n";
} catch (\Throwable $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
    exit(1);
}
