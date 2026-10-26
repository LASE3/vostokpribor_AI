<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

$isStudent = ($currentUser['role'] === 'STUDENT');

if ($isStudent) {
    $assignedDatasets = $db->fetchAll("
        SELECT d.* FROM datasets d 
        JOIN dataset_assignments da ON d.id = da.dataset_id 
        WHERE da.student_id = :sid ORDER BY d.created_at DESC
    ", ['sid' => $currentUser['id']]);
    $processedCount = (int)$db->fetchValue("SELECT COUNT(*) FROM processed_datasets WHERE student_id = :sid", ['sid' => $currentUser['id']]);
} else {
    $assignedDatasets = $db->fetchAll("SELECT * FROM datasets ORDER BY created_at DESC");
    $processedCount = (int)$db->fetchValue("SELECT COUNT(*) FROM processed_datasets");
}

$datasetCount = count($assignedDatasets);
$totalSizeBytes = array_sum(array_column($assignedDatasets, 'file_size'));
$totalSizeMB = round($totalSizeBytes / (1024 * 1024), 2);
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
            <nav class="flex flex-col gap-1" data-active-classes="bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded"><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="dashboard" href="dashboard.php"><span class="material-symbols-outlined text-[18px]">dashboard</span><span class="">Dashboard</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="dataset-catalog" href="DatasetCatalog.php"><span class="material-symbols-outlined text-[18px]">dataset</span><span class="">Dataset Catalog</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="my-datasets" href="MyDataSet.php"><span class="material-symbols-outlined text-[18px]">folder_shared</span><span class="">My Datasets</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="data-profiling-and-quality" href="DataProfilingAndQuality.php"><span class="material-symbols-outlined text-[18px]">troubleshoot</span><span class="">Data Profiling &amp; Quality</span></a><a aria-current="page" class="flex items-center gap-3 px-3 py-2 transition-all bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded" data-path="query-workspace" href="QueryWorkspace.php"><span class="material-symbols-outlined text-[18px]">terminal</span><span class="">Query Workspace</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="upload-processed-data" href="UploadProcessedData.php"><span class="material-symbols-outlined text-[18px]">cloud_upload</span><span class="">Upload Processed Data</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="recent-activity-and-audit-logs" href="RecentActivityAndAudit.php"><span class="material-symbols-outlined text-[18px]">history_toggle_off</span><span class="">Recent Activity &amp; Audit</span></a></nav>
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
            <div class="flex flex-col w-full">
                <!-- 1. Top Sub-header / Operational Session Status Bar -->
                <div class="flex flex-col bg-surface-container-lowest rounded-xl shadow-sm p-3.5 mb-4 gap-3">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <div class="flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high text-primary font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-[13px]">terminal</span>
                                <span>SYS-AI-02: DATASET PORTAL // SQL QUERY WORKSPACE</span>
                            </div>
                            <span class="text-outline-variant font-label-sm">•</span>
                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-primary-fixed text-primary font-code-sm text-code-sm font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                <span>DUCKDB v0.10.2 IN-MEMORY (WASM &amp; CLUSTER LOCAL NODE)</span>
                            </div>
                            <div class="hidden sm:inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-low text-on-surface-variant font-code-sm text-code-sm">
                                <span class="text-outline">SESSION:</span>
                                <span class="text-on-surface font-semibold">W-DUCK-89104</span>
                                <span class="text-outline">NODE:</span>
                                <span class="text-secondary font-mono">WASM-LOCAL-01</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-[#FDF6F0] text-tertiary-container font-label-sm text-label-sm hover:bg-tertiary-fixed transition-colors" href="#">
                                <span class="material-symbols-outlined text-[13px] text-tertiary">confirmation_number</span>
                                <span class="font-bold">Ticket #VP-TCK-1049</span>
                                <span class="text-outline text-[10px]">(Churn Baseline)</span>
                            </a>
                            <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container text-on-surface-variant font-code-sm text-code-sm">
                                <span class="material-symbols-outlined text-[13px] text-primary">psychology</span>
                                <span class="truncate max-w-[180px]">Flight: Churn (v2.4)</span>
                            </div>
                        </div>
                    </div>
                    <!-- Telemetry Chips Strip -->
                    <div class="flex flex-wrap items-center justify-between gap-3 pt-2.5 bg-surface-container-low/60 p-2.5 rounded-lg">
                        <div class="flex flex-wrap items-center gap-4">
                            <!-- Memory Pool -->
                            <div class="flex items-center gap-2">
                                <span class="font-label-sm text-label-sm uppercase text-outline">Memory Pool:</span>
                                <div class="w-24 h-1.5 rounded-full bg-surface-container-highest overflow-hidden">
                                    <div class="h-full bg-primary-container rounded-full" style="width: 52.5%"></div>
                                </div>
                                <span class="font-code-sm text-code-sm font-semibold text-on-surface">4.2 GB / 8.0 GB</span>
                                <span class="font-label-sm text-label-sm text-primary font-bold">(52.5%)</span>
                            </div>
                            <div class="h-3 w-px bg-outline-variant hidden md:block"></div>
                            <!-- Latency -->
                            <div class="flex items-center gap-1.5">
                                <span class="font-label-sm text-label-sm uppercase text-outline">Engine Latency:</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span>
                                <span class="font-code-sm text-code-sm font-semibold text-on-surface">3.4 ms</span>
                                <span class="px-1 py-0.2 rounded bg-surface-container font-label-sm text-label-sm text-primary">WARM</span>
                            </div>
                            <div class="h-3 w-px bg-outline-variant hidden md:block"></div>
                            <!-- Disk Spill -->
                            <div class="flex items-center gap-1.5">
                                <span class="font-label-sm text-label-sm uppercase text-outline">Disk Spill:</span>
                                <span class="font-code-sm text-code-sm font-semibold text-[#10B981]">0 B (In-RAM)</span>
                            </div>
                            <div class="h-3 w-px bg-outline-variant hidden lg:block"></div>
                            <!-- Vector Engine Mode -->
                            <div class="hidden lg:flex items-center gap-1.5">
                                <span class="font-label-sm text-label-sm uppercase text-outline">SIMD Execution:</span>
                                <span class="font-code-sm text-code-sm text-primary font-semibold">AVX-512 Native</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="inline-flex items-center gap-1 px-2.5 py-1 rounded bg-surface-container-lowest text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all font-label-sm text-label-sm shadow-sm" id="flushCacheBtn" title="Evict temporary table buffers">
                                <span class="material-symbols-outlined text-[14px]">cleaning_services</span>
                                <span>FLUSH CACHE</span>
                            </button>
                            <span class="font-code-sm text-code-sm text-outline">AUTO-COMMIT: ON</span>
                        </div>
                    </div>
                </div>
                <!-- 2. Command & Execution Toolbar -->
                <div class="bg-surface-container-lowest rounded-xl shadow-sm p-3 mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Target Parquet Selector -->
                        <div class="flex items-center gap-2 bg-surface-container-low px-2.5 py-1.5 rounded-lg">
                            <span class="material-symbols-outlined text-primary text-[18px]">table_chart</span>
                            <div class="flex flex-col">
                                <span class="font-label-sm text-label-sm text-outline uppercase">Active Source Context</span>
                                <div class="flex items-center gap-1.5">
                                    <select class="bg-transparent font-code-sm text-code-sm text-on-surface font-semibold focus:outline-none cursor-pointer pr-2">
                                        <option selected="">telecom_customer_churn_v2.parquet (142.5k rows • 34.2 MB)</option>
                                        <option>billing_events_stream_sample.parquet (1.2M rows • 88.0 MB)</option>
                                        <option>network_qos_telemetry_2024.parquet (450k rows • 62.4 MB)</option>
                                        <option>support_ticket_embeddings_reduced.parquet (85k rows • 21.0 MB)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Primary RUN QUERY Trigger -->
                        <button class="inline-flex items-center gap-2 px-4 py-2 rounded bg-primary-container text-on-primary font-headline-sm text-headline-sm font-semibold shadow-md hover:bg-primary transition-all active:scale-[0.98]" id="runQueryBtn">
                            <span class="material-symbols-outlined text-[18px] text-[#fedeb3]">bolt</span>
                            <span>RUN QUERY</span>
                            <span class="ml-1 px-1.5 py-0.5 rounded bg-primary text-[#fedeb3] font-label-sm text-label-sm tracking-widest">(CTRL+ENTER)</span>
                        </button>
                        <!-- Secondary Tactical Actions -->
                        <button class="inline-flex items-center gap-1.5 px-3 py-2 rounded bg-surface-container text-primary font-label-sm text-label-sm font-semibold hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined text-[16px]">schema</span>
                            <span>EXPLAIN ANALYZE</span>
                        </button>
                        <button class="inline-flex items-center gap-1.5 px-2.5 py-2 rounded bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm hover:text-on-surface hover:bg-surface-container transition-colors" id="formatSqlBtn">
                            <span class="material-symbols-outlined text-[16px]">code</span>
                            <span>FORMAT SQL</span>
                        </button>
                        <button class="inline-flex items-center gap-1.5 px-2.5 py-2 rounded bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm hover:text-on-surface hover:bg-surface-container transition-colors">
                            <span class="material-symbols-outlined text-[16px]">bookmark_add</span>
                            <span>SAVE SNIPPET</span>
                        </button>
                    </div>
                    <!-- Export & Share Utility Strip -->
                    <div class="flex items-center gap-2">
                        <div class="relative group">
                            <button class="inline-flex items-center gap-1.5 px-3 py-2 rounded bg-surface-container-low text-primary font-label-sm text-label-sm font-semibold hover:bg-surface-container transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">download</span>
                                <span>EXPORT RESULTS</span>
                                <span class="material-symbols-outlined text-[14px]">arrow_drop_down</span>
                            </button>
                            <div class="absolute right-0 top-full mt-1 hidden group-hover:flex flex-col w-44 bg-surface-container-lowest shadow-xl rounded-lg p-1.5 z-30">
                                <a class="flex items-center justify-between px-2.5 py-1.5 rounded text-on-surface hover:bg-surface-container font-code-sm text-code-sm" href="#">
                                    <span>Apache Parquet</span>
                                    <span class="text-outline text-[10px]">.parquet</span>
                                </a>
                                <a class="flex items-center justify-between px-2.5 py-1.5 rounded text-on-surface hover:bg-surface-container font-code-sm text-code-sm" href="#">
                                    <span>Arrow RecordBatch</span>
                                    <span class="text-outline text-[10px]">.arrow</span>
                                </a>
                                <a class="flex items-center justify-between px-2.5 py-1.5 rounded text-on-surface hover:bg-surface-container font-code-sm text-code-sm" href="#">
                                    <span>CSV (RFC 4180)</span>
                                    <span class="text-outline text-[10px]">.csv</span>
                                </a>
                                <a class="flex items-center justify-between px-2.5 py-1.5 rounded text-on-surface hover:bg-surface-container font-code-sm text-code-sm" href="#">
                                    <span>Newline JSON</span>
                                    <span class="text-outline text-[10px]">.jsonl</span>
                                </a>
                            </div>
                        </div>
                        <button class="inline-flex items-center gap-1.5 p-2 rounded bg-surface-container-low text-on-surface-variant hover:text-primary hover:bg-surface-container transition-colors" title="Copy shareable sandbox URL">
                            <span class="material-symbols-outlined text-[18px]">share</span>
                        </button>
                        <button class="inline-flex items-center gap-1.5 p-2 rounded bg-surface-container-low text-on-surface-variant hover:text-primary hover:bg-surface-container transition-colors" title="Workspace Settings">
                            <span class="material-symbols-outlined text-[18px]">settings</span>
                        </button>
                    </div>
                </div>
                <!-- 3. Two-Column Workspace Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start">
                    <!-- LEFT COLUMN: Schema Explorer & Pre-Flight Templates (3.5 cols on lg) -->
                    <div class="lg:col-span-4 xl:col-span-3 flex flex-col gap-4">
                        <!-- Panel 1: Data Lake Schema Tree -->
                        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-3.5 flex flex-col">
                            <div class="flex items-center justify-between pb-2 mb-2 bg-surface-container-low/70 -mx-3.5 -mt-3.5 p-3 rounded-t-xl">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px]">account_tree</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Data Lake Schema</span>
                                </div>
                                <span class="font-code-sm text-code-sm px-1.5 py-0.5 rounded bg-surface-container text-primary font-bold">28 COLS</span>
                            </div>
                            <div class="flex items-center gap-2 mb-3 px-2 py-1.5 rounded bg-surface-container-low">
                                <span class="material-symbols-outlined text-outline text-[16px]">filter_alt</span>
                                <input class="w-full bg-transparent font-code-sm text-code-sm text-on-surface placeholder:text-outline focus:outline-none" placeholder="Filter columns..." type="text" />
                            </div>
                            <!-- Target File Header -->
                            <div class="flex items-center gap-2 p-2 rounded bg-[#FDF6F0] mb-2.5">
                                <span class="material-symbols-outlined text-[16px] text-tertiary">folder_zip</span>
                                <span class="font-code-sm text-code-sm font-semibold text-tertiary-container truncate">telecom_customer_churn_v2</span>
                            </div>
                            <!-- Column List with Badges -->
                            <div class="flex flex-col gap-1 overflow-y-auto max-h-[310px] pr-1">
                                <!-- Col 1 -->
                                <div class="group flex items-center justify-between p-1.5 rounded hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="material-symbols-outlined text-secondary text-[14px]">key</span>
                                        <span class="font-code-sm text-code-sm font-semibold text-on-surface truncate">customer_id</span>
                                    </div>
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <span class="px-1.5 py-0.2 rounded bg-surface-container font-label-sm text-label-sm text-outline uppercase">VARCHAR</span>
                                        <span class="px-1 py-0.2 rounded bg-primary-fixed text-primary font-label-sm text-label-sm font-bold">PK</span>
                                    </div>
                                </div>
                                <!-- Col 2 -->
                                <div class="group flex items-center justify-between p-1.5 rounded hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="material-symbols-outlined text-outline text-[14px]">category</span>
                                        <span class="font-code-sm text-code-sm text-on-surface truncate">contract_type</span>
                                    </div>
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <span class="px-1.5 py-0.2 rounded bg-surface-container font-label-sm text-label-sm text-outline uppercase">VARCHAR</span>
                                        <span class="px-1 py-0.2 rounded bg-[#FDF6F0] text-tertiary font-label-sm text-label-sm">3 UNI</span>
                                    </div>
                                </div>
                                <!-- Col 3: Target -->
                                <div class="group flex items-center justify-between p-1.5 rounded bg-primary-fixed/30 hover:bg-primary-fixed/50 transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="material-symbols-outlined text-primary text-[14px]">flag</span>
                                        <span class="font-code-sm text-code-sm font-bold text-primary truncate">churn_label</span>
                                    </div>
                                    <div class="flex items-center gap-1 flex-shrink-0">
                                        <span class="px-1.5 py-0.2 rounded bg-surface-container font-label-sm text-label-sm text-outline uppercase">INT64</span>
                                        <span class="px-1.5 py-0.2 rounded bg-primary-container text-on-primary font-label-sm text-label-sm font-bold">TARGET</span>
                                    </div>
                                </div>
                                <!-- Col 4 -->
                                <div class="group flex items-center justify-between p-1.5 rounded hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="material-symbols-outlined text-outline text-[14px]">attach_money</span>
                                        <span class="font-code-sm text-code-sm text-on-surface truncate">monthly_charges_usd</span>
                                    </div>
                                    <span class="px-1.5 py-0.2 rounded bg-surface-container font-label-sm text-label-sm text-outline uppercase">FLOAT64</span>
                                </div>
                                <!-- Col 5 -->
                                <div class="group flex items-center justify-between p-1.5 rounded hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="material-symbols-outlined text-outline text-[14px]">calendar_today</span>
                                        <span class="font-code-sm text-code-sm text-on-surface truncate">contract_duration_months</span>
                                    </div>
                                    <span class="px-1.5 py-0.2 rounded bg-surface-container font-label-sm text-label-sm text-outline uppercase">INT64</span>
                                </div>
                                <!-- Col 6 -->
                                <div class="group flex items-center justify-between p-1.5 rounded hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="material-symbols-outlined text-outline text-[14px]">speed</span>
                                        <span class="font-code-sm text-code-sm text-on-surface truncate">data_usage_gb</span>
                                    </div>
                                    <span class="px-1.5 py-0.2 rounded bg-surface-container font-label-sm text-label-sm text-outline uppercase">FLOAT64</span>
                                </div>
                                <!-- Col 7 -->
                                <div class="group flex items-center justify-between p-1.5 rounded hover:bg-surface-container transition-colors">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="material-symbols-outlined text-outline text-[14px]">phone_in_talk</span>
                                        <span class="font-code-sm text-code-sm text-on-surface truncate">customer_service_calls</span>
                                    </div>
                                    <span class="px-1.5 py-0.2 rounded bg-surface-container font-label-sm text-label-sm text-outline uppercase">INT64</span>
                                </div>
                                <button class="flex items-center justify-center gap-1.5 py-2 mt-1 rounded bg-surface-container-low hover:bg-surface-container text-primary font-label-sm text-label-sm transition-colors">
                                    <span class="material-symbols-outlined text-[14px]">expand_more</span>
                                    <span>+21 ADDITIONAL SCHEMA COLUMNS</span>
                                </button>
                            </div>
                        </div>
                        <!-- Panel 2: Pre-Flight Feature Analysis Snippets -->
                        <div class="bg-surface-container-lowest rounded-xl shadow-sm p-3.5 flex flex-col">
                            <div class="flex items-center justify-between pb-2 mb-2 bg-surface-container-low/70 -mx-3.5 -mt-3.5 p-3 rounded-t-xl">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[18px]">auto_stories</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Pre-Flight Snippets</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-outline uppercase">SYS-AI TEMPLATES</span>
                            </div>
                            <div class="flex flex-col gap-2">
                                <!-- Snippet 1 -->
                                <div class="p-2.5 rounded-lg bg-surface-container-low hover:bg-surface-container cursor-pointer transition-all flex flex-col gap-1 group">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-md text-label-md text-primary font-bold group-hover:underline">Target Leakage Cross-Tab</span>
                                        <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-primary">arrow_forward</span>
                                    </div>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Calculates mutual info bounds &amp; cross-feature leak score.</span>
                                    <span class="font-code-sm text-code-sm text-outline mt-1 font-mono">CROSSTAB(contract_type, churn_label)</span>
                                </div>
                                <!-- Snippet 2 -->
                                <div class="p-2.5 rounded-lg bg-surface-container-low hover:bg-surface-container cursor-pointer transition-all flex flex-col gap-1 group">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-md text-label-md text-primary font-bold group-hover:underline">Class Imbalance &amp; Weight Matrix</span>
                                        <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-primary">arrow_forward</span>
                                    </div>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">RATI-0 positive-to-negative ratio for weighted binary loss.</span>
                                    <span class="font-code-sm text-code-sm text-outline mt-1 font-mono">COUNT(churn=1) / COUNT(churn=0)</span>
                                </div>
                                <!-- Snippet 3 -->
                                <div class="p-2.5 rounded-lg bg-surface-container-low hover:bg-surface-container cursor-pointer transition-all flex flex-col gap-1 group">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-md text-label-md text-primary font-bold group-hover:underline">Tenure Quantiles &amp; Hazard Cohorts</span>
                                        <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-primary">arrow_forward</span>
                                    </div>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">NTILE(10) segmentation across duration milestones.</span>
                                    <span class="font-code-sm text-code-sm text-outline mt-1 font-mono">NTILE(10) OVER (ORDER BY tenure)</span>
                                </div>
                                <!-- Snippet 4 -->
                                <div class="p-2.5 rounded-lg bg-surface-container-low hover:bg-surface-container cursor-pointer transition-all flex flex-col gap-1 group">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-md text-label-md text-primary font-bold group-hover:underline">Missing Value &amp; Null Scan</span>
                                        <span class="material-symbols-outlined text-[14px] text-outline group-hover:text-primary">arrow_forward</span>
                                    </div>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant">Data integrity scan across 28 features in vector mode.</span>
                                    <span class="font-code-sm text-code-sm text-outline mt-1 font-mono">SUM(CASE WHEN col IS NULL 1...)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT COLUMN: Editor & Results Console (8.5 cols on lg) -->
                    <div class="lg:col-span-8 xl:col-span-9 flex flex-col gap-4">
                        <!-- Editor Card -->
                        <div class="bg-surface-container-lowest rounded-xl shadow-sm flex flex-col overflow-hidden">
                            <!-- Query Tabs -->
                            <div class="flex items-center justify-between bg-surface-container-low px-3 pt-2">
                                <div class="flex items-center gap-1 overflow-x-auto">
                                    <!-- Active Tab 1 -->
                                    <div class="flex items-center gap-2 px-3 py-2 bg-surface-container-lowest rounded-t-lg shadow-sm">
                                        <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                                        <span class="font-code-sm text-code-sm font-semibold text-primary">churn_cohort_analysis.sql</span>
                                        <button class="hover:text-error text-outline transition-colors ml-1">
                                            <span class="material-symbols-outlined text-[14px]">close</span>
                                        </button>
                                    </div>
                                    <!-- Tab 2 -->
                                    <div class="flex items-center gap-2 px-3 py-2 bg-transparent text-on-surface-variant hover:bg-surface-container-high rounded-t-lg transition-colors cursor-pointer">
                                        <span class="font-code-sm text-code-sm">leakage_check_contract.sql</span>
                                        <button class="hover:text-error text-outline transition-colors ml-1">
                                            <span class="material-symbols-outlined text-[14px]">close</span>
                                        </button>
                                    </div>
                                    <!-- Tab 3 -->
                                    <div class="flex items-center gap-2 px-3 py-2 bg-transparent text-on-surface-variant hover:bg-surface-container-high rounded-t-lg transition-colors cursor-pointer">
                                        <span class="font-code-sm text-code-sm">scratchpad_v1.sql</span>
                                        <button class="hover:text-error text-outline transition-colors ml-1">
                                            <span class="material-symbols-outlined text-[14px]">close</span>
                                        </button>
                                    </div>
                                    <button class="p-1.5 rounded hover:bg-surface-container text-primary transition-colors" title="New Query Tab">
                                        <span class="material-symbols-outlined text-[16px]">add</span>
                                    </button>
                                </div>
                                <div class="flex items-center gap-2 pb-1.5">
                                    <span class="font-label-sm text-label-sm text-outline uppercase hidden sm:inline">DuckDB In-Memory Dialect</span>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-surface-container text-primary font-code-sm text-code-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span>
                                        <span>SYNTAX OK</span>
                                    </span>
                                </div>
                            </div>
                            <!-- SQL Dialect Editor Area with Monospaced Lines -->
                            <div class="relative flex bg-surface-container-lowest p-2 overflow-x-auto min-h-[290px] font-code-md text-code-md">
                                <!-- Line Numbers -->
                                <div class="flex flex-col text-outline-variant select-none pr-3 pl-2 py-1 text-right font-code-sm text-code-sm bg-surface-container-low/40 rounded-l">
                                    <span>01</span>
                                    <span>02</span>
                                    <span>03</span>
                                    <span>04</span>
                                    <span>05</span>
                                    <span>06</span>
                                    <span>07</span>
                                    <span>08</span>
                                    <span>09</span>
                                    <span>10</span>
                                    <span>11</span>
                                    <span>12</span>
                                    <span>13</span>
                                    <span>14</span>
                                </div>
                                <!-- Highlighted SQL Code Canvas -->
                                <div class="flex flex-col pl-3 py-1 flex-1 text-on-surface font-code-md text-code-md leading-[20px] whitespace-pre">
                                    <span class="text-outline font-italic select-none">-- Ticket #VP-TCK-1049: Baseline Feature Extraction &amp; Mutual Information Pre-Filter</span>
                                    <div><span class="text-primary font-bold">SELECT</span></div>
                                    <div> <span class="text-on-surface font-semibold">contract_type</span>,</div>
                                    <div> <span class="text-primary-container font-semibold">COUNT</span>(*) <span class="text-primary font-bold">AS</span> <span class="text-secondary font-semibold">total_subscribers</span>,</div>
                                    <div> <span class="text-primary-container font-semibold">ROUND</span>(<span class="text-primary-container font-semibold">AVG</span>(monthly_charges_usd), <span class="text-secondary">2</span>) <span class="text-primary font-bold">AS</span> <span class="text-secondary font-semibold">mean_monthly_charges</span>,</div>
                                    <div> <span class="text-primary-container font-semibold">ROUND</span>(<span class="text-primary-container font-semibold">SUM</span>(<span class="text-primary font-bold">CASE WHEN</span> churn_label = <span class="text-secondary">1</span> <span class="text-primary font-bold">THEN</span> <span class="text-secondary">1</span> <span class="text-primary font-bold">ELSE</span> <span class="text-secondary">0</span> <span class="text-primary font-bold">END</span>) * <span class="text-secondary">100.0</span> / <span class="text-primary-container font-semibold">COUNT</span>(*), <span class="text-secondary">2</span>) <span class="text-primary font-bold">AS</span> <span class="text-secondary font-semibold">churn_rate_pct</span>,</div>
                                    <div> <span class="text-primary-container font-semibold">ROUND</span>(<span class="text-primary-container font-semibold">AVG</span>(contract_duration_months), <span class="text-secondary">1</span>) <span class="text-primary font-bold">AS</span> <span class="text-secondary font-semibold">avg_tenure_months</span>,</div>
                                    <div> <span class="text-primary-container font-semibold">ROUND</span>(<span class="text-primary-container font-semibold">STDDEV_SAMP</span>(monthly_charges_usd), <span class="text-secondary">2</span>) <span class="text-primary font-bold">AS</span> <span class="text-secondary font-semibold">std_charges</span></div>
                                    <div><span class="text-primary font-bold">FROM</span> <span class="text-primary-container font-semibold">read_parquet</span>(<span class="text-[#352407] bg-[#FDF6F0] px-1 rounded">'s3://vp-lake-eu-01/lake/churn/v2_4/telecom_customer_churn_v2.parquet'</span>)</div>
                                    <div><span class="text-primary font-bold">WHERE</span> international_roaming_charges &gt;= <span class="text-secondary">0.0</span></div>
                                    <div><span class="text-primary font-bold">GROUP BY</span> contract_type</div>
                                    <div><span class="text-primary font-bold">ORDER BY</span> total_subscribers <span class="text-primary font-bold">DESC</span>;</div>
                                    <div class="h-4"></div>
                                </div>
                            </div>
                            <!-- Editor Status Bar Footer -->
                            <div class="flex flex-wrap items-center justify-between px-3 py-1.5 bg-surface-container-low font-code-sm text-code-sm text-on-surface-variant">
                                <div class="flex items-center gap-3">
                                    <span>Ln 11, Col 42</span>
                                    <span>•</span>
                                    <span>UTF-8</span>
                                    <span>•</span>
                                    <span class="text-primary font-semibold">DuckDB SQL Dialect</span>
                                    <span>•</span>
                                    <span class="text-[#10B981] font-semibold">Engine: Warm Cache</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-outline">Est. Credits: <strong class="text-on-surface">0.00</strong> (Range WASM Local)</span>
                                    <span class="inline-flex items-center gap-1 text-[#10B981]">
                                        <span class="material-symbols-outlined text-[13px]">check_circle</span>
                                        <span>Syntax: Valid</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Lower Pane: Query Results & Analytical Table Console -->
                        <div class="bg-surface-container-lowest rounded-xl shadow-sm flex flex-col overflow-hidden">
                            <!-- Results Header Tabs -->
                            <div class="flex flex-wrap items-center justify-between bg-surface-container-low px-3 pt-2">
                                <div class="flex items-center gap-1">
                                    <button class="flex items-center gap-2 px-3 py-2 bg-surface-container-lowest rounded-t-lg shadow-sm font-label-md text-label-md text-primary font-bold">
                                        <span class="material-symbols-outlined text-[16px]">table_rows</span>
                                        <span>RESULTS TABLE (3 ROWS)</span>
                                    </button>
                                    <button class="flex items-center gap-2 px-3 py-2 bg-transparent text-on-surface-variant hover:bg-surface-container-high rounded-t-lg transition-colors font-label-md text-label-md">
                                        <span class="material-symbols-outlined text-[16px]">account_tree</span>
                                        <span>EXECUTION PLAN (DAG 6 OPS)</span>
                                    </button>
                                    <button class="flex items-center gap-2 px-3 py-2 bg-transparent text-on-surface-variant hover:bg-surface-container-high rounded-t-lg transition-colors font-label-md text-label-md">
                                        <span class="material-symbols-outlined text-[16px]">memory</span>
                                        <span>SPILL &amp; VECTOR STATS</span>
                                    </button>
                                    <button class="flex items-center gap-2 px-3 py-2 bg-transparent text-on-surface-variant hover:bg-surface-container-high rounded-t-lg transition-colors font-label-md text-label-md">
                                        <span class="material-symbols-outlined text-[16px]">show_chart</span>
                                        <span>TELEMETRY TIMELINE</span>
                                    </button>
                                </div>
                                <div class="flex items-center gap-2 pb-1.5">
                                    <button class="p-1 rounded bg-surface-container text-primary hover:bg-surface-container-high transition-colors" title="Filter Result Columns">
                                        <span class="material-symbols-outlined text-[16px]">view_column</span>
                                    </button>
                                    <button class="p-1 rounded bg-surface-container text-primary hover:bg-surface-container-high transition-colors" title="Fullscreen Results View">
                                        <span class="material-symbols-outlined text-[16px]">fullscreen</span>
                                    </button>
                                </div>
                            </div>
                            <!-- Execution Telemetry Metric Bar -->
                            <div class="flex flex-wrap items-center justify-between px-3 py-2 bg-surface-container-lowest font-code-sm text-code-sm text-on-surface-variant shadow-inner">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="flex items-center gap-1 font-semibold text-primary">
                                        <span class="material-symbols-outlined text-[14px]">timer</span>
                                        Execution: 18.4 ms
                                    </span>
                                    <span class="text-outline text-[10px]">(Scan: 4.1 ms • Agg: 9.2 ms • Output: 5.1 ms)</span>
                                    <span class="text-outline-variant">•</span>
                                    <span>Scanned: <strong class="text-on-surface">34.2 MB / 142,500 rows</strong></span>
                                    <span class="text-outline-variant">•</span>
                                    <span>Vectors: <strong class="text-on-surface">70 Chunks (2,048)</strong></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 rounded bg-surface-container font-label-sm text-label-sm text-primary font-bold">AVX-512 VECTORIZED</span>
                                </div>
                            </div>
                            <!-- High-Density Data Table -->
                            <div class="overflow-x-auto w-full">
                                <table class="w-full text-left font-body-md text-body-md">
                                    <thead>
                                        <tr class="bg-surface-container-high text-primary font-label-sm text-label-sm uppercase">
                                            <th class="py-2 px-3">#</th>
                                            <th class="py-2 px-3">contract_type</th>
                                            <th class="py-2 px-3 text-right">total_subscribers</th>
                                            <th class="py-2 px-3 text-right">mean_monthly_charges</th>
                                            <th class="py-2 px-3 text-right">churn_rate_pct</th>
                                            <th class="py-2 px-3 text-right">avg_tenure_months</th>
                                            <th class="py-2 px-3 text-right">std_charges</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-none font-code-md text-code-md">
                                        <!-- Row 1 (Month-to-month, High Risk) -->
                                        <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                            <td class="py-2 px-3 font-code-sm text-code-sm text-outline">1</td>
                                            <td class="py-2 px-3 font-semibold text-on-surface">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-2 h-2 rounded-full bg-error"></span>
                                                    <span>Month-to-month</span>
                                                </div>
                                            </td>
                                            <td class="py-2 px-3 text-right font-semibold text-on-surface">78,410</td>
                                            <td class="py-2 px-3 text-right text-on-surface">$73.40</td>
                                            <td class="py-2 px-3 text-right">
                                                <div class="inline-flex items-center gap-2 justify-end">
                                                    <!-- High-churn indicator bar -->
                                                    <div class="w-14 h-2 bg-surface-container-high rounded-full overflow-hidden hidden sm:block">
                                                        <div class="bg-error h-full rounded-full" style="width: 42.8%;"></div>
                                                    </div>
                                                    <span class="px-2 py-0.5 rounded bg-error-container text-on-error-container font-bold">42.80%</span>
                                                </div>
                                            </td>
                                            <td class="py-2 px-3 text-right text-on-surface">18.2 mo</td>
                                            <td class="py-2 px-3 text-right text-on-surface-variant">$22.15</td>
                                        </tr>
                                        <!-- Row 2 (One year, Moderate Risk) -->
                                        <tr class="bg-surface-container-low/40 hover:bg-surface-container transition-colors">
                                            <td class="py-2 px-3 font-code-sm text-code-sm text-outline">2</td>
                                            <td class="py-2 px-3 font-semibold text-on-surface">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-2 h-2 rounded-full bg-tertiary"></span>
                                                    <span>One year</span>
                                                </div>
                                            </td>
                                            <td class="py-2 px-3 text-right font-semibold text-on-surface">34,220</td>
                                            <td class="py-2 px-3 text-right text-on-surface">$65.80</td>
                                            <td class="py-2 px-3 text-right">
                                                <div class="inline-flex items-center gap-2 justify-end">
                                                    <div class="w-14 h-2 bg-surface-container-high rounded-full overflow-hidden hidden sm:block">
                                                        <div class="bg-tertiary h-full rounded-full" style="width: 11.2%;"></div>
                                                    </div>
                                                    <span class="px-2 py-0.5 rounded bg-[#FDF6F0] text-tertiary-container font-bold">11.20%</span>
                                                </div>
                                            </td>
                                            <td class="py-2 px-3 text-right text-on-surface">34.8 mo</td>
                                            <td class="py-2 px-3 text-right text-on-surface-variant">$18.40</td>
                                        </tr>
                                        <!-- Row 3 (Two year, Low Risk / Retained) -->
                                        <tr class="bg-surface-container-lowest hover:bg-surface-container-low transition-colors">
                                            <td class="py-2 px-3 font-code-sm text-code-sm text-outline">3</td>
                                            <td class="py-2 px-3 font-semibold text-on-surface">
                                                <div class="flex items-center gap-2">
                                                    <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                                                    <span>Two year</span>
                                                </div>
                                            </td>
                                            <td class="py-2 px-3 text-right font-semibold text-on-surface">29,870</td>
                                            <td class="py-2 px-3 text-right text-on-surface">$60.10</td>
                                            <td class="py-2 px-3 text-right">
                                                <div class="inline-flex items-center gap-2 justify-end">
                                                    <div class="w-14 h-2 bg-surface-container-high rounded-full overflow-hidden hidden sm:block">
                                                        <div class="bg-[#10B981] h-full rounded-full" style="width: 2.9%;"></div>
                                                    </div>
                                                    <span class="px-2 py-0.5 rounded bg-surface-container text-[#10B981] font-bold">2.90%</span>
                                                </div>
                                            </td>
                                            <td class="py-2 px-3 text-right text-on-surface">48.6 mo</td>
                                            <td class="py-2 px-3 text-right text-on-surface-variant">$16.85</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Inline Visual Summary: Churn Risk Split Visualizer -->
                            <div class="p-3 bg-surface-container-low/40 flex flex-wrap items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Cohort Distribution Breakdown:</span>
                                    <!-- Sparkline visualization SVG -->
                                    <div class="flex items-center gap-2">
                                        <svg class="h-6 w-32" fill="none" viewbox="0 0 120 20">
                                            <rect fill="#4C1D95" height="16" opacity="0.9" rx="2" width="66" x="0" y="2"></rect>
                                            <rect fill="#78350F" height="16" opacity="0.7" rx="2" width="29" x="68" y="2"></rect>
                                            <rect fill="#10B981" height="16" opacity="0.8" rx="2" width="21" x="99" y="2"></rect>
                                        </svg>
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">55.0% Month-to-Month | 24.0% 1-Yr | 21.0% 2-Yr</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 text-outline font-label-sm text-label-sm">
                                    <span class="material-symbols-outlined text-[14px]">info</span>
                                    <span>Month-to-month contracts exhibit a 14.7x hazard multiplier over Two-year tenure.</span>
                                </div>
                            </div>
                            <!-- 4. Action Handoff Footer: Direct SYS-AI-03 Workbench Pipeline Integration -->
                            <div class="p-4 bg-gradient-to-r from-surface-container to-surface-container-low flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-lg bg-primary-container text-on-primary flex items-center justify-center flex-shrink-0 shadow-sm">
                                        <span class="material-symbols-outlined text-[22px]">model_training</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="font-label-sm text-label-sm text-primary font-bold uppercase tracking-wider">RANGE AI PIPELINE HANDOFF</span>
                                            <span class="px-1.5 py-0.2 rounded bg-primary-fixed text-primary font-label-sm text-label-sm">SYS-AI-03</span>
                                        </div>
                                        <p class="font-body-md text-body-md text-on-surface-variant">
                                            Push this aggregated cohort or query view directly into the AI Workbench model training pipeline for XGBoost Feature Selection.
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2.5 flex-shrink-0">
                                    <button class="px-3 py-2 rounded bg-surface-container-lowest text-primary font-headline-sm text-headline-sm font-semibold hover:bg-surface-container-high transition-colors shadow-sm">
                                        SAVE TABLE TO CATALOG
                                    </button>
                                    <button class="inline-flex items-center gap-2 px-4 py-2 rounded bg-primary-container text-on-primary font-headline-sm text-headline-sm font-semibold shadow-md hover:bg-primary transition-all active:scale-[0.98]">
                                        <span class="material-symbols-outlined text-[18px]">publish</span>
                                        <span>REGISTER FEATURE VIEW IN SYS-AI-03</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>