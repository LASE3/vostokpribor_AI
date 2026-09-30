<?php
/**
 * VOSTOKPRIBOR AI • API: Data Center Catalog & Features
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../db/db.php';
apply_perf_headers();

header('Content-Type: application/json; charset=utf-8');

$datasets = VostokDB::getDatasets();
echo json_encode([
    'total' => count($datasets),
    'data' => $datasets
], JSON_PRETTY_PRINT);
