<?php
/**
 * @var string $pageType
 * @var array<string, int> $counts
 * @var array<int, array<string, mixed>> $students
 * @var array<int, array<string, mixed>> $scenarios
 * @var array<int, array<string, mixed>> $auditLogs
 * @var string $databaseHealth
 */
if (!isset($pageType, $counts, $students, $scenarios, $auditLogs, $databaseHealth)) {
    http_response_code(404);
    exit;
}
// Included after the authenticated SOC page has loaded persisted data.
$escape = static fn($value) => htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
?>
<div class="w-full flex flex-col gap-6">
    <!-- Header Mission Control Banner -->
    <section class="bg-white border border-border rounded-xl p-6 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 text-primary mb-1">
                    <span class="material-symbols-outlined text-2xl md:text-3xl"><?= $pageType === 'operations' ? 'hub' : 'space_dashboard' ?></span>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-primary tracking-tight">
                        <?= $pageType === 'operations' ? 'AI Operations Dashboard' : 'AI SOC Mission Control' ?>
                    </h1>
                </div>
                <p class="text-xs md:text-sm text-on-surface-variant">
                    Persisted training activity and service availability across SYS-AI-01 through SYS-AI-05
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="TicketsAndScenarios.php" class="vp-btn vp-btn-primary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm">
                    Create Scenario / Ticket
                </a>
                <a href="StudentManagement.php" class="vp-btn vp-btn-secondary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm">
                    Create Student
                </a>
                <a href="WorkspaceConfiguration.php" class="vp-btn vp-btn-outline px-4 py-2 text-xs font-semibold rounded-lg shadow-sm">
                    Review Submissions
                </a>
            </div>
        </div>
    </section>

    <!-- Key Performance Indicators (6 columns desktop, 3 columns tablet, 2/1 on mobile) -->
    <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
        <?php foreach ([
            ['groups', 'Students', $counts['students'], 'No students'],
            ['account_tree', 'Scenarios', $counts['scenarios'], 'No scenarios'],
            ['confirmation_number', 'Tickets', $counts['tickets'], 'No tickets'],
            ['pending_actions', 'Pending Reviews', $counts['reviews'], 'No pending reviews'],
            ['memory', 'Models', $counts['models'], 'No models'],
            ['crisis_alert', 'Failed Jobs', $counts['failed'], 'No failed records']
        ] as [$icon, $label, $value, $empty]): ?>
            <div class="bg-white border border-border rounded-xl p-5 shadow-sm flex flex-col justify-between min-h-[120px] transition-all hover:border-secondary hover:shadow-md">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-xs font-semibold uppercase tracking-wider text-slate-500"><?= $label ?></span>
                    <span class="material-symbols-outlined text-primary text-xl"><?= $icon ?></span>
                </div>
                <div class="text-3xl font-extrabold text-primary font-sans my-1"><?= $value ?></div>
                <span class="text-xs text-slate-500 font-mono"><?= $value === 0 ? $empty : 'MySQL records' ?></span>
            </div>
        <?php endforeach; ?>
    </section>

    <!-- Subsystem Status Grid -->
    <section class="bg-white border border-border rounded-xl p-6 shadow-sm flex flex-col gap-4">
        <div class="flex items-center gap-2.5 pb-3 border-b border-border/40 text-primary">
            <span class="material-symbols-outlined text-xl">developer_board</span>
            <h2 class="text-base font-bold text-primary font-sans">Subsystem Status</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
            <?php foreach ([
                ['SYS-AI-01', 'Tickets & Scenarios', $counts['tickets'] . ' tickets', 'TicketsAndScenarios.php'],
                ['SYS-AI-02', 'Dataset Portal', $counts['datasets'] . ' datasets', 'DatasetManagement.php'],
                ['SYS-AI-03', 'AI/ML Workbench', $counts['notebooks'] . ' notebooks', 'StudentWorkspaces.php'],
                ['SYS-AI-04', 'Model Registry', $counts['models'] . ' models', 'ModelManagement.php'],
                ['SYS-AI-05', 'AI Ops & SOC', $counts['submissions'] . ' submissions', 'WorkspaceConfiguration.php']
            ] as [$system, $label, $count, $link]): ?>
                <a href="<?= $escape($link) ?>" class="bg-[#FDF6F0] rounded-xl p-4 border border-border hover:border-secondary flex flex-col justify-between gap-3 shadow-xs transition-all hover:shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="font-mono text-[11px] font-bold text-primary bg-lavender px-2 py-0.5 rounded"><?= $system ?></span>
                        <span class="material-symbols-outlined text-slate-400 text-sm">arrow_outward</span>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-slate-800 block"><?= $label ?></span>
                        <span class="text-xs font-medium text-slate-600 block mt-0.5"><?= $count ?></span>
                    </div>
                    <span class="text-[11px] font-mono text-slate-400 border-t border-border/40 pt-2">External service health NOT AVAILABLE</span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Student Training Activity & Activity & Audit (2 columns desktop, stacked tablet/mobile) -->
    <section class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white border border-border rounded-xl p-6 shadow-sm flex flex-col gap-4">
            <div class="flex items-center justify-between pb-3 border-b border-border/40">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-xl">school</span>
                    <h2 class="text-base font-bold text-primary">Student Training Activity</h2>
                </div>
                <span class="font-mono text-xs text-slate-500"><?= count($students) ?> active cadets</span>
            </div>
            <div class="divide-y divide-border/40">
                <?php if (!$students): ?>
                    <div class="vp-empty-state py-8">
                        <span class="material-symbols-outlined vp-empty-icon text-3xl">school</span>
                        <p class="vp-empty-title">No student activity</p>
                        <p class="vp-empty-desc">No active cadets assigned yet.</p>
                    </div>
                <?php endif; ?>
                <?php foreach ($students as $student): ?>
                    <div class="py-3 flex items-center justify-between gap-4">
                        <div>
                            <strong class="text-primary text-sm font-semibold"><?= $escape($student['full_name']) ?></strong>
                            <p class="font-mono text-xs text-slate-500"><?= $escape($student['identifier']) ?></p>
                        </div>
                        <div class="text-right font-mono text-xs text-slate-600">
                            <span class="font-bold text-primary"><?= (int)$student['tickets_count'] ?></span> tickets ·
                            <span class="font-bold text-primary"><?= (int)$student['submissions_count'] ?></span> submissions
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-white border border-border rounded-xl p-6 shadow-sm flex flex-col gap-4">
            <div class="flex items-center justify-between pb-3 border-b border-border/40">
                <div class="flex items-center gap-2 text-primary">
                    <span class="material-symbols-outlined text-xl">history</span>
                    <h2 class="text-base font-bold text-primary">Activity &amp; Audit</h2>
                </div>
                <span class="font-mono text-xs text-slate-500"><?= count($auditLogs) ?> logged events</span>
            </div>
            <div class="bg-[#FDF6F0] border border-border/60 p-4 rounded-xl font-mono text-xs leading-relaxed text-slate-600 max-h-[340px] overflow-y-auto">
                <?php if (!$auditLogs): ?>
                    <div class="py-8 text-center text-slate-400">
                        <span class="material-symbols-outlined text-3xl mb-1 text-slate-300">receipt_long</span>
                        <p>No audit events recorded</p>
                    </div>
                <?php endif; ?>
                <?php foreach ($auditLogs as $event): ?>
                    <div class="py-2 border-b border-border/30 last:border-b-0 flex items-start gap-2">
                        <span class="text-slate-400 shrink-0"><?= $escape($event['created_at']) ?></span>
                        <strong class="text-primary shrink-0"><?= $escape($event['action']) ?></strong>
                        <span class="truncate"><?= $escape($event['resource_type']) ?> #<?= $escape($event['resource_id']) ?> · <?= $escape($event['outcome']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Training Scenarios Table -->
    <section class="bg-white border border-border rounded-xl p-6 shadow-sm flex flex-col gap-4">
        <div class="flex items-center justify-between pb-3 border-b border-border/40">
            <div class="flex items-center gap-2 text-primary">
                <span class="material-symbols-outlined text-xl">account_tree</span>
                <h2 class="text-base font-bold text-primary">Training Scenarios</h2>
            </div>
            <span class="font-mono text-xs text-slate-500"><?= count($scenarios) ?> scenarios</span>
        </div>
        <div class="vp-table-container">
            <table class="vp-table">
                <thead>
                    <tr>
                        <th>Scenario Code &amp; Title</th>
                        <th>Version</th>
                        <th>Status</th>
                        <th>Tickets</th>
                        <th>Datasets</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$scenarios): ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-500">
                                <div class="vp-empty-state border-0 bg-transparent py-4">
                                    <span class="material-symbols-outlined vp-empty-icon text-3xl">account_tree</span>
                                    <p class="vp-empty-title">No scenarios published</p>
                                    <p class="vp-empty-desc">Create a training scenario in the Scenario Builder.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($scenarios as $scenario): ?>
                        <tr>
                            <td>
                                <strong class="text-primary font-mono text-xs"><?= $escape($scenario['code']) ?></strong>
                                <span class="text-slate-800 ml-1.5 font-medium"><?= $escape($scenario['title']) ?></span>
                            </td>
                            <td class="font-mono text-xs"><?= $escape($scenario['version']) ?></td>
                            <td>
                                <span class="vp-badge vp-badge-primary"><?= $escape($scenario['status']) ?></span>
                            </td>
                            <td class="font-mono text-xs font-semibold"><?= (int)$scenario['tickets_count'] ?></td>
                            <td class="font-mono text-xs font-semibold"><?= (int)$scenario['datasets_count'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Bottom System Health Telemetry Panels (3 balanced columns) -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="bg-white border border-border rounded-xl p-6 shadow-sm flex flex-col justify-between min-h-[170px]">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-bold text-primary font-mono uppercase tracking-wide">Database Request</h3>
                    <span class="vp-dot bg-emerald-500"></span>
                </div>
                <p class="font-mono text-sm text-slate-800 bg-[#FDF6F0] p-3 rounded-lg border border-border/50 my-2">
                    SELECT 1 checked: <strong class="text-primary"><?= $escape($databaseHealth) ?></strong>
                </p>
            </div>
            <p class="text-xs text-on-surface-variant font-mono">Measured during this page request only.</p>
        </div>

        <div class="bg-white border border-border rounded-xl p-6 shadow-sm flex flex-col justify-between min-h-[170px]">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-bold text-primary font-mono uppercase tracking-wide">Compute / GPU / Worker</h3>
                    <span class="vp-dot bg-amber-500"></span>
                </div>
                <p class="font-mono text-sm text-slate-600 bg-[#FDF6F0] p-3 rounded-lg border border-border/50 my-2">
                    NOT AVAILABLE
                </p>
            </div>
            <p class="text-xs text-on-surface-variant leading-relaxed">
                No metrics available. Execution is disabled until an isolated runner is deployed and verified.
            </p>
        </div>

        <div class="bg-white border border-border rounded-xl p-6 shadow-sm flex flex-col justify-between min-h-[170px]">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-bold text-primary font-mono uppercase tracking-wide">Inference / SLA / Sync</h3>
                    <span class="vp-dot bg-slate-400"></span>
                </div>
                <p class="font-mono text-sm text-slate-600 bg-[#FDF6F0] p-3 rounded-lg border border-border/50 my-2">
                    NOT AVAILABLE
                </p>
            </div>
            <p class="text-xs text-on-surface-variant leading-relaxed">
                No endpoint health measurements or latency samples are available.
            </p>
        </div>
    </section>
</div>
