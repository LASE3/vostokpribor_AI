<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;
use App\Core\Auth;

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');

try {
    $models = Database::query(
        "SELECT m.id, m.model_code, m.name, m.framework, m.current_version, m.status as gate_status,
                s.code as scenario_code,
                (SELECT mv.metrics FROM model_versions mv WHERE mv.model_id = m.id ORDER BY mv.created_at DESC LIMIT 1) as metrics_json
         FROM models m
         LEFT JOIN scenarios s ON m.scenario_id = s.id
         ORDER BY m.updated_at DESC"
    );

    $formatted = [];
    foreach ($models as $m) {
        $metrics = !empty($m['metrics_json']) ? json_decode($m['metrics_json'], true) : [];
        $formatted[] = [
            'model_id'    => $m['model_code'],
            'name'        => $m['name'],
            'version'     => $m['current_version'],
            'framework'   => $m['framework'],
            'scenario_id' => $m['scenario_code'],
            'gate_status' => $m['gate_status'],
            'metrics'     => $metrics,
            'endpoint'    => '/api/v1/models/' . $m['id']
        ];
    }

    echo json_encode([
        'status'            => 'OK',
        'timestamp'         => date('c'),
        'total_models'      => count($formatted),
        'registered_models' => $formatted
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'ERROR',
        'message' => 'Unable to query model repository'
    ]);
}
