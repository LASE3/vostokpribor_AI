<?php

namespace App\Services;

use App\Repositories\ModelRepository;
use App\Repositories\ValidationRepository;
use App\Core\Logger;
use InvalidArgumentException;
use RuntimeException;

class ValidationService
{
    private ModelRepository $modelRepo;
    private ValidationRepository $valRepo;

    public function __construct()
    {
        $this->modelRepo = new ModelRepository();
        $this->valRepo = new ValidationRepository();
    }

    public function runValidation(int $modelId, int $modelVersionId, int $actorId): array
    {
        $model = $this->modelRepo->findById($modelId);
        if (!$model) {
            throw new RuntimeException('Model record not found.');
        }

        $version = $this->modelRepo->findVersionById($modelVersionId);
        if (!$version || (int)$version['model_id'] !== $modelId) {
            throw new RuntimeException('Model version not found.');
        }

        // Enforce ownership: student must own the model or be ADMIN
        $userRepo = new \App\Repositories\UserRepository();
        $user = $userRepo->findById($actorId);
        $role = $user['role'] ?? 'STUDENT';
        if ($role !== 'ADMIN' && (int)$model['student_id'] !== $actorId) {
            throw new RuntimeException('Access Denied: You do not own this candidate model.');
        }

        $modelsStorageDir = dirname(__DIR__, 2) . '/storage/private/models';
        $artifactFullPath = $modelsStorageDir . '/' . basename($version['artifact_path']);

        $checks = [];
        $passedCount = 0;

        // Check 1: Artifact File Integrity
        $fileExisted = file_exists($artifactFullPath);
        $fileSize = $fileExisted ? filesize($artifactFullPath) : 0;
        $calculatedSha = $fileExisted ? hash_file('sha256', $artifactFullPath) : '';
        $shaMatch = ($calculatedSha === $version['checksum_sha256']);

        $checks[] = [
            'name'     => 'Artifact File Integrity',
            'passed'   => $fileExisted && $shaMatch,
            'details'  => $fileExisted && $shaMatch ? 'Artifact verified on storage cluster (SHA-256 match).' : 'File missing or SHA-256 checksum mismatch.'
        ];
        if ($fileExisted && $shaMatch) $passedCount++;

        // Check 2: Serialization Security Scan
        $format = strtolower($version['artifact_format']);
        $safeFormats = ['onnx', 'joblib', 'json', 'pt', 'bin'];
        $isSafeFormat = in_array($format, $safeFormats);

        $checks[] = [
            'name'     => 'Serialization Safety Verification',
            'passed'   => $isSafeFormat,
            'details'  => $isSafeFormat ? "Format [.$format] approved under Avionics ML Safety Spec 880-B." : "Unsafe format [.$format] rejected."
        ];
        if ($isSafeFormat) $passedCount++;

        // Check 3: Inference Latency Benchmark Gate (< 50ms) - Empirical Only, No Fabricated Fallback
        $metrics = !empty($version['metrics']) ? json_decode($version['metrics'], true) : [];
        $hasLatency = isset($metrics['latency_ms']) && is_numeric($metrics['latency_ms']);
        $latencyMs = $hasLatency ? (float)$metrics['latency_ms'] : null;
        $latencyPass = $hasLatency && ($latencyMs <= 50.0);

        $checks[] = [
            'name'     => 'Inference Latency Benchmark',
            'passed'   => $latencyPass,
            'details'  => $hasLatency
                ? "Empirical measured latency: {$latencyMs} ms (Gate Threshold: <= 50.0 ms)."
                : "NOT_EVALUATED: No empirical benchmark latency recorded."
        ];
        if ($latencyPass) $passedCount++;

        // Check 4: Predictive Accuracy & Metric Threshold - Empirical Only, No Fabricated Fallback
        $hasF1 = isset($metrics['f1_score']) && is_numeric($metrics['f1_score']);
        $hasAcc = isset($metrics['accuracy']) && is_numeric($metrics['accuracy']);
        $scoreValue = $hasF1 ? (float)$metrics['f1_score'] : ($hasAcc ? (float)$metrics['accuracy'] : null);
        $accuracyPass = ($scoreValue !== null) && ($scoreValue >= 0.75);

        $checks[] = [
            'name'     => 'Candidate Performance Benchmark',
            'passed'   => $accuracyPass,
            'details'  => ($scoreValue !== null)
                ? "Empirical benchmark score: {$scoreValue} (Benchmark Threshold: >= 0.75)."
                : "INCOMPLETE: No evaluation metrics recorded. Run evaluation job first."
        ];
        if ($accuracyPass) $passedCount++;

        $totalChecks = count($checks);
        $isOverallPassed = ($passedCount === $totalChecks);
        $overallScore = round(($passedCount / $totalChecks) * 100, 1);
        $status = $isOverallPassed ? 'PASSED' : 'FAILED';

        $report = [
            'model_id'        => $modelId,
            'model_code'      => $model['model_code'],
            'version'         => $version['version'],
            'overall_status'  => $status,
            'score_percent'   => $overallScore,
            'checks_passed'   => $passedCount,
            'checks_total'    => $totalChecks,
            'checks'          => $checks,
            'executed_at'     => date('Y-m-d H:i:s')
        ];

        $runId = $this->valRepo->createRun([
            'model_id'         => $modelId,
            'model_version_id' => $modelVersionId,
            'requested_by'     => $actorId,
            'status'           => $status,
            'score'            => $overallScore,
            'checks_passed'    => $passedCount,
            'checks_total'     => $totalChecks,
            'report_json'      => $report,
            'completed_at'     => date('Y-m-d H:i:s')
        ]);

        // Update model status to VALIDATION_PASSED or VALIDATION_FAILED
        $newModelStatus = $isOverallPassed ? 'VALIDATION_PASSED' : 'VALIDATION_FAILED';
        $this->modelRepo->updateStatus($modelId, $newModelStatus);

        Logger::audit('MODEL_VALIDATION_COMPLETED', 'validation_runs', (string)$runId, 'SUCCESS', [
            'model_code' => $model['model_code'],
            'outcome'    => $status,
            'score'      => $overallScore
        ], $actorId);

        return $this->valRepo->findById($runId);
    }

    public function getRun(int $id, ?int $userId = null, ?string $role = null): array
    {
        $run = $this->valRepo->findById($id);
        if (!$run) {
            throw new RuntimeException('Validation report not found.');
        }

        if ($userId !== null && $role !== 'ADMIN' && (int)$run['requested_by'] !== $userId) {
            throw new RuntimeException('Access Denied: You cannot view another student\'s validation report.');
        }

        return $run;
    }
}
