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
        SELECT d.*, s.title AS scenario_title, da.created_at AS assigned_date 
        FROM datasets d 
        JOIN dataset_assignments da ON d.id = da.dataset_id 
        LEFT JOIN scenarios s ON d.scenario_id = s.id 
        WHERE da.student_id = :sid 
        ORDER BY da.created_at DESC
    ", ['sid' => $currentUser['id']]);

    $processedDatasets = $db->fetchAll("
        SELECT pd.*, d.name AS source_name 
        FROM processed_datasets pd 
        LEFT JOIN datasets d ON pd.source_dataset_id = d.id 
        WHERE pd.student_id = :sid 
        ORDER BY pd.created_at DESC
    ", ['sid' => $currentUser['id']]);
} else {
    $assignedDatasets = $db->fetchAll("
        SELECT d.*, s.title AS scenario_title, d.created_at AS assigned_date 
        FROM datasets d 
        LEFT JOIN scenarios s ON d.scenario_id = s.id 
        ORDER BY d.created_at DESC
    ");

    $processedDatasets = $db->fetchAll("
        SELECT pd.*, d.name AS source_name 
        FROM processed_datasets pd 
        LEFT JOIN datasets d ON pd.source_dataset_id = d.id 
        ORDER BY pd.created_at DESC
    ");
}
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
                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-[0_0_0_1px_#E8C9A0]"><span class="w-1.5 h-1.5 rounded-full bg-[#E8C9A0]"></span><span>SYS-AI-02: DATA CENTER &amp; CATALOG</span></div>
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
            <nav class="flex flex-col gap-1" data-active-classes="bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded"><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="dashboard" href="dashboard.php"><span class="material-symbols-outlined text-[18px]">dashboard</span><span>Dashboard</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="dataset-catalog" href="DatasetCatalog.php"><span class="material-symbols-outlined text-[18px]">dataset</span><span>Dataset Catalog</span></a><a aria-current="page" class="flex items-center gap-3 px-3 py-2 transition-all bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded" data-path="my-datasets" href="MyDataSet.php"><span class="material-symbols-outlined text-[18px]">folder_shared</span><span>My Datasets</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="data-profiling-and-quality" href="DataProfilingAndQuality.php"><span class="material-symbols-outlined text-[18px]">troubleshoot</span><span>Data Profiling & Quality</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="query-workspace" href="QueryWorkspace.php"><span class="material-symbols-outlined text-[18px]">terminal</span><span>Query Workspace</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="upload-processed-data" href="UploadProcessedData.php"><span class="material-symbols-outlined text-[18px]">cloud_upload</span><span>Upload Processed Data</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="recent-activity-and-audit-logs" href="RecentActivityAndAudit.php"><span class="material-symbols-outlined text-[18px]">history_toggle_off</span><span>Recent Activity & Audit</span></a></nav>
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
                <!-- Notification Toast Overlay -->
                <div class="fixed bottom-6 right-8 z-50 transition-opacity duration-300 opacity-0 pointer-events-none flex items-center gap-2 px-3 py-2 rounded shadow-xl bg-primary-container text-on-primary font-label-sm text-label-sm" id="quick-feedback-toast">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    <span>PARQUET QUERY BUFFER COPIED TO CLIPBOARD</span>
                </div>
                <!-- SECTION 1: Page Banner & Workspace Header -->
                <section class="flex flex-col gap-4 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                        <div class="flex flex-col gap-1 max-w-3xl">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high text-primary font-label-sm text-label-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-container"></span>
                                    CADET WORKSPACE REPOSITORY // CADET ENG. K. CHEN [VP-88204]
                                </span>
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-secondary-container/40 text-on-secondary-container font-code-sm text-code-sm font-semibold">
                                    SEC_LEVEL: L2-DEFENSE
                                </span>
                            </div>
                            <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight mt-1">
                                My Datasets &amp; Feature Stores
                            </h1>
                            <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">
                                Manage personal Parquet snapshots, active experiment feature tables, feature engineering scratchpads, and custom telemetry extractions staged for AI Workbench (SYS-AI-03).
                            </p>
                        </div>
                        <!-- Action Cluster & Live Quota Capsule -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                            <!-- Live Quota Capsule -->
                            <div class="flex flex-col justify-center px-3 py-2 rounded bg-surface-container-lowest shadow-sm min-w-[200px]">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-label-sm text-label-sm uppercase text-outline">Personal Allocation</span>
                                    <span class="font-code-sm text-code-sm font-bold text-primary">38.4 GB / 100 GB</span>
                                </div>
                                <div class="w-full h-1.5 rounded-full bg-surface-container-high overflow-hidden">
                                    <div class="h-full bg-primary-container rounded-full" style="width: 38.4%"></div>
                                </div>
                                <span class="font-code-sm text-code-sm text-on-surface-variant mt-1 text-right">38.4% Partitioned</span>
                            </div>
                            <button class="flex items-center justify-center gap-2 px-3 py-2 rounded bg-surface-container-lowest text-primary font-label-md text-label-md shadow-sm hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[16px]">cloud_sync</span>
                                <span>Import Lake (S3)</span>
                            </button>
                            <button class="flex items-center justify-center gap-2 px-3 py-2 rounded bg-surface-container-lowest text-primary font-label-md text-label-md shadow-sm hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[16px]">send_time_extension</span>
                                <span>Sync Workbench</span>
                            </button>
                            <button class="flex items-center justify-center gap-2 px-4 py-2 rounded bg-primary-container text-on-primary font-label-md text-label-md shadow-sm hover:bg-primary transition-colors">
                                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                                <span>+ New Personal Dataset</span>
                            </button>
                        </div>
                    </div>
                </section>
                <!-- SECTION 2: Telemetry Metrics Summary Cards (4 Bento Nodes) -->
                <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                    <!-- Card 1 -->
                    <div class="relative overflow-hidden flex flex-col justify-between p-3.5 rounded bg-surface-container-lowest shadow-sm">
                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-container"></div>
                        <div class="flex items-start justify-between">
                            <span class="font-label-sm text-label-sm uppercase text-outline">Active Personal Datasets</span>
                            <span class="material-symbols-outlined text-primary text-[18px]">folder_special</span>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-baseline gap-2">
                                <span class="font-headline-lg text-headline-lg text-on-surface font-bold">7</span>
                                <span class="font-label-sm text-label-sm text-primary uppercase">Repositories</span>
                            </div>
                            <p class="font-code-sm text-code-sm text-on-surface-variant mt-1">
                                3 Parquet • 2 Arrow Tables • 2 CSV Ingests
                            </p>
                        </div>
                        <div class="mt-3 pt-2 flex items-center justify-between bg-surface-container-low/40 -mx-3.5 -mb-3.5 px-3.5 py-1.5">
                            <span class="font-code-sm text-code-sm text-outline">TOTAL VOLUME</span>
                            <span class="font-code-sm text-code-sm font-semibold text-on-surface">224.62 MB</span>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="relative overflow-hidden flex flex-col justify-between p-3.5 rounded bg-surface-container-lowest shadow-sm">
                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary-container"></div>
                        <div class="flex items-start justify-between">
                            <span class="font-label-sm text-label-sm uppercase text-outline">Pinned for Ticket Tasks</span>
                            <span class="material-symbols-outlined text-primary text-[18px]">push_pin</span>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-baseline gap-2">
                                <span class="font-headline-lg text-headline-lg text-on-surface font-bold">2</span>
                                <span class="font-label-sm text-label-sm text-primary uppercase">Assigned Datasets</span>
                            </div>
                            <div class="flex flex-wrap gap-1 mt-1">
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-fixed text-tertiary font-code-sm text-code-sm">#VP-TCK-1049</span>
                                <span class="px-1.5 py-0.2 rounded bg-tertiary-fixed text-tertiary font-code-sm text-code-sm">#VP-TCK-1052</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 flex items-center justify-between bg-surface-container-low/40 -mx-3.5 -mb-3.5 px-3.5 py-1.5">
                            <span class="font-code-sm text-code-sm text-outline">ACTIVE DISPATCH</span>
                            <span class="font-code-sm text-code-sm text-primary font-bold">PREDICTIVE RANGE</span>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="relative overflow-hidden flex flex-col justify-between p-3.5 rounded bg-surface-container-lowest shadow-sm">
                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-secondary"></div>
                        <div class="flex items-start justify-between">
                            <span class="font-label-sm text-label-sm uppercase text-outline">Feature Views Created</span>
                            <span class="material-symbols-outlined text-secondary text-[18px]">hub</span>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-baseline gap-2">
                                <span class="font-headline-lg text-headline-lg text-on-surface font-bold">14</span>
                                <span class="font-label-sm text-label-sm text-secondary uppercase">Engineered Views</span>
                            </div>
                            <p class="font-code-sm text-code-sm text-on-surface-variant mt-1">
                                5 Exported to SYS-AI-03 XGBoost
                            </p>
                        </div>
                        <div class="mt-3 pt-2 flex items-center justify-between bg-surface-container-low/40 -mx-3.5 -mb-3.5 px-3.5 py-1.5">
                            <span class="font-code-sm text-code-sm text-outline">MODEL LINKAGE</span>
                            <span class="font-code-sm text-code-sm text-secondary font-semibold">5 ACTIVE PIPES</span>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="relative overflow-hidden flex flex-col justify-between p-3.5 rounded bg-surface-container-lowest shadow-sm">
                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-primary"></div>
                        <div class="flex items-start justify-between">
                            <span class="font-label-sm text-label-sm uppercase text-outline">Staging Buffer Health</span>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#10B981] animate-pulse"></span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant">NODE-02</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="flex items-baseline gap-2">
                                <span class="font-headline-lg text-headline-lg text-on-surface font-bold">98.6%</span>
                                <span class="font-label-sm text-label-sm text-primary uppercase">Nominal</span>
                            </div>
                            <p class="font-code-sm text-code-sm text-on-surface-variant mt-1">
                                Zero corrupted partitions • Checksums valid
                            </p>
                        </div>
                        <div class="mt-3 pt-2 flex items-center justify-between bg-surface-container-low/40 -mx-3.5 -mb-3.5 px-3.5 py-1.5">
                            <span class="font-code-sm text-code-sm text-outline">SHARD STATUS</span>
                            <span class="font-code-sm text-code-sm font-semibold text-[#10B981]">SYNCED &amp; MOUNTED</span>
                        </div>
                    </div>
                </section>
                <!-- SECTION 3: Filter, Scope & Telemetry Command Strip -->
                <section class="flex flex-col gap-3 p-3 rounded bg-surface-container-lowest shadow-sm mb-4">
                    <!-- Row 1: Workspace Filter Tabs & Format Pills -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 pb-3 border-b border-surface-container-high/70">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <button class="filter-tab-btn px-2.5 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm transition-all" onclick="switchFilterTab('all', this)">
                                All Personal (7)
                            </button>
                            <button class="filter-tab-btn px-2.5 py-1 rounded bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm hover:bg-surface-container-high transition-all" onclick="switchFilterTab('pinned', this)">
                                Pinned / Ticket-Linked (2)
                            </button>
                            <button class="filter-tab-btn px-2.5 py-1 rounded bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm hover:bg-surface-container-high transition-all" onclick="switchFilterTab('scratchpad', this)">
                                Feature Scratchpads (3)
                            </button>
                            <button class="filter-tab-btn px-2.5 py-1 rounded bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm hover:bg-surface-container-high transition-all" onclick="switchFilterTab('draft', this)">
                                Drafts &amp; Experiments (2)
                            </button>
                            <button class="filter-tab-btn px-2.5 py-1 rounded bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm hover:bg-surface-container-high transition-all" onclick="switchFilterTab('archived', this)">
                                Archived (0)
                            </button>
                        </div>
                        <!-- Format Filter Pills -->
                        <div class="flex items-center gap-1.5 overflow-x-auto text-nowrap">
                            <span class="font-label-sm text-label-sm uppercase text-outline mr-1">FORMAT:</span>
                            <button class="px-2 py-0.5 rounded bg-surface-container-high font-code-sm text-code-sm text-primary font-bold">ALL</button>
                            <button class="px-2 py-0.5 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface-variant hover:bg-surface-container-high">PARQUET</button>
                            <button class="px-2 py-0.5 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface-variant hover:bg-surface-container-high">FEATHER/ARROW</button>
                            <button class="px-2 py-0.5 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface-variant hover:bg-surface-container-high">DUCKDB NATIVE</button>
                            <button class="px-2 py-0.5 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface-variant hover:bg-surface-container-high">CSV</button>
                        </div>
                    </div>
                    <!-- Row 2: Search Input, Bulk Selection Bar & View Mode Switches -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                        <!-- Search Input -->
                        <div class="flex-1 relative flex items-center">
                            <span class="material-symbols-outlined absolute left-2.5 text-outline text-[18px]">search</span>
                            <input class="w-full h-8 pl-8 pr-3 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest shadow-sm transition-all" oninput="filterBySearch(this.value)" placeholder="Search personal datasets, feature definitions, tags, ticket IDs..." type="text" />
                        </div>
                        <!-- Bulk Actions & Toggle -->
                        <div class="flex items-center gap-2 justify-between sm:justify-end">
                            <div class="flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface-variant">
                                <span class="material-symbols-outlined text-[15px] text-outline">tune</span>
                                <span id="selected-counter-display">0 SELECTED</span>
                            </div>
                            <button class="px-2 py-1 rounded bg-surface-container-low text-on-surface-variant font-label-sm text-label-sm hover:bg-surface-container-high flex items-center gap-1 transition-colors">
                                <span class="material-symbols-outlined text-[14px]">file_download</span>
                                <span>Export Selected</span>
                            </button>
                            <button class="px-2 py-1 rounded bg-error-container text-on-error-container font-label-sm text-label-sm hover:opacity-90 flex items-center gap-1 transition-colors">
                                <span class="material-symbols-outlined text-[14px]">delete</span>
                                <span>Drop Scratchpad</span>
                            </button>
                            <div class="w-px h-5 bg-surface-container-high mx-1 hidden sm:block"></div>
                            <!-- View Mode Switch -->
                            <div class="flex items-center rounded bg-surface-container-low p-0.5">
                                <button class="p-1 rounded bg-primary-container text-on-primary transition-all" id="toggle-list-btn" onclick="toggleViewMode('list')" title="High-Density List Mode">
                                    <span class="material-symbols-outlined text-[16px] block">format_list_bulleted</span>
                                </button>
                                <button class="p-1 rounded bg-surface-container-low text-on-surface-variant transition-all hover:text-on-surface" id="toggle-grid-btn" onclick="toggleViewMode('grid')" title="Card Grid Mode">
                                    <span class="material-symbols-outlined text-[16px] block">grid_view</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- SECTION 4A: HIGH-DENSITY DATASET LIST (Default Active Engineering View) -->
                <div class="flex flex-col gap-2" id="dataset-list-container">
                    <!-- Header Row -->
                    <div class="hidden lg:grid grid-cols-12 gap-3 px-3 py-2 rounded bg-surface-container-high text-primary font-label-sm text-label-sm uppercase tracking-wider items-center shadow-sm">
                        <div class="col-span-1 flex items-center gap-2">
                            <input class="rounded w-3.5 h-3.5 accent-primary cursor-pointer" onchange="selectAllRows(this)" type="checkbox" />
                            <span>PIN</span>
                        </div>
                        <div class="col-span-4">Dataset Identifier &amp; Tactical Metadata</div>
                        <div class="col-span-2">Telemetry &amp; Schema Size</div>
                        <div class="col-span-2">Data Quality &amp; PII Health</div>
                        <div class="col-span-1">Modified</div>
                        <div class="col-span-2 text-right pr-2">Dispatch Commands</div>
                    </div>
                    <!-- DATASET 1: Pinned Primary Active -->
                    <div class="dataset-item-target dataset-row-item grid grid-cols-1 lg:grid-cols-12 gap-3 p-3 rounded bg-surface-container-lowest shadow-sm hover:shadow-md transition-all items-center" data-pinned="true" data-search-index="telecom_customer_churn_v2_engineered.parquet VP-TCK-1049 xgboost feature roaming_to_tenure_ratio imputed_total_charges" data-type="scratchpad">
                        <!-- Col 1: Select & Pin -->
                        <div class="col-span-1 flex items-center justify-between lg:justify-start gap-2">
                            <input class="row-select-checkbox rounded w-3.5 h-3.5 accent-primary cursor-pointer" onchange="handleRowCheck(this)" type="checkbox" />
                            <button class="p-1 rounded text-primary hover:bg-surface-container-high transition-colors" title="Pinned Ticket Task">
                                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">push_pin</span>
                            </button>
                            <span class="inline-flex lg:hidden px-1.5 py-0.5 rounded bg-tertiary-fixed text-tertiary font-code-sm text-code-sm">
                                #VP-TCK-1049
                            </span>
                        </div>
                        <!-- Col 2: Name & Tags -->
                        <div class="col-span-4 flex flex-col gap-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-code-md text-code-md font-bold text-primary hover:underline cursor-pointer">
                                    telecom_customer_churn_v2_engineered.parquet
                                </span>
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.2 rounded bg-tertiary-fixed text-tertiary font-code-sm text-code-sm font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                    VP-TCK-1049
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="px-1.5 py-0.2 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                    XGBOOST FEATURE SET
                                </span>
                                <span class="px-1.5 py-0.2 rounded bg-surface-container-low text-on-surface-variant font-code-sm text-code-sm">
                                    v2.4-cadet-draft
                                </span>
                                <span class="font-code-sm text-code-sm text-secondary truncate max-w-[220px]" title="Engineered: roaming_to_tenure_ratio, imputed_total_charges">
                                    +4 Engineered Features
                                </span>
                            </div>
                        </div>
                        <!-- Col 3: Specs -->
                        <div class="col-span-2 flex flex-col justify-center">
                            <div class="flex items-center gap-1 font-code-sm text-code-sm text-on-surface font-semibold">
                                <span class="material-symbols-outlined text-[14px] text-outline">database</span>
                                <span>142,800 Rows</span>
                            </div>
                            <div class="font-code-sm text-code-sm text-on-surface-variant">
                                32 Features • <span class="text-primary font-semibold">5.12 MB</span>
                            </div>
                        </div>
                        <!-- Col 4: Quality & Integrity -->
                        <div class="col-span-2 flex flex-col justify-center">
                            <div class="flex items-center justify-between mb-0.5">
                                <span class="font-label-sm text-label-sm text-on-surface">Pristine Check</span>
                                <span class="font-code-sm text-code-sm text-[#10B981] font-bold">99.4%</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-surface-container-high overflow-hidden">
                                <div class="h-full bg-[#10B981] rounded-full" style="width: 99.4%"></div>
                            </div>
                            <span class="font-code-sm text-code-sm text-outline mt-0.5">Zero null violations</span>
                        </div>
                        <!-- Col 5: Updated -->
                        <div class="col-span-1 flex flex-col justify-center">
                            <span class="font-code-sm text-code-sm text-on-surface font-medium">12m ago</span>
                            <span class="font-code-sm text-code-sm text-outline">K. Chen</span>
                        </div>
                        <!-- Col 6: Actions -->
                        <div class="col-span-2 flex items-center justify-start lg:justify-end gap-1.5">
                            <button class="px-2 py-1 rounded bg-surface-container-high text-primary hover:bg-primary-container hover:text-on-primary transition-colors font-label-sm text-label-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">terminal</span>
                                <span>Query</span>
                            </button>
                            <button class="px-2 py-1 rounded bg-primary-container text-on-primary hover:bg-primary transition-colors font-label-sm text-label-sm flex items-center gap-1 shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">bolt</span>
                                <span>Push AI-03</span>
                            </button>
                            <button class="p-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[16px]">more_vert</span>
                            </button>
                        </div>
                    </div>
                    <!-- DATASET 2: Pinned Network Outage -->
                    <div class="dataset-item-target dataset-row-item grid grid-cols-1 lg:grid-cols-12 gap-3 p-3 rounded bg-surface-container-lowest shadow-sm hover:shadow-md transition-all items-center" data-pinned="true" data-search-index="network_outage_anomalies_filtered.arrow VP-TCK-1052 geojson embeddings stream extract" data-type="scratchpad">
                        <div class="col-span-1 flex items-center justify-between lg:justify-start gap-2">
                            <input class="row-select-checkbox rounded w-3.5 h-3.5 accent-primary cursor-pointer" onchange="handleRowCheck(this)" type="checkbox" />
                            <button class="p-1 rounded text-primary hover:bg-surface-container-high transition-colors" title="Pinned Ticket Task">
                                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">push_pin</span>
                            </button>
                            <span class="inline-flex lg:hidden px-1.5 py-0.5 rounded bg-tertiary-fixed text-tertiary font-code-sm text-code-sm">
                                #VP-TCK-1052
                            </span>
                        </div>
                        <div class="col-span-4 flex flex-col gap-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-code-md text-code-md font-bold text-on-surface hover:text-primary cursor-pointer">
                                    network_outage_anomalies_filtered.arrow
                                </span>
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.2 rounded bg-tertiary-fixed text-tertiary font-code-sm text-code-sm font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                    VP-TCK-1052
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="px-1.5 py-0.2 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                    GEOJSON EMBEDDINGS
                                </span>
                                <span class="px-1.5 py-0.2 rounded bg-surface-container-low text-on-surface-variant font-code-sm text-code-sm">
                                    STREAM-EXTRACT
                                </span>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col justify-center">
                            <div class="flex items-center gap-1 font-code-sm text-code-sm text-on-surface font-semibold">
                                <span class="material-symbols-outlined text-[14px] text-outline">grain</span>
                                <span>28,040 Nodes</span>
                            </div>
                            <div class="font-code-sm text-code-sm text-on-surface-variant">
                                16 Features • <span class="text-primary font-semibold">14.1 MB</span>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col justify-center">
                            <div class="flex items-center justify-between mb-0.5">
                                <span class="font-label-sm text-label-sm text-on-surface">Pristine Check</span>
                                <span class="font-code-sm text-code-sm text-[#10B981] font-bold">99.0%</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-surface-container-high overflow-hidden">
                                <div class="h-full bg-[#10B981] rounded-full" style="width: 99.0%"></div>
                            </div>
                            <span class="font-code-sm text-code-sm text-outline mt-0.5">14 warnings suppressed</span>
                        </div>
                        <div class="col-span-1 flex flex-col justify-center">
                            <span class="font-code-sm text-code-sm text-on-surface font-medium">2h ago</span>
                            <span class="font-code-sm text-code-sm text-outline">K. Chen</span>
                        </div>
                        <div class="col-span-2 flex items-center justify-start lg:justify-end gap-1.5">
                            <button class="px-2 py-1 rounded bg-surface-container-high text-primary hover:bg-primary-container hover:text-on-primary transition-colors font-label-sm text-label-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">terminal</span>
                                <span>Query SQL</span>
                            </button>
                            <button class="px-2 py-1 rounded bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-sm text-label-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">share</span>
                                <span>Share</span>
                            </button>
                            <button class="p-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[16px]">more_vert</span>
                            </button>
                        </div>
                    </div>
                    <!-- DATASET 3: Cleaned Billing Dataset -->
                    <div class="dataset-item-target dataset-row-item grid grid-cols-1 lg:grid-cols-12 gap-3 p-3 rounded bg-surface-container-lowest shadow-sm hover:shadow-md transition-all items-center" data-pinned="false" data-search-index="billing_imputed_clean_v1.parquet data-cleaning imputation median-fill" data-type="draft">
                        <div class="col-span-1 flex items-center justify-between lg:justify-start gap-2">
                            <input class="row-select-checkbox rounded w-3.5 h-3.5 accent-primary cursor-pointer" onchange="handleRowCheck(this)" type="checkbox" />
                            <button class="p-1 rounded text-outline hover:text-primary hover:bg-surface-container-high transition-colors" title="Pin to quick launch">
                                <span class="material-symbols-outlined text-[18px]">push_pin</span>
                            </button>
                        </div>
                        <div class="col-span-4 flex flex-col gap-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-code-md text-code-md font-bold text-on-surface hover:text-primary cursor-pointer">
                                    billing_imputed_clean_v1.parquet
                                </span>
                                <span class="px-1.5 py-0.2 rounded bg-surface-container-high text-on-surface-variant font-code-sm text-code-sm">
                                    STAGE-REFINED
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="px-1.5 py-0.2 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                    DATA-CLEANING
                                </span>
                                <span class="px-1.5 py-0.2 rounded bg-surface-container-low text-on-surface-variant font-code-sm text-code-sm">
                                    IMPUTATION COMPLETED
                                </span>
                                <span class="px-1.5 py-0.2 rounded bg-surface-container-low text-on-surface-variant font-code-sm text-code-sm">
                                    MEDIAN-FILL
                                </span>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col justify-center">
                            <div class="flex items-center gap-1 font-code-sm text-code-sm text-on-surface font-semibold">
                                <span class="material-symbols-outlined text-[14px] text-outline">database</span>
                                <span>450,210 Rows</span>
                            </div>
                            <div class="font-code-sm text-code-sm text-on-surface-variant">
                                14 Features • <span class="text-primary font-semibold">18.2 MB</span>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col justify-center">
                            <div class="flex items-center justify-between mb-0.5">
                                <span class="font-label-sm text-label-sm text-on-surface">Postal Imputed</span>
                                <span class="font-code-sm text-code-sm text-on-surface-variant font-bold">96.0%</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-surface-container-high overflow-hidden">
                                <div class="h-full bg-secondary rounded-full" style="width: 96.0%"></div>
                            </div>
                            <span class="font-code-sm text-code-sm text-outline mt-0.5">4% missing postal filled</span>
                        </div>
                        <div class="col-span-1 flex flex-col justify-center">
                            <span class="font-code-sm text-code-sm text-on-surface font-medium">Yesterday</span>
                            <span class="font-code-sm text-code-sm text-outline">K. Chen</span>
                        </div>
                        <div class="col-span-2 flex items-center justify-start lg:justify-end gap-1.5">
                            <button class="px-2 py-1 rounded bg-surface-container-high text-primary hover:bg-primary-container hover:text-on-primary transition-colors font-label-sm text-label-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">terminal</span>
                                <span>Query SQL</span>
                            </button>
                            <button class="px-2 py-1 rounded bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-sm text-label-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">troubleshoot</span>
                                <span>Inspect</span>
                            </button>
                            <button class="p-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[16px]">more_vert</span>
                            </button>
                        </div>
                    </div>
                    <!-- DATASET 4: Cadet Experiment / Embeddings -->
                    <div class="dataset-item-target dataset-row-item grid grid-cols-1 lg:grid-cols-12 gap-3 p-3 rounded bg-surface-container-lowest shadow-sm hover:shadow-md transition-all items-center" data-pinned="false" data-search-index="customer_support_sentiment_embeddings.arrow nlp 768-d embeddings bert-tokenized cadet experiment" data-type="scratchpad">
                        <div class="col-span-1 flex items-center justify-between lg:justify-start gap-2">
                            <input class="row-select-checkbox rounded w-3.5 h-3.5 accent-primary cursor-pointer" onchange="handleRowCheck(this)" type="checkbox" />
                            <button class="p-1 rounded text-outline hover:text-primary hover:bg-surface-container-high transition-colors" title="Pin to quick launch">
                                <span class="material-symbols-outlined text-[18px]">push_pin</span>
                            </button>
                        </div>
                        <div class="col-span-4 flex flex-col gap-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-code-md text-code-md font-bold text-on-surface hover:text-primary cursor-pointer">
                                    customer_support_sentiment_embeddings.arrow
                                </span>
                                <span class="px-1.5 py-0.2 rounded bg-secondary-container/60 text-on-secondary-container font-code-sm text-code-sm font-semibold">
                                    TENSOR EXPERIMENT
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="px-1.5 py-0.2 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                    NLP 768-D EMBEDDINGS
                                </span>
                                <span class="px-1.5 py-0.2 rounded bg-surface-container-low text-on-surface-variant font-code-sm text-code-sm">
                                    BERT-TOKENIZED
                                </span>
                                <span class="px-1.5 py-0.2 rounded bg-surface-container-low text-on-surface-variant font-code-sm text-code-sm">
                                    CADET EXPERIMENT
                                </span>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col justify-center">
                            <div class="flex items-center gap-1 font-code-sm text-code-sm text-on-surface font-semibold">
                                <span class="material-symbols-outlined text-[14px] text-outline">scatter_plot</span>
                                <span>64,520 Rows</span>
                            </div>
                            <div class="font-code-sm text-code-sm text-on-surface-variant">
                                768 Dimensions • <span class="text-primary font-semibold">184.0 MB</span>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col justify-center">
                            <div class="flex items-center justify-between mb-0.5">
                                <span class="font-label-sm text-label-sm text-on-surface">PII Redaction</span>
                                <span class="font-code-sm text-code-sm text-[#10B981] font-bold">100% Masked</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-surface-container-high overflow-hidden">
                                <div class="h-full bg-[#10B981] rounded-full" style="width: 100%"></div>
                            </div>
                            <span class="font-code-sm text-code-sm text-outline mt-0.5">Regex + NER Sanitized</span>
                        </div>
                        <div class="col-span-1 flex flex-col justify-center">
                            <span class="font-code-sm text-code-sm text-on-surface font-medium">3d ago</span>
                            <span class="font-code-sm text-code-sm text-outline">K. Chen</span>
                        </div>
                        <div class="col-span-2 flex items-center justify-start lg:justify-end gap-1.5">
                            <button class="px-2 py-1 rounded bg-surface-container-high text-primary hover:bg-primary-container hover:text-on-primary transition-colors font-label-sm text-label-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">terminal</span>
                                <span>Query SQL</span>
                            </button>
                            <button class="px-2 py-1 rounded bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-sm text-label-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">troubleshoot</span>
                                <span>Inspect</span>
                            </button>
                            <button class="p-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[16px]">more_vert</span>
                            </button>
                        </div>
                    </div>
                    <!-- DATASET 5: Avionics / Flight Telemetry -->
                    <div class="dataset-item-target dataset-row-item grid grid-cols-1 lg:grid-cols-12 gap-3 p-3 rounded bg-surface-container-lowest shadow-sm hover:shadow-md transition-all items-center" data-pinned="false" data-search-index="flight_telemetry_subsampled_test.parquet arinc-429 draft vibration sensors" data-type="draft">
                        <div class="col-span-1 flex items-center justify-between lg:justify-start gap-2">
                            <input class="row-select-checkbox rounded w-3.5 h-3.5 accent-primary cursor-pointer" onchange="handleRowCheck(this)" type="checkbox" />
                            <button class="p-1 rounded text-outline hover:text-primary hover:bg-surface-container-high transition-colors" title="Pin to quick launch">
                                <span class="material-symbols-outlined text-[18px]">push_pin</span>
                            </button>
                        </div>
                        <div class="col-span-4 flex flex-col gap-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-code-md text-code-md font-bold text-on-surface hover:text-primary cursor-pointer">
                                    flight_telemetry_subsampled_test.parquet
                                </span>
                                <span class="px-1.5 py-0.2 rounded bg-surface-container-high text-outline font-code-sm text-code-sm">
                                    TEST HARNESS
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="px-1.5 py-0.2 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                    ARINC-429 DRAFT
                                </span>
                                <span class="px-1.5 py-0.2 rounded bg-surface-container-low text-on-surface-variant font-code-sm text-code-sm">
                                    VIBRATION SENSORS
                                </span>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col justify-center">
                            <div class="flex items-center gap-1 font-code-sm text-code-sm text-on-surface font-semibold">
                                <span class="material-symbols-outlined text-[14px] text-outline">speed</span>
                                <span>85,000 Rows</span>
                            </div>
                            <div class="font-code-sm text-code-sm text-on-surface-variant">
                                12 Features • <span class="text-primary font-semibold">3.20 MB</span>
                            </div>
                        </div>
                        <div class="col-span-2 flex flex-col justify-center">
                            <div class="flex items-center justify-between mb-0.5">
                                <span class="font-label-sm text-label-sm text-on-surface">Data Integrity</span>
                                <span class="font-code-sm text-code-sm text-on-surface font-bold">Nominal</span>
                            </div>
                            <div class="w-full h-1.5 rounded-full bg-surface-container-high overflow-hidden">
                                <div class="h-full bg-primary-container rounded-full" style="width: 98%"></div>
                            </div>
                            <span class="font-code-sm text-code-sm text-outline mt-0.5">Calibration locked</span>
                        </div>
                        <div class="col-span-1 flex flex-col justify-center">
                            <span class="font-code-sm text-code-sm text-on-surface font-medium">5d ago</span>
                            <span class="font-code-sm text-code-sm text-outline">K. Chen</span>
                        </div>
                        <div class="col-span-2 flex items-center justify-start lg:justify-end gap-1.5">
                            <button class="px-2 py-1 rounded bg-surface-container-high text-primary hover:bg-primary-container hover:text-on-primary transition-colors font-label-sm text-label-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">terminal</span>
                                <span>Query SQL</span>
                            </button>
                            <button class="px-2 py-1 rounded bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-sm text-label-sm flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">troubleshoot</span>
                                <span>Inspect</span>
                            </button>
                            <button class="p-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[16px]">more_vert</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- SECTION 4B: ALTERNATIVE GRID CARD VIEW (Toggleable) -->
                <div class="hidden grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3" id="dataset-grid-container">
                    <!-- Grid Card 1 -->
                    <div class="dataset-item-target flex flex-col justify-between p-4 rounded bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow relative overflow-hidden" data-search-index="telecom_customer_churn_v2_engineered.parquet VP-TCK-1049">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-primary-container"></div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-2 py-0.5 rounded bg-tertiary-fixed text-tertiary font-code-sm text-code-sm font-semibold">TICKET #VP-TCK-1049</span>
                                <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings: 'FILL' 1;">push_pin</span>
                            </div>
                            <h3 class="font-code-md text-code-md font-bold text-primary break-all mb-1">telecom_customer_churn_v2_engineered.parquet</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mb-3">Staged for XGBoost Training iteration #4. Includes 4 engineered interaction factors.</p>
                            <div class="grid grid-cols-2 gap-2 p-2 rounded bg-surface-container-low mb-3 font-code-sm text-code-sm">
                                <div><span class="text-outline">ROWS:</span> <strong class="text-on-surface">142,800</strong></div>
                                <div><span class="text-outline">FEATS:</span> <strong class="text-on-surface">32 cols</strong></div>
                                <div><span class="text-outline">SIZE:</span> <strong class="text-primary">5.12 MB</strong></div>
                                <div><span class="text-outline">HEALTH:</span> <strong class="text-[#10B981]">99.4%</strong></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-surface-container-high">
                            <span class="font-code-sm text-code-sm text-outline">Updated 12m ago</span>
                            <button class="px-3 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm hover:bg-primary">Open in Query</button>
                        </div>
                    </div>
                    <!-- Grid Card 2 -->
                    <div class="dataset-item-target flex flex-col justify-between p-4 rounded bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow relative overflow-hidden" data-search-index="network_outage_anomalies_filtered.arrow VP-TCK-1052">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-primary-container"></div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-2 py-0.5 rounded bg-tertiary-fixed text-tertiary font-code-sm text-code-sm font-semibold">TICKET #VP-TCK-1052</span>
                                <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings: 'FILL' 1;">push_pin</span>
                            </div>
                            <h3 class="font-code-md text-code-md font-bold text-on-surface break-all mb-1">network_outage_anomalies_filtered.arrow</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mb-3">Geographic routing partition stream for anomaly identification range.</p>
                            <div class="grid grid-cols-2 gap-2 p-2 rounded bg-surface-container-low mb-3 font-code-sm text-code-sm">
                                <div><span class="text-outline">NODES:</span> <strong class="text-on-surface">28,040</strong></div>
                                <div><span class="text-outline">FEATS:</span> <strong class="text-on-surface">16 cols</strong></div>
                                <div><span class="text-outline">SIZE:</span> <strong class="text-primary">14.1 MB</strong></div>
                                <div><span class="text-outline">HEALTH:</span> <strong class="text-[#10B981]">99.0%</strong></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-surface-container-high">
                            <span class="font-code-sm text-code-sm text-outline">Updated 2h ago</span>
                            <button class="px-3 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm hover:bg-primary">Open in Query</button>
                        </div>
                    </div>
                    <!-- Grid Card 3 -->
                    <div class="dataset-item-target flex flex-col justify-between p-4 rounded bg-surface-container-lowest shadow-sm hover:shadow-md transition-shadow relative overflow-hidden" data-search-index="customer_support_sentiment_embeddings.arrow">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-secondary"></div>
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-2 py-0.5 rounded bg-secondary-container/60 text-on-secondary-container font-code-sm text-code-sm font-semibold">EMBEDDING STORE</span>
                                <span class="material-symbols-outlined text-outline text-[18px]">push_pin</span>
                            </div>
                            <h3 class="font-code-md text-code-md font-bold text-on-surface break-all mb-1">customer_support_sentiment_embeddings.arrow</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mb-3">BERT 768-D tokenized personal latent feature vectors for churn sentiment analysis.</p>
                            <div class="grid grid-cols-2 gap-2 p-2 rounded bg-surface-container-low mb-3 font-code-sm text-code-sm">
                                <div><span class="text-outline">ROWS:</span> <strong class="text-on-surface">64,520</strong></div>
                                <div><span class="text-outline">DIMS:</span> <strong class="text-on-surface">768-D</strong></div>
                                <div><span class="text-outline">SIZE:</span> <strong class="text-primary">184.0 MB</strong></div>
                                <div><span class="text-outline">PII:</span> <strong class="text-[#10B981]">MASKED</strong></div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-surface-container-high">
                            <span class="font-code-sm text-code-sm text-outline">Updated 3d ago</span>
                            <button class="px-3 py-1 rounded bg-surface-container-high text-primary font-label-sm text-label-sm hover:bg-primary-container hover:text-on-primary">Open in Query</button>
                        </div>
                    </div>
                </div>
                <!-- SECTION 5: AUXILIARY TOOLBAR & DUCKDB SANDBOX CONSOLE -->
                <section class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- Quick Run DuckDB In-Memory Sandbox Snippet -->
                    <div class="lg:col-span-2 flex flex-col p-4 rounded bg-surface-container-lowest shadow-sm">
                        <div class="flex items-center justify-between pb-2 mb-2 border-b border-surface-container-high">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[18px]">terminal</span>
                                <span class="font-label-sm text-label-sm uppercase font-bold text-primary">DuckDB Sandbox Scratchpad // Direct Parquet Memory Mount</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-primary font-code-sm text-code-sm">DUCKDB v0.10-WASM</span>
                                <button class="px-2 py-0.5 rounded bg-surface-container-low text-on-surface-variant hover:bg-surface-container-high font-label-sm text-label-sm flex items-center gap-1 transition-colors" onclick="copySnippet('duckdb-code-target')">
                                    <span class="material-symbols-outlined text-[13px]">content_copy</span>
                                    <span>Copy Snippet</span>
                                </button>
                            </div>
                        </div>
                        <!-- Monospace Code Terminal -->
                        <div class="rounded bg-surface-container-low p-3 font-code-md text-code-md text-on-surface overflow-x-auto">
                            <div class="space-y-0.5 leading-relaxed" id="duckdb-code-target">
                                <span class="text-secondary font-semibold">-- Fast Cadet Inspection for VP-TCK-1049</span><br />
                                <span class="text-primary font-bold">SELECT</span> customer_id, tenure_months, roaming_to_tenure_ratio, predicted_churn_risk<br />
                                <span class="text-primary font-bold">FROM</span> <span class="text-[#78350F]">'personal_lake/k_chen/telecom_customer_churn_v2_engineered.parquet'</span><br />
                                <span class="text-primary font-bold">WHERE</span> roaming_to_tenure_ratio &gt; 1.45<br />
                                <span class="text-primary font-bold">ORDER BY</span> predicted_churn_risk <span class="text-primary font-bold">DESC LIMIT</span> 10;
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-3 pt-2 text-on-surface-variant font-code-sm text-code-sm">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                                <span>Buffer mounted to personal ramfs (4.2 ms execution latency estimated)</span>
                            </div>
                            <button class="px-3 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm hover:bg-primary transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">play_arrow</span>
                                <span>Execute in Query Console</span>
                            </button>
                        </div>
                    </div>
                    <!-- Right Side: Cadence & System Sync Telemetry Card -->
                    <div class="flex flex-col justify-between p-4 rounded bg-surface-container-lowest shadow-sm">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-label-sm text-label-sm uppercase text-outline">Range Compliance &amp; Sync</span>
                                <span class="px-1.5 py-0.5 rounded bg-[#FDF6F0] text-tertiary-container font-code-sm text-code-sm font-bold">SEC-OK</span>
                            </div>
                            <h4 class="font-headline-sm text-headline-sm text-on-surface mb-1">Alpha Node Replication</h4>
                            <p class="font-body-sm text-body-sm text-on-surface-variant mb-4">
                                All 7 personal dataset checkpoints are backed up to ALPHA-RANGE-02 storage array with cryptographic verification.
                            </p>
                            <div class="space-y-2 mb-4 font-code-sm text-code-sm">
                                <div class="flex justify-between items-center py-1 border-b border-surface-container-high/60">
                                    <span class="text-outline">SHA-256 HASH CHAIN:</span>
                                    <span class="font-bold text-primary font-mono truncate max-w-[140px]">8f4a9b...c1e0</span>
                                </div>
                                <div class="flex justify-between items-center py-1 border-b border-surface-container-high/60">
                                    <span class="text-outline">LOCAL CACHE STATE:</span>
                                    <span class="text-[#10B981] font-bold">SYNCHRONIZED</span>
                                </div>
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-outline">TARGET WORKBENCH:</span>
                                    <span class="text-on-surface font-bold">SYS-AI-03 (XGBoost)</span>
                                </div>
                            </div>
                        </div>
                        <div class="pt-2 border-t border-surface-container-high flex items-center justify-between">
                            <span class="font-code-sm text-code-sm text-outline">PULL FREQUENCY: 60s</span>
                            <button class="px-2.5 py-1 rounded bg-surface-container-high text-primary font-label-sm text-label-sm hover:bg-primary-container hover:text-on-primary transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">sync</span>
                                <span>Force Resync</span>
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <script src="js/main.js"></script>
</body>

</html>