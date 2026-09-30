<?php
/**
 * VOSTOKPRIBOR AI • Mission Control Portal & Avionics Dispatch
 * Central gateway to all 5 AI subsystems with live telemetry & data exchange.
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/db/db.php';
apply_perf_headers();

$isDbLive = VostokDB::isLive();
$systems = $GLOBALS['VOSTOK_SYSTEMS'];
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>VOSTOKPRIBOR AI • Mission Control & Avionics Portal</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&amp;family=IBM+Plex+Mono:wght@400;500;600;700&amp;family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/global.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="assets/js/portal.js"></script>
</head>
<body class="bg-background text-on-surface antialiased min-h-screen selection:bg-tertiary-container selection:text-tertiary font-sans bg-radial-glow">

    <!-- Mission Control Top Navigation Bar -->
    <header class="sticky top-0 z-50 bg-[#000f21]/95 backdrop-blur-xl border-b border-[#1f3651] shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between gap-6">
            <!-- Brand & Node Status -->
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-tertiary-container border border-tertiary/40 flex items-center justify-center text-tertiary shadow-[0_0_16px_rgba(255,185,86,0.3)]">
                    <span class="material-symbols-outlined text-2xl">satellite_alt</span>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="text-base font-bold font-mono tracking-wider uppercase text-white">VOSTOKPRIBOR AI</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-tertiary-container text-tertiary border border-tertiary/40 font-semibold">AVIONICS v4.8</span>
                    </div>
                    <span class="text-xs text-[#8e9197] font-mono">Mission Control & Aerospace ML Architecture</span>
                </div>
            </div>

            <!-- Central Telemetry Bar -->
            <div class="hidden lg:flex items-center gap-4 bg-[#06203a] px-4 py-2 rounded-xl border border-[#1f3651] text-xs font-mono">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-white font-semibold">ORB-NODE-09</span>
                </div>
                <span class="text-[#43474c]">|</span>
                <div class="text-[#c4c6cd]">Compute: <strong class="text-tertiary">88.4 TFLOPS</strong></div>
                <span class="text-[#43474c]">|</span>
                <div class="text-[#c4c6cd]">VRAM: <strong class="text-white">78.4 / 80 GB</strong></div>
                <span class="text-[#43474c]">|</span>
                <div class="text-[#c4c6cd]">Mesh Latency: <strong class="text-secondary">12ms</strong></div>
            </div>

            <!-- DB Status Badge & Utility Buttons -->
            <div class="flex items-center gap-3">
                <a href="db/init.php" class="flex items-center gap-2 px-3 py-1.5 rounded-lg border text-xs font-mono transition-all <?= $isDbLive ? 'bg-emerald-950/70 border-emerald-500/50 text-emerald-300 hover:bg-emerald-900/80' : 'bg-amber-950/70 border-amber-500/50 text-amber-300 hover:bg-amber-900/80' ?>" title="Click to view Database Setup / Status">
                    <span class="w-2 h-2 rounded-full <?= $isDbLive ? 'bg-emerald-400' : 'bg-amber-400 animate-ping' ?>"></span>
                    <span><?= $isDbLive ? 'DB: MYSQL CONNECTED' : 'DB: SIMULATED (SETUP)' ?></span>
                </a>
                <button class="px-3 py-1.5 rounded-lg bg-[#06203a] border border-[#1f3651] text-xs font-mono text-[#c4c6cd] hover:text-white transition-all">
                    EN / AR
                </button>
                <button onclick="window.openVostokModal('vostok-quick-switcher')" class="px-3 py-1.5 rounded-lg bg-tertiary-container border border-tertiary/40 text-xs font-mono text-tertiary font-bold hover:bg-tertiary hover:text-[#331e00] transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm">terminal</span>
                    <span>CMD+K</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-6 py-12">
        <!-- Hero Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-tertiary mb-2">
                    <span class="material-symbols-outlined text-base">hub</span>
                    <span>Subsystems Dispatch Matrix • Level 3 Flight Deck</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold font-mono tracking-tight text-white leading-tight">
                    AVIONICS MISSION CONTROL
                </h1>
                <p class="text-sm md:text-base text-[#c4c6cd] mt-3 max-w-2xl leading-relaxed">
                    Select a subsystem below to launch into operational flight consoles, telemetry streams, data lineage graphs, or production model canary gates.
                </p>
            </div>
            <!-- Quick Filter Input -->
            <div class="relative w-full md:w-80">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#8e9197] text-lg">search</span>
                <input id="system-search" type="text" placeholder="Filter systems or views..." 
                    class="w-full bg-[#000f21] border border-[#1f3651] rounded-xl pl-10 pr-4 py-2.5 text-xs font-mono text-white placeholder-[#8e9197] focus:border-tertiary outline-none transition-colors" />
            </div>
        </div>

        <!-- 5-Systems Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="systems-grid">
            
            <!-- SYS-AI-01: AI Project Management -->
            <div class="vostok-card p-6 flex flex-col justify-between group relative overflow-hidden" data-keywords="projects tasks kanban deliverables evaluation gradebook instructor">
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-secondary/5 rounded-full blur-2xl pointer-events-none"></div>
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-secondary-container border border-secondary/40 flex items-center justify-center text-secondary group-hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-2xl">folder_special</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-secondary tracking-widest block uppercase">SYS-AI-01</span>
                                <h2 class="text-lg font-bold font-mono text-white group-hover:text-tertiary transition-colors">AI Project Management</h2>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-emerald-950/80 text-emerald-400 border border-emerald-500/40 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            OPERATIONAL
                        </span>
                    </div>

                    <p class="text-xs text-[#c4c6cd] leading-relaxed mb-4">
                        Track agile engineering milestones, deliverable submissions, grading rubrics, sprint velocity, and cadet ticket boards.
                    </p>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-3 gap-2 p-3 rounded-lg bg-[#000f21] border border-[#132b45] text-center font-mono text-[11px] mb-5">
                        <div>
                            <span class="text-[#8e9197] text-[10px] block">TASKS</span>
                            <strong class="text-white">24 Active</strong>
                        </div>
                        <div class="border-x border-[#132b45]">
                            <span class="text-[#8e9197] text-[10px] block">SPRINT</span>
                            <strong class="text-emerald-400">94.2%</strong>
                        </div>
                        <div>
                            <span class="text-[#8e9197] text-[10px] block">REVIEWS</span>
                            <strong class="text-secondary">18 Done</strong>
                        </div>
                    </div>

                    <!-- Subpage Direct Links -->
                    <div class="mb-5">
                        <span class="text-[10px] uppercase font-mono text-[#8e9197] tracking-wider block mb-2">Operational Sub-Views</span>
                        <div class="flex flex-wrap gap-1.5 text-xs">
                            <a href="AI Project Management/Dashboard.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Dashboard</a>
                            <a href="AI Project Management/DeliverablesAndSubmissionPanel.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Deliverables</a>
                            <a href="AI Project Management/TicketBoard.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Ticket Board</a>
                            <a href="AI Project Management/InstructorDashboard.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Instructor</a>
                            <a href="AI Project Management/EvaluationView.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Evaluation</a>
                        </div>
                    </div>
                </div>

                <a href="AI Project Management/Dashboard.php" class="w-full py-2.5 rounded-lg bg-secondary-container hover:bg-secondary text-[#00142a] hover:text-[#000f21] font-bold text-xs font-mono transition-all flex items-center justify-center gap-2 shadow-md">
                    <span>Launch Projects System</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- SYS-AI-02: Data Center -->
            <div class="vostok-card p-6 flex flex-col justify-between group relative overflow-hidden" data-keywords="data center datasets lineage sql catalog query feature store ingest">
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-primary/5 rounded-full blur-2xl pointer-events-none"></div>
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#0f2438] border border-primary/40 flex items-center justify-center text-primary group-hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-2xl">dataset</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-primary tracking-widest block uppercase">SYS-AI-02</span>
                                <h2 class="text-lg font-bold font-mono text-white group-hover:text-tertiary transition-colors">Data Center</h2>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-emerald-950/80 text-emerald-400 border border-emerald-500/40 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            SYNCED
                        </span>
                    </div>

                    <p class="text-xs text-[#c4c6cd] leading-relaxed mb-4">
                        High-throughput feature store, provenance lineage DAG graphs, Trino/DuckDB SQL studio, and immutable ingest pipelines.
                    </p>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-3 gap-2 p-3 rounded-lg bg-[#000f21] border border-[#132b45] text-center font-mono text-[11px] mb-5">
                        <div>
                            <span class="text-[#8e9197] text-[10px] block">INGEST</span>
                            <strong class="text-white">1.4 TB</strong>
                        </div>
                        <div class="border-x border-[#132b45]">
                            <span class="text-[#8e9197] text-[10px] block">FEATURES</span>
                            <strong class="text-primary">24 Tables</strong>
                        </div>
                        <div>
                            <span class="text-[#8e9197] text-[10px] block">LINEAGE</span>
                            <strong class="text-emerald-400">100% DAG</strong>
                        </div>
                    </div>

                    <!-- Subpage Direct Links -->
                    <div class="mb-5">
                        <span class="text-[10px] uppercase font-mono text-[#8e9197] tracking-wider block mb-2">Operational Sub-Views</span>
                        <div class="flex flex-wrap gap-1.5 text-xs">
                            <a href="Data Center/DatasetCatalog.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Catalog</a>
                            <a href="Data Center/DatasetDetail.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Detail</a>
                            <a href="Data Center/DataLineageAndAuditHistory.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Lineage Graph</a>
                            <a href="Data Center/QueryWorkspace.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">SQL Studio</a>
                            <a href="Data Center/UploadProcessedData.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Upload</a>
                        </div>
                    </div>
                </div>

                <a href="Data Center/DatasetCatalog.php" class="w-full py-2.5 rounded-lg bg-[#0f2438] hover:bg-primary border border-primary/40 text-primary hover:text-[#00142a] font-bold text-xs font-mono transition-all flex items-center justify-center gap-2 shadow-md">
                    <span>Launch Data Center</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- SYS-AI-03: AI/ML Workbench -->
            <div class="vostok-card p-6 flex flex-col justify-between group relative overflow-hidden" data-keywords="workbench experiments models training hyperparameter ml lineage agents llm">
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-tertiary/10 rounded-full blur-2xl pointer-events-none"></div>
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-tertiary-container border border-tertiary/50 flex items-center justify-center text-tertiary group-hover:scale-105 transition-transform shadow-[0_0_12px_rgba(255,185,86,0.3)]">
                                <span class="material-symbols-outlined text-2xl">precision_manufacturing</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-tertiary tracking-widest block uppercase">SYS-AI-03</span>
                                <h2 class="text-lg font-bold font-mono text-white group-hover:text-tertiary transition-colors">AI/ML Workbench</h2>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-tertiary-container text-tertiary border border-tertiary/50 flex items-center gap-1 font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary animate-pulse"></span>
                            ENGAGED
                        </span>
                    </div>

                    <p class="text-xs text-[#c4c6cd] leading-relaxed mb-4">
                        Exploratory model training, hyperparameter optimization, ROC/PR curves, multi-run diff comparisons, and GenAI agent chains.
                    </p>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-3 gap-2 p-3 rounded-lg bg-[#000f21] border border-[#132b45] text-center font-mono text-[11px] mb-5">
                        <div>
                            <span class="text-[#8e9197] text-[10px] block">RUNS</span>
                            <strong class="text-white">18 Active</strong>
                        </div>
                        <div class="border-x border-[#132b45]">
                            <span class="text-[#8e9197] text-[10px] block">CHAMPION</span>
                            <strong class="text-tertiary">0.884 F1</strong>
                        </div>
                        <div>
                            <span class="text-[#8e9197] text-[10px] block">CLUSTER</span>
                            <strong class="text-emerald-400">88.4 TF</strong>
                        </div>
                    </div>

                    <!-- Subpage Direct Links -->
                    <div class="mb-5">
                        <span class="text-[10px] uppercase font-mono text-[#8e9197] tracking-wider block mb-2">Operational Sub-Views</span>
                        <div class="flex flex-wrap gap-1.5 text-xs">
                            <a href="AI/ML Workbench/WorkbenchHome.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Workbench Home</a>
                            <a href="AI/ML Workbench/ExperimentBuilder.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Builder</a>
                            <a href="AI/ML Workbench/CompareRuns.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Compare Runs</a>
                            <a href="AI/ML Workbench/RunResults.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Metrics</a>
                            <a href="AI/ML Workbench/GenAI_AndAgentWorkbench.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">GenAI Agents</a>
                        </div>
                    </div>
                </div>

                <a href="AI/ML Workbench/WorkbenchHome.php" class="w-full py-2.5 rounded-lg bg-tertiary hover:bg-tertiary-fixed text-[#331e00] font-bold text-xs font-mono transition-all flex items-center justify-center gap-2 shadow-lg shadow-tertiary/20">
                    <span>Launch ML Workbench</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- SYS-AI-04: Model Registry & Deployment -->
            <div class="vostok-card p-6 flex flex-col justify-between group relative overflow-hidden" data-keywords="registry deployment endpoints triton swagger canary rollback cards gateway">
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-secondary/5 rounded-full blur-2xl pointer-events-none"></div>
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#132b45] border border-secondary/40 flex items-center justify-center text-secondary group-hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-2xl">rocket_launch</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-secondary tracking-widest block uppercase">SYS-AI-04</span>
                                <h2 class="text-lg font-bold font-mono text-white group-hover:text-tertiary transition-colors">Registry & Deployment</h2>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-emerald-950/80 text-emerald-400 border border-emerald-500/40 flex items-center gap-1 font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            CANARY GATE
                        </span>
                    </div>

                    <p class="text-xs text-[#c4c6cd] leading-relaxed mb-4">
                        Production gates, Triton ONNX endpoints, Swagger inference test console, model cards, and automated rollbacks.
                    </p>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-3 gap-2 p-3 rounded-lg bg-[#000f21] border border-[#132b45] text-center font-mono text-[11px] mb-5">
                        <div>
                            <span class="text-[#8e9197] text-[10px] block">ENDPOINTS</span>
                            <strong class="text-white">12 Pods</strong>
                        </div>
                        <div class="border-x border-[#132b45]">
                            <span class="text-[#8e9197] text-[10px] block">GATE</span>
                            <strong class="text-tertiary">10% Canary</strong>
                        </div>
                        <div>
                            <span class="text-[#8e9197] text-[10px] block">LATENCY</span>
                            <strong class="text-secondary">11.4 ms</strong>
                        </div>
                    </div>

                    <!-- Subpage Direct Links -->
                    <div class="mb-5">
                        <span class="text-[10px] uppercase font-mono text-[#8e9197] tracking-wider block mb-2">Operational Sub-Views</span>
                        <div class="flex flex-wrap gap-1.5 text-xs">
                            <a href="Model Registry & Deployment/ModelRegistry.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Registry</a>
                            <a href="Model Registry & Deployment/ModelCard.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-tertiary hover:text-white border border-tertiary/40 transition-colors font-semibold">Model Card (v2)</a>
                            <a href="Model Registry & Deployment/DeploymentWizard.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Deploy Wizard</a>
                            <a href="Model Registry & Deployment/EndpointConsole.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Console</a>
                            <a href="Model Registry & Deployment/DeploymentHistoryRollback.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Rollback</a>
                        </div>
                    </div>
                </div>

                <a href="Model Registry & Deployment/ModelRegistry.php" class="w-full py-2.5 rounded-lg bg-[#132b45] hover:bg-secondary text-secondary hover:text-[#00142a] border border-secondary/40 font-bold text-xs font-mono transition-all flex items-center justify-center gap-2 shadow-md">
                    <span>Launch Registry & Deploy</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- SYS-AI-05: AI Operations Center (AI SOC) -->
            <div class="vostok-card p-6 flex flex-col justify-between group relative overflow-hidden" data-keywords="soc telemetry drift triage war room incident alert monitoring post-mortem">
                <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-error/10 rounded-full blur-2xl pointer-events-none"></div>
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-error-container border border-error/50 flex items-center justify-center text-error group-hover:scale-105 transition-transform shadow-[0_0_15px_rgba(255,180,171,0.25)]">
                                <span class="material-symbols-outlined text-2xl">shield_with_heart</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-error tracking-widest block uppercase">SYS-AI-05</span>
                                <h2 class="text-lg font-bold font-mono text-white group-hover:text-tertiary transition-colors">AI SOC Center</h2>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-error-container text-error border border-error/50 flex items-center gap-1 font-bold animate-pulse">
                            <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                            INCIDENT ACTIVE
                        </span>
                    </div>

                    <p class="text-xs text-[#c4c6cd] leading-relaxed mb-4">
                        24/7 mission telemetry wall display, Kolmogorov-Smirnov drift investigation, real-time alert triage, and post-mortem drills.
                    </p>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-3 gap-2 p-3 rounded-lg bg-[#000f21] border border-[#132b45] text-center font-mono text-[11px] mb-5">
                        <div>
                            <span class="text-[#8e9197] text-[10px] block">INCIDENT</span>
                            <strong class="text-error">#INC-4092</strong>
                        </div>
                        <div class="border-x border-[#132b45]">
                            <span class="text-[#8e9197] text-[10px] block">DRIFT</span>
                            <strong class="text-error">-29.8% F1</strong>
                        </div>
                        <div>
                            <span class="text-[#8e9197] text-[10px] block">LATENCY</span>
                            <strong class="text-secondary">12ms Mesh</strong>
                        </div>
                    </div>

                    <!-- Subpage Direct Links -->
                    <div class="mb-5">
                        <span class="text-[10px] uppercase font-mono text-[#8e9197] tracking-wider block mb-2">Operational Sub-Views</span>
                        <div class="flex flex-wrap gap-1.5 text-xs">
                            <a href="AI Operations Center (AI SOC)/FleetTelemetry.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Fleet Wall</a>
                            <a href="AI Operations Center (AI SOC)/IncidentTriage.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Triage</a>
                            <a href="AI Operations Center (AI SOC)/DriftInvestigationWorkspace.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-error hover:text-white border border-error/40 transition-colors">Drift Studio</a>
                            <a href="AI Operations Center (AI SOC)/IncidentWarRoom.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">War Room</a>
                            <a href="AI Operations Center (AI SOC)/IncidentPostMortem.php" class="px-2.5 py-1 rounded bg-[#06203a] hover:bg-[#132b45] text-on-surface-variant hover:text-white border border-[#1f3651] transition-colors">Post-Mortem</a>
                        </div>
                    </div>
                </div>

                <a href="AI Operations Center (AI SOC)/FleetTelemetry.php" class="w-full py-2.5 rounded-lg bg-error-container hover:bg-error text-white hover:text-black font-bold text-xs font-mono transition-all flex items-center justify-center gap-2 shadow-lg shadow-error/20">
                    <span>Launch AI SOC Flight Deck</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- SYS-EXCHANGE: Future DB & Cross-System API Hub -->
            <div class="vostok-card p-6 flex flex-col justify-between group relative overflow-hidden border border-tertiary/30 bg-[#000f21]" data-keywords="api exchange database mysql sync status cross system rest">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-tertiary-container border border-tertiary/40 flex items-center justify-center text-tertiary">
                                <span class="material-symbols-outlined text-2xl">schema</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-tertiary tracking-widest block uppercase">SYS-EXCHANGE</span>
                                <h2 class="text-lg font-bold font-mono text-white">Cross-System Exchange Hub</h2>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono <?= $isDbLive ? 'bg-emerald-950 text-emerald-400 border border-emerald-500/40' : 'bg-[#1f3651] text-secondary border border-[#43474c]' ?>">
                            REST / JSON
                        </span>
                    </div>

                    <p class="text-xs text-[#c4c6cd] leading-relaxed mb-4">
                        Unified DB & API endpoints linking Models, Datasets, Incidents, and Tickets across the entire VOSTOKPRIBOR AI avionics fleet.
                    </p>

                    <!-- API Links -->
                    <div class="space-y-2 mb-5 font-mono text-xs">
                        <a href="api/status.php" target="_blank" class="p-2 rounded bg-[#06203a] hover:bg-[#132b45] border border-[#1f3651] flex items-center justify-between text-on-surface-variant hover:text-white transition-colors">
                            <span class="flex items-center gap-2">
                                <span class="text-emerald-400 font-bold">GET</span>
                                <span>/api/status.php</span>
                            </span>
                            <span class="material-symbols-outlined text-xs">open_in_new</span>
                        </a>
                        <a href="api/exchange.php" target="_blank" class="p-2 rounded bg-[#06203a] hover:bg-[#132b45] border border-[#1f3651] flex items-center justify-between text-on-surface-variant hover:text-white transition-colors">
                            <span class="flex items-center gap-2">
                                <span class="text-tertiary font-bold">POST/GET</span>
                                <span>/api/exchange.php</span>
                            </span>
                            <span class="material-symbols-outlined text-xs">open_in_new</span>
                        </a>
                        <a href="api/models.php" target="_blank" class="p-2 rounded bg-[#06203a] hover:bg-[#132b45] border border-[#1f3651] flex items-center justify-between text-on-surface-variant hover:text-white transition-colors">
                            <span class="flex items-center gap-2">
                                <span class="text-secondary font-bold">CRUD</span>
                                <span>/api/models.php</span>
                            </span>
                            <span class="material-symbols-outlined text-xs">open_in_new</span>
                        </a>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="db/init.php" class="flex-1 py-2.5 rounded-lg bg-tertiary-container hover:bg-tertiary border border-tertiary/50 text-tertiary hover:text-[#331e00] font-bold text-xs font-mono transition-all flex items-center justify-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">settings_suggest</span>
                        <span>DB Setup & Migrations</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Cross-System Data Exchange Architecture Diagram -->
        <div class="mt-16 p-8 rounded-2xl bg-[#000f21] border border-[#1f3651] relative overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
                <div>
                    <span class="text-xs font-mono uppercase text-tertiary tracking-widest block mb-1">Architecture Overview</span>
                    <h2 class="text-2xl font-bold font-mono text-white">Cross-System Information Exchange Protocol</h2>
                    <p class="text-xs text-[#c4c6cd] mt-1 max-w-xl">
                        Models registered in ML Workbench automatically synchronize with the Model Registry, receive drift monitoring in AI SOC, and correlate with Project sprint tickets.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="api/status.php" target="_blank" class="px-4 py-2 rounded-lg bg-[#06203a] hover:bg-[#132b45] text-xs font-mono text-[#c4c6cd] hover:text-white border border-[#1f3651] transition-all">
                        View Live Telemetry JSON
                    </a>
                </div>
            </div>

            <!-- Flow Pipeline Nodes -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 relative">
                <div class="p-4 rounded-xl bg-[#06203a] border border-[#1f3651] text-center">
                    <span class="material-symbols-outlined text-secondary text-2xl mb-1">folder_special</span>
                    <div class="text-xs font-bold font-mono text-white">SYS-01 Projects</div>
                    <div class="text-[10px] text-[#8e9197] font-mono mt-1">Sprint tickets & OKRs</div>
                </div>
                <div class="p-4 rounded-xl bg-[#06203a] border border-[#1f3651] text-center">
                    <span class="material-symbols-outlined text-primary text-2xl mb-1">dataset</span>
                    <div class="text-xs font-bold font-mono text-white">SYS-02 Data Center</div>
                    <div class="text-[10px] text-[#8e9197] font-mono mt-1">Feature store & Lineage</div>
                </div>
                <div class="p-4 rounded-xl bg-[#06203a] border border-tertiary/40 text-center shadow-[0_0_12px_rgba(255,185,86,0.15)]">
                    <span class="material-symbols-outlined text-tertiary text-2xl mb-1">precision_manufacturing</span>
                    <div class="text-xs font-bold font-mono text-tertiary">SYS-03 Workbench</div>
                    <div class="text-[10px] text-[#8e9197] font-mono mt-1">Training & Model artifacts</div>
                </div>
                <div class="p-4 rounded-xl bg-[#06203a] border border-[#1f3651] text-center">
                    <span class="material-symbols-outlined text-secondary text-2xl mb-1">rocket_launch</span>
                    <div class="text-xs font-bold font-mono text-white">SYS-04 Registry</div>
                    <div class="text-[10px] text-[#8e9197] font-mono mt-1">Triton pods & Canary</div>
                </div>
                <div class="p-4 rounded-xl bg-[#06203a] border border-error/40 text-center shadow-[0_0_12px_rgba(255,180,171,0.15)]">
                    <span class="material-symbols-outlined text-error text-2xl mb-1">shield_with_heart</span>
                    <div class="text-xs font-bold font-mono text-error">SYS-05 AI SOC</div>
                    <div class="text-[10px] text-[#8e9197] font-mono mt-1">Live drift & Incident triage</div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-16 border-t border-[#1f3651] py-8 text-center text-xs font-mono text-[#8e9197]">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                <span>VOSTOKPRIBOR AI • ALL 5 SYSTEMS OPERATIONAL // CLUSTER SLA: 99.98%</span>
            </div>
            <div class="flex items-center gap-4 text-[11px]">
                <a href="db/init.php" class="hover:text-white transition-colors">Database Setup</a>
                <span>•</span>
                <a href="api/exchange.php" class="hover:text-white transition-colors">Exchange API</a>
                <span>•</span>
                <span class="text-outline">Epoch <?= time() ?></span>
            </div>
        </div>
    </footer>

    <script src="assets/js/app.js"></script>
</body>
</html>
