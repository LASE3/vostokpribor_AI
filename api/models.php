<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;
use App\Core\Auth;
use App\Middleware\AuthenticationMiddleware;
use App\Services\ModelService;

$currentUser = AuthenticationMiddleware::handle(true);

if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
    header('Allow: GET');
    \App\Core\Response::error('This endpoint supports GET only.', 'METHOD_NOT_ALLOWED', 405);
}


header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');

try {
    $page = (new ModelService())->pageModels((int)$currentUser['id'], $currentUser['role'], null, $_GET);
    $models = $page['items'];

    $formatted = [];
    foreach ($models as $m) {
        $metrics = !empty($m['metrics_json']) ? json_decode($m['metrics_json'], true) : [];
        $formatted[] = [
            'model_id'    => $m['model_code'],
            'name'        => $m['name'],
            'version'     => $m['current_version'],
            'framework'   => $m['framework'],
            'scenario_id' => $m['scenario_id'],
            'gate_status' => $m['status'],
            'metrics'     => $metrics,
            'record_url'  => \App\Core\AppUrl::to('api/v1/models/' . $m['id']),
            'inference_endpoint' => null
        ];
    }

    echo json_encode([
        'status'            => 'OK',
        'timestamp'         => date('c'),
        'total_models'      => $page['total'],
        'pagination'        => \App\Core\Pagination::metadata($page),
        'registered_models' => $formatted
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
} catch (\InvalidArgumentException $e) {
    \App\Core\Response::error($e->getMessage(),'VALIDATION_ERROR',422);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'ERROR',
        'message' => 'Unable to query model repository'
    ]);
}
