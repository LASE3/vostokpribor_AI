<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;

$db = Database::getInstance();

// Ensure a test notebook exists
$notebookId = $db->fetchValue("SELECT id FROM notebooks LIMIT 1");
if (!$notebookId) {
    $notebookId = $db->insert('notebooks', [
        'code' => 'NB-' . strtoupper(bin2hex(random_bytes(4))),
        'title' => 'telemetry_exploration.ipynb',
        'student_id' => 1,
        'status' => 'ACTIVE'
    ]);
}

$jobUuid = bin2hex(random_bytes(16));
$code = "import sys\nprint('VOSTOKPRIBOR ML Isolation Engine Active.')\nprint('Python Interpreter:', sys.version.split()[0])\nx = sum([i * 2 for i in range(10)])\nprint('Computed telemetry sum:', x)\n";

$jobId = $db->insert('execution_jobs', [
    'job_uuid' => $jobUuid,
    'notebook_id' => $notebookId,
    'student_id' => 1,
    'code_to_execute' => $code,
    'status' => 'QUEUED',
    'created_at' => date('Y-m-d H:i:s')
]);

echo "Job #$jobId (UUID: $jobUuid) enqueued into execution_jobs for Notebook #$notebookId.\n";

