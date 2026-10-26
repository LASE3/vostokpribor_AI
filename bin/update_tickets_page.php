<?php
$filePath = __DIR__ . '/../AI Project Management/Tickets.php';
$content = file_get_contents($filePath);

// Find the start of tbody and end of tbody
$startMarker = '<tbody class="divide-y divide-surface-container font-body-md text-body-md" id="ticketRowsContainer">';
$endMarker = '</tbody>';

$startPos = strpos($content, $startMarker);
if ($startPos === false) {
    die("Start marker not found\n");
}

$endPos = strpos($content, $endMarker, $startPos);
if ($endPos === false) {
    die("End marker not found\n");
}

$newTbody = <<<'PHP'
<tbody class="divide-y divide-surface-container font-body-md text-body-md" id="ticketRowsContainer">
<?php if (empty($tickets)): ?>
    <tr>
        <td colspan="9" class="py-12 px-6 text-center">
            <div class="flex flex-col items-center justify-center gap-3">
                <span class="material-symbols-outlined text-4xl text-primary opacity-60">assignment_late</span>
                <div class="flex flex-col">
                    <span class="font-bold text-base text-primary">No Work Orders Assigned</span>
                    <span class="text-xs text-on-surface-variant mt-1">There are currently no tickets assigned to your cadet profile in this engineering range. When flight directors schedule a training scenario, your tickets will appear here with requirements and grading rubrics.</span>
                </div>
            </div>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($tickets as $t): ?>
        <?php
        $statusClasses = match($t['status']) {
            'ASSIGNED' => 'bg-secondary-fixed text-on-secondary-fixed',
            'IN_PROGRESS' => 'bg-primary-fixed text-on-primary-fixed',
            'SUBMITTED', 'UNDER_REVIEW' => 'bg-amber-100 text-amber-900 border border-amber-300',
            'APPROVED' => 'bg-emerald-100 text-emerald-900 border border-emerald-300',
            'CHANGES_REQUESTED' => 'bg-rose-100 text-rose-900 border border-rose-300',
            default => 'bg-surface-container text-on-surface-variant'
        };
        $priorityDot = match($t['priority']) {
            'CRITICAL' => 'bg-error animate-pulse',
            'HIGH' => 'bg-amber-500',
            'MEDIUM' => 'bg-primary',
            default => 'bg-outline-variant'
        };
        ?>
        <tr class="hover:bg-surface-container-low transition-colors group cursor-pointer ticket-row"
            data-id="<?= htmlspecialchars($t['ticket_code']) ?>"
            data-priority="<?= htmlspecialchars($t['priority']) ?>"
            data-scenario="<?= htmlspecialchars($t['scenario_title'] ?? 'Core AI') ?>"
            data-status="<?= htmlspecialchars($t['status']) ?>">
            <td class="py-space-md px-space-md font-code-inline text-label-md">
                <span class="inline-flex items-center px-2 py-0.5 rounded bg-primary text-on-primary font-bold shadow-sm">
                    <?= htmlspecialchars($t['ticket_code']) ?>
                </span>
            </td>
            <td class="py-space-md px-space-md">
                <div class="flex flex-col min-w-0">
                    <div class="flex items-center gap-space-xs">
                        <span class="font-headline-md text-[14px] text-primary font-semibold truncate">
                            <?= htmlspecialchars($t['title']) ?>
                        </span>
                    </div>
                    <span class="font-body-sm text-body-sm text-on-surface-variant truncate">
                        <?= htmlspecialchars($t['description'] ?? 'Work order for AI telemetry range pipeline.') ?>
                    </span>
                </div>
            </td>
            <td class="py-space-md px-space-md hidden md:table-cell">
                <div class="flex flex-col font-label-sm text-label-sm">
                    <span class="font-semibold text-on-surface"><?= htmlspecialchars($t['student_name'] ?? ($currentUser['full_name'] ?? 'Cadet')) ?></span>
                    <span class="text-on-surface-variant font-code-inline"><?= htmlspecialchars($t['student_identifier'] ?? $currentUser['identifier']) ?></span>
                </div>
            </td>
            <td class="py-space-md px-space-md hidden lg:table-cell">
                <span class="inline-flex items-center px-2 py-0.5 rounded bg-secondary-container text-on-secondary-container font-label-sm text-label-sm font-semibold">
                    <?= htmlspecialchars($t['scenario_title'] ?? 'Training Scenario') ?>
                </span>
            </td>
            <td class="py-space-md px-space-md">
                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded bg-surface-container-high font-label-sm text-label-sm font-bold text-primary">
                    <span class="w-2 h-2 rounded-full <?= $priorityDot ?>"></span>
                    <span><?= htmlspecialchars($t['priority']) ?></span>
                </div>
            </td>
            <td class="py-space-md px-space-md hidden sm:table-cell font-code-inline text-label-sm">
                <span><?= htmlspecialchars($t['deadline'] ? date('M j, Y', strtotime($t['deadline'])) : 'Open SLA') ?></span>
            </td>
            <td class="py-space-md px-space-md">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded <?= $statusClasses ?> font-label-sm text-label-sm font-semibold">
                    <span><?= htmlspecialchars(str_replace('_', ' ', $t['status'])) ?></span>
                </span>
            </td>
            <td class="py-space-md px-space-md hidden xl:table-cell">
                <span class="font-code-inline text-label-sm font-semibold text-primary">
                    <?= $t['status'] === 'APPROVED' ? '100% Certified' : ($t['status'] === 'IN_PROGRESS' ? 'In Progress' : 'Queued') ?>
                </span>
            </td>
            <td class="py-space-md px-space-md text-right">
                <a href="TicketDetails.php?id=<?= $t['id'] ?>" class="px-space-md py-1 rounded bg-primary text-on-primary hover:bg-secondary transition-all font-label-sm text-label-sm font-semibold shadow-sm inline-flex items-center gap-0.5">
                    <span>Inspect</span>
                    <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
PHP;

$content = substr($content, 0, $startPos) . $newTbody . substr($content, $endPos);
file_put_contents($filePath, $content);
echo "Successfully updated Tickets.php with dynamic tbody.\n";
