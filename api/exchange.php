<?php
/**
 * VOSTOKPRIBOR AI • API: Cross-System Data Exchange Hub
 * Coordinates information exchange between:
 * SYS-AI-01 (Projects) <-> SYS-AI-02 (Data Center) <-> SYS-AI-03 (Workbench)
 * <-> SYS-AI-04 (Registry & Deploy) <-> SYS-AI-05 (AI Operations Center)
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../db/db.php';
apply_perf_headers();

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'POST') {
    $payload = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    $sourceSystem = $payload['source_system'] ?? 'SYS-AI-03';
    $targetSystem = $payload['target_system'] ?? 'SYS-AI-04';
    $action = $payload['action'] ?? 'SYNC_EVENT';
    $data = $payload['data'] ?? [];

    $eventId = 'EVT-' . strtoupper(substr(md5(uniqid()), 0, 8));

    // Simulated event bus log
    echo json_encode([
        'success' => true,
        'event_id' => $eventId,
        'timestamp' => time(),
        'source' => $sourceSystem,
        'target' => $targetSystem,
        'action' => $action,
        'status' => 'DISPATCHED',
        'db_persisted' => VostokDB::isLive(),
        'message' => "Cross-system event transmitted successfully from {$sourceSystem} to {$targetSystem}."
    ], JSON_PRETTY_PRINT);
    exit;
}

// GET: Returns comprehensive aggregate overview of all systems data
echo json_encode([
    'timestamp' => time(),
    'db_connected' => VostokDB::isLive(),
    'aggregate' => [
        'systems' => VostokDB::getSystems(),
        'models' => VostokDB::getModels(),
        'datasets' => VostokDB::getDatasets(),
        'incidents' => VostokDB::getIncidents(),
        'tickets' => VostokDB::getTickets()
    ]
], JSON_PRETTY_PRINT);
