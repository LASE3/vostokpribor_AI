<?php

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $host = Env::get('DB_HOST', '127.0.0.1');
            $port = Env::get('DB_PORT', '3306');
            $dbname = (string)Env::get('DB_NAME', '');
            $user = (string)Env::get('DB_USER', '');
            $pass = Env::get('DB_PASS', '');
            $charset = Env::get('DB_CHARSET', 'utf8mb4');

            if (!preg_match('/^[A-Za-z][A-Za-z0-9_]{0,63}$/D', $dbname) || $user === '') {
                throw new RuntimeException('Explicit DB_NAME and DB_USER configuration is required. No default installation database will be used.');
            }
            if (Env::get('APP_ENV', 'production') === 'testing' && !str_ends_with($dbname, '_test')) {
                throw new RuntimeException('Testing requires a dedicated database name ending in _test.');
            }

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => true,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                error_log("Database connection failure: " . $e->getMessage());
                throw new RuntimeException('Database unavailable. Check the server configuration.');
            }
        }

        return self::$instance;
    }

    public static function query(string $sql, array $params = []): array
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function queryOne(string $sql, array $params = []): ?array
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    public static function execute(string $sql, array $params = []): int
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    private static ?self $classInstance = null;

    public static function getInstance(): self
    {
        if (self::$classInstance === null) {
            self::$classInstance = new self();
        }
        return self::$classInstance;
    }

    public function fetchAll(string $sql, array $params = []): array
    {
        return self::query($sql, $params);
    }

    public function fetchOne(string $sql, array $params = []): ?array
    {
        return self::queryOne($sql, $params);
    }

    public function fetchValue(string $sql, array $params = [], mixed $default = null): mixed
    {
        $row = self::queryOne($sql, $params);
        if ($row !== null && count($row) > 0) {
            return reset($row);
        }
        return $default;
    }

    public function insert(string $table, array $data): int
    {
        self::assertIdentifier($table);
        if (!$data) {
            throw new \InvalidArgumentException('Insert requires at least one column.');
        }

        $keys = array_keys($data);
        foreach ($keys as $key) self::assertIdentifier($key);
        $fields = implode(', ', array_map(fn($k) => "`$k`", $keys));
        $placeholders = implode(', ', array_map(fn($k) => ":$k", $keys));
        $sql = "INSERT INTO `$table` ($fields) VALUES ($placeholders)";

        $params = [];
        foreach ($data as $k => $v) {
            $params[":$k"] = $v;
        }

        self::execute($sql, $params);
        return (int)self::lastInsertId();
    }

    public function update(string $table, array $data, string $where = '', array $whereParams = []): int
    {
        self::assertIdentifier($table);
        if (!$data || trim($where) === '') {
            throw new \InvalidArgumentException('Update requires columns and an explicit WHERE clause.');
        }

        $setClauses = [];
        $params = [];
        foreach ($data as $k => $v) {
            self::assertIdentifier($k);
            $setClauses[] = "`$k` = :set_$k";
            $params[":set_$k"] = $v;
        }
        $setString = implode(', ', $setClauses);
        $sql = "UPDATE `$table` SET $setString WHERE $where";

        foreach ($whereParams as $k => $v) {
            $params[$k] = $v;
        }

        return self::execute($sql, $params);
    }

    public static function lastInsertId(): string
    {
        return self::getConnection()->lastInsertId();
    }

    public static function transaction(callable $callback): mixed
    {
        $db = self::getConnection();
        if ($db->inTransaction()) {
            $savepoint = 'nested_' . bin2hex(random_bytes(6));
            $db->exec('SAVEPOINT ' . $savepoint);
            try {
                $result = $callback($db);
                $db->exec('RELEASE SAVEPOINT ' . $savepoint);
                return $result;
            } catch (\Throwable $e) {
                $db->exec('ROLLBACK TO SAVEPOINT ' . $savepoint);
                $db->exec('RELEASE SAVEPOINT ' . $savepoint);
                throw $e;
            }
        }

        $db->beginTransaction();
        try {
            $result = $callback($db);
            $db->commit();
            return $result;
        } catch (\Throwable $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public function delete(string $table, string $where = '', array $params = []): int
    {
        self::assertIdentifier($table);
        if (trim($where) === '') {
            throw new \InvalidArgumentException('Delete requires an explicit WHERE clause.');
        }
        $sql = "DELETE FROM `$table` WHERE $where";
        return self::execute($sql, $params);
    }

    private static function assertIdentifier(string $identifier): void
    {
        if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $identifier)) {
            throw new \InvalidArgumentException('Expected a table or column name; use execute() for SQL.');
        }
    }
}
