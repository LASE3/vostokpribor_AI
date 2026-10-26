<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthorizationMiddleware;
use App\Services\UserService;
use App\Core\Auth;
use App\Core\Csrf;

// Strict Admin-only Access
AuthorizationMiddleware::requireAdmin();

$currentUser = Auth::user();
$userService = new UserService();

$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');
$cohort = trim($_GET['cohort'] ?? '');

$filterParams = [];
if ($search !== '') $filterParams['search'] = $search;
if ($status !== '') $filterParams['status'] = $status;
if ($cohort !== '') $filterParams['cohort'] = $cohort;

$data = $userService->listStudents($filterParams, 100, 0);
$students = $data['items'];
$totalStudents = $data['total'];

$activeCount = 0;
$inactiveCount = 0;
foreach ($students as $s) {
    if ($s['status'] === 'ACTIVE') $activeCount++;
    else $inactiveCount++;
}

$csrfToken = Csrf::getToken();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <title>VOSTOKPRIBOR AI • SYS-AI-05 Cadet & Student Administration</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
    <style>
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
    </style>
</head>

<body class="fiberglass-bg font-sans text-on-surface min-h-screen selection:bg-secondary-fixed selection:text-primary">

    <!-- Top Mission Control Bar -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white/95 backdrop-blur-md border-b border-primary-container/15 shadow-sm z-50 flex items-center justify-between px-6">
        <div class="flex items-center gap-6">
            <a href="../index.php" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                <div class="w-10 h-10 rounded-xl bg-primary-container flex items-center justify-center text-white shadow-sm">
                    <span class="material-symbols-outlined text-2xl text-tertiary-fixed">satellite_alt</span>
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="font-mono text-sm font-extrabold text-primary tracking-wider uppercase">VOSTOKPRIBOR AI</span>
                        <span class="px-1.5 py-0.2 rounded text-[10px] font-mono bg-secondary-fixed text-primary font-bold">AVIONICS v4.8</span>
                    </div>
                    <span class="font-mono text-[11px] text-outline">SYS-AI-05 • AI Operations Center (AI SOC)</span>
                </div>
            </a>

            <div class="h-6 w-px bg-outline-variant/60 hidden md:block"></div>

            <!-- Subsystem Nav Pills -->
            <nav class="hidden xl:flex items-center gap-1.5 p-1 bg-surface-container-low rounded-xl border border-outline-variant/40 font-mono text-xs">
                <a href="../AI Project Management/Tickets.php" class="px-3 py-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-secondary-fixed/50 transition-colors">SYS-AI-01 <span class="text-[10px] text-outline">(Projects)</span></a>
                <a href="../Data Center/DatasetCatalog.php" class="px-3 py-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-secondary-fixed/50 transition-colors">SYS-AI-02 <span class="text-[10px] text-outline">(Data Lake)</span></a>
                <a href="../ML Workbench/NotebookWorkbench.php" class="px-3 py-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-secondary-fixed/50 transition-colors">SYS-AI-03 <span class="text-[10px] text-outline">(Workbench)</span></a>
                <a href="../Model Registry & Deployment/ModelRegistry.php" class="px-3 py-1.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-secondary-fixed/50 transition-colors">SYS-AI-04 <span class="text-[10px] text-outline">(Registry)</span></a>
                <a href="TicketsAndScenarios.php" class="px-3 py-1.5 rounded-lg bg-primary-container text-white font-bold shadow-sm flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>SYS-AI-05 (AI SOC)</span>
                </a>
            </nav>
        </div>

        <!-- Right Quick Telemetry & Instructor Profile -->
        <div class="flex items-center gap-4">
            <div class="hidden lg:flex items-center gap-2.5 px-3 py-1.5 rounded-xl bg-surface-container-low border border-outline-variant/50 text-xs font-mono">
                <span class="text-primary font-bold">CADET ROSTER:</span>
                <span class="text-emerald-700 font-semibold" id="header-student-count"><?= $totalStudents ?> ENROLLED</span>
            </div>

            <!-- Instructor Avatar & Logout -->
            <div class="flex items-center gap-3 pl-2 border-l border-outline-variant/50">
                <div class="flex flex-col text-right hidden sm:flex font-mono">
                    <span class="text-xs font-bold text-primary leading-tight"><?= htmlspecialchars($currentUser['full_name']) ?></span>
                    <span class="text-[10px] text-outline uppercase"><?= htmlspecialchars($currentUser['identifier']) ?> • ADMIN</span>
                </div>
                <div class="w-9 h-9 rounded-xl bg-primary-container text-white flex items-center justify-center font-mono font-bold text-sm shadow-sm">
                    <?= strtoupper(substr($currentUser['full_name'], 0, 2)) ?>
                </div>
                <a href="../logout.php" title="Logout" class="p-2 rounded-xl text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <aside class="fixed left-0 top-16 bottom-0 w-64 bg-white/95 backdrop-blur-md border-r border-primary-container/15 shadow-sm z-40 overflow-y-auto font-mono text-xs">
        <div class="p-4 flex flex-col gap-6">
            <!-- Section 1 -->
            <div class="flex flex-col gap-1">
                <div class="px-2 py-1 text-[10px] font-bold text-outline uppercase tracking-wider">Overview</div>
                <a href="Dashboard.php" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-on-surface-variant hover:bg-secondary-fixed hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">space_dashboard</span>
                    <span>SOC Wall Dashboard</span>
                </a>
                <a href="OperationsDashboard.php" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-on-surface-variant hover:bg-secondary-fixed hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">hub</span>
                    <span>Operations Telemetry</span>
                </a>
            </div>

            <!-- Section 2: Active Module -->
            <div class="flex flex-col gap-1">
                <div class="px-2 py-1 text-[10px] font-bold text-primary uppercase tracking-wider flex items-center justify-between">
                    <span>Training Management</span>
                </div>
                <a href="TicketsAndScenarios.php" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-on-surface-variant hover:bg-secondary-fixed hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">tune</span>
                    <span>Scenario Builder</span>
                </a>
                <a href="DatasetManagement.php" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-on-surface-variant hover:bg-secondary-fixed hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">database</span>
                    <span>Dataset Management</span>
                </a>
                <a href="StudentManagement.php" class="flex items-center gap-2.5 px-3 py-2 rounded-xl bg-primary-container text-white font-bold shadow-sm">
                    <span class="material-symbols-outlined text-[18px] text-tertiary-fixed">group</span>
                    <span>Cadet & Student Roster</span>
                </a>
                <a href="WorkspaceConfiguration.php" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-on-surface-variant hover:bg-secondary-fixed hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">fact_check</span>
                    <span>Submissions & Rubrics</span>
                </a>
            </div>

            <!-- Section 3: Platform Administration -->
            <div class="flex flex-col gap-1">
                <div class="px-2 py-1 text-[10px] font-bold text-outline uppercase tracking-wider">Platform Administration</div>
                <a href="StudentManagement.php" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-on-surface-variant hover:bg-secondary-fixed hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span>
                    <span>Users & Permissions</span>
                </a>
                <a href="OperationsDashboard.php" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-on-surface-variant hover:bg-secondary-fixed hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                    <span>Audit Trail Ledger</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Container -->
    <div class="pl-64">
        <main class="relative pt-20 pb-16 px-8 min-h-screen font-mono">
            <!-- Toast notification container -->
            <div id="toast" class="fixed bottom-6 right-6 z-50 transform translate-y-24 opacity-0 transition-all duration-300 px-4 py-3 rounded-xl shadow-xl flex items-center gap-2.5 text-xs text-white"></div>

            <!-- Page Title Bar -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <div class="flex items-center gap-2 text-xs uppercase tracking-wider text-primary font-bold mb-1">
                        <span class="material-symbols-outlined text-base">group</span>
                        <span>CADET ADMINISTRATION & SECURITY ROSTER</span>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Student Accounts & Flight Assignments</h1>
                    <p class="text-xs text-slate-600 mt-1">
                        Administrator-controlled enrollment. Cadets can only be created by mission directors. Public registration is locked.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button onclick="openCreateStudentModal()" class="px-4 py-2.5 rounded-xl bg-primary text-white hover:bg-primary/90 font-bold text-xs flex items-center gap-2 shadow-md hover:shadow-lg transition-all">
                        <span class="material-symbols-outlined text-sm">person_add</span>
                        <span>+ Enlist New Cadet</span>
                    </button>
                </div>
            </div>

            <!-- Metric Bento Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="p-4 rounded-xl bg-white border border-primary/10 shadow-sm">
                    <span class="text-[11px] text-slate-500 font-bold block mb-1">TOTAL ENROLLED</span>
                    <strong class="text-2xl text-primary font-extrabold" id="kpi-total"><?= $totalStudents ?></strong>
                </div>
                <div class="p-4 rounded-xl bg-white border border-primary/10 shadow-sm">
                    <span class="text-[11px] text-slate-500 font-bold block mb-1">ACTIVE CADETS</span>
                    <strong class="text-2xl text-emerald-700 font-extrabold" id="kpi-active"><?= $activeCount ?></strong>
                </div>
                <div class="p-4 rounded-xl bg-white border border-primary/10 shadow-sm">
                    <span class="text-[11px] text-slate-500 font-bold block mb-1">SUSPENDED / INACTIVE</span>
                    <strong class="text-2xl text-rose-700 font-extrabold" id="kpi-inactive"><?= $inactiveCount ?></strong>
                </div>
                <div class="p-4 rounded-xl bg-white border border-primary/10 shadow-sm">
                    <span class="text-[11px] text-slate-500 font-bold block mb-1">SECURITY STATUS</span>
                    <strong class="text-2xl text-primary font-extrabold flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span> LOCKED
                    </strong>
                </div>
            </div>

            <!-- Filters Bar -->
            <div class="p-4 rounded-xl bg-white border border-primary/10 shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4 text-xs">
                <form method="GET" class="flex flex-wrap items-center gap-3 flex-1">
                    <div class="relative w-full sm:w-64">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                        <input
                            type="text"
                            name="search"
                            value="<?= htmlspecialchars($search) ?>"
                            placeholder="Search name, email, or ID..."
                            class="w-full bg-[#F6F9FF] border border-primary/15 rounded-lg pl-9 pr-3 py-2 text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:border-primary"
                        />
                    </div>
                    <select name="status" class="bg-[#F6F9FF] border border-primary/15 rounded-lg px-3 py-2 text-xs text-slate-700 focus:outline-none">
                        <option value="">All Statuses</option>
                        <option value="ACTIVE" <?= $status === 'ACTIVE' ? 'selected' : '' ?>>Active</option>
                        <option value="INACTIVE" <?= $status === 'INACTIVE' ? 'selected' : '' ?>>Inactive</option>
                        <option value="SUSPENDED" <?= $status === 'SUSPENDED' ? 'selected' : '' ?>>Suspended</option>
                    </select>
                    <button type="submit" class="px-3.5 py-2 rounded-lg bg-surface-container-low hover:bg-secondary-fixed text-primary font-bold">
                        Filter
                    </button>
                    <?php if ($search || $status || $cohort): ?>
                        <a href="StudentManagement.php" class="px-3 py-2 text-slate-500 hover:text-primary">Reset</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Cadet Roster Table -->
            <div class="bg-white rounded-xl border border-primary/10 shadow-sm overflow-hidden mb-10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-[#F6F9FF] text-slate-500 font-bold border-b border-primary/10 uppercase tracking-wider text-[10px]">
                                <th class="py-3 px-4">Cadet Identifier</th>
                                <th class="py-3 px-4">Full Name</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4">Cohort</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 text-center">Tickets</th>
                                <th class="py-3 px-4 text-center">Submissions</th>
                                <th class="py-3 px-4 text-center">Notebooks</th>
                                <th class="py-3 px-4 text-center">Models</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-primary/5 text-slate-700" id="student-table-body">
                            <?php if (empty($students)): ?>
                                <tr>
                                    <td colspan="10" class="py-12 text-center text-slate-500">
                                        <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">person_off</span>
                                        <strong>No Cadet Accounts Found</strong>
                                        <p class="text-[11px] mt-1 text-slate-400">Zero student accounts enrolled. Click "+ Enlist New Cadet" above to provision the first cadet account.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($students as $s): ?>
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="py-3.5 px-4 font-bold text-primary">
                                            <?= htmlspecialchars($s['identifier']) ?>
                                        </td>
                                        <td class="py-3.5 px-4 font-semibold text-slate-900">
                                            <?= htmlspecialchars($s['full_name']) ?>
                                        </td>
                                        <td class="py-3.5 px-4 text-slate-600">
                                            <?= htmlspecialchars($s['email']) ?>
                                        </td>
                                        <td class="py-3.5 px-4 text-slate-600">
                                            <?= htmlspecialchars($s['cohort'] ?? 'General') ?>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <?php if ($s['status'] === 'ACTIVE'): ?>
                                                <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-50 text-emerald-800 border border-emerald-300 font-bold">ACTIVE</span>
                                            <?php else: ?>
                                                <span class="px-2 py-0.5 rounded text-[10px] bg-rose-50 text-rose-800 border border-rose-300 font-bold"><?= htmlspecialchars($s['status']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                            <?= (int)$s['tickets_count'] ?>
                                        </td>
                                        <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                            <?= (int)$s['submissions_count'] ?>
                                        </td>
                                        <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                            <?= (int)$s['notebooks_count'] ?>
                                        </td>
                                        <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                            <?= (int)$s['models_count'] ?>
                                        </td>
                                        <td class="py-3.5 px-4 text-right">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <button onclick="viewDossier(<?= (int)$s['id'] ?>)" title="View Cadet Dossier" class="p-1.5 rounded-lg bg-surface-container-low hover:bg-secondary-fixed text-primary transition-colors">
                                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                                </button>
                                                <button onclick="openResetPasswordModal(<?= (int)$s['id'] ?>, this.dataset.name)" data-name="<?= htmlspecialchars($s['full_name'], ENT_QUOTES, 'UTF-8') ?>" title="Reset Password" class="p-1.5 rounded-lg bg-surface-container-low hover:bg-secondary-fixed text-primary transition-colors">
                                                    <span class="material-symbols-outlined text-sm">key</span>
                                                </button>
                                                <button onclick="toggleStudentStatus(<?= (int)$s['id'] ?>, '<?= $s['status'] === 'ACTIVE' ? 'INACTIVE' : 'ACTIVE' ?>')" title="<?= $s['status'] === 'ACTIVE' ? 'Deactivate' : 'Activate' ?>" class="p-1.5 rounded-lg <?= $s['status'] === 'ACTIVE' ? 'hover:bg-rose-50 text-rose-600' : 'hover:bg-emerald-50 text-emerald-600' ?> transition-colors">
                                                    <span class="material-symbols-outlined text-sm"><?= $s['status'] === 'ACTIVE' ? 'person_off' : 'how_to_reg' ?></span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MODAL: Enlist New Cadet -->
            <div id="modal-create-student" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-primary/20 relative">
                    <div class="flex items-center justify-between pb-4 border-b border-primary/10 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-2xl">person_add</span>
                            <h3 class="font-bold text-primary uppercase text-sm">Enlist New Cadet Account</h3>
                        </div>
                        <button onclick="closeModal('modal-create-student')" class="text-slate-400 hover:text-slate-700">
                            <span class="material-symbols-outlined text-xl">close</span>
                        </button>
                    </div>

                    <form id="form-create-student" onsubmit="handleCreateStudent(event)" class="space-y-4 text-xs">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>" />

                        <div>
                            <label class="block font-bold text-slate-700 uppercase mb-1">Full Name</label>
                            <input type="text" name="full_name" required placeholder="Student full name" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 uppercase mb-1">Cadet Identifier</label>
                                <input type="text" name="identifier" required placeholder="e.g. VK-88219" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary uppercase" />
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 uppercase mb-1">Email Address</label>
                                <input type="email" name="email" required placeholder="e.g. alexey.morozov@vostokpribor.space" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 uppercase mb-1">Cohort Designation</label>
                                <input type="text" name="cohort" value="" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 uppercase mb-1">Department</label>
                                <input type="text" name="department" value="" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 uppercase mb-1">Initial Access Password</label>
                            <input type="password" name="password" required minlength="12" maxlength="72" placeholder="12 to 72 characters" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" id="must_change_password" name="must_change_password" value="1" checked class="rounded border-primary/30 text-primary focus:ring-0" />
                            <label for="must_change_password" class="text-slate-600 font-medium">Require password reset upon first logon</label>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-primary/10">
                            <button type="button" onclick="closeModal('modal-create-student')" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Cancel</button>
                            <button type="submit" id="btn-submit-student" class="px-5 py-2 rounded-xl bg-primary text-white font-bold hover:bg-primary/90 flex items-center gap-1.5 shadow-md">
                                <span>Provision Account</span>
                                <span class="material-symbols-outlined text-sm">check</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MODAL: Reset Password -->
            <div id="modal-reset-password" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-primary/20 relative">
                    <div class="flex items-center justify-between pb-3 border-b border-primary/10 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-xl">key</span>
                            <h3 class="font-bold text-primary uppercase text-sm">Reset Cadet Password</h3>
                        </div>
                        <button onclick="closeModal('modal-reset-password')" class="text-slate-400 hover:text-slate-700">
                            <span class="material-symbols-outlined text-xl">close</span>
                        </button>
                    </div>

                    <form id="form-reset-password" onsubmit="handleResetPassword(event)" class="space-y-4 text-xs">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>" />
                        <input type="hidden" id="reset-student-id" name="student_id" value="" />

                        <div>
                            <p class="text-slate-600 mb-2">Resetting password for: <strong id="reset-student-name" class="text-slate-900"></strong></p>
                            <label class="block font-bold text-slate-700 uppercase mb-1">New Strong Password</label>
                            <input type="password" name="new_password" required minlength="12" maxlength="72" placeholder="12 to 72 characters" class="w-full bg-[#F6F9FF] border border-primary/20 rounded-xl px-3.5 py-2 focus:outline-none focus:border-primary" />
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-primary/10">
                            <button type="button" onclick="closeModal('modal-reset-password')" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Cancel</button>
                            <button type="submit" class="px-4 py-2 rounded-xl bg-primary text-white font-bold hover:bg-primary/90">Apply Reset</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MODAL: Cadet Dossier Slide-Over / Modal -->
            <div id="modal-dossier" class="fixed inset-0 bg-primary/40 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[85vh] p-6 shadow-2xl border border-primary/20 relative flex flex-col">
                    <div class="flex items-center justify-between pb-3 border-b border-primary/10 mb-4 shrink-0">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-2xl">badge</span>
                            <h3 class="font-bold text-primary uppercase text-sm" id="dossier-title">Cadet Dossier</h3>
                        </div>
                        <button onclick="closeModal('modal-dossier')" class="text-slate-400 hover:text-slate-700">
                            <span class="material-symbols-outlined text-xl">close</span>
                        </button>
                    </div>

                    <div class="flex-1 overflow-y-auto space-y-6 text-xs" id="dossier-content">
                        <!-- Filled by JS -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const CSRF_TOKEN = "<?= htmlspecialchars($csrfToken) ?>";

        function showToast(msg, isError = false) {
            const toast = document.getElementById('toast');
            toast.innerText = msg;
            toast.className = `fixed bottom-6 right-6 z-50 px-4 py-3 rounded-xl shadow-xl flex items-center gap-2.5 text-xs text-white transition-all duration-300 ${isError ? 'bg-rose-700' : 'bg-primary'}`;
            toast.classList.remove('translate-y-24', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
            setTimeout(() => {
                toast.classList.add('translate-y-24', 'opacity-0');
                toast.classList.remove('translate-y-0', 'opacity-100');
            }, 3000);
        }

        function openModal(id) {
            document.getElementById(id)?.classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id)?.classList.add('hidden');
        }

        function openCreateStudentModal() {
            openModal('modal-create-student');
        }

        function openResetPasswordModal(id, name) {
            document.getElementById('reset-student-id').value = id;
            document.getElementById('reset-student-name').innerText = name;
            openModal('modal-reset-password');
        }

        async function handleCreateStudent(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-submit-student');
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-sm">sync</span> Provisioning...';

            const form = e.target;
            const payload = {
                full_name: form.full_name.value.trim(),
                identifier: form.identifier.value.trim(),
                email: form.email.value.trim(),
                cohort: form.cohort.value.trim(),
                department: form.department.value.trim(),
                password: form.password.value,
                must_change_password: form.must_change_password.checked ? 1 : 0
            };

            try {
                const res = await fetch('../api/v1/users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify(payload)
                });
                const json = await res.json();
                if (json.success) {
                    showToast('Cadet successfully enlisted and provisioned!');
                    closeModal('modal-create-student');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    showToast(json.error?.message || 'Provisioning failed', true);
                    btn.disabled = false;
                    btn.innerHTML = '<span>Provision Account</span><span class="material-symbols-outlined text-sm">check</span>';
                }
            } catch (err) {
                showToast('Network error during provisioning', true);
                btn.disabled = false;
                btn.innerHTML = '<span>Provision Account</span><span class="material-symbols-outlined text-sm">check</span>';
            }
        }

        async function handleResetPassword(e) {
            e.preventDefault();
            const form = e.target;
            const id = form.student_id.value;
            const newPassword = form.new_password.value;

            try {
                const res = await fetch(`../api/v1/users/${id}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ password: newPassword })
                });
                const json = await res.json();
                if (json.success) {
                    showToast('Cadet password reset successfully.');
                    closeModal('modal-reset-password');
                    form.reset();
                } else {
                    showToast(json.error?.message || 'Password reset failed', true);
                }
            } catch (err) {
                showToast('Network error during password reset', true);
            }
        }

        async function toggleStudentStatus(id, newStatus) {
            if (!confirm(`Are you sure you want to set cadet status to ${newStatus}?`)) return;

            try {
                const res = await fetch(`../api/v1/users/${id}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ status: newStatus })
                });
                const json = await res.json();
                if (json.success) {
                    showToast(`Cadet status updated to ${newStatus}`);
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    showToast(json.error?.message || 'Status update failed', true);
                }
            } catch (err) {
                showToast('Network error updating status', true);
            }
        }

        function escapeDossier(value) {
            if (Array.isArray(value)) return value.map(escapeDossier);
            if (value && typeof value === 'object') return Object.fromEntries(Object.entries(value).map(([key,item]) => [key,escapeDossier(item)]));
            return typeof value === 'string' ? value.replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])) : value;
        }
        async function viewDossier(id) {
            openModal('modal-dossier');
            const container = document.getElementById('dossier-content');
            container.innerHTML = '<div class="py-8 text-center text-slate-500"><span class="material-symbols-outlined animate-spin text-2xl">sync</span><p class="mt-2">Retrieving flight dossier...</p></div>';

            try {
                const res = await fetch(`../api/v1/users/${id}`);
                const json = await res.json();
                if (!json.success || !json.data) {
                    container.innerHTML = '<p class="text-rose-600">Failed to load dossier.</p>';
                    return;
                }

                const d = escapeDossier(json.data);
                const p = d.profile;
                document.getElementById('dossier-title').innerText = `Dossier: ${json.data.profile.full_name} (${json.data.profile.identifier})`;

                container.innerHTML = `
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 p-3 bg-surface-container-low rounded-xl">
                        <div><span class="text-slate-400 block text-[10px]">COHORT</span><strong>${p.cohort || 'N/A'}</strong></div>
                        <div><span class="text-slate-400 block text-[10px]">EMAIL</span><strong>${p.email}</strong></div>
                        <div><span class="text-slate-400 block text-[10px]">STATUS</span><strong>${p.status}</strong></div>
                        <div><span class="text-slate-400 block text-[10px]">ENROLLED</span><strong>${p.created_at.split(' ')[0]}</strong></div>
                    </div>

                    <div>
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">assignment</span> Assigned Tickets (${d.tickets.length})
                        </h4>
                        ${d.tickets.length === 0 ? '<p class="text-slate-400 italic">No tickets assigned yet.</p>' : `
                            <div class="space-y-1.5">
                                ${d.tickets.map(t => `
                                    <div class="p-2.5 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between">
                                        <div><strong class="text-primary">${t.ticket_code}</strong>: ${t.title}</div>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-secondary-fixed text-primary">${t.status}</span>
                                    </div>
                                `).join('')}
                            </div>
                        `}
                    </div>

                    <div>
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">database</span> Assigned Datasets (${d.datasets.length})
                        </h4>
                        ${d.datasets.length === 0 ? '<p class="text-slate-400 italic">No datasets linked.</p>' : `
                            <div class="space-y-1.5">
                                ${d.datasets.map(ds => `
                                    <div class="p-2 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between">
                                        <div><strong>${ds.code}</strong> - ${ds.name}</div>
                                        <span class="text-slate-500 font-mono text-[10px]">${(ds.file_size / 1024).toFixed(1)} KB</span>
                                    </div>
                                `).join('')}
                            </div>
                        `}
                    </div>

                    <div>
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">terminal</span> Notebooks (${d.notebooks.length})
                        </h4>
                        ${d.notebooks.length === 0 ? '<p class="text-slate-400 italic">No notebooks created yet.</p>' : `
                            <div class="space-y-1.5">
                                ${d.notebooks.map(nb => `
                                    <div class="p-2 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between">
                                        <div><strong>${nb.code}</strong>: ${nb.title}</div>
                                        <span class="text-emerald-700 font-bold">${nb.status}</span>
                                    </div>
                                `).join('')}
                            </div>
                        `}
                    </div>

                    <div>
                        <h4 class="font-bold text-primary mb-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-sm">fact_check</span> Deliverables & Submissions (${d.submissions.length})
                        </h4>
                        ${d.submissions.length === 0 ? '<p class="text-slate-400 italic">No deliverables submitted.</p>' : `
                            <div class="space-y-1.5">
                                ${d.submissions.map(sub => `
                                    <div class="p-2 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-between">
                                        <div><strong>${sub.submission_code}</strong> (Iteration #${sub.iteration}) - ${sub.ticket_code}</div>
                                        <div>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold ${sub.status === 'APPROVED' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'}">${sub.status}</span>
                                            ${sub.total_score !== null ? `<span class="ml-2 font-bold text-primary">${sub.total_score}/100</span>` : ''}
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        `}
                    </div>
                `;
            } catch (err) {
                container.innerHTML = '<p class="text-rose-600">Error fetching dossier.</p>';
            }
        }
    </script>
</body>

</html>
