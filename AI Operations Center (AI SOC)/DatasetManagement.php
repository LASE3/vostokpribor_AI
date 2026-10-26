<?php
// VOSTOKPRIBOR AI • SYS-AI-05: AI Operations Center (AI SOC) - Dataset Management
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthorizationMiddleware;
use App\Core\Database;
use App\Core\Auth;
use App\Core\Csrf;

AuthorizationMiddleware::requireAdmin();
$currentUser = Auth::user();
$db = Database::getInstance();

$msg = '';
$err = '';

// Handle Upload New Dataset POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_dataset') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $err = "Security token expired or invalid. Please try again.";
    } else {
        $name = trim($_POST['name'] ?? '');
        $code = trim($_POST['code'] ?? '');
        $format = strtoupper(trim($_POST['format'] ?? 'CSV'));
        $desc = trim($_POST['description'] ?? '');
        $scenarioId = !empty($_POST['scenario_id']) ? (int)$_POST['scenario_id'] : null;

        if (empty($name) || empty($code)) {
            $err = "Dataset Name and Code are required.";
        } elseif (!isset($_FILES['dataset_file']) || $_FILES['dataset_file']['error'] !== UPLOAD_ERR_OK) {
            $err = "A valid dataset file must be provided.";
        } else {
            $file = $_FILES['dataset_file'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['csv', 'json', 'parquet', 'txt'])) {
                $err = "Unsupported file format (allowed: CSV, JSON, Parquet, TXT).";
            } else {
                $storageDir = __DIR__ . '/../storage/private/datasets';
                if (!is_dir($storageDir)) {
                    mkdir($storageDir, 0755, true);
                }
                $safeName = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file['name']);
                $storageFilename = time() . '_' . $safeName;
                $targetPath = $storageDir . '/' . $storageFilename;
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $fileSize = filesize($targetPath);
                    $checksum = hash_file('sha256', $targetPath);
                    $rowCount = 0;
                    $colCount = 0;

                    if ($ext === 'csv') {
                        if (($handle = fopen($targetPath, "r")) !== false) {
                            $header = fgetcsv($handle);
                            if ($header) $colCount = count($header);
                            while (fgets($handle) !== false) $rowCount++;
                            fclose($handle);
                        }
                    } elseif ($ext === 'json') {
                        $jsonContent = json_decode(file_get_contents($targetPath), true);
                        if (is_array($jsonContent)) {
                            $rowCount = count($jsonContent);
                            if ($rowCount > 0 && is_array($jsonContent[0])) {
                                $colCount = count($jsonContent[0]);
                            }
                        }
                    }

                    Database::transaction(function() use ($db, $code, $name, $desc, $format, $storageFilename, $fileSize, $checksum, $rowCount, $colCount, $scenarioId, $currentUser, &$dsId) {
                        $dsId = $db->insert('datasets', [
                            'code' => $code,
                            'name' => $name,
                            'description' => $desc,
                            'format' => $format,
                            'file_path' => $storageFilename,
                            'file_size' => $fileSize,
                            'checksum_sha256' => $checksum,
                            'row_count' => $rowCount,
                            'column_count' => $colCount,
                            'is_master' => 1,
                            'version' => 'v1.0',
                            'scenario_id' => $scenarioId,
                            'uploaded_by' => $currentUser['id']
                        ]);

                        $db->insert('audit_logs', [
                            'user_id' => $currentUser['id'],
                            'action' => 'DATASET_UPLOAD',
                            'resource_type' => 'DATASET',
                            'resource_id' => $dsId,
                            'outcome' => 'SUCCESS',
                            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                            'details_json' => json_encode(['code' => $code, 'name' => $name, 'format' => $format])
                        ]);
                    });

                    $msg = "Dataset '$name' uploaded and indexed successfully into Data Lake.";
                } else {
                    $err = "Failed to store uploaded dataset file.";
                }
            }
        }
    }
}

// Handle Assign Dataset POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'assign_dataset') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $err = "Security token expired or invalid.";
    } else {
        $datasetId = (int)($_POST['dataset_id'] ?? 0);
        $studentId = (int)($_POST['student_id'] ?? 0);
        if ($datasetId > 0 && $studentId > 0) {
            $existing = $db->fetchOne("SELECT id FROM dataset_assignments WHERE dataset_id = :did AND student_id = :sid", [
                'did' => $datasetId,
                'sid' => $studentId
            ]);
            if (!$existing) {
                Database::transaction(function() use ($db, $datasetId, $studentId, $currentUser) {
                    $db->insert('dataset_assignments', [
                        'dataset_id' => $datasetId,
                        'student_id' => $studentId,
                        'assigned_by' => $currentUser['id']
                    ]);
                    $db->insert('audit_logs', [
                        'user_id' => $currentUser['id'],
                        'action' => 'DATASET_ASSIGN',
                        'resource_type' => 'DATASET',
                        'resource_id' => $datasetId,
                        'outcome' => 'SUCCESS',
                        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                        'details_json' => json_encode(['student_id' => $studentId])
                    ]);
                });
                $msg = "Dataset assigned to student successfully.";
            } else {
                $msg = "Dataset was already assigned to this student.";
            }
        }
    }
}

$datasets = $db->fetchAll("
    SELECT d.*, u.full_name AS uploaded_by_name, s.title AS scenario_title,
           (SELECT COUNT(*) FROM dataset_assignments WHERE dataset_id = d.id) AS assigned_students_count
    FROM datasets d
    LEFT JOIN users u ON d.uploaded_by = u.id
    LEFT JOIN scenarios s ON d.scenario_id = s.id
    ORDER BY d.created_at DESC
");
$students = $db->fetchAll("SELECT id, full_name, identifier, email FROM users WHERE role = 'STUDENT' AND status = 'ACTIVE' ORDER BY full_name ASC");
$scenarios = $db->fetchAll("SELECT id, code, title FROM scenarios ORDER BY created_at DESC");

$selectedDatasetId = isset($_GET['id']) ? (int)$_GET['id'] : (!empty($datasets) ? (int)$datasets[0]['id'] : 0);
$selectedDataset = null;
foreach ($datasets as $d) {
    if ((int)$d['id'] === $selectedDatasetId) {
        $selectedDataset = $d;
        break;
    }
}
if (!$selectedDataset && !empty($datasets)) {
    $selectedDataset = $datasets[0];
}

$csrfToken = Csrf::getToken();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="web_dashboard" name="shell-type">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;family=JetBrains+Mono:wght@100..900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="fiberglass-bg font-body-md text-on-surface min-h-screen">
    <header class="fixed top-0 left-0 right-0 h-16 bg-surface-container-lowest/90 backdrop-blur-md shadow-[0_1px_8px_rgba(76,29,149,0.06)] z-50 flex items-center justify-between px-margin-desktop">
        <div class="flex items-center gap-space-lg">
            <div class="flex items-center gap-space-sm"><img alt="VOSTOKPRIBOR Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1WFY3uXJ_9VBQSYhio3LVjLuY04weLyokzp987wSe7sNmLm6J_v-iBWBRUy3suJiuOvORdi5ycPrycJRlBFblqocpH7MR32xcHH09--U1FZEYb_N7dqQPHlWW5BW_vPyKR6necxQ856c6yxbD1S94T0POQSl-8SC_gqw2chw0ZgIDADFAOBMGy7ZpT4PuJKdlN_YkmHcsGM8Ou4GukoU-klYJiuzJdHRIk4WL9qKtKyBqjVPsyWFLOElrc">
                <div class="flex flex-col"><span class="font-headline-sm text-headline-sm text-primary tracking-tight">VOSTOKPRIBOR</span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Range AI Control</span></div>
            </div>
            <div class="h-6 w-px bg-surface-container-highest"></div>
            <nav class="hidden xl:flex items-center gap-space-xs p-1 bg-surface-container-low rounded-lg" data-active-classes="bg-secondary-container text-primary font-bold"><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-tickets" href="../AI Project Management/Dashboard.php">SYS-AI-01</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-data" href="../Data Center/dashboard.php">SYS-AI-02</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-workbench" href="../ML Workbench/NotebookWorkbench.php">SYS-AI-03</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-models" href="../Model Registry & Deployment/dashboard.php">SYS-AI-04</a><a class="px-space-sm py-1 rounded bg-primary-container text-white font-bold font-label-md text-label-md shadow-sm" data-path="dashboard" href="TicketsAndScenarios.php">SYS-AI-05 [ACTIVE]</a></nav>
        </div>
        <div class="flex items-center gap-space-md">
            <div class="hidden md:flex items-center gap-space-xs bg-surface-container px-space-md py-1.5 rounded-lg w-64 text-on-surface-variant"><span class="material-symbols-outlined text-[18px]">search</span><span class="font-body-sm text-body-sm text-on-surface-variant">Search telemetry, models...</span></div>
            <div class="hidden lg:flex items-center gap-space-xs bg-tertiary-fixed text-on-tertiary-fixed px-space-sm py-1 rounded-full font-label-sm text-label-sm"><span class="w-2 h-2 rounded-full bg-error animate-pulse"></span><span class="">SCN-904-ALPHA (LIVE)</span></div><button class="relative p-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1.5 right-1.5 w-2 h-2 bg-error rounded-full"></span></button>
            <div class="flex items-center gap-space-sm pl-space-xs">
                <div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md text-on-surface leading-tight"><?= htmlspecialchars($currentUser['full_name']) ?></span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase"><?= htmlspecialchars($currentUser['role']) ?></span></div>
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
            </div>
        </div>
    </header>
    <aside class="fixed left-0 top-16 bottom-0 w-72 bg-surface-container-lowest shadow-[0_1px_8px_rgba(76,29,149,0.04)] z-40 overflow-y-auto">
        <div class="p-space-md flex flex-col gap-space-lg">
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Overview</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="main-dashboard" href="Dashboard.php"><span class="material-symbols-outlined text-[18px]">space_dashboard</span><span class="font-body-md text-body-md">Main Dashboard</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="training-analytics" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Training Analytics</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Training Management</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="tickets-and-scenarios" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Tickets &amp; Scenarios</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="dataset-management" href="DatasetManagement.php"><span class="material-symbols-outlined text-[18px]">database</span><span class="font-body-md text-body-md">Dataset Management</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="students-and-cohorts" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">group</span><span class="font-body-md text-body-md">Students &amp; Cohorts</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="submission-reviews" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">fact_check</span><span class="font-body-md text-body-md">Submission Reviews</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="grading-and-feedback" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">rate_review</span><span class="font-body-md text-body-md">Grading &amp; Feedback</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Platform Administration</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="subsystem-control" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">memory</span><span class="font-body-md text-body-md">Subsystem Control</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="workspace-configuration" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">settings_input_component</span><span class="font-body-md text-body-md">Workspace Configuration</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="users-and-permissions" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">admin_panel_settings</span><span class="font-body-md text-body-md">Users &amp; Permissions</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="audit-logs" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">receipt_long</span><span class="font-body-md text-body-md">Audit Logs</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">AI Operations</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="operations-dashboard" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">hub</span><span class="font-body-md text-body-md">Operations Dashboard</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="model-monitoring" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">monitoring</span><span class="font-body-md text-body-md">Model Monitoring</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="alerts-and-incidents" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">warning</span><span class="font-body-md text-body-md">Alerts &amp; Incidents</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="deployment-history" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">history</span><span class="font-body-md text-body-md">Deployment History</span></a>
            </nav>
        </div>
    </aside>
    <div class="pl-72">
        <main class="relative pt-16 min-h-screen px-margin-desktop py-margin">
            <div class="flex flex-col w-full">
<?php if (!empty($msg)): ?>
    <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-800 font-mono text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">check_circle</span>
        <span><?= htmlspecialchars($msg) ?></span>
    </div>
<?php endif; ?>
<?php if (!empty($err)): ?>
    <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-300 text-rose-800 font-mono text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-rose-600">error</span>
        <span><?= htmlspecialchars($err) ?></span>
    </div>
<?php endif; ?>
                <!-- 1. Header / Command Breadcrumb & Status Ribbon -->
                <div class="flex flex-col gap-space-sm mb-space-lg">
                    <div class="flex flex-wrap items-center justify-between gap-space-md">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-space-xs font-label-md text-label-md text-on-surface-variant mb-1">
                                <span class="hover:text-primary transition-colors">SYS-AI-05</span>
                                <span class="">/</span>
                                <span class="hover:text-primary transition-colors">TRAINING MANAGEMENT</span>
                                <span class="">/</span>
                                <span class="text-primary font-bold">DATASET REPOSITORY &amp; GOVERNANCE</span>
                            </div>
                            <div class="flex items-center gap-space-sm">
                                <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">Dataset Administration &amp; Versioning</h1>
                                <span class="inline-flex items-center gap-1.5 px-space-sm py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary animate-ping"></span>
                                    SYS-AI-02 SYNC ACTIVE
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <button class="flex items-center gap-space-xs px-space-md py-2 rounded-lg bg-surface-container-lowest text-primary font-label-md text-label-md shadow-sm hover:bg-secondary-fixed transition-all">
                                <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                                <span class="">Export Manifest (JSON)</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-md py-2 rounded-lg bg-surface-container-lowest text-primary font-label-md text-label-md shadow-sm hover:bg-secondary-fixed transition-all">
                                <span class="material-symbols-outlined text-[18px]">security_update_good</span>
                                <span class="">Run Integrity Scan</span>
                            </button>
                            <button onclick="document.getElementById('modal-upload-dataset').classList.remove('hidden')" class="flex items-center gap-space-xs px-space-md py-2 rounded-lg bg-primary-container text-on-primary font-label-md text-label-md shadow-md hover:bg-primary transition-all cursor-pointer"><span class="material-symbols-outlined text-[18px]">add_box</span><span>+ Register Dataset / Version</span></button><button onclick="document.getElementById('modal-assign-dataset').classList.remove('hidden')" class="flex items-center gap-space-xs px-space-md py-2 rounded-lg bg-secondary-fixed text-primary font-label-md text-label-md shadow-sm hover:bg-secondary-fixed/80 transition-all cursor-pointer"><span class="material-symbols-outlined text-[18px]">person_add</span><span>Assign to Cadet</span></button>
                        </div>
                    </div>
                    <!-- Telemetry Sub-Band -->
                    <div class="w-full flex flex-wrap items-center justify-between px-space-md py-2 bg-surface-container-low rounded-lg text-on-surface-variant font-label-sm text-label-sm shadow-sm">
                        <div class="flex items-center gap-space-md flex-wrap">
                            <span class="flex items-center gap-1 text-primary">
                                <span class="material-symbols-outlined text-[16px]">cloud_sync</span>
                                SYS-AI-02 LAKEHOUSE CONNECTOR: <strong class="font-bold">S3 COMPATIBLE (OK)</strong>
                            </span>
                            <span class="text-outline-variant">•</span>
                            <span class="">LATENCY: <strong class="text-on-surface">18ms</strong></span>
                            <span class="text-outline-variant">•</span>
                            <span class="">LAST AUDIT SYNC: <strong class="text-on-surface">3 mins ago (08:42:19 UTC)</strong></span>
                        </div>
                        <div class="flex items-center gap-space-xs text-primary font-label-sm">
                            <span class="material-symbols-outlined text-[16px] text-tertiary">verified_user</span>
                            <span class="">IMMUTABLE AUDIT LEDGER: <span class="bg-tertiary-fixed text-on-tertiary-fixed px-1.5 py-0.5 rounded font-bold">BLOCK #914,882</span></span>
                        </div>
                    </div>
                </div>
                <!-- 2. Metric / Summary Cards Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md mb-space-lg">
                    <!-- Card 1 -->
                    <div class="flex flex-col p-space-md bg-surface-container-lowest rounded-xl shadow-sm">
                        <div class="flex items-center justify-between text-on-surface-variant mb-2">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Managed Repositories</span>
                            <span class="material-symbols-outlined text-primary text-[20px]">database</span>
                        </div>
                        <div class="flex items-baseline gap-space-xs">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold"><?= count($datasets) ?></span><span class="font-label-md text-label-md text-on-surface-variant">Datasets</span>
                        </div>
                        <div class="flex items-center justify-between mt-space-sm pt-space-xs font-label-sm text-label-sm text-on-surface-variant">
                            <span class="">Total Footprint</span>
                            <span class="font-bold text-primary"><?= number_format(array_sum(array_column($datasets, 'file_size')) / (1024 * 1024), 2) ?> MB</span>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="flex flex-col p-space-md bg-surface-container-lowest rounded-xl shadow-sm">
                        <div class="flex items-center justify-between text-on-surface-variant mb-2">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">SYS-AI-02 Sync Health</span>
                            <span class="material-symbols-outlined text-primary text-[20px]">sync</span>
                        </div>
                        <div class="flex items-baseline gap-space-xs">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold">14/14</span>
                            <span class="font-label-md text-label-md text-primary font-semibold">100% Synced</span>
                        </div>
                        <div class="flex items-center justify-between mt-space-sm pt-space-xs font-label-sm text-label-sm text-on-surface-variant">
                            <span class="">Partitions Verified</span>
                            <span class="font-bold text-primary">128 Partition Blocks</span>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="flex flex-col p-space-md bg-surface-container-lowest rounded-xl shadow-sm">
                        <div class="flex items-center justify-between text-on-surface-variant mb-2">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Scenario Bindings</span>
                            <span class="material-symbols-outlined text-primary text-[20px]">hub</span>
                        </div>
                        <div class="flex items-baseline gap-space-xs">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold"><?= count(array_unique(array_filter(array_column($datasets, 'scenario_id')))) ?></span><span class="font-label-md text-label-md text-on-surface-variant">Active Scenarios</span>
                        </div>
                        <div class="flex items-center justify-between mt-space-sm pt-space-xs font-label-sm text-label-sm text-on-surface-variant">
                            <span class="">Target Cohorts</span>
                            <span class="font-bold text-primary">2025-A &amp; 2025-B</span>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="flex flex-col p-space-md bg-surface-container-lowest rounded-xl shadow-sm">
                        <div class="flex items-center justify-between text-on-surface-variant mb-2">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Integrity &amp; Drift Guard</span>
                            <span class="material-symbols-outlined text-primary text-[20px]">fact_check</span>
                        </div>
                        <div class="flex items-baseline gap-space-xs">
                            <span class="font-headline-xl text-headline-xl text-primary font-bold">0</span>
                            <span class="font-label-md text-label-md text-primary font-semibold">Violations / Null Err</span>
                        </div>
                        <div class="flex items-center justify-between mt-space-sm pt-space-xs font-label-sm text-label-sm text-on-surface-variant">
                            <span class="">Schema Drift Metric</span>
                            <span class="font-bold text-primary">PSI &lt; 0.04 (Nominal)</span>
                        </div>
                    </div>
                </div>
                <!-- 3. Asymmetric Split Workbench: Catalog (Left) & Deep Inspector (Right) -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg items-start">
                    <!-- LEFT COLUMN: Catalog & Version Register (5 cols on 12-col grid ~ 38%) -->
                    <div class="xl:col-span-4 flex flex-col gap-space-md">
                        <!-- Search & Filters Panel -->
                        <div class="flex flex-col p-space-md bg-surface-container-lowest rounded-xl shadow-sm gap-space-sm">
                            <div class="flex items-center justify-between">
                                <span class="font-label-md text-label-md text-primary font-bold uppercase tracking-wider">Dataset Index</span>
                                <span class="font-label-sm text-label-sm bg-secondary-fixed text-on-secondary-fixed px-2 py-0.5 rounded-full">14 Datasets</span>
                            </div>
                            <!-- Filter Bar -->
                            <div class="relative w-full">
                                <span class="material-symbols-outlined absolute left-3 top-2.5 text-[18px] text-on-surface-variant">search</span>
                                <input class="w-full pl-9 pr-3 py-2 bg-surface-container-low rounded-lg font-body-sm text-body-sm text-on-surface focus:outline-none focus:ring-2 focus:ring-primary-container" placeholder="Filter by slug, scenario, format..." type="text" value="churn">
                            </div>
                            <!-- Format Filter Pills -->
                            <div class="flex items-center gap-space-xs overflow-x-auto pb-1">
                                <button class="px-2.5 py-1 rounded-full bg-primary-container text-on-primary font-label-sm text-label-sm whitespace-nowrap">All (14)</button>
                                <button class="px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm hover:text-primary whitespace-nowrap">Parquet (8)</button>
                                <button class="px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm hover:text-primary whitespace-nowrap">JSONL (3)</button>
                                <button class="px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm hover:text-primary whitespace-nowrap">Tar/Vision (2)</button>
                                <button class="px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-label-sm text-label-sm hover:text-primary whitespace-nowrap">Feather (1)</button>
                            </div>
                        </div>
                        <!-- Dataset List Cards -->
<div class="flex flex-col gap-space-xs">
    <?php if (empty($datasets)): ?>
        <div class="p-4 bg-surface-container-lowest rounded-xl border border-dashed border-outline-variant text-center text-on-surface-variant text-xs">
            <span class="material-symbols-outlined text-2xl mb-1 text-outline">database</span>
            <p>No master datasets indexed yet.</p>
            <p class="mt-1">Click "+ Register Dataset / Version" above to index a new catalog entry.</p>
        </div>
    <?php else: ?>
        <?php foreach ($datasets as $ds): ?>
            <?php $isSelected = ($selectedDataset && $selectedDataset['id'] === $ds['id']); ?>
            <a href="DatasetManagement.php?id=<?= $ds['id'] ?>" class="flex flex-col p-space-md <?= $isSelected ? 'bg-secondary-fixed/40' : 'bg-surface-container-lowest hover:bg-surface-container-low' ?> rounded-xl shadow-sm transition-all relative overflow-hidden block">
                <?php if ($isSelected): ?>
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-primary-container"></div>
                <?php endif; ?>
                <div class="flex items-start justify-between gap-space-sm pl-1">
                    <div class="flex flex-col min-w-0">
                        <div class="flex items-center gap-space-xs">
                            <span class="font-label-md text-label-md font-bold text-primary truncate"><?= htmlspecialchars($ds['name']) ?></span>
                        </div>
                        <span class="font-body-sm text-body-sm text-on-surface-variant truncate"><?= htmlspecialchars($ds['format']) ?> • <?= number_format($ds['row_count']) ?> rows • <?= (int)$ds['column_count'] ?> features</span>
                    </div>
                    <span class="px-2 py-0.5 rounded <?= $isSelected ? 'bg-primary-container text-on-primary' : 'bg-surface-container text-primary' ?> font-label-sm text-label-sm whitespace-nowrap"><?= htmlspecialchars($ds['version'] ?? 'v1.0') ?></span>
                </div>
                <div class="flex items-center justify-between mt-space-sm pt-space-xs pl-1 font-label-sm text-label-sm text-on-surface-variant">
                    <span class="flex items-center gap-1 text-primary">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                        <?= htmlspecialchars($ds['scenario_title'] ?? 'Global Lake Repository') ?>
                    </span>
                    <span class="flex items-center gap-1 text-on-surface font-label-sm font-mono text-[10px]">
                        <?= number_format($ds['file_size'] / (1024 * 1024), 2) ?> MB
                    </span>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
                        </div>
                        <!-- Version Audit Lineage Box -->
                        <div class="p-space-md bg-surface-container-lowest rounded-xl shadow-sm flex flex-col gap-space-xs">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-label-sm text-label-sm text-primary font-bold uppercase tracking-wider">Historical Revisions</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant font-mono">telecom_churn</span>
                            </div>
                            <div class="flex flex-col gap-1.5 text-body-sm font-label-sm text-label-sm">
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-low text-on-surface">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-primary">v2.1.0</span>
                                        <span class="text-on-surface-variant">(Current Active)</span>
                                    </div>
                                    <span class="text-primary font-bold">142 Cohort Submissions Bound</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container text-on-surface-variant">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold">v2.0.0</span>
                                        <span class="">(Pre-Imputation)</span>
                                    </div>
                                    <span class="text-outline">Archived • Read Only</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container text-on-surface-variant">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold">v1.0.0</span>
                                        <span class="">(Raw Pilot)</span>
                                    </div>
                                    <span class="text-outline">Archived • 2024-C Cohort</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT COLUMN: Deep Inspection & Governance Workbench (8 cols ~ 62%) -->
                    <div class="xl:col-span-8 flex flex-col gap-space-md">
                        <!-- Primary Active File Detail Card -->
                        <div class="flex flex-col bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden">
                            <!-- Top File Meta Banner -->
                            <div class="p-space-lg flex flex-col gap-space-sm bg-gradient-to-r from-surface-container-lowest via-surface-container-low to-surface-container-lowest">
                                <div class="flex flex-wrap items-center justify-between gap-space-sm">
                                    <div class="flex items-center gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[28px]">folder_special</span>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <h2 class="font-headline-md text-headline-md text-primary font-bold">telecom_customer_churn_v2.parquet</h2>
                                                <span class="px-2.5 py-0.5 rounded-full bg-primary-container text-on-primary font-label-sm text-label-sm font-bold">v2.1.0 ACTIVE</span>
                                            </div>
                                            <span class="font-label-sm text-label-sm text-on-surface-variant">URI: <code class="font-mono text-primary font-bold">s3://vp-lakehouse-ai02/datasets/tabular/churn/v2.1.0/part-00.parquet</code></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-space-xs">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm font-bold">
                                            <span class="material-symbols-outlined text-[14px]">cloud_done</span>
                                            SYS-AI-02 SYNCED
                                        </span>
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-bold">
                                            <span class="material-symbols-outlined text-[14px]">lock</span>
                                            IMMUTABLE
                                        </span>
                                    </div>
                                </div>
                                <!-- Cryptographic Digest Pill -->
                                <div class="flex flex-wrap items-center justify-between gap-space-xs p-2 bg-surface-container-low rounded-lg font-label-sm text-label-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="text-on-surface-variant font-bold">SHA-256 CHECK:</span>
                                        <span class="font-mono text-primary">8a7f9b2de34081c7e2b71948fc39023194aa82b3c29f45610ec888e23f019b88</span>
                                    </div>
                                    <span class="text-primary font-semibold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">verified</span>
                                        Digital Signature Verified by Instruct-Key-09
                                    </span>
                                </div>
                            </div>
                            <!-- Tab Bar Navigation -->
                            <div class="flex items-center gap-space-xs px-space-lg pt-space-xs bg-surface-container-low overflow-x-auto"><button class="px-space-md py-2.5 font-label-md text-label-md font-bold text-on-primary bg-primary-container rounded-t-lg shadow-sm flex items-center gap-1.5 whitespace-nowrap border-b-2 border-primary-container"><span class="material-symbols-outlined text-[16px]">view_column</span><span class="">Schema &amp; Types</span><span class="ml-1 px-1.5 py-0.2 bg-secondary-fixed text-on-secondary-fixed rounded-full text-[10px] font-bold">21 COLUMNS</span></button><button class="px-space-md py-2.5 font-label-md text-label-md text-on-surface-variant hover:text-primary rounded-t-lg transition-colors flex items-center gap-1.5 whitespace-nowrap"><span class="material-symbols-outlined text-[16px]">table_rows</span><span class="">Sample Records (100)</span></button><button class="px-space-md py-2.5 font-label-md text-label-md text-on-surface-variant hover:text-primary rounded-t-lg transition-colors flex items-center gap-1.5 whitespace-nowrap"><span class="material-symbols-outlined text-[16px]">troubleshoot</span><span class="">Data Quality &amp; Profiling</span><span class="ml-1 px-1.5 py-0.2 bg-secondary-fixed text-on-secondary-fixed rounded-full text-[10px] font-bold">PASS</span></button><button class="px-space-md py-2.5 font-label-md text-label-md text-on-surface-variant hover:text-primary rounded-t-lg transition-colors flex items-center gap-1.5 whitespace-nowrap"><span class="material-symbols-outlined text-[16px]">school</span><span class="">Scenario Bindings (SCN-01)</span><span class="ml-1 px-1.5 py-0.2 bg-surface-container text-on-surface-variant rounded-full text-[10px] font-bold">2 BOUND</span></button><button class="px-space-md py-2.5 font-label-md text-label-md text-on-surface-variant hover:text-primary rounded-t-lg transition-colors flex items-center gap-1.5 whitespace-nowrap"><span class="material-symbols-outlined text-[16px]">history_edu</span><span class="">Lineage &amp; Access Logs</span><span class="ml-1 px-1.5 py-0.2 bg-secondary-fixed text-on-secondary-fixed rounded-full text-[10px] font-bold">SEALED</span></button></div>
                            <!-- Tab Body: Schema & Types View -->
                            <div class="p-space-lg flex flex-col gap-space-md">
                                <div class="flex flex-wrap items-center justify-between gap-space-sm">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2"><span class="font-headline-sm text-headline-sm text-primary font-bold">Dataset Schema, Arrow Types &amp; Column Profiling</span><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm font-semibold">Parquet 2.6 • Snappy</span></div><span class="font-body-sm text-body-sm text-on-surface-variant">Strict Typing Enforced • Verified against Blueprint SCN-01-SPEC-v2.1 • Zero Schema Drift</span>
                                    </div>
                                    <div class="flex items-center gap-2 flex-wrap"><button class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container text-primary font-label-sm text-label-sm hover:bg-secondary-fixed transition-colors"><span class="material-symbols-outlined text-[16px]">code</span><span class="">Export Arrow Schema (JSON)</span></button><button class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary-container text-on-primary font-label-sm text-label-sm hover:bg-primary transition-colors shadow-sm"><span class="material-symbols-outlined text-[16px]">verified</span><span class="">Validate Against SCN-01 Spec</span></button></div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-space-sm p-space-md bg-surface-container-low rounded-xl border border-surface-container-highest/60">
                                    <div class="flex flex-col p-2 bg-surface-container-lowest rounded-lg border border-surface-container-highest/60"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-semibold">Feature Composition</span>
                                        <div class="flex items-center gap-1.5 mt-1"><span class="material-symbols-outlined text-primary text-[18px]">dataset</span><span class="font-headline-sm text-[15px] font-bold text-primary">21 Total Columns</span></div><span class="text-[11px] font-mono text-on-surface-variant mt-1">1 ID • 14 Num • 5 Cat • 1 Label</span>
                                    </div>
                                    <div class="flex flex-col p-2 bg-surface-container-lowest rounded-lg border border-surface-container-highest/60"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-semibold">Serialization &amp; Codec</span>
                                        <div class="flex items-center gap-1.5 mt-1"><span class="material-symbols-outlined text-primary text-[18px]">archive</span><span class="font-headline-sm text-[15px] font-bold text-primary">PyArrow / Snappy</span></div><span class="text-[11px] font-mono text-on-surface-variant mt-1">Dictionary Encoding: Active</span>
                                    </div>
                                    <div class="flex flex-col p-2 bg-surface-container-lowest rounded-lg border border-surface-container-highest/60"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-semibold">Data Integrity &amp; Nulls</span>
                                        <div class="flex items-center gap-1.5 mt-1"><span class="material-symbols-outlined text-primary text-[18px]">fact_check</span><span class="font-headline-sm text-[15px] font-bold text-primary">100% Conformance</span></div><span class="text-[11px] font-mono text-on-surface-variant mt-1">0 Null Values across 70,430 rows</span>
                                    </div>
                                    <div class="flex flex-col p-2 bg-surface-container-lowest rounded-lg border border-surface-container-highest/60"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase font-semibold">Memory Layout</span>
                                        <div class="flex items-center gap-1.5 mt-1"><span class="material-symbols-outlined text-primary text-[18px]">memory</span><span class="font-headline-sm text-[15px] font-bold text-primary">11.8 MB In-Memory</span></div><span class="text-[11px] font-mono text-on-surface-variant mt-1">Disk: 2.4 MB (Compressed)</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between"><span class="font-label-md text-label-md text-primary font-bold uppercase tracking-wider">Column Definitions &amp; Statistical Profiler</span><span class="font-label-sm text-label-sm text-on-surface-variant font-mono">Indexed by Arrow Physical Field ID</span></div>
                                    <div class="overflow-x-auto rounded-lg shadow-sm border border-surface-container-highest/60">
                                        <table class="w-full text-left font-body-sm text-body-sm whitespace-nowrap">
                                            <thead class="bg-surface-container-high text-primary font-label-md text-label-md uppercase tracking-wider">
                                                <tr>
                                                    <th class="py-2.5 px-3">Column Name</th>
                                                    <th class="py-2.5 px-3">Physical Arrow Type</th>
                                                    <th class="py-2.5 px-3">Nullability / Missing</th>
                                                    <th class="py-2.5 px-3">Value Distribution / Bounds</th>
                                                    <th class="py-2.5 px-3">Schema Role &amp; Usage</th>
                                                    <th class="py-2.5 px-3 text-right">Validation</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-none font-label-sm">
                                                <tr class="bg-surface-container-lowest hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-primary">key</span><span class="">customer_id</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">utf8 (string)</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">Unique: 70,430 (100% Cardinality)</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold font-label-sm">PRIMARY KEY</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">VALIDATED</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-low hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">123</span><span class="">tenure</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">int64</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">Min: 1 • Max: 72 • Mean: 32.4 • σ: 24.5</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-surface-container text-primary font-bold font-label-sm">NUMERIC FEATURE</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">VALIDATED</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-lowest hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">123</span><span class="">monthly_charges</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">float64</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">Min: 18.25 • Max: 118.75 • Mean: 64.76</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-surface-container text-primary font-bold font-label-sm">NUMERIC FEATURE</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">VALIDATED</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-low hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">123</span><span class="">total_charges</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">float64</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">Min: 18.80 • Max: 8684.80 • Mean: 2283.30</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">NUMERIC (IMPUTED)</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">VALIDATED</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-lowest hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">label</span><span class="">contract_type</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">utf8 (dictionary)</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">Month-to-month (55%), 1-Yr (21%), 2-Yr (24%)</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-surface-container text-primary font-bold font-label-sm">CATEGORICAL</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">VALIDATED</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-low hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">label</span><span class="">internet_service</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">utf8 (dictionary)</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">DSL (34%), Fiber optic (44%), No (22%)</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-surface-container text-primary font-bold font-label-sm">CATEGORICAL</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">VALIDATED</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-lowest hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">label</span><span class="">payment_method</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">utf8 (dictionary)</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">Electronic (33%), Mail (23%), Transfer (22%), CC (22%)</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-surface-container text-primary font-bold font-label-sm">CATEGORICAL</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">VALIDATED</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-low hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-tertiary">flag</span><span class="font-bold text-tertiary">churn_label</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-bold">int64 (binary)</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">Class 0: 73.5% (51,747) • Class 1: 26.5% (18,683)</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-primary-container text-on-primary font-bold font-label-sm">GROUND TRUTH TARGET</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">SEALED</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-lowest hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">tune</span><span class="">senior_citizen</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">int64 (0/1)</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">0: 83.8% • 1: 16.2%</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-surface-container text-primary font-bold font-label-sm">BINARY DEMOGRAPHIC</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">VALIDATED</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-low hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">tune</span><span class="">partner</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">utf8 (Yes/No)</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">Yes: 48.3% • No: 51.7%</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-surface-container text-primary font-bold font-label-sm">BINARY DEMOGRAPHIC</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">VALIDATED</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-lowest hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">tune</span><span class="">online_security</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">utf8 (dictionary)</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">No: 49.7% • Yes: 28.7% • No Internet: 21.6%</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-surface-container text-primary font-bold font-label-sm">SERVICE ATTRIBUTE</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">VALIDATED</span></td>
                                                </tr>
                                                <tr class="bg-surface-container-low hover:bg-secondary-fixed/20 transition-colors">
                                                    <td class="py-2 px-3 font-mono font-bold text-primary flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-outline">tune</span><span class="">tech_support</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px]"><span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">utf8 (dictionary)</span></td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-primary font-semibold">0.0% (0)</td>
                                                    <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">No: 49.3% • Yes: 29.0% • No Internet: 21.6%</td>
                                                    <td class="py-2 px-3"><span class="px-2 py-0.5 rounded bg-surface-container text-primary font-bold font-label-sm">SERVICE ATTRIBUTE</span></td>
                                                    <td class="py-2 px-3 text-right"><span class="px-2 py-0.5 rounded bg-secondary-fixed text-on-secondary-fixed font-bold font-label-sm">VALIDATED</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="p-space-md bg-surface-container-low rounded-xl border border-surface-container-highest/60 flex flex-col gap-space-xs">
                                    <div class="flex items-center justify-between"><span class="font-label-md text-label-md text-primary font-bold uppercase tracking-wider">PyArrow Type System &amp; Partition Metadata</span><span class="font-label-sm text-label-sm text-on-surface-variant font-mono">pyarrow==14.0.2 / parquet-cpp 2.6.0</span></div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-space-sm pt-1">
                                        <div class="p-2.5 bg-surface-container-lowest rounded-lg border border-surface-container-highest/60"><span class="font-label-sm text-[11px] text-on-surface-variant uppercase font-bold">Arrow Key-Value Metadata</span>
                                            <p class="font-mono text-[11px] text-primary mt-1">{"instructor_spec": "SCN-01", "imputation": "median", "salt": "0x4F92A"}</p>
                                        </div>
                                        <div class="p-2.5 bg-surface-container-lowest rounded-lg border border-surface-container-highest/60"><span class="font-label-sm text-[11px] text-on-surface-variant uppercase font-bold">Column Chunk Allocation</span>
                                            <p class="font-mono text-[11px] text-primary mt-1">Row Group Size: 64 MB (1 chunk) • Columnar Row Pruning: Enabled</p>
                                        </div>
                                        <div class="p-2.5 bg-surface-container-lowest rounded-lg border border-surface-container-highest/60"><span class="font-label-sm text-[11px] text-on-surface-variant uppercase font-bold">Precision &amp; Overflow Guard</span>
                                            <p class="font-mono text-[11px] text-primary mt-1">IEEE 754 Double Precision • Safe Casts Enforced in SYS-AI-03 Pod</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col p-space-md bg-tertiary-fixed/30 rounded-xl gap-space-sm">
                                    <div class="flex items-start justify-between gap-space-sm">
                                        <div class="flex items-start gap-space-sm"><span class="material-symbols-outlined text-tertiary text-[24px]">shield_with_heart</span>
                                            <div class="flex flex-col"><span class="font-label-md text-label-md text-on-tertiary-fixed font-bold uppercase tracking-wider">Immutability Lock &amp; Controlled Schema Governance</span>
                                                <p class="font-body-sm text-body-sm text-on-surface">This schema is cryptographically locked for active cohort grading across <strong class="font-bold text-primary">142 student submissions</strong>. Column modifications, type casts, or feature deletions require formal version deprecation and instructor re-signing.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-space-sm pt-space-xs"><button class="px-space-md py-1.5 rounded-lg bg-primary-container text-on-primary font-label-md text-label-md shadow-sm hover:bg-primary transition-all flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">security</span><span class="">Audit Data Leakage Protection</span></button><button class="px-space-md py-1.5 rounded-lg bg-surface-container-lowest text-primary font-label-md text-label-md shadow-sm hover:bg-secondary-fixed transition-all flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">file_download</span><span class="">Download Schema JSON</span></button><button class="px-space-md py-1.5 rounded-lg bg-surface-container-lowest text-on-surface-variant font-label-md text-label-md shadow-sm hover:text-primary transition-all flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">history</span><span class="">Compare with v2.0.0 Schema</span></button></div>
                                </div>
                            </div>
                        </div>
                        <!-- Linked Blueprint Scenarios Matrix -->
                        <div class="flex flex-col p-space-lg bg-surface-container-lowest rounded-xl shadow-sm gap-space-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-primary text-[20px]">assignment_turned_in</span>
                                    <span class="font-headline-sm text-headline-sm text-primary font-bold">Active Scenario Bindings (7 Blueprints)</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">Training Engine: SYS-AI-01 / SYS-AI-03</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-sm">
                                <div class="flex items-start justify-between p-space-sm bg-surface-container-low rounded-lg">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="font-label-md text-label-md font-bold text-primary">SCN-01: Churn Prediction Blueprint</span>
                                            <span class="px-1.5 py-0.2 bg-secondary-fixed text-on-secondary-fixed rounded text-label-sm font-label-sm">BOUND</span>
                                        </div>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Features: 21 • Cohort 2025-A (64 students)</span>
                                    </div>
                                    <span class="material-symbols-outlined text-primary text-[18px]">link</span>
                                </div>
                                <div class="flex items-start justify-between p-space-sm bg-surface-container-low rounded-lg">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="font-label-md text-label-md font-bold text-primary">SCN-01-EX: Advanced Feature Engineering</span>
                                            <span class="px-1.5 py-0.2 bg-secondary-fixed text-on-secondary-fixed rounded text-label-sm font-label-sm">BOUND</span>
                                        </div>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant">Features: 21 • Cohort 2025-B (78 students)</span>
                                    </div>
                                    <span class="material-symbols-outlined text-primary text-[18px]">link</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="js/main.js"></script>
    <!-- Upload Dataset Modal -->
    <div id="modal-upload-dataset" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-surface-container-lowest rounded-2xl shadow-2xl max-w-lg w-full p-6 border border-primary/20">
            <div class="flex items-center justify-between pb-3 border-b border-outline-variant/30 mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-2xl">upload_file</span>
                    <h3 class="font-bold text-lg text-primary">Register Master Dataset</h3>
                </div>
                <button type="button" onclick="document.getElementById('modal-upload-dataset').classList.add('hidden')" class="p-1 rounded-lg hover:bg-surface-container text-on-surface-variant">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="action" value="upload_dataset">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Dataset Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Telemetry Flight Vector 2026" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Dataset Code *</label>
                        <input type="text" name="code" required placeholder="DS-FLIGHT-V2" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Format *</label>
                        <select name="format" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                            <option value="CSV">CSV</option>
                            <option value="JSON">JSON</option>
                            <option value="PARQUET">Parquet</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Training Scenario Binding</label>
                    <select name="scenario_id" class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                        <option value="">-- Unassigned / General Lake --</option>
                        <?php foreach ($scenarios as $sc): ?>
                            <option value="<?= $sc['id'] ?>"><?= htmlspecialchars($sc['code']) ?>: <?= htmlspecialchars($sc['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Description</label>
                    <textarea name="description" rows="2" placeholder="Summary of data schema, columns, and target label..." class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Dataset File *</label>
                    <input type="file" name="dataset_file" required accept=".csv,.json,.parquet,.txt" class="w-full text-xs text-on-surface-variant file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-primary/90">
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-outline-variant/30">
                    <button type="button" onclick="document.getElementById('modal-upload-dataset').classList.add('hidden')" class="px-4 py-2 rounded-lg bg-surface-container text-on-surface-variant text-xs font-bold">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white text-xs font-bold shadow-md hover:bg-primary/90">Upload &amp; Index</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Assign Dataset Modal -->
    <div id="modal-assign-dataset" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-surface-container-lowest rounded-2xl shadow-2xl max-w-md w-full p-6 border border-primary/20">
            <div class="flex items-center justify-between pb-3 border-b border-outline-variant/30 mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-2xl">person_add</span>
                    <h3 class="font-bold text-lg text-primary">Assign Dataset to Cadet</h3>
                </div>
                <button type="button" onclick="document.getElementById('modal-assign-dataset').classList.add('hidden')" class="p-1 rounded-lg hover:bg-surface-container text-on-surface-variant">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="assign_dataset">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Select Dataset *</label>
                    <select name="dataset_id" required class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                        <?php foreach ($datasets as $ds): ?>
                            <option value="<?= $ds['id'] ?>" <?= ($selectedDataset && $selectedDataset['id'] === $ds['id']) ? 'selected' : '' ?>><?= htmlspecialchars($ds['code']) ?> - <?= htmlspecialchars($ds['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Select Cadet Student *</label>
                    <select name="student_id" required class="w-full px-3 py-2 bg-surface-container-low rounded-lg text-sm border border-outline-variant/40 focus:border-primary focus:outline-none">
                        <?php if (empty($students)): ?>
                            <option value="">No active cadets found</option>
                        <?php else: ?>
                            <?php foreach ($students as $stu): ?>
                                <option value="<?= $stu['id'] ?>"><?= htmlspecialchars($stu['full_name']) ?> (<?= htmlspecialchars($stu['identifier'] ?? $stu['email']) ?>)</option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-outline-variant/30">
                    <button type="button" onclick="document.getElementById('modal-assign-dataset').classList.add('hidden')" class="px-4 py-2 rounded-lg bg-surface-container text-on-surface-variant text-xs font-bold">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white text-xs font-bold shadow-md hover:bg-primary/90">Confirm Assignment</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>