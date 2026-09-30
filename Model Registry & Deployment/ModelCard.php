<?php
// Model Registry & Deployment • ModelCard.php
require_once __DIR__ . '/../config/config.php';
apply_perf_headers();
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <title>Model Card // churn_rf_v2 • VOSTOKPRIBOR AI</title>
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&amp;family=IBM+Plex+Mono:wght@400;500;600&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/global.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>
<body class="bg-background font-body-md text-on-surface antialiased min-h-screen selection:bg-tertiary-container selection:text-tertiary">
    <!-- Sidebar Navigation -->
    <aside class="fixed left-0 top-0 h-full w-72 bg-surface-container-lowest border-r border-outline-variant/30 z-50 flex flex-col justify-between shadow-2xl">
        <div class="flex flex-col">
            <div class="h-28 px-space-md border-b border-outline-variant/30 flex items-center justify-between bg-surface-container-low/60">
                <a href="../index.php" class="flex items-center gap-space-sm hover:opacity-90 transition-opacity">
                    <div class="w-9 h-9 rounded bg-tertiary-container flex items-center justify-center border border-tertiary/40">
                        <span class="material-symbols-outlined text-tertiary text-xl">satellite_alt</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-headline-sm text-title-sm tracking-wider uppercase text-on-surface font-bold leading-tight">VOSTOKPRIBOR</span>
                        <div class="flex items-center gap-1 mt-0.5">
                            <span class="font-code-sm text-[10px] text-tertiary font-mono tracking-widest uppercase">SYS-AI-04</span>
                            <span class="text-outline text-[10px] font-mono">v4.8.2-rt</span>
                        </div>
                    </div>
                </a>
                <div class="flex items-center px-1.5 py-0.5 rounded bg-surface-container-high border border-outline-variant/40">
                    <span class="font-code-sm text-[10px] text-secondary font-mono">PROD</span>
                </div>
            </div>
            <div class="px-space-md pt-4 pb-2">
                <div class="text-[10px] uppercase font-mono tracking-widest text-outline mb-2">Subsystems Dispatch</div>
                <nav class="flex flex-col gap-1">
                    <a class="flex items-center justify-between px-3 py-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all group" href="../AI Project Management/Dashboard.php">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">folder_special</span>
                            <span class="font-mono text-xs text-outline">SYS-AI-01</span>
                            <span class="text-xs">Projects</span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
                    </a>
                    <a class="flex items-center justify-between px-3 py-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all group" href="../Data Center/DatasetCatalog.php">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">dataset</span>
                            <span class="font-mono text-xs text-outline">SYS-AI-02</span>
                            <span class="text-xs">Data Center</span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
                    </a>
                    <a class="flex items-center justify-between px-3 py-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all group" href="../AI/ML Workbench/WorkbenchHome.php">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">precision_manufacturing</span>
                            <span class="font-mono text-xs text-outline">SYS-AI-03</span>
                            <span class="text-xs">Workbench</span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
                    </a>
                    <a aria-current="page" class="flex items-center justify-between px-3 py-2 rounded-lg border border-outline-variant/40 bg-surface-container-high text-on-surface font-semibold shadow-inner" href="ModelRegistry.php">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-tertiary text-lg">rocket_launch</span>
                            <span class="font-mono text-xs text-tertiary">SYS-AI-04</span>
                            <span class="text-xs text-on-surface">Registry & Deploy</span>
                        </div>
                        <span class="w-2 h-2 rounded bg-tertiary shadow-[0_0_8px_rgba(255,185,86,0.8)]"></span>
                    </a>
                    <a class="flex items-center justify-between px-3 py-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all group" href="../AI Operations Center (AI SOC)/FleetTelemetry.php">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-lg">shield_with_heart</span>
                            <span class="font-mono text-xs text-outline">SYS-AI-05</span>
                            <span class="text-xs">AI SOC</span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full bg-outline-variant/60"></span>
                    </a>
                </nav>
            </div>
        </div>
        <div class="p-space-md border-t border-outline-variant/30 bg-surface-container-lowest/90">
            <div class="flex items-center justify-between p-2 rounded-lg bg-surface-container-low border border-outline-variant/20 mb-2">
                <div class="flex flex-col">
                    <span class="text-[10px] text-outline uppercase font-mono">Triton Cluster</span>
                    <span class="text-xs text-on-surface font-mono font-bold">12 Endpoints Active</span>
                </div>
                <span class="material-symbols-outlined text-secondary text-lg">memory</span>
            </div>
            <div class="flex items-center justify-between text-outline text-[11px]">
                <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>CLUSTER GATE</span>
                <span class="font-mono">NODE-04-EU</span>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="pl-72 flex flex-col min-h-screen">
        <!-- Top App Bar & Subsystem Ribbon -->
        <header class="fixed top-0 left-72 right-0 h-28 bg-surface-container-lowest/95 backdrop-blur-md border-b border-outline-variant/30 z-40 flex flex-col justify-between shadow-md">
            <div class="h-16 px-space-md flex items-center justify-between gap-space-md">
                <div class="flex items-center gap-space-md flex-1 max-w-2xl">
                    <div class="relative w-80">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">search</span>
                        <input class="w-full h-9 pl-9 pr-3 rounded bg-surface-container-low border border-outline-variant/50 text-xs font-mono text-on-surface placeholder:text-outline focus:outline-none focus:border-tertiary transition-colors" placeholder="Search parameters, features, tags... /" type="text" />
                    </div>
                    <div class="flex items-center bg-surface-container-high/60 border border-outline-variant/40 rounded px-2.5 py-1 gap-2">
                        <span class="material-symbols-outlined text-tertiary text-sm">verified</span>
                        <span class="text-xs text-on-surface-variant font-mono">#MODEL: churn_rf_v2.0 (Active Gate)</span>
                    </div>
                </div>
                <div class="flex items-center gap-space-sm">
                    <button class="px-2.5 py-1 rounded bg-surface-container-low border border-outline-variant/30 text-xs font-mono hover:text-on-surface transition-colors">EN / AR</button>
                    <button class="relative p-1.5 rounded-lg bg-surface-container-low border border-outline-variant/30 hover:border-outline text-on-surface-variant hover:text-on-surface transition-all">
                        <span class="material-symbols-outlined text-lg">notifications</span>
                        <span class="absolute top-1 right-1 w-2 h-2 rounded-full bg-tertiary"></span>
                    </button>
                    <div class="flex items-center gap-2 pl-2 border-l border-outline-variant/30">
                        <div class="flex flex-col text-right">
                            <span class="text-xs font-medium text-on-surface">Sarah Chen</span>
                            <span class="text-[10px] text-outline font-mono">Senior ML Ops #4092</span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-secondary-container border border-secondary/40 flex items-center justify-center font-bold text-secondary text-xs">
                            SC
                        </div>
                    </div>
                </div>
            </div>
            <!-- Subpage Nav -->
            <div class="h-12 px-space-md border-t border-outline-variant/20 bg-surface-container/60 flex items-center overflow-x-auto justify-between text-xs">
                <nav class="flex items-center gap-2">
                    <a class="px-3 py-1.5 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" href="ModelRegistry.php">Model Registry</a>
                    <a aria-current="page" class="px-3 py-1.5 rounded bg-surface-container-highest text-primary font-semibold border-b-2 border-tertiary" href="ModelCard.php">Model Card (churn_rf_v2)</a>
                    <a class="px-3 py-1.5 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" href="DeploymentWizard.php">Deployment Wizard</a>
                    <a class="px-3 py-1.5 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" href="EndpointConsole.php">Endpoint Console (Swagger)</a>
                    <a class="px-3 py-1.5 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" href="EnterpriseIntegrations.php">Enterprise Integrations</a>
                    <a class="px-3 py-1.5 rounded text-on-surface-variant hover:text-on-surface hover:bg-surface-container transition-colors" href="DeploymentHistoryRollback.php">Releases & Rollback</a>
                </nav>
                <div class="flex items-center gap-2 font-mono text-xs text-outline">
                    <span>STATUS: <strong class="text-emerald-400">STAGED_PROD</strong></span>
                    <span>•</span>
                    <span>GATE: <strong>CANARY_10%</strong></span>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="w-full pt-32 pb-12 px-8 flex-1 bg-surface">
            <!-- Breadcrumb Header Banner -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 p-6 rounded-xl bg-surface-container-low border border-outline-variant/40 shadow-lg mb-6 dot-canvas">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-xl bg-tertiary-container border border-tertiary/50 flex items-center justify-center shrink-0 shadow-[0_0_20px_rgba(255,185,86,0.2)]">
                        <span class="material-symbols-outlined text-tertiary text-3xl">psychology</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h1 class="text-2xl font-bold font-mono tracking-tight text-white">churn_rf_v2.0</h1>
                            <span class="px-2.5 py-0.5 rounded text-[11px] font-mono bg-emerald-950/80 text-emerald-400 border border-emerald-500/40">CHAMPION CANDIDATE</span>
                            <span class="px-2 py-0.5 rounded text-[11px] font-mono bg-error-container text-error border border-error/40 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-error animate-ping"></span>
                                DRIFT DETECTED IN SOC
                            </span>
                        </div>
                        <p class="text-sm text-on-surface-variant mt-1 max-w-3xl leading-relaxed">
                            Enterprise Customer Churn Predictive Classifier using Random Forest Ensembles with Calibrated Probability Estimates. Optimized for High-Recall Retention campaigns.
                        </p>
                        <div class="flex items-center gap-4 mt-3 text-xs font-mono text-outline flex-wrap">
                            <span>Author: <strong>Dr. Alexei Voronov</strong></span>
                            <span>Created: <strong>2026-09-24</strong></span>
                            <span>Format: <strong>ONNX / Scikit-Learn 1.3</strong></span>
                            <span>Weights Hash: <strong class="text-tertiary">sha256:4f9812a...</strong></span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <a href="DeploymentWizard.php" class="px-4 py-2.5 rounded-lg bg-tertiary text-on-tertiary font-bold text-xs flex items-center gap-2 hover:bg-tertiary-fixed shadow-md transition-all">
                        <span class="material-symbols-outlined text-sm">rocket_launch</span>
                        Deploy to Triton
                    </a>
                    <a href="../AI Operations Center (AI SOC)/DriftInvestigationWorkspace.php" class="px-4 py-2.5 rounded-lg bg-surface-container-high border border-outline-variant/60 text-xs font-medium text-on-surface hover:border-tertiary transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm text-rose-400">query_stats</span>
                        Investigate Drift
                    </a>
                </div>
            </div>

            <!-- Key Performance Metrics Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="p-4 rounded-xl bg-surface-container border border-outline-variant/30 flex flex-col justify-between">
                    <div class="flex items-center justify-between text-outline text-xs font-mono">
                        <span>F1 SCORE (TEST)</span>
                        <span class="material-symbols-outlined text-secondary text-base">analytics</span>
                    </div>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-bold font-mono text-white">0.874</span>
                        <span class="text-xs font-mono text-emerald-400 font-bold">+4.2% vs v1</span>
                    </div>
                    <div class="text-[11px] text-outline mt-1 font-mono">Baseline threshold: 0.800</div>
                </div>

                <div class="p-4 rounded-xl bg-surface-container border border-outline-variant/30 flex flex-col justify-between">
                    <div class="flex items-center justify-between text-outline text-xs font-mono">
                        <span>ROC-AUC SCORE</span>
                        <span class="material-symbols-outlined text-tertiary text-base">area_chart</span>
                    </div>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-bold font-mono text-white">0.912</span>
                        <span class="text-xs font-mono text-emerald-400 font-bold">Optimal Rank</span>
                    </div>
                    <div class="text-[11px] text-outline mt-1 font-mono">False Positive Rate: 4.8%</div>
                </div>

                <div class="p-4 rounded-xl bg-surface-container border border-outline-variant/30 flex flex-col justify-between">
                    <div class="flex items-center justify-between text-outline text-xs font-mono">
                        <span>INFERENCE P99</span>
                        <span class="material-symbols-outlined text-secondary text-base">speed</span>
                    </div>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-bold font-mono text-white">11.4 ms</span>
                        <span class="text-xs font-mono text-secondary font-bold">Triton ONNX</span>
                    </div>
                    <div class="text-[11px] text-outline mt-1 font-mono">SLA Gate: &lt; 25.0 ms</div>
                </div>

                <div class="p-4 rounded-xl bg-surface-container border border-outline-variant/30 flex flex-col justify-between">
                    <div class="flex items-center justify-between text-outline text-xs font-mono">
                        <span>FAIRNESS / BIAS AUDIT</span>
                        <span class="material-symbols-outlined text-emerald-400 text-base">gavel</span>
                    </div>
                    <div class="mt-2 flex items-baseline gap-2">
                        <span class="text-3xl font-bold font-mono text-emerald-400">0.98</span>
                        <span class="text-xs font-mono text-emerald-400 font-bold">DIR Ratio</span>
                    </div>
                    <div class="text-[11px] text-outline mt-1 font-mono">Demographic Parity: PASS</div>
                </div>
            </div>

            <!-- Model Card Detailed Tabs -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left 2 Cols: Technical Details & Intended Use -->
                <div class="lg:col-span-2 flex flex-col gap-6">
                    <!-- Intended Use & Boundaries -->
                    <div class="p-6 rounded-xl bg-surface-container border border-outline-variant/30">
                        <h2 class="text-sm font-bold uppercase font-mono tracking-wider text-tertiary mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">verified_user</span>
                            1. Model Purpose & Operational Scope
                        </h2>
                        <div class="space-y-3 text-xs text-on-surface-variant leading-relaxed">
                            <p>
                                <strong class="text-white">Primary Use Case:</strong> Predict high-risk customer turnover across Enterprise B2B telecommunication contracts 60 days before contract expiry.
                            </p>
                            <p>
                                <strong class="text-white">Out-of-Scope Operations:</strong> Not licensed for automated punitive SLA penalties or individual credit score rating without human-in-the-loop review.
                            </p>
                            <p>
                                <strong class="text-white">Input Schema Requirements:</strong> Requires 28 telemetry vectors including monthly billing delta, bandwidth saturation index, tier status, and ticket escalations over the last 90 days.
                            </p>
                        </div>
                    </div>

                    <!-- Training & Evaluation Data -->
                    <div class="p-6 rounded-xl bg-surface-container border border-outline-variant/30">
                        <h2 class="text-sm font-bold uppercase font-mono tracking-wider text-secondary mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">storage</span>
                            2. Training Dataset & Ingestion Lineage
                        </h2>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs text-left">
                                <thead class="border-b border-outline-variant/30 text-outline font-mono">
                                    <tr>
                                        <th class="py-2">SPLIT</th>
                                        <th class="py-2">RECORDS</th>
                                        <th class="py-2">CHURN POSITIVES</th>
                                        <th class="py-2">FEATURE STORE VERSION</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/20 font-mono text-on-surface">
                                    <tr>
                                        <td class="py-2.5 font-bold text-white">Training (70%)</td>
                                        <td class="py-2.5">142,800</td>
                                        <td class="py-2.5 text-tertiary">18,564 (13.0%)</td>
                                        <td class="py-2.5 text-outline">telecom_q3_v1.parquet</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2.5 font-bold text-white">Validation (15%)</td>
                                        <td class="py-2.5">30,600</td>
                                        <td class="py-2.5 text-tertiary">3,978 (13.0%)</td>
                                        <td class="py-2.5 text-outline">telecom_q3_v1.parquet</td>
                                    </tr>
                                    <tr>
                                        <td class="py-2.5 font-bold text-white">Test (15%)</td>
                                        <td class="py-2.5">30,600</td>
                                        <td class="py-2.5 text-tertiary">3,982 (13.0%)</td>
                                        <td class="py-2.5 text-outline">telecom_q3_v1.parquet</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 pt-3 border-t border-outline-variant/20 flex items-center justify-between text-xs">
                            <a href="../Data Center/DataLineageAndAuditHistory.php" class="text-secondary hover:underline flex items-center gap-1">
                                <span>Inspect Full Data Lineage DAG</span>
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                            <span class="text-outline font-mono">Provenance: 100% Immutable Verified</span>
                        </div>
                    </div>

                    <!-- Hyperparameters & Tuning Manifest -->
                    <div class="p-6 rounded-xl bg-surface-container border border-outline-variant/30 font-mono text-xs">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-white mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-base text-tertiary">tune</span>
                            3. Model Hyperparameters Manifest
                        </h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <div class="p-2.5 rounded bg-surface-container-high border border-outline-variant/30">
                                <span class="text-outline text-[10px] block">N_ESTIMATORS</span>
                                <span class="text-white font-bold text-sm">200 Trees</span>
                            </div>
                            <div class="p-2.5 rounded bg-surface-container-high border border-outline-variant/30">
                                <span class="text-outline text-[10px] block">MAX_DEPTH</span>
                                <span class="text-white font-bold text-sm">16</span>
                            </div>
                            <div class="p-2.5 rounded bg-surface-container-high border border-outline-variant/30">
                                <span class="text-outline text-[10px] block">CRITERION</span>
                                <span class="text-white font-bold text-sm">entropy</span>
                            </div>
                            <div class="p-2.5 rounded bg-surface-container-high border border-outline-variant/30">
                                <span class="text-outline text-[10px] block">CLASS_WEIGHT</span>
                                <span class="text-white font-bold text-sm">balanced_subsample</span>
                            </div>
                            <div class="p-2.5 rounded bg-surface-container-high border border-outline-variant/30">
                                <span class="text-outline text-[10px] block">MIN_SAMPLES_SPLIT</span>
                                <span class="text-white font-bold text-sm">8</span>
                            </div>
                            <div class="p-2.5 rounded bg-surface-container-high border border-outline-variant/30">
                                <span class="text-outline text-[10px] block">BOOTSTRAP</span>
                                <span class="text-white font-bold text-sm">True (OOB 0.881)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Col: Artifacts & Deployment Status -->
                <div class="flex flex-col gap-6">
                    <!-- Checkpoint Artifacts Box -->
                    <div class="p-6 rounded-xl bg-surface-container border border-outline-variant/30">
                        <h2 class="text-sm font-bold uppercase font-mono tracking-wider text-white mb-3 flex items-center justify-between">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-tertiary">inventory_2</span>
                                Artifacts & Checkpoints
                            </span>
                            <span class="text-[10px] text-outline font-mono">S3 // 128 MB</span>
                        </h2>
                        <div class="space-y-2.5 text-xs">
                            <div class="p-3 rounded-lg bg-surface-container-high border border-outline-variant/30 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-tertiary text-lg">extension</span>
                                    <div>
                                        <div class="font-mono text-white font-bold">model.onnx</div>
                                        <div class="text-[10px] text-outline font-mono">114.2 MB • ONNX v1.16</div>
                                    </div>
                                </div>
                                <button class="p-1.5 rounded hover:bg-surface-container text-secondary" title="Download">
                                    <span class="material-symbols-outlined text-base">download</span>
                                </button>
                            </div>
                            <div class="p-3 rounded-lg bg-surface-container-high border border-outline-variant/30 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-lg">description</span>
                                    <div>
                                        <div class="font-mono text-white font-bold">schema.json</div>
                                        <div class="text-[10px] text-outline font-mono">4.8 KB • Ingestion Protocol</div>
                                    </div>
                                </div>
                                <button class="p-1.5 rounded hover:bg-surface-container text-secondary" title="Download">
                                    <span class="material-symbols-outlined text-base">download</span>
                                </button>
                            </div>
                            <div class="p-3 rounded-lg bg-surface-container-high border border-outline-variant/30 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-400 text-lg">verified</span>
                                    <div>
                                        <div class="font-mono text-white font-bold">model_card.pdf</div>
                                        <div class="text-[10px] text-outline font-mono">1.2 MB • Compliance Audit</div>
                                    </div>
                                </div>
                                <button class="p-1.5 rounded hover:bg-surface-container text-secondary" title="Download">
                                    <span class="material-symbols-outlined text-base">download</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Live Gateway Endpoint -->
                    <div class="p-6 rounded-xl bg-surface-container border border-outline-variant/30">
                        <h2 class="text-sm font-bold uppercase font-mono tracking-wider text-white mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-base text-secondary">cloud_done</span>
                            Production Endpoint
                        </h2>
                        <div class="p-3 rounded bg-surface-container-lowest font-mono text-[11px] text-emerald-400 break-all border border-outline-variant/20 mb-3">
                            POST https://gateway.vostokpribor.ai/v2/models/churn_rf_v2/infer
                        </div>
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between font-mono">
                                <span class="text-outline">Active Traffic Gate:</span>
                                <span class="text-tertiary font-bold">10% Canary (90% to v1.9)</span>
                            </div>
                            <div class="flex justify-between font-mono">
                                <span class="text-outline">Current P99 Latency:</span>
                                <span class="text-white font-bold">11.4 ms</span>
                            </div>
                            <div class="flex justify-between font-mono">
                                <span class="text-outline">Active Pods:</span>
                                <span class="text-white font-bold">4 / 4 Healthy</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-outline-variant/20 flex gap-2">
                            <a href="EndpointConsole.php" class="flex-1 py-2 rounded bg-surface-container-high text-center text-xs font-mono text-on-surface hover:text-white transition-colors">
                                Open Console
                            </a>
                            <a href="DeploymentHistoryRollback.php" class="flex-1 py-2 rounded bg-surface-container-high text-center text-xs font-mono text-error hover:bg-error-container transition-colors">
                                Rollback Gate
                            </a>
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
