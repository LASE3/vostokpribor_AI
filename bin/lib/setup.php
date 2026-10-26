<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }

use App\Core\Env;

function setupRequireLocal(string $database): void
{
    $environment = strtolower((string)Env::get('APP_ENV', 'production'));
    $urlHost = strtolower((string)parse_url((string)Env::get('APP_URL', ''), PHP_URL_HOST));
    $databaseHost = strtolower((string)Env::get('DB_HOST', ''));
    $loopbacks = ['localhost', '127.0.0.1', '::1', '[::1]'];
    if (!in_array($environment, ['local', 'development', 'dev', 'testing'], true)
        || ($environment === 'testing' && !str_ends_with($database, '_test'))
        || !in_array($urlHost, $loopbacks, true)
        || !in_array($databaseHost, $loopbacks, true)) {
        throw new RuntimeException('REFUSED: local APP_ENV, loopback APP_URL and DB_HOST required; testing databases must end in _test.');
    }
}

function setupMigrate(PDO $pdo): int
{
    $lock = 'vostok_migrate_' . substr(hash('sha256', $pdo->query('SELECT DATABASE()')->fetchColumn()), 0, 32);
    $statement = $pdo->prepare('SELECT GET_LOCK(:lock_name, 10)');
    $statement->execute(['lock_name' => $lock]);
    if ((int)$statement->fetchColumn() !== 1) throw new RuntimeException('Another migration is running.');
    try {
        $pdo->exec('CREATE TABLE IF NOT EXISTS migrations (id INT AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255) NOT NULL UNIQUE, applied_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
        $applied = $pdo->query('SELECT migration FROM migrations')->fetchAll(PDO::FETCH_COLUMN);
        $files = glob(dirname(__DIR__, 2) . '/database/migrations/*.sql');
        sort($files);
        $count = 0;
        foreach ($files as $file) {
            $name = basename($file);
            if (in_array($name, $applied, true)) { echo "SKIP $name\n"; continue; }
            $pdo->exec(file_get_contents($file));
            $statement = $pdo->prepare('INSERT INTO migrations (migration) VALUES (:migration)');
            $statement->execute(['migration' => $name]);
            echo "APPLIED $name\n";
            $count++;
        }
        return $count;
    } finally {
        $statement = $pdo->prepare('SELECT RELEASE_LOCK(:lock_name)');
        $statement->execute(['lock_name' => $lock]);
    }
}

function setupAssertEmpty(PDO $pdo): void
{
    foreach ($pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN) as $table) {
        if ($table === 'migrations') continue;
        if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $table)) throw new RuntimeException('Unexpected table identifier.');
        if ((int)$pdo->query('SELECT COUNT(*) FROM `' . $table . '`')->fetchColumn() !== 0) {
            throw new RuntimeException('REFUSED: ' . $table . ' contains data. No records were reset.');
        }
    }
}

function setupCreateAdmin(PDO $pdo, string $email, string $name, string $identifier, string $password): void
{
    $lock = 'vostok_admin_' . substr(hash('sha256', $pdo->query('SELECT DATABASE()')->fetchColumn()), 0, 32);
    $statement = $pdo->prepare('SELECT GET_LOCK(:lock_name, 10)');
    $statement->execute(['lock_name' => $lock]);
    if ((int)$statement->fetchColumn() !== 1) throw new RuntimeException('Administrator initialization is already running.');
    try {
        $pdo->beginTransaction();
        setupAssertEmpty($pdo);
        $statement = $pdo->prepare("INSERT INTO users (role,email,password_hash,full_name,identifier,status,must_change_password) VALUES ('ADMIN',:email,:hash,:name,:identifier,'ACTIVE',1)");
        $statement->execute(['email' => $email, 'hash' => password_hash($password, PASSWORD_DEFAULT), 'name' => $name, 'identifier' => $identifier]);
        $pdo->commit();
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        throw $e;
    } finally {
        $statement = $pdo->prepare('SELECT RELEASE_LOCK(:lock_name)');
        $statement->execute(['lock_name' => $lock]);
    }
}
