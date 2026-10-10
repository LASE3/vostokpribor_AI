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
                        <!-- Drag & Drop Tactical Frame -->
                        <div class="relative group cursor-pointer flex flex-col items-center justify-center p-8 rounded-lg bg-surface-container-low transition-all duration-200 shadow-inner hover:bg-surface-container" id="dropzone-box">
                            <!-- Technical Corner Accents -->
                            <span class="absolute top-2 left-2 font-code-sm text-[10px] text-outline opacity-60">INGEST_PORT::SEC-443</span>
                            <span class="absolute top-2 right-2 font-code-sm text-[10px] text-outline opacity-60">ENC::CHACHA20-POLY1305</span>
                            <span class="absolute bottom-2 left-2 font-code-sm text-[10px] text-outline opacity-60">DUCKDB_PARSER_READY</span>
                            <span class="absolute bottom-2 right-2 font-code-sm text-[10px] text-outline opacity-60">NODE::ALPHA-01</span>
                            <div class="w-14 h-14 rounded-full bg-surface-container-lowest shadow-md flex items-center justify-center text-primary-container mb-3 group-hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-[30px]">drive_folder_upload</span>
                            </div>
                            <p class="font-headline-sm text-headline-sm text-on-surface text-center mb-1">
                                Drop Processed Datasets or Mount Direct Lake Artifact
                            </p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant text-center max-w-md mb-4">
                                Direct ingestion parses zero-copy schemas into the Alpha In-Memory cache. Automatic quarantine triggered on schema drift or unmasked PII.
                            </p>
                            <!-- Supported Formats Badges -->
                            <div class="flex flex-wrap items-center justify-center gap-1.5 mb-5">
                                <span class="px-2 py-0.5 rounded bg-surface-container-lowest font-code-sm text-code-sm text-primary font-bold shadow-sm">.PARQUET (SNAPPY/ZSTD)</span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-lowest font-code-sm text-code-sm text-secondary font-bold shadow-sm">.ARROW / .FEATHER</span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-lowest font-code-sm text-code-sm text-on-surface-variant shadow-sm">.CSV / .TSV (GZIP)</span>
                                <span class="px-2 py-0.5 rounded bg-surface-container-lowest font-code-sm text-code-sm text-on-surface-variant shadow-sm">.JSONL / .NDJSON</span>
                            </div>
                            <!-- Buttons -->
                            <div class="flex flex-wrap items-center gap-3">
                                <button class="px-4 py-2 rounded bg-primary-container hover:bg-primary text-on-primary font-label-md text-label-md uppercase tracking-wider flex items-center gap-2 shadow-sm transition-colors" type="button">
                                    <span class="material-symbols-outlined text-[16px]">file_open</span>
                                    Browse Filesystem
                                </button>
                                <button class="px-4 py-2 rounded bg-surface-container-highest hover:bg-surface-container text-primary font-label-md text-label-md uppercase tracking-wider flex items-center gap-2 shadow-sm transition-colors" type="button">
                                    <span class="material-symbols-outlined text-[16px]">cloud_sync</span>
                                    Mount Lake S3 Bucket
                                </button>
                            </div>
                        </div>
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
                                <!-- Item 1: READY TO REGISTER -->
                                <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                                            <div class="flex flex-col">
                                                <span class="font-code-md text-code-md font-semibold text-on-surface">churn_engineered_features_v3.parquet</span>
                                                <span class="font-code-sm text-code-sm text-outline">SHA256: 8f2b7a94...1c88</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col">
                                            <span class="font-code-md text-code-md text-on-surface">42.8 MB</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">142,500 rows • 64 cols</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-[#FDF6F0] text-tertiary font-code-sm text-code-sm w-fit font-bold">
                                                <span class="material-symbols-outlined text-[13px] text-[#10B981]">check_circle</span>
                                                <span>READY TO REGISTER (100% VALIDATED)</span>
                                            </div>
                                            <span class="font-code-sm text-code-sm text-outline">Null Matrix: 0.00% Drift • PII Cleared</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-secondary font-bold">#VP-TCK-1049</span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <button class="px-2.5 py-1 rounded bg-surface-container-low hover:bg-surface-container text-on-surface font-label-sm text-label-sm uppercase tracking-wider transition-colors">
                                                Inspect Preview
                                            </button>
                                            <button class="px-3 py-1 rounded bg-primary-container hover:bg-primary text-on-primary font-label-sm text-label-sm uppercase tracking-wider flex items-center gap-1 shadow-sm transition-colors">
                                                <span class="material-symbols-outlined text-[14px]">rocket_launch</span>
                                                Push to SYS-AI-03
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Item 2: VALIDATING 78% -->
                                <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-2 h-2 rounded-full bg-[#F59E0B] animate-pulse"></span>
                                            <div class="flex flex-col">
                                                <span class="font-code-md text-code-md font-semibold text-on-surface">billing_imputed_transactions_oct.csv</span>
                                                <span class="font-code-sm text-code-sm text-outline">GZIP Stream • Thread #4</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col">
                                            <span class="font-code-md text-code-md text-on-surface">18.2 MB</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">450,210 rows • 19 cols</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-1 w-64">
                                            <div class="flex justify-between items-center font-code-sm text-code-sm text-primary font-bold">
                                                <span>VALIDATING // DUCKDB PROFILE</span>
                                                <span>78%</span>
                                            </div>
                                            <div class="w-full h-1.5 rounded-full bg-surface-container-high overflow-hidden">
                                                <div class="h-full bg-primary-container rounded-full animate-pulse" style="width: 78%"></div>
                                            </div>
                                            <span class="font-code-sm text-code-sm text-outline">0 Syntax Errors • Profiling Skew...</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-secondary font-bold">#VP-TCK-1049</span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <button class="px-2.5 py-1 rounded bg-surface-container-low text-outline font-label-sm text-label-sm uppercase tracking-wider cursor-not-allowed" disabled="">
                                                Generating Profile...
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Item 3: ARROW MEMORY MOUNTED -->
                                <tr class="hover:bg-surface-container-low transition-colors bg-surface-container-lowest">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-2 h-2 rounded-full bg-[#10B981]"></span>
                                            <div class="flex flex-col">
                                                <span class="font-code-md text-code-md font-semibold text-on-surface">network_telemetry_outages_cleaned.arrow</span>
                                                <span class="font-code-sm text-code-sm text-outline">Zero-Copy RAMFS • Arrow IPC v2</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col">
                                            <span class="font-code-md text-code-md text-on-surface">14.1 MB</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">28,040 rows • 42 cols</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container text-primary font-code-sm text-code-sm w-fit font-bold">
                                                <span class="material-symbols-outlined text-[13px] text-[#10B981]">memory</span>
                                                <span>CHECKSUM VERIFIED // STAGED TO RAMFS</span>
                                            </div>
                                            <span class="font-code-sm text-code-sm text-outline">Zero Memory Leaks • Target Ready</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-secondary font-bold">#VP-TCK-1049</span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <button class="px-3 py-1 rounded bg-surface-container hover:bg-surface-container-high text-primary font-label-sm text-label-sm uppercase tracking-wider flex items-center gap-1 transition-colors">
                                                <span class="material-symbols-outlined text-[14px]">terminal</span>
                                                Mount in Query Workspace
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Item 4: REJECTED // PII LEAK -->
                                <tr class="hover:bg-error-container/20 transition-colors bg-surface-container-lowest">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-2 h-2 rounded-full bg-error"></span>
                                            <div class="flex flex-col">
                                                <span class="font-code-md text-code-md font-semibold text-error">raw_transcripts_unmasked_scratch.csv</span>
                                                <span class="font-code-sm text-code-sm text-error/80">Quarantine Node #03</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col">
                                            <span class="font-code-md text-code-md text-on-surface">8.4 MB</span>
                                            <span class="font-code-sm text-code-sm text-on-surface-variant">12,100 rows</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-error-container text-on-error-container font-code-sm text-code-sm w-fit font-bold">
                                                <span class="material-symbols-outlined text-[13px]">gpp_bad</span>
                                                <span>REJECTED // PII LEAK DETECTED</span>
                                            </div>
                                            <span class="font-code-sm text-code-sm text-error font-medium">Contains unmasked caller MSISDN in col 4</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-0.5 rounded bg-surface-container font-code-sm text-code-sm text-secondary font-bold">#VP-TCK-1049</span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <button class="px-2.5 py-1 rounded bg-error-container text-on-error-container hover:bg-error hover:text-on-error font-label-sm text-label-sm uppercase tracking-wider transition-colors flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[13px]">visibility</span>
                                                View Sanitization Diff
                                            </button>
                                        </div>
                                    </td>
                                </tr>
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