<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/Views/Layout/AppLayout.php';

use App\Middleware\AuthorizationMiddleware;
use App\Core\Auth;
use App\Core\Csrf;
use App\Services\SubmissionService;
use App\Views\Layout\AppLayout;

AuthorizationMiddleware::requireAdmin();
$currentUser = Auth::user();
$service = new SubmissionService();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::validate($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Invalid CSRF token.');
    }
    try {
        $payload = ['status' => $_POST['status'] ?? '', 'feedback' => $_POST['feedback'] ?? ''];
        if (($_POST['total_score'] ?? '') !== '') {
            $payload['total_score'] = $_POST['total_score'];
        }
        $service->reviewSubmission((int)($_POST['submission_id'] ?? 0), $payload, (int)$currentUser['id']);
        header('Location: WorkspaceConfiguration.php?id=' . (int)$_POST['submission_id'] . '&reviewed=1');
        exit;
    } catch (\Throwable $e) {
        $error = $e->getMessage();
    }
}

$submissions = $service->listSubmissions((int)$currentUser['id'], 'ADMIN');
$selected = null;
if ($submissions) {
    $target = (int)($_GET['id'] ?? $submissions[0]['id']);
    foreach ($submissions as $sub) {
        if ((int)$sub['id'] === $target) {
            $selected = $service->getSubmission($target, (int)$currentUser['id'], 'ADMIN');
        }
    }
}

$escape = static fn($value) => htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');

AppLayout::start([
    'pageTitle' => 'VOSTOKPRIBOR AI · SOC Submission Reviews & Grading',
    'systemKey' => 'soc',
    'activePage' => 'WorkspaceConfiguration.php',
    'currentUser' => $currentUser,
]);
?>

<div class="w-full">
    <div class="flex flex-col w-full gap-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-xl border border-[#F5DEB3] shadow-sm">
            <div>
                <h1 class="text-2xl font-bold font-sans text-primary tracking-tight">Submission Reviews &amp; Feedback</h1>
                <p class="text-xs md:text-sm text-slate-500 mt-1">Review student deliverables, provide qualitative feedback, and persist grading decisions in MySQL.</p>
            </div>
            <a href="TicketsAndScenarios.php" class="vp-btn vp-btn-primary">
                <span class="material-symbols-outlined text-[18px]">tune</span>
                <span>Scenarios &amp; Tickets</span>
            </a>
        </div>

        <?php if ($error): ?>
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-sans"><?= $escape($error) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['reviewed'])): ?>
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-sans font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <span>Review decision saved to MySQL. The student can now inspect the feedback.</span>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
            <div class="xl:col-span-8 vp-card">
                <div class="vp-card-header">
                    <h2 class="vp-card-title">Submitted Student Work</h2>
                </div>
                <div class="vp-table-container">
                    <table class="vp-table">
                        <thead>
                            <tr>
                                <th>Submission</th>
                                <th>Student</th>
                                <th>Ticket</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$submissions): ?>
                                <tr><td colspan="4" class="p-10 text-center text-slate-500 font-mono text-xs">No student submissions recorded</td></tr>
                            <?php endif; ?>
                            <?php foreach ($submissions as $sub): ?>
                                <tr class="<?= ($selected && (int)$selected['id'] === (int)$sub['id']) ? 'bg-[#F3E8FF]/50 font-semibold' : '' ?>">
                                    <td><a class="text-primary hover:underline font-mono" href="?id=<?= (int)$sub['id'] ?>"><?= $escape($sub['submission_code']) ?></a></td>
                                    <td><?= $escape($sub['student_name']) ?></td>
                                    <td><span class="vp-badge vp-badge-primary"><?= $escape($sub['ticket_code']) ?></span></td>
                                    <td><span class="vp-badge <?= $sub['status'] === 'APPROVED' ? 'vp-badge-success' : ($sub['status'] === 'CHANGES_REQUESTED' ? 'vp-badge-warning' : 'vp-badge-primary') ?>"><?= $escape($sub['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($selected): ?>
                    <div class="p-5 rounded-xl bg-[#FDF6F0] border border-[#F5DEB3] space-y-3">
                        <div class="flex items-center justify-between border-b border-[#F5DEB3]/50 pb-2">
                            <h3 class="text-base font-bold text-primary font-mono"><?= $escape($selected['submission_code']) ?></h3>
                            <span class="text-xs text-slate-500 font-mono">Submitted: <?= $escape($selected['created_at']) ?></span>
                        </div>
                        <p class="text-xs font-semibold text-slate-700"><?= $escape($selected['student_name'] . ' — ' . $selected['student_identifier']) ?></p>
                        <div class="p-3 bg-white rounded-lg border border-[#F5DEB3]/60 text-xs text-slate-800 whitespace-pre-wrap leading-relaxed"><?= $escape($selected['notes']) ?></div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs font-mono text-slate-600 pt-1">
                            <div><strong class="text-primary">Model:</strong> <?= $escape($selected['model_name'] ?? 'No model attached') ?></div>
                            <div><strong class="text-primary">Notebook:</strong> <?= $escape($selected['notebook_title'] ?? 'No notebook attached') ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="xl:col-span-4 vp-card">
                <div class="vp-card-header">
                    <h2 class="vp-card-title">Instructor Evaluation & Decision</h2>
                </div>
                <?php if (!$selected): ?>
                    <p class="py-12 text-center text-slate-500 font-mono text-xs">Select a submission from the list to review.</p>
                <?php elseif (in_array($selected['status'], ['SUBMITTED', 'UNDER_REVIEW'], true)): ?>
                    <form method="post" class="flex flex-col gap-4">
                        <input type="hidden" name="csrf_token" value="<?= Csrf::getToken() ?>">
                        <input type="hidden" name="submission_id" value="<?= (int)$selected['id'] ?>">
                        
                        <div class="vp-form-group">
                            <label class="vp-label">Review Decision</label>
                            <select required name="status" class="vp-select">
                                <option value="CHANGES_REQUESTED">Request Changes</option>
                                <option value="APPROVED">Approve Submission</option>
                                <option value="REJECTED">Reject Submission</option>
                            </select>
                        </div>

                        <div class="vp-form-group">
                            <label class="vp-label">Total Score (0–100, Optional)</label>
                            <input name="total_score" type="number" min="0" max="100" step="0.1" placeholder="e.g. 92.5" class="vp-input">
                        </div>

                        <div class="vp-form-group">
                            <label class="vp-label">Instructor Feedback</label>
                            <textarea name="feedback" rows="6" required placeholder="Provide clear feedback on architecture, data pipelines, and validation criteria…" class="vp-textarea"></textarea>
                        </div>

                        <button class="vp-btn vp-btn-primary w-full h-11 text-sm font-bold shadow-md">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                            <span>Save Review Decision</span>
                        </button>
                        <p class="text-[11px] text-slate-500 leading-tight text-center">Approval records an instructor decision and persists to MySQL.</p>
                    </form>
                <?php else: ?>
                    <div class="p-5 rounded-xl bg-[#FDF6F0] border border-[#F5DEB3] space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 uppercase">Recorded Decision</span>
                            <span class="vp-badge <?= $selected['status'] === 'APPROVED' ? 'vp-badge-success' : 'vp-badge-warning' ?>"><?= $escape($selected['status']) ?></span>
                        </div>
                        <div class="p-3 bg-white rounded-lg border border-[#F5DEB3]/60 text-xs text-slate-800 whitespace-pre-wrap leading-relaxed"><?= $escape($selected['feedback']) ?></div>
                        <div class="text-xs font-mono text-slate-600 space-y-1 pt-1">
                            <div><strong class="text-primary">Score:</strong> <?= $selected['total_score'] === null ? 'Not scored' : $escape($selected['total_score']) . ' / 100' ?></div>
                            <div class="text-[11px] text-slate-500">Reviewed by <?= $escape($selected['reviewer_name']) ?> at <?= $escape($selected['reviewed_at']) ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
AppLayout::end([
    'extraScriptsHtml' => '<script src="../assets/js/range-client.js"></script>',
]);