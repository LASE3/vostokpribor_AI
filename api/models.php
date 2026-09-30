<?php
/**
 * VOSTOKPRIBOR AI • API: Model Registry & Deployment Checkpoints
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../db/db.php';
apply_perf_headers();

header('Content-Type: application/json; charset=utf-8');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    
    $modelName = $input['model_name'] ?? 'churn_model_' . time();
    $version = $input['version'] ?? '1.0.0';
    $framework = $input['framework'] ?? 'Scikit-Learn';
    $f1 = (float)($input['f1_score'] ?? 0.85);

    if (VostokDB::isLive()) {
        $id = VostokDB::insert('models', [
            'model_name' => $modelName,
            'version' => $version,
            'framework' => $framework,
            'f1_score' => $f1,
            'status' => 'STAGED',
            'author' => $input['author'] ?? 'Operator Intern'
        ]);
        echo json_encode(['success' => true, 'id' => $id, 'message' => 'Model registered in live database.']);
    } else {
        echo json_encode([
            'success' => true,
            'id' => rand(100, 999),
            'message' => 'Model registered in simulated runtime memory.',
            'model' => [
                'model_name' => $modelName,
                'version' => $version,
                'framework' => $framework,
                'f1_score' => $f1
            ]
        ]);
    }
    exit;
}

$models = VostokDB::getModels();
echo json_encode([
    'total' => count($models),
    'data' => $models
], JSON_PRETTY_PRINT);
