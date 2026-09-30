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
                <!-- METADATA & TELEMETRY SUB-HEADER -->
                <section class="bg-surface-container-low px-space-lg py-space-md rounded-lg shadow-sm flex flex-col gap-space-sm">
                    <div class="flex flex-wrap items-center justify-between gap-space-md">
                        <div class="flex items-center gap-space-md min-w-0">
                            <div class="w-10 h-10 rounded bg-secondary-container flex items-center justify-center flex-shrink-0 text-secondary">
                                <span class="material-symbols-outlined text-[24px]">description</span>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <div class="flex items-center gap-space-xs flex-wrap">
                                    <span class="font-headline-md text-headline-md text-on-surface font-semibold tracking-tight">customers.csv</span>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container-high text-primary font-label-sm text-label-sm font-mono uppercase tracking-widest">v2.1 STABLE</span>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container-highest text-tertiary font-label-sm text-label-sm tracking-wider font-mono">CONFIDENTIAL // LVL 2 AUTH</span>
                                </div>
                                <div class="flex items-center gap-space-sm text-on-surface-variant font-body-sm text-body-sm mt-0.5">
                                    <span class="text-secondary font-mono">SYS05-CRM-INGEST</span>
                                    <span class="text-outline">/</span>
                                    <span>Cluster Alpha-09</span>
                                    <span class="text-outline">/</span>
                                    <span class="text-outline">Ingested 14m ago by pipeline <span class="font-mono text-on-surface">etl_crm_sync#892</span></span>
                                </div>
                            </div>
                        </div>
                        <!-- Action Buttons -->
                        <div class="flex items-center gap-space-xs flex-wrap">
                            <button class="flex items-center gap-space-xs px-space-sm py-2 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface transition-colors font-label-lg text-label-lg shadow-sm">
                                <span class="material-symbols-outlined text-[16px] text-tertiary">terminal</span>
                                <span>Open in SQL Workbench</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-sm py-2 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface transition-colors font-label-lg text-label-lg shadow-sm">
                                <span class="material-symbols-outlined text-[16px] text-secondary">download</span>
                                <span>Export / Download</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-sm py-2 rounded bg-surface-container-high hover:bg-surface-container-highest text-on-surface transition-colors font-label-lg text-label-lg shadow-sm">
                                <span class="material-symbols-outlined text-[16px] text-primary">verified_user</span>
                                <span>Run Audit Check</span>
                            </button>
                            <button class="flex items-center gap-space-xs px-space-sm py-2 rounded bg-primary-container text-primary font-semibold hover:bg-surface-container-highest transition-colors font-label-lg text-label-lg shadow-sm">
                                <span class="material-symbols-outlined text-[16px]">account_tree</span>
                                <span>Schema Check</span>
                            </button>
                        </div>
                    </div>
                    <!-- Micro telemetry spec rail -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-space-sm pt-space-xs bg-surface-container-lowest/60 p-space-sm rounded">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Payload Size</span>
                            <span class="font-label-lg text-label-lg text-on-surface font-mono">4.20 MB</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Encoding / Format</span>
                            <span class="font-label-lg text-label-lg text-on-surface font-mono">UTF-8 / RFC-4180</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Delimiters</span>
                            <span class="font-label-lg text-label-lg text-on-surface font-mono">Comma (,) / CR+LF</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Source Engine</span>
                            <span class="font-label-lg text-label-lg text-on-surface font-mono">Postgres CDC Sync</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Storage Node</span>
                            <span class="font-label-lg text-label-lg text-on-surface font-mono">tier1_cold_s3_vstk</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Checksum SHA-256</span>
                            <span class="font-label-lg text-label-lg text-on-surface font-mono truncate" title="e7b39a8c1f0923e59002dfbc">e7b39a...02dfbc</span>
                        </div>
                    </div>
                </section>
                <!-- TAB NAVIGATION BAR -->
                <div class="mt-space-md flex items-center justify-between overflow-x-auto bg-surface-container-lowest p-space-2xs rounded-lg shadow-sm">
                    <div class="flex items-center gap-space-xs">
                        <button class="px-space-md py-2 rounded text-on-surface-variant hover:text-on-surface font-label-lg text-label-lg transition-colors flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-[16px]">grid_on</span>
                            <span>1. Preview</span>
                        </button>
                        <button class="px-space-md py-2 rounded text-on-surface-variant hover:text-on-surface font-label-lg text-label-lg transition-colors flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-[16px]">schema</span>
                            <span>2. Schema</span>
                        </button>
                        <button class="px-space-md py-2 rounded text-on-surface-variant hover:text-on-surface font-label-lg text-label-lg transition-colors flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-[16px]">checklist_rtl</span>
                            <span>3. Quality &amp; Completeness</span>
                        </button>
                        <button class="px-space-md py-2 rounded bg-surface-container-high text-on-surface font-semibold font-label-lg text-label-lg shadow-sm flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-[16px] text-tertiary">analytics</span>
                            <span>4. Profiling &amp; Distributions</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
                        </button>
                        <button class="px-space-md py-2 rounded text-on-surface-variant hover:text-on-surface font-label-lg text-label-lg transition-colors flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-[16px]">history_edu</span>
                            <span>5. Lineage &amp; Audit History</span>
                        </button>
                    </div>
                    <div class="flex items-center gap-space-xs pr-space-xs">
                        <span class="font-label-sm text-label-sm text-outline font-mono uppercase">STAT_ENGINE: v4.8</span>
                        <span class="px-space-xs py-0.5 rounded bg-surface-container text-secondary font-label-sm text-label-sm font-mono">DETERMINISTIC</span>
                    </div>
                </div>
                <!-- A. TOP QUICK METRICS / SUMMARY RIBBON -->
                <section class="mt-space-md grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-space-md">
                    <!-- Total Records -->
                    <div class="bg-surface-container p-space-md rounded-lg flex flex-col justify-between shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between text-outline">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Total Records</span>
                            <span class="material-symbols-outlined text-[18px]">table_rows</span>
                        </div>
                        <div class="mt-space-sm flex items-baseline gap-space-xs">
                            <span class="font-telemetry-num text-telemetry-num text-on-surface font-semibold font-mono">10,480</span>
                            <span class="font-label-sm text-label-sm text-outline">rows</span>
                        </div>
                        <div class="mt-space-2xs font-body-sm text-body-sm text-on-surface-variant font-mono">Exact row count verified</div>
                        <div class="absolute -right-4 -bottom-4 w-16 h-16 rounded-full bg-primary/5 pointer-events-none"></div>
                    </div>
                    <!-- Total Attributes -->
                    <div class="bg-surface-container p-space-md rounded-lg flex flex-col justify-between shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between text-outline">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Total Attributes</span>
                            <span class="material-symbols-outlined text-[18px]">view_column</span>
                        </div>
                        <div class="mt-space-sm flex items-baseline gap-space-xs">
                            <span class="font-telemetry-num text-telemetry-num text-on-surface font-semibold font-mono">18</span>
                            <span class="font-label-sm text-label-sm text-outline">columns</span>
                        </div>
                        <div class="mt-space-2xs font-body-sm text-body-sm text-on-surface-variant font-mono flex items-center gap-space-xs">
                            <span class="text-primary">7 Num</span>
                            <span class="text-outline">·</span>
                            <span class="text-secondary">9 Cat</span>
                            <span class="text-outline">·</span>
                            <span class="text-tertiary">2 Date</span>
                        </div>
                    </div>
                    <!-- Duplicate Records -->
                    <div class="bg-surface-container p-space-md rounded-lg flex flex-col justify-between shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between text-outline">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Duplicate Records</span>
                            <span class="material-symbols-outlined text-[18px]">content_copy</span>
                        </div>
                        <div class="mt-space-sm flex items-baseline gap-space-xs">
                            <span class="font-telemetry-num text-telemetry-num text-on-surface font-semibold font-mono">0</span>
                            <span class="font-label-sm text-label-sm text-outline">instances</span>
                        </div>
                        <div class="mt-space-2xs font-body-sm text-body-sm text-on-surface-variant font-mono">Evaluated on key: CUS_ID</div>
                    </div>
                    <!-- Global Fill Rate -->
                    <div class="bg-surface-container p-space-md rounded-lg flex flex-col justify-between shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between text-outline">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Global Fill Rate</span>
                            <span class="material-symbols-outlined text-[18px]">pie_chart</span>
                        </div>
                        <div class="mt-space-sm flex items-baseline gap-space-xs">
                            <span class="font-telemetry-num text-telemetry-num text-on-surface font-semibold font-mono">98.42%</span>
                            <span class="font-label-sm text-label-sm text-outline">cells</span>
                        </div>
                        <div class="mt-space-2xs font-body-sm text-body-sm text-on-surface-variant font-mono">2,976 null / 188,640 total</div>
                    </div>
                    <!-- Target Attribute -->
                    <div class="bg-surface-container p-space-md rounded-lg flex flex-col justify-between shadow-sm relative overflow-hidden">
                        <div class="flex items-center justify-between text-outline">
                            <span class="font-label-sm text-label-sm uppercase tracking-wider">Target Attribute</span>
                            <span class="material-symbols-outlined text-[18px] text-tertiary">target</span>
                        </div>
                        <div class="mt-space-sm flex items-baseline gap-space-xs">
                            <span class="font-headline-md text-headline-md text-tertiary font-mono font-semibold">churn_label</span>
                        </div>
                        <div class="mt-space-2xs font-body-sm text-body-sm text-on-surface-variant font-mono">Binary discrete (0 / 1)</div>
                    </div>
                </section>
                <!-- B. MAIN PROFILING & QUALITY PANELS (BENTO ARCHITECTURE) -->
                <div class="mt-space-lg grid grid-cols-1 lg:grid-cols-12 gap-space-lg">
                    <!-- LEFT COLUMN: DISTRIBUTIONS & STATS (8 cols) -->
                    <div class="lg:col-span-8 flex flex-col gap-space-lg">
                        <!-- SUB-PANEL: NUMERICAL ATTRIBUTES DISTRIBUTIONS -->
                        <div class="bg-surface-container p-space-lg rounded-lg shadow-sm flex flex-col">
                            <div class="flex items-center justify-between pb-space-sm">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-[20px] text-primary">equalizer</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Continuous Numerical Profiling</span>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container-high text-outline font-mono font-label-sm text-label-sm">HISTOGRAM_BINS = 24</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider">Unfiltered Sample n=10,480</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-md mt-space-sm">
                                <!-- Numerical 1: monthly_spend_eur -->
                                <div class="bg-surface-container-low p-space-md rounded flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-lg text-label-lg font-mono text-primary font-semibold">monthly_spend_eur</span>
                                            <span class="font-label-sm text-label-sm text-outline font-mono">FLOAT64</span>
                                        </div>
                                        <!-- Metrics grid -->
                                        <div class="grid grid-cols-3 gap-space-xs mt-space-sm bg-surface-container-lowest/80 p-space-xs rounded text-center font-mono">
                                            <div class="flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">MEAN</span>
                                                <span class="text-on-surface font-body-sm text-body-sm">€842.10</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">MEDIAN</span>
                                                <span class="text-on-surface font-body-sm text-body-sm">€620.00</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">STD DEV</span>
                                                <span class="text-on-surface font-body-sm text-body-sm">€512.40</span>
                                            </div>
                                            <div class="flex flex-col mt-space-2xs">
                                                <span class="text-outline font-label-sm text-label-sm">MIN</span>
                                                <span class="text-on-surface font-body-sm text-body-sm">€12.50</span>
                                            </div>
                                            <div class="flex flex-col mt-space-2xs">
                                                <span class="text-outline font-label-sm text-label-sm">MAX</span>
                                                <span class="text-on-surface font-body-sm text-body-sm">€4,890.00</span>
                                            </div>
                                            <div class="flex flex-col mt-space-2xs">
                                                <span class="text-outline font-label-sm text-label-sm">SKEWNESS</span>
                                                <span class="text-tertiary font-body-sm text-body-sm">+1.84</span>
                                            </div>
                                        </div>
                                        <!-- High-resolution SVG Histogram with Density Curve -->
                                        <div class="mt-space-md relative w-full h-32 flex items-end">
                                            <svg class="w-full h-full overflow-visible" preserveaspectratio="none" viewbox="0 0 240 90">
                                                <g class="text-secondary-container fill-current">
                                                    <rect height="30" rx="1" width="8" x="0" y="60"></rect>
                                                    <rect height="58" rx="1" width="8" x="10" y="32"></rect>
                                                    <rect height="80" rx="1" width="8" x="20" y="10"></rect>
                                                    <rect height="72" rx="1" width="8" x="30" y="18"></rect>
                                                    <rect height="55" rx="1" width="8" x="40" y="35"></rect>
                                                    <rect height="42" rx="1" width="8" x="50" y="48"></rect>
                                                    <rect height="35" rx="1" width="8" x="60" y="55"></rect>
                                                    <rect height="28" rx="1" width="8" x="70" y="62"></rect>
                                                    <rect height="22" rx="1" width="8" x="80" y="68"></rect>
                                                    <rect height="17" rx="1" width="8" x="90" y="73"></rect>
                                                    <rect height="14" rx="1" width="8" x="100" y="76"></rect>
                                                    <rect height="12" rx="1" width="8" x="110" y="78"></rect>
                                                    <rect height="10" rx="1" width="8" x="120" y="80"></rect>
                                                    <rect height="8" rx="1" width="8" x="130" y="82"></rect>
                                                    <rect height="7" rx="1" width="8" x="140" y="83"></rect>
                                                    <rect height="6" rx="1" width="8" x="150" y="84"></rect>
                                                    <rect height="5" rx="1" width="8" x="160" y="85"></rect>
                                                    <rect height="4" rx="1" width="8" x="170" y="86"></rect>
                                                    <rect height="3" rx="1" width="8" x="180" y="87"></rect>
                                                    <rect height="3" rx="1" width="8" x="190" y="87"></rect>
                                                    <rect height="2" rx="1" width="8" x="200" y="88"></rect>
                                                    <rect height="2" rx="1" width="8" x="210" y="88"></rect>
                                                    <rect height="1" rx="1" width="8" x="220" y="89"></rect>
                                                    <rect height="1" rx="1" width="8" x="230" y="89"></rect>
                                                </g>
                                                <!-- Kernel Density Estimation overlay line -->
                                                <path d="M 0,65 Q 15,10 25,12 T 50,42 T 90,70 T 140,82 T 240,89" fill="none" stroke="#ffb956" stroke-width="2"></path>
                                            </svg>
                                        </div>
                                        <div class="flex justify-between items-center text-outline font-label-sm text-label-sm font-mono mt-1">
                                            <span>€12.50</span>
                                            <span>€1,500</span>
                                            <span>€3,000</span>
                                            <span>€4,890.00</span>
                                        </div>
                                    </div>
                                    <div class="mt-space-xs text-on-surface-variant font-body-sm text-body-sm">Right-skewed long-tail spend profile.</div>
                                </div>
                                <!-- Numerical 2: account_age_months -->
                                <div class="bg-surface-container-low p-space-md rounded flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-lg text-label-lg font-mono text-primary font-semibold">account_age_months</span>
                                            <span class="font-label-sm text-label-sm text-outline font-mono">INT32</span>
                                        </div>
                                        <!-- Metrics grid -->
                                        <div class="grid grid-cols-3 gap-space-xs mt-space-sm bg-surface-container-lowest/80 p-space-xs rounded text-center font-mono">
                                            <div class="flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">MEAN</span>
                                                <span class="text-on-surface font-body-sm text-body-sm">28.4 mo</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">MEDIAN</span>
                                                <span class="text-on-surface font-body-sm text-body-sm">24.0 mo</span>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-outline font-label-sm text-label-sm">IQR</span>
                                                <span class="text-on-surface font-body-sm text-body-sm">22.0 mo</span>
                                            </div>
                                            <div class="flex flex-col mt-space-2xs">
                                                <span class="text-outline font-label-sm text-label-sm">MIN</span>
                                                <span class="text-on-surface font-body-sm text-body-sm">1.0 mo</span>
                                            </div>
                                            <div class="flex flex-col mt-space-2xs">
                                                <span class="text-outline font-label-sm text-label-sm">MAX</span>
                                                <span class="text-on-surface font-body-sm text-body-sm">72.0 mo</span>
                                            </div>
                                            <div class="flex flex-col mt-space-2xs">
                                                <span class="text-outline font-label-sm text-label-sm">ZEROES</span>
                                                <span class="text-on-surface font-body-sm text-body-sm">0 (0.0%)</span>
                                            </div>
                                        </div>
                                        <!-- High-resolution SVG Histogram -->
                                        <div class="mt-space-md relative w-full h-32 flex items-end">
                                            <svg class="w-full h-full overflow-visible" preserveaspectratio="none" viewbox="0 0 240 90">
                                                <g class="text-surface-variant fill-current">
                                                    <rect height="45" rx="1" width="8" x="0" y="45"></rect>
                                                    <rect height="62" rx="1" width="8" x="10" y="28"></rect>
                                                    <rect height="58" rx="1" width="8" x="20" y="32"></rect>
                                                    <rect height="50" rx="1" width="8" x="30" y="40"></rect>
                                                    <rect height="70" rx="1" width="8" x="40" y="20"></rect>
                                                    <rect height="65" rx="1" width="8" x="50" y="25"></rect>
                                                    <rect height="52" rx="1" width="8" x="60" y="38"></rect>
                                                    <rect height="46" rx="1" width="8" x="70" y="44"></rect>
                                                    <rect height="42" rx="1" width="8" x="80" y="48"></rect>
                                                    <rect height="38" rx="1" width="8" x="90" y="52"></rect>
                                                    <rect height="40" rx="1" width="8" x="100" y="50"></rect>
                                                    <rect height="36" rx="1" width="8" x="110" y="54"></rect>
                                                    <rect height="32" rx="1" width="8" x="120" y="58"></rect>
                                                    <rect height="30" rx="1" width="8" x="130" y="60"></rect>
                                                    <rect height="24" rx="1" width="8" x="140" y="66"></rect>
                                                    <rect height="21" rx="1" width="8" x="150" y="69"></rect>
                                                    <rect height="18" rx="1" width="8" x="160" y="72"></rect>
                                                    <rect height="15" rx="1" width="8" x="170" y="75"></rect>
                                                    <rect height="13" rx="1" width="8" x="180" y="77"></rect>
                                                    <rect height="11" rx="1" width="8" x="190" y="79"></rect>
                                                    <rect height="9" rx="1" width="8" x="200" y="81"></rect>
                                                    <rect height="7" rx="1" width="8" x="210" y="83"></rect>
                                                    <rect height="5" rx="1" width="8" x="220" y="85"></rect>
                                                    <rect height="4" rx="1" width="8" x="230" y="86"></rect>
                                                </g>
                                                <path d="M 0,48 Q 45,15 55,25 T 100,52 T 160,72 T 240,86" fill="none" stroke="#abc9f2" stroke-width="2"></path>
                                            </svg>
                                        </div>
                                        <div class="flex justify-between items-center text-outline font-label-sm text-label-sm font-mono mt-1">
                                            <span>1 mo</span>
                                            <span>24 mo</span>
                                            <span>48 mo</span>
                                            <span>72 mo</span>
                                        </div>
                                    </div>
                                    <div class="mt-space-xs text-on-surface-variant font-body-sm text-body-sm">Cohort retention spans up to 6 years tenure.</div>
                                </div>
                            </div>
                        </div>
                        <!-- SUB-PANEL: CATEGORICAL FREQUENCIES & TARGET CLASS DISTRIBUTION -->
                        <div class="bg-surface-container p-space-lg rounded-lg shadow-sm flex flex-col">
                            <div class="flex items-center justify-between pb-space-sm">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-[20px] text-tertiary">category</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Categorical Frequencies &amp; Target Cardinality</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-outline font-mono">OBJECTIVE COUNTS (NO NORMATIVE LABELS)</span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-space-md mt-space-sm">
                                <!-- Target Class Ratio -->
                                <div class="bg-surface-container-low p-space-md rounded flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-lg text-label-lg font-mono text-tertiary font-semibold">churn_label (Target)</span>
                                            <span class="font-label-sm text-label-sm text-outline font-mono">BINARY</span>
                                        </div>
                                        <p class="text-on-surface-variant font-body-sm text-body-sm mt-1">Class representation across total records.</p>
                                        <!-- Stacked visual bar -->
                                        <div class="mt-space-md w-full h-7 rounded bg-surface-container-lowest overflow-hidden flex shadow-inner">
                                            <div class="bg-secondary-container h-full flex items-center justify-center font-label-sm text-label-sm font-mono text-on-surface font-semibold" style="width: 85%;">
                                                85.0%
                                            </div>
                                            <div class="bg-tertiary h-full flex items-center justify-center font-label-sm text-label-sm font-mono text-on-tertiary font-bold" style="width: 15%;">
                                                15.0%
                                            </div>
                                        </div>
                                        <!-- Breakdown list -->
                                        <div class="mt-space-md flex flex-col gap-space-xs">
                                            <div class="flex items-center justify-between p-space-xs rounded bg-surface-container-high/60">
                                                <div class="flex items-center gap-space-xs">
                                                    <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                                    <span class="font-mono font-label-sm text-label-sm text-on-surface">Class 0 (Retained)</span>
                                                </div>
                                                <div class="font-mono font-label-sm text-label-sm text-on-surface font-semibold">8,908 (85.0%)</div>
                                            </div>
                                            <div class="flex items-center justify-between p-space-xs rounded bg-surface-container-high/60">
                                                <div class="flex items-center gap-space-xs">
                                                    <span class="w-2.5 h-2.5 rounded-full bg-tertiary"></span>
                                                    <span class="font-mono font-label-sm text-label-sm text-on-surface">Class 1 (Churned)</span>
                                                </div>
                                                <div class="font-mono font-label-sm text-label-sm text-on-surface font-semibold">1,572 (15.0%)</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-space-md pt-space-xs text-outline font-label-sm text-label-sm font-mono">
                                        Total Class Count: 2 · Ratio: 5.67:1
                                    </div>
                                </div>
                                <!-- Categorical 1: industry_sector -->
                                <div class="bg-surface-container-low p-space-md rounded flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-lg text-label-lg font-mono text-primary font-semibold">industry_sector</span>
                                            <span class="font-label-sm text-label-sm text-outline font-mono">5 DISTINCT</span>
                                        </div>
                                        <p class="text-on-surface-variant font-body-sm text-body-sm mt-1">Frequency ranking by entity count.</p>
                                        <div class="mt-space-sm flex flex-col gap-2 font-mono font-body-sm text-body-sm">
                                            <div>
                                                <div class="flex justify-between text-on-surface text-[11px] mb-0.5">
                                                    <span class="truncate">Geomatics &amp; Defense</span>
                                                    <span>3,120 (29.8%)</span>
                                                </div>
                                                <div class="w-full bg-surface-container-lowest h-2 rounded overflow-hidden">
                                                    <div class="bg-primary h-full rounded" style="width: 29.8%;"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-on-surface text-[11px] mb-0.5">
                                                    <span class="truncate">Heavy Manufacturing</span>
                                                    <span>2,840 (27.1%)</span>
                                                </div>
                                                <div class="w-full bg-surface-container-lowest h-2 rounded overflow-hidden">
                                                    <div class="bg-primary h-full rounded" style="width: 27.1%;"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-on-surface text-[11px] mb-0.5">
                                                    <span class="truncate">Process Mining</span>
                                                    <span>2,110 (20.1%)</span>
                                                </div>
                                                <div class="w-full bg-surface-container-lowest h-2 rounded overflow-hidden">
                                                    <div class="bg-primary h-full rounded" style="width: 20.1%;"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-on-surface text-[11px] mb-0.5">
                                                    <span class="truncate">Enterprise Logistics</span>
                                                    <span>1,410 (13.5%)</span>
                                                </div>
                                                <div class="w-full bg-surface-container-lowest h-2 rounded overflow-hidden">
                                                    <div class="bg-primary h-full rounded" style="width: 13.5%;"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-on-surface text-[11px] mb-0.5">
                                                    <span class="truncate">Telemetry &amp; Energy</span>
                                                    <span>1,000 (9.5%)</span>
                                                </div>
                                                <div class="w-full bg-surface-container-lowest h-2 rounded overflow-hidden">
                                                    <div class="bg-primary h-full rounded" style="width: 9.5%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-space-sm pt-space-xs text-outline font-label-sm text-label-sm font-mono">
                                        Missing: 0 (0.00%)
                                    </div>
                                </div>
                                <!-- Categorical 2: service_tier -->
                                <div class="bg-surface-container-low p-space-md rounded flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="font-label-lg text-label-lg font-mono text-primary font-semibold">service_tier</span>
                                            <span class="font-label-sm text-label-sm text-outline font-mono">3 DISTINCT</span>
                                        </div>
                                        <p class="text-on-surface-variant font-body-sm text-body-sm mt-1">Service SLA level segmentation.</p>
                                        <div class="mt-space-sm flex flex-col gap-3 font-mono font-body-sm text-body-sm">
                                            <div>
                                                <div class="flex justify-between text-on-surface text-[11px] mb-0.5">
                                                    <span>Tier 1: Core Standard</span>
                                                    <span>5,240 (50.0%)</span>
                                                </div>
                                                <div class="w-full bg-surface-container-lowest h-2.5 rounded overflow-hidden">
                                                    <div class="bg-secondary h-full rounded" style="width: 50%;"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-on-surface text-[11px] mb-0.5">
                                                    <span>Tier 2: Enterprise SLA</span>
                                                    <span>3,810 (36.4%)</span>
                                                </div>
                                                <div class="w-full bg-surface-container-lowest h-2.5 rounded overflow-hidden">
                                                    <div class="bg-secondary h-full rounded" style="width: 36.4%;"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between text-on-surface text-[11px] mb-0.5">
                                                    <span>Tier 3: Sovereign Cloud</span>
                                                    <span>1,430 (13.6%)</span>
                                                </div>
                                                <div class="w-full bg-surface-container-lowest h-2.5 rounded overflow-hidden">
                                                    <div class="bg-secondary h-full rounded" style="width: 13.6%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-space-md pt-space-xs text-outline font-label-sm text-label-sm font-mono">
                                        Missing: 0 (0.00%) · Modus: Tier 1
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT COLUMN: QUALITY MATRIX & CORRELATION (4 cols) -->
                    <div class="lg:col-span-4 flex flex-col gap-space-lg">
                        <!-- SUB-PANEL: NEUTRAL QUALITY CHECK MATRIX -->
                        <div class="bg-surface-container p-space-lg rounded-lg shadow-sm flex flex-col">
                            <div class="flex items-center justify-between pb-space-sm">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-[20px] text-primary">data_check</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Per-Column Fill Rates</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-outline font-mono">8 / 18 INSPECTED</span>
                            </div>
                            <p class="text-on-surface-variant font-body-sm text-body-sm">Direct observation of empty/null values across attributes.</p>
                            <!-- Completeness Bars Table -->
                            <div class="mt-space-sm flex flex-col gap-space-sm">
                                <div class="bg-surface-container-low p-space-xs rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-on-surface font-semibold">cus_id</span>
                                        <span class="text-outline">0 missing · 100.0%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-primary h-full w-full"></div>
                                    </div>
                                </div>
                                <div class="bg-surface-container-low p-space-xs rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-on-surface font-semibold">company_name</span>
                                        <span class="text-outline">0 missing · 100.0%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-primary h-full w-full"></div>
                                    </div>
                                </div>
                                <div class="bg-surface-container-low p-space-xs rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-on-surface font-semibold">contract_signed_date</span>
                                        <span class="text-outline">0 missing · 100.0%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-primary h-full w-full"></div>
                                    </div>
                                </div>
                                <div class="bg-surface-container-low p-space-xs rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-on-surface font-semibold">monthly_spend_eur</span>
                                        <span class="text-outline">0 missing · 100.0%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-primary h-full w-full"></div>
                                    </div>
                                </div>
                                <div class="bg-surface-container-low p-space-xs rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-on-surface font-semibold">support_tickets_l90d</span>
                                        <span class="text-secondary">42 missing · 99.60%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-secondary h-full" style="width: 99.6%;"></div>
                                    </div>
                                </div>
                                <div class="bg-surface-container-low p-space-xs rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-on-surface font-semibold">last_telemetry_ping</span>
                                        <span class="text-secondary">184 missing · 98.25%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-secondary h-full" style="width: 98.25%;"></div>
                                    </div>
                                </div>
                                <div class="bg-surface-container-low p-space-xs rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-on-surface font-semibold">secondary_contact_email</span>
                                        <span class="text-tertiary">2,750 missing · 73.76%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-tertiary h-full" style="width: 73.76%;"></div>
                                    </div>
                                </div>
                                <div class="bg-surface-container-low p-space-xs rounded flex flex-col gap-1">
                                    <div class="flex items-center justify-between font-mono text-[11px]">
                                        <span class="text-on-surface font-semibold">churn_label</span>
                                        <span class="text-outline">0 missing · 100.0%</span>
                                    </div>
                                    <div class="w-full bg-surface-container-lowest h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-primary h-full w-full"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-space-sm pt-space-xs flex items-center justify-between text-outline font-label-sm text-label-sm">
                                <span>Total column check count: 18</span>
                                <a class="text-primary hover:underline" href="#">View all columns →</a>
                            </div>
                        </div>
                        <!-- SUB-PANEL: FEATURE CORRELATION MATRIX -->
                        <div class="bg-surface-container p-space-lg rounded-lg shadow-sm flex flex-col">
                            <div class="flex items-center justify-between pb-space-sm">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-[20px] text-tertiary">grid_view</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Pearson Correlation Matrix</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-outline font-mono">5×5 NUMERIC</span>
                            </div>
                            <p class="text-on-surface-variant font-body-sm text-body-sm">Bivariate linear coefficient readings (-1.00 to +1.00).</p>
                            <!-- 5x5 Heatmap Matrix -->
                            <div class="mt-space-md overflow-x-auto">
                                <table class="w-full text-center font-mono text-[11px] border-collapse">
                                    <thead>
                                        <tr class="text-outline">
                                            <th class="p-1 text-left font-normal">FEATURE</th>
                                            <th class="p-1 font-normal" title="monthly_spend">SPD</th>
                                            <th class="p-1 font-normal" title="account_age">AGE</th>
                                            <th class="p-1 font-normal" title="support_tickets">TCK</th>
                                            <th class="p-1 font-normal" title="telemetry_pings">PNG</th>
                                            <th class="p-1 font-normal text-tertiary font-bold" title="churn_label">CHR</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-surface-container-high/40">
                                        <tr>
                                            <td class="p-1.5 text-left text-on-surface font-semibold">monthly_spend</td>
                                            <td class="p-1.5 bg-primary-container text-primary font-bold">1.00</td>
                                            <td class="p-1.5 bg-surface-container-high text-on-surface-variant">+0.08</td>
                                            <td class="p-1.5 bg-secondary-container text-secondary font-semibold">+0.42</td>
                                            <td class="p-1.5 bg-surface-container-high text-on-surface-variant">+0.14</td>
                                            <td class="p-1.5 bg-surface-container-lowest text-tertiary">-0.22</td>
                                        </tr>
                                        <tr>
                                            <td class="p-1.5 text-left text-on-surface font-semibold">account_age</td>
                                            <td class="p-1.5 bg-surface-container-high text-on-surface-variant">+0.08</td>
                                            <td class="p-1.5 bg-primary-container text-primary font-bold">1.00</td>
                                            <td class="p-1.5 bg-surface-container-high text-on-surface-variant">-0.11</td>
                                            <td class="p-1.5 bg-surface-container-high text-on-surface-variant">+0.26</td>
                                            <td class="p-1.5 bg-secondary-container text-tertiary font-semibold">-0.31</td>
                                        </tr>
                                        <tr>
                                            <td class="p-1.5 text-left text-on-surface font-semibold">support_tickets</td>
                                            <td class="p-1.5 bg-secondary-container text-secondary font-semibold">+0.42</td>
                                            <td class="p-1.5 bg-surface-container-high text-on-surface-variant">-0.11</td>
                                            <td class="p-1.5 bg-primary-container text-primary font-bold">1.00</td>
                                            <td class="p-1.5 bg-surface-container-high text-on-surface-variant">-0.38</td>
                                            <td class="p-1.5 bg-primary-container text-tertiary font-bold">+0.54</td>
                                        </tr>
                                        <tr>
                                            <td class="p-1.5 text-left text-on-surface font-semibold">telemetry_pings</td>
                                            <td class="p-1.5 bg-surface-container-high text-on-surface-variant">+0.14</td>
                                            <td class="p-1.5 bg-surface-container-high text-on-surface-variant">+0.26</td>
                                            <td class="p-1.5 bg-surface-container-high text-on-surface-variant">-0.38</td>
                                            <td class="p-1.5 bg-primary-container text-primary font-bold">1.00</td>
                                            <td class="p-1.5 bg-primary-container text-tertiary font-bold">-0.58</td>
                                        </tr>
                                        <tr>
                                            <td class="p-1.5 text-left text-tertiary font-bold">churn_label</td>
                                            <td class="p-1.5 bg-surface-container-lowest text-tertiary">-0.22</td>
                                            <td class="p-1.5 bg-secondary-container text-tertiary font-semibold">-0.31</td>
                                            <td class="p-1.5 bg-primary-container text-tertiary font-bold">+0.54</td>
                                            <td class="p-1.5 bg-primary-container text-tertiary font-bold">-0.58</td>
                                            <td class="p-1.5 bg-primary-container text-primary font-bold">1.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-space-md flex items-center justify-between text-[10px] font-mono text-outline">
                                <div class="flex items-center gap-1">
                                    <span class="w-2.5 h-2.5 rounded-sm bg-surface-container-lowest"></span>
                                    <span>-1.0 Negative</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="w-2.5 h-2.5 rounded-sm bg-surface-container-high"></span>
                                    <span>0.0 Neutral</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="w-2.5 h-2.5 rounded-sm bg-primary-container"></span>
                                    <span>+1.0 Positive</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- C. DATA PREVIEW DRAWER / REAL SAMPLE RECORDS ACCORDION -->
                <section class="mt-space-lg bg-surface-container p-space-lg rounded-lg shadow-sm flex flex-col">
                    <div class="flex flex-wrap items-center justify-between gap-space-sm pb-space-sm">
                        <div class="flex items-center gap-space-xs">
                            <span class="material-symbols-outlined text-[20px] text-secondary">table_view</span>
                            <span class="font-headline-sm text-headline-sm text-on-surface">Data Snapshot &amp; Schema Alignment</span>
                            <span class="px-space-xs py-0.5 rounded bg-surface-container-high text-primary font-label-sm text-label-sm font-mono">Top 5 of 10,480 Rows</span>
                        </div>
                        <div class="flex items-center gap-space-sm">
                            <span class="font-label-sm text-label-sm text-outline font-mono">DISPLAYING 8 KEY FIELDS</span>
                            <button class="p-space-2xs rounded bg-surface-container-high text-on-surface hover:text-tertiary transition-colors" id="toggle-preview-btn">
                                <span class="material-symbols-outlined text-[20px]" id="toggle-icon">expand_less</span>
                            </button>
                        </div>
                    </div>
                    <!-- Data Table Container -->
                    <div class="mt-space-sm overflow-x-auto rounded" id="preview-table-container">
                        <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                            <thead class="bg-surface-container-lowest text-outline font-label-sm text-label-sm uppercase font-mono tracking-wider">
                                <tr>
                                    <th class="p-space-sm">cus_id</th>
                                    <th class="p-space-sm">company_name</th>
                                    <th class="p-space-sm">industry_sector</th>
                                    <th class="p-space-sm">service_tier</th>
                                    <th class="p-space-sm text-right">monthly_spend_eur</th>
                                    <th class="p-space-sm text-right">account_age_months</th>
                                    <th class="p-space-sm text-right">support_tickets</th>
                                    <th class="p-space-sm text-center text-tertiary">churn_label</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-surface-container-high/60 font-mono">
                                <tr class="hover:bg-surface-container-high/40 transition-colors">
                                    <td class="p-space-sm font-semibold text-primary">CUS-1001</td>
                                    <td class="p-space-sm font-body-md text-body-md text-on-surface font-sans">Aral Geomatics Group</td>
                                    <td class="p-space-sm text-on-surface-variant">Geomatics &amp; Defense</td>
                                    <td class="p-space-sm">
                                        <span class="px-space-xs py-0.5 rounded bg-surface-container-highest text-secondary text-[11px]">Tier 2 Enterprise</span>
                                    </td>
                                    <td class="p-space-sm text-right text-on-surface">€1,420.00</td>
                                    <td class="p-space-sm text-right text-on-surface">34</td>
                                    <td class="p-space-sm text-right text-on-surface">1</td>
                                    <td class="p-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-bold">0</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-container-high/40 transition-colors">
                                    <td class="p-space-sm font-semibold text-primary">CUS-1002</td>
                                    <td class="p-space-sm font-body-md text-body-md text-on-surface font-sans">BaltNord Process Systems</td>
                                    <td class="p-space-sm text-on-surface-variant">Heavy Manufacturing</td>
                                    <td class="p-space-sm">
                                        <span class="px-space-xs py-0.5 rounded bg-surface-container-highest text-secondary text-[11px]">Tier 1 Core</span>
                                    </td>
                                    <td class="p-space-sm text-right text-on-surface">€2,890.00</td>
                                    <td class="p-space-sm text-right text-on-surface">12</td>
                                    <td class="p-space-sm text-right text-on-surface">8</td>
                                    <td class="p-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-tertiary text-on-tertiary font-bold">1</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-container-high/40 transition-colors">
                                    <td class="p-space-sm font-semibold text-primary">CUS-1003</td>
                                    <td class="p-space-sm font-body-md text-body-md text-on-surface font-sans">Steppe Mining Technologies</td>
                                    <td class="p-space-sm text-on-surface-variant">Process Mining</td>
                                    <td class="p-space-sm">
                                        <span class="px-space-xs py-0.5 rounded bg-surface-container-highest text-secondary text-[11px]">Tier 1 Core</span>
                                    </td>
                                    <td class="p-space-sm text-right text-on-surface">€840.00</td>
                                    <td class="p-space-sm text-right text-on-surface">48</td>
                                    <td class="p-space-sm text-right text-on-surface">0</td>
                                    <td class="p-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-bold">0</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-container-high/40 transition-colors">
                                    <td class="p-space-sm font-semibold text-primary">CUS-1004</td>
                                    <td class="p-space-sm font-body-md text-body-md text-on-surface font-sans">Severo-Vostok Transport</td>
                                    <td class="p-space-sm text-on-surface-variant">Enterprise Logistics</td>
                                    <td class="p-space-sm">
                                        <span class="px-space-xs py-0.5 rounded bg-surface-container-highest text-secondary text-[11px]">Tier 2 Enterprise</span>
                                    </td>
                                    <td class="p-space-sm text-right text-on-surface">€3,120.00</td>
                                    <td class="p-space-sm text-right text-on-surface">8</td>
                                    <td class="p-space-sm text-right text-on-surface">14</td>
                                    <td class="p-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-tertiary text-on-tertiary font-bold">1</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-surface-container-high/40 transition-colors">
                                    <td class="p-space-sm font-semibold text-primary">CUS-1005</td>
                                    <td class="p-space-sm font-body-md text-body-md text-on-surface font-sans">Ob-Irtysh Cryo-Engineering</td>
                                    <td class="p-space-sm text-on-surface-variant">Telemetry &amp; Energy</td>
                                    <td class="p-space-sm">
                                        <span class="px-space-xs py-0.5 rounded bg-surface-container-highest text-secondary text-[11px]">Tier 3 Sovereign</span>
                                    </td>
                                    <td class="p-space-sm text-right text-on-surface">€4,150.00</td>
                                    <td class="p-space-sm text-right text-on-surface">52</td>
                                    <td class="p-space-sm text-right text-on-surface">2</td>
                                    <td class="p-space-sm text-center">
                                        <span class="px-2 py-0.5 rounded bg-surface-container-high text-on-surface font-bold">0</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Bottom Metadata Status -->
                    <div class="mt-space-md pt-space-xs flex flex-wrap items-center justify-between text-outline font-label-sm text-label-sm">
                        <div class="flex items-center gap-space-md">
                            <span>PRIMARY_KEY: `cus_id`</span>
                            <span>INDEX_STATUS: BTREE_SYNCHRONIZED</span>
                            <span>PARTITIONING: NONE</span>
                        </div>
                        <div class="flex items-center gap-space-xs">
                            <span>SHOWING FIRST 5 ROWS ONLY</span>
                            <span class="text-outline-variant font-mono">·</span>
                            <button class="text-primary hover:underline font-label-sm text-label-sm">Inspect Full Pagination Grid →</button>
                        </div>
                    </div>
                </section>
            </div>
            
        </main>
    </div>
    <script src="../assets/js/app.js"></script>
    <script src="js/main.js"></script>
</body>

</html>