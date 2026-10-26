<?php
use App\Core\Csrf;
/** Data panels use the unified design tokens and preserve the workbench dock widths. */
$rangeInput = 'vp-input w-full px-3.5 py-2 bg-[#FDF6F0] rounded-lg text-sm border border-[#F5DEB3] text-slate-800 focus:border-[#4C1D95] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#4C1D95]/15 transition-all';
$rangeButton = 'vp-btn vp-btn-primary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm transition-all';
$rangeCard = 'vp-card bg-white rounded-xl p-5 shadow-sm border border-[#F5DEB3] flex flex-col gap-3.5';
$rangeTitles = [
    'NotebookWorkbench' => 'Notebook Workbench',
    'ExperimentRuns' => 'Experiment Runs',
    'MetricTelemetry' => 'Metric Telemetry',
    'HyperparameterMatrix' => 'Hyperparameter Matrix',
    'TensorInspector' => 'Tensor Inspector',
    'ModelArtifacts' => 'Model Artifacts',
    'RangeEvaluation' => 'Range Evaluation',
    'dashboard' => 'Model Registry & Deployment Operations',
    'ModelRegistry' => 'Model Registry Catalog',
    'ValidationPipeline' => 'Automated Validation Pipeline Harness',
    'ValidationReports' => 'Validation Reports',
    'DeploymentConfig' => 'Deployment Configuration',
    'DeployedEndpoints' => 'Deployed Endpoints'
];
?>
<div class="flex flex-col w-full gap-6">
    <!-- Shared Page Heading -->
    <div class="bg-white border border-border rounded-xl p-6 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex flex-col gap-1">
            <span class="font-mono text-xs uppercase tracking-wider text-slate-500 font-semibold"><?= $rangeSystem === 'ml' ? 'SYS-AI-03' : 'SYS-AI-04' ?> / <?= range_h($rangeContextName) ?></span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-primary tracking-tight"><?= range_h($rangeTitles[$rangePage] ?? $rangePage) ?></h1>
            <p class="text-xs md:text-sm text-on-surface-variant mt-0.5"><?= range_h($activeTicket ? $activeTicket['ticket_code'] . ' — ' . $activeTicket['title'] : 'No assigned tickets. Create or assign real work to begin.') ?></p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a class="vp-btn vp-btn-primary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm" href="<?= $rangeSystem === 'ml' ? '../Model Registry & Deployment/ModelRegistry.php' : '../ML Workbench/NotebookWorkbench.php' ?>">
                <?= $rangeSystem === 'ml' ? 'Model Registry' : 'Notebook Workbench' ?>
            </a>
        </div>
    </div>

    <?php if ($rangeError): ?>
        <div role="alert" class="p-4 bg-error-container text-on-error-container border border-red-300 rounded-xl text-sm font-medium flex items-center gap-2 shadow-xs">
            <span class="material-symbols-outlined text-lg">error</span>
            <span><?= range_h($rangeError) ?></span>
        </div>
    <?php endif; ?>

    <?php if ($rangePage === 'NotebookWorkbench'): ?>
    <!-- 3-Column Responsive Workbench Layout: Left Dock ~256px, Center Editor Flexible, Right Panel ~320px -->
    <div class="w-full flex flex-col xl:flex-row items-start gap-5">
        <!-- Left Dock (Workspace Tree, Datasets, Create Notebook) -->
        <aside class="w-full xl:w-64 shrink-0 flex flex-col gap-4" id="left-dock">
            <div class="<?= $rangeCard ?>">
                <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                    <span class="material-symbols-outlined text-lg">folder_open</span>
                    <h2 class="font-mono text-xs text-primary uppercase font-bold tracking-wide">Workspace Tree</h2>
                </div>
                <?php if (!$rangeNotebooks): range_empty('No notebooks', 'Create a notebook explicitly using the form below.', 'note_add'); else: foreach ($rangeNotebooks as $nb): ?>
                    <a class="px-3 py-2 rounded-lg hover:bg-lavender text-primary font-mono text-xs break-all transition-colors border border-transparent hover:border-secondary flex items-center gap-2" href="NotebookWorkbench.php?id=<?= (int)$nb['id'] ?>">
                        <span class="material-symbols-outlined text-sm text-secondary">description</span>
                        <span class="truncate"><?= range_h($nb['title']) ?></span>
                    </a>
                <?php endforeach; endif; ?>
            </div>

            <div class="<?= $rangeCard ?>">
                <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                    <span class="material-symbols-outlined text-lg">dataset</span>
                    <h2 class="font-mono text-xs text-primary uppercase font-bold tracking-wide">Assigned Datasets</h2>
                </div>
                <?php if (!$rangeDatasets): range_empty('No datasets', 'No datasets assigned to current ticket.', 'database'); else: foreach ($rangeDatasets as $ds): ?>
                    <div class="font-mono text-xs p-2.5 rounded-lg bg-[#FDF6F0] border border-border/60">
                        <strong class="text-primary block truncate"><?= range_h($ds['name']) ?></strong>
                        <p class="text-slate-500 text-[11px] mt-0.5"><?= (int)$ds['row_count'] ?> rows × <?= (int)$ds['column_count'] ?> cols</p>
                    </div>
                <?php endforeach; endif; ?>
            </div>

            <form method="post" class="<?= $rangeCard ?>">
                <input type="hidden" name="action" value="create_notebook">
                <input type="hidden" name="csrf_token" value="<?= range_h(Csrf::getToken()) ?>">
                <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                    <span class="material-symbols-outlined text-lg">add_circle</span>
                    <h2 class="font-mono text-xs text-primary uppercase font-bold tracking-wide">Create Notebook</h2>
                </div>
                <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                    Title
                    <input class="<?= $rangeInput ?>" name="title" required minlength="2" maxlength="255" placeholder="e.g. baseline_model.ipynb">
                </label>
                <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                    Assigned Ticket
                    <select class="<?= $rangeInput ?>" name="ticket_id"><?php range_ticket_options($rangeTickets); ?></select>
                </label>
                <button class="vp-btn vp-btn-primary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm w-full mt-1" type="submit">
                    Create Notebook
                </button>
            </form>
        </aside>

        <!-- Center Notebook Editor (Flexible min-w-0, Primary interactive area) -->
        <section class="flex-1 min-w-0 w-full flex flex-col gap-4">
            <?php if (!$rangeNotebook): ?>
                <div class="<?= $rangeCard ?> py-12">
                    <?php range_empty('No active notebook selected', 'Choose a notebook from the workspace tree or create a new one to begin editing.', 'edit_note'); ?>
                </div>
            <?php else: ?>
                <div class="<?= $rangeCard ?>">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-border/40">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-2xl text-primary">terminal</span>
                            <h2 class="text-lg font-bold text-primary"><?= range_h($rangeNotebook['title']) ?></h2>
                        </div>
                        <span class="font-mono text-xs bg-lavender text-primary px-2.5 py-1 rounded-full font-semibold border border-secondary/50">
                            Version <?= (int)$rangeNotebook['version'] ?> · <?= range_h($rangeNotebook['status']) ?>
                        </span>
                    </div>
                    <p class="font-mono text-xs text-slate-500">Last persisted: <?= range_h($rangeNotebook['updated_at']) ?></p>
                </div>

                <form method="post" id="notebook-editor" class="flex flex-col gap-4">
                    <input type="hidden" name="action" value="save_notebook">
                    <input type="hidden" name="csrf_token" value="<?= range_h(Csrf::getToken()) ?>">
                    <input type="hidden" name="notebook_id" value="<?= (int)$rangeNotebook['id'] ?>">

                    <div id="notebook-cells" class="flex flex-col gap-4">
                        <?php foreach ($rangeNotebook['cells'] as $cell): ?>
                            <article class="bg-white border border-border rounded-xl p-5 shadow-sm flex flex-col gap-3 transition-all hover:border-secondary" data-notebook-cell>
                                <div class="flex items-center justify-between gap-2 pb-2 border-b border-border/40">
                                    <div class="flex items-center gap-2">
                                        <select name="cell_type[]" class="text-xs font-mono font-semibold text-primary bg-lavender/60 border border-secondary/40 rounded px-2.5 py-1 focus:outline-none">
                                            <option value="code" <?= $cell['cell_type'] === 'code' ? 'selected' : '' ?>>Code [Python]</option>
                                            <option value="markdown" <?= $cell['cell_type'] === 'markdown' ? 'selected' : '' ?>>Markdown</option>
                                        </select>
                                    </div>
                                    <button type="button" data-remove-cell class="text-xs text-rose-600 hover:text-rose-800 font-semibold px-2 py-1 rounded hover:bg-rose-50 transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">delete</span> Remove
                                    </button>
                                </div>
                                <textarea name="source[]" rows="10" class="font-mono text-xs leading-relaxed bg-[#FDF6F0] border border-border p-3.5 rounded-lg text-slate-900 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none w-full resize-y" spellcheck="false"><?= range_h($cell['source']) ?></textarea>
                                <div class="text-[11px] font-mono text-slate-400 flex items-center gap-1.5 pt-1">
                                    <span class="material-symbols-outlined text-sm">lock</span>
                                    <span>Execution unavailable — isolated runner not deployed</span>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <div class="bg-white border border-border rounded-xl p-4 shadow-sm flex flex-wrap items-center justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <button class="vp-btn vp-btn-secondary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm" type="button" id="add-notebook-cell">
                                <span class="material-symbols-outlined text-sm mr-1">add</span> Add Cell
                            </button>
                            <button class="vp-btn vp-btn-primary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm" type="submit">
                                <span class="material-symbols-outlined text-sm mr-1">save</span> Save Notebook
                            </button>
                            <button class="vp-btn vp-btn-outline px-4 py-2 text-xs font-semibold rounded-lg opacity-50 cursor-not-allowed" type="button" disabled title="An isolated runner has not been deployed">
                                <span class="material-symbols-outlined text-sm mr-1">play_disabled</span> Run Unavailable
                            </button>
                        </div>
                        <p class="text-xs text-slate-500 font-mono">Code persisted on save. Isolated execution unavailable.</p>
                    </div>
                </form>

                <template id="notebook-cell-template">
                    <article class="bg-white border border-border rounded-xl p-5 shadow-sm flex flex-col gap-3 transition-all hover:border-secondary" data-notebook-cell>
                        <div class="flex items-center justify-between gap-2 pb-2 border-b border-border/40">
                            <div class="flex items-center gap-2">
                                <select name="cell_type[]" class="text-xs font-mono font-semibold text-primary bg-lavender/60 border border-secondary/40 rounded px-2.5 py-1 focus:outline-none">
                                    <option value="code">Code [Python]</option>
                                    <option value="markdown">Markdown</option>
                                </select>
                            </div>
                            <button type="button" data-remove-cell class="text-xs text-rose-600 hover:text-rose-800 font-semibold px-2 py-1 rounded hover:bg-rose-50 transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">delete</span> Remove
                            </button>
                        </div>
                        <textarea name="source[]" rows="10" class="font-mono text-xs leading-relaxed bg-[#FDF6F0] border border-border p-3.5 rounded-lg text-slate-900 focus:bg-white focus:border-primary focus:ring-2 focus:ring-primary/10 outline-none w-full resize-y" spellcheck="false"></textarea>
                        <div class="text-[11px] font-mono text-slate-400 flex items-center gap-1.5 pt-1">
                            <span class="material-symbols-outlined text-sm">lock</span>
                            <span>Execution unavailable — isolated runner not deployed</span>
                        </div>
                    </article>
                </template>
            <?php endif; ?>
        </section>

        <!-- Right Panel (Execution Status, Telemetry, Experiment Runs) -->
        <aside class="w-full xl:w-80 shrink-0 flex flex-col gap-4" id="right-panel">
            <div class="<?= $rangeCard ?>">
                <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                    <span class="material-symbols-outlined text-lg">speed</span>
                    <h2 class="font-mono text-xs text-primary uppercase font-bold tracking-wide">Execution Status</h2>
                </div>
                <div class="bg-[#FDF6F0] p-3 rounded-lg border border-border/50 text-xs font-mono text-slate-700">
                    <span class="vp-dot bg-slate-400 mr-1.5"></span><strong>Execution unavailable</strong>
                </div>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    A separate sandbox with restricted credentials and verified resource limits has not been deployed. Saving code does not execute it.
                </p>
            </div>

            <div class="<?= $rangeCard ?>">
                <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                    <span class="material-symbols-outlined text-lg">memory</span>
                    <h2 class="font-mono text-xs text-primary uppercase font-bold tracking-wide">Hardware Telemetry</h2>
                </div>
                <?php range_empty('No metrics available', 'No verified worker or GPU telemetry source is connected.', 'memory'); ?>
            </div>

            <div class="<?= $rangeCard ?>">
                <div class="flex items-center justify-between pb-2 border-b border-border/40 text-primary">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">science</span>
                        <h2 class="font-mono text-xs text-primary uppercase font-bold tracking-wide">Experiment Runs</h2>
                    </div>
                    <span class="font-mono text-xs text-slate-500 font-bold"><?= count($rangeRuns) ?></span>
                </div>
                <p class="text-xs text-slate-600 font-mono"><?= count($rangeRuns) ?> saved run records</p>
                <a href="ExperimentRuns.php" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1">
                    <span>View experiment records</span>
                    <span class="material-symbols-outlined text-xs">arrow_forward</span>
                </a>
            </div>
        </aside>
    </div>

    <?php elseif ($rangePage === 'dashboard'): ?>
    <!-- Model Registry & Deployment Operations Dashboard -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 2xl:grid-cols-7 gap-4">
        <?php $stats = [
            'Total Models' => count($rangeModels),
            'Artifact Versions' => count($rangeVersions),
            'Validation Reports' => count($rangeValidations),
            'Awaiting Evaluation' => count(array_filter($rangeModels, fn($m) => $m['status'] === 'VALIDATION_PENDING')),
            'Deployment Requests' => count($rangeDeployments),
            'Endpoint Health' => 'NOT AVAILABLE',
            'Inference Metrics' => 'NOT AVAILABLE'
        ];
        foreach ($stats as $label => $value): ?>
            <div class="bg-white border border-border rounded-xl p-5 shadow-sm flex flex-col justify-between min-h-[120px] transition-all hover:border-secondary hover:shadow-md">
                <span class="font-mono text-xs font-semibold uppercase tracking-wider text-slate-500"><?= range_h($label) ?></span>
                <strong class="text-3xl font-extrabold text-primary font-sans my-1"><?= range_h($value) ?></strong>
                <span class="text-xs text-slate-500 font-mono"><?= ($label === 'Total Models' && !$rangeModels) ? 'No models' : 'persisted' ?></span>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
        <div class="<?= $rangeCard ?> xl:col-span-3">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">fact_check</span>
                <h2 class="text-base font-bold text-primary">Recent Validation &amp; Deployment Runs</h2>
            </div>
            <?php require __DIR__ . '/range_validation_table.php'; ?>
        </div>
        <div class="<?= $rangeCard ?> xl:col-span-2">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">gavel</span>
                <h2 class="text-base font-bold text-primary">Validation Gate Diagnostics</h2>
            </div>
            <?php range_empty('No metrics available', 'Quality evaluation and inference require a verified isolated provider.', 'gavel'); ?>
        </div>
    </div>

    <?php elseif ($rangePage === 'ModelRegistry'): ?>
    <!-- Model Registry Catalog & Balanced Candidate Registration Forms -->
    <div class="<?= $rangeCard ?>">
        <div class="flex items-center justify-between pb-2 border-b border-border/40 text-primary">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-xl">inventory_2</span>
                <h2 class="text-base font-bold text-primary">Registered Candidates · <?= count($rangeModels) ?></h2>
            </div>
        </div>
        <?php require __DIR__ . '/range_model_table.php'; ?>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <form method="post" class="<?= $rangeCard ?> p-6">
            <input type="hidden" name="action" value="register_model">
            <input type="hidden" name="csrf_token" value="<?= range_h(Csrf::getToken()) ?>">
            <div class="pb-2 border-b border-border/40">
                <h2 class="text-base font-bold text-primary">Register Candidate Metadata</h2>
                <p class="text-xs text-on-surface-variant mt-0.5">Registration creates metadata. Upload a genuine artifact separately to create a version.</p>
            </div>
            <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                Model Name
                <input class="<?= $rangeInput ?>" name="name" required minlength="2" maxlength="255" placeholder="e.g. ResNet50 Classifier">
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                    Model Code
                    <input class="<?= $rangeInput ?>" name="model_code" required pattern="[A-Za-z0-9][A-Za-z0-9_.-]{2,63}" placeholder="e.g. resnet50_v1">
                </label>
                <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                    Framework
                    <input class="<?= $rangeInput ?>" name="framework" required minlength="2" maxlength="64" placeholder="e.g. PyTorch, ONNX">
                </label>
            </div>
            <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                Assigned Ticket
                <select class="<?= $rangeInput ?>" name="ticket_id"><?php range_ticket_options($rangeTickets); ?></select>
            </label>
            <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                Description
                <textarea class="<?= $rangeInput ?>" name="description" rows="3" placeholder="Candidate architectural summary and hyperparameter scope..."></textarea>
            </label>
            <button class="vp-btn vp-btn-primary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm mt-1" type="submit">
                Register Metadata
            </button>
        </form>

        <form method="post" enctype="multipart/form-data" class="<?= $rangeCard ?> p-6">
            <input type="hidden" name="action" value="upload_artifact">
            <input type="hidden" name="csrf_token" value="<?= range_h(Csrf::getToken()) ?>">
            <div class="pb-2 border-b border-border/40">
                <h2 class="text-base font-bold text-primary">Upload Real Artifact</h2>
                <p class="text-xs text-on-surface-variant mt-0.5">Upload a serialized model binary to bind an immutable version.</p>
            </div>
            <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                Candidate Model
                <select class="<?= $rangeInput ?>" name="model_id" required>
                    <option value="">Choose registered candidate</option>
                    <?php foreach ($rangeModels as $model): ?>
                        <option value="<?= (int)$model['id'] ?>"><?= range_h($model['model_code'] . ' — ' . $model['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                Immutable Version Tag
                <input class="<?= $rangeInput ?>" name="version" required maxlength="32" placeholder="e.g. v1.0.0">
            </label>
            <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                Model Artifact File (.onnx, .joblib, .json, .pt, .bin)
                <input class="<?= $rangeInput ?> file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-lavender file:text-primary hover:file:bg-purple-200 cursor-pointer" type="file" name="artifact_file" required accept=".onnx,.joblib,.json,.pt,.bin">
            </label>
            <p class="text-xs text-on-surface-variant leading-relaxed">
                Files remain private in the local artifact store. Accepted file extensions do not guarantee safe serialization or quality pass.
            </p>
            <button class="vp-btn vp-btn-primary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm mt-1" type="submit" <?= !$rangeModels ? 'disabled' : '' ?>>
                Upload Artifact
            </button>
        </form>
    </div>

    <?php elseif (in_array($rangePage, ['ValidationPipeline', 'RangeEvaluation'], true)): ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="<?= $rangeCard ?> lg:col-span-2">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">verified_user</span>
                <h2 class="text-base font-bold text-primary">Evidence &amp; Validation</h2>
            </div>
            <div class="bg-[#FDF6F0] border border-border/60 p-4 rounded-xl text-xs space-y-2">
                <p>Quality status: <strong class="text-amber-700 font-mono">NOT_EVALUATED</strong></p>
                <p class="text-slate-600">Artifact integrity can be checked against its stored checksum. Latency, quality, serialization safety, and holdout evaluation remain unavailable until a trusted isolated evaluator produces evidence bound to the artifact and dataset.</p>
                <p class="text-slate-500 font-mono text-[11px]">Student-written metrics are user-reported information and cannot pass validation or enable deployment.</p>
            </div>
            <form method="post" class="flex flex-col gap-3 mt-2">
                <input type="hidden" name="action" value="request_validation">
                <input type="hidden" name="csrf_token" value="<?= range_h(Csrf::getToken()) ?>">
                <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                    Model
                    <select class="<?= $rangeInput ?>" name="model_id" required>
                        <option value="">Choose model</option>
                        <?php foreach ($rangeModels as $m): ?>
                            <option value="<?= (int)$m['id'] ?>"><?= range_h($m['model_code']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                    Uploaded Artifact Version
                    <select class="<?= $rangeInput ?>" name="model_version_id" required>
                        <option value="">Choose artifact belonging to selected model</option>
                        <?php foreach ($rangeVersions as $v): ?>
                            <option value="<?= (int)$v['id'] ?>"><?= range_h($v['model_code'] . ' · ' . $v['version']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <button class="vp-btn vp-btn-primary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm mt-1" type="submit" <?= !$rangeVersions ? 'disabled' : '' ?>>
                    Check Artifact / Request Evaluation
                </button>
            </form>
        </div>

        <div class="<?= $rangeCard ?>">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">analytics</span>
                <h2 class="text-base font-bold text-primary">Gate Metrics</h2>
            </div>
            <?php range_empty('No metrics available', 'No trusted evaluation measurements exist.', 'analytics'); ?>
        </div>
    </div>
    <div class="<?= $rangeCard ?>">
        <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
            <span class="material-symbols-outlined text-xl">list_alt</span>
            <h2 class="text-base font-bold text-primary">Validation Run History</h2>
        </div>
        <?php require __DIR__ . '/range_validation_table.php'; ?>
    </div>

    <?php elseif ($rangePage === 'ValidationReports'): ?>
    <div class="<?= $rangeCard ?>">
        <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
            <span class="material-symbols-outlined text-xl">description</span>
            <h2 class="text-base font-bold text-primary">Validation Reports Inventory</h2>
        </div>
        <?php require __DIR__ . '/range_validation_table.php'; ?>
    </div>
    <?php if ($rangeReport): $report = json_decode($rangeReport['report_json'] ?? '{}', true) ?: []; ?>
        <div class="<?= $rangeCard ?>">
            <div class="flex items-center justify-between pb-2 border-b border-border/40">
                <h2 class="text-base font-bold text-primary"><?= range_h($rangeReport['model_code']) ?> · <?= range_h($rangeReport['status']) ?></h2>
                <span class="font-mono text-xs bg-lavender text-primary px-2.5 py-1 rounded">Score: <?= $rangeReport['score'] === null ? 'NOT_EVALUATED' : range_h($rangeReport['score']) ?></span>
            </div>
            <pre class="font-mono text-xs p-4 bg-[#FDF6F0] border border-border/60 rounded-xl whitespace-pre-wrap break-all leading-relaxed text-slate-800"><?= range_h(json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
        </div>
    <?php endif; ?>

    <?php elseif (in_array($rangePage, ['DeploymentConfig', 'DeployedEndpoints'], true)): ?>
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="<?= $rangeCard ?> xl:col-span-2">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">cell_tower</span>
                <h2 class="text-base font-bold text-primary"><?= $rangePage === 'DeployedEndpoints' ? 'Endpoint Inventory' : 'Deployment Configuration' ?></h2>
            </div>
            <?php range_empty('No verified deployed endpoints', 'Deployment unavailable. No verified inference provider is connected and no endpoint has been created by this application.', 'cell_tower'); ?>
            <button class="vp-btn vp-btn-outline px-4 py-2 text-xs font-semibold rounded-lg opacity-50 cursor-not-allowed mt-2 w-fit" disabled>
                Deployment Unavailable
            </button>
        </div>
        <div class="<?= $rangeCard ?>">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">monitoring</span>
                <h2 class="text-base font-bold text-primary">Endpoint Telemetry</h2>
            </div>
            <?php range_empty('No metrics available', 'Real-time telemetry unavailable without active endpoints.', 'monitoring'); ?>
        </div>
    </div>

    <div class="<?= $rangeCard ?>">
        <div class="flex items-center justify-between pb-2 border-b border-border/40 text-primary">
            <h2 class="text-base font-bold text-primary">Recorded Deployment Requests</h2>
            <span class="font-mono text-xs text-slate-500 font-bold"><?= count($rangeDeployments) ?></span>
        </div>
        <?php if (!$rangeDeployments): range_empty('No deployment requests', 'No historical deployment requests recorded.', 'send_time_extension'); else: ?>
            <p class="text-xs text-on-surface-variant font-mono">These are stored request states. Runtime health is NOT AVAILABLE.</p>
            <div class="vp-table-container mt-2">
                <table class="vp-table">
                    <thead>
                        <tr>
                            <th>Model</th>
                            <th>Environment</th>
                            <th>Request Status</th>
                            <th>Endpoint</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rangeDeployments as $d): ?>
                            <tr>
                                <td class="font-mono text-xs font-bold text-primary"><?= range_h($d['model_code']) ?></td>
                                <td><?= range_h($d['environment']) ?></td>
                                <td><span class="vp-badge vp-badge-secondary"><?= range_h($d['status']) ?></span></td>
                                <td class="font-mono text-xs text-slate-400">NOT VERIFIED</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <?php elseif ($rangePage === 'ModelArtifacts'): ?>
    <div class="<?= $rangeCard ?>">
        <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
            <span class="material-symbols-outlined text-xl">folder_zip</span>
            <h2 class="text-base font-bold text-primary">Model Metadata</h2>
        </div>
        <?php require __DIR__ . '/range_model_table.php'; ?>
    </div>
    <div class="<?= $rangeCard ?>">
        <div class="flex items-center justify-between pb-2 border-b border-border/40 text-primary">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-xl">inventory_2</span>
                <h2 class="text-base font-bold text-primary">Uploaded Artifact Inventory</h2>
            </div>
            <span class="font-mono text-xs text-slate-500 font-bold"><?= count($rangeVersions) ?></span>
        </div>
        <?php if (!$rangeVersions): range_empty('No model artifacts', 'Metadata registration does not create a file.', 'inventory_2'); else: ?>
            <div class="vp-table-container mt-2">
                <table class="vp-table">
                    <thead>
                        <tr>
                            <th>Model / Version</th>
                            <th>Format</th>
                            <th>Size</th>
                            <th>SHA-256 Checksum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rangeVersions as $v): ?>
                            <tr>
                                <td><strong class="text-primary font-mono text-xs"><?= range_h($v['model_code'] . ' · ' . $v['version']) ?></strong></td>
                                <td class="font-mono text-xs"><?= range_h($v['artifact_format']) ?></td>
                                <td class="font-mono text-xs"><?= (int)$v['file_size'] ?> bytes</td>
                                <td class="font-mono text-xs text-slate-500 break-all"><?= range_h($v['checksum_sha256']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <?php elseif ($rangePage === 'ExperimentRuns'): ?>
    <div class="flex flex-col xl:flex-row items-start gap-6">
        <section class="flex-1 min-w-0 w-full flex flex-col gap-6">
            <div class="<?= $rangeCard ?>">
                <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                    <span class="material-symbols-outlined text-xl">table_chart</span>
                    <h2 class="text-base font-bold text-primary">Experiment Runs Matrix</h2>
                </div>
                <?php require __DIR__ . '/range_run_table.php'; ?>
            </div>
            <form method="post" class="<?= $rangeCard ?> p-6">
                <input type="hidden" name="action" value="create_experiment">
                <input type="hidden" name="csrf_token" value="<?= range_h(Csrf::getToken()) ?>">
                <div class="pb-2 border-b border-border/40">
                    <h2 class="text-base font-bold text-primary">Create Experiment Metadata</h2>
                    <p class="text-xs text-on-surface-variant mt-0.5">Author a new experiment record bound to an assigned ticket.</p>
                </div>
                <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                    Experiment Name
                    <input class="<?= $rangeInput ?>" name="name" required minlength="2" maxlength="255" placeholder="e.g. learning_rate_decay_study">
                </label>
                <label class="flex flex-col gap-1 text-xs font-semibold text-slate-700">
                    Assigned Ticket
                    <select class="<?= $rangeInput ?>" name="ticket_id"><?php range_ticket_options($rangeTickets); ?></select>
                </label>
                <button class="vp-btn vp-btn-primary px-4 py-2 text-xs font-semibold rounded-lg shadow-sm mt-1" type="submit">
                    Create Experiment
                </button>
            </form>
        </section>
        <aside class="w-full xl:w-80 shrink-0 flex flex-col gap-4">
            <div class="<?= $rangeCard ?>">
                <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                    <span class="material-symbols-outlined text-lg">science</span>
                    <h2 class="font-mono text-xs text-primary uppercase font-bold tracking-wide">Experiment Inventory</h2>
                </div>
                <?php if (!$rangeExperiments): range_empty('No experiments', 'Author an experiment metadata entry to track parameters.', 'science'); else: foreach ($rangeExperiments as $e): ?>
                    <div class="p-2.5 rounded-lg bg-[#FDF6F0] border border-border/60 font-mono text-xs text-primary">
                        <?= range_h($e['code'] . ' — ' . $e['name']) ?>
                    </div>
                <?php endforeach; endif; ?>
            </div>
            <div class="<?= $rangeCard ?>">
                <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                    <span class="material-symbols-outlined text-lg">memory</span>
                    <h2 class="font-mono text-xs text-primary uppercase font-bold tracking-wide">Run Telemetry</h2>
                </div>
                <?php range_empty('No metrics available', 'A trusted isolated runner has not been deployed.', 'memory'); ?>
            </div>
        </aside>
    </div>

    <?php elseif ($rangePage === 'TensorInspector'): ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="<?= $rangeCard ?> lg:col-span-2">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">biotech</span>
                <h2 class="text-base font-bold text-primary">Tensor &amp; Variable Inspector</h2>
            </div>
            <?php range_empty('No runtime tensors available', 'Execution is disabled until a verified isolated runner is deployed.', 'biotech'); ?>
        </div>
        <div class="<?= $rangeCard ?>">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">memory</span>
                <h2 class="text-base font-bold text-primary">Memory &amp; GPU</h2>
            </div>
            <?php range_empty('No metrics available', 'No live telemetry attached.', 'memory'); ?>
        </div>
    </div>

    <?php elseif ($rangePage === 'HyperparameterMatrix'): ?>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="<?= $rangeCard ?> lg:col-span-8">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">grid_view</span>
                <h2 class="text-base font-bold text-primary">Saved Hyperparameters</h2>
            </div>
            <?php require __DIR__ . '/range_run_table.php'; ?>
        </div>
        <div class="<?= $rangeCard ?> lg:col-span-4">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">equalizer</span>
                <h2 class="text-base font-bold text-primary">Parameter Importance</h2>
            </div>
            <?php range_empty('No metrics available', 'No trusted measurements support a parameter ranking.', 'equalizer'); ?>
        </div>
    </div>

    <?php elseif ($rangePage === 'MetricTelemetry'): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <?php foreach (['Training Loss', 'Predictive Quality', 'Inference Latency', 'GPU Utilization'] as $metric): ?>
            <div class="<?= $rangeCard ?>">
                <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                    <span class="material-symbols-outlined text-lg">show_chart</span>
                    <h2 class="font-mono text-xs text-primary uppercase font-bold"><?= range_h($metric) ?></h2>
                </div>
                <?php range_empty('No metrics available', 'No stream connected.', 'query_stats'); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="<?= $rangeCard ?>">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">history</span>
                <h2 class="text-base font-bold text-primary">Saved Run Records</h2>
            </div>
            <?php require __DIR__ . '/range_run_table.php'; ?>
        </div>
        <div class="<?= $rangeCard ?>">
            <div class="flex items-center gap-2 pb-2 border-b border-border/40 text-primary">
                <span class="material-symbols-outlined text-xl">verified</span>
                <h2 class="text-base font-bold text-primary">Trusted Measurement Provenance</h2>
            </div>
            <?php range_empty('NOT AVAILABLE', 'User-reported metrics are not a trusted evaluation or runtime telemetry source.', 'security'); ?>
        </div>
    </div>
    <?php endif; ?>
</div>

