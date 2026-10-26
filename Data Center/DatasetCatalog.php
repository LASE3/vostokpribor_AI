<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

$isStudent = ($currentUser['role'] === 'STUDENT');

if ($isStudent) {
    $datasets = $db->fetchAll("
        SELECT d.*, s.title AS scenario_title 
        FROM datasets d 
        JOIN dataset_assignments da ON d.id = da.dataset_id 
        LEFT JOIN scenarios s ON d.scenario_id = s.id 
        WHERE da.student_id = :sid 
        ORDER BY d.created_at DESC
    ", ['sid' => $currentUser['id']]);
} else {
    $datasets = $db->fetchAll("
        SELECT d.*, s.title AS scenario_title 
        FROM datasets d 
        LEFT JOIN scenarios s ON d.scenario_id = s.id 
        ORDER BY d.created_at DESC
    ");
}

$datasetCount = count($datasets);
$totalSizeBytes = array_sum(array_column($datasets, 'file_size'));
$totalSizeMB = round($totalSizeBytes / (1024 * 1024), 2);
$totalRows = array_sum(array_column($datasets, 'row_count'));
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
            <nav class="flex flex-col gap-1" data-active-classes="bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded"><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="dashboard" href="dashboard.php"><span class="material-symbols-outlined text-[18px]">dashboard</span><span>Dashboard</span></a><a aria-current="page" class="flex items-center gap-3 px-3 py-2 transition-all bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded" data-path="dataset-catalog" href="DatasetCatalog.php"><span class="material-symbols-outlined text-[18px]">dataset</span><span>Dataset Catalog</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="my-datasets" href="MyDataSet.php"><span class="material-symbols-outlined text-[18px]">folder_shared</span><span>My Datasets</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="data-profiling-and-quality" href="DataProfilingAndQuality.php"><span class="material-symbols-outlined text-[18px]">troubleshoot</span><span>Data Profiling & Quality</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="query-workspace" href="QueryWorkspace.php"><span class="material-symbols-outlined text-[18px]">terminal</span><span>Query Workspace</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="upload-processed-data" href="UploadProcessedData.php"><span class="material-symbols-outlined text-[18px]">cloud_upload</span><span>Upload Processed Data</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="recent-activity-and-audit-logs" href="RecentActivityAndAudit.php"><span class="material-symbols-outlined text-[18px]">history_toggle_off</span><span>Recent Activity & Audit</span></a></nav>
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
                <!-- Command Telemetry Strip & Quick Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6">
                    <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-label-sm text-label-sm text-outline uppercase">Active Inventory</span>
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-surface-container text-primary font-code-sm text-code-sm">SYS-02-SYNC</span>
                        </div>
                        <div class="flex items-baseline justify-between">
                            <span class="font-headline-lg text-headline-lg text-primary"><?= $datasetCount ?> Datasets</span>
                            <span class="font-code-sm text-code-sm text-secondary"><?= $totalSizeMB ?> MB Stored</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded-full mt-2 overflow-hidden">
                            <div class="bg-primary-container h-full rounded-full" style="width: 78%"></div>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-label-sm text-label-sm text-outline uppercase">Quality Verification</span>
                            <span class="inline-flex items-center gap-1 font-label-sm text-label-sm text-primary"><span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span>91.4% Index</span>
                        </div>
                        <div class="flex items-baseline justify-between">
                            <span class="font-headline-lg text-headline-lg text-on-surface">36 Certified</span>
                            <span class="font-code-sm text-code-sm text-error">4 Flags • 2 Drift</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded-full mt-2 overflow-hidden">
                            <div class="bg-[#10B981] h-full rounded-full" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-label-sm text-label-sm text-outline uppercase">Range Target Lock</span>
                            <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-tertiary-container font-label-sm text-label-sm">VP-TCK-1049</span>
                        </div>
                        <div class="flex items-baseline justify-between">
                            <span class="font-headline-lg text-headline-lg text-tertiary-container truncate">Customer Churn</span>
                            <span class="font-code-sm text-code-sm text-primary font-bold">142.5k Rows</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded-full mt-2 overflow-hidden">
                            <div class="bg-tertiary-container h-full rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="bg-surface-container-lowest p-3.5 rounded shadow-sm flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-label-sm text-label-sm text-outline uppercase">Storage Protocol</span>
                            <span class="font-code-sm text-code-sm text-outline">L2 S3/CEPH CLUSTER</span>
                        </div>
                        <div class="flex items-baseline justify-between">
                            <span class="font-headline-lg text-headline-lg text-primary">Apache Iceberg</span>
                            <span class="font-code-sm text-code-sm text-[#10B981]">Snappy ZSTD Active</span>
                        </div>
                        <div class="w-full bg-surface-container-high h-1 rounded-full mt-2 overflow-hidden">
                            <div class="bg-secondary-container h-full rounded-full" style="width: 64%"></div>
                        </div>
                    </div>
                </div>
                <!-- Primary Discovery & Operational Control Filter Bar -->
                <div class="bg-surface-container-lowest p-4 rounded shadow-sm mb-4">
                    <div class="flex flex-col lg:flex-row gap-3 items-stretch lg:items-center justify-between mb-3.5">
                        <!-- Search Input with Schema Autocomplete Trigger -->
                        <div class="relative flex-1">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-outline text-[20px]">filter_alt</span>
                            <input class="w-full h-10 pl-10 pr-24 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest shadow-sm" id="catalog-search" placeholder="Filter by dataset ID (DS-*), column names, target tensor, or schema metadata (e.g., 'tenure', 'fraud_flag')..." type="text" value="" />
                            <div class="absolute right-2 top-2 flex items-center gap-1">
                                <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-outline font-label-sm text-label-sm">⌘K</span>
                                <button class="text-primary hover:text-on-primary-fixed p-1 rounded transition-colors" onclick="document.getElementById('catalog-search').value=''" title="Clear Search">
                                    <span class="material-symbols-outlined text-[16px]">close</span>
                                </button>
                            </div>
                        </div>
                        <!-- Quick Action Controls & View Mode -->
                        <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                            <div class="flex items-center bg-surface-container-low p-0.5 rounded">
                                <button class="flex items-center gap-1.5 px-3 py-1.5 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm transition-all">
                                    <span class="material-symbols-outlined text-[16px]">table_rows</span>
                                    <span>Table Grid</span>
                                </button>
                                <button class="flex items-center gap-1.5 px-3 py-1.5 rounded text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm transition-all">
                                    <span class="material-symbols-outlined text-[16px]">grid_view</span>
                                    <span>Dense Cards</span>
                                </button>
                            </div>
                            <button class="flex items-center gap-1.5 px-3.5 py-2 rounded bg-surface-container text-primary font-label-sm text-label-sm hover:bg-surface-container-high transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">upload_file</span>
                                <span>Register Dataset</span>
                            </button>
                            <button class="flex items-center gap-1.5 px-3.5 py-2 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm hover:opacity-95 transition-all">
                                <span class="material-symbols-outlined text-[16px]">refresh</span>
                                <span>Sync Schema Registry</span>
                            </button>
                        </div>
                    </div>
                    <!-- Parameterized Tactical Filters -->
                    <div class="flex flex-wrap lg:flex-nowrap items-center gap-3 pt-3">
                        <!-- Scenario Filter Select -->
                        <div class="flex items-center gap-2">
                            <span class="font-label-sm text-label-sm text-outline uppercase whitespace-nowrap">Scenario:</span>
                            <select class="h-8 px-2.5 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface focus:outline-none focus:bg-surface-container-lowest cursor-pointer shadow-sm">
                                <option selected="">All 7 Range Scenarios</option>
                                <option>Predictive AI: Customer Churn (VP-TCK-1049)</option>
                                <option>Financial Risk: Synthetic Fraud Detection</option>
                                <option>Edge Vision: Optical Manufacturing Defect</option>
                                <option>NLP Transcripts: Multilingual Customer Complaint</option>
                                <option>Enterprise RAG: Flight Manuals & Operational SOP</option>
                                <option>Multi-Agent: Autonomous Support Dialogues</option>
                                <option>SecOps Telemetry: AI SOC Flight Incident</option>
                            </select>
                        </div>
                        <!-- Department Filter -->
                        <div class="flex items-center gap-2">
                            <span class="font-label-sm text-label-sm text-outline uppercase whitespace-nowrap">Division:</span>
                            <select class="h-8 px-2.5 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface focus:outline-none focus:bg-surface-container-lowest cursor-pointer shadow-sm">
                                <option selected="">All Departments</option>
                                <option>Avionics Engineering</option>
                                <option>Commercial Operations</option>
                                <option>Flight Ops & Safety</option>
                                <option>Quality Control & Optics</option>
                                <option>HR & Corporate Policy</option>
                            </select>
                        </div>
                        <!-- Quality Filter -->
                        <div class="flex items-center gap-2">
                            <span class="font-label-sm text-label-sm text-outline uppercase whitespace-nowrap">Quality:</span>
                            <select class="h-8 px-2.5 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface focus:outline-none focus:bg-surface-container-lowest cursor-pointer shadow-sm">
                                <option selected="">All Health Statuses</option>
                                <option>Fully Verified (Passed >95%)</option>
                                <option>Warnings Present (Schema / Drift)</option>
                                <option>Unprofiled / Quarantine</option>
                            </select>
                        </div>
                        <!-- Format Filter Pills -->
                        <div class="flex items-center gap-1.5 overflow-x-auto ml-auto pl-2">
                            <span class="font-label-sm text-label-sm text-outline uppercase mr-1 whitespace-nowrap">Format:</span>
                            <button class="px-2.5 py-1 rounded bg-primary-container text-on-primary font-code-sm text-code-sm font-semibold">ALL</button>
                            <button class="px-2 py-1 rounded bg-surface-container-low hover:bg-surface-container text-on-surface-variant font-code-sm text-code-sm transition-colors">PARQUET</button>
                            <button class="px-2 py-1 rounded bg-surface-container-low hover:bg-surface-container text-on-surface-variant font-code-sm text-code-sm transition-colors">CSV</button>
                            <button class="px-2 py-1 rounded bg-surface-container-low hover:bg-surface-container text-on-surface-variant font-code-sm text-code-sm transition-colors">JSON</button>
                            <button class="px-2 py-1 rounded bg-surface-container-low hover:bg-surface-container text-on-surface-variant font-code-sm text-code-sm transition-colors">PDF/TEXT</button>
                        </div>
                    </div>
                </div>
                <!-- Main High-Density Catalog Table Section -->
                <div class="bg-surface-container-lowest rounded shadow-sm overflow-hidden mb-4">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-surface-container-high text-primary font-label-sm text-label-sm uppercase tracking-wider select-none">
                                    <th class="py-3 px-4 font-semibold w-1/4">
                                        <div class="flex items-center gap-1.5 cursor-pointer hover:text-on-primary-container">
                                            <span>Dataset ID & Entity Descriptor</span>
                                            <span class="material-symbols-outlined text-[14px]">arrow_downward</span>
                                        </div>
                                    </th>
                                    <th class="py-3 px-3 font-semibold w-1/5">Business Intent & Profile</th>
                                    <th class="py-3 px-3 font-semibold">Department & Authority</th>
                                    <th class="py-3 px-3 font-semibold">Format & Volume</th>
                                    <th class="py-3 px-3 font-semibold">Associated Scenario</th>
                                    <th class="py-3 px-3 font-semibold text-center">Quality Index</th>
                                    <th class="py-3 px-3 font-semibold">Version & Timestamp</th>
                                    <th class="py-3 px-4 font-semibold text-right">Operational Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-container-high">
                                <!-- Row 1: Active Target (Customer Churn) -->
                                <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-code-md text-code-md text-primary font-bold">DS-AV-042</span>
                                                <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-tertiary-container font-label-sm text-label-sm shadow-sm">
                                                    VP-TCK-1049 [ACTIVE]
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-primary text-[15px]">description</span>
                                                <span class="font-code-md text-code-md text-on-surface font-semibold">telecom_customer_churn_v2.parquet</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-sm text-label-sm text-outline">SHA256: 4b29f...8a1</span>
                                                <span class="w-1 h-1 rounded-full bg-outline"></span>
                                                <span class="font-code-sm text-code-sm text-secondary">Snappy Encoded</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <p class="font-body-md text-body-md text-on-surface line-clamp-2">
                                            Customer demographic profile, monthly billing telemetry, support dispatch counts, and survival duration for binary churn hazard modeling.
                                        </p>
                                        <span class="font-code-sm text-code-sm text-primary font-medium mt-0.5 block">Target: Churn_Flag (1=True)</span>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md text-on-surface font-semibold">Commercial Operations</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Dr. M. Sorokin (L3)</span>
                                            <span class="font-label-sm text-label-sm text-outline">TEAM: RETENTION-ENG</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-bold">Parquet (Snappy)</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">142,500 rows × 28 cols</span>
                                            <span class="font-code-sm text-code-sm text-secondary">34.2 MB partition</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-[#FDF6F0] text-tertiary-container font-label-sm text-label-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                                            <span>Customer Churn v2.4</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-code-sm text-code-sm font-bold shadow-sm">
                                                <span class="material-symbols-outlined text-[13px] text-primary">check_circle</span>
                                                96.4% Health
                                            </span>
                                            <span class="font-label-sm text-label-sm text-[#10B981] mt-0.5">0 Missing Criticals</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-semibold">v2.4.0</span>
                                            <span class="font-body-sm text-body-sm text-outline">2 hours ago</span>
                                            <span class="font-label-sm text-label-sm text-primary">By Chen, K.</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex flex-col items-end gap-1.5">
                                            <div class="flex items-center gap-1.5">
                                                <button class="px-2.5 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm hover:opacity-90 transition-opacity">
                                                    Inspect & Preview
                                                </button>
                                                <button class="px-2 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm hover:bg-secondary-fixed transition-colors">
                                                    <span class="material-symbols-outlined text-[14px]">download</span>
                                                </button>
                                            </div>
                                            <a class="font-label-sm text-label-sm text-tertiary hover:underline flex items-center gap-1" href="#">
                                                <span>Open in SYS-AI-03 Workbench</span>
                                                <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 2: Synthetic Fraud Detection -->
                                <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-code-md text-code-md text-primary font-bold">DS-FN-108</span>
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">
                                                    UNASSIGNED
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-outline text-[15px]">table_chart</span>
                                                <span class="font-code-md text-code-md text-on-surface font-semibold">credit_card_fraud_synthetic.csv</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-sm text-label-sm text-outline">SHA256: 7d11e...39c</span>
                                                <span class="w-1 h-1 rounded-full bg-outline"></span>
                                                <span class="font-code-sm text-code-sm text-outline">GZIP Compressed</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <p class="font-body-md text-body-md text-on-surface line-clamp-2">
                                            Synthesized high-frequency transaction stream featuring PCA anonymized coordinates (V1-V28) with injected illicit network topologies.
                                        </p>
                                        <span class="font-code-sm text-code-sm text-error font-medium mt-0.5 block">Alert: Extreme Class Imbalance (0.17%)</span>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md text-on-surface font-semibold">Commercial Operations</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">L. Vance, Lead Risk</span>
                                            <span class="font-label-sm text-label-sm text-outline">TEAM: FIN-DEFENSE</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-bold">CSV (Gzip)</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">1,200,000 rows × 31 cols</span>
                                            <span class="font-code-sm text-code-sm text-secondary">148.8 MB</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                            <span>Fraud Detection v1.8</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-error-container text-on-error-container font-code-sm text-code-sm font-bold">
                                                <span class="material-symbols-outlined text-[13px] text-error">warning</span>
                                                81.2% Warn
                                            </span>
                                            <span class="font-label-sm text-label-sm text-error mt-0.5">Skew > 99.8%</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-semibold">v1.8.2</span>
                                            <span class="font-body-sm text-body-sm text-outline">Yesterday</span>
                                            <span class="font-label-sm text-label-sm text-outline">Automated Pipeline</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex flex-col items-end gap-1.5">
                                            <div class="flex items-center gap-1.5">
                                                <button class="px-2.5 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm hover:opacity-90 transition-opacity">
                                                    Inspect & Preview
                                                </button>
                                                <button class="px-2 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm hover:bg-secondary-fixed transition-colors">
                                                    <span class="material-symbols-outlined text-[14px]">download</span>
                                                </button>
                                            </div>
                                            <a class="font-label-sm text-label-sm text-primary hover:underline flex items-center gap-1" href="#">
                                                <span>Open in SYS-AI-03 Workbench</span>
                                                <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 3: Manufacturing Optical Defects -->
                                <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-code-md text-code-md text-primary font-bold">DS-QC-554</span>
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                                    CERTIFIED L2
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-outline text-[15px]">code_blocks</span>
                                                <span class="font-code-md text-code-md text-on-surface font-semibold">manufacturing_optical_defects_metadata.json</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-sm text-label-sm text-outline">SHA256: 99a02...bb7</span>
                                                <span class="w-1 h-1 rounded-full bg-outline"></span>
                                                <span class="font-code-sm text-code-sm text-secondary">COCO 2.0 Annotations</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <p class="font-body-md text-body-md text-on-surface line-clamp-2">
                                            Multi-spectral machine vision defect bounding polygons, scratch severity, and micro-crack classifications on composite wings.
                                        </p>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant mt-0.5 block">Resolution: 4096×4096 Normalized</span>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md text-on-surface font-semibold">Quality Control & Optics</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Eng. T. Weber</span>
                                            <span class="font-label-sm text-label-sm text-outline">RANGE: NDT-SCAN</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-bold">JSON Lines (COCO)</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">45,000 records × 14 keys</span>
                                            <span class="font-code-sm text-code-sm text-secondary">19.4 MB metadata</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                            <span>Manufacturing Defect</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-code-sm text-code-sm font-bold shadow-sm">
                                                <span class="material-symbols-outlined text-[13px] text-primary">check_circle</span>
                                                98.9% Health
                                            </span>
                                            <span class="font-label-sm text-label-sm text-[#10B981] mt-0.5">Bounding BBoxes Valid</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-semibold">v3.1.0</span>
                                            <span class="font-body-sm text-body-sm text-outline">3 days ago</span>
                                            <span class="font-label-sm text-label-sm text-outline">Weber, T.</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex flex-col items-end gap-1.5">
                                            <div class="flex items-center gap-1.5">
                                                <button class="px-2.5 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm hover:opacity-90 transition-opacity">
                                                    Inspect & Preview
                                                </button>
                                                <button class="px-2 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm hover:bg-secondary-fixed transition-colors">
                                                    <span class="material-symbols-outlined text-[14px]">download</span>
                                                </button>
                                            </div>
                                            <a class="font-label-sm text-label-sm text-primary hover:underline flex items-center gap-1" href="#">
                                                <span>Open in SYS-AI-03 Workbench</span>
                                                <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 4: NLP Complaint Classification -->
                                <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-code-md text-code-md text-primary font-bold">DS-AV-890</span>
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">
                                                    STAGING
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-outline text-[15px]">description</span>
                                                <span class="font-code-md text-code-md text-on-surface font-semibold">complaint_call_transcripts_multilingual.parquet</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-sm text-label-sm text-outline">SHA256: 12f45...9a0</span>
                                                <span class="w-1 h-1 rounded-full bg-outline"></span>
                                                <span class="font-code-sm text-code-sm text-secondary">Tokens: ~12.4M</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <p class="font-body-md text-body-md text-on-surface line-clamp-2">
                                            ASR transcribed support phone inquiries with hierarchical escalation tags, sentiment vectors, and anonymized PII redactions.
                                        </p>
                                        <span class="font-code-sm text-code-sm text-primary font-medium mt-0.5 block">5 Languages: EN, ES, DE, FR, JP</span>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md text-on-surface font-semibold">Commercial Operations</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">S. Gupta, NLP Lead</span>
                                            <span class="font-label-sm text-label-sm text-outline">CORP: CALL-CENTRAL</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-bold">Parquet (Snappy)</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">82,000 rows × 19 cols</span>
                                            <span class="font-code-sm text-code-sm text-secondary">62.1 MB</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                            <span>Complaint NLP</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-code-sm text-code-sm font-bold shadow-sm">
                                                <span class="material-symbols-outlined text-[13px] text-primary">check_circle</span>
                                                94.2% Health
                                            </span>
                                            <span class="font-label-sm text-label-sm text-outline mt-0.5">PII Masked 100%</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-semibold">v1.1.0</span>
                                            <span class="font-body-sm text-body-sm text-outline">5 days ago</span>
                                            <span class="font-label-sm text-label-sm text-outline">Gupta, S.</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex flex-col items-end gap-1.5">
                                            <div class="flex items-center gap-1.5">
                                                <button class="px-2.5 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm hover:opacity-90 transition-opacity">
                                                    Inspect & Preview
                                                </button>
                                                <button class="px-2 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm hover:bg-secondary-fixed transition-colors">
                                                    <span class="material-symbols-outlined text-[14px]">download</span>
                                                </button>
                                            </div>
                                            <a class="font-label-sm text-label-sm text-primary hover:underline flex items-center gap-1" href="#">
                                                <span>Open in SYS-AI-03 Workbench</span>
                                                <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 5: RAG Corpus Flight Manuals -->
                                <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-code-md text-code-md text-primary font-bold">DS-FL-221</span>
                                                <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-tertiary-container font-label-sm text-label-sm shadow-sm">
                                                    RESTRICTED
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-outline text-[15px]">picture_as_pdf</span>
                                                <span class="font-code-md text-code-md text-on-surface font-semibold">enterprise_flight_manuals_rag_corpus.pdf</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-sm text-label-sm text-outline">SHA256: 55e71...ca8</span>
                                                <span class="w-1 h-1 rounded-full bg-outline"></span>
                                                <span class="font-code-sm text-code-sm text-secondary">Chunked (512 Tok)</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <p class="font-body-md text-body-md text-on-surface line-clamp-2">
                                            Civil and military flight ops checklists, emergency decompression SOPs, and cockpit avionics recovery step diagrams.
                                        </p>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant mt-0.5 block">Embedding Dim: 1536 text-embedding-3</span>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md text-on-surface font-semibold">Flight Ops & Safety</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Capt. R. Alvarez</span>
                                            <span class="font-label-sm text-label-sm text-outline">CLEARANCE: LEVEL 3</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-bold">Text Corpus / PDF</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">1,240 documents / 42.1k chunks</span>
                                            <span class="font-code-sm text-code-sm text-secondary">410.5 MB bundle</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                            <span>HR / Ops Knowledge RAG</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-code-sm text-code-sm font-bold shadow-sm">
                                                <span class="material-symbols-outlined text-[13px] text-primary">check_circle</span>
                                                99.1% Health
                                            </span>
                                            <span class="font-label-sm text-label-sm text-[#10B981] mt-0.5">Vector Index Clean</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-semibold">v4.0.0</span>
                                            <span class="font-body-sm text-body-sm text-outline">1 week ago</span>
                                            <span class="font-label-sm text-label-sm text-outline">Alvarez, R.</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex flex-col items-end gap-1.5">
                                            <div class="flex items-center gap-1.5">
                                                <button class="px-2.5 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm hover:opacity-90 transition-opacity">
                                                    Inspect & Preview
                                                </button>
                                                <button class="px-2 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm hover:bg-secondary-fixed transition-colors">
                                                    <span class="material-symbols-outlined text-[14px]">download</span>
                                                </button>
                                            </div>
                                            <a class="font-label-sm text-label-sm text-primary hover:underline flex items-center gap-1" href="#">
                                                <span>Open in SYS-AI-03 Workbench</span>
                                                <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 6: Autonomous Support Dialogues -->
                                <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-code-md text-code-md text-primary font-bold">DS-AG-303</span>
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm">
                                                    AGENT LAB
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-outline text-[15px]">smart_toy</span>
                                                <span class="font-code-md text-code-md text-on-surface font-semibold">autonomous_support_dialogues_v1.json</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-sm text-label-sm text-outline">SHA256: 83cc2...ef1</span>
                                                <span class="w-1 h-1 rounded-full bg-outline"></span>
                                                <span class="font-code-sm text-code-sm text-secondary">Role-Annotated (Tool Calls)</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <p class="font-body-md text-body-md text-on-surface line-clamp-2">
                                            Multi-turn user and synthetic AI agent interaction chains with embedded JSON function dispatch parameters and ground truth success labels.
                                        </p>
                                        <span class="font-code-sm text-code-sm text-on-surface-variant mt-0.5 block">Format: ChatML Dialect</span>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md text-on-surface font-semibold">HR & Corporate Policy</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">E. Park, Agentic AI</span>
                                            <span class="font-label-sm text-label-sm text-outline">DEPT: SYS-AGENTS</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-bold">JSON (ChatML)</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">110,000 turns × 8 nodes</span>
                                            <span class="font-code-sm text-code-sm text-secondary">88.3 MB</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                            <span>Customer Support Agent</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-code-sm text-code-sm font-bold shadow-sm">
                                                <span class="material-symbols-outlined text-[13px] text-primary">check_circle</span>
                                                95.0% Health
                                            </span>
                                            <span class="font-label-sm text-label-sm text-[#10B981] mt-0.5">Syntax Lint Verified</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-semibold">v1.0.4</span>
                                            <span class="font-body-sm text-body-sm text-outline">2 weeks ago</span>
                                            <span class="font-label-sm text-label-sm text-outline">Park, E.</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex flex-col items-end gap-1.5">
                                            <div class="flex items-center gap-1.5">
                                                <button class="px-2.5 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm hover:opacity-90 transition-opacity">
                                                    Inspect & Preview
                                                </button>
                                                <button class="px-2 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm hover:bg-secondary-fixed transition-colors">
                                                    <span class="material-symbols-outlined text-[14px]">download</span>
                                                </button>
                                            </div>
                                            <a class="font-label-sm text-label-sm text-primary hover:underline flex items-center gap-1" href="#">
                                                <span>Open in SYS-AI-03 Workbench</span>
                                                <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 7: AI SOC Incident Flight Telemetry -->
                                <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="font-code-md text-code-md text-primary font-bold">DS-SC-904</span>
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                                    DEFENSE SPEC
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-outline text-[15px]">security</span>
                                                <span class="font-code-md text-code-md text-on-surface font-semibold">telemetry_anomalies_flight_incident_soc.parquet</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-label-sm text-label-sm text-outline">SHA256: 01fa9...7e4</span>
                                                <span class="w-1 h-1 rounded-full bg-outline"></span>
                                                <span class="font-code-sm text-code-sm text-secondary">ZSTD Level 9</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <p class="font-body-md text-body-md text-on-surface line-clamp-2">
                                            High-throughput avionics bus sensor signals (ARINC 429), control surface flutter rates, and simulated hostile EW spoofing signatures.
                                        </p>
                                        <span class="font-code-sm text-code-sm text-primary font-medium mt-0.5 block">Sampling: 100Hz Synchronous</span>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-body-md text-body-md text-on-surface font-semibold">Avionics Engineering</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">Maj. D. Morozov</span>
                                            <span class="font-label-sm text-label-sm text-outline">RANGE: SOC-DEFENSE</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-bold">Parquet (ZSTD)</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">980,000 rows × 52 cols</span>
                                            <span class="font-code-sm text-code-sm text-secondary">218.4 MB</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                                            <span>AI SOC Incident</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="inline-flex flex-col items-center">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-code-sm text-code-sm font-bold shadow-sm">
                                                <span class="material-symbols-outlined text-[13px] text-primary">check_circle</span>
                                                97.8% Health
                                            </span>
                                            <span class="font-label-sm text-label-sm text-[#10B981] mt-0.5">Zero Signal Loss</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="flex flex-col">
                                            <span class="font-code-sm text-code-sm text-on-surface font-semibold">v2.0.1</span>
                                            <span class="font-body-sm text-body-sm text-outline">4 hours ago</span>
                                            <span class="font-label-sm text-label-sm text-outline">Morozov, D.</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex flex-col items-end gap-1.5">
                                            <div class="flex items-center gap-1.5">
                                                <button class="px-2.5 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm hover:opacity-90 transition-opacity">
                                                    Inspect & Preview
                                                </button>
                                                <button class="px-2 py-1 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm hover:bg-secondary-fixed transition-colors">
                                                    <span class="material-symbols-outlined text-[14px]">download</span>
                                                </button>
                                            </div>
                                            <a class="font-label-sm text-label-sm text-primary hover:underline flex items-center gap-1" href="#">
                                                <span>Open in SYS-AI-03 Workbench</span>
                                                <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Interactive Tactical Pagination & Range Buffer Summary -->
                    <div class="bg-surface-container-high px-4 py-3 flex flex-col sm:flex-row items-center justify-between gap-3 text-on-surface">
                        <div class="flex items-center gap-4">
                            <span class="font-code-sm text-code-sm text-on-surface-variant">
                                Showing <span class="font-bold text-on-surface">1 – 7</span> of <span class="font-bold text-on-surface">42</span> indexed entities
                            </span>
                            <div class="flex items-center gap-1.5">
                                <span class="font-label-sm text-label-sm text-outline uppercase">Items / Page:</span>
                                <select class="h-7 px-2 rounded bg-surface-container-lowest font-code-sm text-code-sm text-on-surface focus:outline-none cursor-pointer shadow-sm">
                                    <option>10</option>
                                    <option selected="">25</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <button class="px-2 py-1 rounded bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-code-sm text-code-sm shadow-sm disabled:opacity-40" disabled="">
                                <span class="material-symbols-outlined text-[14px]">first_page</span>
                            </button>
                            <button class="px-2 py-1 rounded bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-code-sm text-code-sm shadow-sm disabled:opacity-40" disabled="">
                                <span class="material-symbols-outlined text-[14px]">chevron_left</span>
                            </button>
                            <button class="px-2.5 py-1 rounded bg-primary-container text-on-primary font-code-sm text-code-sm font-bold shadow-sm">1</button>
                            <button class="px-2.5 py-1 rounded bg-surface-container-lowest text-on-surface hover:bg-surface-container font-code-sm text-code-sm shadow-sm">2</button>
                            <button class="px-2.5 py-1 rounded bg-surface-container-lowest text-on-surface hover:bg-surface-container font-code-sm text-code-sm shadow-sm">3</button>
                            <button class="px-2 py-1 rounded bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-code-sm text-code-sm shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                            </button>
                            <button class="px-2 py-1 rounded bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-code-sm text-code-sm shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">last_page</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Lower Split Panel: Selected Dataset Telemetry & Visual Schema Quick-Inspector -->
                <div class="bg-surface-container-lowest rounded p-5 shadow-sm">
                    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between pb-4 mb-4 gap-3 bg-surface-container-low p-3 rounded">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-primary-container text-on-primary flex items-center justify-center shadow-sm">
                                <span class="material-symbols-outlined text-[24px]">troubleshoot</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-headline-sm text-headline-sm text-on-surface font-bold">Quick Inspector • DS-AV-042</span>
                                    <span class="px-2 py-0.5 rounded bg-tertiary-fixed text-tertiary-container font-label-sm text-label-sm">Active Churn Target Lock</span>
                                </div>
                                <span class="font-code-sm text-code-sm text-secondary">
                                    Cluster URI: <code class="text-primary font-bold">s3://range-datasets/sys-02/telecom_customer_churn_v2.parquet</code>
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="px-3 py-1.5 rounded bg-surface-container text-primary font-label-sm text-label-sm hover:bg-surface-container-high transition-colors shadow-sm">
                                Run Fresh Quality Scan
                            </button>
                            <button class="px-3 py-1.5 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm hover:opacity-90">
                                Load Head(100) Rows
                            </button>
                        </div>
                    </div>
                    <!-- Inspector Tabs & Distribution Visualizations -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                        <!-- Column Distributions & Null Rates -->
                        <div class="lg:col-span-2 bg-surface-container-low p-4 rounded">
                            <div class="flex items-center justify-between mb-3">
                                <span class="font-label-sm text-label-sm text-outline uppercase">Schema Profile & Nullity (Top 6 Columns)</span>
                                <span class="font-code-sm text-code-sm text-primary">28 Total Attributes</span>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">customer_id (string, primary_key)</span>
                                        <span class="font-code-sm text-code-sm text-[#10B981]">0.0% Null • 100% Unique</span>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden flex">
                                        <div class="bg-primary-container h-full" style="width: 100%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">tenure_months (int32)</span>
                                        <span class="font-code-sm text-code-sm text-[#10B981]">0.0% Null • Mean: 32.4 • Std: 24.5</span>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden flex">
                                        <div class="bg-primary h-full" style="width: 100%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">monthly_charges (float64)</span>
                                        <span class="font-code-sm text-code-sm text-[#10B981]">0.0% Null • Range: $18.25 - $118.75</span>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden flex">
                                        <div class="bg-secondary-container h-full" style="width: 100%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">total_charges (float64)</span>
                                        <span class="font-code-sm text-code-sm text-error">0.08% Null (11 rows empty string converted)</span>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden flex">
                                        <div class="bg-primary-container h-full" style="width: 99.92%"></div>
                                        <div class="bg-error h-full" style="width: 0.08%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">support_tickets_count (int16)</span>
                                        <span class="font-code-sm text-code-sm text-[#10B981]">0.0% Null • Poisson λ=1.4</span>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden flex">
                                        <div class="bg-primary h-full" style="width: 100%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-code-sm text-code-sm text-on-surface font-bold text-tertiary">churn_flag [TARGET] (binary)</span>
                                        <span class="font-code-sm text-code-sm text-tertiary">26.5% Positive (Class Balance 1:3.7)</span>
                                    </div>
                                    <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden flex">
                                        <div class="bg-tertiary-container h-full" style="width: 26.5%"></div>
                                        <div class="bg-surface-dim h-full" style="width: 73.5%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Compliance, Lineage & Downstream Integration Status -->
                        <div class="bg-surface-container-low p-4 rounded flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="font-label-sm text-label-sm text-outline uppercase">Downstream Range Target</span>
                                    <span class="px-1.5 py-0.5 rounded bg-tertiary-fixed text-tertiary-container font-label-sm text-label-sm">READY</span>
                                </div>
                                <div class="bg-surface-container-lowest p-3 rounded mb-3 shadow-sm">
                                    <span class="font-label-sm text-label-sm text-outline uppercase">Active Consumer Module</span>
                                    <p class="font-body-md text-body-md text-on-surface font-semibold mt-0.5">
                                        SYS-AI-03: AI Workbench (Notebook #NB-CHURN-09)
                                    </p>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                                        Model target: LightGBM Gradient Booster + SHAP Interpretability explainers.
                                    </p>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-body-sm">
                                        <span class="text-on-surface-variant">Data Governance Status:</span>
                                        <span class="font-code-sm text-code-sm text-[#10B981] font-bold">APPROVED (SOC2/GDPR)</span>
                                    </div>
                                    <div class="flex items-center justify-between text-body-sm">
                                        <span class="text-on-surface-variant">Feature Store Registration:</span>
                                        <span class="font-code-sm text-code-sm text-primary font-bold">FEAST-VP // CHURN_V2</span>
                                    </div>
                                    <div class="flex items-center justify-between text-body-sm">
                                        <span class="text-on-surface-variant">Synthetic Balancing Needed:</span>
                                        <span class="font-code-sm text-code-sm text-tertiary font-bold">SMOTE recommended</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-3">
                                <button class="w-full py-2 px-3 rounded bg-primary-container text-on-primary font-label-sm text-label-sm shadow-sm flex items-center justify-center gap-2 hover:opacity-95 transition-all">
                                    <span class="material-symbols-outlined text-[16px]">rocket_launch</span>
                                    <span>Push Partition to Range AI Workbench</span>
                                </button>
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