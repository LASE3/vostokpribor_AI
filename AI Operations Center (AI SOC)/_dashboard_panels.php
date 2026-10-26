<?php
if (!isset($pageType, $counts, $students, $scenarios)) {
    http_response_code(404);
    exit;
}
// Included after the authenticated SOC page has loaded persisted data.
$escape = static fn($value) => htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
?>
<div class="w-full">
    <div class="flex flex-col w-full gap-space-lg">
        <section class="flex flex-col gap-space-md">
            <div class="flex flex-wrap items-center justify-between gap-space-md bg-surface-container-lowest p-space-md rounded-xl shadow-sm">
                <div>
                    <div class="flex items-center gap-space-sm text-primary"><span class="material-symbols-outlined"><?= $pageType === 'operations' ? 'hub' : 'space_dashboard' ?></span>
                        <h1 class="font-headline-lg text-headline-lg font-bold"><?= $pageType === 'operations' ? 'AI Operations Dashboard' : 'AI SOC Mission Control' ?></h1>
                    </div>
                    <p class="font-body-sm text-body-sm text-on-surface-variant">Persisted training activity and service availability</p>
                </div>
                <div class="flex items-center gap-space-sm"><a href="TicketsAndScenarios.php" class="px-space-md py-2 rounded-lg bg-primary text-on-primary font-label-md">Create Scenario / Ticket</a><a href="StudentManagement.php" class="px-space-md py-2 rounded-lg bg-secondary-fixed text-primary font-label-md">Create Student</a><a href="WorkspaceConfiguration.php" class="px-space-md py-2 rounded-lg bg-surface-container text-primary font-label-md">Review Submissions</a></div>
            </div>
        </section>
        <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-space-md">
            <?php foreach ([['groups', 'Students', $counts['students'], 'No students'], ['account_tree', 'Scenarios', $counts['scenarios'], 'No scenarios'], ['confirmation_number', 'Tickets', $counts['tickets'], 'No tickets'], ['pending_actions', 'Pending Reviews', $counts['reviews'], 'No submissions'], ['memory', 'Models', $counts['models'], 'No models'], ['crisis_alert', 'Failed Jobs', $counts['failed'], 'No failed execution records']] as [$icon, $label, $value, $empty]): ?>
                <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col gap-space-sm">
                    <div class="flex items-center justify-between"><span class="font-label-sm text-label-sm text-on-surface-variant uppercase"><?= $label ?></span><span class="material-symbols-outlined text-primary"><?= $icon ?></span></div>
                    <div class="font-headline-lg text-headline-lg text-primary font-bold"><?= $value ?></div><span class="font-body-sm text-body-sm text-on-surface-variant"><?= $value === 0 ? $empty : 'MySQL records' ?></span>
                </div>
            <?php endforeach; ?>
        </section>
        <section class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col gap-space-md">
            <div class="flex items-center gap-space-sm"><span class="material-symbols-outlined text-primary">developer_board</span>
                <h2 class="font-headline-sm text-headline-sm text-primary font-bold">Subsystem Status</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-space-md">
                <?php foreach ([['SYS-AI-01', 'Tickets & Scenarios', $counts['tickets'] . ' tickets', '../AI Project Management/Tickets.php'], ['SYS-AI-02', 'Dataset Portal', $counts['datasets'] . ' datasets', 'DatasetManagement.php'], ['SYS-AI-03', 'AI/ML Workbench', $counts['notebooks'] . ' notebooks', '../ML Workbench/NotebookWorkbench.php'], ['SYS-AI-04', 'Model Registry', $counts['models'] . ' models', '../Model Registry & Deployment/ModelRegistry.php'], ['SYS-AI-05', 'AI Ops & SOC', $counts['submissions'] . ' submissions', 'WorkspaceConfiguration.php']] as [$system, $label, $count, $link]): ?>
                    <a href="<?= $escape($link) ?>" class="bg-surface-container-low rounded-lg p-space-md border border-outline-variant/40 flex flex-col gap-space-sm"><span class="font-label-sm text-label-sm text-primary font-bold"><?= $system ?></span><span class="font-headline-sm text-headline-sm font-bold text-primary"><?= $label ?></span><span class="font-body-sm text-body-sm"><?= $count ?></span><span class="font-label-sm text-label-sm text-on-surface-variant">External service health NOT AVAILABLE</span></a>
                <?php endforeach; ?>
            </div>
        </section>
        <section class="grid grid-cols-1 xl:grid-cols-2 gap-space-lg">
            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col gap-space-md">
                <h2 class="font-headline-sm text-headline-sm text-primary font-bold">Student Training Activity</h2>
                <div class="divide-y divide-outline-variant/30"><?php if (!$students): ?><p class="py-8 text-center text-on-surface-variant">No students</p><?php endif; ?><?php foreach ($students as $student): ?><div class="py-space-md flex items-center justify-between">
                            <div><strong class="text-primary"><?= $escape($student['full_name']) ?></strong>
                                <p class="font-mono text-xs"><?= $escape($student['identifier']) ?></p>
                            </div>
                            <div class="text-right font-label-sm text-label-sm"><?= (int)$student['tickets_count'] ?> assigned tickets<br><?= (int)$student['submissions_count'] ?> submissions</div>
                        </div><?php endforeach; ?></div>
            </div>
            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col gap-space-md">
                <h2 class="font-headline-sm text-headline-sm text-primary font-bold">Activity &amp; Audit</h2>
                <div class="bg-surface-container-low p-space-sm rounded-lg font-mono text-xs leading-relaxed text-on-surface-variant"><?php if (!$auditLogs): ?><p class="py-8 text-center">No audit events</p><?php endif; ?><?php foreach ($auditLogs as $event): ?><div class="py-2 border-b border-outline-variant/20"><span><?= $escape($event['created_at']) ?></span> <strong class="text-primary"><?= $escape($event['action']) ?></strong> <?= $escape($event['resource_type']) ?> #<?= $escape($event['resource_id']) ?> · <?= $escape($event['outcome']) ?></div><?php endforeach; ?></div>
            </div>
        </section>
        <section class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm flex flex-col gap-space-md">
            <h2 class="font-headline-sm text-headline-sm text-primary font-bold">Training Scenarios</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left font-body-sm text-body-sm">
                    <thead class="bg-surface-container-low font-label-sm text-label-sm text-on-surface-variant uppercase">
                        <tr>
                            <th class="p-space-sm">Scenario</th>
                            <th class="p-space-sm">Version</th>
                            <th class="p-space-sm">Status</th>
                            <th class="p-space-sm">Tickets</th>
                            <th class="p-space-sm">Datasets</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container-highest"><?php if (!$scenarios): ?><tr>
                                <td colspan="5" class="p-10 text-center text-on-surface-variant">No scenarios</td>
                            </tr><?php endif; ?><?php foreach ($scenarios as $scenario): ?><tr>
                                <td class="p-space-sm"><strong class="text-primary"><?= $escape($scenario['code']) ?></strong> <?= $escape($scenario['title']) ?></td>
                                <td class="p-space-sm"><?= $escape($scenario['version']) ?></td>
                                <td class="p-space-sm"><?= $escape($scenario['status']) ?></td>
                                <td class="p-space-sm"><?= (int)$scenario['tickets_count'] ?></td>
                                <td class="p-space-sm"><?= (int)$scenario['datasets_count'] ?></td>
                            </tr><?php endforeach; ?></tbody>
                </table>
            </div>
        </section>
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-space-md">
            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                <h3 class="font-headline-sm text-headline-sm text-primary font-bold">Database Request</h3>
                <p class="my-6 font-mono text-sm">SELECT 1 checked: <?= $escape($databaseHealth) ?></p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Measured during this page request only.</p>
            </div>
            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                <h3 class="font-headline-sm text-headline-sm text-primary font-bold">Compute / GPU / Worker</h3>
                <p class="my-6 font-mono text-sm">NOT AVAILABLE</p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">No metrics available. Execution is disabled until an isolated runner is deployed and verified.</p>
            </div>
            <div class="bg-surface-container-lowest rounded-xl p-space-md shadow-sm">
                <h3 class="font-headline-sm text-headline-sm text-primary font-bold">Inference / SLA / Synchronization</h3>
                <p class="my-6 font-mono text-sm">NOT AVAILABLE</p>
                <p class="font-body-sm text-body-sm text-on-surface-variant">No endpoint health measurements or latency samples are available.</p>
            </div>
        </section>
    </div>
</div>