<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

$isStudent = ($currentUser['role'] === 'STUDENT');
use App\Core\Csrf;
use App\Services\DatasetService;

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_processed') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
        $err = "Security token expired or invalid.";
    } else {
        try {
            $sourceId = (int)($_POST['source_dataset_id'] ?? 0);
            $ticketId = !empty($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : null;
            $name = trim($_POST['name'] ?? '');
            $notes = trim($_POST['transformation_notes'] ?? '');
            $dsService = new DatasetService();
            $dsService->uploadProcessedDataset($sourceId, (int)$currentUser['id'], $ticketId, $_FILES['processed_file'] ?? [], [
                'name' => $name,
                'transformation_notes' => $notes
            ]);
            $msg = "Processed dataset indexed and stored successfully in Range Lake.";
        } catch (\Throwable $e) {
            $err = $e->getMessage();
        }
    }
}

if ($isStudent) {
    $assignedDatasets = $db->fetchAll("
        SELECT d.* FROM datasets d 
        JOIN dataset_assignments da ON d.id = da.dataset_id 
        WHERE da.student_id = :sid ORDER BY d.created_at DESC
    ", ['sid' => $currentUser['id']]);
    $processedDatasets = $db->fetchAll("
        SELECT pd.*, d.name AS source_name, d.code AS source_code 
        FROM processed_datasets pd 
        JOIN datasets d ON pd.source_dataset_id = d.id 
        WHERE pd.student_id = :sid 
        ORDER BY pd.created_at DESC
    ", ['sid' => $currentUser['id']]);
} else {
    $assignedDatasets = $db->fetchAll("SELECT * FROM datasets ORDER BY created_at DESC");
    $processedDatasets = $db->fetchAll("
        SELECT pd.*, d.name AS source_name, d.code AS source_code, u.full_name AS student_name 
        FROM processed_datasets pd 
        JOIN datasets d ON pd.source_dataset_id = d.id 
        LEFT JOIN users u ON pd.student_id = u.id 
        ORDER BY pd.created_at DESC
    ");
}

$processedCount = count($processedDatasets);
$datasetCount = count($assignedDatasets);
$totalSizeBytes = array_sum(array_column($assignedDatasets, 'file_size'));
$totalSizeMB = round($totalSizeBytes / (1024 * 1024), 2);
$csrfToken = Csrf::getToken();
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;family=JetBrains+Mono:wght@100..900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="bg-[#EAF4FF] text-on-surface font-body-md text-body-md antialiased [background-image:radial-gradient(#4C1D95_0.6px,transparent_0.6px)] [background-size:24px_24px]">
    <header class="fixed top-0 w-full z-40 bg-surface-container-lowest/95 backdrop-blur-md shadow-[0_1px_8px_rgba(76,29,149,0.06)]">
        <div class="h-28 w-full px-6 flex flex-col justify-between pt-2 pb-1">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3"><img alt="VOSTOKPRIBOR Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1XplCZG68pWLAjQwkwEQR7ZWfQCFwva3Nyh2w6WLaTmOUPbr3ASOiYmaUX6kte-9TBdAj-NoUqkGBT4A3Z8gW8-zaJSQDwWTeADPzdgpsKcARCUsBG0lI4JxEa0gO7e4jddImZvB-Wishm72yamBli-8hT0TsYOKcnaDAapgxjUUCuy6ns_J3pKhO4elY7lr_ElWkpHkQkgUQa1pPRYLckAh_QZHd84AYvgEW4NApRMiJMvLpC3Gaiqq8M" />
                    <div class="flex flex-col"><span class="font-label-sm text-label-sm uppercase tracking-wider text-primary">VOSTOKPRIBOR // AI ENGINEERING RANGE</span>
                        <div class="flex items-center gap-2 mt-0.5">
                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-[0_0_0_1px_#E8C9A0]"><span class="w-1.5 h-1.5 rounded-full bg-[#E8C9A0]"></span><span class="">SYS-AI-02: DATA CENTER &amp; CATALOG</span></div>
                            <div class="hidden xl:inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-[#FDF6F0] text-tertiary-container font-label-sm text-label-sm"><span class="material-symbols-outlined text-[13px] text-tertiary">tune</span><span class="">Active Scenario: [Predictive AI: Customer Churn] (v2.4)</span></div>
                        </div>
                    </div>
                </div>
                <div class="flex-1 max-w-xl mx-4 hidden md:block">
                    <div class="relative flex items-center"><span class="material-symbols-outlined absolute left-3 text-outline text-[18px]">search</span><input class="w-full h-8 pl-9 pr-3 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest shadow-[0_0_0_1px_#dae2fd] transition-all" placeholder="Search datasets, tables, schemas, ticket IDs..." type="text" /></div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden lg:flex flex-col text-right"><span class="font-label-md text-label-md text-on-surface"><?= htmlspecialchars($currentUser['full_name']) ?></span><span class="font-code-sm text-code-sm text-secondary"><?= htmlspecialchars($currentUser['identifier'] ?? $currentUser['email']) ?> • <?= htmlspecialchars($currentUser['role']) ?></span></div><button class="relative p-1.5 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-error"></span></button>
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
                </div>
            </div>
            <div class="flex items-center justify-between pt-1 overflow-x-auto">
                <div class="flex items-center gap-1"><span class="font-label-sm text-label-sm uppercase text-outline mr-2 hidden sm:inline">Subsystems:</span><a class="px-2 py-0.5 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors whitespace-nowrap" href="../AI Project Management/Dashboard.php">SYS-AI-01: Problem Framing</a><a class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] whitespace-nowrap" href="dashboard.php">SYS-AI-02: Dataset Portal [ACTIVE]</a><a class="px-2 py-0.5 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors whitespace-nowrap" href="../ML Workbench/NotebookWorkbench.php">SYS-AI-03: AI Workbench</a><a class="px-2 py-0.5 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors whitespace-nowrap" href="../Model Registry & Deployment/dashboard.php">SYS-AI-04: Model Registry</a><a class="px-2 py-0.5 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors whitespace-nowrap" href="../AI Operations Center (AI SOC)/TicketsAndScenarios.php">SYS-AI-05: Range Admin</a></div>
                <div class="hidden lg:flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#10B981] animate-pulse"></span><span class="font-code-sm text-code-sm text-on-surface-variant">TELEMETRY LIVE</span></div>
            </div>
        </div>
    </header>
    <aside class="fixed left-0 top-28 bottom-0 w-64 bg-surface-container-lowest/95 backdrop-blur-md z-30 flex flex-col justify-between py-4 shadow-[0_1px_8px_rgba(76,29,149,0.06)]">
        <div class="flex flex-col flex-1 overflow-y-auto px-3">
            <div class="px-3 pb-2 mb-2 flex items-center justify-between"><span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Workspace Modules</span><span class="font-code-sm text-code-sm text-primary">v2.4.1</span></div>
            <nav class="flex flex-col gap-1" data-active-classes="bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded"><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="dashboard" href="dashboard.php"><span class="material-symbols-outlined text-[18px]">dashboard</span><span class="">Dashboard</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="dataset-catalog" href="DatasetCatalog.php"><span class="material-symbols-outlined text-[18px]">dataset</span><span class="">Dataset Catalog</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="my-datasets" href="MyDataSet.php"><span class="material-symbols-outlined text-[18px]">folder_shared</span><span class="">My Datasets</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="data-profiling-and-quality" href="DataProfilingAndQuality.php"><span class="material-symbols-outlined text-[18px]">troubleshoot</span><span class="">Data Profiling &amp; Quality</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="query-workspace" href="QueryWorkspace.php"><span class="material-symbols-outlined text-[18px]">terminal</span><span class="">Query Workspace</span></a><a aria-current="page" class="flex items-center gap-3 px-3 py-2 transition-all bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded" data-path="upload-processed-data" href="UploadProcessedData.php"><span class="material-symbols-outlined text-[18px]">cloud_upload</span><span class="">Upload Processed Data</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="recent-activity-and-audit-logs" href="RecentActivityAndAudit.php"><span class="material-symbols-outlined text-[18px]">history_toggle_off</span><span class="">Recent Activity &amp; Audit</span></a></nav>
        </div>
        <div class="px-4 pt-3 flex flex-col gap-3 bg-surface-container-low/50">
            <div class="bg-surface-container-lowest p-2.5 rounded shadow-[0_1px_4px_rgba(76,29,149,0.04)]">
                <div class="flex justify-between items-center mb-1"><span class="font-label-sm text-label-sm uppercase text-outline">Storage Quota</span><span class="font-code-sm text-code-sm text-primary font-bold">38.4%</span></div>
                <div class="w-full h-1.5 rounded-full bg-surface-container-high overflow-hidden">
                    <div class="h-full bg-primary-container rounded-full" style="width: 38.4%"></div>
                </div>
                <div class="flex justify-between items-center mt-1"><span class="font-code-sm text-code-sm text-on-surface-variant">38.4 GB</span><span class="font-code-sm text-code-sm text-outline">100 GB cap</span></div>
            </div>
            <div class="p-2 rounded bg-[#FDF6F0] flex flex-col gap-0.5"><span class="font-label-sm text-label-sm uppercase text-tertiary font-bold">Scenario Context</span><span class="font-code-sm text-code-sm text-on-surface truncate">Customer Churn (v2.4)</span></div>
            <div class="flex items-center justify-between p-2 rounded bg-surface-container-lowest">
                <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#10B981]"></span><span class="font-label-sm text-label-sm text-on-surface">System Health</span></div><span class="font-code-sm text-code-sm text-[#10B981] font-bold">NOMINAL</span>
            </div>
        </div>
    </aside>
    <div class="pl-64">
        <main class="relative pt-28 w-full px-8 pb-12">
            <?php if ($msg): ?>
<div class="p-3 mb-4 rounded-lg bg-emerald-100 border border-emerald-300 text-emerald-800 text-xs font-mono flex items-center gap-2">
    <span class="material-symbols-outlined text-[18px]">check_circle</span>
    <span><?= htmlspecialchars($msg) ?></span>
</div>
<?php endif; ?>
<?php if ($err): ?>
<div class="p-3 mb-4 rounded-lg bg-rose-100 border border-rose-300 text-rose-800 text-xs font-mono flex items-center gap-2">
    <span class="material-symbols-outlined text-[18px]">error</span>
    <span><?= htmlspecialchars($err) ?></span>
</div>
<?php endif; ?>
            <div class="flex flex-col w-full gap-5">
                <!-- Flight Scope Banner / Telemetry Header -->
                <div class="w-full bg-surface-container-lowest p-5 rounded-lg shadow-sm flex flex-col xl:flex-row items-start xl:items-center justify-between gap-4">
                    <div class="flex flex-col gap-1.5">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">WORKSPACE REPOSITORY</span>
                            <span class="font-code-sm text-code-sm text-outline">/</span>
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">CADET ENG. K. CHEN [VP-88204]</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container-high text-primary font-code-sm text-code-sm">SECURITY CLEARANCE: L2</span>
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-sm text-code-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                SYS-AI-02 // INGESTION &amp; PIPELINE REGISTER
                            </span>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-primary-container">radar</span>
                                <span class="font-headline-sm text-headline-sm text-on-surface">Flight Scope: Customer Churn (v2.4)</span>
                            </div>
                            <span class="font-code-sm text-code-sm text-outline">|</span>
                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-secondary">
                                <span class="material-symbols-outlined text-[14px]">confirmation_number</span>
                                <span>Target Ticket: #VP-TCK-1049</span>
                            </div>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm">
                                <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                                ALPHA-NODE INGEST ONLINE
                            </span>
                        </div>
                    </div>
                    <!-- Quick Storage Telemetry Gauge -->
                    <div class="flex items-center gap-4 bg-surface-container-low px-4 py-3 rounded-lg min-w-[280px]">
                        <div class="flex flex-col flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-label-sm text-label-sm uppercase text-outline">Buffer Headroom</span>
                                <span class="font-code-sm text-code-sm text-primary font-bold">61.6 GB FREE</span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-surface-container-highest overflow-hidden">
                                <div class="h-full bg-primary-container rounded-full" style="width: 38.4%"></div>
                            </div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="font-code-sm text-code-sm text-on-surface-variant">38.4 GB Used</span>
                                <span class="font-code-sm text-code-sm text-outline">100.0 GB Limit</span>
                            </div>
                        </div>
                        <div class="w-9 h-9 rounded bg-surface-container-lowest flex items-center justify-center text-primary shadow-sm">
                            <span class="material-symbols-outlined text-[20px]">database</span>
                        </div>
                    </div>
                </div>
                <!-- Primary Interactive Surface: Staging Dropzone + Preflight Configuration Bento -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                    <!-- Left Column: Multi-Format Staging Dropzone -->
                    <div class="lg:col-span-7 flex flex-col gap-4 bg-surface-container-lowest p-6 rounded-lg shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-container text-[20px]">cloud_upload</span>
                                <h2 class="font-headline-sm text-headline-sm text-on-surface">Data Surface Ingestion Gate</h2>
                            </div>
                            <div class="flex items-center gap-1.5 font-code-sm text-code-sm text-outline">
                                <span class="material-symbols-outlined text-[15px]">verified_user</span>
                                <span>Max Stream Batch: 5.0 GB</span>
                            </div>
                        </div>
                        <!-- Functional Ingestion Upload Form -->
<form method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 p-6 rounded-lg bg-surface-container-low border border-primary/20 shadow-inner">
    <input type="hidden" name="action" value="upload_processed">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-1">Source Master Dataset *</label>
            <select name="source_dataset_id" required class="w-full h-9 px-3 rounded bg-surface-container-lowest font-code-sm text-code-sm text-on-surface focus:outline-none shadow-sm">
                <?php if (empty($assignedDatasets)): ?>
                    <option value="">No assigned datasets available</option>
                <?php else: ?>
                    <?php foreach ($assignedDatasets as $ads): ?>
                        <option value="<?= $ads['id'] ?>"><?= htmlspecialchars($ads['code']) ?> - <?= htmlspecialchars($ads['name']) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div>
            <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-1">Processed Artifact Name *</label>
            <input type="text" name="name" required placeholder="e.g. telecom_imputed_features_v2.csv" class="w-full h-9 px-3 rounded bg-surface-container-lowest font-code-sm text-code-sm text-on-surface focus:outline-none shadow-sm" />
        </div>
    </div>
    
    <div>
        <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-1">Select Processed File (.CSV / .JSON) *</label>
        <input type="file" name="processed_file" required accept=".csv,.json" class="w-full text-xs text-on-surface-variant file:mr-3 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-bold file:bg-primary file:text-white hover:file:bg-primary/90" />
    </div>

    <div>
        <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline block mb-1">Transformation Notes & Applied Pipeline</label>
        <textarea name="transformation_notes" rows="2" placeholder="e.g. Imputed missing billing values with median; encoded categorical features." class="w-full px-3 py-2 rounded bg-surface-container-lowest font-code-sm text-code-sm text-on-surface focus:outline-none shadow-sm"></textarea>
    </div>

    <div class="flex items-center justify-end gap-3 pt-2">
        <button type="submit" class="px-5 py-2.5 rounded bg-primary text-white hover:bg-primary/90 font-label-md text-label-md uppercase tracking-wider flex items-center gap-2 shadow-md transition-all">
            <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
            <span>Upload Processed Dataset</span>
        </button>
    </div>
</form>
<!-- Destination Namespace Input -->
                        <div class="flex flex-col gap-1.5 mt-1">
                            <div class="flex items-center justify-between">
                                <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline" for="dest-namespace">Target Lake Namespace / Storage Path</label>
                                <span class="font-code-sm text-code-sm text-secondary">AUTO-RESOLVE: ENABLED</span>
                            </div>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3 text-outline text-[18px]">folder</span>
                                <input class="w-full h-9 pl-9 pr-24 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface focus:outline-none focus:bg-surface-container-lowest shadow-sm transition-all" id="dest-namespace" type="text" value="personal_lake/k_chen/telecom_churn_v2_features.parquet" />
                                <button class="absolute right-1.5 px-2.5 py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm uppercase tracking-wider hover:bg-surface-container-high transition-colors" type="button">
                                    Validate
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column: Pre-Flight Pipeline & Ingest Validation Rules -->
                    <div class="lg:col-span-5 flex flex-col justify-between gap-4 bg-surface-container-lowest p-6 rounded-lg shadow-sm">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary-container text-[20px]">security</span>
                                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Ingest Contract &amp; Pre-Flight</h2>
                                </div>
                                <span class="font-label-sm text-label-sm px-2 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed">RIGOR: STRICT</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                Inbound records undergo real-time micro-benchmarking and schema isolation before being added to Range index catalogs.
                            </p>
                            <!-- Strict Contract Match Toggle Panel -->
                            <div class="p-3 rounded bg-surface-container-low flex items-center justify-between gap-3">
                                <div class="flex flex-col">
                                    <span class="font-label-md text-label-md text-on-surface">Contract Enforcement</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">ProtoDef strict validation; drop on schema drift</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input checked="" class="sr-only peer" type="checkbox" />
                                    <div class="w-9 h-5 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-surface-container-lowest after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-container"></div>
                                </label>
                            </div>
                            <!-- Verification Checklist -->
                            <div class="flex flex-col gap-2 mt-1">
                                <label class="flex items-start gap-2.5 cursor-pointer p-2 rounded hover:bg-surface-container-low transition-colors">
                                    <input checked="" class="mt-0.5 w-4 h-4 rounded text-primary-container accent-primary-container focus:ring-0" type="checkbox" />
                                    <div class="flex flex-col">
                                        <span class="font-body-md text-body-md font-medium text-on-surface">Auto-generate DuckDB Null &amp; Skew Matrix</span>
                                        <span class="font-code-sm text-code-sm text-outline">Compute quantile metrics and cardinality diagnostics</span>
                                    </div>
                                </label>
                                <label class="flex items-start gap-2.5 cursor-pointer p-2 rounded hover:bg-surface-container-low transition-colors">
                                    <input checked="" class="mt-0.5 w-4 h-4 rounded text-primary-container accent-primary-container focus:ring-0" type="checkbox" />
                                    <div class="flex flex-col">
                                        <span class="font-body-md text-body-md font-medium text-on-surface">Target Leakage Interceptor</span>
                                        <span class="font-code-sm text-code-sm text-outline">Scan against active label <span class="text-primary font-bold">churn_label</span> for high collinearity (&gt;0.92)</span>
                                    </div>
                                </label>
                                <label class="flex items-start gap-2.5 cursor-pointer p-2 rounded hover:bg-surface-container-low transition-colors">
                                    <input checked="" class="mt-0.5 w-4 h-4 rounded text-primary-container accent-primary-container focus:ring-0" type="checkbox" />
                                    <div class="flex flex-col">
                                        <span class="font-body-md text-body-md font-medium text-on-surface">Automated PII Sanitization</span>
                                        <span class="font-code-sm text-code-sm text-outline">Regex mask for MSISDN, SSN, IP, and raw email addresses</span>
                                    </div>
                                </label>
                                <label class="flex items-start gap-2.5 cursor-pointer p-2 rounded hover:bg-surface-container-low transition-colors">
                                    <input checked="" class="mt-0.5 w-4 h-4 rounded text-primary-container accent-primary-container focus:ring-0" type="checkbox" />
                                    <div class="flex flex-col">
                                        <span class="font-body-md text-body-md font-medium text-on-surface">Cryptographic Verification (SHA-256)</span>
                                        <span class="font-code-sm text-code-sm text-outline">Hash generation for multi-node replica consistency</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <!-- Format Conversion Dropdown -->
                        <div class="flex flex-col gap-1.5 pt-2">
                            <label class="font-label-sm text-label-sm uppercase tracking-wider text-outline" for="format-select">Storage Compression Format</label>
                            <div class="relative">
                                <select class="w-full h-9 px-3 pr-8 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface focus:outline-none focus:bg-surface-container-lowest appearance-none shadow-sm cursor-pointer" id="format-select">
                                    <option selected="">Parquet (Snappy L1 - Optimized for SYS-AI-03)</option>
                                    <option>Parquet (ZSTD - High Density Archival)</option>
                                    <option>Apache Arrow IPC (Direct RAM Zero-Copy)</option>
                                    <option>Preserve Original Native Format</option>
                                </select>
                                <span class="material-symbols-outlined pointer-events-none absolute right-2.5 top-2 text-outline text-[18px]">expand_more</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Direct Cloud / S3-Compatible MinIO Lake Mount Bar -->
                <div class="w-full bg-surface-container-lowest p-4 rounded-lg shadow-sm flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-8 h-8 rounded bg-surface-container flex items-center justify-center text-primary-container shrink-0">
                            <span class="material-symbols-outlined text-[18px]">terminal</span>
                        </div>
                        <div class="flex flex-col min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Direct Range Lake Pipe (DuckDB SQL Stream)</span>
                                <span class="font-code-sm text-code-sm text-[#10B981] font-bold">MINIO-S3 // S3-COMPATIBLE</span>
                            </div>
                            <div class="font-code-sm text-code-sm text-on-surface bg-surface-container-low px-3 py-1.5 rounded truncate select-all mt-1">
                                COPY personal_lake.telecom_features FROM 's3://vp-lake-eu-01/staging/flight_v2_4/' (FORMAT PARQUET, COMPRESSION SNAPPY);
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <button class="px-3 py-2 rounded bg-surface-container text-primary hover:bg-surface-container-high font-label-md text-label-md uppercase tracking-wider flex items-center gap-1.5 shadow-sm transition-colors" type="button">
                            <span class="material-symbols-outlined text-[16px]">sync_alt</span>
                            Sync Node Shards
                        </button>
                        <button class="px-3.5 py-2 rounded bg-primary-container hover:bg-primary text-on-primary font-label-md text-label-md uppercase tracking-wider flex items-center gap-1.5 shadow-sm transition-colors" type="button">
                            <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                            Execute Remote Lake Pull
                        </button>
                    </div>
                </div>
                <!-- Active Ingestion & Staging Queue Table -->
                <div class="w-full bg-surface-container-lowest rounded-lg shadow-sm flex flex-col overflow-hidden">
                    <!-- Table Header Toolbar -->
                    <div class="px-5 py-3.5 bg-surface-container flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-primary-container text-[20px]">queue_play_next</span>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface">Active Staging Queue &amp; Ingest Pipeline</h3>
                            <span class="px-2 py-0.5 rounded-full bg-surface-container-highest text-primary font-code-sm text-code-sm font-bold">4 ARTIFACTS</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="px-2.5 py-1 rounded bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-code-sm text-code-sm flex items-center gap-1 transition-colors">
                                <span class="material-symbols-outlined text-[14px]">filter_list</span>
                                Filter: All Statuses
                            </button>
                            <button class="px-2.5 py-1 rounded bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-code-sm text-code-sm flex items-center gap-1 transition-colors">
                                <span class="material-symbols-outlined text-[14px]">refresh</span>
                                Auto-refresh 5s
                            </button>
                        </div>
                    </div>
                    <!-- Telemetry Table Body -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-low text-primary font-label-sm text-label-sm uppercase tracking-wider">
                                    <th class="py-2.5 px-4 font-semibold">Artifact Identifier</th>
                                    <th class="py-2.5 px-4 font-semibold">Volume / Rows</th>
                                    <th class="py-2.5 px-4 font-semibold">Pipeline State &amp; Verification</th>
                                    <th class="py-2.5 px-4 font-semibold">Ticket Association</th>
                                    <th class="py-2.5 px-4 font-semibold text-right">Cadet Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-container-high font-body-md text-body-md">
<?php if (empty($processedDatasets)): ?>
    <tr>
        <td colspan="5" class="py-8 text-center text-on-surface-variant font-mono text-xs">
            <span class="material-symbols-outlined text-3xl mb-1 text-outline">folder_off</span>
            <p>No processed datasets registered in this flight namespace yet.</p>
            <p class="mt-1 text-outline">Upload a feature-engineered file above linked to your assigned master dataset.</p>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($processedDatasets as $pd): ?>
        <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
            <td class="py-3 px-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                    <div class="flex flex-col">
                        <span class="font-code-md text-code-md font-semibold text-on-surface"><?= htmlspecialchars($pd['name']) ?></span>
                        <span class="font-code-sm text-code-sm text-outline">Source: <?= htmlspecialchars($pd['source_code']) ?> • SHA: <?= substr($pd['checksum_sha256'] ?? '', 0, 16) ?>...</span>
                    </div>
                </div>
            </td>
            <td class="py-3 px-4">
                <div class="flex flex-col">
                    <span class="font-code-md text-code-md text-on-surface"><?= number_format($pd['file_size'] / (1024 * 1024), 2) ?> MB</span>
                    <span class="font-code-sm text-code-sm text-on-surface-variant"><?= number_format($pd['row_count']) ?> rows • <?= htmlspecialchars(strtoupper($pd['format'])) ?></span>
                </div>
            </td>
            <td class="py-3 px-4">
                <div class="flex flex-col gap-1">
                    <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-[#FDF6F0] text-tertiary font-code-sm text-code-sm w-fit font-bold">
                        <span class="material-symbols-outlined text-[13px] text-[#10B981]">check_circle</span>
                        <span>REGISTERED IN LAKE</span>
                    </div>
                    <span class="font-code-sm text-code-sm text-outline"><?= htmlspecialchars($pd['transformation_notes'] ?: 'No transformation notes provided') ?></span>
                </div>
            </td>
            <td class="py-3 px-4">
                <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-secondary font-bold">
                    <?= $pd['ticket_id'] ? '#VP-TCK-' . $pd['ticket_id'] : 'GENERAL' ?>
                </span>
            </td>
            <td class="py-3 px-4 text-right">
                <div class="inline-flex items-center gap-2">
                    <span class="text-xs font-mono text-outline"><?= htmlspecialchars($pd['created_at']) ?></span>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>