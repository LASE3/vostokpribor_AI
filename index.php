<?php
require_once __DIR__ . '/app/bootstrap.php';

use App\Core\Database;
use App\Middleware\AuthenticationMiddleware;

// Require authentication - unauthenticated visitors redirected to login.php
$currentUser = AuthenticationMiddleware::handle(false);
$isAdmin = strtoupper((string)($currentUser['role'] ?? '')) === 'ADMIN';

$db = Database::getInstance();

// Counts are scoped to the signed-in user.
$uid=(int)$currentUser['id'];
$tickets=(new \App\Services\TicketService())->listTicketsForUser($uid,$currentUser['role']);
$subs=(new \App\Services\SubmissionService())->listSubmissions($uid,$currentUser['role']);
$activeTickets=count(array_filter($tickets,fn($t)=>in_array($t['status'],['ASSIGNED','IN_PROGRESS'],true)));
$allTickets=count($tickets);
$approvedSubmissions=count(array_filter($subs,fn($v)=>$v['status']==='APPROVED'));
$pendingSubmissions=count(array_filter($subs,fn($v)=>in_array($v['status'],['SUBMITTED','UNDER_REVIEW'],true)));
$datasetCount=count((new \App\Services\DatasetService())->listForUser($uid,$currentUser['role']));
$processedCount=(int)$db->fetchValue('SELECT COUNT(*) FROM processed_datasets'.($isAdmin?'':' WHERE student_id=:id'),$isAdmin?[]:['id'=>$uid]);
foreach(['notebookCount'=>'notebooks','experimentRunCount'=>'experiment_runs','modelCount'=>'models','runningJobs'=>'execution_jobs','queuedJobs'=>'execution_jobs'] as $variable=>$table) {
    $query='SELECT COUNT(*) FROM '.$table.' WHERE 1=1';
    $params=[];
    if(!$isAdmin){$query.=' AND student_id=:id';$params['id']=$uid;}
    if($variable==='runningJobs')$query.=" AND status='RUNNING'";
    if($variable==='queuedJobs')$query.=" AND status='QUEUED'";
    $$variable=(int)$db->fetchValue($query,$params);
}
$deployedCount=(int)$db->fetchValue("SELECT COUNT(*) FROM deployment_requests WHERE status='DEPLOYED'".($isAdmin?'':' AND requested_by=:id'),$isAdmin?[]:['id'=>$uid]);
$studentCount=$isAdmin?(int)$db->fetchValue("SELECT COUNT(*) FROM users WHERE role='STUDENT'"):0;
$activeStudents=$isAdmin?(int)$db->fetchValue("SELECT COUNT(*) FROM users WHERE role='STUDENT' AND status='ACTIVE'"):0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>VOSTOKPRIBOR AI · Mission Control & Avionics Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['IBM Plex Mono', 'monospace'],
                    },
                    colors: {
                        brand: {
                            purple: '#4C1D95',
                            lilac: '#D8B4FE',
                            lavender: '#F3E8FF',
                            rosegold: '#E8C9A0',
                            cream: '#FDF6F0',
                            wheat: '#F5DEB3',
                            bg: '#EAF4FF',
                            bgSub: '#DCEEFF',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Precision Fiberglass Micro-Composite Pattern */
        .fiberglass-bg {
            background-color: #EAF4FF;
            background-image:
                radial-gradient(ellipse at 50% 0%, rgba(216, 180, 254, 0.22) 0%, transparent 65%),
                linear-gradient(135deg, rgba(220, 238, 255, 0.45) 25%, transparent 25%),
                linear-gradient(225deg, rgba(220, 238, 255, 0.45) 25%, transparent 25%),
                linear-gradient(315deg, rgba(245, 222, 179, 0.12) 25%, transparent 25%),
                linear-gradient(45deg, rgba(245, 222, 179, 0.12) 25%, transparent 25%);
            background-size: 100% 100%, 28px 28px, 28px 28px, 28px 28px, 28px 28px;
            background-position: 0 0, 0 0, 14px 0, 14px -14px, 0px 14px;
        }

        .precision-card {
            background: #FFFFFF;
            border: 1px solid rgba(76, 29, 149, 0.12);
            box-shadow: 0 1px 3px rgba(76, 29, 149, 0.04), 0 4px 14px rgba(220, 238, 255, 0.6);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .precision-card:hover {
            border-color: rgba(76, 29, 149, 0.35);
            box-shadow: 0 4px 20px rgba(76, 29, 149, 0.08), 0 1px 4px rgba(76, 29, 149, 0.04);
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="fiberglass-bg text-slate-800 antialiased min-h-screen font-sans selection:bg-[#F3E8FF] selection:text-[#4C1D95]">

    <!-- Mission Control Top Navigation Bar -->
    <header class="sticky top-0 z-50 bg-[#FFFFFF]/95 backdrop-blur-md border-b border-[#4C1D95]/15 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between gap-6">
            <!-- Brand & Node Status -->
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-[#4C1D95] border border-[#4C1D95]/30 flex items-center justify-center text-white shadow-[0_2px_10px_rgba(76,29,149,0.25)]">
                    <span class="material-symbols-outlined text-2xl text-[#E8C9A0]">satellite_alt</span>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="text-base font-extrabold font-mono tracking-wider uppercase text-[#4C1D95]">VOSTOKPRIBOR AI</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-[#F3E8FF] text-[#4C1D95] border border-[#D8B4FE] font-bold">RANGE v4.8</span>
                    </div>
                    <span class="text-xs text-slate-500 font-mono">Aerospace Engineering Range & Mission Control</span>
                </div>
            </div>

            <!-- Central Telemetry Bar -->
            <div class="hidden lg:flex items-center gap-4 bg-[#F6F9FF] px-4 py-2 rounded-xl border border-[#4C1D95]/15 text-xs font-mono shadow-inner">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    <span class="text-[#4C1D95] font-bold"><?= htmlspecialchars($currentUser['cohort'] ?? 'No cohort assigned') ?></span>
                </div>
                <span class="text-slate-300">|</span>
                <div class="text-slate-600">Active Tasks: <strong class="text-[#4C1D95] font-semibold"><?= $activeTickets ?></strong></div>
                <span class="text-slate-300">|</span>
                <div class="text-slate-600">Datasets: <strong class="text-slate-800 font-semibold"><?= $datasetCount ?></strong></div>
                <span class="text-slate-300">|</span>
                <div class="text-slate-600">Models: <strong class="text-[#4C1D95] font-semibold"><?= $modelCount ?></strong></div>
                <span class="text-slate-300">|</span>
                <div class="flex items-center gap-1.5 px-2 py-0.5 rounded bg-emerald-50 border border-emerald-300 text-[11px] font-semibold text-emerald-800">
                    <span class="material-symbols-outlined text-sm">verified</span>
                    <span>DB: MARIADB CONNECTED</span>
                </div>
            </div>

            <!-- User Identity & Logout Controls -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl border <?= $isAdmin ? 'bg-[#F3E8FF] border-[#D8B4FE] text-[#4C1D95]' : 'bg-[#FDF6F0] border-[#F5DEB3] text-[#8C5E28]' ?>">
                    <span class="material-symbols-outlined text-lg"><?= $isAdmin ? 'admin_panel_settings' : 'school' ?></span>
                    <div class="flex flex-col text-left">
                        <span class="text-xs font-bold font-mono leading-tight"><?= htmlspecialchars($currentUser['full_name']) ?></span>
                        <span class="text-[10px] font-mono opacity-80"><?= htmlspecialchars($currentUser['identifier']) ?> · <?= $isAdmin ? 'COMMANDER (ADMIN)' : 'CADET' ?></span>
                    </div>
                </div>

                <a href="logout.php" title="Sign out of flight session" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-rose-50 border border-slate-200 hover:border-rose-300 text-xs font-mono text-slate-700 hover:text-rose-700 font-bold transition-all flex items-center gap-1.5 shadow-sm">
                    <span class="material-symbols-outlined text-sm">logout</span>
                    <span class="hidden sm:inline">Sign Out</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-6 py-10">
        <?php if (isset($_GET['access_denied'])): ?>
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-300 text-rose-900 flex items-center justify-between shadow-sm font-mono text-xs">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-rose-600 text-2xl">gpp_maybe</span>
                    <div>
                        <strong class="font-bold text-sm block">SECURITY ACCESS RESTRICTION</strong>
                        <span>Your security clearance does not permit access to AI Operations Center (AI SOC) or privileged administrative flight decks. Only authenticated instructors and range administrators may access System 5.</span>
                    </div>
                </div>
                <a href="index.php" class="px-3 py-1.5 rounded-lg bg-rose-200 hover:bg-rose-300 text-rose-900 font-bold transition-colors">Dismiss</a>
            </div>
        <?php endif; ?>

        <!-- Subsystem Persistent Quick Nav Strip -->
        <div class="mb-8 p-2.5 rounded-xl bg-white/80 border border-[#4C1D95]/15 backdrop-blur shadow-sm flex items-center justify-between text-xs font-mono overflow-x-auto">
            <div class="flex items-center gap-1">
                <span class="px-3 py-1 text-[11px] font-bold tracking-wider text-[#4C1D95] uppercase flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm text-[#4C1D95]">apps</span>
                    Fleet Systems:
                </span>
                <a href="AI Project Management/Tickets.php" class="px-3 py-1.5 rounded-lg hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] font-medium transition-colors">SYS-AI-01 <span class="text-slate-400 text-[10px]">(Projects)</span></a>
                <a href="Data Center/DatasetCatalog.php" class="px-3 py-1.5 rounded-lg hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] font-medium transition-colors">SYS-AI-02 <span class="text-slate-400 text-[10px]">(Data Lake)</span></a>
                <a href="ML Workbench/NotebookWorkbench.php" class="px-3 py-1.5 rounded-lg hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] font-medium transition-colors">SYS-AI-03 <span class="text-slate-400 text-[10px]">(Workbench)</span></a>
                <a href="Model Registry & Deployment/ModelRegistry.php" class="px-3 py-1.5 rounded-lg hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] font-medium transition-colors">SYS-AI-04 <span class="text-slate-400 text-[10px]">(Registry)</span></a>
                <?php if ($isAdmin): ?>
                    <a href="AI Operations Center (AI SOC)/TicketsAndScenarios.php" class="px-3 py-1.5 rounded-lg bg-[#4C1D95] text-white font-bold shadow-sm transition-colors">SYS-AI-05 <span class="text-[#E8C9A0] text-[10px]">(AI SOC)</span></a>
                    <a href="AI Operations Center (AI SOC)/StudentManagement.php" class="px-3 py-1.5 rounded-lg bg-[#FDF6F0] text-[#8C5E28] hover:bg-[#E8C9A0] border border-[#F5DEB3] font-bold shadow-sm transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">manage_accounts</span>
                        <span>Cadet Roster (<?= $studentCount ?>)</span>
                    </a>
                <?php else: ?>
                    <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-400 font-medium cursor-not-allowed flex items-center gap-1" title="Instructor Access Only">
                        <span class="material-symbols-outlined text-[14px]">lock</span>
                        <span>SYS-AI-05 (Admin Only)</span>
                    </span>
                <?php endif; ?>
            </div>
            <div class="hidden sm:flex items-center gap-2 pr-2 text-[11px] text-slate-500">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>Active Database: <strong><?= htmlspecialchars((string)\App\Core\Env::get('DB_NAME')) ?> (MySQL)</strong></span>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-widest text-[#4C1D95] font-bold mb-2">
                    <span class="material-symbols-outlined text-base text-[#4C1D95]">hub</span>
                    <span>Subsystems Dispatch Matrix · Level 3 Flight Deck</span>
                    <span class="px-2 py-0.5 rounded text-[10px] bg-[#E8C9A0]/30 text-[#8C5E28] border border-[#E8C9A0] font-semibold">PRECISION CLASS</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold font-mono tracking-tight text-[#4C1D95] leading-tight">
                    AVIONICS MISSION CONTROL
                </h1>
                <p class="text-sm md:text-base text-slate-600 mt-2 max-w-2xl leading-relaxed">
                    Select a subsystem below to launch into operational flight consoles, telemetry streams, data lineage graphs, or production model canary gates.
                </p>
            </div>
            <!-- Quick Filter Input -->
            <div class="relative w-full md:w-80">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                <input id="system-search" type="text" placeholder="Filter systems or views..."
                    class="w-full bg-white border border-[#4C1D95]/20 rounded-xl pl-10 pr-4 py-2.5 text-xs font-mono text-slate-800 placeholder-slate-400 focus:border-[#4C1D95] focus:ring-2 focus:ring-[#D8B4FE]/50 outline-none transition-all shadow-sm" />
            </div>
        </div>

        <!-- 5-Systems Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="systems-grid">

            <!-- SYS-AI-01: AI Project Management -->
            <div id="sys-01" class="precision-card p-6 flex flex-col justify-between group relative overflow-hidden rounded-2xl">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#F3E8FF] border border-[#D8B4FE] flex items-center justify-center text-[#4C1D95] group-hover:scale-105 transition-transform shadow-sm">
                                <span class="material-symbols-outlined text-2xl">folder_special</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-[#4C1D95] tracking-widest block uppercase">SYS-AI-01</span>
                                <h2 class="text-lg font-bold font-mono text-slate-900 group-hover:text-[#4C1D95] transition-colors">AI Project Management</h2>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-emerald-50 text-emerald-800 border border-emerald-300 flex items-center gap-1 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            WORKFLOW
                        </span>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Track agile engineering milestones, deliverable submissions, grading rubrics, sprint velocity, and cadet ticket boards.
                    </p>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-3 gap-2 p-3 rounded-xl bg-[#F6F9FF] border border-[#DCEEFF] text-center font-mono text-[11px] mb-5">
                        <div>
                            <span class="text-slate-400 text-[10px] block font-semibold">TASKS</span>
                            <strong class="text-slate-800"><?= $activeTickets ?> Active</strong>
                        </div>
                        <div class="border-x border-[#DCEEFF]">
                            <span class="text-slate-400 text-[10px] block font-semibold">ALL TICKETS</span>
                            <strong class="text-emerald-700 font-bold"><?= $allTickets ?> Total</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[10px] block font-semibold">APPROVED</span>
                            <strong class="text-[#4C1D95]"><?= $approvedSubmissions ?> Done</strong>
                        </div>
                    </div>

                    <!-- Subpage Direct Links -->
                    <div class="mb-5">
                        <span class="text-[10px] uppercase font-mono text-slate-400 tracking-wider block mb-2 font-bold">Operational Sub-Views</span>
                        <div class="flex flex-wrap gap-1.5 text-xs">
                            <a href="AI Project Management/Dashboard.php" class="px-2.5 py-1 rounded-lg bg-[#F6F9FF] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#DCEEFF] transition-colors">Dashboard</a>
                            <a href="AI Project Management/Submissions.php" class="px-2.5 py-1 rounded-lg bg-[#F6F9FF] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#DCEEFF] transition-colors">Deliverables</a>
                            <a href="AI Project Management/Tickets.php" class="px-2.5 py-1 rounded-lg bg-[#F6F9FF] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#DCEEFF] transition-colors">Ticket Board</a>
                            <a href="AI Project Management/TicketDetails.php" class="px-2.5 py-1 rounded-lg bg-[#F6F9FF] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#DCEEFF] transition-colors">Ticket Details</a>
                            <a href="AI Project Management/StudentProfile.php" class="px-2.5 py-1 rounded-lg bg-[#F6F9FF] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#DCEEFF] transition-colors">Cadet Profile</a>
                        </div>
                    </div>
                </div>

                <a href="AI Project Management/Dashboard.php" class="w-full py-2.5 rounded-xl bg-[#F3E8FF] hover:bg-[#4C1D95] text-[#4C1D95] hover:text-white border border-[#D8B4FE] font-bold text-xs font-mono transition-all flex items-center justify-center gap-2 shadow-sm">
                    <span>Launch Projects System</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- SYS-AI-02: Data Center -->
            <div id="sys-02" class="precision-card p-6 flex flex-col justify-between group relative overflow-hidden rounded-2xl">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#FDF6F0] border border-[#F5DEB3] flex items-center justify-center text-[#8C5E28] group-hover:scale-105 transition-transform shadow-sm">
                                <span class="material-symbols-outlined text-2xl text-[#8C5E28]">dataset</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-[#8C5E28] tracking-widest block uppercase">SYS-AI-02</span>
                                <h2 class="text-lg font-bold font-mono text-slate-900 group-hover:text-[#4C1D95] transition-colors">Data Center</h2>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-emerald-50 text-emerald-800 border border-emerald-300 flex items-center gap-1 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            FILE UPLOADS
                        </span>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Upload real CSV or JSON files, assign datasets to students, inspect file-derived statistics, and save processed data.
                    </p>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-3 gap-2 p-3 rounded-xl bg-[#FDF6F0] border border-[#F5DEB3] text-center font-mono text-[11px] mb-5">
                        <div>
                            <span class="text-slate-400 text-[10px] block font-semibold">DATASETS</span>
                            <strong class="text-slate-800"><?= $datasetCount ?> Files</strong>
                        </div>
                        <div class="border-x border-[#F5DEB3]">
                            <span class="text-slate-400 text-[10px] block font-semibold">PROCESSED</span>
                            <strong class="text-[#4C1D95] font-bold"><?= $processedCount ?> Sets</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[10px] block font-semibold">LINEAGE</span>
                            <strong class="text-emerald-700 font-bold">NOT AVAILABLE</strong>
                        </div>
                    </div>

                    <!-- Subpage Direct Links -->
                    <div class="mb-5">
                        <span class="text-[10px] uppercase font-mono text-slate-400 tracking-wider block mb-2 font-bold">Operational Sub-Views</span>
                        <div class="flex flex-wrap gap-1.5 text-xs">
                            <a href="Data Center/DatasetCatalog.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#F5DEB3] transition-colors">Catalog</a>
                            <a href="Data Center/MyDataSet.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#F5DEB3] transition-colors">My Datasets</a>
                            <a href="Data Center/DataProfilingAndQuality.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#F5DEB3] transition-colors">Data Profiling</a>
                            <a href="Data Center/QueryWorkspace.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#F5DEB3] transition-colors">SQL Studio</a>
                            <a href="Data Center/UploadProcessedData.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#F5DEB3] transition-colors">Upload</a>
                        </div>
                    </div>
                </div>

                <a href="Data Center/dashboard.php" class="w-full py-2.5 rounded-xl bg-[#FDF6F0] hover:bg-[#E8C9A0] text-[#8C5E28] hover:text-[#4C1D95] border border-[#F5DEB3] font-bold text-xs font-mono transition-all flex items-center justify-center gap-2 shadow-sm">
                    <span>Launch Data Center</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- SYS-AI-03: AI/ML Workbench -->
            <div id="sys-03" class="precision-card p-6 flex flex-col justify-between group relative overflow-hidden rounded-2xl border-[#E8C9A0]/80">
                <div class="absolute top-0 right-0 w-24 h-24 bg-[#E8C9A0]/15 rounded-full blur-xl pointer-events-none"></div>
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#E8C9A0]/25 border border-[#E8C9A0] flex items-center justify-center text-[#8C5E28] group-hover:scale-105 transition-transform shadow-[0_2px_10px_rgba(232,201,160,0.3)]">
                                <span class="material-symbols-outlined text-2xl text-[#8C5E28]">precision_manufacturing</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-[#8C5E28] tracking-widest block uppercase">SYS-AI-03</span>
                                <h2 class="text-lg font-bold font-mono text-slate-900 group-hover:text-[#4C1D95] transition-colors">AI/ML Workbench</h2>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-[#E8C9A0]/30 text-[#8C5E28] border border-[#E8C9A0] flex items-center gap-1 font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#8C5E28]"></span>
                            CODE SAVING
                        </span>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Save notebook code, experiment metadata, and model artifacts. Execution remains unavailable until an isolated runner is deployed.
                    </p>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-3 gap-2 p-3 rounded-xl bg-[#FDF6F0] border border-[#E8C9A0]/60 text-center font-mono text-[11px] mb-5">
                        <div>
                            <span class="text-slate-400 text-[10px] block font-semibold">NOTEBOOKS</span>
                            <strong class="text-slate-800"><?= $notebookCount ?> Books</strong>
                        </div>
                        <div class="border-x border-[#E8C9A0]/60">
                            <span class="text-slate-400 text-[10px] block font-semibold">RUNS</span>
                            <strong class="text-[#8C5E28] font-bold"><?= $experimentRunCount ?> Runs</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[10px] block font-semibold">WORKER</span>
                            <strong class="text-emerald-700 font-bold">UNAVAILABLE</strong>
                        </div>
                    </div>

                    <!-- Subpage Direct Links -->
                    <div class="mb-5">
                        <span class="text-[10px] uppercase font-mono text-slate-400 tracking-wider block mb-2 font-bold">Operational Sub-Views</span>
                        <div class="flex flex-wrap gap-1.5 text-xs">
                            <a href="ML Workbench/NotebookWorkbench.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#F5DEB3] transition-colors">Workbench Home</a>
                            <a href="ML Workbench/ExperimentRuns.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#F5DEB3] transition-colors">Runs & Compare</a>
                            <a href="ML Workbench/MetricTelemetry.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#F5DEB3] transition-colors">Metrics</a>
                            <a href="ML Workbench/TensorInspector.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#F5DEB3] transition-colors">Tensor Inspector</a>
                            <a href="ML Workbench/ModelArtifacts.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#F5DEB3] transition-colors">Model Artifacts</a>
                        </div>
                    </div>
                </div>

                <a href="ML Workbench/NotebookWorkbench.php" class="w-full py-2.5 rounded-xl bg-[#E8C9A0] hover:bg-[#4C1D95] text-[#4C1D95] hover:text-white font-bold text-xs font-mono transition-all flex items-center justify-center gap-2 shadow-md">
                    <span>Launch ML Workbench</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <!-- SYS-AI-04: Model Registry & Deployment -->
            <div id="sys-04" class="precision-card p-6 flex flex-col justify-between group relative overflow-hidden rounded-2xl border-2 border-[#4C1D95] shadow-md bg-gradient-to-b from-white to-[#F6F9FF]">
                <div class="absolute top-0 right-0 bg-[#4C1D95] text-white text-[9px] font-mono font-bold px-3 py-0.5 rounded-bl-lg tracking-wider uppercase">
                    MODEL LIFECYCLE
                </div>
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#4C1D95] border border-[#4C1D95] flex items-center justify-center text-white group-hover:scale-105 transition-transform shadow-[0_2px_12px_rgba(76,29,149,0.3)]">
                                <span class="material-symbols-outlined text-2xl text-[#E8C9A0]">rocket_launch</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-[#4C1D95] tracking-widest block uppercase">SYS-AI-04</span>
                                <h2 class="text-lg font-bold font-mono text-[#4C1D95] transition-colors">Registry & Deployment</h2>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-[#E8C9A0]/30 text-[#8C5E28] border border-[#E8C9A0] flex items-center gap-1 font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#8C5E28]"></span>
                            ARTIFACT CHECKS
                        </span>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Register model metadata, upload private artifacts, and verify file integrity. Quality evaluation and deployment require trusted external services.
                    </p>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-3 gap-2 p-3 rounded-xl bg-white border border-[#D8B4FE] text-center font-mono text-[11px] mb-5 shadow-sm">
                        <div>
                            <span class="text-slate-400 text-[10px] block font-semibold">MODELS</span>
                            <strong class="text-slate-900 font-bold"><?= $modelCount ?> Registered</strong>
                        </div>
                        <div class="border-x border-[#D8B4FE]">
                            <span class="text-slate-400 text-[10px] block font-semibold">DEPLOYED</span>
                            <strong class="text-[#4C1D95] font-bold">UNAVAILABLE</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[10px] block font-semibold">GATES</span>
                            <strong class="text-emerald-700 font-bold">NOT EVALUATED</strong>
                        </div>
                    </div>

                    <!-- Subpage Direct Links -->
                    <div class="mb-5">
                        <span class="text-[10px] uppercase font-mono text-[#4C1D95] tracking-wider block mb-2 font-bold">Operational Sub-Views</span>
                        <div class="flex flex-wrap gap-1.5 text-xs">
                            <a href="Model Registry & Deployment/ModelRegistry.php" class="px-2.5 py-1 rounded-lg bg-[#F3E8FF] hover:bg-[#4C1D95] text-[#4C1D95] hover:text-white border border-[#D8B4FE] transition-colors font-medium">Registry</a>
                            <a href="Model Registry & Deployment/ValidationPipeline.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#E8C9A0] text-[#8C5E28] border border-[#E8C9A0] transition-colors font-semibold">Validation Gates</a>
                            <a href="Model Registry & Deployment/DeploymentConfig.php" class="px-2.5 py-1 rounded-lg bg-[#F3E8FF] hover:bg-[#4C1D95] text-[#4C1D95] hover:text-white border border-[#D8B4FE] transition-colors">Deploy Config</a>
                            <a href="Model Registry & Deployment/DeployedEndpoints.php" class="px-2.5 py-1 rounded-lg bg-[#F3E8FF] hover:bg-[#4C1D95] text-[#4C1D95] hover:text-white border border-[#D8B4FE] transition-colors">Endpoints</a>
                            <a href="Model Registry & Deployment/ValidationReports.php" class="px-2.5 py-1 rounded-lg bg-[#F3E8FF] hover:bg-[#4C1D95] text-[#4C1D95] hover:text-white border border-[#D8B4FE] transition-colors">Reports</a>
                        </div>
                    </div>
                </div>

                <a href="Model Registry & Deployment/dashboard.php" class="w-full py-2.5 rounded-xl bg-[#4C1D95] hover:bg-[#3B1578] text-white font-bold text-xs font-mono transition-all flex items-center justify-center gap-2 shadow-md">
                    <span>Launch Registry & Deploy</span>
                    <span class="material-symbols-outlined text-sm text-[#E8C9A0]">arrow_forward</span>
                </a>
            </div>

            <!-- SYS-AI-05: AI Operations Center (AI SOC) -->
            <div id="sys-05" class="precision-card p-6 flex flex-col justify-between group relative overflow-hidden rounded-2xl">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-center text-rose-700 group-hover:scale-105 transition-transform shadow-sm">
                                <span class="material-symbols-outlined text-2xl">shield_with_heart</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-rose-700 tracking-widest block uppercase">SYS-AI-05</span>
                                <h2 class="text-lg font-bold font-mono text-slate-900 group-hover:text-[#4C1D95] transition-colors">AI SOC Center</h2>
                            </div>
                        </div>
                        <?php if ($isAdmin): ?>
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-purple-50 text-[#4C1D95] border border-purple-300 flex items-center gap-1 font-bold">
                                <span class="material-symbols-outlined text-xs">verified_user</span>
                                ADMIN CLEARANCE
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-rose-50 text-rose-800 border border-rose-300 flex items-center gap-1 font-bold">
                                <span class="material-symbols-outlined text-xs">lock</span>
                                INSTRUCTOR ONLY
                            </span>
                        <?php endif; ?>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Central administrative command: cadet account management, scenario creation, deliverable reviews, execution telemetry, and audit logging.
                    </p>

                    <!-- Key Metrics -->
                    <div class="grid grid-cols-3 gap-2 p-3 rounded-xl bg-rose-50/50 border border-rose-200 text-center font-mono text-[11px] mb-5">
                        <div>
                            <span class="text-slate-400 text-[10px] block font-semibold">CADETS</span>
                            <strong class="text-rose-700 font-bold"><?= $isAdmin ? $studentCount . ' Total' : 'Restricted' ?></strong>
                        </div>
                        <div class="border-x border-rose-200">
                            <span class="text-slate-400 text-[10px] block font-semibold">REVIEWS</span>
                            <strong class="text-rose-700 font-bold"><?= $isAdmin ? $pendingSubmissions . ' Pending' : 'Restricted' ?></strong>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[10px] block font-semibold">JOBS</span>
                            <strong class="text-[#4C1D95] font-bold"><?= $isAdmin ? ($queuedJobs + $runningJobs) . ' Active' : 'Restricted' ?></strong>
                        </div>
                    </div>

                    <!-- Subpage Direct Links -->
                    <div class="mb-5">
                        <span class="text-[10px] uppercase font-mono text-slate-400 tracking-wider block mb-2 font-bold">Operational Sub-Views</span>
                        <?php if ($isAdmin): ?>
                            <div class="flex flex-wrap gap-1.5 text-xs">
                                <a href="AI Operations Center (AI SOC)/StudentManagement.php" class="px-2.5 py-1 rounded-lg bg-[#FDF6F0] hover:bg-[#E8C9A0] text-[#8C5E28] border border-[#F5DEB3] transition-colors font-bold">Cadet Roster</a>
                                <a href="AI Operations Center (AI SOC)/TicketsAndScenarios.php" class="px-2.5 py-1 rounded-lg bg-[#F3E8FF] hover:bg-[#4C1D95] text-[#4C1D95] hover:text-white border border-[#D8B4FE] transition-colors font-bold">Scenario Builder</a>
                                <a href="AI Operations Center (AI SOC)/DatasetManagement.php" class="px-2.5 py-1 rounded-lg bg-[#F6F9FF] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#DCEEFF] transition-colors">Dataset Sync</a>
                                <a href="AI Operations Center (AI SOC)/WorkspaceConfiguration.php" class="px-2.5 py-1 rounded-lg bg-[#F6F9FF] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#DCEEFF] transition-colors">Runtime & Reviews</a>
                                <a href="AI Operations Center (AI SOC)/Dashboard.php" class="px-2.5 py-1 rounded-lg bg-[#F6F9FF] hover:bg-[#F3E8FF] text-slate-700 hover:text-[#4C1D95] border border-[#DCEEFF] transition-colors">Fleet Wall</a>
                            </div>
                        <?php else: ?>
                            <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200 text-slate-500 text-xs font-mono">
                                <span>Restricted to flight instructors. Cadets do not have administrative clearance for System 5 consoles.</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($isAdmin): ?>
                    <a href="AI Operations Center (AI SOC)/TicketsAndScenarios.php" class="w-full py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white border border-rose-600 font-bold text-xs font-mono transition-all flex items-center justify-center gap-2 shadow-sm">
                        <span>Launch AI SOC Command Deck</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                <?php else: ?>
                    <div class="w-full py-2.5 rounded-xl bg-slate-100 text-slate-400 border border-slate-200 font-bold text-xs font-mono flex items-center justify-center gap-2 cursor-not-allowed">
                        <span class="material-symbols-outlined text-sm">lock</span>
                        <span>Instructor Clearance Required</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- SYS-EXCHANGE: Future DB & Cross-System API Hub -->
            <div class="precision-card p-6 flex flex-col justify-between group relative overflow-hidden rounded-2xl border border-[#D8B4FE]">
                <div>
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#F3E8FF] border border-[#D8B4FE] flex items-center justify-center text-[#4C1D95] shadow-sm">
                                <span class="material-symbols-outlined text-2xl">schema</span>
                            </div>
                            <div>
                                <span class="text-[11px] font-mono font-bold text-[#4C1D95] tracking-widest block uppercase">SYS-EXCHANGE</span>
                                <h2 class="text-lg font-bold font-mono text-slate-900">Cross-System Exchange Hub</h2>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-emerald-50 text-emerald-800 border border-emerald-300 font-bold">
                            REST / JSON
                        </span>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Unified DB & API endpoints linking Models, Datasets, Incidents, and Tickets across the entire VOSTOKPRIBOR AI avionics fleet.
                    </p>

                    <!-- API Links -->
                    <div class="space-y-2 mb-5 font-mono text-xs">
                        <a href="api/status.php" target="_blank" class="p-2.5 rounded-xl bg-[#F6F9FF] hover:bg-[#F3E8FF] border border-[#DCEEFF] flex items-center justify-between text-slate-700 hover:text-[#4C1D95] transition-colors">
                            <span class="flex items-center gap-2">
                                <span class="text-emerald-700 font-bold">GET</span>
                                <span>/api/status.php</span>
                            </span>
                            <span class="material-symbols-outlined text-xs text-slate-400">open_in_new</span>
                        </a>
                        <a href="api/exchange.php" target="_blank" class="p-2.5 rounded-xl bg-[#F6F9FF] hover:bg-[#F3E8FF] border border-[#DCEEFF] flex items-center justify-between text-slate-700 hover:text-[#4C1D95] transition-colors">
                            <span class="flex items-center gap-2">
                                <span class="text-[#8C5E28] font-bold">POST/GET</span>
                                <span>/api/exchange.php</span>
                            </span>
                            <span class="material-symbols-outlined text-xs text-slate-400">open_in_new</span>
                        </a>
                        <a href="api/models.php" target="_blank" class="p-2.5 rounded-xl bg-[#F6F9FF] hover:bg-[#F3E8FF] border border-[#DCEEFF] flex items-center justify-between text-slate-700 hover:text-[#4C1D95] transition-colors">
                            <span class="flex items-center gap-2">
                                <span class="text-[#4C1D95] font-bold">CRUD</span>
                                <span>/api/models.php</span>
                            </span>
                            <span class="material-symbols-outlined text-xs text-slate-400">open_in_new</span>
                        </a>
                    </div>
                </div>

                <div class="flex gap-2">
                    <a href="api/status.php" target="_blank" class="flex-1 py-2.5 rounded-xl bg-[#FDF6F0] hover:bg-[#E8C9A0] border border-[#F5DEB3] text-[#8C5E28] hover:text-[#4C1D95] font-bold text-xs font-mono transition-all flex items-center justify-center gap-1.5 shadow-sm">
                        <span class="material-symbols-outlined text-sm">settings_suggest</span>
                        <span>Telemetry Fleet Status</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Cross-System Data Exchange Architecture Diagram -->
        <div class="mt-14 p-8 rounded-2xl bg-white border border-[#4C1D95]/15 shadow-sm relative overflow-hidden">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
                <div>
                    <span class="text-xs font-mono uppercase text-[#4C1D95] tracking-widest block mb-1 font-bold">Architecture Overview</span>
                    <h2 class="text-2xl font-bold font-mono text-slate-900">Cross-System Information Exchange Protocol</h2>
                    <p class="text-xs text-slate-600 mt-1 max-w-xl">
                        Uploaded datasets, notebooks, model metadata, and submissions share authorized MySQL records. Execution, inference, and service telemetry remain unavailable until trusted services are installed.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="api/status.php" class="px-4 py-2 rounded-xl bg-[#F3E8FF] hover:bg-[#4C1D95] text-xs font-mono text-[#4C1D95] hover:text-white border border-[#D8B4FE] transition-all font-semibold shadow-sm">
                        View Persisted Status JSON
                    </a>
                </div>
            </div>

            <!-- Flow Pipeline Nodes -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 relative">
                <div class="p-4 rounded-xl bg-[#F6F9FF] border border-[#DCEEFF] text-center hover:border-[#D8B4FE] transition-colors">
                    <span class="material-symbols-outlined text-[#4C1D95] text-2xl mb-1">folder_special</span>
                    <div class="text-xs font-bold font-mono text-slate-800">SYS-01 Projects</div>
                    <div class="text-[10px] text-slate-500 font-mono mt-1">Sprint tickets & OKRs</div>
                </div>
                <div class="p-4 rounded-xl bg-[#FDF6F0] border border-[#F5DEB3] text-center hover:border-[#E8C9A0] transition-colors">
                    <span class="material-symbols-outlined text-[#8C5E28] text-2xl mb-1">dataset</span>
                    <div class="text-xs font-bold font-mono text-slate-800">SYS-02 Data Center</div>
                    <div class="text-[10px] text-slate-500 font-mono mt-1">Feature store & Lineage</div>
                </div>
                <div class="p-4 rounded-xl bg-[#FDF6F0] border border-[#E8C9A0] text-center shadow-[0_2px_12px_rgba(232,201,160,0.25)]">
                    <span class="material-symbols-outlined text-[#8C5E28] text-2xl mb-1">precision_manufacturing</span>
                    <div class="text-xs font-bold font-mono text-[#8C5E28]">SYS-03 Workbench</div>
                    <div class="text-[10px] text-slate-500 font-mono mt-1">Training & Artifacts</div>
                </div>
                <div class="p-4 rounded-xl bg-[#F3E8FF] border border-[#4C1D95] text-center shadow-sm">
                    <span class="material-symbols-outlined text-[#4C1D95] text-2xl mb-1">rocket_launch</span>
                    <div class="text-xs font-bold font-mono text-[#4C1D95]">SYS-04 Registry</div>
                    <div class="text-[10px] text-slate-500 font-mono mt-1">Metadata & Artifacts</div>
                </div>
                <div class="p-4 rounded-xl bg-rose-50/60 border border-rose-200 text-center shadow-sm">
                    <span class="material-symbols-outlined text-rose-700 text-2xl mb-1">shield_with_heart</span>
                    <div class="text-xs font-bold font-mono text-rose-700">SYS-05 AI SOC</div>
                    <div class="text-[10px] text-slate-500 font-mono mt-1">Reviews & Audit</div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-16 border-t border-[#4C1D95]/15 bg-white/60 backdrop-blur py-8 text-center text-xs font-mono text-slate-500">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>VOSTOKPRIBOR AI · PERSISTED WORKFLOW // EXECUTION & DEPLOYMENT UNAVAILABLE</span>
            </div>
            <div class="flex items-center gap-4 text-[11px]">
                <a href="api/status.php" class="hover:text-[#4C1D95] transition-colors">Database Status</a>
                <span>·</span>
                <a href="api/exchange.php" class="hover:text-[#4C1D95] transition-colors">Exchange API</a>
                <span>·</span>
                <span class="text-slate-400"><?php echo htmlspecialchars(date("c")); ?></span>
            </div>
        </div>
    </footer>

<script src="assets/js/home.js"></script>
</body>

</html>