<?php
/**
 * VOSTOKPRIBOR AI • API: Project Management Tickets & Sprints
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../db/db.php';
apply_perf_headers();

header('Content-Type: application/json; charset=utf-8');

$tickets = VostokDB::getTickets();
echo json_encode([
    'total' => count($tickets),
    'data' => $tickets
], JSON_PRETTY_PRINT);
