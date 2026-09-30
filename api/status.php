<?php
/**
 * VOSTOKPRIBOR AI • API: System Health & Telemetry Status
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../db/db.php';
apply_perf_headers();

header('Content-Type: application/json; charset=utf-8');

$dbLive = VostokDB::isLive();
$systems = VostokDB::getSystems();

echo json_encode([
    'app' => APP_NAME,
    'version' => APP_VERSION,
    'status' => 'ONLINE',
    'timestamp' => time(),
    'database' => [
        'connected' => $dbLive,
        'mode' => $dbLive ? 'LIVE_MYSQL' : 'IN_MEMORY_SIMULATION',
        'error' => VostokDB::getLastError()
    ],
    'telemetry' => [
        'cluster_node' => 'ORB-NODE-09',
        'total_tflops' => 88.4,
        'gpu_vram_gb' => '78.4 / 80.0',
        'uplink_latency_ms' => 12,
        'active_incidents' => 1
    ],
    'subsystems' => $systems
], JSON_PRETTY_PRINT);
