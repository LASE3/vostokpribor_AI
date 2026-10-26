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
            $dbname = Env::get('DB_NAME', 'vostokpribor_ai');
            $user = Env::get('DB_USER', 'root');
            $pass = Env::get('DB_PASS', '');
            $charset = Env::get('DB_CHARSET', 'utf8mb4');

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
                throw new RuntimeException("Could not connect to database cluster: " . $e->getMessage());
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
        $trimmed = trim($table);
        if (stripos($trimmed, 'INSERT INTO ') === 0) {
            self::execute($trimmed, $data);
            return (int)self::lastInsertId();
        }

        $keys = array_keys($data);
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
        $trimmed = trim($table);
        if (stripos($trimmed, 'UPDATE ') === 0) {
            return self::execute($trimmed, $data);
        }

        $setClauses = [];
        $params = [];
        foreach ($data as $k => $v) {
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
            return $callback($db);
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
        $trimmed = trim($table);
        if (stripos($trimmed, 'DELETE FROM ') === 0) {
            return self::execute($trimmed, is_array($where) ? $where : $params);
        }
        $sql = "DELETE FROM `$table` WHERE $where";
        return self::execute($sql, $params);
    }
}
