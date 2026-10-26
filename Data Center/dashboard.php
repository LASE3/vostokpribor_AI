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
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=JetBrains+Mono:wght@100..900&display=swap" rel="stylesheet" />
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
                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-[0_0_0_1px_#E8C9A0]"><span class="w-1.5 h-1.5 rounded-full bg-[#E8C9A0]"></span><span>SYS-AI-02: DATA CENTER & CATALOG</span></div>
                            <div class="hidden xl:inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-[#FDF6F0] text-tertiary-container font-label-sm text-label-sm"><span class="material-symbols-outlined text-[13px] text-tertiary">tune</span><span>Active Scenario: [Predictive AI: Customer Churn] (v2.4)</span></div>
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
            <nav class="flex flex-col gap-1" data-active-classes="bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded"><a aria-current="page" class="flex items-center gap-3 px-3 py-2 transition-all bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded" data-path="dashboard" href="dashboard.php"><span class="material-symbols-outlined text-[18px]">dashboard</span><span>Dashboard</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="dataset-catalog" href="DatasetCatalog.php"><span class="material-symbols-outlined text-[18px]">dataset</span><span>Dataset Catalog</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="my-datasets" href="MyDataSet.php"><span class="material-symbols-outlined text-[18px]">folder_shared</span><span>My Datasets</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="data-profiling-and-quality" href="DataProfilingAndQuality.php"><span class="material-symbols-outlined text-[18px]">troubleshoot</span><span>Data Profiling & Quality</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="query-workspace" href="QueryWorkspace.php"><span class="material-symbols-outlined text-[18px]">terminal</span><span>Query Workspace</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="upload-processed-data" href="UploadProcessedData.php"><span class="material-symbols-outlined text-[18px]">cloud_upload</span><span>Upload Processed Data</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="recent-activity-and-audit-logs" href="RecentActivityAndAudit.php"><span class="material-symbols-outlined text-[18px]">history_toggle_off</span><span>Recent Activity & Audit</span></a></nav>
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
            <div class="flex flex-col w-full gap-5">
                <!-- Active Scenario Command Ribbon -->
                <section class="w-full bg-surface-container-lowest rounded-lg shadow-sm p-4 relative overflow-hidden flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-primary-container"></div>
                    <div class="flex items-center gap-4 pl-2 min-w-0">
                        <div class="w-10 h-10 rounded bg-primary-container/10 flex items-center justify-center flex-shrink-0 text-primary-container">
                            <span class="material-symbols-outlined text-[24px]">terminal</span>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-label-sm text-label-sm text-primary-container uppercase tracking-wider">Mission Target // Ticket #VP-TCK-1049</span>
                                <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed">TRAINING PHASE: FEATURE INGESTION</span>
                                <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-secondary-fixed text-on-secondary-fixed">SLA REMAINING: 03h 42m</span>
                            </div>
                            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mt-0.5 truncate">
                                Predictive AI — Customer Churn Prediction (Pipeline v2.4)
                            </h1>
                            <p class="font-body-sm text-body-sm text-on-surface-variant truncate">
                                Assigned to: Cadet Eng. K. Chen • Objective: Construct normalized feature vector across telecommunications cohort & identify early attrition signals.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5 flex-shrink-0 self-end lg:self-center pl-2 lg:pl-0">
                        <button class="px-3 py-2 rounded bg-surface-container-high text-on-surface hover:bg-surface-container transition-all flex items-center gap-1.5 font-label-md text-label-md">
                            <span class="material-symbols-outlined text-[16px]">tune</span>
                            <span>Ticket Specs</span>
                        </button>
                        <button class="px-3.5 py-2 rounded bg-primary-container text-on-primary hover:bg-primary transition-all flex items-center gap-1.5 font-label-md text-label-md shadow-sm">
                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                            <span>Open in AI Workbench (SYS-AI-03)</span>
                        </button>
                    </div>
                </section>
                <!-- Key Telemetry Metrics Grid -->
                <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 w-full">
                    <!-- Metric 1 -->
                    <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm relative flex flex-col justify-between">
                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-tertiary-fixed-dim"></div>
                        <div class="flex items-center justify-between text-outline">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Total Datasets</span>
                            <span class="material-symbols-outlined text-[18px] text-primary">database</span>
                        </div>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="font-headline-xl text-headline-xl text-on-surface font-bold">42</span>
                            <span class="font-code-sm text-code-sm text-primary">Repositories</span>
                        </div>
                        <div class="mt-2.5 pt-2 flex items-center justify-between font-code-sm text-code-sm bg-surface-container-low/60 px-2 py-1 rounded">
                            <span class="text-on-surface-variant">18.6 GB volume</span>
                            <span class="text-secondary font-medium">Parquet, CSV, JSON</span>
                        </div>
                    </div>
                    <!-- Metric 2 -->
                    <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm relative flex flex-col justify-between">
                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-container"></div>
                        <div class="flex items-center justify-between text-outline">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Ticket Allocations</span>
                            <span class="material-symbols-outlined text-[18px] text-primary-container">assignment_turned_in</span>
                        </div>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="font-headline-xl text-headline-xl text-on-surface font-bold">04</span>
                            <span class="font-code-sm text-code-sm text-on-surface-variant">Datasets Active</span>
                        </div>
                        <div class="mt-2.5 pt-2 flex items-center justify-between font-code-sm text-code-sm bg-surface-container-low/60 px-2 py-1 rounded">
                            <span class="text-on-surface-variant">Assigned Tickets</span>
                            <span class="text-primary font-bold">#1049 • #1052</span>
                        </div>
                    </div>
                    <!-- Metric 3 -->
                    <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm relative flex flex-col justify-between">
                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-tertiary-fixed-dim"></div>
                        <div class="flex items-center justify-between text-outline">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Quality Health Score</span>
                            <span class="material-symbols-outlined text-[18px] text-[#10B981]">verified</span>
                        </div>
                        <div class="mt-2 flex items-baseline justify-between">
                            <div class="flex items-baseline gap-1">
                                <span class="font-headline-xl text-headline-xl text-on-surface font-bold">94.2%</span>
                                <span class="font-code-sm text-code-sm text-[#10B981]">Passed</span>
                            </div>
                            <!-- Sparkline visualization -->
                            <svg class="w-16 h-6 text-primary-container" fill="none" viewbox="0 0 60 20">
                                <path d="M0 16 L12 14 L24 17 L36 9 L48 11 L60 3" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                            </svg>
                        </div>
                        <div class="mt-2.5 pt-2 flex items-center justify-between font-code-sm text-code-sm bg-[#FDF6F0] px-2 py-1 rounded text-tertiary">
                            <span class="flex items-center gap-1 font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                3 Warnings
                            </span>
                            <span class="truncate">Telco Ingestion Batch</span>
                        </div>
                    </div>
                    <!-- Metric 4 -->
                    <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm relative flex flex-col justify-between">
                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-container"></div>
                        <div class="flex items-center justify-between text-outline">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Workspace Telemetry</span>
                            <span class="material-symbols-outlined text-[18px] text-primary">memory</span>
                        </div>
                        <div class="mt-2 flex items-baseline gap-2">
                            <span class="font-headline-xl text-headline-xl text-on-surface font-bold">12</span>
                            <span class="font-code-sm text-code-sm text-on-surface-variant">Sessions Live</span>
                        </div>
                        <div class="mt-2.5 pt-2 flex items-center justify-between font-code-sm text-code-sm bg-surface-container-low/60 px-2 py-1 rounded">
                            <span class="text-on-surface-variant">Mean Exec Latency</span>
                            <span class="text-on-surface font-bold">42 ms</span>
                        </div>
                    </div>
                </section>
                <!-- Interactive Control Deck & Filter Bar -->
                <section class="w-full bg-surface-container-lowest p-3 rounded shadow-sm flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2 flex-wrap">
                        <div class="flex items-center gap-1 bg-surface-container-low px-2 py-1 rounded">
                            <span class="material-symbols-outlined text-[16px] text-outline">filter_list</span>
                            <span class="font-label-sm text-label-sm uppercase text-outline">Scope:</span>
                            <button class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-primary-container text-on-primary">Scenario Only</button>
                            <button class="px-2 py-0.5 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface">All Range Repositories</button>
                        </div>
                        <div class="flex items-center gap-1 bg-surface-container-low px-2 py-1 rounded">
                            <span class="material-symbols-outlined text-[16px] text-outline">tune</span>
                            <span class="font-label-sm text-label-sm uppercase text-outline">Format:</span>
                            <span class="px-1.5 py-0.2 rounded font-code-sm text-code-sm bg-surface-container text-on-surface">ALL</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="px-2.5 py-1.5 rounded bg-surface-container-high text-on-surface hover:bg-surface-container flex items-center gap-1.5 font-label-sm text-label-sm transition-colors">
                            <span class="material-symbols-outlined text-[16px]">terminal</span>
                            <span>Run SQL Console</span>
                        </button>
                        <button class="px-2.5 py-1.5 rounded bg-surface-container-high text-on-surface hover:bg-surface-container flex items-center gap-1.5 font-label-sm text-label-sm transition-colors">
                            <span class="material-symbols-outlined text-[16px]">troubleshoot</span>
                            <span>View Integrity Audit</span>
                        </button>
                        <button class="px-2.5 py-1.5 rounded bg-primary-container text-on-primary flex items-center gap-1.5 font-label-sm text-label-sm shadow-sm hover:bg-primary transition-colors">
                            <span class="material-symbols-outlined text-[16px]">dataset</span>
                            <span>Dataset Catalog</span>
                        </button>
                    </div>
                </section>
                <!-- Split Panel: Assigned Repositories (Primary Focus) and Analytical Engine Sidecars -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-5 w-full">
                    <!-- Primary Focus: Assigned Datasets Console (8 cols) -->
                    <section class="xl:col-span-8 flex flex-col gap-3">
                        <div class="flex items-center justify-between bg-surface-container-lowest px-4 py-3 rounded shadow-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-primary-container"></span>
                                <h2 class="font-headline-sm text-headline-sm text-on-surface uppercase tracking-wide">
                                    Assigned Work Datasets // Active Flight Scope
                                </h2>
                            </div>
                            <span class="font-code-sm text-code-sm text-on-surface-variant">4 Resources Synchronized</span>
                        </div>
                        <!-- Dataset 1: Telecom Churn Base -->
                        <article class="bg-surface-container-lowest rounded shadow-sm p-4 relative overflow-hidden transition-all hover:bg-surface-bright">
                            <div class="absolute top-0 left-0 bottom-0 w-1 bg-primary-container"></div>
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pl-2">
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-label-sm text-label-sm font-bold text-primary-container">PARQUET // TIER-1 CORE</span>
                                        <span class="font-code-sm text-code-sm text-outline">v2.4.1</span>
                                        <span class="px-1.5 py-0.2 rounded font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed">Ticket #VP-TCK-1049</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold tracking-tight mt-1 truncate">
                                        telecom_customer_churn_v2.parquet
                                    </h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                                        Primary behavioral cohort records with 12-month tenure indices, telemetry metrics, and cancellation flag.
                                    </p>
                                </div>
                                <div class="flex items-center gap-3 flex-shrink-0 self-end md:self-center">
                                    <div class="flex flex-col items-end">
                                        <span class="font-label-sm text-label-sm text-outline uppercase">Health Check</span>
                                        <span class="font-code-sm text-code-sm text-[#10B981] font-bold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span>
                                            96% Clean
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button class="p-2 rounded bg-surface-container-low hover:bg-surface-container text-on-surface" title="Query Preview">
                                            <span class="material-symbols-outlined text-[18px]">terminal</span>
                                        </button>
                                        <button class="px-3 py-1.5 rounded bg-primary-container text-on-primary font-label-sm text-label-sm flex items-center gap-1 shadow-sm">
                                            <span>Ingest</span>
                                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-3 pt-3 pl-2 bg-surface-container-low/50 p-2 rounded">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Row Dimensions</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">142,800 Rows</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Schema Width</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">28 Features (Cols)</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Payload Size</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">4.82 MB (Compressed)</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Missing Ratio</span>
                                    <span class="font-code-sm text-code-sm text-[#10B981] font-semibold">0.04% Tolerable</span>
                                </div>
                            </div>
                        </article>
                        <!-- Dataset 2: Billing Transactions (Has Warning) -->
                        <article class="bg-surface-container-lowest rounded shadow-sm p-4 relative overflow-hidden transition-all hover:bg-surface-bright">
                            <div class="absolute top-0 left-0 bottom-0 w-1 bg-tertiary-fixed-dim"></div>
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pl-2">
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-label-sm text-label-sm font-bold text-secondary">CSV // COMMERCE INGEST</span>
                                        <span class="font-code-sm text-code-sm text-outline">v1.1</span>
                                        <span class="px-1.5 py-0.2 rounded font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed">Ticket #VP-TCK-1049</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold tracking-tight mt-1 truncate">
                                        billing_transactions_2024.csv
                                    </h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                                        Historical ledger of payments, chargebacks, and automated bank debits across the 2024 calendar window.
                                    </p>
                                </div>
                                <div class="flex items-center gap-3 flex-shrink-0 self-end md:self-center">
                                    <div class="flex flex-col items-end">
                                        <span class="font-label-sm text-label-sm text-outline uppercase">Health Check</span>
                                        <span class="font-code-sm text-code-sm text-tertiary font-bold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                            89% Warning
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button class="p-2 rounded bg-surface-container-low hover:bg-surface-container text-on-surface" title="Query Preview">
                                            <span class="material-symbols-outlined text-[18px]">terminal</span>
                                        </button>
                                        <button class="px-3 py-1.5 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1">
                                            <span>Resolve</span>
                                            <span class="material-symbols-outlined text-[14px]">tune</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-3 pt-3 pl-2 bg-[#FDF6F0] p-2 rounded">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-tertiary">Row Dimensions</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">450,210 Rows</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-tertiary">Schema Width</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">14 Features</span>
                                </div>
                                <div class="flex flex-col sm:col-span-2">
                                    <span class="font-label-sm text-label-sm uppercase text-tertiary">Integrity Alert</span>
                                    <span class="font-code-sm text-code-sm text-error font-semibold truncate">Missing 12,410 postal code coordinates</span>
                                </div>
                            </div>
                        </article>
                        <!-- Dataset 3: Network Outage Events -->
                        <article class="bg-surface-container-lowest rounded shadow-sm p-4 relative overflow-hidden transition-all hover:bg-surface-bright">
                            <div class="absolute top-0 left-0 bottom-0 w-1 bg-outline-variant"></div>
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pl-2">
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-label-sm text-label-sm font-bold text-outline">JSON // TELEMETRY STREAMS</span>
                                        <span class="font-code-sm text-code-sm text-outline">v4.0.2</span>
                                        <span class="px-1.5 py-0.2 rounded font-label-sm text-label-sm bg-surface-container-high text-on-surface">Ticket #VP-TCK-1052</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold tracking-tight mt-1 truncate">
                                        network_outage_events.json
                                    </h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                                        Tower incident tickets, degraded signal anomalies, and automated relay switch triggers.
                                    </p>
                                </div>
                                <div class="flex items-center gap-3 flex-shrink-0 self-end md:self-center">
                                    <div class="flex flex-col items-end">
                                        <span class="font-label-sm text-label-sm text-outline uppercase">Health Check</span>
                                        <span class="font-code-sm text-code-sm text-[#10B981] font-bold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span>
                                            99% Pristine
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button class="p-2 rounded bg-surface-container-low hover:bg-surface-container text-on-surface" title="Query Preview">
                                            <span class="material-symbols-outlined text-[18px]">terminal</span>
                                        </button>
                                        <button class="px-3 py-1.5 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm flex items-center gap-1">
                                            <span>Inspect</span>
                                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-3 pt-3 pl-2 bg-surface-container-low/50 p-2 rounded">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Log Entities</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">28,040 Nodes</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Structure</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">Nested GeoJSON</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Payload Size</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">14.1 MB Stream</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Latency Index</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">Zero Desync</span>
                                </div>
                            </div>
                        </article>
                        <!-- Dataset 4: Customer Support Transcripts -->
                        <article class="bg-surface-container-lowest rounded shadow-sm p-4 relative overflow-hidden transition-all hover:bg-surface-bright">
                            <div class="absolute top-0 left-0 bottom-0 w-1 bg-primary-container"></div>
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 pl-2">
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="font-label-sm text-label-sm font-bold text-primary-container">PARQUET // NLP TOKENIZED</span>
                                        <span class="font-code-sm text-code-sm text-outline">v1.8</span>
                                        <span class="px-1.5 py-0.2 rounded font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed">Ticket #VP-TCK-1049</span>
                                    </div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold tracking-tight mt-1 truncate">
                                        customer_support_transcripts.parquet
                                    </h3>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                                        Sentiment-annotated agent-customer interaction logs with masked PII strings and resolution satisfaction scores.
                                    </p>
                                </div>
                                <div class="flex items-center gap-3 flex-shrink-0 self-end md:self-center">
                                    <div class="flex flex-col items-end">
                                        <span class="font-label-sm text-label-sm text-outline uppercase">Health Check</span>
                                        <span class="font-code-sm text-code-sm text-[#10B981] font-bold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span>
                                            92% Clean
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button class="p-2 rounded bg-surface-container-low hover:bg-surface-container text-on-surface" title="Query Preview">
                                            <span class="material-symbols-outlined text-[18px]">terminal</span>
                                        </button>
                                        <button class="px-3 py-1.5 rounded bg-primary-container text-on-primary font-label-sm text-label-sm flex items-center gap-1 shadow-sm">
                                            <span>Ingest</span>
                                            <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-3 pt-3 pl-2 bg-surface-container-low/50 p-2 rounded">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Record Count</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">64,520 Transcripts</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Vector Dimension</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">768-D Embeddings</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">PII Compliance</span>
                                    <span class="font-code-sm text-code-sm text-[#10B981] font-semibold">100% Masked</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Storage Size</span>
                                    <span class="font-code-sm text-code-sm text-on-surface font-semibold">18.4 MB</span>
                                </div>
                            </div>
                        </article>
                    </section>
                    <!-- Sidecar Column: Platform Intelligence & Audit Stream (4 cols) -->
                    <aside class="xl:col-span-4 flex flex-col gap-5">
                        <!-- Live Audit Stream -->
                        <div class="bg-surface-container-lowest p-4 rounded shadow-sm flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[18px] text-primary">history_toggle_off</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface uppercase">Live Range Telemetry</span>
                                </div>
                                <span class="w-2 h-2 rounded-full bg-[#10B981] animate-ping"></span>
                            </div>
                            <div class="flex flex-col gap-3 mt-1">
                                <!-- Item 1 -->
                                <div class="flex items-start gap-2.5 p-2 rounded bg-surface-container-low/40">
                                    <div class="w-6 h-6 rounded bg-primary-container text-on-primary flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <span class="material-symbols-outlined text-[14px]">output</span>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <p class="font-body-sm text-body-sm text-on-surface leading-tight">
                                            <span class="font-semibold text-primary">Cadet Chen</span> exported filtered churn subset to Workbench SYS-AI-03.
                                        </p>
                                        <span class="font-label-sm text-label-sm text-outline mt-1">10 MINS AGO • SYS-AI-03 LINK</span>
                                    </div>
                                </div>
                                <!-- Item 2 -->
                                <div class="flex items-start gap-2.5 p-2 rounded bg-surface-container-low/40">
                                    <div class="w-6 h-6 rounded bg-[#FDF6F0] text-tertiary flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <span class="material-symbols-outlined text-[14px]">troubleshoot</span>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <p class="font-body-sm text-body-sm text-on-surface leading-tight">
                                            <span class="font-semibold text-on-surface">Data Engine</span> auto-profiled <span class="font-code-sm text-code-sm text-primary">fraud_synthetic_v1.parquet</span>.
                                        </p>
                                        <span class="font-label-sm text-label-sm text-outline mt-1">35 MINS AGO • BATCH PASS</span>
                                    </div>
                                </div>
                                <!-- Item 3 -->
                                <div class="flex items-start gap-2.5 p-2 rounded bg-surface-container-low/40">
                                    <div class="w-6 h-6 rounded bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <span class="material-symbols-outlined text-[14px]">publish</span>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <p class="font-body-sm text-body-sm text-on-surface leading-tight">
                                            New version <span class="font-code-sm text-code-sm text-primary">v3.1</span> published for <span class="font-code-sm text-code-sm">vibration_sensors.parquet</span> by <span class="font-semibold">Lt. Volkov</span>.
                                        </p>
                                        <span class="font-label-sm text-label-sm text-outline mt-1">1 HR AGO • INSTRUCTOR ACTION</span>
                                    </div>
                                </div>
                            </div>
                            <button class="w-full mt-1 py-1.5 rounded bg-surface-container-high text-on-surface font-label-sm text-label-sm text-center hover:bg-surface-container transition-colors">
                                View Master Audit Journal
                            </button>
                        </div>
                        <!-- Quick Query Execution Sandbox Card -->
                        <div class="bg-surface-container-lowest p-4 rounded shadow-sm flex flex-col gap-2">
                            <div class="flex items-center justify-between">
                                <span class="font-label-sm text-label-sm uppercase text-outline">DuckDB Instant Console</span>
                                <span class="font-code-sm text-code-sm text-primary font-bold">READY</span>
                            </div>
                            <div class="bg-surface-container-low p-2.5 rounded font-code-sm text-code-sm text-on-surface flex flex-col gap-1 overflow-x-auto">
                                <div class="text-outline text-label-sm">-- Quick sample of assigned churn batch</div>
                                <div class="text-primary-container font-semibold">SELECT tenure, churn_flag, monthly_charges</div>
                                <div>FROM read_parquet('telecom_customer_churn_v2.parquet')</div>
                                <div>WHERE international_plan = true LIMIT 5;</div>
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <span class="font-code-sm text-code-sm text-outline">Estimated Cost: 0 range credits</span>
                                <button class="px-3 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm flex items-center gap-1 shadow-sm">
                                    <span class="material-symbols-outlined text-[14px]">play_arrow</span>
                                    <span>Execute</span>
                                </button>
                            </div>
                        </div>
                        <!-- Active Flight Lab Card with Visual Asset -->
                        <div class="bg-surface-container-lowest p-3 rounded shadow-sm flex flex-col gap-2">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Sensor Array Ingest Node</span>
                            <div class="relative w-full h-28 rounded overflow-hidden">
                                <img class="w-full h-full object-cover" data-alt="High tech telemetry engineering laboratory with blue and purple avionics control panels, digital displays showing real-time data streams, and composite materials testing hardware under clean mission room lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDFDJ9S0nROc99LJ0LCQyqlwqSBdwYG0jjiyZoU85G6bIJTiYpXubDJ2KBUc4UPbP_Weev0R-WMdwMZOLQmdxMgKCh0HHNtcpUeXwrEoAIoFm28NoqWsnl_LzsKPeNjB70F_0VZgQStjBXQfFjTNe3QsP2Jv7OMU8okaR5pkpvHXJlVvJ8SR1OM-4xxUDTACjhAmdZOxiJyJXfO5fzIueHPot8xupv6zpdZbWbgj4sIH_uZRNBK01Jf" />
                                <div class="absolute inset-0 bg-primary-container/20 mix-blend-multiply"></div>
                                <div class="absolute bottom-2 left-2 px-2 py-0.5 rounded bg-surface-container-lowest/90 backdrop-blur font-code-sm text-code-sm text-on-surface font-bold">
                                    NODE-EAST-04 // ONLINE
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
                <!-- Department & Domain Repositories Grid -->
                <section class="w-full flex flex-col gap-3 mt-2">
                    <div class="flex items-center justify-between bg-surface-container-lowest px-4 py-3 rounded shadow-sm">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-primary">category</span>
                            <h2 class="font-headline-sm text-headline-sm text-on-surface uppercase tracking-wide">
                                Range Domain Classification // 42 Available Repositories
                            </h2>
                        </div>
                        <a class="font-label-sm text-label-sm text-primary hover:underline" href="#">Explore Full Matrix →</a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 w-full">
                        <!-- Dept 1 -->
                        <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm flex flex-col justify-between hover:bg-surface-bright transition-all group">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="w-7 h-7 rounded bg-primary-container/10 text-primary-container flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[16px]">flight</span>
                                    </span>
                                    <span class="font-label-sm text-label-sm bg-surface-container-high px-1.5 py-0.2 rounded text-on-surface">8 Datasets</span>
                                </div>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold mt-2.5">Avionics Telemetry</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">
                                    In-flight sensor streams, bus telemetry (ARINC-429), and attitude readings.
                                </p>
                            </div>
                            <div class="mt-4 pt-2 flex items-center justify-between font-code-sm text-code-sm text-primary">
                                <span>PARQUET / FEATHER</span>
                                <span class="material-symbols-outlined text-[14px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </div>
                        </div>
                        <!-- Dept 2 -->
                        <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm flex flex-col justify-between hover:bg-surface-bright transition-all group">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="w-7 h-7 rounded bg-[#FDF6F0] text-tertiary flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                                    </span>
                                    <span class="font-label-sm text-label-sm bg-tertiary-fixed text-on-tertiary-fixed px-1.5 py-0.2 rounded">12 Datasets</span>
                                </div>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold mt-2.5">Commercial & Billing</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">
                                    Transactional ledgers, customer churn records, payment cycles, and cohort stats.
                                </p>
                            </div>
                            <div class="mt-4 pt-2 flex items-center justify-between font-code-sm text-code-sm text-tertiary">
                                <span>CSV / XLSX</span>
                                <span class="material-symbols-outlined text-[14px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </div>
                        </div>
                        <!-- Dept 3 -->
                        <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm flex flex-col justify-between hover:bg-surface-bright transition-all group">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="w-7 h-7 rounded bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[16px]">radar</span>
                                    </span>
                                    <span class="font-label-sm text-label-sm bg-surface-container-high px-1.5 py-0.2 rounded text-on-surface">9 Datasets</span>
                                </div>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold mt-2.5">Flight Operations</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">
                                    Routing efficiency tables, dispatch schedules, and airspace weather advisories.
                                </p>
                            </div>
                            <div class="mt-4 pt-2 flex items-center justify-between font-code-sm text-code-sm text-secondary">
                                <span>PARQUET / JSON</span>
                                <span class="material-symbols-outlined text-[14px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </div>
                        </div>
                        <!-- Dept 4 -->
                        <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm flex flex-col justify-between hover:bg-surface-bright transition-all group">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="w-7 h-7 rounded bg-surface-container-high text-on-surface flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[16px]">forum</span>
                                    </span>
                                    <span class="font-label-sm text-label-sm bg-surface-container-high px-1.5 py-0.2 rounded text-on-surface">7 Datasets</span>
                                </div>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold mt-2.5">Support & NLP</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">
                                    Transcribed dispatch calls, customer resolution tickets, and parsed feedback.
                                </p>
                            </div>
                            <div class="mt-4 pt-2 flex items-center justify-between font-code-sm text-code-sm text-on-surface">
                                <span>JSON / AUDIO</span>
                                <span class="material-symbols-outlined text-[14px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </div>
                        </div>
                        <!-- Dept 5 -->
                        <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm flex flex-col justify-between hover:bg-surface-bright transition-all group">
                            <div>
                                <div class="flex items-center justify-between">
                                    <span class="w-7 h-7 rounded bg-primary-container/10 text-primary-container flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[16px]">precision_manufacturing</span>
                                    </span>
                                    <span class="font-label-sm text-label-sm bg-surface-container-high px-1.5 py-0.2 rounded text-on-surface">6 Datasets</span>
                                </div>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface font-semibold mt-2.5">Manufacturing QC</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1 line-clamp-2">
                                    Stress strain measurements, turbine vibration harmonics, and assembly tolerance logs.
                                </p>
                            </div>
                            <div class="mt-4 pt-2 flex items-center justify-between font-code-sm text-code-sm text-primary">
                                <span>CSV / TSV</span>
                                <span class="material-symbols-outlined text-[14px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- High-Density Quick Status Footer / System Spec Strip -->
                <footer class="w-full bg-surface-container-lowest px-4 py-2.5 rounded shadow-sm flex flex-wrap items-center justify-between gap-3 font-code-sm text-code-sm text-outline">
                    <div class="flex items-center gap-3">
                        <span>AI CLUSTER: ALPHA-RANGE-02</span>
                        <span>•</span>
                        <span>STORAGE STORAGE ENGINE: DUCKDB / APACHE ICEBERG</span>
                        <span>•</span>
                        <span class="text-[#10B981] font-semibold">SYNCHRONIZED (T-00:00:12)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-on-surface-variant">SYS-AI-02 DATA CENTER PROTOCOL</span>
                        <span class="px-1.5 py-0.2 rounded bg-tertiary-fixed text-on-tertiary-fixed text-label-sm font-bold">VOSTOKPRIBOR CERTIFIED</span>
                    </div>
                </footer>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>