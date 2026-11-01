<?php

declare(strict_types=1);
require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/Views/Layout/AppLayout.php';

use App\Core\Database;
use App\Middleware\AuthenticationMiddleware;
use App\Views\Layout\AppLayout;

$currentUser = AuthenticationMiddleware::handle();
$admin = $currentUser['role'] === 'ADMIN';
$where = $admin ? '' : ' WHERE student_id=:student';
$params = $admin ? [] : ['student' => (int)$currentUser['id']];
$counts = [];
foreach (['Notebooks' => 'notebooks', 'Experiments' => 'experiments', 'Recorded runs' => 'experiment_runs', 'Registered models' => 'models'] as $label => $table) {
    $counts[$label] = (int)Database::queryOne('SELECT COUNT(*) AS count FROM ' . $table . $where, $params)['count'];
}
$notebooks = Database::query('SELECT id,title,status,version,updated_at FROM notebooks' . $where . ' ORDER BY updated_at DESC,id DESC LIMIT 5', $params);
$experiments = Database::query('SELECT id,name,created_at FROM experiments' . $where . ' ORDER BY created_at DESC,id DESC LIMIT 5', $params);
$h = static fn(mixed $value): string => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
AppLayout::start(['pageTitle' => 'VOSTOKPRIBOR AI · ML Workbench Dashboard', 'systemKey' => 'workbench', 'activePage' => 'Dashboard.php', 'currentUser' => $currentUser]);
?>
<div class="flex flex-col w-full gap-6">
    <div class="bg-white border border-border rounded-xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div><span class="font-mono text-xs uppercase tracking-wider text-slate-500 font-semibold">SYS-AI-03 / ML WORKBENCH</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary tracking-tight">ML Workbench Dashboard</h1>
            <p class="text-xs md:text-sm text-on-surface-variant mt-0.5">Saved notebooks, experiment records, and model metadata.</p>
        </div>
        <a class="vp-btn vp-btn-primary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm" href="NotebookWorkbench.php">Open Notebook Workbench</a>
    </div>
    <?php if ($admin): ?><div class="vp-card bg-white rounded-xl p-5 shadow-sm border border-border text-sm"><p>Administrator inspection is read-only. Manage student work through <a class="text-primary underline" href="../AI Operations Center (AI SOC)/StudentWorkspaces.php">AI SOC</a>.</p></div><?php endif; ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        <?php foreach ($counts as $label => $count): ?><div class="vp-card bg-white rounded-xl p-5 shadow-sm border border-border">
                <p class="font-mono text-xs text-slate-500 uppercase"><?= $h($label) ?></p><strong class="text-3xl font-bold text-primary"><?= $count ?></strong>
            </div><?php endforeach; ?>
    </div>
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
        <section class="vp-card bg-white rounded-xl p-5 shadow-sm border border-border flex flex-col gap-3.5">
            <h2 class="font-mono text-sm text-primary font-bold">Recent notebooks</h2>
            <?php if (!$notebooks): ?><p class="text-sm text-slate-500">No notebooks. Create a notebook explicitly in Notebook Workbench.</p><?php else: foreach ($notebooks as $notebook): ?><a class="border-b border-border py-3 text-sm" href="NotebookWorkbench.php?id=<?= (int)$notebook['id'] ?>"><strong class="text-primary"><?= $h($notebook['title']) ?></strong><span class="block text-xs text-slate-500">Version <?= (int)$notebook['version'] ?> · <?= $h($notebook['status']) ?> · <?= $h($notebook['updated_at']) ?></span></a><?php endforeach;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        endif; ?>
        </section>
        <section class="vp-card bg-white rounded-xl p-5 shadow-sm border border-border flex flex-col gap-3.5">
            <h2 class="font-mono text-sm text-primary font-bold">Recent experiments</h2>
            <?php if (!$experiments): ?><p class="text-sm text-slate-500">No experiments. Save experiment metadata from Experiment Runs.</p><?php else: foreach ($experiments as $experiment): ?><div class="border-b border-border py-3 text-sm"><strong class="text-primary"><?= $h($experiment['name']) ?></strong><span class="block text-xs text-slate-500"><?= $h($experiment['created_at']) ?></span></div><?php endforeach;
                                                                                                                                                                                                                                                                                                                                                                                                            endif; ?>
            <a class="text-primary text-sm underline" href="ExperimentRuns.php">Open Experiment Runs</a>
        </section>
    </div>
    <section class="vp-card bg-white rounded-xl p-5 shadow-sm border border-border">
        <h2 class="font-mono text-sm text-primary font-bold">Execution unavailable</h2>
        <p class="text-sm text-slate-500 mt-2">No verified isolated runner is deployed. Saving code and experiment metadata does not execute Python. No metrics available.</p>
    </section>
</div>
<?php AppLayout::end(['extraScriptsHtml' => '<script src="../assets/js/range-client.js"></script>']); ?>