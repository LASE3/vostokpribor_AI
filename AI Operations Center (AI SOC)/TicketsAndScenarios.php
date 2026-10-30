<?php
// VOSTOKPRIBOR AI • SYS-AI-05: AI Operations Center (AI SOC)
// Dynamic Training Scenario Management Module & Authoring Suite
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthorizationMiddleware;
use App\Core\Database;
use App\Core\Auth;
use App\Core\Csrf;

// Enforce Administrator Authorization
AuthorizationMiddleware::requireAdmin();
$currentUser = Auth::user();
$db = Database::getInstance();

// Load dynamic DB records
$scenarios = $db->fetchAll("SELECT * FROM scenarios ORDER BY created_at DESC");
$tickets = $db->fetchAll("
    SELECT t.*, s.title AS scenario_title, u.full_name AS student_name, u.identifier AS student_identifier
    FROM tickets t
    LEFT JOIN scenarios s ON t.scenario_id = s.id
    LEFT JOIN ticket_assignments ta ON t.id = ta.ticket_id AND ta.revoked_at IS NULL
    LEFT JOIN users u ON ta.student_id = u.id
    ORDER BY t.created_at DESC
");
$students = $db->fetchAll("SELECT id, full_name, identifier, email, cohort FROM users WHERE role = 'STUDENT' AND status = 'ACTIVE' ORDER BY full_name ASC");
$datasets = $db->fetchAll("SELECT id, code, name, format FROM datasets ORDER BY created_at DESC");

require_once __DIR__ . '/../app/Views/Layout/AppLayout.php';

use App\Views\Layout\AppLayout;

AppLayout::start([
    'pageTitle' => 'VOSTOKPRIBOR AI · Dynamic Training Scenario Builder',
    'systemKey' => 'soc',
    'activePage' => 'TicketsAndScenarios.php',
    'currentUser' => $currentUser,
    'extraHeadHtml' => '
        <link rel="stylesheet" href="css/style.css" />
    ',
]);
?>

<!-- Breadcrumbs & Module Title Banner -->
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
    <div>
        <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-wider text-outline mb-1.5">
            <span class="px-2 py-0.5 rounded bg-primary-container text-white font-bold">SYS-AI-05</span>
            <span>/</span>
            <span class="text-primary font-semibold">AI Operations Center</span>
            <span>/</span>
            <span>Dynamic Training Scenario Builder & Lifecycle Matrix</span>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <h1 class="text-2xl md:text-3xl font-extrabold font-mono text-primary tracking-tight">
                Training Scenario Management
            </h1>
            <span class="px-3 py-1 rounded-full text-xs font-mono bg-secondary-fixed text-primary font-bold border border-secondary-container flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span id="scenario-counter-badge">Loading persisted scenarios…</span>
            </span>
        </div>
        <p class="text-xs md:text-sm text-on-surface-variant mt-1.5 max-w-3xl">
            Autonomous administrative flight deck. Instructors can author, configure, version, publish, and evaluate end-to-end multi-step AI scenarios using persisted records across SYS-AI-01 through SYS-AI-05.
        </p>
    </div>

    <!-- Primary Action Hub -->
    <div class="flex items-center gap-2.5 flex-wrap">
        <button onclick="openIntegrationMonitorModal()" class="px-3.5 py-2 rounded-xl bg-white hover:bg-secondary-fixed text-primary border border-outline-variant font-mono font-semibold text-xs shadow-sm transition-all flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[18px] text-emerald-600">sync_alt</span>
            <span>Integration Hub</span>
        </button>
        <button onclick="exportAllScenariosJson()" title="Export Scenarios JSON" class="px-3.5 py-2 rounded-xl bg-white hover:bg-secondary-fixed text-primary border border-outline-variant font-mono font-semibold text-xs shadow-sm transition-all flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[18px]">download</span>
            <span>Export JSON</span>
        </button>
        <label title="Import Scenarios JSON" class="px-3.5 py-2 rounded-xl bg-white hover:bg-secondary-fixed text-primary border border-outline-variant font-mono font-semibold text-xs shadow-sm transition-all flex items-center gap-1.5 cursor-pointer">
            <span class="material-symbols-outlined text-[18px]">upload</span>
            <span>Import JSON</span>
            <input type="file" id="import-json-file" accept=".json" class="hidden" onchange="importScenariosJson(event)">
        </label>
        <button onclick="openScenarioBuilderModal(null)" class="px-4 py-2.5 rounded-xl bg-primary-container hover:bg-primary text-white font-mono font-bold text-xs shadow-md transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] text-tertiary-fixed">add_task</span>
            <span>Create New Scenario</span>
        </button>
    </div>
</div>

<!-- Top Telemetry KPI Cards -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-3.5 mb-8 font-mono">
    <div class="precision-card p-4 rounded-xl flex flex-col justify-between">
        <span class="text-[11px] text-outline font-semibold uppercase flex items-center justify-between">
            <span>Total Scenarios</span>
            <span class="material-symbols-outlined text-[16px] text-primary">inventory_2</span>
        </span>
        <div class="mt-2 flex items-baseline justify-between">
            <span class="text-2xl font-bold text-primary" id="kpi-total-scenarios">0</span>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-surface-container font-semibold">MYSQL</span>
        </div>
    </div>

    <div class="precision-card p-4 rounded-xl flex flex-col justify-between">
        <span class="text-[11px] text-outline font-semibold uppercase flex items-center justify-between">
            <span>Active / Published</span>
            <span class="material-symbols-outlined text-[16px] text-emerald-600">verified</span>
        </span>
        <div class="mt-2 flex items-baseline justify-between">
            <span class="text-2xl font-bold text-emerald-700" id="kpi-active-published">0</span>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold">PERSISTED</span>
        </div>
    </div>

    <div class="precision-card p-4 rounded-xl flex flex-col justify-between">
        <span class="text-[11px] text-outline font-semibold uppercase flex items-center justify-between">
            <span>Cadets In Training</span>
            <span class="material-symbols-outlined text-[16px] text-primary">groups</span>
        </span>
        <div class="mt-2 flex items-baseline justify-between">
            <span class="text-2xl font-bold text-primary" id="kpi-total-students">0</span>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-tertiary-fixed text-tertiary font-bold"><?= count(array_unique(array_filter(array_column($students, 'cohort')))) ?> COHORTS</span>
        </div>
    </div>

    <div class="precision-card p-4 rounded-xl flex flex-col justify-between">
        <span class="text-[11px] text-outline font-semibold uppercase flex items-center justify-between">
            <span>Associated Tickets</span>
            <span class="material-symbols-outlined text-[16px] text-secondary">confirmation_number</span>
        </span>
        <div class="mt-2 flex items-baseline justify-between">
            <span class="text-2xl font-bold text-secondary" id="kpi-total-tickets">0</span>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-secondary-fixed text-primary font-bold">MYSQL</span>
        </div>
    </div>

    <div class="precision-card p-4 rounded-xl flex flex-col justify-between">
        <span class="text-[11px] text-outline font-semibold uppercase flex items-center justify-between">
            <span>Trusted Eval Runner</span>
            <span class="material-symbols-outlined text-[16px] text-primary">balance</span>
        </span>
        <div class="mt-2 flex items-baseline justify-between">
            <span class="text-2xl font-bold text-primary" id="kpi-total-gates">N/A</span>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-secondary-fixed text-primary font-bold">UNCONFIGURED</span>
        </div>
    </div>
</div>

<!-- View Switcher Tabs & Filter Toolbar -->
<div class="precision-card p-4 rounded-2xl mb-8 flex flex-col gap-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Master View Switcher -->
        <div class="flex items-center gap-1.5 bg-surface-container-low p-1.5 rounded-xl border border-outline-variant/40 font-mono text-xs">
            <button id="view-mode-grid-btn" onclick="setViewMode('grid')" class="px-3.5 py-2 rounded-lg bg-primary-container text-white font-bold shadow-sm flex items-center gap-1.5 transition-all">
                <span class="material-symbols-outlined text-[16px]">grid_view</span>
                <span>Scenario Grid</span>
            </button>
            <button id="view-mode-table-btn" onclick="setViewMode('table')" class="px-3.5 py-2 rounded-lg text-on-surface-variant hover:text-primary hover:bg-secondary-fixed/50 font-medium flex items-center gap-1.5 transition-all">
                <span class="material-symbols-outlined text-[16px]">table_rows</span>
                <span>Table Catalog</span>
            </button>
            <button id="view-mode-roadmap-btn" onclick="setViewMode('roadmap')" class="px-3.5 py-2 rounded-lg text-on-surface-variant hover:text-primary hover:bg-secondary-fixed/50 font-medium flex items-center gap-1.5 transition-all">
                <span class="material-symbols-outlined text-[16px]">account_tree</span>
                <span>Scenario Roadmap</span>
            </button>
        </div>

        <!-- Search Input -->
        <div class="relative w-full md:w-80 font-mono">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">search</span>
            <input id="catalog-search" type="text" placeholder="Search ID, title, dept, instructor..." oninput="handleSearchFilterChange()"
                class="w-full bg-surface-container-low border border-outline-variant/50 rounded-xl pl-9 pr-8 py-2 text-xs text-on-surface placeholder-outline focus:border-primary-container focus:bg-white outline-none transition-all shadow-inner" />
            <button id="clear-search-btn" onclick="clearSearch()" class="hidden absolute right-2.5 top-1/2 -translate-y-1/2 text-outline hover:text-primary text-xs">
                <span class="material-symbols-outlined text-[16px]">cancel</span>
            </button>
        </div>
    </div>

    <!-- Secondary Filter Strip -->
    <div class="flex items-center justify-between gap-3 flex-wrap pt-3 border-t border-outline-variant/30 font-mono text-xs">
        <!-- Lifecycle Filter Pills -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 max-w-full">
            <span class="text-[10px] text-outline font-bold uppercase mr-1 whitespace-nowrap">Lifecycle:</span>
            <button onclick="setLifecycleFilter('ALL')" id="filter-status-ALL" class="status-filter-pill px-2.5 py-1 rounded-lg bg-primary-container text-white font-bold text-[11px] whitespace-nowrap shadow-sm">All</button>
            <button onclick="setLifecycleFilter('Draft')" id="filter-status-Draft" class="status-filter-pill px-2.5 py-1 rounded-lg bg-surface-container-low text-on-surface-variant hover:text-primary font-medium text-[11px] whitespace-nowrap">Draft</button>
            <button onclick="setLifecycleFilter('Ready for Review')" id="filter-status-Ready for Review" class="status-filter-pill px-2.5 py-1 rounded-lg bg-surface-container-low text-on-surface-variant hover:text-primary font-medium text-[11px] whitespace-nowrap">Review</button>
            <button onclick="setLifecycleFilter('Published')" id="filter-status-Published" class="status-filter-pill px-2.5 py-1 rounded-lg bg-surface-container-low text-on-surface-variant hover:text-primary font-medium text-[11px] whitespace-nowrap">Published</button>
            <button onclick="setLifecycleFilter('Active')" id="filter-status-Active" class="status-filter-pill px-2.5 py-1 rounded-lg bg-surface-container-low text-on-surface-variant hover:text-primary font-medium text-[11px] whitespace-nowrap">Active</button>
            <button onclick="setLifecycleFilter('Completed')" id="filter-status-Completed" class="status-filter-pill px-2.5 py-1 rounded-lg bg-surface-container-low text-on-surface-variant hover:text-primary font-medium text-[11px] whitespace-nowrap">Completed</button>
            <button onclick="setLifecycleFilter('Archived')" id="filter-status-Archived" class="status-filter-pill px-2.5 py-1 rounded-lg bg-surface-container-low text-on-surface-variant hover:text-primary font-medium text-[11px] whitespace-nowrap">Archived</button>
        </div>

        <!-- Dropdown Selectors: Track & Department -->
        <div class="flex items-center gap-2">
            <!-- Progression Level Filter -->
            <select id="filter-progression-level" onchange="handleSearchFilterChange()" class="px-2.5 py-1.5 rounded-lg bg-surface-container-low border border-outline-variant/40 text-on-surface text-[11px] focus:outline-none focus:border-primary-container">
                <option value="ALL">All Progression Levels</option>
                <option value="Level 1">Level 1 — AI Fundamentals</option>
                <option value="Level 2">Level 2 — AI Engineer</option>
                <option value="Level 3">Level 3 — AI Production</option>
            </select>

            <!-- Category Track Filter -->
            <select id="filter-category" onchange="handleSearchFilterChange()" class="px-2.5 py-1.5 rounded-lg bg-surface-container-low border border-outline-variant/40 text-on-surface text-[11px] focus:outline-none focus:border-primary-container">
                <option value="ALL">All AI Categories</option>
                <option value="Predictive AI">Predictive AI (Tabular)</option>
                <option value="Streaming Anomaly">Streaming & Fraud</option>
                <option value="Computer Vision">Computer Vision</option>
                <option value="NLP">NLP & Classifiers</option>
                <option value="Generative AI">GenAI & RAG</option>
                <option value="Autonomous Agents">Autonomous Agents</option>
                <option value="AI SOC & Safety">AI SOC & Drift</option>
            </select>

            <!-- Department Filter -->
            <select id="filter-department" onchange="handleSearchFilterChange()" class="px-2.5 py-1.5 rounded-lg bg-surface-container-low border border-outline-variant/40 text-on-surface text-[11px] focus:outline-none focus:border-primary-container">
                <option value="ALL">All Departments</option>
                <option value="Customer Retention Operations">Customer Retention</option>
                <option value="Financial Crime & Compliance">Financial Crime</option>
                <option value="Aerospace Quality Assurance">Aerospace QA</option>
                <option value="Global Support Operations">Global Support</option>
                <option value="People Operations & HR">People Ops & HR</option>
                <option value="AI Automation Systems">AI Automation</option>
                <option value="Mission Telemetry & Reliability">Telemetry & Reliability</option>
            </select>
        </div>
    </div>
</div>

<!-- VIEW CONTAINER 1: SCENARIO CARD GRID VIEW -->
<section id="view-container-grid" class="space-y-6">
    <div class="flex items-center justify-between font-mono text-xs text-outline px-1">
        <span id="results-count-text">Loading scenarios…</span>
        <span>Sort: Pedagogical Order (Level 1 → 3)</span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="scenarios-grid-cards">
        <!-- Populated dynamically via JavaScript -->
    </div>
</section>

<!-- VIEW CONTAINER 2: SCENARIO TABLE CATALOG VIEW -->
<section id="view-container-table" class="hidden precision-card rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left font-mono text-xs border-collapse">
            <thead>
                <tr class="bg-surface-container-low border-b border-outline-variant/40 text-outline text-[11px] uppercase tracking-wider">
                    <th class="p-3.5 pl-5">Scenario ID & Title</th>
                    <th class="p-3.5">Category & Track</th>
                    <th class="p-3.5">Difficulty</th>
                    <th class="p-3.5">Department</th>
                    <th class="p-3.5 text-center">Tickets</th>
                    <th class="p-3.5 text-center">Students</th>
                    <th class="p-3.5">Status</th>
                    <th class="p-3.5">Version</th>
                    <th class="p-3.5">Instructor</th>
                    <th class="p-3.5 text-right pr-5">Actions</th>
                </tr>
            </thead>
            <tbody id="scenarios-table-rows" class="divide-y divide-outline-variant/20 bg-white">
                <!-- Populated dynamically via JavaScript -->
            </tbody>
        </table>
    </div>
</section>

<!-- VIEW CONTAINER 3: SCENARIO ROADMAP VIEW -->
<section id="view-container-roadmap" class="hidden space-y-8">
    <div class="precision-card p-6 rounded-2xl">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-container text-white flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-2xl text-tertiary-fixed">route</span>
                </div>
                <div>
                    <h2 class="text-lg font-bold font-mono text-primary">Avionics ML Curriculum Roadmap</h2>
                    <p class="text-xs text-outline font-mono">Pedagogical progression from foundational classifiers to mission-critical AI SOC live drift triage</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full bg-secondary-fixed text-primary font-mono font-bold text-xs">
                3 Rigorous Mastery Levels
            </span>
        </div>

        <!-- Level 1: AI Fundamentals -->
        <div class="mt-6 border-l-4 border-emerald-500 pl-4 py-2 mb-8">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-mono font-bold text-xs">LEVEL 1</span>
                    <h3 class="text-base font-bold font-mono text-slate-900">AI Fundamentals Track</h3>
                </div>
                <span class="text-xs font-mono text-outline">Core Competencies: Feature Pipelines, Imbalance, Vision Segmentation, Multi-Class NLP</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" id="roadmap-level-1-cards">
                <!-- Populated dynamically -->
            </div>
        </div>

        <!-- Level 2: AI Engineer -->
        <div class="border-l-4 border-[#4C1D95] pl-4 py-2 mb-8">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded bg-[#F3E8FF] text-[#4C1D95] font-mono font-bold text-xs">LEVEL 2</span>
                    <h3 class="text-base font-bold font-mono text-slate-900">AI Engineer Track</h3>
                </div>
                <span class="text-xs font-mono text-outline">Core Competencies: Vector Embeddings, RAG Faithfulness, Autonomous ReAct Tool Loops</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="roadmap-level-2-cards">
                <!-- Populated dynamically -->
            </div>
        </div>

        <!-- Level 3: AI Production -->
        <div class="border-l-4 border-rose-500 pl-4 py-2">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded bg-rose-100 text-rose-800 font-mono font-bold text-xs">LEVEL 3</span>
                    <h3 class="text-base font-bold font-mono text-slate-900">AI Production & Operations</h3>
                </div>
                <span class="text-xs font-mono text-outline">Core Competencies: 24/7 SOC Telemetry, KS-Drift Investigation, Blue/Green Instant Rollbacks</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4" id="roadmap-level-3-cards">
                <!-- Populated dynamically -->
            </div>
        </div>
    </div>
</section>

<section id="ticket-management" class="precision-card p-6 rounded-2xl mt-8 space-y-4 font-mono text-xs">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-bold text-primary">Tickets &amp; Assignments</h2><a href="StudentManagement.php" class="text-primary underline">Student management</a><a href="WorkspaceConfiguration.php" class="text-primary underline">Submission reviews</a>
    </div>
    <form onsubmit="createSocTicket(event)" class="grid grid-cols-1 md:grid-cols-2 gap-3" method="post">
        <label>Ticket code<input name="ticket_code" required minlength="3" maxlength="64" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40"></label>
        <label>Title<input name="title" required minlength="3" maxlength="255" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40"></label>
        <label>Scenario<select name="scenario_id" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40">
                <option value="">No scenario</option><?php foreach ($scenarios as $scenario): ?><option value="<?= (int)$scenario['id'] ?>"><?= htmlspecialchars($scenario['code'] . ' — ' . $scenario['title']) ?></option><?php endforeach; ?>
            </select></label>
        <label>Student<select name="student_id" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40">
                <option value="">Unassigned</option><?php foreach ($students as $student): ?><option value="<?= (int)$student['id'] ?>"><?= htmlspecialchars($student['identifier'] . ' — ' . $student['full_name']) ?></option><?php endforeach; ?>
            </select></label>
        <label>Deadline<input type="datetime-local" name="deadline" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40"></label>
        <label>Priority<select name="priority" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40">
                <option>MEDIUM</option>
                <option>LOW</option>
                <option>HIGH</option>
                <option>CRITICAL</option>
            </select></label>
        <?php foreach (['description' => 'Description', 'requirements' => 'Requirements', 'acceptance_criteria' => 'Acceptance criteria'] as $name => $label): ?><label><?= $label ?><textarea name="<?= $name ?>" rows="3" required class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40"></textarea></label><?php endforeach; ?>
        <div class="flex items-end"><button class="px-4 py-2 rounded-xl bg-primary-container text-white font-bold">Create Ticket</button></div>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-surface-container-low text-outline">
                <tr>
                    <th class="p-3">Ticket</th>
                    <th class="p-3">Student</th>
                    <th class="p-3">Scenario</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Deadline</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/30"><?php if (!$tickets): ?><tr>
                        <td colspan="5" class="p-8 text-center text-outline">No tickets</td>
                    </tr><?php endif; ?><?php foreach ($tickets as $ticket): ?><tr>
                        <td class="p-3"><button type="button" class="text-primary underline text-left" onclick="openSocTicketModal(<?= (int)$ticket['id'] ?>)"><?= htmlspecialchars($ticket['ticket_code'] . ' — ' . $ticket['title']) ?></button></td>
                        <td class="p-3"><?= htmlspecialchars($ticket['student_name'] ?? 'Unassigned') ?></td>
                        <td class="p-3"><?= htmlspecialchars($ticket['scenario_title'] ?? 'No scenario') ?></td>
                        <td class="p-3"><?= htmlspecialchars($ticket['status']) ?></td>
                        <td class="p-3"><?= htmlspecialchars($ticket['deadline'] ?? 'No deadline') ?></td>
                    </tr><?php endforeach; ?></tbody>
        </table>
    </div>
</section>

<!-- ========================================================================= -->
<?php require __DIR__ . "/_ticket_management_modal.php"; ?>
<!-- MODAL SUITE                                                               -->
<!-- ========================================================================= -->

<!-- MODAL 1: 10-STEP SCENARIO BUILDER (MULTI-STEP SCENARIO EDITOR) -->
<div id="scenario-builder-modal" class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl flex flex-col max-h-[92vh] overflow-hidden modal-animate border border-outline-variant/40">
        <!-- Modal Top Header -->
        <div class="px-6 py-4 bg-surface-container-low border-b border-outline-variant/40 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-container text-white flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-2xl text-tertiary-fixed">edit_document</span>
                </div>
                <div>
                    <div class="flex items-center gap-2 font-mono text-xs">
                        <span id="editor-modal-mode-badge" class="px-2 py-0.5 rounded bg-primary-container text-white font-bold">CREATE SCENARIO</span>
                        <span id="editor-modal-scenario-id-preview" class="text-primary font-bold">New scenario</span>
                        <span class="text-outline">/</span>
                        <span id="editor-modal-version-preview" class="text-outline">v1.0.0 DRAFT</span>
                    </div>
                    <h2 id="editor-modal-title" class="text-base font-bold font-mono text-slate-900 mt-0.5">Author Training Scenario Specification</h2>
                </div>
            </div>
            <button onclick="closeScenarioBuilderModal()" class="w-8 h-8 rounded-lg text-outline hover:text-primary hover:bg-surface-container flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <!-- Stepper Navigation Strip (10 Steps) -->
        <div class="bg-surface-container-low/60 border-b border-outline-variant/30 px-6 py-2 overflow-x-auto">
            <div class="flex items-center gap-2 min-w-max text-xs font-mono" id="stepper-pills-bar">
                <!-- Populated dynamically via JS -->
            </div>
        </div>

        <!-- Multi-Step Form Body (Scrollable) -->
        <div class="p-6 overflow-y-auto flex-1 font-mono text-xs space-y-6" id="stepper-form-body">

            <!-- STEP 1: GENERAL INFORMATION -->
            <div id="step-pane-1" class="step-pane space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/30">
                    <h3 class="font-bold text-sm text-primary flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-xs">1</span>
                        General Information
                    </h3>
                    <span class="text-[11px] text-outline">Fundamental Scenario Metadata & Categorization</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Scenario Title *</label>
                        <input id="edit-title" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 focus:border-primary focus:bg-white outline-none font-sans text-sm font-semibold text-slate-900" placeholder="e.g. Real-Time Telecom Churn Prediction Engine" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Scenario ID *</label>
                        <input id="edit-id" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 focus:border-primary focus:bg-white outline-none font-mono text-xs font-bold text-primary" placeholder="e.g. Scenario code" />
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-outline uppercase mb-1">Description / Executive Briefing *</label>
                    <textarea id="edit-description" rows="3" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 focus:border-primary focus:bg-white outline-none font-sans text-xs text-slate-800" placeholder="High-level pedagogical and operational summary of the scenario..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Track Category *</label>
                        <select id="edit-category" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800 outline-none">
                            <option value="Predictive AI">Predictive AI (Tabular)</option>
                            <option value="Streaming Anomaly">Streaming & Fraud</option>
                            <option value="Computer Vision">Computer Vision</option>
                            <option value="NLP">NLP & Text Classification</option>
                            <option value="Generative AI">Generative AI & RAG</option>
                            <option value="Autonomous Agents">Autonomous Agents</option>
                            <option value="AI SOC & Safety">AI SOC & Safety</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Difficulty Level *</label>
                        <select id="edit-difficulty" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800 outline-none">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Progression Level *</label>
                        <select id="edit-level" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800 outline-none">
                            <option value="Level 1">Level 1 — AI Fundamentals</option>
                            <option value="Level 2">Level 2 — AI Engineer</option>
                            <option value="Level 3">Level 3 — AI Production</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Assigned Department *</label>
                        <input id="edit-department" type="text" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800 outline-none" placeholder="e.g. Customer Retention Operations" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Responsible Instructor / Lead Architect *</label>
                        <input id="edit-instructor" type="text" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800 outline-none" placeholder="Authenticated administrator" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Keywords / Tags (Comma separated)</label>
                        <input id="edit-tags" type="text" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800 outline-none" placeholder="telecom, churn, xgboost, latency, shap" />
                    </div>
                </div>
            </div>

            <!-- STEP 2: BUSINESS PROBLEM -->
            <div id="step-pane-2" class="step-pane space-y-4 hidden">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/30">
                    <h3 class="font-bold text-sm text-primary flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-xs">2</span>
                        Business Problem & Operational Impact
                    </h3>
                    <span class="text-[11px] text-outline">Executive Justification & Quantifiable Mandates</span>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-outline uppercase mb-1">Business Objective *</label>
                    <input id="edit-bp-objective" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 font-sans text-xs text-slate-900 font-semibold" placeholder="e.g. Reduce voluntary customer contract cancellation by 12% across enterprise tier." />
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-outline uppercase mb-1">Detailed Problem Description *</label>
                    <textarea id="edit-bp-description" rows="3" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 font-sans text-xs text-slate-800" placeholder="Operational friction, account loss patterns, customer service ticket escalations..."></textarea>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-outline uppercase mb-1">Stakeholder Request / Official Mandate</label>
                    <textarea id="edit-bp-stakeholder" rows="2" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 font-sans text-xs text-slate-800" placeholder="Quote from VP of Operations or Enterprise Business Sponsor..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Business Context & Hard Constraints</label>
                        <textarea id="edit-bp-context" rows="2" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 font-sans text-xs text-slate-800" placeholder="e.g. Asymmetric cost matrix ($120 false negative vs $15 outreach); strict PII compliance."></textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Expected Business Impact & ROI</label>
                        <textarea id="edit-bp-impact" rows="2" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 font-sans text-xs text-slate-800" placeholder="e.g. $4.2M estimated annual revenue retention; 45% reduction in retention team manual triage."></textarea>
                    </div>
                </div>
            </div>

            <!-- STEP 3: DATASET CONFIGURATION -->
            <div id="step-pane-3" class="step-pane space-y-4 hidden">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/30">
                    <h3 class="font-bold text-sm text-primary flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-xs">3</span>
                        Dataset Configuration (SYS-AI-02 Data Lake Linkage)
                    </h3>
                    <span class="text-[11px] text-outline">Select, Version, and Set Access Modes for Datasets</span>
                </div>

                <p class="text-xs text-on-surface-variant font-sans">
                    Select uploaded datasets for this specification. Grant student access separately through dataset assignments in Data Center.
                </p>

                <!-- Datasets Dynamic Table -->
                <div class="rounded-xl border border-outline-variant/40 overflow-hidden">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-surface-container-low text-outline uppercase text-[10px]">
                            <tr>
                                <th class="p-2.5">Dataset Filename (SYS-AI-02)</th>
                                <th class="p-2.5">Role</th>
                                <th class="p-2.5">Access Permission</th>
                                <th class="p-2.5">Version & SHA-256</th>
                                <th class="p-2.5 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="builder-datasets-list" class="divide-y divide-outline-variant/20 bg-white">
                            <!-- Populated dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Add Dataset Strip -->
                <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40 flex items-center gap-3 flex-wrap">
                    <select id="new-dataset-name" class="flex-1 min-w-[200px] p-2 rounded-lg bg-white border border-outline-variant/40 text-xs">
                        <option value="">Select uploaded dataset</option><?php foreach ($datasets as $dataset): ?><option value="<?= (int)$dataset['id'] ?>"><?= htmlspecialchars($dataset['code'] . ' — ' . $dataset['name']) ?></option><?php endforeach; ?>
                    </select>
                    <select id="new-dataset-role" class="p-2 rounded-lg bg-white border border-outline-variant/40 text-xs">
                        <option value="Training Split">Training Split</option>
                        <option value="Holdout Test Split">Holdout Test Split</option>
                        <option value="Drift Baseline Feed">Drift Baseline Feed</option>
                        <option value="Auxiliary Embeddings">Auxiliary Embeddings</option>
                    </select>
                    <select id="new-dataset-access" class="p-2 rounded-lg bg-white border border-outline-variant/40 text-xs">
                        <option value="Read-Only (Immutable)">Read-Only (Immutable)</option>
                        <option value="Masked PII">Masked PII</option>
                        <option value="Sandbox R/W">Sandbox R/W</option>
                        <option value="Locked Instructor Truth">Locked Instructor Truth</option>
                    </select>
                    <input id="new-dataset-version" type="text" placeholder="Version (sha:8f2a...)" class="w-36 p-2 rounded-lg bg-white border border-outline-variant/40 text-xs" />
                    <button type="button" onclick="addDatasetToBuilderList()" class="px-3 py-2 rounded-lg bg-primary-container text-white font-bold text-xs flex items-center gap-1 shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                        <span>Add Dataset</span>
                    </button>
                </div>
            </div>

            <!-- STEP 4: TOOLS AND ENVIRONMENT -->
            <div id="step-pane-4" class="step-pane space-y-4 hidden">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/30">
                    <h3 class="font-bold text-sm text-primary flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-xs">4</span>
                        Tools and Environment
                    </h3>
                    <span class="text-[11px] text-outline">Requested Python Stack, Frameworks & Hardware Quotas</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Python Base Runtime</label>
                        <select id="edit-python-version" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800 outline-none">
                            <option value="Python 3.11.8 (Conda Range-v4)">Python 3.11.8 (Conda Range-v4)</option>
                            <option value="Python 3.10.12 (Standard Ubuntu)">Python 3.10.12 (Standard Ubuntu)</option>
                            <option value="Python 3.12.2 (Experimental Modern)">Python 3.12.2 (Experimental Modern)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Inference Engine / Server</label>
                        <select id="edit-framework" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800 outline-none">
                            <option value="Triton ONNX Runtime + FastAPI">Triton ONNX Runtime + FastAPI</option>
                            <option value="TorchServe PyTorch C++">TorchServe PyTorch C++</option>
                            <option value="vLLM / HuggingFace TGI">vLLM / HuggingFace TGI</option>
                            <option value="DuckDB Embedded Microservice">DuckDB Embedded Microservice</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Resource Quota</label>
                        <input id="edit-compute-quota" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800 outline-none" value="" />
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-outline uppercase mb-1">Requested Python Libraries & Packages</label>
                    <input id="edit-libraries" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-primary font-bold outline-none" value="" />
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-outline uppercase mb-1">Requested Subsystem Integrations</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs">
                        <label class="flex items-center gap-2 p-2 rounded-xl bg-surface-container-low border border-outline-variant/40">
                            <input id="int-sys-01" type="checkbox" class="accent-primary" />
                            <span>SYS-01 Tickets</span>
                        </label>
                        <label class="flex items-center gap-2 p-2 rounded-xl bg-surface-container-low border border-outline-variant/40">
                            <input id="int-sys-02" type="checkbox" class="accent-primary" />
                            <span>SYS-02 Data Lake</span>
                        </label>
                        <label class="flex items-center gap-2 p-2 rounded-xl bg-surface-container-low border border-outline-variant/40">
                            <input id="int-sys-03" type="checkbox" class="accent-primary" />
                            <span>SYS-03 Workbench</span>
                        </label>
                        <label class="flex items-center gap-2 p-2 rounded-xl bg-surface-container-low border border-outline-variant/40">
                            <input id="int-sys-04" type="checkbox" class="accent-primary" />
                            <span>SYS-04 Triton Gate</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- STEP 5: STUDENT WORKFLOW -->
            <div id="step-pane-5" class="step-pane space-y-4 hidden">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/30">
                    <h3 class="font-bold text-sm text-primary flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-xs">5</span>
                        Student Workflow & Cross-System Handoffs
                    </h3>
                    <span class="text-[11px] text-outline">Expected Progression Stages & Validation Checkpoints</span>
                </div>

                <div class="space-y-3" id="builder-stages-list">
                    <!-- Stage 1 -->
                    <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40 space-y-1">
                        <div class="flex items-center justify-between font-bold text-primary">
                            <span>Stage 1: Problem Understanding & EDA</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container text-slate-700 text-[10px]">SYS-AI-01 Task Intake</span>
                        </div>
                        <input type="text" class="stage-action-input w-full p-1.5 rounded bg-white border border-outline-variant/30 text-xs" value="" />
                    </div>
                    <!-- Stage 2 -->
                    <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40 space-y-1">
                        <div class="flex items-center justify-between font-bold text-primary">
                            <span>Stage 2: Feature Engineering & Preprocessing</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container text-slate-700 text-[10px]">SYS-AI-02 Data Lineage</span>
                        </div>
                        <input type="text" class="stage-action-input w-full p-1.5 rounded bg-white border border-outline-variant/30 text-xs" value="" />
                    </div>
                    <!-- Stage 3 -->
                    <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40 space-y-1">
                        <div class="flex items-center justify-between font-bold text-primary">
                            <span>Stage 3: Model Training & Experiment Tracking</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container text-slate-700 text-[10px]">SYS-AI-03 MLflow Runs</span>
                        </div>
                        <input type="text" class="stage-action-input w-full p-1.5 rounded bg-white border border-outline-variant/30 text-xs" value="" />
                    </div>
                    <!-- Stage 4 -->
                    <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40 space-y-1">
                        <div class="flex items-center justify-between font-bold text-primary">
                            <span>Stage 4: Holdout Validation & Canary Deployment Gate</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container text-slate-700 text-[10px]">SYS-AI-04 Triton Gate</span>
                        </div>
                        <input type="text" class="stage-action-input w-full p-1.5 rounded bg-white border border-outline-variant/30 text-xs" value="" />
                    </div>
                    <!-- Stage 5 -->
                    <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40 space-y-1">
                        <div class="flex items-center justify-between font-bold text-primary">
                            <span>Stage 5: Live Drift Triage & Defense</span>
                            <span class="px-2 py-0.5 rounded bg-surface-container text-slate-700 text-[10px]">SYS-AI-05 AI SOC Alert</span>
                        </div>
                        <input type="text" class="stage-action-input w-full p-1.5 rounded bg-white border border-outline-variant/30 text-xs" value="" />
                    </div>
                </div>
            </div>

            <!-- STEP 6: SUCCESS CRITERIA -->
            <div id="step-pane-6" class="step-pane space-y-4 hidden">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/30">
                    <h3 class="font-bold text-sm text-primary flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-xs">6</span>
                        Success Criteria & Metric Thresholds
                    </h3>
                    <span class="text-[11px] text-outline">Task-Specific Numerical Acceptance Gates</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Primary Metric</label>
                        <input id="edit-metric-primary-name" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs font-bold text-primary" value="" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Acceptance Threshold *</label>
                        <input id="edit-metric-primary-threshold" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs font-bold text-emerald-700" value="" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Secondary F1 / Precision</label>
                        <input id="edit-metric-secondary" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs font-semibold text-slate-800" value="" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Max Inference Latency SLA</label>
                        <input id="edit-metric-latency" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs font-semibold text-slate-800" value="" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Robustness & Drift Tolerance</label>
                        <input id="edit-metric-robustness" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs font-semibold text-slate-800" value="" />
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-outline uppercase mb-1">Hard Disqualification Rules (Zero Tolerance)</label>
                    <textarea id="edit-metric-hardfail" rows="2" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-error font-semibold" placeholder="e.g. Target leakage flag triggered; AUC > 0.99 with raw timestamp features; unhandled API 500 exceptions."></textarea>
                </div>
            </div>

            <!-- STEP 7: DELIVERABLES -->
            <div id="step-pane-7" class="step-pane space-y-4 hidden">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/30">
                    <h3 class="font-bold text-sm text-primary flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-xs">7</span>
                        Required Cadet Deliverables
                    </h3>
                    <span class="text-[11px] text-outline">Code, Artifacts, Reports, and Live Endpoints</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-3">
                        <label class="flex items-start gap-2.5 p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                            <input id="deliv-notebooks" type="checkbox" class="accent-primary mt-0.5" />
                            <div>
                                <strong class="text-primary block">1. Jupyter Notebooks (.ipynb)</strong>
                                <span class="text-[11px] text-outline">Fully executed `01_eda.ipynb` and `02_model_pipeline.ipynb` with clear markdown reasoning.</span>
                            </div>
                        </label>
                        <label class="flex items-start gap-2.5 p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                            <input id="deliv-repo" type="checkbox" class="accent-primary mt-0.5" />
                            <div>
                                <strong class="text-primary block">2. Git Source Code Repository</strong>
                                <span class="text-[11px] text-outline">Clean repository with `main.py`, `requirements.txt`, Dockerfile, and at least 4 semantic git commits.</span>
                            </div>
                        </label>
                        <label class="flex items-start gap-2.5 p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                            <input id="deliv-model" type="checkbox" class="accent-primary mt-0.5" />
                            <div>
                                <strong class="text-primary block">3. Serialized Model Artifacts</strong>
                                <span class="text-[11px] text-outline">Serialized `model.onnx` or `model.xgb` uploaded to SYS-AI-04 Model Registry with verified checksum.</span>
                            </div>
                        </label>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-start gap-2.5 p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                            <input id="deliv-card" type="checkbox" class="accent-primary mt-0.5" />
                            <div>
                                <strong class="text-primary block">4. Model Card & Technical Report</strong>
                                <span class="text-[11px] text-outline">Formal markdown model card detailing bias analysis, training lineage, and performance trade-offs.</span>
                            </div>
                        </label>
                        <label class="flex items-start gap-2.5 p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                            <input id="deliv-api" type="checkbox" class="accent-primary mt-0.5" />
                            <div>
                                <strong class="text-primary block">5. Containerized Live REST Endpoint</strong>
                                <span class="text-[11px] text-outline">Swagger API passing automated health check at `POST /v1/predict` under 100 concurrent requests.</span>
                            </div>
                        </label>
                        <label class="flex items-start gap-2.5 p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                            <input id="deliv-demo" type="checkbox" class="accent-primary mt-0.5" />
                            <div>
                                <strong class="text-primary block">6. Post-Mortem Incident Log</strong>
                                <span class="text-[11px] text-outline">Documented triage steps for simulated drift incident and blue/green rollback audit trail.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- STEP 8: EVALUATION RULES & RUBRIC -->
            <div id="step-pane-8" class="step-pane space-y-4 hidden">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/30">
                    <h3 class="font-bold text-sm text-primary flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-xs">8</span>
                        Evaluation Rubric & Scoring Weights (8 Dimensions)
                    </h3>
                    <div class="flex items-center gap-2">
                        <span class="text-[11px] text-outline">Total Weight:</span>
                        <span id="rubric-total-weight-badge" class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold">100%</span>
                    </div>
                </div>

                <!-- 8 Dimension Weight Inputs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="rubric-dimension-inputs">
                    <div class="p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 flex items-center justify-between">
                        <span class="font-medium text-slate-800">1. Problem Understanding & Formulation</span>
                        <div class="flex items-center gap-1">
                            <input type="number" id="dim-weight-1" oninput="calculateRubricTotal()" class="w-16 p-1 rounded bg-white border border-outline-variant/40 text-center font-bold text-primary" value="" min="0" max="100" />
                            <span>%</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 flex items-center justify-between">
                        <span class="font-medium text-slate-800">2. Data Prep & Leakage Prevention</span>
                        <div class="flex items-center gap-1">
                            <input type="number" id="dim-weight-2" oninput="calculateRubricTotal()" class="w-16 p-1 rounded bg-white border border-outline-variant/40 text-center font-bold text-primary" value="" min="0" max="100" />
                            <span>%</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 flex items-center justify-between">
                        <span class="font-medium text-slate-800">3. Model Development & Tuning</span>
                        <div class="flex items-center gap-1">
                            <input type="number" id="dim-weight-3" oninput="calculateRubricTotal()" class="w-16 p-1 rounded bg-white border border-outline-variant/40 text-center font-bold text-primary" value="" min="0" max="100" />
                            <span>%</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 flex items-center justify-between">
                        <span class="font-medium text-slate-800">4. Holdout Evaluation & Metrics Rigor</span>
                        <div class="flex items-center gap-1">
                            <input type="number" id="dim-weight-4" oninput="calculateRubricTotal()" class="w-16 p-1 rounded bg-white border border-outline-variant/40 text-center font-bold text-primary" value="" min="0" max="100" />
                            <span>%</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 flex items-center justify-between">
                        <span class="font-medium text-slate-800">5. Diagnostics & Error Analysis</span>
                        <div class="flex items-center gap-1">
                            <input type="number" id="dim-weight-5" oninput="calculateRubricTotal()" class="w-16 p-1 rounded bg-white border border-outline-variant/40 text-center font-bold text-primary" value="" min="0" max="100" />
                            <span>%</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 flex items-center justify-between">
                        <span class="font-medium text-slate-800">6. Production API Deployment & Latency</span>
                        <div class="flex items-center gap-1">
                            <input type="number" id="dim-weight-6" oninput="calculateRubricTotal()" class="w-16 p-1 rounded bg-white border border-outline-variant/40 text-center font-bold text-primary" value="" min="0" max="100" />
                            <span>%</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 flex items-center justify-between">
                        <span class="font-medium text-slate-800">7. Engineering Docs & MLflow Lineage</span>
                        <div class="flex items-center gap-1">
                            <input type="number" id="dim-weight-7" oninput="calculateRubricTotal()" class="w-16 p-1 rounded bg-white border border-outline-variant/40 text-center font-bold text-primary" value="" min="0" max="100" />
                            <span>%</span>
                        </div>
                    </div>
                    <div class="p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 flex items-center justify-between">
                        <span class="font-medium text-slate-800">8. Business Impact Synthesis</span>
                        <div class="flex items-center gap-1">
                            <input type="number" id="dim-weight-8" oninput="calculateRubricTotal()" class="w-16 p-1 rounded bg-white border border-outline-variant/40 text-center font-bold text-primary" value="" min="0" max="100" />
                            <span>%</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Passing Grade Threshold</label>
                        <input id="edit-passing-score" type="text" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs font-bold text-primary" value="" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Automatic Validation</label>
                        <select id="edit-auto-val" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800">
                            <option value="Unavailable until trusted evaluator is deployed">Unavailable until trusted evaluator is deployed</option>
                            <option value="Manual Instructor Review Only">Manual Instructor Review Only</option>
                            <option value="Hybrid (planned)">Hybrid (planned)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Instructor Review Requirement</label>
                        <select id="edit-instructor-review-req" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800">
                            <option value="Mandatory Final Signoff Required">Mandatory Final Signoff Required</option>
                            <option value="Optional Spot Checks">Optional Spot Checks</option>
                            <option value="Peer Review by Senior Cadet">Peer Review by Senior Cadet</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- STEP 9: PUBLICATION & ASSIGNMENT -->
            <div id="step-pane-9" class="step-pane space-y-4 hidden">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/30">
                    <h3 class="font-bold text-sm text-primary flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-xs">9</span>
                        Publication Status & Cohort Assignments
                    </h3>
                    <span class="text-[11px] text-outline">Lifecycle State, Enrolled Cohorts & Deadlines</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Lifecycle Status *</label>
                        <select id="edit-lifecycle-status" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs font-bold text-primary">
                            <option value="Draft">Draft</option>
                            <option value="Ready for Review">Ready for Review</option>
                            <option value="Published">Published</option>
                            <option value="Active">Active</option>
                            <option value="Completed">Completed</option>
                            <option value="Archived">Archived</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Target Cohort Assignment</label>
                        <select id="edit-cohort" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs font-semibold text-slate-800">
                            <option value="">No cohort selected</option><?php foreach (array_unique(array_filter(array_column($students, 'cohort'))) as $cohort): ?><option value="<?= htmlspecialchars($cohort) ?>"><?= htmlspecialchars($cohort) ?></option><?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Enrolled Cadets Count</label>
                        <input id="edit-students-count" type="number" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs font-bold text-primary" value="" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Start Date & Time</label>
                        <input id="edit-start-date" type="date" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800" value="" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Hard Submission Deadline</label>
                        <input id="edit-deadline" type="date" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800" value="" />
                    </div>
                </div>

                <div class="p-3 rounded-xl bg-surface-container-low border border-outline-variant/40">
                    <label class="flex items-center gap-2 cursor-pointer font-semibold text-slate-900">
                        <input id="edit-visible-toggle" type="checkbox" class="accent-primary" />
                        <span>Requested Student Publication Visibility</span>
                    </label>
                    <p class="text-[11px] text-outline mt-1 pl-6">
                        Publication preferences describe the specification. Ticket and dataset access is enforced by their separate assignments.
                    </p>
                </div>
            </div>

            <!-- STEP 10: VERSION HISTORY & RELEASE -->
            <div id="step-pane-10" class="step-pane space-y-4 hidden">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/30">
                    <h3 class="font-bold text-sm text-primary flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-primary-container text-white flex items-center justify-center text-xs">10</span>
                        Version History & Release Changelog
                    </h3>
                    <span class="text-[11px] text-outline">Recorded Change History & Audit Trail</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Current Version Identifier *</label>
                        <input id="edit-version" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs font-bold text-primary" value="" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-outline uppercase mb-1">Author of Changes</label>
                        <input id="edit-version-author" type="text" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800" value="" />
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-outline uppercase mb-1">Mandatory Release Changelog / Commit Note *</label>
                    <textarea id="edit-changelog" rows="2" class="w-full p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-slate-800" placeholder="Describe rationale for this update (e.g., tightened SHAP latency bounds to 60ms)..."></textarea>
                </div>

                <!-- Version History List -->
                <div>
                    <label class="block text-[11px] font-bold text-outline uppercase mb-2">Previous Historical Revisions for this Scenario</label>
                    <div id="builder-version-history-list" class="space-y-2 max-h-48 overflow-y-auto">
                        <!-- Populated dynamically -->
                    </div>
                </div>
            </div>

        </div>

        <!-- Modal Footer Controls -->
        <div class="px-6 py-4 bg-surface-container-low border-t border-outline-variant/40 flex items-center justify-between font-mono text-xs">
            <button type="button" onclick="closeScenarioBuilderModal()" class="px-4 py-2 rounded-xl text-outline hover:text-primary hover:bg-surface-container transition-colors">
                Cancel & Close
            </button>

            <div class="flex items-center gap-2.5">
                <button type="button" id="stepper-prev-btn" onclick="goToPreviousStep()" class="px-4 py-2 rounded-xl bg-white border border-outline-variant/50 text-primary font-bold hover:bg-secondary-fixed transition-all disabled:opacity-40 disabled:pointer-events-none">
                    ← Back
                </button>
                <button type="button" onclick="saveCurrentScenario(true)" class="px-4 py-2 rounded-xl bg-surface-container text-primary border border-outline-variant/50 font-bold hover:bg-secondary-fixed transition-all">
                    Save as Draft
                </button>
                <button type="button" id="stepper-next-btn" onclick="goToNextStep()" class="px-5 py-2 rounded-xl bg-primary-container text-white font-bold hover:bg-primary shadow-sm transition-all flex items-center gap-1">
                    <span>Next Step</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </button>
                <button type="button" id="stepper-save-final-btn" onclick="saveCurrentScenario(false)" class="hidden px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 shadow-sm transition-all flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span>Save & Finalize Scenario</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2: PREVIEW AS STUDENT MODAL -->
<div id="preview-student-modal" class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden modal-animate border border-outline-variant/40">
        <div class="px-6 py-4 bg-primary-container text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-2xl text-tertiary-fixed">visibility</span>
                <div>
                    <div class="flex items-center gap-2 font-mono text-xs">
                        <span class="px-2 py-0.5 rounded bg-tertiary-fixed text-tertiary font-bold">CADET VIEW SIMULATION</span>
                        <span id="preview-student-id">Scenario code</span>
                        <span>•</span>
                        <span id="preview-student-version">Version</span>
                    </div>
                    <h2 id="preview-student-title" class="text-base font-bold font-mono text-white mt-0.5">Scenario Mission Briefing</h2>
                </div>
            </div>
            <button onclick="closeModal('preview-student-modal')" class="text-white/80 hover:text-white">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto space-y-6 text-xs font-mono" id="preview-student-content">
            <!-- Dynamically generated cadet preview -->
        </div>
        <div class="px-6 py-3.5 bg-surface-container-low border-t border-outline-variant/40 flex items-center justify-between text-xs font-mono">
            <span class="text-outline">Simulated student environment: Ready to accept model submissions & notebook runs</span>
            <button onclick="closeModal('preview-student-modal')" class="px-4 py-2 rounded-xl bg-primary-container text-white font-bold">
                Close Preview
            </button>
        </div>
    </div>
</div>

<!-- MODAL 3: CONSEQUENTIAL ACTION CONFIRMATION MODAL -->
<div id="confirmation-guard-modal" class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 flex flex-col modal-animate border border-error/30">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-xl bg-error-container text-error flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl">warning</span>
            </div>
            <div>
                <h3 id="guard-title" class="font-bold font-mono text-base text-error">Confirm Consequential Action</h3>
                <p id="guard-subtitle" class="font-mono text-xs text-outline">Scenario Safety Enforcement Guard</p>
            </div>
        </div>
        <div class="p-3 rounded-xl bg-error-container/40 border border-error/30 text-xs font-mono text-on-error-container mb-4" id="guard-message">
            Are you sure you want to proceed with this consequential change?
        </div>
        <p class="text-xs text-outline font-mono mb-6" id="guard-consequence">
            Active student workspaces and automated canary deployment gates may be immediately affected.
        </p>
        <div class="flex items-center justify-end gap-2.5 font-mono text-xs">
            <button onclick="closeModal('confirmation-guard-modal')" class="px-4 py-2 rounded-xl bg-surface-container text-primary font-bold hover:bg-secondary-fixed">
                Cancel
            </button>
            <button id="guard-confirm-action-btn" class="px-4 py-2 rounded-xl bg-error text-white font-bold hover:bg-red-700 shadow-sm">
                Confirm Action
            </button>
        </div>
    </div>
</div>

<!-- MODAL 4: VERSION COMPARISON (DIFF) MODAL -->
<div id="version-compare-modal" class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden modal-animate border border-outline-variant/40">
        <div class="px-6 py-4 bg-surface-container-low border-b border-outline-variant/40 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary-container text-white flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl text-tertiary-fixed">compare_arrows</span>
                </div>
                <div>
                    <div class="font-mono text-xs text-outline">Version Audit Matrix</div>
                    <h2 class="text-base font-bold font-mono text-primary" id="compare-modal-scenario-title">Compare Scenario Revisions</h2>
                </div>
            </div>
            <button onclick="closeModal('version-compare-modal')" class="text-outline hover:text-primary">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto space-y-6 text-xs font-mono" id="version-compare-content">
            <!-- Dynamically generated diff comparison -->
        </div>
        <div class="px-6 py-3.5 bg-surface-container-low border-t border-outline-variant/40 flex items-center justify-between text-xs font-mono">
            <span class="text-outline">Changes record the authenticated author, time, and audit event in MySQL.</span>
            <button onclick="closeModal('version-compare-modal')" class="px-4 py-2 rounded-xl bg-primary-container text-white font-bold">
                Close Diff Viewer
            </button>
        </div>
    </div>
</div>

<!-- MODAL 5: ASSOCIATED TICKETS MODAL (SYS-AI-01 INTEGRATION) -->
<div id="tickets-view-modal" class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden modal-animate border border-outline-variant/40">
        <div class="px-6 py-4 bg-surface-container-low border-b border-outline-variant/40 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#F3E8FF] border border-[#D8B4FE] flex items-center justify-center text-[#4C1D95]">
                    <span class="material-symbols-outlined text-2xl">folder_special</span>
                </div>
                <div>
                    <div class="font-mono text-xs text-primary font-bold">SYS-AI-01 Persisted Ticket Board</div>
                    <h2 class="text-base font-bold font-mono text-slate-900" id="tickets-modal-scenario-title">Associated Sprint Tickets</h2>
                </div>
            </div>
            <button onclick="closeModal('tickets-view-modal')" class="text-outline hover:text-primary">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto space-y-4 text-xs font-mono" id="tickets-modal-content">
            <!-- Dynamically populated tickets -->
        </div>
        <div class="px-6 py-3.5 bg-surface-container-low border-t border-outline-variant/40 flex items-center justify-between text-xs font-mono">
            <a href="#ticket-management" onclick="closeModal('tickets-view-modal')" class="text-primary hover:underline font-bold flex items-center gap-1">
                <span>Manage Tickets in AI SOC</span>
                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
            </a>
            <button onclick="closeModal('tickets-view-modal')" class="px-4 py-2 rounded-xl bg-primary-container text-white font-bold">
                Close
            </button>
        </div>
    </div>
</div>

<!-- MODAL 6: STUDENT PROGRESS & SUBMISSIONS MODAL -->
<div id="progress-view-modal" class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden modal-animate border border-outline-variant/40">
        <div class="px-6 py-4 bg-surface-container-low border-b border-outline-variant/40 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-secondary-fixed text-primary flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-2xl">groups</span>
                </div>
                <div>
                    <div class="font-mono text-xs text-primary font-bold">SYS-AI-05 Submission & Grade Tracker</div>
                    <h2 class="text-base font-bold font-mono text-slate-900" id="progress-modal-scenario-title">Enrolled Cadet Progress & Artifacts</h2>
                </div>
            </div>
            <button onclick="closeModal('progress-view-modal')" class="text-outline hover:text-primary">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto space-y-4 text-xs font-mono" id="progress-modal-content">
            <!-- Dynamically populated progress & submissions table -->
        </div>
        <div class="px-6 py-3.5 bg-surface-container-low border-t border-outline-variant/40 flex items-center justify-between text-xs font-mono">
            <span class="text-outline">Ticket status comes from MySQL. Execution and inference telemetry are unavailable.</span>
            <button onclick="closeModal('progress-view-modal')" class="px-4 py-2 rounded-xl bg-primary-container text-white font-bold">
                Close
            </button>
        </div>
    </div>
</div>

<!-- MODAL 7: MANAGE ASSIGNMENTS MODAL -->
<div id="manage-assignments-modal" class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 flex flex-col modal-animate border border-outline-variant/40 font-mono text-xs">
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-outline-variant/30">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-2xl text-primary">assignment_ind</span>
                <h3 class="font-bold text-sm text-primary">Manage Cohort Assignments</h3>
            </div>
            <button onclick="closeModal('manage-assignments-modal')" class="text-outline hover:text-primary">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <div class="space-y-4 mb-6">
            <label class="block text-[11px] font-bold text-outline uppercase">Scenario Target</label>
            <input id="assign-scenario-title-input" type="text" readonly class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40 font-bold text-primary">
            <label class="block text-[11px] font-bold text-outline uppercase">Existing ticket</label>
            <select id="assignment-ticket" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40"></select>
            <label class="block text-[11px] font-bold text-outline uppercase">Active student</label>
            <select id="assignment-student" class="w-full p-2 rounded-xl bg-surface-container-low border border-outline-variant/40">
                <option value="">Select student</option><?php foreach ($students as $student): ?><option value="<?= (int)$student['id'] ?>"><?= htmlspecialchars($student['identifier'] . ' — ' . $student['full_name']) ?></option><?php endforeach; ?>
            </select>
            <p class="text-outline">Create a ticket first. Dataset access is assigned separately in Data Center.</p>
        </div>
        <div class="flex items-center justify-end gap-2">
            <button onclick="closeModal('manage-assignments-modal')" class="px-4 py-2 rounded-xl bg-surface-container text-primary font-bold">
                Cancel
            </button>
            <button onclick="saveAssignmentChanges()" class="px-4 py-2 rounded-xl bg-primary-container text-white font-bold hover:bg-primary">
                Save Assignments
            </button>
        </div>
    </div>
</div>

<!-- MODAL 8: CROSS-SYSTEM INTEGRATION HUB TELEMETRY -->
<div id="integration-monitor-modal" class="fixed inset-0 z-50 bg-inverse-surface/60 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden modal-animate border border-outline-variant/40 font-mono text-xs">
        <div class="px-6 py-4 bg-primary-container text-white flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-2xl text-tertiary-fixed">hub</span>
                <div>
                    <h2 class="text-base font-bold font-mono text-white">SYS-AI Integration Hub Telemetry</h2>
                    <p class="text-[11px] text-white/80">Active Shared Scenario ID & Version Traceability Matrix</p>
                </div>
            </div>
            <button onclick="closeModal('integration-monitor-modal')" class="text-white/80 hover:text-white">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto space-y-6">
            <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/40"><strong>MySQL</strong>
                <p>Connected for this page request. Scenario, ticket and dataset counts come from persisted rows.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-3"><?php foreach (['SYS-AI-01' => 'Tickets', 'SYS-AI-02' => 'Datasets', 'SYS-AI-03' => 'Execution', 'SYS-AI-04' => 'Inference', 'SYS-AI-05' => 'External telemetry'] as $system => $label): ?><div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/40 space-y-2"><strong><?= $system ?></strong>
                        <p><?= $label ?></p><span class="text-outline">Service health NOT AVAILABLE</span>
                    </div><?php endforeach; ?></div>
            <div class="rounded-xl border border-outline-variant/40 overflow-hidden">
                <table class="w-full text-left text-[11px]">
                    <thead class="bg-surface-container-low text-outline">
                        <tr>
                            <th class="p-2.5">Scenario</th>
                            <th class="p-2.5">Version</th>
                            <th class="p-2.5">Status</th>
                        </tr>
                    </thead>
                    <tbody id="integration-scenarios-rows"><?php if (!$scenarios): ?><tr>
                                <td colspan="3" class="p-6 text-center text-outline">No scenarios</td>
                            </tr><?php endif; ?><?php foreach ($scenarios as $scenario): ?><tr>
                                <td class="p-2.5"><?= htmlspecialchars($scenario['code']) ?></td>
                                <td class="p-2.5"><?= htmlspecialchars($scenario['version']) ?></td>
                                <td class="p-2.5"><?= htmlspecialchars($scenario['status']) ?></td>
                            </tr><?php endforeach; ?></tbody>
                </table>
            </div>
            <p class="text-outline">No automatic assignments, notebooks, validation or deployment services run when a scenario is published.</p>
        </div>
        <div class="px-6 py-3.5 bg-surface-container-low border-t border-outline-variant/40 flex items-center justify-end">
            <button onclick="closeModal('integration-monitor-modal')" class="px-4 py-2 rounded-xl bg-primary-container text-white font-bold">
                Close Monitor
            </button>
        </div>
    </div>
</div>

<!-- Toast Notification Container -->
<div id="toast-container" class="fixed bottom-6 right-6 z-50 flex flex-col gap-2 pointer-events-none font-mono text-xs"></div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT MASTER APPLICATION LOGIC & STATE STORE                        -->
<!-- ========================================================================= -->
<script id="soc-config" type="application/json">
    <?= json_encode(['csrf' => Csrf::getToken(), 'user' => ['full_name' => $currentUser['full_name']], 'datasets' => $datasets, 'students' => $students, 'ticketCount' => (int)$db->fetchValue('SELECT COUNT(*) FROM tickets')], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>
</script>
<script src="js/main.js"></script>
<?php
AppLayout::end([
    'extraScriptsHtml' => '<script src="../assets/js/range-client.js"></script><script src="../assets/js/soc-training.js"></script>',
]);
?>
