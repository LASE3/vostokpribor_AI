<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;
use App\Middleware\AuthorizationMiddleware;

AuthorizationMiddleware::requireAdmin(true);

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');

try {
    $scenarios = Database::query(
        "SELECT s.id, s.code, s.title, s.difficulty, s.department as assigned_department, s.status, s.version,
                (SELECT COUNT(*) FROM tickets t WHERE t.scenario_id = s.id) as tickets_count,
                (SELECT COUNT(DISTINCT ta.student_id) FROM ticket_assignments ta JOIN tickets t2 ON ta.ticket_id = t2.id WHERE t2.scenario_id = s.id) as students_count
         FROM scenarios s
         ORDER BY s.created_at DESC"
    );

    $formatted = [];
    foreach ($scenarios as $s) {
        $formatted[] = [
            'id'                  => $s['code'],
            'title'               => $s['title'],
            'difficulty'          => $s['difficulty'],
            'assigned_department' => $s['assigned_department'],
            'tickets_count'       => (int)$s['tickets_count'],
            'students_count'      => (int)$s['students_count'],
            'status'              => $s['status'],
            'version'             => $s['version']
        ];
    }

    echo json_encode([
        'protocol'        => 'VOSTOKPRIBOR-CROSS-SYSTEM-SYNC-v1',
        'timestamp'       => date('c'),
        'scenarios_count' => count($formatted),
        'scenarios'       => $formatted
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'ERROR',
        'message' => 'Unable to query cross-system exchange'
    ]);
}
