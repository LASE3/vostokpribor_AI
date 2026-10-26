<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;

if (php_sapi_name() !== 'cli') {
    exit(1);
}

$action = $argv[1] ?? '';

switch ($action) {
    case 'fetch-next':
        $job = Database::queryOne(
            "SELECT * FROM execution_jobs WHERE status = 'QUEUED' ORDER BY created_at ASC LIMIT 1"
        );
        if ($job) {
            $claimed = Database::execute(
                "UPDATE execution_jobs SET status = 'RUNNING', started_at = NOW() WHERE id = :id AND status = 'QUEUED'",
                ['id' => $job['id']]
            );
            if ($claimed > 0) {
                echo json_encode(['found' => true, 'job' => $job]);
            } else {
                echo json_encode(['found' => false]);
            }
        } else {
            echo json_encode(['found' => false]);
        }
        break;

    case 'fetch-job':
        $uuid = $argv[2] ?? '';
        $job = Database::queryOne(
            "SELECT * FROM execution_jobs WHERE job_uuid = :uuid LIMIT 1",
            ['uuid' => $uuid]
        );
        if ($job && $job['status'] === 'QUEUED') {
            Database::execute(
                "UPDATE execution_jobs SET status = 'RUNNING', started_at = NOW() WHERE id = :id",
                ['id' => $job['id']]
            );
        }
        echo json_encode(['found' => (bool)$job, 'job' => $job]);
        break;

    case 'list-datasets':
        $studentId = (int)($argv[2] ?? 0);
        $datasets = Database::query(
            "SELECT d.code, d.format, d.file_path
             FROM dataset_assignments da
             JOIN datasets d ON da.dataset_id = d.id
             WHERE da.student_id = :s_id",
            ['s_id' => $studentId]
        );
        echo json_encode($datasets);
        break;

    case 'complete-job':
        // Payload passed via STDIN JSON
        $raw = file_get_contents('php://stdin');
        $payload = json_decode($raw, true);

        if ($payload) {
            $jobId = (int)($payload['job_id'] ?? 0);
            $status = $payload['status'] ?? 'COMPLETED';
            $stdout = $payload['stdout'] ?? '';
            $stderr = $payload['stderr'] ?? '';
            $exitCode = isset($payload['exit_code']) ? (int)$payload['exit_code'] : 0;
            $elapsedMs = (int)($payload['elapsed_ms'] ?? 0);
            $cellId = !empty($payload['cell_id']) ? (int)$payload['cell_id'] : null;
            $plotPath = $payload['plot_path'] ?? null;

            Database::execute(
                "UPDATE execution_jobs 
                 SET status = :status, stdout = :out, stderr = :err, exit_code = :code, 
                     execution_time_ms = :elapsed, completed_at = NOW() 
                 WHERE id = :id",
                [
                    'status'  => $status,
                    'out'     => $stdout,
                    'err'     => $stderr,
                    'code'    => $exitCode,
                    'elapsed' => $elapsedMs,
                    'id'      => $jobId
                ]
            );

            if ($cellId) {
                Database::execute(
                    "UPDATE notebook_cells 
                     SET output_text = :out, output_error = :err, output_image_path = :img, 
                         execution_count = COALESCE(execution_count, 0) + 1, last_executed_at = NOW() 
                     WHERE id = :c_id",
                    [
                        'out'  => $stdout,
                        'err'  => $stderr,
                        'img'  => $plotPath,
                        'c_id' => $cellId
                    ]
                );
            }

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
        }
        break;

    default:
        echo json_encode(['error' => 'Unknown action']);
        break;
}
