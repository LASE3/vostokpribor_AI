<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$models = [
    'status' => 'OK',
    'timestamp' => date('c'),
    'active_scenario' => 'SCN-CHURN-101',
    'registered_models' => [
        [
            'model_id' => 'MOD-CHURN-XGB-01',
            'name' => 'XGBoost Telecom Churn Predictor',
            'version' => 'v2.4.1',
            'framework' => 'XGBoost 1.7.5',
            'scenario_id' => 'SCN-CHURN-101',
            'gate_status' => 'CANARY_10_PERCENT',
            'metrics' => ['f1_score' => 0.884, 'precision' => 0.892, 'recall' => 0.876, 'latency_ms' => 11.4],
            'endpoint' => 'http://localhost:8000/v2/models/churn_xgboost/infer'
        ],
        [
            'model_id' => 'MOD-FRAUD-LGBM-02',
            'name' => 'LightGBM Transaction Fraud Detector',
            'version' => 'v2.1.0',
            'framework' => 'LightGBM 3.3.5',
            'scenario_id' => 'SCN-FRAUD-102',
            'gate_status' => 'STAGING_VALIDATION',
            'metrics' => ['auc_roc' => 0.962, 'f1_score' => 0.914, 'latency_ms' => 8.2],
            'endpoint' => 'http://localhost:8000/v2/models/fraud_lgbm/infer'
        ],
        [
            'model_id' => 'MOD-DEFECT-YOLO-03',
            'name' => 'YOLOv8x Surface Defect Segmenter',
            'version' => 'v1.9.3',
            'framework' => 'PyTorch 2.1.0 (ONNX)',
            'scenario_id' => 'SCN-DEFECT-103',
            'gate_status' => 'PRODUCTION_ACTIVE',
            'metrics' => ['mAP50' => 0.948, 'inference_fps' => 74.0, 'latency_ms' => 13.5],
            'endpoint' => 'http://localhost:8000/v2/models/defect_yolo/infer'
        ]
    ]
];

echo json_encode($models, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
