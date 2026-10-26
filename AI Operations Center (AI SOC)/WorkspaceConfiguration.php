<?php
require_once __DIR__ . '/../app/bootstrap.php';
use App\Middleware\AuthorizationMiddleware;
use App\Core\Auth;
use App\Core\Csrf;
use App\Services\SubmissionService;
AuthorizationMiddleware::requireAdmin();
$currentUser=Auth::user();
$service=new SubmissionService();
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (!Csrf::validate($_POST['csrf_token']??null)) { http_response_code(403); exit('Invalid CSRF token.'); }
    try {
        $payload=['status'=>$_POST['status']??'','feedback'=>$_POST['feedback']??''];
        if (($_POST['total_score']??'')!=='') $payload['total_score']=$_POST['total_score'];
        $service->reviewSubmission((int)($_POST['submission_id']??0),$payload,(int)$currentUser['id']);
        header('Location: WorkspaceConfiguration.php?id='.(int)$_POST['submission_id'].'&reviewed=1');exit;
    } catch (Throwable $e) { $error=$e->getMessage(); }
}
$submissions=$service->listSubmissions((int)$currentUser['id'],'ADMIN');
$selected=null;
if ($submissions) {
    $target=(int)($_GET['id']??$submissions[0]['id']);
    foreach($submissions as $sub) if((int)$sub['id']===$target)$selected=$service->getSubmission($target,(int)$currentUser['id'],'ADMIN');
}
$escape=static fn($value)=>htmlspecialchars((string)($value??''),ENT_QUOTES,'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="web_dashboard" name="shell-type" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=JetBrains+Mono:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/tailwind.config.js"></script>
</head>

<body class="fiberglass-bg font-body-md text-on-surface min-h-screen">
    <header class="fixed top-0 left-0 right-0 h-16 bg-surface-container-lowest/90 backdrop-blur-md shadow-[0_1px_8px_rgba(76,29,149,0.06)] z-50 flex items-center justify-between px-margin-desktop">
        <div class="flex items-center gap-space-lg">
            <div class="flex items-center gap-space-sm"><img alt="VOSTOKPRIBOR Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida/AEtjO1WFY3uXJ_9VBQSYhio3LVjLuY04weLyokzp987wSe7sNmLm6J_v-iBWBRUy3suJiuOvORdi5ycPrycJRlBFblqocpH7MR32xcHH09--U1FZEYb_N7dqQPHlWW5BW_vPyKR6necxQ856c6yxbD1S94T0POQSl-8SC_gqw2chw0ZgIDADFAOBMGy7ZpT4PuJKdlN_YkmHcsGM8Ou4GukoU-klYJiuzJdHRIk4WL9qKtKyBqjVPsyWFLOElrc" />
                <div class="flex flex-col"><span class="font-headline-sm text-headline-sm text-primary tracking-tight">VOSTOKPRIBOR</span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Range AI Control</span></div>
            </div>
            <div class="h-6 w-px bg-surface-container-highest"></div>
            <nav class="hidden xl:flex items-center gap-space-xs p-1 bg-surface-container-low rounded-lg" data-active-classes="bg-secondary-container text-primary font-bold"><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-tickets" href="../AI Project Management/Dashboard.php">SYS-AI-01</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-data" href="../Data Center/dashboard.php">SYS-AI-02</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-workbench" href="../ML Workbench/NotebookWorkbench.php">SYS-AI-03</a><a class="px-space-sm py-1 rounded text-on-surface-variant hover:text-primary font-label-md text-label-md transition-colors" data-path="subsystem-models" href="../Model Registry & Deployment/dashboard.php">SYS-AI-04</a><a class="px-space-sm py-1 rounded bg-primary-container text-white font-bold font-label-md text-label-md shadow-sm" data-path="dashboard" href="TicketsAndScenarios.php">SYS-AI-05 [ACTIVE]</a></nav>
        </div>
        <div class="flex items-center gap-space-md">
            <div class="hidden md:flex items-center gap-space-xs bg-surface-container px-space-md py-1.5 rounded-lg w-64 text-on-surface-variant"><span class="material-symbols-outlined text-[18px]">search</span><span class="font-body-sm text-body-sm text-on-surface-variant">Search telemetry, models...</span></div>
            <div class="hidden lg:flex items-center gap-space-xs bg-tertiary-fixed text-on-tertiary-fixed px-space-sm py-1 rounded-full font-label-sm text-label-sm"><span class="w-2 h-2 rounded-full bg-error animate-pulse"></span><span>Submission Reviews</span></div><button class="relative p-2 rounded-lg text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-colors"><span class="material-symbols-outlined text-[20px]">notifications</span></button>
            <div class="flex items-center gap-space-sm pl-space-xs">
                <div class="flex flex-col text-right hidden sm:flex"><span class="font-label-md text-label-md text-on-surface leading-tight"><?= $escape($currentUser['full_name']) ?></span><span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Administrator</span></div>
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div>
            </div>
        </div>
    </header>
    <aside class="fixed left-0 top-16 bottom-0 w-72 bg-surface-container-lowest shadow-[0_1px_8px_rgba(76,29,149,0.04)] z-40 overflow-y-auto">
        <div class="p-space-md flex flex-col gap-space-lg">
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Overview</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="main-dashboard" href="Dashboard.php"><span class="material-symbols-outlined text-[18px]">space_dashboard</span><span class="font-body-md text-body-md">Main Dashboard</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="training-analytics" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">query_stats</span><span class="font-body-md text-body-md">Training Analytics</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Training Management</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="tickets-and-scenarios" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">tune</span><span class="font-body-md text-body-md">Tickets & Scenarios</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="dataset-management" href="DatasetManagement.php"><span class="material-symbols-outlined text-[18px]">database</span><span class="font-body-md text-body-md">Dataset Management</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="students-and-cohorts" href="StudentManagement.php"><span class="material-symbols-outlined text-[18px]">group</span><span class="font-body-md text-body-md">Students & Cohorts</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="submission-reviews" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">fact_check</span><span class="font-body-md text-body-md">Submission Reviews</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="grading-and-feedback" href="TicketsAndScenarios.php"><span class="material-symbols-outlined text-[18px]">rate_review</span><span class="font-body-md text-body-md">Grading & Feedback</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Platform Administration</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="subsystem-control" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">memory</span><span class="font-body-md text-body-md">Subsystem Control</span></a><a aria-current="page" class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg transition-colors bg-primary-container text-on-primary font-semibold shadow-sm" data-path="workspace-configuration" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">settings_input_component</span><span class="font-body-md text-body-md">Workspace Configuration</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="users-and-permissions" href="WorkspaceConfiguration.php"><span class="material-symbols-outlined text-[18px]">admin_panel_settings</span><span class="font-body-md text-body-md">Users & Permissions</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="audit-logs" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">receipt_long</span><span class="font-body-md text-body-md">Audit Logs</span></a>
            </nav>
            <nav class="flex flex-col gap-space-xs" data-active-classes="bg-primary-container text-on-primary font-semibold shadow-sm">
                <div class="px-space-sm py-1 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">AI Operations</div><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="operations-dashboard" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">hub</span><span class="font-body-md text-body-md">Operations Dashboard</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="model-monitoring" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">monitoring</span><span class="font-body-md text-body-md">Model Monitoring</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="alerts-and-incidents" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">warning</span><span class="font-body-md text-body-md">Alerts & Incidents</span></a><a class="flex items-center gap-space-sm px-space-sm py-2 rounded-lg text-on-surface-variant hover:bg-secondary-fixed hover:text-on-secondary-fixed transition-colors" data-path="deployment-history" href="OperationsDashboard.php"><span class="material-symbols-outlined text-[18px]">history</span><span class="font-body-md text-body-md">Deployment History</span></a>
            </nav>
        </div>
    </aside>
    <div class="pl-72">
        <main class="relative pt-16 min-h-screen px-margin-desktop py-margin">
<div class="w-full"><div class="flex flex-col w-full gap-space-lg">
    <div class="flex items-center justify-between bg-surface-container-lowest p-space-md rounded-xl shadow-sm"><div><h1 class="font-headline-lg text-headline-lg text-primary font-bold">Submission Reviews &amp; Feedback</h1><p class="font-body-sm text-body-sm text-on-surface-variant">Review actual student submissions and persist the decision in MySQL.</p></div><a href="TicketsAndScenarios.php" class="px-space-md py-space-sm bg-primary text-on-primary rounded-lg">Tickets &amp; Scenarios</a></div>
    <?php if ($error): ?><div class="p-space-md rounded-xl bg-error-container text-on-error-container"><?= $escape($error) ?></div><?php endif; ?>
    <?php if (isset($_GET['reviewed'])): ?><div class="p-space-md rounded-xl bg-secondary-fixed text-primary">Review saved to MySQL. The student can see the decision and feedback.</div><?php endif; ?>
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-space-lg">
        <div class="xl:col-span-8 bg-surface-container-lowest p-space-md rounded-xl shadow-sm space-y-space-md"><h2 class="font-headline-sm text-headline-sm text-primary font-bold">Submitted Work</h2>
            <div class="overflow-x-auto"><table class="w-full text-left font-body-sm text-body-sm"><thead class="bg-surface-container-low text-on-surface-variant uppercase"><tr><th class="p-space-sm">Submission</th><th class="p-space-sm">Student</th><th class="p-space-sm">Ticket</th><th class="p-space-sm">Status</th></tr></thead><tbody class="divide-y divide-outline-variant/30"><?php if (!$submissions): ?><tr><td colspan="4" class="p-12 text-center text-on-surface-variant">No submissions</td></tr><?php endif; ?><?php foreach ($submissions as $sub): ?><tr><td class="p-space-sm"><a class="text-primary underline" href="?id=<?= (int)$sub['id'] ?>"><?= $escape($sub['submission_code']) ?></a></td><td class="p-space-sm"><?= $escape($sub['student_name']) ?></td><td class="p-space-sm"><?= $escape($sub['ticket_code']) ?></td><td class="p-space-sm"><?= $escape($sub['status']) ?></td></tr><?php endforeach; ?></tbody></table></div>
            <?php if ($selected): ?><div class="p-space-md rounded-lg bg-surface-container-low space-y-space-sm"><h3 class="font-headline-sm text-headline-sm text-primary font-bold"><?= $escape($selected['submission_code']) ?></h3><p><?= $escape($selected['student_name'].' — '.$selected['student_identifier']) ?></p><p class="whitespace-pre-wrap"><?= $escape($selected['notes']) ?></p><p>Model: <?= $escape($selected['model_name']??'No model attached') ?></p><p>Notebook: <?= $escape($selected['notebook_title']??'No notebook attached') ?></p><p>Submitted: <?= $escape($selected['created_at']) ?></p></div><?php endif; ?>
        </div>
        <div class="xl:col-span-4 bg-surface-container-lowest p-space-md rounded-xl shadow-sm space-y-space-md"><h2 class="font-headline-sm text-headline-sm text-primary font-bold">Instructor Decision</h2>
            <?php if (!$selected): ?><p class="py-8 text-center text-on-surface-variant">No submissions to review.</p><?php elseif (in_array($selected['status'],['SUBMITTED','UNDER_REVIEW'],true)): ?>
            <form method="post" class="flex flex-col gap-space-md"><input type="hidden" name="csrf_token" value="<?= Csrf::getToken() ?>"><input type="hidden" name="submission_id" value="<?= (int)$selected['id'] ?>"><label>Decision<select required name="status" class="w-full p-space-sm rounded-lg bg-surface-container-low border border-outline-variant/40"><option value="CHANGES_REQUESTED">Request Changes</option><option value="APPROVED">Approve</option><option value="REJECTED">Reject</option></select></label><label>Score (optional)<input name="total_score" type="number" min="0" max="100" step="0.1" class="w-full p-space-sm rounded-lg bg-surface-container-low border border-outline-variant/40"></label><label>Feedback<textarea name="feedback" rows="7" required class="w-full p-space-sm rounded-lg bg-surface-container-low border border-outline-variant/40"></textarea></label><button class="w-full bg-primary text-on-primary py-space-sm rounded-xl font-headline-sm shadow-md">Save Review</button><p class="font-body-sm text-body-sm text-on-surface-variant">Approval records an instructor decision. It does not claim automated validation or deploy a model.</p></form>
            <?php else: ?><div class="p-space-md rounded-lg bg-surface-container-low"><strong><?= $escape($selected['status']) ?></strong><p class="whitespace-pre-wrap"><?= $escape($selected['feedback']) ?></p><p>Score: <?= $selected['total_score']===null?'Not scored':$escape($selected['total_score']) ?></p><p>Reviewed by <?= $escape($selected['reviewer_name']) ?> at <?= $escape($selected['reviewed_at']) ?></p></div><?php endif; ?>
        </div>
    </div>
</div></div>
</main>
    </div>
</body>

</html>