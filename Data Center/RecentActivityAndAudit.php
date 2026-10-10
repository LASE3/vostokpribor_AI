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
                    <div class="hidden lg:flex flex-col text-right"><span class="font-label-md text-label-md text-on-surface">Cadet Eng. K. Chen</span><span class="font-code-sm text-code-sm text-secondary">ID: VP-88204 • L2 CLEARANCE</span></div><button class="relative p-1.5 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-error"></span></button>
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
            <nav class="flex flex-col gap-1" data-active-classes="bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded"><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="dashboard" href="dashboard.php"><span class="material-symbols-outlined text-[18px]">dashboard</span><span class="">Dashboard</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="dataset-catalog" href="DatasetCatalog.php"><span class="material-symbols-outlined text-[18px]">dataset</span><span class="">Dataset Catalog</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="my-datasets" href="MyDataSet.php"><span class="material-symbols-outlined text-[18px]">folder_shared</span><span class="">My Datasets</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="data-profiling-and-quality" href="DataProfilingAndQuality.php"><span class="material-symbols-outlined text-[18px]">troubleshoot</span><span class="">Data Profiling &amp; Quality</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="query-workspace" href="QueryWorkspace.php"><span class="material-symbols-outlined text-[18px]">terminal</span><span class="">Query Workspace</span></a><a class="flex items-center gap-3 px-3 py-2 rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all font-body-md text-body-md" data-path="upload-processed-data" href="UploadProcessedData.php"><span class="material-symbols-outlined text-[18px]">cloud_upload</span><span class="">Upload Processed Data</span></a><a aria-current="page" class="flex items-center gap-3 px-3 py-2 transition-all bg-primary-container text-on-primary font-bold shadow-[0_0_0_1px_#E8C9A0] rounded" data-path="recent-activity-and-audit-logs" href="RecentActivityAndAudit.php"><span class="material-symbols-outlined text-[18px]">history_toggle_off</span><span class="">Recent Activity &amp; Audit</span></a></nav>
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
            <div class="flex flex-col w-full gap-6">
                <!-- Top Breadcrumb & Mission Header Bar -->
                <div class="flex flex-col gap-2">
                    <div class="flex flex-wrap items-center justify-between gap-3 bg-surface-container-lowest px-4 py-2.5 rounded shadow-sm">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded bg-primary-container text-on-primary font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-[14px]">terminal</span>
                            </span>
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">
                                CADET ENG. K. CHEN [VP-88204] / SECURITY CLEARANCE: L2 // SYS-AI-02 AUDIT TRAIL &amp; ACTIVITY LOG
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-[#FDF6F0] text-tertiary font-code-sm text-code-sm">
                                <span class="w-2 h-2 rounded-full bg-[#10B981] animate-pulse"></span>
                                LEDGER: SYNCED TO BLOCK #8,912,404
                            </span>
                            <span class="font-code-sm text-code-sm text-secondary">RANGE::ALPHA-02-NODE</span>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mt-2">
                        <div>
                            <h1 class="font-headline-lg text-headline-lg text-primary tracking-tight">Recent Activity &amp; Audit Log</h1>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-1 max-w-3xl">
                                Immutable chronological ledger of ingest runs, DuckDB queries, schema mutations, and system telemetry across Range nodes.
                            </p>
                        </div>
                        <div class="flex items-center gap-2 self-start md:self-auto">
                            <button class="inline-flex items-center gap-2 px-3 py-1.5 rounded bg-surface-container text-primary font-label-md text-label-md hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-[16px]">file_download</span>
                                Export Audit Ledger (.jsonl)
                            </button>
                            <button class="inline-flex items-center gap-2 px-3 py-1.5 rounded bg-primary-container text-on-primary font-label-md text-label-md hover:opacity-95 shadow-sm transition-opacity">
                                <span class="material-symbols-outlined text-[16px]">verified</span>
                                Verify Chain Integrity
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Executive Telemetry Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Card 1 -->
                    <div class="bg-surface-container-lowest p-4 rounded shadow-sm relative overflow-hidden flex flex-col justify-between">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-[#E8C9A0]"></div>
                        <div class="flex items-start justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Total Audit Events</span>
                            <span class="inline-flex p-1.5 rounded bg-surface-container text-primary">
                                <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                            </span>
                        </div>
                        <div class="mt-3">
                            <div class="font-headline-xl text-headline-xl text-primary font-bold">1,428</div>
                            <div class="flex items-center gap-2 mt-1 font-code-sm text-code-sm text-on-surface-variant">
                                <span class="inline-flex items-center text-primary font-semibold">
                                    <span class="material-symbols-outlined text-[14px]">arrow_upward</span>312
                                </span>
                                <span>Logged last 24h</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 bg-surface-container-low px-2 py-1 rounded flex justify-between items-center text-code-sm">
                            <span class="text-outline">Sync Drift:</span>
                            <span class="font-code-sm text-code-sm text-primary font-bold">0.000 ms</span>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-surface-container-lowest p-4 rounded shadow-sm relative overflow-hidden flex flex-col justify-between">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-primary-container"></div>
                        <div class="flex items-start justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Pipeline Integrity</span>
                            <span class="inline-flex p-1.5 rounded bg-surface-container text-primary">
                                <span class="material-symbols-outlined text-[18px]">shield</span>
                            </span>
                        </div>
                        <div class="mt-3">
                            <div class="font-headline-xl text-headline-xl text-[#10B981] font-bold">99.4%</div>
                            <div class="flex items-center gap-2 mt-1 font-code-sm text-code-sm text-error">
                                <span class="material-symbols-outlined text-[14px]">warning</span>
                                <span>1 quarantined leak detected</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 bg-error-container text-on-error-container px-2 py-1 rounded flex justify-between items-center text-code-sm">
                            <span>Target: Node-03 PII Bin</span>
                            <span class="font-bold">AWAITING REVIEW</span>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-surface-container-lowest p-4 rounded shadow-sm relative overflow-hidden flex flex-col justify-between">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-[#E8C9A0]"></div>
                        <div class="flex items-start justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">DuckDB Query Sessions</span>
                            <span class="inline-flex p-1.5 rounded bg-surface-container text-primary">
                                <span class="material-symbols-outlined text-[18px]">memory</span>
                            </span>
                        </div>
                        <div class="mt-3">
                            <div class="font-headline-xl text-headline-xl text-primary font-bold">86 <span class="text-body-sm font-normal text-outline">Runs</span></div>
                            <div class="flex items-center gap-2 mt-1 font-code-sm text-code-sm text-on-surface-variant">
                                <span class="text-primary font-semibold">Mean: 4.8 ms</span>
                                <span>• 0 B spill baseline</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 bg-surface-container-low px-2 py-1 rounded flex justify-between items-center text-code-sm">
                            <span class="text-outline">Engine Mode:</span>
                            <span class="font-code-sm text-code-sm text-secondary font-bold">WASM V2 + Parquet</span>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="bg-surface-container-lowest p-4 rounded shadow-sm relative overflow-hidden flex flex-col justify-between">
                        <div class="absolute top-0 left-0 right-0 h-1 bg-primary-container"></div>
                        <div class="flex items-start justify-between">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider text-outline">Ledger Consensus</span>
                            <span class="inline-flex p-1.5 rounded bg-surface-container text-primary">
                                <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                            </span>
                        </div>
                        <div class="mt-3">
                            <div class="font-headline-xl text-headline-xl text-primary font-bold">SHA-256</div>
                            <div class="flex items-center gap-1.5 mt-1 font-code-sm text-code-sm text-[#10B981]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10B981]"></span>
                                <span>100% parity with ALPHA-02</span>
                            </div>
                        </div>
                        <div class="mt-3 pt-2 bg-surface-container-low px-2 py-1 rounded flex justify-between items-center text-code-sm">
                            <span class="text-outline">Merkle Root:</span>
                            <span class="font-code-sm text-code-sm text-primary font-mono truncate max-w-[110px]">9b4f2c01..89a</span>
                        </div>
                    </div>
                </div>
                <!-- Filter & Query Control Bar -->
                <div class="bg-surface-container-lowest p-3 rounded shadow-sm flex flex-col gap-3">
                    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
                        <!-- Search Input -->
                        <div class="flex-1 relative">
                            <span class="material-symbols-outlined absolute left-3 top-2 text-outline text-[18px]">search</span>
                            <input class="w-full h-9 pl-9 pr-4 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface placeholder:text-outline focus:outline-none focus:bg-surface-container-lowest transition-all" id="auditFilterInput" placeholder="Filter audit trail by cadet ID, dataset name, query hash, or node..." type="text" />
                        </div>
                        <!-- Time Range & Quick Dropdowns -->
                        <div class="flex flex-wrap items-center gap-2">
                            <div class="flex items-center bg-surface-container-low rounded px-2.5 py-1">
                                <span class="material-symbols-outlined text-outline text-[16px] mr-1.5">schedule</span>
                                <select class="bg-transparent font-code-sm text-code-sm text-on-surface focus:outline-none cursor-pointer">
                                    <option>Last 24 Hours</option>
                                    <option>Last 7 Days</option>
                                    <option>Active Scenario Only [Customer Churn v2.4]</option>
                                    <option>Full Academic Term</option>
                                </select>
                            </div>
                            <div class="flex items-center bg-surface-container-low rounded px-2.5 py-1">
                                <span class="material-symbols-outlined text-outline text-[16px] mr-1.5">dns</span>
                                <select class="bg-transparent font-code-sm text-code-sm text-on-surface focus:outline-none cursor-pointer">
                                    <option>All Range Nodes</option>
                                    <option>NODE::ALPHA-01</option>
                                    <option>NODE::ALPHA-02</option>
                                    <option>NODE::QUARANTINE-03</option>
                                    <option>WASM-LOCAL-01</option>
                                </select>
                            </div>
                            <button class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-surface-container text-on-surface-variant hover:text-primary font-label-sm text-label-sm transition-colors">
                                <span class="material-symbols-outlined text-[16px]">tune</span>
                                Reset Filters
                            </button>
                        </div>
                    </div>
                    <!-- Category Pills Strip -->
                    <div class="flex items-center gap-1.5 overflow-x-auto pt-1" id="filterPillGroup">
                        <button class="px-2.5 py-1 rounded font-label-sm text-label-sm bg-primary-container text-on-primary whitespace-nowrap shadow-sm">
                            All Events (1,428)
                        </button>
                        <button class="px-2.5 py-1 rounded font-label-sm text-label-sm bg-surface-container-low text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap">
                            Data Ingestion (412)
                        </button>
                        <button class="px-2.5 py-1 rounded font-label-sm text-label-sm bg-surface-container-low text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap">
                            DuckDB Query Runs (864)
                        </button>
                        <button class="px-2.5 py-1 rounded font-label-sm text-label-sm bg-surface-container-low text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap">
                            Schema &amp; Contract Drift (98)
                        </button>
                        <button class="px-2.5 py-1 rounded font-label-sm text-label-sm bg-[#FDF6F0] text-tertiary-container hover:opacity-90 transition-opacity whitespace-nowrap font-bold">
                            Security &amp; PII Quarantine (1)
                        </button>
                        <button class="px-2.5 py-1 rounded font-label-sm text-label-sm bg-surface-container-low text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors whitespace-nowrap">
                            Model Pipeline Handoff (53)
                        </button>
                    </div>
                </div>
                <!-- Main Content Grid (Ledger + Telemetry Side Panels) -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
                    <!-- Left Main Ledger Column (8 of 12) -->
                    <div class="xl:col-span-8 flex flex-col gap-4">
                        <div class="flex items-center justify-between bg-surface-container-lowest px-4 py-3 rounded shadow-sm">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[20px]">view_timeline</span>
                                <span class="font-headline-sm text-headline-sm text-primary">Immutable Audit Ledger Stream</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-code-sm text-code-sm text-secondary">Auto-Refresh: 5s</span>
                                <span class="w-2 h-2 rounded-full bg-[#10B981] animate-ping"></span>
                            </div>
                        </div>
                        <!-- Audit Entries List -->
                        <div class="flex flex-col gap-3" id="auditLedgerStream">
                            <!-- Entry 1: Feature Export Handoff -->
                            <div class="bg-surface-container-lowest p-4 rounded shadow-sm flex flex-col gap-3 transition-all hover:bg-surface-bright">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-primary-container text-on-primary">
                                            FEATURE_EXPORT_HANDOFF [SYS-AI-03]
                                        </span>
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">telecom_customer_churn_v2.parquet</span>
                                        <span class="font-code-sm text-code-sm text-outline">• Node: NODE::ALPHA-01</span>
                                    </div>
                                    <div class="flex items-center gap-2 font-code-sm text-code-sm text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                                        <span>10 mins ago [14:22:04 UTC]</span>
                                    </div>
                                </div>
                                <div class="p-3 bg-surface-container-low rounded font-body-md text-body-md text-on-surface">
                                    Exported filtered churn cohort feature view (142,500 rows, 28 feature columns) to <span class="font-semibold text-primary">SYS-AI-03 AI Workbench</span> for XGBoost hyperparameter training pipeline.
                                </div>
                                <div class="flex flex-wrap items-center justify-between gap-2 pt-1">
                                    <div class="flex flex-wrap items-center gap-3 text-code-sm">
                                        <span class="text-on-surface-variant">Actor: <strong class="text-on-surface">Cadet Eng. K. Chen (VP-88204)</strong></span>
                                        <span class="font-code-sm text-code-sm text-outline">Hash: <code class="text-primary font-mono">8f2b7a94...1c88</code></span>
                                        <span class="inline-flex items-center gap-1 text-[#10B981] font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">check_circle</span> VERIFIED OK
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button class="px-2.5 py-1 rounded bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm transition-colors">
                                            Inspect Artifact
                                        </button>
                                        <button class="px-2.5 py-1 rounded bg-surface-container-low hover:bg-surface-container text-on-surface font-label-sm text-label-sm transition-colors">
                                            Download Proof
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Entry 2: PII Quarantine Warning (Highlighted) -->
                            <div class="bg-surface-container-lowest p-4 rounded shadow-sm flex flex-col gap-3 relative overflow-hidden bg-gradient-to-r from-error-container/20 via-surface-container-lowest to-surface-container-lowest">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-error text-on-error font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[12px]">security</span>
                                            PII_QUARANTINE_REJECTED [WARNING]
                                        </span>
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">raw_transcripts_unmasked_scratch.csv</span>
                                        <span class="font-code-sm text-code-sm text-outline">• Node: NODE::QUARANTINE-03</span>
                                    </div>
                                    <div class="flex items-center gap-2 font-code-sm text-code-sm text-error font-semibold">
                                        <span class="material-symbols-outlined text-[14px]">warning</span>
                                        <span>42 mins ago [13:50:18 UTC]</span>
                                    </div>
                                </div>
                                <div class="p-3 bg-error-container/30 rounded font-body-md text-body-md text-on-surface">
                                    Quarantined raw transcript upload on quarantine node #03: <strong class="text-error">unmasked caller MSISDN detected in column 4</strong> (42 phone records violating Data Governance Policy D-09). Ingest pipeline auto-halted.
                                </div>
                                <div class="flex flex-wrap items-center justify-between gap-2 pt-1">
                                    <div class="flex flex-wrap items-center gap-3 text-code-sm">
                                        <span class="text-on-surface-variant">Actor: <strong class="text-on-surface">Automated Pipeline Engine [PII-Scanner-v4]</strong></span>
                                        <span class="font-code-sm text-code-sm text-outline">Hash: <code class="text-primary font-mono">e198a002...3d4f</code></span>
                                        <span class="inline-flex items-center gap-1 text-tertiary-container font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">flag</span> ISOLATED
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button class="px-2.5 py-1 rounded bg-error text-on-error hover:opacity-95 font-label-sm text-label-sm transition-opacity">
                                            Sanitize &amp; Review Diff
                                        </button>
                                        <button class="px-2.5 py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm transition-colors">
                                            View Policy Rule D-09
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Entry 3: DuckDB Query Executed -->
                            <div class="bg-surface-container-lowest p-4 rounded shadow-sm flex flex-col gap-3 transition-all hover:bg-surface-bright">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-primary font-semibold">
                                            DUCKDB_QUERY_EXECUTED
                                        </span>
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">billing_transactions_2024.csv</span>
                                        <span class="font-code-sm text-code-sm text-outline">• Node: WASM-LOCAL-01</span>
                                    </div>
                                    <div class="flex items-center gap-2 font-code-sm text-code-sm text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                                        <span>1 hr 14 mins ago [13:18:22 UTC]</span>
                                    </div>
                                </div>
                                <div class="p-3 bg-surface-container-low rounded font-body-md text-body-md text-on-surface flex flex-col gap-2">
                                    <div>
                                        Executed analytical aggregation on customer monthly revenue distribution:
                                    </div>
                                    <div class="bg-surface-container-lowest p-2 rounded font-code-sm text-code-sm text-primary overflow-x-auto">
                                        SELECT plan_tier, count(*), round(avg(monthly_fee), 2) FROM 'billing_transactions_2024.parquet' GROUP BY 1 ORDER BY 2 DESC;
                                    </div>
                                    <div class="text-body-sm text-on-surface-variant flex items-center gap-3">
                                        <span>Rows Scanned: 840,192</span>
                                        <span>• Latency: 3.2 ms</span>
                                        <span>• Memory Used: 18.4 MB</span>
                                    </div>
                                </div>
                                <div class="flex flex-wrap items-center justify-between gap-2 pt-1">
                                    <div class="flex flex-wrap items-center gap-3 text-code-sm">
                                        <span class="text-on-surface-variant">Actor: <strong class="text-on-surface">Cadet Eng. K. Chen (VP-88204)</strong></span>
                                        <span class="font-code-sm text-code-sm text-outline">Hash: <code class="text-primary font-mono">3c09f871...bc41</code></span>
                                        <span class="inline-flex items-center gap-1 text-[#10B981] font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">check_circle</span> VERIFIED OK
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button class="px-2.5 py-1 rounded bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm transition-colors">
                                            Open in Query Terminal
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Entry 4: Ingest Success & Checksum Validation -->
                            <div class="bg-surface-container-lowest p-4 rounded shadow-sm flex flex-col gap-3 transition-all hover:bg-surface-bright">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-[#10B981]/15 text-[#047857] font-semibold">
                                            INGEST_SUCCESS [100% VALIDATED]
                                        </span>
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">telecom_customer_churn_v2.parquet</span>
                                        <span class="font-code-sm text-code-sm text-outline">• Node: NODE::ALPHA-02</span>
                                    </div>
                                    <div class="flex items-center gap-2 font-code-sm text-code-sm text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                                        <span>2 hrs ago [12:30:11 UTC]</span>
                                    </div>
                                </div>
                                <div class="p-3 bg-surface-container-low rounded font-body-md text-body-md text-on-surface">
                                    Ingestion of production batch v2.4 completed. 100% schema alignment verified across 32 categorical and numeric dimensions. Parquet Snappy compression verified.
                                </div>
                                <div class="flex flex-wrap items-center justify-between gap-2 pt-1">
                                    <div class="flex flex-wrap items-center gap-3 text-code-sm">
                                        <span class="text-on-surface-variant">Actor: <strong class="text-on-surface">Automated Pipeline Engine</strong></span>
                                        <span class="font-code-sm text-code-sm text-outline">Hash: <code class="text-primary font-mono">6a7d1883...00ef</code></span>
                                        <span class="inline-flex items-center gap-1 text-[#10B981] font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">check_circle</span> VERIFIED OK
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button class="px-2.5 py-1 rounded bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm transition-colors">
                                            Data Profile Report
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Entry 5: DuckDB Memory Pressure & Spill Simulation -->
                            <div class="bg-surface-container-lowest p-4 rounded shadow-sm flex flex-col gap-3 transition-all hover:bg-surface-bright">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="px-2 py-0.5 rounded font-label-sm text-label-sm bg-[#FDF6F0] text-tertiary-container font-semibold">
                                            MEMORY_SPILL_SIMULATION
                                        </span>
                                        <span class="font-code-sm text-code-sm text-on-surface font-semibold">sys_benchmarks_run_09.parquet</span>
                                        <span class="font-code-sm text-code-sm text-outline">• Node: NODE::ALPHA-01</span>
                                    </div>
                                    <div class="flex items-center gap-2 font-code-sm text-code-sm text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                                        <span>4 hrs ago [10:14:05 UTC]</span>
                                    </div>
                                </div>
                                <div class="p-3 bg-surface-container-low rounded font-body-md text-body-md text-on-surface">
                                    Memory pressure spill simulation triggered via <code class="font-code-sm text-code-sm bg-surface-container px-1 py-0.5 rounded text-primary">PRAGMA max_memory='256MB';</code> 148.6 MB spilled to scratch storage with 100% checksum parity. Range node remained stable.
                                </div>
                                <div class="flex flex-wrap items-center justify-between gap-2 pt-1">
                                    <div class="flex flex-wrap items-center gap-3 text-code-sm">
                                        <span class="text-on-surface-variant">Actor: <strong class="text-on-surface">Range Benchmark Daemon</strong></span>
                                        <span class="font-code-sm text-code-sm text-outline">Hash: <code class="text-primary font-mono">22d5610a...94a1</code></span>
                                        <span class="inline-flex items-center gap-1 text-[#10B981] font-semibold">
                                            <span class="material-symbols-outlined text-[14px]">check_circle</span> VERIFIED OK
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button class="px-2.5 py-1 rounded bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm transition-colors">
                                            View Spill Graph
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pagination / Ledger Stream Footnote -->
                        <div class="flex items-center justify-between bg-surface-container-lowest px-4 py-2.5 rounded shadow-sm text-body-sm text-on-surface-variant">
                            <span>Showing 5 of 1,428 Ledger Events (Page 1 of 286)</span>
                            <div class="flex items-center gap-1">
                                <button class="px-2 py-1 rounded bg-surface-container text-primary disabled:opacity-50 font-label-sm text-label-sm" disabled="">Previous</button>
                                <button class="px-2.5 py-1 rounded bg-primary-container text-on-primary font-label-sm text-label-sm">1</button>
                                <button class="px-2.5 py-1 rounded bg-surface-container-low hover:bg-surface-container text-on-surface font-label-sm text-label-sm">2</button>
                                <button class="px-2.5 py-1 rounded bg-surface-container-low hover:bg-surface-container text-on-surface font-label-sm text-label-sm">3</button>
                                <button class="px-2 py-1 rounded bg-surface-container text-primary font-label-sm text-label-sm">Next</button>
                            </div>
                        </div>
                    </div>
                    <!-- Right Side Inspection & Telemetry Panel (4 of 12) -->
                    <div class="xl:col-span-4 flex flex-col gap-4">
                        <!-- Security & Quarantine Alert Card -->
                        <div class="bg-surface-container-lowest p-4 rounded shadow-sm flex flex-col gap-3 relative overflow-hidden">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-error text-[20px]">notification_important</span>
                                    <span class="font-headline-sm text-headline-sm text-error">Active Quarantine Bin</span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-error-container text-on-error-container font-label-sm text-label-sm font-bold">1 ACTION REQUIRED</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                An automated compliance sensor intercepted an unmasked dataset payload. Access has been restricted to Node #03 pending audit clearance.
                            </p>
                            <div class="bg-error-container/20 p-3 rounded flex flex-col gap-2">
                                <div class="flex justify-between items-center text-code-sm">
                                    <span class="font-bold text-on-surface">raw_transcripts_unmasked_scratch.csv</span>
                                    <span class="text-error font-semibold">Policy: D-09</span>
                                </div>
                                <div class="text-body-sm text-on-surface-variant">
                                    MSISDN regex match in column index [4] (<code class="text-primary font-mono">customer_contact_num</code>). Cadet authorization required for regex masking script execution.
                                </div>
                                <div class="flex items-center justify-between pt-1">
                                    <span class="text-code-sm text-outline">Detected: 13:50 UTC</span>
                                    <button class="px-2.5 py-1 rounded bg-error text-on-error font-label-sm text-label-sm hover:opacity-90">
                                        Apply Mask &amp; Re-ingest
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Immutable Ledger Status & Node Replication -->
                        <div class="bg-surface-container-lowest p-4 rounded shadow-sm flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[20px]">account_tree</span>
                                    <span class="font-headline-sm text-headline-sm text-primary">Node Consensus &amp; Merkle Parity</span>
                                </div>
                                <span class="px-2 py-0.5 rounded bg-surface-container text-primary font-label-sm text-label-sm font-bold">L2 RANGE</span>
                            </div>
                            <div class="flex flex-col gap-2 bg-surface-container-low p-3 rounded text-code-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-outline">Consensus Protocol:</span>
                                    <span class="text-on-surface font-semibold">RAFT + Cryptographic Merkle</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-outline">Active Ledger Height:</span>
                                    <span class="text-primary font-bold">Block #8,912,404</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-outline">Snapshot Epoch:</span>
                                    <span class="text-on-surface font-semibold">Every 15 min (Auto)</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-outline">Consensus Quorum:</span>
                                    <span class="text-[#10B981] font-semibold">3 / 3 Nodes Active</span>
                                </div>
                            </div>
                            <!-- Node Status Rows -->
                            <div class="flex flex-col gap-2 pt-1">
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-low text-code-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                                        <span class="font-semibold text-on-surface">NODE::ALPHA-01 (Primary)</span>
                                    </div>
                                    <span class="text-primary font-mono text-[11px]">8f2b7a94..</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-low text-code-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                                        <span class="font-semibold text-on-surface">NODE::ALPHA-02 (Telemetry)</span>
                                    </div>
                                    <span class="text-primary font-mono text-[11px]">8f2b7a94..</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded bg-surface-container-low text-code-sm">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                        <span class="font-semibold text-on-surface">NODE::QUARANTINE-03</span>
                                    </div>
                                    <span class="text-secondary font-mono text-[11px]">e198a002..</span>
                                </div>
                            </div>
                            <!-- Visual Mini Merkle Tree Representation -->
                            <div class="p-3 bg-surface-container-low rounded flex flex-col gap-2">
                                <span class="font-label-sm text-label-sm uppercase text-outline">Cryptographic Integrity Graph</span>
                                <div class="flex items-center justify-center py-2">
                                    <svg class="w-full max-w-[240px] h-14 text-primary" fill="none" viewbox="0 0 240 56" xmlns="http://www.w3.org/2000/svg">
                                        <!-- Top Root -->
                                        <rect fill="currentColor" height="16" opacity="0.9" rx="2" width="50" x="95" y="2"></rect>
                                        <!-- Branch Lines -->
                                        <path d="M120 18 L60 36 M120 18 L180 36" stroke="currentColor" stroke-dasharray="2 2" stroke-width="1.5"></path>
                                        <!-- Bottom Leaves -->
                                        <rect fill="currentColor" height="16" opacity="0.6" rx="2" width="50" x="35" y="36"></rect>
                                        <rect fill="currentColor" height="16" opacity="0.6" rx="2" width="50" x="155" y="36"></rect>
                                    </svg>
                                </div>
                                <div class="flex justify-between items-center text-label-sm text-outline">
                                    <span>Root Parity: 100%</span>
                                    <span class="text-[#10B981] font-bold">MATCH CONFIRMED</span>
                                </div>
                            </div>
                        </div>
                        <!-- Quick Cryptographic Audit Verification Tool -->
                        <div class="bg-surface-container-lowest p-4 rounded shadow-sm flex flex-col gap-3">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-[20px]">policy</span>
                                <span class="font-headline-sm text-headline-sm text-primary">On-Demand Block Verifier</span>
                            </div>
                            <p class="font-body-sm text-body-sm text-on-surface-variant">
                                Validate any entry against local client-side WASM cryptographic proofs:
                            </p>
                            <div class="flex gap-2">
                                <input class="flex-1 h-8 px-3 rounded bg-surface-container-low font-code-sm text-code-sm text-on-surface placeholder:text-outline focus:outline-none" placeholder="Paste SHA-256 event hash..." type="text" />
                                <button class="px-3 py-1 bg-primary text-on-primary rounded font-label-sm text-label-sm hover:opacity-95">
                                    Validate
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