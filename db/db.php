<?php
/**
 * VOSTOKPRIBOR AI • Database Integration & Cross-System Exchange
 * Manages PDO connections, query executions, and mock failover if MySQL is offline.
 */

require_once __DIR__ . '/../config/config.php';

class VostokDB {
    private static ?PDO $pdo = null;
    private static bool $connected = false;
    private static ?string $error = null;
    private static bool $checked = false;

    /**
     * Initializes PDO connection or catches failure gracefully.
     */
    public static function getConnection(): ?PDO {
        if (self::$pdo !== null) {
            return self::$pdo;
        }
        if (self::$checked && !self::$connected) {
            return null;
        }
        self::$checked = true;

        // Ultra-fast socket check (0.12s) for instant response when MySQL is offline
        $fp = @fsockopen(DB_HOST, (int)DB_PORT, $errno, $errstr, 0.12);
        if (!$fp) {
            self::$connected = false;
            self::$error = "MySQL service not running on " . DB_HOST . ":" . DB_PORT;
            return null;
        }
        fclose($fp);

        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            self::$pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 1
            ]);
            self::$connected = true;
            self::$error = null;
            return self::$pdo;
        } catch (PDOException $e) {
            self::$pdo = null;
            self::$connected = false;
            self::$error = $e->getMessage();
            return null;
        }
    }

    public static function isLive(): bool {
        self::getConnection();
        return self::$connected;
    }

    public static function getLastError(): ?string {
        return self::$error;
    }

    /**
     * Executes query with parameters and returns all rows
     */
    public static function fetchAll(string $sql, array $params = []): array {
        $db = self::getConnection();
        if ($db) {
            try {
                $stmt = $db->prepare($sql);
                $stmt->execute($params);
                return $stmt->fetchAll();
            } catch (Exception $e) {
                // fall through to fallback
            }
        }
        return [];
    }

    /**
     * Inserts data into a table
     */
    public static function insert(string $table, array $data): int {
        $db = self::getConnection();
        if (!$db) return 0;

        $columns = implode(', ', array_map(fn($k) => "`$k`", array_keys($data)));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";

        $stmt = $db->prepare($sql);
        $stmt->execute(array_values($data));
        return (int)$db->lastInsertId();
    }

    /**
     * Returns systems with live DB or structured system registry
     */
    public static function getSystems(): array {
        if (self::isLive()) {
            $rows = self::fetchAll("SELECT * FROM `systems` ORDER BY `id` ASC");
            if (!empty($rows)) {
                return $rows;
            }
        }
        // Fallback to config registry
        return array_values($GLOBALS['VOSTOK_SYSTEMS']);
    }

    /**
     * Returns registered models
     */
    public static function getModels(): array {
        if (self::isLive()) {
            $rows = self::fetchAll("SELECT * FROM `models` ORDER BY `created_at` DESC");
            if (!empty($rows)) return $rows;
        }
        return [
            [
                'id' => 1,
                'model_name' => 'churn_rf_v2',
                'version' => '2.0.4',
                'framework' => 'Scikit-Learn 1.3 / ONNX',
                'accuracy' => 0.8920,
                'f1_score' => 0.8740,
                'roc_auc' => 0.9120,
                'drift_score' => 0.2980,
                'status' => 'CANARY_10',
                'traffic_pct' => 10,
                'p99_latency_ms' => 11.40,
                'author' => 'Dr. Alexei Voronov',
                'sha256_hash' => '4f9812a...796120'
            ],
            [
                'id' => 2,
                'model_name' => 'churn_xgb_champion',
                'version' => '1.9.0',
                'framework' => 'XGBoost 2.0',
                'accuracy' => 0.8810,
                'f1_score' => 0.8610,
                'roc_auc' => 0.9040,
                'drift_score' => 0.0120,
                'status' => 'PRODUCTION',
                'traffic_pct' => 90,
                'p99_latency_ms' => 8.20,
                'author' => 'Cadet Sarah Chen',
                'sha256_hash' => '8b321ae...23901a'
            ]
        ];
    }

    /**
     * Returns datasets
     */
    public static function getDatasets(): array {
        if (self::isLive()) {
            $rows = self::fetchAll("SELECT * FROM `datasets` ORDER BY `id` ASC");
            if (!empty($rows)) return $rows;
        }
        return [
            [
                'id' => 1,
                'dataset_code' => 'DS-TELCO-Q3-V1',
                'name' => 'telecom_q3_v1.parquet',
                'num_records' => 204000,
                'size_mb' => 48.60,
                'file_format' => 'parquet',
                'feature_count' => 28,
                'provenance' => 'Verified Immutable'
            ],
            [
                'id' => 2,
                'dataset_code' => 'DS-CRM-FEED-05',
                'name' => 'crm_event_stream_v5.json',
                'num_records' => 1250000,
                'size_mb' => 312.40,
                'file_format' => 'json',
                'feature_count' => 14,
                'provenance' => 'Drifted Stream Source'
            ]
        ];
    }

    /**
     * Returns incidents
     */
    public static function getIncidents(): array {
        if (self::isLive()) {
            $rows = self::fetchAll("SELECT * FROM `incidents` ORDER BY `id` DESC");
            if (!empty($rows)) return $rows;
        }
        return [
            [
                'id' => 1,
                'incident_code' => 'INC-4092',
                'title' => 'F1 Score Degradation on Production Churn Endpoint',
                'severity' => 'P1 CRITICAL',
                'status' => 'INVESTIGATING',
                'model_name' => 'churn_rf_v2',
                'assigned_to' => 'Alexei V. (Primary SOC)',
                'blast_radius' => 'Enterprise Retention Svc · APAC / EMEA',
                'drift_delta' => '0.87 -> 0.61 (-29.8%)',
                'trigger_time' => '04:18 UTC'
            ]
        ];
    }

    /**
     * Returns tickets
     */
    public static function getTickets(): array {
        if (self::isLive()) {
            $rows = self::fetchAll("SELECT * FROM `tickets` ORDER BY `id` ASC");
            if (!empty($rows)) return $rows;
        }
        return [
            [
                'id' => 1,
                'ticket_code' => 'TK-AI-101',
                'title' => 'Retrain churn_rf_v2 with corrected categorical encoding',
                'assignee' => 'Sarah Chen',
                'status' => 'IN_PROGRESS',
                'priority' => 'CRITICAL',
                'story_points' => 8
            ],
            [
                'id' => 2,
                'ticket_code' => 'TK-AI-102',
                'title' => 'Deploy Canary Traffic Gate 10% to Triton Cluster',
                'assignee' => 'Alexei Voronov',
                'status' => 'COMPLETED',
                'priority' => 'HIGH',
                'story_points' => 5
            ]
        ];
    }
}
