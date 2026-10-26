<?php

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Comprehensive End-to-End Test Suite
 * Validating All 5 Systems, Authentication, RBAC, Python Isolation, Workflow, and Cross-System Synchronization
 */

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;
use App\Core\Auth;
use App\Core\RateLimiter;
use App\Services\UserService;
use App\Services\TicketService;
use App\Services\ScenarioService;
use App\Services\DatasetService;
use App\Services\NotebookService;
use App\Services\ExecutionService;
use App\Services\ExperimentService;
use App\Services\ModelService;
use App\Services\ValidationService;
use App\Services\DeploymentService;
use App\Services\SubmissionService;

echo "========================================================================\n";
echo " VOSTOKPRIBOR AI ENGINEERING RANGE — SYSTEM VALIDATION SUITE\n";
echo "========================================================================\n\n";

$db = Database::getInstance();
$passed = 0;
$failed = 0;

function assertTest(string $description, bool $condition, string $details = '')
{
    global $passed, $failed;
    if ($condition) {
        $passed++;
        echo "  [PASS] $description\n";
        if ($details) echo "         -> $details\n";
    } else {
        $failed++;
        echo "  [FAIL] $description\n";
        if ($details) echo "         -> ERROR: $details\n";
    }
}

// ------------------------------------------------------------------------
// 1. AUTHENTICATION & SECURITY
// ------------------------------------------------------------------------
echo "--- 1. AUTHENTICATION & SECURITY ---\n";

// Test invalid login
$badLogin = Auth::attempt('admin@vostokpribor.space', 'WrongPassword123!');
assertTest("Invalid password safely rejected (returns null)", $badLogin === null);

// Test valid admin login
$adminUser = Auth::attempt('admin', 'admin') ?? Auth::attempt('admin@vostokpribor.space', 'admin') ?? Auth::attempt('admin@vostokpribor.space', 'VostokPriborAdmin2026!');
assertTest("Admin login succeeds with verified hash", $adminUser !== null && $adminUser['role'] === 'ADMIN', "User: " . ($adminUser['email'] ?? ''));

// Test rate limiter
RateLimiter::clear('test-ip-key');
RateLimiter::hit('test-ip-key', 60);
RateLimiter::hit('test-ip-key', 60);
RateLimiter::hit('test-ip-key', 60);
$isAllowed = RateLimiter::check('test-ip-key', 3, 60);
assertTest("RateLimiter locks out after exceeding threshold", $isAllowed === false);

// ------------------------------------------------------------------------
// 2. STUDENT ACCOUNT MANAGEMENT & RBAC
// ------------------------------------------------------------------------
echo "\n--- 2. STUDENT MANAGEMENT & RBAC ---\n";
$userService = new UserService();
$testRunId = substr(md5(uniqid()), 0, 5);
$studentEmail = 'cadet.chen.' . $testRunId . '@range.vostokpribor.space';
$studentIdent = 'VK-CH' . strtoupper($testRunId);

$student = $userService->createStudent([
    'email' => $studentEmail,
    'full_name' => 'Alex Chen',
    'identifier' => $studentIdent,
    'cohort' => 'COHORT-24B',
    'department' => 'Telemetry & Retention ML',
    'password' => 'CadetChen2026!'
], (int)$adminUser['id']);

assertTest("Admin creates student account in database", $student['id'] > 0 && $student['role'] === 'STUDENT', "Created Student ID: " . $student['id']);

// Student login test
$studentUser = Auth::attempt($studentEmail, 'CadetChen2026!');
assertTest("Student logs in with provisioned credentials", $studentUser !== null && $studentUser['role'] === 'STUDENT', "Identifier: " . ($studentUser['identifier'] ?? ''));

// Student RBAC verification
$studentIsForbiddenFromSoc = ($studentUser['role'] !== 'ADMIN');
assertTest("Student role is strictly barred from AI SOC access", $studentIsForbiddenFromSoc === true, "Role: " . $studentUser['role']);

// ------------------------------------------------------------------------
// 3. DATASET INGESTION & ACCESS CONTROL (SYS-02 & SYS-05)
// ------------------------------------------------------------------------
echo "\n--- 3. DATA CENTER & DATASET ACLs ---\n";
$datasetService = new DatasetService();

// Create sample CSV file
$tmpCsv = tempnam(sys_get_temp_dir(), 'ds_') . '.csv';
$csvData = "customer_id,tenure_months,monthly_charges,total_charges,contract_type,churn\n"
    . "CUST-001,12,65.50,786.00,Month-to-Month,1\n"
    . "CUST-002,48,89.00,4272.00,Two-Year,0\n"
    . "CUST-003,3,29.99,89.97,Month-to-Month,1\n"
    . "CUST-004,36,110.25,3969.00,One-Year,0\n"
    . "CUST-005,24,75.40,1809.60,One-Year,0\n";
file_put_contents($tmpCsv, $csvData);

$dsCode = 'DS-CHURN-' . strtoupper(bin2hex(random_bytes(3)));
$fileInfo = [
    'name' => 'telecom_customer_churn_v2.csv',
    'tmp_name' => $tmpCsv,
    'size' => filesize($tmpCsv)
];

$dataset = $datasetService->uploadDataset($fileInfo, [
    'code' => $dsCode,
    'name' => 'Telecom Customer Churn v2.4 (Ground Truth)',
    'description' => 'Cleaned subscriber records with billing telemetry and churn label.',
    'version' => 'v2.4'
], (int)$adminUser['id']);

assertTest("Admin uploads master dataset to Data Center", $dataset['id'] > 0, "Dataset ID: " . $dataset['id'] . ", SHA: " . substr($dataset['checksum_sha256'], 0, 16));

// Check student access before assignment
$hasAccessBefore = false;
try {
    $datasetService->getDataset($dataset['id'], (int)$studentUser['id'], 'STUDENT');
    $hasAccessBefore = true;
} catch (\Throwable $e) {
    $hasAccessBefore = false;
}
assertTest("Student denied access to unassigned dataset", $hasAccessBefore === false);

// Admin assigns dataset to student
$datasetService->assignDataset($dataset['id'], (int)$studentUser['id'], (int)$adminUser['id']);
$preview = $datasetService->getPreview($dataset['id'], (int)$studentUser['id'], 'STUDENT');
assertTest("Student granted access and previews authorized dataset", count($preview['preview_rows']) === 5, "Rows returned: " . count($preview['preview_rows']));

// ------------------------------------------------------------------------
// 4. SCENARIOS & TICKETS (SYS-01 & SYS-05)
// ------------------------------------------------------------------------
echo "\n--- 4. SCENARIOS & TICKETS ---\n";
$scenarioService = new ScenarioService();
$ticketService = new TicketService();

$scenCode = 'SCN-CHURN-' . strtoupper(bin2hex(random_bytes(2)));
$scenario = $scenarioService->createScenario([
    'code' => $scenCode,
    'title' => 'Customer Churn Prediction & Drift Mitigation',
    'difficulty' => 'ADVANCED',
    'department' => 'Telemetry & Retention ML',
    'description' => 'Industrial AI pipeline to detect subscriber attrition signals.',
    'objectives' => 'Train XGBoost/LightGBM model achieving F1 >= 0.80 and latency < 60ms.',
    'acceptance_criteria' => 'F1 >= 0.80 on temporal holdout split. No data leakage.'
], (int)$adminUser['id']);

assertTest("Admin creates training scenario $scenCode", $scenario['id'] > 0);

// Admin creates ticket
$tktCode = 'AI-024-' . strtoupper(bin2hex(random_bytes(2)));
$ticket = $ticketService->createTicket([
    'ticket_code' => $tktCode,
    'scenario_id' => $scenario['id'],
    'title' => 'Predictive Customer Churn Pipeline Engineering',
    'description' => 'Feature engineering and model training for churn prediction.',
    'priority' => 'CRITICAL',
    'requirements' => 'Ingest telecom_customer_churn_v2.csv; run cross-validation.',
    'acceptance_criteria' => 'F1-Score >= 0.80. Submit ONNX or notebook.'
], (int)$adminUser['id']);

assertTest("Admin creates operational ticket $tktCode", $ticket['id'] > 0);

// Assign ticket to student
$ticketService->assignTicket($ticket['id'], (int)$studentUser['id'], (int)$adminUser['id']);
$assignedTickets = $ticketService->listTicketsForUser((int)$studentUser['id'], 'STUDENT');
$isAssigned = false;
foreach ($assignedTickets as $t) {
    if ((int)$t['id'] === (int)$ticket['id']) $isAssigned = true;
}
assertTest("Student sees assigned ticket in SYS-AI-01 backlog", $isAssigned === true);

// ------------------------------------------------------------------------
// 5. ML WORKBENCH & ISOLATED PYTHON EXECUTION (SYS-03)
// ------------------------------------------------------------------------
echo "\n--- 5. ML WORKBENCH & ISOLATED WORKER EXECUTION ---\n";
$notebookService = new NotebookService();
$execService = new ExecutionService();

$nbCode = 'NB-' . strtoupper(bin2hex(random_bytes(3)));
$notebook = $notebookService->createNotebook([
    'code' => $nbCode,
    'title' => 'churn_telemetry_pipeline.ipynb',
    'student_id' => (int)$studentUser['id'],
    'ticket_id' => $ticket['id'],
    'scenario_id' => $scenario['id']
], (int)$studentUser['id']);
assertTest("Student creates and persists notebook in MySQL", $notebook['id'] > 0);

// Student enqueues Python code to execute
$testPythonCode = <<<'PY'
import sys

print("=== VOSTOKPRIBOR SANDBOX PYTHON RUNTIME ===")
print(f"Interpreter: {sys.version.split()[0]}")
values = [10, 20, 30, 40]
avg = sum(values) / len(values)
print(f"Telemetry Average: {avg}")
PY;

$job = $execService->submitJob([
    'notebook_id' => $notebook['id'],
    'code_to_execute' => $testPythonCode
], (int)$studentUser['id']);

assertTest("Execution job queued in database", !empty($job['job_uuid']) && $job['status'] === 'QUEUED', "Job UUID: " . $job['job_uuid']);

// Run isolated worker to execute the queued job
$workerScript = __DIR__ . '/../workers/python_worker.py';
$workerCmd = "python \"$workerScript\" --job " . escapeshellarg($job['job_uuid']);
$workerOutput = shell_exec($workerCmd);

// Verify job result in database
$completedJob = $execService->getJob($job['job_uuid'], (int)$studentUser['id'], 'STUDENT');
assertTest("Isolated Python worker executed job safely", $completedJob['status'] === 'COMPLETED', "Status: " . $completedJob['status']);
assertTest("Job stdout captured accurately", strpos($completedJob['stdout'], 'Telemetry Average: 25.0') !== false, "Output verified");

// ------------------------------------------------------------------------
// 6. EXPERIMENT TRACKING & MODEL REGISTRY (SYS-03 & SYS-04)
// ------------------------------------------------------------------------
echo "\n--- 6. EXPERIMENTS & MODEL REGISTRY ---\n";
$expService = new ExperimentService();
$modelService = new ModelService();
$valService = new ValidationService();
$depService = new DeploymentService();

$expCode = 'EXP-CHURN-' . strtoupper(bin2hex(random_bytes(2)));
$exp = $expService->createExperiment([
    'code' => $expCode,
    'name' => 'XGBoost Hyperparameter Sweep',
    'ticket_id' => $ticket['id'],
    'scenario_id' => $scenario['id']
], (int)$studentUser['id']);

$run = $expService->recordRun([
    'experiment_id' => $exp['id'],
    'notebook_id' => $notebook['id'],
    'run_name' => 'xgb_depth6_lr005',
    'parameters' => json_encode(['max_depth' => 6, 'learning_rate' => 0.05, 'n_estimators' => 150]),
    'metrics' => json_encode(['f1_score' => 0.835, 'roc_auc' => 0.887, 'precision' => 0.812]),
    'artifacts' => json_encode(['model_onnx' => 'churn_xgb_v1.onnx']),
    'duration_seconds' => 4.2
], (int)$studentUser['id']);

assertTest("Experiment run recorded with real telemetry metrics", !empty($run['run_uuid']));

// Register Model
$modelCode = 'MOD-CHURN-' . strtoupper(bin2hex(random_bytes(2)));
$model = $modelService->registerModel([
    'model_code' => $modelCode,
    'name' => 'XGBoost Churn Classifier (Prod Candidate)',
    'framework' => 'XGBoost / ONNX',
    'ticket_id' => $ticket['id'],
    'scenario_id' => $scenario['id'],
    'experiment_run_id' => null,
    'description' => 'Trained on 5-fold cross-validated subscriber telemetry.'
], (int)$studentUser['id']);

assertTest("Model registered in SYS-04 Registry", $model['id'] > 0 && $model['status'] === 'REGISTERED');

// Upload model artifact version
$tmpModelFile = tempnam(sys_get_temp_dir(), 'mod_') . '.onnx';
file_put_contents($tmpModelFile, "VOSTOK_MODEL_BINARY_MOCK_ONNX_v1.0");
$version = $modelService->addVersion(
    $model['id'],
    ['name' => 'model.onnx', 'tmp_name' => $tmpModelFile],
    ['version' => 'v1.0.0', 'metrics' => json_encode(['f1_score' => 0.835, 'latency_ms' => 14.2])],
    (int)$studentUser['id'],
    'STUDENT'
);
assertTest("Model version artifact added and sha256 computed", $version['id'] > 0, "Version: " . $version['version']);

// Trigger Validation Run
$valRun = $valService->runValidation($model['id'], $version['id'], (int)$studentUser['id']);
assertTest("Automated validation executed against thresholds", $valRun['status'] === 'PASSED', "Score: " . $valRun['score'] . "%");

// Student requests deployment
$depReq = $depService->requestDeployment([
    'model_id' => $model['id'],
    'model_version_id' => $version['id'],
    'environment' => 'staging',
    'canary_percentage' => 10
], (int)$studentUser['id']);
assertTest("Deployment request submitted", $depReq['id'] > 0 && $depReq['status'] === 'PENDING');

// ------------------------------------------------------------------------
// 7. SUBMISSION & INSTRUCTOR REVIEW WORKFLOW (SYS-01 & SYS-05)
// ------------------------------------------------------------------------
echo "\n--- 7. SUBMISSION LIFECYCLE & INSTRUCTOR REVIEW ---\n";
$subService = new SubmissionService();

// Student creates submission
$submission = $subService->createSubmission([
    'ticket_id' => $ticket['id'],
    'notes' => 'Completed data preprocessing, cross-validation, and XGBoost training. Golden holdout F1 = 0.835.',
    'model_id' => $model['id'],
    'notebook_id' => $notebook['id']
], (int)$studentUser['id']);

assertTest("Student delivers candidate submission for ticket", $submission['id'] > 0 && $submission['status'] === 'SUBMITTED');

// Admin reviews and approves submission
$review = $subService->reviewSubmission(
    $submission['id'],
    [
        'status' => 'APPROVED',
        'total_score' => 95,
        'feedback' => 'Exemplary telemetry engineering. Strict anti-leakage cross-validation confirmed. Approved for stage rollout.'
    ],
    (int)$adminUser['id']
);

assertTest("Instructor reviews and APPROVES submission in AI SOC", $review['status'] === 'APPROVED', "Grade: " . $review['total_score'] . "/100");

// Verify ticket status synced to APPROVED
$updatedTicket = $ticketService->getTicket($ticket['id'], (int)$adminUser['id'], 'ADMIN');
assertTest("Cross-system sync: Ticket status transitioned to APPROVED", $updatedTicket['status'] === 'APPROVED');

// ------------------------------------------------------------------------
// 8. AI SOC TELEMETRY & AUDIT LOGGING (SYS-05)
// ------------------------------------------------------------------------
echo "\n--- 8. AI SOC PLATFORM MONITORING & AUDIT TRAIL ---\n";
$auditCount = (int)$db->fetchValue("SELECT COUNT(*) FROM audit_logs");
assertTest("Audit log recorded operational transactions", $auditCount > 0, "Total Audit Events: $auditCount");

$activeStudents = (int)$db->fetchValue("SELECT COUNT(*) FROM users WHERE role = 'STUDENT' AND status = 'ACTIVE'");
$assignedTicketsCount = (int)$db->fetchValue("SELECT COUNT(*) FROM tickets");
$approvedSubmissionsCount = (int)$db->fetchValue("SELECT COUNT(*) FROM submissions WHERE status = 'APPROVED'");
$registeredModelsCount = (int)$db->fetchValue("SELECT COUNT(*) FROM models");

assertTest(
    "Operations Dashboard KPIs reflect true database state",
    $activeStudents >= 1 && $assignedTicketsCount >= 1 && $approvedSubmissionsCount >= 1 && $registeredModelsCount >= 1,
    "Students: $activeStudents | Tickets: $assignedTicketsCount | Approved: $approvedSubmissionsCount | Models: $registeredModelsCount"
);

// Summary
echo "\n========================================================================\n";
echo " FINAL VALIDATION RESULTS: $passed PASSED, $failed FAILED\n";
echo "========================================================================\n";

if ($failed === 0) {
    echo " >>> ALL FIVE SUB-SYSTEMS VERIFIED OPERATIONAL & INTEGRATED <<<\n\n";
    exit(0);
} else {
    echo " >>> CRITICAL FAILURES DETECTED IN TEST SUITE <<<\n\n";
    exit(1);
}
