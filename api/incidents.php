<?php
/**
 * VOSTOKPRIBOR AI • API: AI SOC Incidents & Telemetry Drift
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../db/db.php';
apply_perf_headers();

header('Content-Type: application/json; charset=utf-8');

$incidents = VostokDB::getIncidents();
echo json_encode([
    'total' => count($incidents),
    'data' => $incidents
], JSON_PRETTY_PRINT);
