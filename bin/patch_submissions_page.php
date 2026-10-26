<?php
$file = __DIR__ . '/../AI Project Management/Submissions.php';
$content = file_get_contents($file);

$topPhp = <<<'PHP'
<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

// Handle new submission creation from modal if posted
$submitSuccess = '';
$submitError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_submission') {
    $ticketId = (int)($_POST['ticket_id'] ?? 0);
    $notes = trim($_POST['notes'] ?? '');
    if ($ticketId > 0 && !empty($notes)) {
        // Verify assignment
        $assigned = ($currentUser['role'] === 'ADMIN') ? true : (bool)$db->fetchOne(
            "SELECT id FROM ticket_assignments WHERE ticket_id = :tid AND student_id = :sid",
            ['tid' => $ticketId, 'sid' => $currentUser['id']]
        );

        if ($assigned) {
            $subCode = 'SUBM-' . strtoupper(bin2hex(random_bytes(4)));
            $iter = (int)$db->fetchValue("SELECT COUNT(*) FROM submissions WHERE ticket_id = :tid AND student_id = :sid", [
                'tid' => $ticketId,
                'sid' => $currentUser['id']
            ]) + 1;

            $subId = $db->insert(
                "INSERT INTO submissions (submission_code, ticket_id, student_id, iteration, notes, status, created_at, updated_at)
                 VALUES (:code, :tid, :sid, :iter, :notes, 'SUBMITTED', NOW(), NOW())",
                [
                    'code' => $subCode,
                    'tid' => $ticketId,
                    'sid' => $currentUser['id'],
                    'iter' => $iter,
                    'notes' => $notes
                ]
            );

            $db->update("UPDATE tickets SET status = 'SUBMITTED', updated_at = NOW() WHERE id = :id AND status IN ('ASSIGNED', 'IN_PROGRESS')", ['id' => $ticketId]);

            $db->insert("INSERT INTO audit_logs (user_id, action, resource_type, resource_id, outcome, ip_address, user_agent, details_json, created_at)
                         VALUES (:uid, 'SUBMISSION_CREATE', 'SUBMISSION', :rid, 'SUCCESS', :ip, :ua, :details, NOW())", [
                'uid' => $currentUser['id'],
                'rid' => $subId,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                'ua' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI',
                'details' => json_encode(['ticket_id' => $ticketId, 'code' => $subCode])
            ]);

            $submitSuccess = "Artifact deliverable successfully submitted ($subCode). Dispatched to review pipeline.";
        } else {
            $submitError = "You are not assigned to the selected ticket.";
        }
    } else {
        $submitError = "Please select a ticket and provide submission methodology notes.";
    }
}

// Load student's assigned tickets for modal dropdown
$assignedTickets = [];
if ($currentUser['role'] === 'ADMIN') {
    $assignedTickets = $db->fetchAll("SELECT id, ticket_code, title FROM tickets ORDER BY created_at DESC");
} else {
    $assignedTickets = $db->fetchAll("SELECT t.id, t.ticket_code, t.title FROM tickets t JOIN ticket_assignments ta ON t.id = ta.ticket_id WHERE ta.student_id = :sid ORDER BY t.created_at DESC", ['sid' => $currentUser['id']]);
}

// Load submissions
$submissions = [];
if ($currentUser['role'] === 'ADMIN') {
    $submissions = $db->fetchAll("
        SELECT s.*, t.ticket_code, t.title AS ticket_title, stud.full_name AS student_name, stud.identifier AS student_identifier, rev.full_name AS reviewer_name
        FROM submissions s
        JOIN tickets t ON s.ticket_id = t.id
        JOIN users stud ON s.student_id = stud.id
        LEFT JOIN users rev ON s.reviewed_by = rev.id
        ORDER BY s.created_at DESC
    ");
} else {
    $submissions = $db->fetchAll("
        SELECT s.*, t.ticket_code, t.title AS ticket_title, rev.full_name AS reviewer_name
        FROM submissions s
        JOIN tickets t ON s.ticket_id = t.id
        LEFT JOIN users rev ON s.reviewed_by = rev.id
        WHERE s.student_id = :sid
        ORDER BY s.created_at DESC
    ", ['sid' => $currentUser['id']]);
}

// Stats
$totalSubmissions = count($submissions);
$underReviewCount = 0;
$approvedCount = 0;
$revisionsCount = 0;
foreach ($submissions as $s) {
    if (in_array($s['status'], ['SUBMITTED', 'UNDER_REVIEW'])) $underReviewCount++;
    if ($s['status'] === 'APPROVED') $approvedCount++;
    if (in_array($s['status'], ['CHANGES_REQUESTED', 'REJECTED'])) $revisionsCount++;
}
?>
PHP;

if (strpos($content, 'AuthenticationMiddleware::handle()') === false) {
    $content = $topPhp . "\n" . $content;
}

// Replace User in header
$content = preg_replace(
    '/<div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md font-semibold text-on-surface">Alex Chen<\/span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline">VK-88219<\/span><\/div>/',
    '<div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md font-semibold text-on-surface"><?= htmlspecialchars($currentUser[\'full_name\']) ?></span><span class="font-label-sm text-label-sm text-on-surface-variant font-code-inline"><?= htmlspecialchars($currentUser[\'identifier\'] ?? $currentUser[\'email\']) ?></span></div>',
    $content
);

// Replace Stat counters (Total, Approved, Under Review, Changes Requested)
$content = preg_replace('/<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline">12<\/span>/', '<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline"><?= $totalSubmissions ?></span>', $content);
$content = preg_replace('/<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline">8<\/span>/', '<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline"><?= $approvedCount ?></span>', $content);
$content = preg_replace('/<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline">2<\/span>/', '<span class="font-headline-lg text-headline-lg font-bold text-on-surface font-code-inline"><?= $underReviewCount ?></span>', $content);

// Dynamic submissions table/list
$oldListPattern = '/<!-- Table \/ Submission Rows Container -->[\s\S]*?<\/div>\s*<\/div>\s*<\/div>\s*<!-- Pagination \/ Footer Controls -->/';

$newList = <<<'HTML'
<!-- Table / Submission Rows Container -->
<div class="flex flex-col divide-y divide-surface-container">
    <?php if (empty($submissions)): ?>
        <div class="p-12 text-center flex flex-col items-center justify-center gap-2">
            <span class="material-symbols-outlined text-4xl text-outline-variant">inventory_2</span>
            <span class="font-headline-sm font-bold text-on-surface">No Submissions Recorded</span>
            <p class="font-body-sm text-on-surface-variant max-w-md">You have not submitted any model deliverables yet. Open your assigned tickets in SYS-AI-01 to prepare and package a candidate solution.</p>
        </div>
    <?php else: ?>
        <?php foreach ($submissions as $sub): ?>
            <div class="p-space-md hover:bg-surface-container-low transition-colors flex flex-col lg:flex-row lg:items-center justify-between gap-space-md">
                <div class="flex items-start gap-space-md">
                    <div class="w-10 h-10 rounded-xl bg-primary-container flex items-center justify-center text-white mt-0.5 shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">task_alt</span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-space-xs flex-wrap">
                            <span class="font-code-inline font-bold text-primary"><?= htmlspecialchars($sub['submission_code']) ?></span>
                            <span class="px-space-xs py-0.5 rounded bg-surface-container font-code-inline text-label-sm font-semibold text-on-surface">Iteration #<?= $sub['iteration'] ?></span>
                            <span class="px-space-xs py-0.5 rounded font-label-sm text-label-sm font-bold <?= $sub['status'] === 'APPROVED' ? 'bg-emerald-100 text-emerald-800' : ($sub['status'] === 'CHANGES_REQUESTED' ? 'bg-amber-100 text-amber-800' : 'bg-secondary-fixed text-on-secondary-fixed') ?>">
                                <?= htmlspecialchars($sub['status']) ?>
                            </span>
                            <?php if (!empty($sub['student_name'])): ?>
                                <span class="text-xs text-on-surface-variant font-mono">by <?= htmlspecialchars($sub['student_name']) ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="font-body-md font-semibold text-on-surface"><?= htmlspecialchars($sub['ticket_code']) ?>: <?= htmlspecialchars($sub['ticket_title']) ?></span>
                        <p class="font-body-sm text-on-surface-variant line-clamp-2"><?= htmlspecialchars($sub['notes'] ?: 'No submission notes provided.') ?></p>
                        <?php if (!empty($sub['feedback'])): ?>
                            <div class="mt-1 p-2 rounded bg-surface-container text-xs font-mono text-primary border-l-2 border-primary">
                                <strong>Instructor Feedback:</strong> <?= htmlspecialchars($sub['feedback']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-space-md self-end lg:self-center font-mono text-xs">
                    <div class="flex flex-col text-right">
                        <span class="text-on-surface font-semibold">Submitted: <?= date('M d, Y H:i', strtotime($sub['created_at'])) ?> UTC</span>
                        <span class="text-on-surface-variant">Reviewer: <?= htmlspecialchars($sub['reviewer_name'] ?? 'Pending Review') ?></span>
                    </div>
                    <div class="text-center px-3 py-1.5 rounded-lg bg-surface-container-high font-bold text-primary">
                        Score: <?= $sub['total_score'] !== null ? $sub['total_score'] . '/100' : 'N/A' ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</div>
</div>
<!-- Pagination / Footer Controls -->
HTML;

$content = preg_replace($oldListPattern, $newList, $content, 1);

// Add modal for submit deliverable
$modalHtml = <<<'HTML'
<!-- Submit New Artifact Modal -->
<div id="submitModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-surface-container-lowest rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-outline-variant flex flex-col gap-4">
        <div class="flex items-center justify-between pb-3 border-b border-surface-container">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-2xl">cloud_upload</span>
                <h3 class="font-headline-md font-bold text-on-surface">Submit Deliverable Artifact</h3>
            </div>
            <button type="button" onclick="document.getElementById('submitModal').classList.add('hidden')" class="text-on-surface-variant hover:text-on-surface">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <?php if (empty($assignedTickets)): ?>
            <div class="p-4 rounded-xl bg-amber-50 text-amber-900 text-xs font-mono">
                No active tickets available for submission. You must first have an assigned operational ticket.
            </div>
        <?php else: ?>
            <form method="POST" class="flex flex-col gap-3 font-sans">
                <input type="hidden" name="action" value="create_submission">
                
                <div class="flex flex-col gap-1">
                    <label class="font-label-sm font-semibold text-on-surface-variant">Select Assigned Ticket:</label>
                    <select name="ticket_id" required class="p-2 rounded-lg border border-outline-variant bg-surface-container-low text-xs font-mono">
                        <?php foreach ($assignedTickets as $at): ?>
                            <option value="<?= $at['id'] ?>"><?= htmlspecialchars($at['ticket_code']) ?> - <?= htmlspecialchars($at['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="font-label-sm font-semibold text-on-surface-variant">Methodology Notes &amp; Defense:</label>
                    <textarea name="notes" rows="4" required placeholder="Describe model metrics, cross-validation setup, hyperparameter decisions..." class="p-2 rounded-lg border border-outline-variant bg-surface-container-low text-xs"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-surface-container">
                    <button type="button" onclick="document.getElementById('submitModal').classList.add('hidden')" class="px-4 py-2 rounded-lg text-on-surface-variant text-xs font-mono hover:bg-surface-container">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-white text-xs font-mono font-bold hover:bg-primary-container transition-colors">Submit Candidate Package</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('openSubmitModalBtn');
    if (btn) {
        btn.addEventListener('click', function() {
            document.getElementById('submitModal').classList.remove('hidden');
        });
    }
});
</script>
HTML;

$content = str_replace('</body>', $modalHtml . "\n</body>", $content);

file_put_contents($file, $content);
echo "Submissions.php successfully updated with dynamic database data.\n";
