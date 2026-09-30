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
                <!-- TOP CONTEXT & ACTION HEADER -->
                <div class="flex flex-col gap-space-md mb-space-lg">
                    <!-- Breadcrumb & Tactical Status Bar -->
                    <div class="flex flex-wrap items-center justify-between gap-space-md bg-surface-container-low p-space-md rounded-lg shadow-sm">
                        <div class="flex flex-col gap-space-2xs min-w-0">
                            <div class="flex items-center gap-space-xs font-label-sm text-label-sm">
                                <span class="text-on-surface-variant uppercase tracking-widest">SYS-AI-02 Data Center</span>
                                <span class="text-outline">/</span>
                                <span class="text-secondary font-semibold uppercase tracking-wider">Ingestion Gateway</span>
                                <span class="text-outline">/</span>
                                <span class="text-primary font-mono">Upload Processed Data</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-space-sm mt-space-2xs">
                                <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight flex items-center gap-space-xs">
                                    Dataset Ingestion &amp; Feature Staging
                                </h1>
                                <div class="flex items-center gap-space-xs px-space-sm py-0.5 rounded-full bg-surface-container-highest text-tertiary font-label-sm text-label-sm font-mono">
                                    <span class="h-1.5 w-1.5 rounded-full bg-tertiary animate-pulse"></span>
                                    TARGET: customer_churn_model_v2_prep
                                </div>
                                <div class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-mono font-label-sm text-label-sm">
                                    #AI-024 Customer Churn
                                </div>
                            </div>
                        </div>
                        <!-- Action Group -->
                        <div class="flex items-center gap-space-sm flex-shrink-0">
                            <button class="px-space-md py-1.5 rounded font-label-lg text-label-lg bg-surface-container-high text-on-surface-variant hover:text-on-surface hover:bg-surface-bright transition-colors">
                                Discard Staging
                            </button>
                            <button class="px-space-md py-1.5 rounded font-label-lg text-label-lg bg-secondary-container text-on-surface hover:bg-surface-variant transition-colors flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-[16px]">rule</span>
                                <span>Validate Schema Diff</span>
                            </button>
                            <button class="px-space-lg py-1.5 rounded font-label-lg text-label-lg bg-tertiary text-on-tertiary font-semibold hover:bg-tertiary-fixed transition-colors flex items-center gap-space-xs shadow-md">
                                <span>Commit &amp; Open Workbench</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                    <!-- Mode Switcher & Pipeline Ribbon -->
                    <div class="flex flex-wrap items-center justify-between gap-space-sm bg-surface-container px-space-md py-space-xs rounded">
                        <div class="flex items-center gap-space-xs">
                            <span class="font-label-sm text-label-sm text-outline uppercase tracking-wider mr-space-xs">Gateway Mode:</span>
                            <button class="px-space-sm py-1 rounded font-label-sm text-label-sm bg-primary-container text-primary font-semibold flex items-center gap-space-2xs">
                                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span>
                                Staged Dataset Ingestion
                            </button>
                            <button class="px-space-sm py-1 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors">
                                Batch Delta Append
                            </button>
                            <button class="px-space-sm py-1 rounded font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high transition-colors">
                                Direct Schema Migration
                            </button>
                        </div>
                        <div class="flex items-center gap-space-md font-label-sm text-label-sm text-outline font-mono">
                            <span class="flex items-center gap-space-2xs"><span class="text-tertiary font-bold">NODE:</span> DC-NORTH-EDGE-04</span>
                            <span class="flex items-center gap-space-2xs"><span class="text-primary font-bold">ENCRYPTION:</span> TLS 1.3 (ChaCha20)</span>
                        </div>
                    </div>
                </div>
                <!-- MAIN 2-COLUMN TELEMETRY WORKSPACE -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg">
                    <!-- LEFT COLUMN: DROP ZONE, CONFIGURATION & AUDIT PROVENANCE (5 Cols) -->
                    <div class="xl:col-span-5 flex flex-col gap-space-lg">
                        <!-- Staged File Status & Industrial Dropzone -->
                        <div class="bg-surface-container-low p-space-lg rounded-xl flex flex-col gap-space-md shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-primary text-[20px]">upload_file</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Ingested Staging Buffer</span>
                                </div>
                                <span class="px-space-xs py-0.5 rounded font-label-sm text-label-sm bg-surface-container-high text-primary font-mono uppercase">
                                    STATUS: BUFFERED
                                </span>
                            </div>
                            <!-- Drop Box Visual Area -->
                            <div class="relative bg-surface-container-lowest p-space-md rounded-lg flex flex-col gap-space-sm">
                                <div class="flex items-start justify-between gap-space-sm">
                                    <div class="flex items-center gap-space-sm min-w-0">
                                        <div class="w-10 h-10 rounded bg-primary-container flex items-center justify-center flex-shrink-0">
                                            <span class="material-symbols-outlined text-primary text-[22px]">table_chart</span>
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="font-label-lg text-label-lg text-on-surface truncate font-mono">churn_features_engineered_v2.csv</span>
                                            <span class="font-body-sm text-body-sm text-outline">4.88 MB · 10,480 rows · 24 columns · Ingested via SSL</span>
                                        </div>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container-high text-primary font-label-sm text-label-sm font-mono flex-shrink-0">100%</span>
                                </div>
                                <!-- Progress Bar Meter -->
                                <div class="w-full bg-surface-container h-1.5 rounded-full overflow-hidden">
                                    <div class="bg-primary h-full w-full"></div>
                                </div>
                                <div class="flex items-center justify-between font-label-sm text-label-sm font-mono text-outline pt-space-2xs">
                                    <span class="truncate">SHA-256: 4f8a2b7e...c91d4e08 (VERIFIED)</span>
                                    <span class="text-tertiary font-semibold flex items-center gap-space-2xs flex-shrink-0">
                                        <span class="material-symbols-outlined text-[14px]">check_circle</span> READY
                                    </span>
                                </div>
                            </div>
                            <!-- Auxiliary Action Triggers -->
                            <div class="flex items-center justify-between gap-space-sm pt-space-xs">
                                <button class="flex items-center gap-space-2xs text-secondary hover:text-on-surface font-label-sm text-label-sm transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">sync</span>
                                    <span>Replace Staged File</span>
                                </button>
                                <button class="flex items-center gap-space-2xs text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">attachment</span>
                                    <span>Upload Schema Dictionary (.json)</span>
                                </button>
                            </div>
                        </div>
                        <!-- Version Naming & Target Enclave Configuration -->
                        <div class="bg-surface-container-low p-space-lg rounded-xl flex flex-col gap-space-md shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-primary text-[20px]">tune</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Target Version &amp; Enclave Setup</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-outline font-mono">SPEC-V4</span>
                            </div>
                            <!-- Target Version Input -->
                            <div class="flex flex-col gap-space-2xs">
                                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Target Version Identifier</label>
                                <div class="flex items-center bg-surface-container-lowest px-space-sm py-1.5 rounded">
                                    <span class="text-outline font-mono text-body-sm mr-1">v/</span>
                                    <input class="bg-transparent text-on-surface font-mono text-body-sm flex-1 outline-none" type="text" value="churn_clean_engineered_v2" />
                                    <span class="material-symbols-outlined text-primary text-[18px]">verified</span>
                                </div>
                                <div class="flex flex-wrap items-center gap-space-2xs mt-space-2xs">
                                    <span class="font-label-sm text-label-sm text-outline">Suggested tags:</span>
                                    <button class="px-space-xs py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-primary font-mono font-label-sm text-label-sm transition-colors">+ _imputed</button>
                                    <button class="px-space-xs py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-primary font-mono font-label-sm text-label-sm transition-colors">+ _encoded</button>
                                    <button class="px-space-xs py-0.5 rounded bg-surface-container hover:bg-surface-container-high text-primary font-mono font-label-sm text-label-sm transition-colors">+ _scaled</button>
                                </div>
                            </div>
                            <!-- Base Dataset Dropdown -->
                            <div class="flex flex-col gap-space-2xs">
                                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Parent Origin / Base Dataset</label>
                                <div class="flex items-center justify-between bg-surface-container-lowest px-space-sm py-2 rounded cursor-pointer">
                                    <div class="flex items-center gap-space-xs min-w-0">
                                        <span class="material-symbols-outlined text-secondary text-[18px]">history</span>
                                        <span class="font-body-sm text-body-sm text-on-surface font-mono truncate">customers.csv (v2.1 STABLE — SYS05 CRM)</span>
                                    </div>
                                    <span class="material-symbols-outlined text-outline text-[18px]">unfold_more</span>
                                </div>
                            </div>
                            <!-- Target Environment Radio Pills -->
                            <div class="flex flex-col gap-space-2xs">
                                <label class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Deployment Tier</label>
                                <div class="grid grid-cols-1 gap-space-xs">
                                    <div class="flex items-center justify-between p-space-sm rounded bg-surface-container-high cursor-pointer">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="h-2 w-2 rounded-full bg-tertiary"></span>
                                            <span class="font-label-lg text-label-lg text-on-surface font-semibold">Development / Experimentation</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-tertiary uppercase font-mono font-bold">ACTIVE TARGET</span>
                                    </div>
                                    <div class="flex items-center justify-between p-space-sm rounded bg-surface-container-lowest opacity-60 hover:opacity-100 transition-opacity cursor-pointer">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="h-2 w-2 rounded-full bg-outline"></span>
                                            <span class="font-label-lg text-label-lg text-on-surface-variant">Staging Enclave (Pre-Prod)</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-outline font-mono">ISOLATED</span>
                                    </div>
                                    <div class="flex items-center justify-between p-space-sm rounded bg-surface-container-lowest opacity-60 hover:opacity-100 transition-opacity cursor-pointer">
                                        <div class="flex items-center gap-space-xs">
                                            <span class="h-2 w-2 rounded-full bg-outline"></span>
                                            <span class="font-label-lg text-label-lg text-on-surface-variant">Production Feature Store</span>
                                        </div>
                                        <span class="font-label-sm text-label-sm text-outline font-mono">LOCKED</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Lineage & Preprocessing Audit Log -->
                        <div class="bg-surface-container-low p-space-lg rounded-xl flex flex-col gap-space-md shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-primary text-[20px]">receipt_long</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Data Lineage &amp; Preprocessing Log</span>
                                </div>
                                <span class="px-space-xs py-0.5 rounded font-label-sm text-label-sm bg-surface-container text-tertiary font-mono">AUDIT MANDATE</span>
                            </div>
                            <div class="flex flex-col gap-space-2xs">
                                <label class="font-label-sm text-label-sm text-on-surface-variant">Declared Transformations (Immutable Provenance Record)</label>
                                <div class="bg-surface-container-lowest p-space-sm rounded font-mono text-body-sm text-on-surface leading-relaxed flex flex-col gap-space-xs">
                                    <div class="flex items-start gap-space-xs">
                                        <span class="text-tertiary">01.</span>
                                        <span class="text-on-surface-variant">Imputed missing <code class="text-primary bg-surface-container px-1 py-0.2 rounded">support_tickets_l90d</code> using cohort median (<code class="text-on-surface font-semibold">median=1</code>).</span>
                                    </div>
                                    <div class="flex items-start gap-space-xs">
                                        <span class="text-tertiary">02.</span>
                                        <span class="text-on-surface-variant">One-hot encoded <code class="text-primary bg-surface-container px-1 py-0.2 rounded">industry_sector</code> (5 sparse vectors) and <code class="text-primary bg-surface-container px-1 py-0.2 rounded">service_tier</code> (ordinal 1-3).</span>
                                    </div>
                                    <div class="flex items-start gap-space-xs">
                                        <span class="text-tertiary">03.</span>
                                        <span class="text-on-surface-variant">Generated interaction: <code class="text-primary bg-surface-container px-1 py-0.2 rounded">spend_tenure_ratio = monthly_spend_eur / (account_age_months + 1)</code>.</span>
                                    </div>
                                    <div class="flex items-start gap-space-xs">
                                        <span class="text-tertiary">04.</span>
                                        <span class="text-on-surface-variant">Clipped high-side outliers for <code class="text-primary bg-surface-container px-1 py-0.2 rounded">monthly_spend_eur</code> beyond 99th percentile (€4,150.00).</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-space-xs bg-surface-container-high px-space-sm py-space-xs rounded">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-outline text-[16px]">fingerprint</span>
                                    <span class="font-label-sm text-label-sm text-on-surface">Operator: Intern AI Engineer (ENG-09412)</span>
                                </div>
                                <span class="font-label-sm text-label-sm text-secondary font-mono">CLEARANCE: LVL-2</span>
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT COLUMN: VALIDATION GATEKEEPER & SCHEMA DIFF MATRIX (7 Cols) -->
                    <div class="xl:col-span-7 flex flex-col gap-space-lg">
                        <!-- Automated Pre-Flight Gatekeeper Telemetry -->
                        <div class="bg-surface-container-low p-space-lg rounded-xl flex flex-col gap-space-md shadow-sm">
                            <div class="flex flex-wrap items-center justify-between gap-space-sm">
                                <div class="flex items-center gap-space-sm">
                                    <div class="w-8 h-8 rounded bg-primary-container flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary text-[20px]">verified_user</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline-sm text-headline-sm text-on-surface">Automated Pre-Flight Gatekeeper V4.2</span>
                                        <span class="font-body-sm text-body-sm text-outline">Real-time deep invariant schema &amp; statistical integrity audit</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-space-xs px-space-sm py-1 rounded bg-surface-container-high">
                                    <span class="h-2 w-2 rounded-full bg-primary"></span>
                                    <span class="font-label-sm text-label-sm text-on-surface font-mono font-bold">6 / 6 AUDITS PASSED</span>
                                    <span class="text-tertiary font-label-sm text-label-sm font-mono">(1 ADVISORY)</span>
                                </div>
                            </div>
                            <!-- Gatekeeper Metric Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-space-xs">
                                <!-- Check 1 -->
                                <div class="bg-surface-container-lowest p-space-sm rounded flex items-start justify-between gap-space-sm">
                                    <div class="flex items-start gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">key</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-lg text-label-lg text-on-surface font-semibold">Primary Key Uniqueness</span>
                                            <span class="font-body-sm text-body-sm text-outline">Col: <code class="text-secondary font-mono">cus_id</code> · 10,480 unique keys</span>
                                        </div>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded font-label-sm text-label-sm bg-primary-container text-primary font-mono font-bold">0 COLLISIONS</span>
                                </div>
                                <!-- Check 2 -->
                                <div class="bg-surface-container-lowest p-space-sm rounded flex items-start justify-between gap-space-sm">
                                    <div class="flex items-start gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">filter_alt_off</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-lg text-label-lg text-on-surface font-semibold">Null Constraint Assertion</span>
                                            <span class="font-body-sm text-body-sm text-outline">0 unhandled NaNs in core matrix</span>
                                        </div>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded font-label-sm text-label-sm bg-primary-container text-primary font-mono font-bold">PASS 100%</span>
                                </div>
                                <!-- Check 3 -->
                                <div class="bg-surface-container-lowest p-space-sm rounded flex items-start justify-between gap-space-sm">
                                    <div class="flex items-start gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">schema</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-lg text-label-lg text-on-surface font-semibold">Type Consistency Match</span>
                                            <span class="font-body-sm text-body-sm text-outline">24/24 columns conform to spec</span>
                                        </div>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded font-label-sm text-label-sm bg-primary-container text-primary font-mono font-bold">CONGRUENT</span>
                                </div>
                                <!-- Check 4 -->
                                <div class="bg-surface-container-lowest p-space-sm rounded flex items-start justify-between gap-space-sm">
                                    <div class="flex items-start gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">format_list_numbered</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-lg text-label-lg text-on-surface font-semibold">Row Count Parity</span>
                                            <span class="font-body-sm text-body-sm text-outline">10,480 / 10,480 original preserved</span>
                                        </div>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded font-label-sm text-label-sm bg-primary-container text-primary font-mono font-bold">0 DROPPED</span>
                                </div>
                                <!-- Check 5 -->
                                <div class="bg-surface-container-lowest p-space-sm rounded flex items-start justify-between gap-space-sm">
                                    <div class="flex items-start gap-space-xs">
                                        <span class="material-symbols-outlined text-primary text-[18px] mt-0.5">stacked_bar_chart</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-lg text-label-lg text-on-surface font-semibold">Value Range Clamping</span>
                                            <span class="font-body-sm text-body-sm text-outline">Z-scores within standard bounds [-3.8, +4.1]</span>
                                        </div>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded font-label-sm text-label-sm bg-primary-container text-primary font-mono font-bold">NOMINAL</span>
                                </div>
                                <!-- Check 6: Advisory -->
                                <div class="bg-surface-container-lowest p-space-sm rounded flex items-start justify-between gap-space-sm">
                                    <div class="flex items-start gap-space-xs">
                                        <span class="material-symbols-outlined text-tertiary text-[18px] mt-0.5">warning</span>
                                        <div class="flex flex-col">
                                            <span class="font-label-lg text-label-lg text-on-surface font-semibold">Target Drift Advisory</span>
                                            <span class="font-body-sm text-body-sm text-outline">Class split: 85.0% retained / 15.0% churn</span>
                                        </div>
                                    </div>
                                    <span class="px-space-xs py-0.5 rounded font-label-sm text-label-sm bg-tertiary-container text-tertiary font-mono font-bold">NEUTRAL ADVISORY</span>
                                </div>
                            </div>
                        </div>
                        <!-- Schema Comparison Diff Matrix & Inspection Panel -->
                        <div class="bg-surface-container-low p-space-lg rounded-xl flex flex-col gap-space-md shadow-sm">
                            <div class="flex flex-wrap items-center justify-between gap-space-sm">
                                <div class="flex items-center gap-space-xs">
                                    <span class="material-symbols-outlined text-primary text-[20px]">difference</span>
                                    <span class="font-headline-sm text-headline-sm text-on-surface">Differential Schema Analyzer</span>
                                </div>
                                <!-- View Tabs -->
                                <div class="flex items-center bg-surface-container-lowest p-space-2xs rounded font-label-sm text-label-sm">
                                    <button class="px-space-sm py-1 rounded bg-surface-container-high text-on-surface font-semibold">
                                        Schema Diff (24 Cols)
                                    </button>
                                    <button class="px-space-sm py-1 text-on-surface-variant hover:text-on-surface transition-colors">
                                        Data Preview (Top 5)
                                    </button>
                                    <button class="px-space-sm py-1 text-on-surface-variant hover:text-on-surface transition-colors">
                                        Summary Statistics
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-body-sm font-body-sm text-outline">
                                <div class="flex items-center gap-space-md">
                                    <span class="flex items-center gap-space-2xs">
                                        <span class="h-2 w-2 rounded-full bg-primary"></span>
                                        <span class="text-on-surface-variant">Base: customers.csv (v2.1)</span>
                                    </span>
                                    <span class="text-outline font-mono">VS</span>
                                    <span class="flex items-center gap-space-2xs">
                                        <span class="h-2 w-2 rounded-full bg-tertiary"></span>
                                        <span class="text-on-surface-variant">Staged: churn_clean_engineered_v2</span>
                                    </span>
                                </div>
                                <span class="font-mono text-label-sm text-label-sm text-outline">+3 Engineered · 2 Transformed</span>
                            </div>
                            <!-- High-Density Telemetry Table -->
                            <div class="overflow-x-auto rounded-lg bg-surface-container-lowest">
                                <table class="w-full text-left font-body-sm text-body-sm border-collapse">
                                    <thead>
                                        <tr class="bg-surface-container text-outline font-label-sm text-label-sm uppercase tracking-wider">
                                            <th class="py-2.5 px-space-sm">Status</th>
                                            <th class="py-2.5 px-space-sm">Feature Name</th>
                                            <th class="py-2.5 px-space-sm">Base Type &amp; Nulls</th>
                                            <th class="py-2.5 px-space-sm">New Type &amp; Nulls</th>
                                            <th class="py-2.5 px-space-sm">Transformation Flag</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-surface-container font-mono text-[13px]">
                                        <!-- Row 1: Primary Key -->
                                        <tr class="hover:bg-surface-container-high/40 transition-colors">
                                            <td class="py-2 px-space-sm">
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container text-outline font-bold text-label-sm">=</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-on-surface font-semibold">cus_id</td>
                                            <td class="py-2 px-space-sm text-outline">INT4 · 0 nulls</td>
                                            <td class="py-2 px-space-sm text-on-surface">INT4 · 0 nulls</td>
                                            <td class="py-2 px-space-sm">
                                                <span class="px-space-xs py-0.5 rounded bg-surface-container text-outline font-label-sm text-label-sm">PRIMARY KEY</span>
                                            </td>
                                        </tr>
                                        <!-- Row 2: Company Name -->
                                        <tr class="hover:bg-surface-container-high/40 transition-colors">
                                            <td class="py-2 px-space-sm">
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container text-outline font-bold text-label-sm">=</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-on-surface">company_name</td>
                                            <td class="py-2 px-space-sm text-outline">VARCHAR · 0 nulls</td>
                                            <td class="py-2 px-space-sm text-on-surface">VARCHAR · 0 nulls</td>
                                            <td class="py-2 px-space-sm text-outline font-body-sm">Unchanged</td>
                                        </tr>
                                        <!-- Row 3: Industry Sector (Modified) -->
                                        <tr class="bg-surface-container-high/20 hover:bg-surface-container-high/40 transition-colors">
                                            <td class="py-2 px-space-sm">
                                                <span class="px-1.5 py-0.5 rounded bg-secondary-container text-secondary font-bold text-label-sm">~</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-primary font-semibold">industry_sector</td>
                                            <td class="py-2 px-space-sm text-outline">VARCHAR · 0 nulls</td>
                                            <td class="py-2 px-space-sm text-on-surface">VARCHAR + 5 DUMMIES</td>
                                            <td class="py-2 px-space-sm">
                                                <span class="px-space-xs py-0.5 rounded bg-secondary-container text-secondary font-label-sm text-label-sm">ONE-HOT ENCODED</span>
                                            </td>
                                        </tr>
                                        <!-- Row 4: Monthly Spend (Modified) -->
                                        <tr class="bg-surface-container-high/20 hover:bg-surface-container-high/40 transition-colors">
                                            <td class="py-2 px-space-sm">
                                                <span class="px-1.5 py-0.5 rounded bg-secondary-container text-secondary font-bold text-label-sm">~</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-primary font-semibold">monthly_spend_eur</td>
                                            <td class="py-2 px-space-sm text-error font-semibold">NUMERIC · 4 nulls</td>
                                            <td class="py-2 px-space-sm text-on-surface">NUMERIC · 0 nulls</td>
                                            <td class="py-2 px-space-sm">
                                                <span class="px-space-xs py-0.5 rounded bg-secondary-container text-secondary font-label-sm text-label-sm">IMPUTED &amp; CLIPPED</span>
                                            </td>
                                        </tr>
                                        <!-- Row 5: Account Age -->
                                        <tr class="hover:bg-surface-container-high/40 transition-colors">
                                            <td class="py-2 px-space-sm">
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container text-outline font-bold text-label-sm">=</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-on-surface">account_age_months</td>
                                            <td class="py-2 px-space-sm text-outline">INT4 · 0 nulls</td>
                                            <td class="py-2 px-space-sm text-on-surface">INT4 · 0 nulls</td>
                                            <td class="py-2 px-space-sm text-outline font-body-sm">Unchanged</td>
                                        </tr>
                                        <!-- Row 6: Spend Tenure Ratio (New) -->
                                        <tr class="bg-primary-container/20 hover:bg-primary-container/30 transition-colors">
                                            <td class="py-2 px-space-sm">
                                                <span class="px-1.5 py-0.5 rounded bg-tertiary-container text-tertiary font-bold text-label-sm">+</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-tertiary font-semibold">spend_tenure_ratio</td>
                                            <td class="py-2 px-space-sm text-outline italic">— NOT IN BASE —</td>
                                            <td class="py-2 px-space-sm text-on-surface">FLOAT64 · 0 nulls</td>
                                            <td class="py-2 px-space-sm">
                                                <span class="px-space-xs py-0.5 rounded bg-tertiary-container text-tertiary font-label-sm text-label-sm">SYNTHETIC RATIO</span>
                                            </td>
                                        </tr>
                                        <!-- Row 7: Ticket Urgency (New) -->
                                        <tr class="bg-primary-container/20 hover:bg-primary-container/30 transition-colors">
                                            <td class="py-2 px-space-sm">
                                                <span class="px-1.5 py-0.5 rounded bg-tertiary-container text-tertiary font-bold text-label-sm">+</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-tertiary font-semibold">ticket_urgency_score</td>
                                            <td class="py-2 px-space-sm text-outline italic">— NOT IN BASE —</td>
                                            <td class="py-2 px-space-sm text-on-surface">FLOAT64 · [0.0 - 1.0]</td>
                                            <td class="py-2 px-space-sm">
                                                <span class="px-space-xs py-0.5 rounded bg-tertiary-container text-tertiary font-label-sm text-label-sm">MIN-MAX SCALED</span>
                                            </td>
                                        </tr>
                                        <!-- Row 8: Enterprise Tier Flag (New) -->
                                        <tr class="bg-primary-container/20 hover:bg-primary-container/30 transition-colors">
                                            <td class="py-2 px-space-sm">
                                                <span class="px-1.5 py-0.5 rounded bg-tertiary-container text-tertiary font-bold text-label-sm">+</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-tertiary font-semibold">is_enterprise_tier</td>
                                            <td class="py-2 px-space-sm text-outline italic">— NOT IN BASE —</td>
                                            <td class="py-2 px-space-sm text-on-surface">BOOLEAN · 0 nulls</td>
                                            <td class="py-2 px-space-sm">
                                                <span class="px-space-xs py-0.5 rounded bg-tertiary-container text-tertiary font-label-sm text-label-sm">DERIVED BINARY</span>
                                            </td>
                                        </tr>
                                        <!-- Row 9: Churn Label -->
                                        <tr class="hover:bg-surface-container-high/40 transition-colors">
                                            <td class="py-2 px-space-sm">
                                                <span class="px-1.5 py-0.5 rounded bg-surface-container text-outline font-bold text-label-sm">=</span>
                                            </td>
                                            <td class="py-2 px-space-sm text-on-surface font-semibold">churn_label</td>
                                            <td class="py-2 px-space-sm text-outline">INT2 (0/1) · 0 nulls</td>
                                            <td class="py-2 px-space-sm text-on-surface">INT2 (0/1) · 0 nulls</td>
                                            <td class="py-2 px-space-sm">
                                                <span class="px-space-xs py-0.5 rounded bg-primary-container text-primary font-label-sm text-label-sm">TARGET PRESERVED</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex items-center justify-between font-label-sm text-label-sm text-outline px-space-xs pt-space-xs">
                                <span>Showing 9 of 24 schema attributes</span>
                                <a class="text-secondary hover:text-on-surface transition-colors flex items-center gap-space-2xs" href="#">
                                    <span>Expand Full 24-Column Data Dictionary</span>
                                    <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BOTTOM AUDIT LEDGER NOTICE & WORKFLOW ACTION FOOTER -->
                <div class="mt-space-lg flex flex-col gap-space-sm">
                    <div class="flex flex-wrap items-center justify-between gap-space-md bg-surface-container-high p-space-md rounded-lg shadow-md">
                        <!-- Immutable Audit Trace Pill -->
                        <div class="flex items-center gap-space-sm min-w-0">
                            <div class="w-8 h-8 rounded bg-surface-container-lowest flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-tertiary text-[18px]">verified</span>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="font-label-lg text-label-lg text-on-surface flex items-center gap-space-2xs">
                                    <span>Security Ledger Audit Event #ING-8824</span>
                                    <span class="px-space-xs py-0.5 rounded bg-surface-container text-primary font-mono text-[10px]">IMMUTABLE WORM</span>
                                </span>
                                <span class="font-body-sm text-body-sm text-outline truncate">
                                    Destination: SYS-AI-03 Workbench &amp; Feature Store · SHA: <code class="text-secondary font-mono">4f8a2b...c91d</code> verified
                                </span>
                            </div>
                        </div>
                        <!-- Final Dispatch Controls -->
                        <div class="flex items-center gap-space-sm flex-shrink-0">
                            <button class="px-space-md py-2 rounded font-label-lg text-label-lg bg-surface-container text-on-surface-variant hover:text-on-surface transition-colors">
                                Return to Catalog
                            </button>
                            <button class="px-space-md py-2 rounded font-label-lg text-label-lg bg-secondary-container text-on-surface hover:bg-surface-variant transition-colors flex items-center gap-space-xs">
                                <span class="material-symbols-outlined text-[16px]">save</span>
                                <span>Save as Draft</span>
                            </button>
                            <button class="px-space-lg py-2 rounded font-label-lg text-label-lg bg-tertiary text-on-tertiary font-semibold hover:bg-tertiary-fixed transition-colors flex items-center gap-space-xs shadow-lg">
                                <span>Commit to Pipeline &amp; Open Workbench</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </button>
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