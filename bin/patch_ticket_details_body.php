<?php
// Patch TicketDetails.php body elements
$file = __DIR__ . '/../AI Project Management/TicketDetails.php';
$content = file_get_contents($file);

// Replace User Profile in Header
$content = preg_replace(
    '/<div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md font-semibold text-on-surface">Alex Chen<\/span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">VK-88219<\/span><\/div>/',
    '<div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md font-semibold text-on-surface"><?= htmlspecialchars($currentUser[\'full_name\']) ?></span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline"><?= htmlspecialchars($currentUser[\'identifier\'] ?? $currentUser[\'email\']) ?></span></div>',
    $content
);

// Replace Scenario badge in Header
$content = preg_replace(
    '/<span>Scenario: Churn Prediction \(AI-024\)<\/span>/',
    '<span>Scenario: <?= htmlspecialchars($ticket[\'scenario_title\'] ?? \'General Operations\') ?> (<?= htmlspecialchars($ticket[\'ticket_code\'] ?? \'NONE\') ?>)</span>',
    $content
);

// Handle alerts if any
$alertHtml = <<<'HTML'
<?php if (!empty($commentSuccess) || !empty($submissionSuccess)): ?>
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-800 font-mono text-sm mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">check_circle</span>
        <span><?= htmlspecialchars($commentSuccess ?: $submissionSuccess) ?></span>
    </div>
<?php endif; ?>
<?php if (!empty($commentError) || !empty($submissionError)): ?>
    <div class="p-4 rounded-xl bg-rose-50 border border-rose-300 text-rose-800 font-mono text-sm mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-rose-600">error</span>
        <span><?= htmlspecialchars($commentError ?: $submissionError) ?></span>
    </div>
<?php endif; ?>
HTML;

// Inject alerts right below <div class="px-gutter-desktop py-space-lg flex flex-col gap-space-lg max-w-[1720px] mx-auto w-full">
$content = str_replace(
    '<div class="px-gutter-desktop py-space-lg flex flex-col gap-space-lg max-w-[1720px] mx-auto w-full">',
    '<div class="px-gutter-desktop py-space-lg flex flex-col gap-space-lg max-w-[1720px] mx-auto w-full">' . "\n" . $alertHtml,
    $content
);

// Replace Ticket Code in Breadcrumb
$content = preg_replace(
    '/<span class="font-code-inline font-semibold text-primary px-space-xs py-0.5 rounded bg-surface-container">AI-024<\/span>/',
    '<span class="font-code-inline font-semibold text-primary px-space-xs py-0.5 rounded bg-surface-container"><?= htmlspecialchars($ticket[\'ticket_code\'] ?? \'NO-TICKET\') ?></span>',
    $content
);

// Replace Ticket Status in Breadcrumb
$content = preg_replace(
    '/<span>IN PROGRESS: FEATURE ENGINEERING<\/span>/',
    '<span><?= htmlspecialchars($ticket[\'status\'] ?? \'UNASSIGNED\') ?></span>',
    $content
);

// Replace Priority in Breadcrumb
$content = preg_replace(
    '/<span>PRIORITY: CRITICAL \(P1\)<\/span>/',
    '<span>PRIORITY: <?= htmlspecialchars($ticket[\'priority\'] ?? \'NORMAL\') ?></span>',
    $content
);

// Replace Title
$content = preg_replace(
    '/AI-024: Predictive Customer Churn &amp; Drift Mitigation Pipeline/',
    '<?= htmlspecialchars(($ticket[\'ticket_code\'] ?? \'TKT\') . \': \' . ($ticket[\'title\'] ?? \'No Assigned Ticket Selected\')) ?>',
    $content
);

// Replace Description
$oldDescPattern = '/<!-- Section 1: Comprehensive Mission Overview -->[\s\S]*?<\/section>/';
$newDesc = <<<'HTML'
<!-- Section 1: Comprehensive Mission Overview -->
<section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-md">
    <div class="flex items-center gap-space-sm pb-space-xs border-b border-surface-container">
        <span class="material-symbols-outlined text-primary text-[20px]">terminal</span>
        <h2 class="font-headline-md text-headline-md font-bold text-on-surface">1. Operational Description &amp; Requirements</h2>
    </div>
    <div class="prose max-w-none text-body-md font-body-md text-on-surface-variant leading-relaxed">
        <p><?= nl2br(htmlspecialchars($ticket['description'] ?? 'No description specified for this ticket.')) ?></p>
        <?php if (!empty($ticket['requirements'])): ?>
            <div class="mt-4 p-4 rounded bg-surface-container-low border border-surface-container">
                <span class="font-semibold text-primary block mb-1">Specific Mission Requirements:</span>
                <p class="whitespace-pre-line"><?= htmlspecialchars($ticket['requirements']) ?></p>
            </div>
        <?php endif; ?>
        <?php if (!empty($ticket['acceptance_criteria'])): ?>
            <div class="mt-4 p-4 rounded bg-surface-container-low border border-surface-container">
                <span class="font-semibold text-primary block mb-1">Acceptance Criteria &amp; Thresholds:</span>
                <p class="whitespace-pre-line"><?= htmlspecialchars($ticket['acceptance_criteria']) ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
HTML;

$content = preg_replace($oldDescPattern, $newDesc, $content, 1);

// Replace Section 2: Datasets List
$oldDataPattern = '/<!-- Section 2: Data Sources &amp; Lakehouse Mounts -->[\s\S]*?<\/section>/';
$newData = <<<'HTML'
<!-- Section 2: Data Sources & Lakehouse Mounts -->
<section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-md">
    <div class="flex items-center justify-between pb-space-xs border-b border-surface-container">
        <div class="flex items-center gap-space-sm">
            <span class="material-symbols-outlined text-primary text-[20px]">database</span>
            <h2 class="font-headline-md text-headline-md font-bold text-on-surface">2. Attached Telemetry Data Assets</h2>
        </div>
        <span class="font-label-sm text-label-sm text-on-tertiary-container font-code-inline font-bold">RANGE DATA CENTER (SYS-02)</span>
    </div>
    <div class="flex flex-col gap-space-sm">
        <?php if (empty($datasets)): ?>
            <div class="p-6 rounded bg-surface-container-low text-center font-mono text-sm text-on-surface-variant">
                No telemetry datasets directly assigned or bound to this scenario yet. Check SYS-AI-02 Data Center catalog.
            </div>
        <?php else: ?>
            <?php foreach ($datasets as $ds): ?>
                <div class="p-space-md rounded bg-surface-container-low hover:bg-surface-container transition-colors flex flex-col md:flex-row md:items-center justify-between gap-space-md">
                    <div class="flex items-start gap-space-md">
                        <div class="w-8 h-8 rounded bg-primary-container flex items-center justify-center text-white mt-0.5">
                            <span class="material-symbols-outlined text-[18px]">table_chart</span>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center gap-2">
                                <span class="font-code-inline text-code-inline font-bold text-primary"><?= htmlspecialchars($ds['name']) ?></span>
                                <span class="px-1.5 py-0.2 rounded text-[10px] font-mono bg-surface-container font-bold text-on-surface-variant"><?= htmlspecialchars($ds['format']) ?></span>
                            </div>
                            <span class="font-body-sm text-body-sm text-on-surface-variant"><?= htmlspecialchars($ds['description'] ?? 'Operational range data asset') ?> • <?= number_format($ds['row_count']) ?> rows</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-space-sm pl-11 md:pl-0">
                        <span class="px-space-xs py-0.5 rounded bg-surface-container-highest font-label-sm text-label-sm font-code-inline text-on-surface-variant"><?= round($ds['file_size'] / (1024 * 1024), 2) ?> MB</span>
                        <a class="px-space-sm py-1 rounded bg-primary text-on-primary font-label-sm text-label-sm font-semibold hover:bg-primary-container transition-colors" href="../Data Center/DatasetCatalog.php">
                            Inspect in SYS-02
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
HTML;

$content = preg_replace($oldDataPattern, $newData, $content, 1);

// Replace Section 4: Comments & Notes
$oldNotesPattern = '/<!-- Instructor Timeline & Audit Trail -->[\s\S]*?<\/section>/';
$newNotes = <<<'HTML'
<!-- Instructor Timeline & Audit Trail -->
<section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-md">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-space-sm">
            <span class="material-symbols-outlined text-primary text-[18px]">history_edu</span>
            <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Mission Notes &amp; Audit Trail</h3>
        </div>
        <span class="font-code-inline text-xs text-on-surface-variant"><?= count($comments) ?> entries</span>
    </div>
    
    <div class="relative flex flex-col gap-space-md pl-4 before:content-[''] before:absolute before:left-1.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-surface-container-high max-h-80 overflow-y-auto">
        <?php if (empty($comments)): ?>
            <p class="font-body-sm text-body-sm text-on-surface-variant italic py-2">
                No mission notes or feedback recorded yet. Add an observation below.
            </p>
        <?php else: ?>
            <?php foreach ($comments as $cm): ?>
                <div class="relative flex flex-col gap-1">
                    <span class="absolute -left-4 top-1 w-2.5 h-2.5 rounded-full <?= $cm['role'] === 'ADMIN' ? 'bg-primary' : 'bg-secondary' ?> ring-4 ring-surface-container-lowest"></span>
                    <div class="flex items-center justify-between">
                        <span class="font-label-sm text-label-sm font-code-inline text-primary font-bold"><?= date('M d, H:i', strtotime($cm['created_at'])) ?> UTC</span>
                        <span class="font-label-sm text-label-sm px-1 rounded <?= $cm['role'] === 'ADMIN' ? 'bg-secondary-fixed text-on-secondary-fixed' : 'bg-surface-container text-on-surface-variant' ?>">
                            <?= htmlspecialchars($cm['full_name']) ?> (<?= htmlspecialchars($cm['role']) ?>)
                        </span>
                    </div>
                    <p class="font-body-sm text-body-sm text-on-surface bg-surface-container-low p-space-sm rounded whitespace-pre-wrap">
                        <?= htmlspecialchars($cm['comment']) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Add Note Form -->
    <form method="POST" class="mt-2 flex flex-col gap-2 pt-2 border-t border-surface-container">
        <input type="hidden" name="action" value="add_comment">
        <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?? 0 ?>">
        <textarea name="comment" required rows="2" placeholder="Post progress note or question for instructor..." class="w-full text-xs p-2 rounded-lg border border-outline-variant/60 focus:border-primary focus:outline-none font-sans bg-surface-container-low"></textarea>
        <button type="submit" class="self-end px-3 py-1.5 rounded-lg bg-surface-container-high hover:bg-primary hover:text-white text-primary text-xs font-semibold font-mono transition-colors">
            Post Observation
        </button>
    </form>
</section>
HTML;

$content = preg_replace($oldNotesPattern, $newNotes, $content, 1);

// Replace Deliverable Submission Form
$oldSubPattern = '/<!-- Live Deliverables Sandbox & Upload Component -->[\s\S]*?<\/section>/';
$newSub = <<<'HTML'
<!-- Live Deliverables Sandbox & Upload Component -->
<section class="bg-surface-container-lowest rounded p-space-lg shadow-sm flex flex-col gap-space-md" id="submission-drawer">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-space-sm">
            <span class="material-symbols-outlined text-primary text-[20px]">cloud_upload</span>
            <h3 class="font-headline-md text-headline-md font-bold text-on-surface">Deliverable Submission</h3>
        </div>
        <span class="font-label-sm text-label-sm px-1.5 py-0.5 rounded bg-tertiary-fixed text-on-tertiary-fixed font-code-inline font-semibold">RANGE EVALUATION</span>
    </div>
    
    <?php if (!empty($submissions)): ?>
        <div class="p-3 rounded-lg bg-surface-container-low border border-surface-container">
            <span class="font-label-sm text-label-sm font-bold text-primary block mb-1">Previous Submissions:</span>
            <div class="flex flex-col gap-1 text-xs font-mono">
                <?php foreach (array_slice($submissions, 0, 3) as $sub): ?>
                    <div class="flex items-center justify-between py-1 border-b border-surface-container-highest last:border-0">
                        <span>Iteration #<?= $sub['iteration'] ?> (<?= htmlspecialchars($sub['submission_code']) ?>)</span>
                        <span class="px-1.5 py-0.2 rounded font-bold text-[10px] <?= $sub['status'] === 'APPROVED' ? 'bg-emerald-100 text-emerald-800' : ($sub['status'] === 'CHANGES_REQUESTED' ? 'bg-amber-100 text-amber-800' : 'bg-surface-container text-on-surface-variant') ?>">
                            <?= htmlspecialchars($sub['status']) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <form method="POST" class="flex flex-col gap-3">
        <input type="hidden" name="action" value="submit_deliverable">
        <input type="hidden" name="ticket_id" value="<?= $ticket['id'] ?? 0 ?>">
        
        <div class="flex flex-col gap-1">
            <label class="font-label-sm text-label-sm font-semibold text-on-surface-variant">Submission Notes &amp; Methodology Defense:</label>
            <textarea name="notes" rows="3" required placeholder="Describe your model architecture, data preprocessing strategy, validation results, and F1 / precision performance..." class="w-full text-xs p-2 rounded-lg border border-outline-variant/60 focus:border-primary focus:outline-none font-sans bg-surface-container-low"></textarea>
        </div>

        <button type="submit" class="w-full py-2.5 px-space-md rounded bg-primary text-on-primary font-label-md text-label-md font-bold tracking-wide uppercase hover:bg-primary-container shadow-sm transition-all transform active:scale-98 flex items-center justify-center gap-space-sm" <?= empty($ticket) ? 'disabled' : '' ?>>
            <span class="material-symbols-outlined text-[18px]">play_circle</span>
            <span>Submit Deliverables to Instructor</span>
        </button>
    </form>
</section>
HTML;

$content = preg_replace($oldSubPattern, $newSub, $content, 1);

file_put_contents($file, $content);
echo "TicketDetails.php body elements updated successfully.\n";
