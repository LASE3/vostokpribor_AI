<?php
require_once __DIR__ . '/../config/config.php';
apply_perf_headers();
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="bg-background font-body-md text-on-surface antialiased">
    <aside class="fixed left-0 top-0 h-full w-64 bg-surface-container-lowest z-50 flex flex-col justify-between">
        <div class="flex flex-col">
            <div class="h-16 px-space-md flex items-center gap-space-sm bg-surface-container-low"><a href="../index.php" title="Return to Mission Control" class="hover:opacity-80 transition-opacity"><img alt="VOSTOKPRIBOR AI Emblem" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1WChaZlDzbMhLgB7CKLbcwys8iyFQh4IndCJk_ECktdbqDF1I6VJLCvzXknLTOJatZwGFaSH8h75LujcuaUJIub7LPO63lIx2JSHusDx2OZJE4ceEhZsKs_Wjkv71qOS3i8MI5dF5Y_2NYaiAppSLANo94BzS6OZ9z07ZaUzp9ydLOkjWGjr2LKZ6GaaadAX6ZVzEPGvIw5iP1cBfjrdkDhECDXN5kSy4z3k9K3ktsqz5tzI7ND8lSdL_Y" /></a>
                <div class="flex flex-col"><span class="font-label-md text-label-md tracking-widest text-primary uppercase">VOSTOKPRIBOR</span><span class="font-label-sm text-label-sm text-on-surface-variant">PRECISION TELEMETRY</span></div>
            </div>
            <div class="px-space-md py-space-sm">
                <div class="font-label-sm text-label-sm text-outline uppercase tracking-widest px-space-xs mb-space-xs">Subsystems</div>
                <nav class="flex flex-col gap-space-2xs" data-active-classes="bg-surface-container-high text-on-surface font-semibold"><a class="flex items-center gap-space-sm px-space-sm py-space-xs rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors font-label-lg text-label-lg" data-path="projects" href="../AI Project Management/Dashboard.php"><span class="material-symbols-outlined text-[18px]">folder_supervised</span><span>SYS-AI-01 Projects</span></a><a class="flex items-center gap-space-sm px-space-sm py-space-xs rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors font-label-lg text-label-lg" data-path="data-center" href="../Data Center/DatasetCatalog.php">
                        <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-[18px] text-tertiary">database</span><span>SYS-AI-02 Data Center</span></div><span class="h-2 w-2 rounded-full bg-tertiary animate-pulse"></span>
                    </a><a class="flex items-center gap-space-sm px-space-sm py-space-xs rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors font-label-lg text-label-lg" data-path="workbench" href="../AI/ML Workbench/WorkbenchHome.php"><span class="material-symbols-outlined text-[18px]">terminal</span><span>SYS-AI-03 Workbench</span></a><a class="flex items-center gap-space-sm px-space-sm py-space-xs rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors font-label-lg text-label-lg" data-path="registry-deployment" href="../Model Registry & Deployment/ModelRegistry.php"><span class="material-symbols-outlined text-[18px]">layers</span><span>SYS-AI-04 Registry &amp; Deployment</span></a><a class="flex items-center gap-space-sm px-space-sm py-space-xs rounded text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-colors font-label-lg text-label-lg" data-path="ai-soc" href="../AI Operations Center (AI SOC)/FleetTelemetry.php"><span class="material-symbols-outlined text-[18px]">shield</span><span>SYS-AI-05 AI SOC</span></a></nav>
            </div>
        </div>
        <div class="p-space-md bg-surface-container-low">
            <div class="flex items-center justify-between font-label-sm text-label-sm text-on-surface-variant mb-space-2xs"><span>NODE TELEMETRY</span><span class="text-tertiary">ONLINE</span></div>
            <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                <div class="bg-tertiary h-full w-[84%]"></div>
            </div>
            <div class="flex justify-between items-center mt-space-2xs font-label-sm text-label-sm text-outline"><span>ARRAY CORE</span><span>84% CAP</span></div>
        </div>
    </aside>
    <div class="pl-64">
        <header class="fixed top-0 left-64 right-0 z-40 bg-surface/90 backdrop-blur-md shadow-[0_1px_8px_rgba(0,0,0,0.25)]">
            <div class="h-16 px-space-lg flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md"><a href="../index.php" title="Return to Mission Control" class="hover:opacity-80 transition-opacity"><img alt="VOSTOKPRIBOR AI Emblem" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1WChaZlDzbMhLgB7CKLbcwys8iyFQh4IndCJk_ECktdbqDF1I6VJLCvzXknLTOJatZwGFaSH8h75LujcuaUJIub7LPO63lIx2JSHusDx2OZJE4ceEhZsKs_Wjkv71qOS3i8MI5dF5Y_2NYaiAppSLANo94BzS6OZ9z07ZaUzp9ydLOkjWGjr2LKZ6GaaadAX6ZVzEPGvIw5iP1cBfjrdkDhECDXN5kSy4z3k9K3ktsqz5tzI7ND8lSdL_Y" /></a>
                    <div class="flex items-center gap-space-xs font-label-lg text-label-lg"><span class="text-on-surface-variant">VOSTOKPRIBOR AI</span><span class="text-outline">/</span><span class="text-primary font-semibold">SYS-AI-02 Data Center</span></div>
                    <div class="flex items-center gap-space-xs px-space-sm py-space-2xs rounded bg-surface-container-high"><span class="h-2 w-2 rounded-full bg-tertiary animate-ping"></span><span class="font-label-sm text-label-sm text-on-surface font-mono">#AI-024 Customer Churn</span></div>
                </div>
                <div class="flex-1 max-w-xs">
                    <div class="flex items-center bg-surface-container-low rounded px-space-sm py-space-2xs text-on-surface-variant"><span class="material-symbols-outlined text-[18px] mr-space-xs text-outline">search</span><span class="font-body-sm text-body-sm flex-1 text-outline">Search telemetry, tags, schema...</span><span class="font-label-sm text-label-sm bg-surface-container px-1.5 py-0.5 rounded text-on-surface-variant font-mono">⌘K</span></div>
                </div>
                <div class="flex items-center gap-space-md">
                    <div class="flex items-center bg-surface-container-lowest p-space-2xs rounded-full font-label-sm text-label-sm"><button class="px-space-sm py-0.5 rounded-full bg-primary-container text-on-surface font-semibold">Student</button><button class="px-space-sm py-0.5 text-on-surface-variant hover:text-on-surface transition-colors">Instructor</button></div>
                    <div class="flex items-center bg-surface-container-lowest p-space-2xs rounded font-label-sm text-label-sm"><span class="px-space-xs text-primary font-bold">EN</span><span class="text-outline">|</span><span class="px-space-xs text-on-surface-variant hover:text-on-surface cursor-pointer">AR</span></div><button class="relative p-space-xs rounded bg-surface-container-high text-on-surface hover:text-tertiary transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span><span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-tertiary"></span></button>
                    <div class="flex items-center gap-space-xs px-space-sm py-space-2xs bg-surface-container rounded"><span class="h-2 w-2 rounded-full bg-tertiary"></span>
                        <div class="flex flex-col"><span class="font-label-sm text-label-sm text-on-surface leading-tight">Intern AI Engineer</span><span class="font-label-sm text-label-sm text-on-surface-variant leading-tight">Level 2</span></div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
                </div>
            </div>
            <div class="h-12 px-space-lg bg-surface-container-low flex items-center overflow-x-auto gap-space-xs">
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">01</span><span class="text-outline mr-space-xs">Business Request</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">02</span><span class="text-outline mr-space-xs">Problem Framing</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0 bg-surface-container-high px-space-xs py-1 rounded"><span class="px-space-xs py-0.5 rounded bg-tertiary text-on-tertiary font-bold font-mono">03</span><span class="text-on-surface font-semibold mr-space-xs">Data Discovery</span><span class="text-tertiary font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0 bg-surface-container-high px-space-xs py-1 rounded"><span class="px-space-xs py-0.5 rounded bg-tertiary text-on-tertiary font-bold font-mono">04</span><span class="text-on-surface font-semibold mr-space-xs">Data Extraction</span><span class="text-tertiary font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0 bg-surface-container-high px-space-xs py-1 rounded"><span class="px-space-xs py-0.5 rounded bg-tertiary text-on-tertiary font-bold font-mono">05</span><span class="text-on-surface font-semibold mr-space-xs">Quality &amp; Profiling</span><span class="text-tertiary font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">06</span><span class="text-outline mr-space-xs">Feature Eng.</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">07</span><span class="text-outline mr-space-xs">Model Train</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">08</span><span class="text-outline mr-space-xs">Eval &amp; Validate</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">09</span><span class="text-outline mr-space-xs">Governance</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">10</span><span class="text-outline mr-space-xs">Deployment</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">11</span><span class="text-outline mr-space-xs">Monitoring</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">12</span><span class="text-outline mr-space-xs">Drift Detect</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">13</span><span class="text-outline mr-space-xs">Retrain Loop</span><span class="text-outline-variant font-mono text-[10px]">→</span></div>
                <div class="flex items-center gap-space-2xs font-label-sm text-label-sm flex-shrink-0"><span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono">14</span><span class="text-outline">Final Report</span></div>
            </div>
        </header>
        <main class="relative pt-28 w-full px-space-lg pb-space-2xl bg-background">
            <div class="flex flex-col w-full">
                <!-- TOP TELEMETRY / WORKSPACE CONTROL BAR -->
                <div class="flex flex-col gap-space-sm mb-space-md">
                    <!-- Meta row: Session coordinates & operational posture -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm bg-surface-container-lowest p-space-sm rounded-lg border border-outline-variant/30">
                        <div class="flex flex-wrap items-center gap-space-md">
                            <div class="flex items-center gap-space-xs font-label-sm text-label-sm">
                                <span class="text-outline uppercase tracking-wider">SESSION</span>
                                <span class="font-mono text-tertiary bg-surface-container-high px-space-xs py-0.5 rounded">QRY-2024-0914-08</span>
                            </div>
                            <div class="h-3 w-px bg-outline-variant"></div>
                            <div class="flex items-center gap-space-xs font-label-sm text-label-sm">
                                <span class="text-outline uppercase tracking-wider">ENGINE</span>
                                <span class="text-primary font-mono flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary">memory</span>
                                    PostgreSQL 15.4 / DuckDB In-Memory OLAP v0.9.2
                                </span>
                            </div>
                            <div class="h-3 w-px bg-outline-variant"></div>
                            <div class="flex items-center gap-1.5 font-label-sm text-label-sm">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-tertiary opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-tertiary"></span>
                                </span>
                                <span class="text-on-surface uppercase tracking-wider">REPL PIPELINE READY</span>
                            </div>
                        </div>
                        <!-- Execution mode segmented pill -->
                        <div class="flex items-center bg-surface-container p-0.5 rounded-full font-label-sm text-label-sm border border-outline-variant/40" id="modeSelector">
                            <button class="px-space-sm py-1 rounded-full bg-primary-container text-on-surface font-semibold flex items-center gap-1 transition-all" id="btnModeSql">
                                <span class="material-symbols-outlined text-[14px] text-tertiary">data_object</span>
                                <span>SQL Query</span>
                            </button>
                            <button class="px-space-sm py-1 rounded-full text-on-surface-variant hover:text-on-surface flex items-center gap-1 transition-all" id="btnModePandas">
                                <span class="material-symbols-outlined text-[14px]">code</span>
                                <span>pandas DataFrame</span>
                            </button>
                        </div>
                    </div>
                    <!-- Execution control strip & primary actions -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm bg-surface-container-low p-space-sm rounded-lg border border-outline-variant/30">
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <!-- Run action -->
                            <button class="flex items-center gap-space-xs px-space-md py-1.5 bg-tertiary hover:bg-tertiary-fixed text-on-tertiary font-label-lg text-label-lg rounded shadow-sm transition-all group font-semibold" id="btnExecuteQuery">
                                <span class="material-symbols-outlined text-[18px] group-hover:scale-110 transition-transform">play_arrow</span>
                                <span>Run Query</span>
                                <span class="font-mono text-label-sm bg-on-tertiary/15 px-1 py-0.2 rounded ml-1">Ctrl+Enter</span>
                            </button>
                            <button class="flex items-center gap-space-2xs px-space-sm py-1.5 bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm rounded transition-colors border border-outline-variant/30">
                                <span class="material-symbols-outlined text-[16px] text-primary">auto_fix</span>
                                <span>Format SQL</span>
                            </button>
                            <button class="flex items-center gap-space-2xs px-space-sm py-1.5 bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm rounded transition-colors border border-outline-variant/30">
                                <span class="material-symbols-outlined text-[16px] text-tertiary">schema</span>
                                <span>Validate (EXPLAIN)</span>
                            </button>
                            <button class="flex items-center gap-space-2xs px-space-sm py-1.5 bg-surface-container-high hover:bg-error-container/40 text-on-surface-variant hover:text-error font-label-sm text-label-sm rounded transition-colors border border-outline-variant/30">
                                <span class="material-symbols-outlined text-[16px]">stop_circle</span>
                                <span>Kill</span>
                            </button>
                            <div class="h-4 w-px bg-outline-variant/40 mx-space-2xs"></div>
                            <!-- Limit selector -->
                            <div class="flex items-center gap-space-2xs bg-surface-container px-space-sm py-1 rounded border border-outline-variant/30">
                                <span class="font-label-sm text-label-sm text-outline">LIMIT:</span>
                                <select class="bg-transparent font-mono font-label-sm text-label-sm text-on-surface focus:outline-none cursor-pointer">
                                    <option class="bg-surface-container-high text-on-surface" value="100">100 rows</option>
                                    <option class="bg-surface-container-high text-on-surface" selected="" value="500">500 rows</option>
                                    <option class="bg-surface-container-high text-on-surface" value="1000">1,000 rows</option>
                                    <option class="bg-surface-container-high text-on-surface" value="ALL">All records</option>
                                </select>
                            </div>
                            <!-- Timeout chip -->
                            <div class="flex items-center gap-1 font-label-sm text-label-sm text-on-surface-variant bg-surface-container px-space-xs py-1 rounded border border-outline-variant/20">
                                <span class="material-symbols-outlined text-[14px] text-outline">timer</span>
                                <span class="font-mono text-outline">TTL: 30s</span>
                            </div>
                        </div>
                        <!-- Downstream Pipeline dispatch actions -->
                        <div class="flex flex-wrap items-center gap-space-xs">
                            <button class="flex items-center gap-1 px-space-sm py-1.5 bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm rounded transition-colors border border-outline-variant/30">
                                <span class="material-symbols-outlined text-[16px] text-primary">bookmark_add</span>
                                <span>Save Virtual View</span>
                            </button>
                            <!-- Export Dropdown simulation -->
                            <div class="relative group">
                                <button class="flex items-center gap-1 px-space-sm py-1.5 bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-label-sm text-label-sm rounded transition-colors border border-outline-variant/30">
                                    <span class="material-symbols-outlined text-[16px] text-tertiary">download</span>
                                    <span>Export Results</span>
                                    <span class="material-symbols-outlined text-[14px]">arrow_drop_down</span>
                                </button>
                                <div class="hidden group-hover:flex flex-col absolute right-0 top-full mt-1 w-44 bg-surface-container-lowest rounded-md shadow-xl border border-outline-variant/50 p-1 z-30 font-label-sm text-label-sm">
                                    <button class="flex items-center justify-between px-space-sm py-1.5 hover:bg-surface-container rounded text-left text-on-surface">
                                        <span>CSV Compressed (.gz)</span>
                                        <span class="font-mono text-outline text-[10px]">~12 KB</span>
                                    </button>
                                    <button class="flex items-center justify-between px-space-sm py-1.5 hover:bg-surface-container rounded text-left text-on-surface">
                                        <span>Apache Parquet</span>
                                        <span class="font-mono text-tertiary text-[10px]">FAST</span>
                                    </button>
                                    <button class="flex items-center justify-between px-space-sm py-1.5 hover:bg-surface-container rounded text-left text-on-surface">
                                        <span>JSON Lines (NDJSON)</span>
                                        <span class="font-mono text-outline text-[10px]">REST</span>
                                    </button>
                                </div>
                            </div>
                            <button class="flex items-center gap-1.5 px-space-md py-1.5 bg-primary-container hover:bg-secondary-container text-primary font-label-sm text-label-sm rounded font-semibold transition-colors border border-primary/30">
                                <span class="material-symbols-outlined text-[16px] text-tertiary">send</span>
                                <span>Send to SYS-AI-03 Workbench</span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- WORKSPACE BODY: 2-COLUMN DUAL STRATUM (Sidebar + Editor/Results) -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-md w-full items-start">
                    <!-- LEFT PANEL: SCHEMA & TABLE CATALOG BROWSER (3 cols on xl) -->
                    <div class="xl:col-span-3 flex flex-col bg-surface-container-lowest rounded-lg border border-outline-variant/30 overflow-hidden">
                        <!-- Catalog Header -->
                        <div class="p-space-sm bg-surface-container-low flex items-center justify-between border-b border-outline-variant/30">
                            <div class="flex items-center gap-space-xs font-label-sm text-label-sm">
                                <span class="material-symbols-outlined text-[16px] text-tertiary">folder_data</span>
                                <span class="font-semibold text-on-surface tracking-wider uppercase">SCHEMA BROWSER</span>
                            </div>
                            <span class="font-mono text-label-sm text-tertiary bg-tertiary/10 px-1.5 py-0.5 rounded">3 CONNECTED</span>
                        </div>
                        <!-- Quick Search Schemas -->
                        <div class="p-space-xs bg-surface-container-lowest border-b border-outline-variant/20">
                            <div class="flex items-center bg-surface-container px-space-xs py-1 rounded border border-outline-variant/30">
                                <span class="material-symbols-outlined text-[16px] text-outline mr-1">search</span>
                                <input class="bg-transparent text-body-sm font-body-sm text-on-surface placeholder:text-outline focus:outline-none w-full" placeholder="Filter tables, fields, schemas..." type="text" />
                                <span class="material-symbols-outlined text-[14px] text-outline cursor-pointer hover:text-on-surface">tune</span>
                            </div>
                        </div>
                        <!-- Hierarchical Tree Container -->
                        <div class="p-space-xs flex flex-col gap-1 max-h-[360px] overflow-y-auto">
                            <!-- Schema 1: CRM (Active focus) -->
                            <div class="flex flex-col bg-surface-container-low/60 rounded p-space-2xs border border-primary/20">
                                <div class="flex items-center justify-between text-label-sm font-label-sm py-1 px- space-2xs cursor-pointer hover:bg-surface-container-high rounded text-on-surface">
                                    <div class="flex items-center gap-1.5 font-semibold text-primary">
                                        <span class="material-symbols-outlined text-[16px] text-primary">expand_more</span>
                                        <span class="font-mono text-tertiary">sys05_crm</span>
                                    </div>
                                    <span class="text-[9px] font-mono px-1 py-0.2 rounded bg-tertiary-container text-tertiary">LVL 2</span>
                                </div>
                                <!-- Table & Columns Tree -->
                                <div class="pl-4 pr-1 flex flex-col gap-1 mt-0.5">
                                    <!-- customers table node -->
                                    <div class="flex items-center justify-between p-1 rounded bg-surface-container-high/80 text-on-surface">
                                        <div class="flex items-center gap-1 font-mono text-label-sm font-semibold">
                                            <span class="material-symbols-outlined text-[14px] text-tertiary">table_chart</span>
                                            <span class="text-tertiary">customers</span>
                                            <span class="text-outline text-[10px]">(18 cols · 10.4k)</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <button class="hover:text-tertiary text-outline material-symbols-outlined text-[14px]" title="Insert into SQL">add_circle</button>
                                            <button class="hover:text-primary text-outline material-symbols-outlined text-[14px]" title="Preview Top 50">visibility</button>
                                        </div>
                                    </div>
                                    <!-- Column list -->
                                    <div class="pl-4 flex flex-col gap-0.5 border-l border-outline-variant/30 ml-2">
                                        <div class="flex items-center justify-between font-mono text-[11px] text-on-surface-variant hover:text-on-surface py-0.5">
                                            <span class="flex items-center gap-1">
                                                <span class="text-tertiary font-bold text-[9px]">PK</span>
                                                <span>cus_id</span>
                                            </span>
                                            <span class="text-outline text-[10px]">INT4</span>
                                        </div>
                                        <div class="flex items-center justify-between font-mono text-[11px] text-on-surface-variant hover:text-on-surface py-0.5">
                                            <span>company_name</span>
                                            <span class="text-outline text-[10px]">VARCHAR</span>
                                        </div>
                                        <div class="flex items-center justify-between font-mono text-[11px] text-on-surface-variant hover:text-on-surface py-0.5">
                                            <span>industry_sector</span>
                                            <span class="text-outline text-[10px]">VARCHAR</span>
                                        </div>
                                        <div class="flex items-center justify-between font-mono text-[11px] text-on-surface-variant hover:text-on-surface py-0.5">
                                            <span>monthly_spend_eur</span>
                                            <span class="text-outline text-[10px]">NUMERIC</span>
                                        </div>
                                        <div class="flex items-center justify-between font-mono text-[11px] text-on-surface-variant hover:text-on-surface py-0.5">
                                            <span>account_age_months</span>
                                            <span class="text-outline text-[10px]">INT</span>
                                        </div>
                                        <div class="flex items-center justify-between font-mono text-[11px] text-on-surface-variant hover:text-on-surface py-0.5">
                                            <span>support_tickets_l90d</span>
                                            <span class="text-outline text-[10px]">INT</span>
                                        </div>
                                        <div class="flex items-center justify-between font-mono text-[11px] text-tertiary bg-tertiary/10 px-1 rounded py-0.5 font-semibold">
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[11px]">crisis_alert</span>
                                                <span>churn_label</span>
                                            </span>
                                            <span class="text-[9px] uppercase tracking-wide">TARGET</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Schema 2: Finance -->
                            <div class="flex flex-col bg-surface-container-lowest rounded p-space-2xs border border-outline-variant/20">
                                <div class="flex items-center justify-between text-label-sm font-label-sm py-1 px-space-2xs cursor-pointer hover:bg-surface-container-high rounded text-on-surface">
                                    <div class="flex items-center gap-1.5 font-semibold text-on-surface">
                                        <span class="material-symbols-outlined text-[16px] text-outline">expand_more</span>
                                        <span class="font-mono text-primary">sys07_finance</span>
                                    </div>
                                    <span class="text-[9px] font-mono px-1 py-0.2 rounded bg-surface-container-high text-on-surface-variant">LVL 2</span>
                                </div>
                                <div class="pl-4 pr-1 flex flex-col gap-1 mt-0.5">
                                    <div class="flex items-center justify-between p-1 rounded hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface">
                                        <div class="flex items-center gap-1 font-mono text-label-sm">
                                            <span class="material-symbols-outlined text-[14px] text-outline">table_chart</span>
                                            <span>transactions</span>
                                            <span class="text-outline text-[10px]">(12c · 84.2k)</span>
                                        </div>
                                        <button class="hover:text-tertiary text-outline material-symbols-outlined text-[14px]" title="Quick Join">link</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Schema 3: IT Helpdesk -->
                            <div class="flex flex-col bg-surface-container-lowest rounded p-space-2xs border border-outline-variant/20">
                                <div class="flex items-center justify-between text-label-sm font-label-sm py-1 px-space-2xs cursor-pointer hover:bg-surface-container-high rounded text-on-surface">
                                    <div class="flex items-center gap-1.5 font-semibold text-on-surface">
                                        <span class="material-symbols-outlined text-[16px] text-outline">expand_more</span>
                                        <span class="font-mono text-primary">sys08_it_helpdesk</span>
                                    </div>
                                    <span class="text-[9px] font-mono px-1 py-0.2 rounded bg-surface-container-high text-on-surface-variant">LVL 2</span>
                                </div>
                                <div class="pl-4 pr-1 flex flex-col gap-1 mt-0.5">
                                    <div class="flex items-center justify-between p-1 rounded hover:bg-surface-container-high text-on-surface-variant hover:text-on-surface">
                                        <div class="flex items-center gap-1 font-mono text-label-sm">
                                            <span class="material-symbols-outlined text-[14px] text-outline">table_chart</span>
                                            <span>support_tickets</span>
                                            <span class="text-outline text-[10px]">(14c · 5.6k)</span>
                                        </div>
                                        <button class="hover:text-tertiary text-outline material-symbols-outlined text-[14px]" title="Quick Join">link</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Schema 4: HR (Locked) -->
                            <div class="flex items-center justify-between text-label-sm font-label-sm py-1.5 px-space-sm bg-surface-container-lowest rounded opacity-50 border border-transparent">
                                <div class="flex items-center gap-1.5 font-mono text-outline">
                                    <span class="material-symbols-outlined text-[14px] text-error">lock</span>
                                    <span>sys06_hr</span>
                                </div>
                                <span class="text-[9px] font-mono px-1 py-0.2 rounded bg-error-container text-on-error-container">LVL 3 REQ</span>
                            </div>
                        </div>
                        <!-- Quick Analysis Snippets Drawer -->
                        <div class="p-space-sm bg-surface-container-low border-t border-outline-variant/30 flex flex-col gap-space-xs">
                            <div class="flex items-center justify-between font-label-sm text-label-sm">
                                <span class="text-outline uppercase tracking-wider font-semibold">RECIPE SNIPPETS</span>
                                <span class="material-symbols-outlined text-[14px] text-outline">bolt</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <button class="text-left font-mono text-[11px] p-1.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface flex items-center justify-between group transition-colors">
                                    <span class="text-primary group-hover:text-tertiary">#01 Churn Analysis Join</span>
                                    <span class="text-outline group-hover:text-tertiary text-[10px]">INSERT</span>
                                </button>
                                <button class="text-left font-mono text-[11px] p-1.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface flex items-center justify-between group transition-colors">
                                    <span class="text-on-surface-variant group-hover:text-tertiary">#02 Agg Spend by Sector</span>
                                    <span class="text-outline group-hover:text-tertiary text-[10px]">INSERT</span>
                                </button>
                                <button class="text-left font-mono text-[11px] p-1.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface flex items-center justify-between group transition-colors">
                                    <span class="text-on-surface-variant group-hover:text-tertiary">#03 Missing Values Filter</span>
                                    <span class="text-outline group-hover:text-tertiary text-[10px]">INSERT</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT / MAIN: DUAL EDITOR + RESULTS VIEWPORT (9 cols on xl) -->
                    <div class="xl:col-span-9 flex flex-col gap-space-md">
                        <!-- MODULE 1: CODE EDITOR FRAME -->
                        <div class="flex flex-col bg-surface-container-lowest rounded-lg border border-outline-variant/40 overflow-hidden shadow-md">
                            <!-- Editor Tab Bar -->
                            <div class="flex items-center justify-between bg-surface-container-low border-b border-outline-variant/30 px-space-sm pt-space-xs">
                                <div class="flex items-center gap-1 font-mono text-label-sm text-label-sm">
                                    <!-- Active Tab 1 -->
                                    <div class="flex items-center gap-2 px-space-sm py-1.5 bg-surface-container-lowest text-tertiary rounded-t font-semibold border-t-2 border-tertiary border-x border-outline-variant/30">
                                        <span class="material-symbols-outlined text-[14px]">terminal</span>
                                        <span>query_churn_factors.sql</span>
                                        <span class="h-1.5 w-1.5 rounded-full bg-tertiary"></span>
                                        <button class="material-symbols-outlined text-[14px] text-outline hover:text-on-surface">close</button>
                                    </div>
                                    <!-- Inactive Tab 2 -->
                                    <div class="flex items-center gap-2 px-space-sm py-1.5 text-on-surface-variant hover:bg-surface-container rounded-t transition-colors cursor-pointer">
                                        <span class="material-symbols-outlined text-[14px] text-outline">description</span>
                                        <span>sector_spend_agg.sql</span>
                                    </div>
                                    <!-- Inactive Tab 3 -->
                                    <div class="flex items-center gap-2 px-space-sm py-1.5 text-on-surface-variant hover:bg-surface-container rounded-t transition-colors cursor-pointer">
                                        <span class="material-symbols-outlined text-[14px] text-outline">data_array</span>
                                        <span>scratchpad.py (pandas)</span>
                                    </div>
                                    <button class="p-1 text-outline hover:text-on-surface rounded hover:bg-surface-container">
                                        <span class="material-symbols-outlined text-[16px]">add</span>
                                    </button>
                                </div>
                                <div class="flex items-center gap-space-xs text-outline font-label-sm text-label-sm pb-1">
                                    <span>UTF-8</span>
                                    <span>·</span>
                                    <span>Spaces: 4</span>
                                    <span>·</span>
                                    <button class="material-symbols-outlined text-[16px] hover:text-on-surface" title="Toggle wrap">wrap_text</button>
                                </div>
                            </div>
                            <!-- Interactive Realistic Code Viewport -->
                            <div class="relative flex font-mono text-body-sm bg-[#000c1c] text-on-surface select-text overflow-x-auto py-space-sm">
                                <!-- Line Numbers Gutter -->
                                <div class="flex flex-col text-right pr-space-sm pl-space-sm select-none text-outline-variant/70 border-r border-outline-variant/20 font-mono text-label-sm leading-6">
                                    <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span><span>15</span><span>16</span>
                                </div>
                                <!-- Highlighted SQL Code -->
                                <div class="flex-1 pl-space-md pr-space-md whitespace-pre font-mono leading-6 tracking-wide">
                                    <div><span class="text-outline italic">-- Ticket #AI-024: Cross-feature aggregation for high-risk accounts</span></div>
                                    <div><span class="text-tertiary font-bold">SELECT</span></div>
                                    <div> c.cus_id,</div>
                                    <div> c.company_name,</div>
                                    <div> c.industry_sector,</div>
                                    <div> c.service_tier,</div>
                                    <div> c.monthly_spend_eur,</div>
                                    <div> c.account_age_months,</div>
                                    <div> <span class="text-secondary font-semibold">COUNT</span>(t.ticket_id) <span class="text-tertiary font-bold">AS</span> open_tickets_90d,</div>
                                    <div> <span class="text-secondary font-semibold">ROUND</span>(<span class="text-secondary font-semibold">AVG</span>(tx.amount_eur), <span class="text-[#ffddb5]">2</span>) <span class="text-tertiary font-bold">AS</span> avg_monthly_tx,</div>
                                    <div> c.churn_label</div>
                                    <div><span class="text-tertiary font-bold">FROM</span> sys05_crm.customers c</div>
                                    <div><span class="text-tertiary font-bold">LEFT JOIN</span> sys08_it_helpdesk.support_tickets t </div>
                                    <div> <span class="text-tertiary font-bold">ON</span> c.cus_id = t.cus_id <span class="text-tertiary font-bold">AND</span> t.status <span class="text-tertiary font-bold">IN</span> (<span class="text-secondary-fixed-dim">'OPEN'</span>, <span class="text-secondary-fixed-dim">'ESCALATED'</span>)</div>
                                    <div><span class="text-tertiary font-bold">LEFT JOIN</span> sys07_finance.transactions tx</div>
                                    <div> <span class="text-tertiary font-bold">ON</span> c.cus_id = tx.cus_id <span class="text-tertiary font-bold">AND</span> tx.tx_date &gt;= <span class="text-secondary font-semibold">CURRENT_DATE</span> - <span class="text-tertiary font-bold">INTERVAL</span> <span class="text-secondary-fixed-dim">'90 days'</span></div>
                                    <div><span class="text-tertiary font-bold">GROUP BY</span> c.cus_id, c.company_name, c.industry_sector, c.service_tier, c.monthly_spend_eur, c.account_age_months, c.churn_label</div>
                                    <div><span class="text-tertiary font-bold">ORDER BY</span> c.monthly_spend_eur <span class="text-tertiary font-bold">DESC</span>, open_tickets_90d <span class="text-tertiary font-bold">DESC</span></div>
                                    <div><span class="text-tertiary font-bold">LIMIT</span> <span class="text-[#ffddb5]">500</span>;</div>
                                </div>
                            </div>
                            <!-- Editor Telemetry Status Footer -->
                            <div class="px-space-md py-1.5 bg-surface-container flex flex-wrap items-center justify-between text-label-sm font-label-sm border-t border-outline-variant/30">
                                <div class="flex items-center gap-space-md">
                                    <div class="flex items-center gap-1.5 text-secondary font-semibold">
                                        <span class="material-symbols-outlined text-[16px] text-tertiary">check_circle</span>
                                        <span class="text-on-surface">Execution: <span class="text-tertiary font-mono">COMPLETED</span> in <span class="font-mono text-tertiary">142ms</span></span>
                                    </div>
                                    <span class="text-outline">·</span>
                                    <div class="font-mono text-on-surface-variant">500 rows returned</div>
                                    <span class="text-outline">·</span>
                                    <div class="font-mono text-on-surface-variant">4.2 MB scanned</div>
                                </div>
                                <div class="flex items-center gap-space-md font-mono text-[11px] text-outline">
                                    <span>Buffer: 28.4 MB</span>
                                    <span>Spool: 0 KB (Direct RAM)</span>
                                    <span class="text-tertiary">DuckDB Vectorized</span>
                                </div>
                            </div>
                        </div>
                        <!-- MODULE 2: RESULTS INSPECTION & DATA GRID -->
                        <div class="flex flex-col bg-surface-container-lowest rounded-lg border border-outline-variant/40 overflow-hidden shadow-lg">
                            <!-- Results Sub-tabs & Quick Actions Toolbar -->
                            <div class="p-space-sm bg-surface-container-low flex flex-wrap items-center justify-between gap-space-sm border-b border-outline-variant/30">
                                <!-- Views switcher -->
                                <div class="flex items-center gap-1 font-label-sm text-label-sm">
                                    <button class="px-space-sm py-1 rounded bg-surface-container-high text-tertiary font-semibold flex items-center gap-1.5 border border-outline-variant/40">
                                        <span class="material-symbols-outlined text-[16px]">grid_on</span>
                                        <span>Results Table</span>
                                        <span class="font-mono text-[10px] bg-tertiary/20 text-tertiary px-1 py-0.2 rounded">500</span>
                                    </button>
                                    <button class="px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container flex items-center gap-1.5 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">account_tree</span>
                                        <span>Query Plan (EXPLAIN)</span>
                                    </button>
                                    <button class="px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container flex items-center gap-1.5 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">insights</span>
                                        <span>Telemetry &amp; Profiling</span>
                                    </button>
                                    <button class="px-space-sm py-1 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container flex items-center gap-1.5 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">sync_alt</span>
                                        <span>pandas Equivalent</span>
                                    </button>
                                </div>
                                <!-- Utility tools -->
                                <div class="flex items-center gap-space-xs">
                                    <div class="flex items-center bg-surface-container px-space-xs py-1 rounded border border-outline-variant/30">
                                        <span class="material-symbols-outlined text-[14px] text-outline mr-1">filter_list</span>
                                        <input class="bg-transparent text-label-sm font-label-sm text-on-surface placeholder:text-outline focus:outline-none w-36" placeholder="Filter in result rows..." type="text" />
                                    </div>
                                    <button class="p-1 text-on-surface-variant hover:text-on-surface rounded bg-surface-container hover:bg-surface-container-high border border-outline-variant/30" title="Toggle columns">
                                        <span class="material-symbols-outlined text-[16px]">view_column</span>
                                    </button>
                                    <button class="p-1 text-on-surface-variant hover:text-on-surface rounded bg-surface-container hover:bg-surface-container-high border border-outline-variant/30" title="Copy to clipboard">
                                        <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                    </button>
                                    <button class="p-1 text-on-surface-variant hover:text-on-surface rounded bg-surface-container hover:bg-surface-container-high border border-outline-variant/30" title="Open fullscreen">
                                        <span class="material-symbols-outlined text-[16px]">fullscreen</span>
                                    </button>
                                </div>
                            </div>
                            <!-- High-Density Analytical Data Table -->
                            <div class="overflow-x-auto w-full">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-surface-container-high text-on-surface font-mono text-[11px] uppercase tracking-wider border-b border-outline-variant/40">
                                            <th class="py-2 px-space-sm border-r border-outline-variant/20">#</th>
                                            <th class="py-2 px-space-sm border-r border-outline-variant/20">cus_id <span class="text-tertiary">▾</span></th>
                                            <th class="py-2 px-space-sm border-r border-outline-variant/20">company_name</th>
                                            <th class="py-2 px-space-sm border-r border-outline-variant/20">industry_sector</th>
                                            <th class="py-2 px-space-sm border-r border-outline-variant/20">service_tier</th>
                                            <th class="py-2 px-space-sm text-right border-r border-outline-variant/20">monthly_spend_eur</th>
                                            <th class="py-2 px-space-sm text-right border-r border-outline-variant/20">age_mo</th>
                                            <th class="py-2 px-space-sm text-right border-r border-outline-variant/20">open_tx_90d</th>
                                            <th class="py-2 px-space-sm text-right border-r border-outline-variant/20">avg_tx_eur</th>
                                            <th class="py-2 px-space-sm text-center">churn_label</th>
                                        </tr>
                                    </thead>
                                    <tbody class="font-mono text-body-sm divide-y divide-outline-variant/20">
                                        <!-- Row 1 -->
                                        <tr class="hover:bg-surface-container-high/60 transition-colors">
                                            <td class="py-2 px-space-sm text-outline font-mono text-label-sm border-r border-outline-variant/20">01</td>
                                            <td class="py-2 px-space-sm font-semibold text-primary border-r border-outline-variant/20">CUS-1005</td>
                                            <td class="py-2 px-space-sm text-on-surface font-body-sm font-medium border-r border-outline-variant/20">Ob-Irtysh Cryo-Engineering</td>
                                            <td class="py-2 px-space-sm text-on-surface-variant font-body-sm border-r border-outline-variant/20">Telemetry &amp; Energy</td>
                                            <td class="py-2 px-space-sm border-r border-outline-variant/20"><span class="px-1.5 py-0.5 rounded text-[11px] bg-primary-container text-primary">Tier 3 Sovereign</span></td>
                                            <td class="py-2 px-space-sm text-right font-semibold text-on-surface border-r border-outline-variant/20">€4,150.00</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface-variant border-r border-outline-variant/20">52</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface border-r border-outline-variant/20">2</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface-variant border-r border-outline-variant/20">€1,383.33</td>
                                            <td class="py-2 px-space-sm text-center">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-semibold bg-surface-container text-on-surface-variant">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-outline"></span> 0 (Retained)
                                                </span>
                                            </td>
                                        </tr>
                                        <!-- Row 2 (Churn Alert) -->
                                        <tr class="bg-error-container/10 hover:bg-error-container/20 transition-colors">
                                            <td class="py-2 px-space-sm text-outline font-mono text-label-sm border-r border-outline-variant/20">02</td>
                                            <td class="py-2 px-space-sm font-semibold text-error border-r border-outline-variant/20">CUS-1004</td>
                                            <td class="py-2 px-space-sm text-on-surface font-body-sm font-medium border-r border-outline-variant/20">Severo-Vostok Transport</td>
                                            <td class="py-2 px-space-sm text-on-surface-variant font-body-sm border-r border-outline-variant/20">Enterprise Logistics</td>
                                            <td class="py-2 px-space-sm border-r border-outline-variant/20"><span class="px-1.5 py-0.5 rounded text-[11px] bg-surface-container text-secondary">Tier 2 Enterprise</span></td>
                                            <td class="py-2 px-space-sm text-right font-semibold text-on-surface border-r border-outline-variant/20">€3,120.00</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface-variant border-r border-outline-variant/20">8</td>
                                            <td class="py-2 px-space-sm text-right font-bold text-error border-r border-outline-variant/20">14</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface-variant border-r border-outline-variant/20">€1,040.00</td>
                                            <td class="py-2 px-space-sm text-center">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-error-container text-error">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-error animate-pulse"></span> 1 (Churned)
                                                </span>
                                            </td>
                                        </tr>
                                        <!-- Row 3 (Churn Alert) -->
                                        <tr class="bg-error-container/10 hover:bg-error-container/20 transition-colors">
                                            <td class="py-2 px-space-sm text-outline font-mono text-label-sm border-r border-outline-variant/20">03</td>
                                            <td class="py-2 px-space-sm font-semibold text-error border-r border-outline-variant/20">CUS-1002</td>
                                            <td class="py-2 px-space-sm text-on-surface font-body-sm font-medium border-r border-outline-variant/20">BaltNord Process Systems</td>
                                            <td class="py-2 px-space-sm text-on-surface-variant font-body-sm border-r border-outline-variant/20">Heavy Manufacturing</td>
                                            <td class="py-2 px-space-sm border-r border-outline-variant/20"><span class="px-1.5 py-0.5 rounded text-[11px] bg-surface-container text-secondary">Tier 1 Core</span></td>
                                            <td class="py-2 px-space-sm text-right font-semibold text-on-surface border-r border-outline-variant/20">€2,890.00</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface-variant border-r border-outline-variant/20">12</td>
                                            <td class="py-2 px-space-sm text-right font-bold text-tertiary border-r border-outline-variant/20">8</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface-variant border-r border-outline-variant/20">€963.33</td>
                                            <td class="py-2 px-space-sm text-center">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-error-container text-error">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-error"></span> 1 (Churned)
                                                </span>
                                            </td>
                                        </tr>
                                        <!-- Row 4 -->
                                        <tr class="hover:bg-surface-container-high/60 transition-colors">
                                            <td class="py-2 px-space-sm text-outline font-mono text-label-sm border-r border-outline-variant/20">04</td>
                                            <td class="py-2 px-space-sm font-semibold text-primary border-r border-outline-variant/20">CUS-1001</td>
                                            <td class="py-2 px-space-sm text-on-surface font-body-sm font-medium border-r border-outline-variant/20">Aral Geomatics Group</td>
                                            <td class="py-2 px-space-sm text-on-surface-variant font-body-sm border-r border-outline-variant/20">Geomatics &amp; Defense</td>
                                            <td class="py-2 px-space-sm border-r border-outline-variant/20"><span class="px-1.5 py-0.5 rounded text-[11px] bg-surface-container text-secondary">Tier 2 Enterprise</span></td>
                                            <td class="py-2 px-space-sm text-right font-semibold text-on-surface border-r border-outline-variant/20">€1,420.00</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface-variant border-r border-outline-variant/20">34</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface border-r border-outline-variant/20">1</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface-variant border-r border-outline-variant/20">€473.33</td>
                                            <td class="py-2 px-space-sm text-center">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-semibold bg-surface-container text-on-surface-variant">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-outline"></span> 0 (Retained)
                                                </span>
                                            </td>
                                        </tr>
                                        <!-- Row 5 -->
                                        <tr class="hover:bg-surface-container-high/60 transition-colors">
                                            <td class="py-2 px-space-sm text-outline font-mono text-label-sm border-r border-outline-variant/20">05</td>
                                            <td class="py-2 px-space-sm font-semibold text-primary border-r border-outline-variant/20">CUS-1003</td>
                                            <td class="py-2 px-space-sm text-on-surface font-body-sm font-medium border-r border-outline-variant/20">Steppe Mining Technologies</td>
                                            <td class="py-2 px-space-sm text-on-surface-variant font-body-sm border-r border-outline-variant/20">Process Mining</td>
                                            <td class="py-2 px-space-sm border-r border-outline-variant/20"><span class="px-1.5 py-0.5 rounded text-[11px] bg-surface-container text-secondary">Tier 1 Core</span></td>
                                            <td class="py-2 px-space-sm text-right font-semibold text-on-surface border-r border-outline-variant/20">€840.00</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface-variant border-r border-outline-variant/20">48</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface border-r border-outline-variant/20">0</td>
                                            <td class="py-2 px-space-sm text-right text-on-surface-variant border-r border-outline-variant/20">€280.00</td>
                                            <td class="py-2 px-space-sm text-center">
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-semibold bg-surface-container text-on-surface-variant">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-outline"></span> 0 (Retained)
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <!-- STATISTICAL SUMMARY FOOTER ROW -->
                                    <tfoot>
                                        <tr class="bg-surface-container font-mono text-[11px] border-t-2 border-outline-variant/40">
                                            <td class="py-2 px-space-sm text-outline border-r border-outline-variant/20">Σ</td>
                                            <td class="py-2 px-space-sm text-on-surface-variant font-semibold border-r border-outline-variant/20">5 unique</td>
                                            <td class="py-2 px-space-sm text-outline border-r border-outline-variant/20">--</td>
                                            <td class="py-2 px-space-sm text-outline border-r border-outline-variant/20">5 sectors</td>
                                            <td class="py-2 px-space-sm text-outline border-r border-outline-variant/20">3 tiers</td>
                                            <td class="py-2 px-space-sm text-right font-bold text-tertiary border-r border-outline-variant/20">
                                                <div class="flex flex-col">
                                                    <span>AVG €2,484.00</span>
                                                    <span class="text-[9px] text-outline font-normal">MAX €4,150.00</span>
                                                </div>
                                            </td>
                                            <td class="py-2 px-space-sm text-right text-on-surface border-r border-outline-variant/20">
                                                <span>AVG 30.8m</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-right text-on-surface border-r border-outline-variant/20">
                                                <span class="text-tertiary">Σ 25 tickets</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-right text-on-surface border-r border-outline-variant/20">
                                                <span>AVG €828.00</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-center font-bold">
                                                <span class="text-error bg-error-container/30 px-1.5 py-0.5 rounded">2/5 (40% Churned)</span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- Data Grid Bottom Pagination & Micro-diagnostics -->
                            <div class="px-space-sm py-2 bg-surface-container-low flex flex-wrap items-center justify-between gap-space-sm border-t border-outline-variant/30 text-label-sm font-label-sm">
                                <div class="flex items-center gap-space-sm">
                                    <span class="text-on-surface-variant">Showing <span class="font-mono text-on-surface font-semibold">1-5</span> of <span class="font-mono text-tertiary font-semibold">500</span> records</span>
                                    <span class="text-outline">·</span>
                                    <span class="text-outline">Null values: <span class="font-mono text-primary font-semibold">0 detected</span></span>
                                </div>
                                <!-- Pagination triggers -->
                                <div class="flex items-center gap-1 font-mono">
                                    <button class="px-2 py-0.5 rounded bg-surface-container text-outline hover:text-on-surface disabled:opacity-30" disabled="">&lt;&lt;</button>
                                    <button class="px-2 py-0.5 rounded bg-surface-container text-outline hover:text-on-surface disabled:opacity-30" disabled="">&lt;</button>
                                    <button class="px-2 py-0.5 rounded bg-tertiary text-on-tertiary font-bold">1</button>
                                    <button class="px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface">2</button>
                                    <button class="px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface">3</button>
                                    <span class="px-1 text-outline">...</span>
                                    <button class="px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface">50</button>
                                    <button class="px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface">&gt;</button>
                                    <button class="px-2 py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-on-surface">&gt;&gt;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </main>
    </div>
    <script src="../assets/js/app.js"></script>
    <script src="js/main.js"></script>
</body>

</html>