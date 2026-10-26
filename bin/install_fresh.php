<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/lib/setup.php';
use App\Core\Env;

$options = getopt('', ['database:', 'confirm-local-dev', 'backup-dir:']);
try {
    $target = (string)($options['database'] ?? '');
    if (!isset($options['confirm-local-dev']) || !preg_match('/^[A-Za-z][A-Za-z0-9_]{2,63}$/D', $target)) {
        throw new RuntimeException('Usage: php bin/install_fresh.php --database=NEW_DATABASE_NAME --confirm-local-dev [--backup-dir=ABSOLUTE_PATH_OUTSIDE_WEBROOT]');
    }
    setupRequireLocal($target);
    $host = (string)Env::get('DB_HOST', '127.0.0.1');
    $port = (string)Env::get('DB_PORT', '3306');
    $user = (string)Env::get('DB_USER', '');
    if ($user === '') throw new RuntimeException('Explicit DB_USER configuration is required.');
    $password = (string)Env::get('DB_PASS', '');
    $source = (string)Env::get('DB_NAME', '');
    $pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $exists = $pdo->prepare('SELECT COUNT(*) FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = :name');
    $exists->execute(['name' => $target]);
    if ((int)$exists->fetchColumn() !== 0) throw new RuntimeException('REFUSED: target database already exists. Choose a NEW name. No data were changed.');
    $exists->execute(['name' => $source]);
    if ($source !== '' && (int)$exists->fetchColumn() !== 0) {
        $directory = (string)($options['backup-dir'] ?? ((getenv('USERPROFILE') ?: sys_get_temp_dir()) . '/.codex/backups/vostokpribor'));
        if (!is_dir($directory) && !mkdir($directory, 0700, true)) throw new RuntimeException('Cannot create backup directory.');
        $directory = realpath($directory);
        $webroot = realpath(dirname(__DIR__, 2));
        if (!$directory || !$webroot || str_starts_with(strtolower(str_replace('\\', '/', $directory)) . '/', strtolower(str_replace('\\', '/', $webroot)) . '/')) {
            throw new RuntimeException('REFUSED: backups must be outside the web root.');
        }
        $filename = $directory . '/' . preg_replace('/[^A-Za-z0-9_-]/', '_', $source) . '_' . gmdate('Ymd_His') . '_' . bin2hex(random_bytes(3)) . '.sql';
        $dump = is_file('C:/xampp/mysql/bin/mysqldump.exe') ? 'C:/xampp/mysql/bin/mysqldump.exe' : 'mysqldump';
        $command = [$dump, '--host=' . $host, '--port=' . $port, '--user=' . $user, '--single-transaction', '--routines', '--events', '--hex-blob', '--result-file=' . $filename, '--databases', $source];
        $environment = getenv();
        $environment['MYSQL_PWD'] = $password;
        $process = proc_open($command, [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, null, $environment, ['bypass_shell' => true]);
        if (!is_resource($process)) throw new RuntimeException('Cannot start mysqldump; no new database created.');
        fclose($pipes[0]);
        $stdout = stream_get_contents($pipes[1]); fclose($pipes[1]);
        $stderr = stream_get_contents($pipes[2]); fclose($pipes[2]);
        $result = proc_close($process);
        if ($result !== 0 || !is_file($filename) || filesize($filename) === 0) throw new RuntimeException('Backup failed; no new database created. ' . $stderr);
        chmod($filename, 0600);
        echo 'BACKUP ' . $source . ': ' . $filename . ' SHA256=' . hash_file('sha256', $filename) . "\n";
    } else {
        echo "No existing configured database to back up.\n";
    }
    // No IF NOT EXISTS: races also fail closed instead of adopting an existing DB.
    $pdo->exec('CREATE DATABASE `' . $target . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    $pdo->exec('USE `' . $target . '`');
    setupMigrate($pdo);
    setupCreateAdmin($pdo, 'admin@vostokpribor.local', 'Super Administrator', 'admin', 'admin');
    echo "CREATED $target with one ADMIN admin, initial password admin, mandatory rotation. All work/audit tables are empty.\n";
    echo "The old database is intact. Update DB_NAME in your local .env only after reviewing this output.\n";
} catch (Throwable $e) { fwrite(STDERR, $e->getMessage() . "\n"); exit(1); }
