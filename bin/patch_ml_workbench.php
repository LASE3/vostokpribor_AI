<?php
// Patch ML Workbench pages with real auth & dynamic queries
$files = [
    __DIR__ . '/../ML Workbench/NotebookWorkbench.php',
    __DIR__ . '/../ML Workbench/ExperimentRuns.php',
    __DIR__ . '/../ML Workbench/ModelArtifacts.php',
    __DIR__ . '/../ML Workbench/RangeEvaluation.php',
    __DIR__ . '/../ML Workbench/TensorInspector.php',
    __DIR__ . '/../ML Workbench/HyperparameterMatrix.php',
    __DIR__ . '/../ML Workbench/MetricTelemetry.php'
];

$topPhp = <<<'PHP'
<?php
require_once __DIR__ . '/../app/bootstrap.php';

use App\Middleware\AuthenticationMiddleware;
use App\Core\Database;
use App\Core\Auth;

$currentUser = AuthenticationMiddleware::handle();
$db = Database::getInstance();

$isStudent = ($currentUser['role'] === 'STUDENT');

// Fetch or create initial notebook for student if in NotebookWorkbench
$notebook = null;
$notebookCells = [];
if ($isStudent) {
    $notebook = $db->fetchOne("SELECT * FROM notebooks WHERE student_id = :sid ORDER BY updated_at DESC LIMIT 1", ['sid' => $currentUser['id']]);
    if (!$notebook) {
        // Create initial notebook
        $nbCode = 'NB-' . strtoupper(bin2hex(random_bytes(3)));
        $assignedTicket = $db->fetchOne("SELECT ticket_id FROM ticket_assignments WHERE student_id = :sid LIMIT 1", ['sid' => $currentUser['id']]);
        $ticketId = $assignedTicket ? $assignedTicket['ticket_id'] : null;
        $nbId = $db->insert(
            "INSERT INTO notebooks (code, title, student_id, ticket_id, version, status, kernel_state, created_at, updated_at)
             VALUES (:code, 'telemetry_pipeline_v1.ipynb', :sid, :tid, 1, 'ACTIVE', 'IDLE', NOW(), NOW())",
            [
                'code' => $nbCode,
                'sid' => $currentUser['id'],
                'tid' => $ticketId
            ]
        );
        $notebook = $db->fetchOne("SELECT * FROM notebooks WHERE id = :id", ['id' => $nbId]);

        // Seed initial cells
        $db->insert("INSERT INTO notebook_cells (notebook_id, cell_order, cell_type, source, output_text, updated_at) VALUES (:nid, 1, 'markdown', '# VOSTOKPRIBOR Telemetry Range\\nPipeline candidate notebook.', '', NOW())", ['nid' => $nbId]);
        $db->insert("INSERT INTO notebook_cells (notebook_id, cell_order, cell_type, source, output_text, updated_at) VALUES (:nid, 2, 'code', 'import os, sys\nprint(f\"Python {sys.version.split()[0]} online in range sandbox.\")\nsum_val = sum(range(10))\nprint(f\"Computed sum: {sum_val}\")', 'Loaded Python runtime in sandbox.', NOW())", ['nid' => $nbId]);
    }
} else {
    $notebook = $db->fetchOne("SELECT * FROM notebooks ORDER BY updated_at DESC LIMIT 1");
}

if ($notebook) {
    $notebookCells = $db->fetchAll("SELECT * FROM notebook_cells WHERE notebook_id = :nid ORDER BY cell_order ASC", ['nid' => $notebook['id']]);
}

// Experiment runs
if ($isStudent) {
    $experimentRuns = $db->fetchAll("SELECT * FROM experiment_runs WHERE student_id = :sid ORDER BY created_at DESC", ['sid' => $currentUser['id']]);
    $modelArtifacts = $db->fetchAll("SELECT m.*, mv.version, mv.artifact_path, mv.file_size FROM models m LEFT JOIN model_versions mv ON m.id = mv.model_id WHERE m.student_id = :sid ORDER BY m.created_at DESC", ['sid' => $currentUser['id']]);
} else {
    $experimentRuns = $db->fetchAll("SELECT er.*, u.full_name AS student_name FROM experiment_runs er LEFT JOIN users u ON er.student_id = u.id ORDER BY er.created_at DESC");
    $modelArtifacts = $db->fetchAll("SELECT m.*, mv.version, mv.artifact_path, mv.file_size, u.full_name AS student_name FROM models m LEFT JOIN model_versions mv ON m.id = mv.model_id LEFT JOIN users u ON m.student_id = u.id ORDER BY m.created_at DESC");
}
?>
PHP;

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);

    if (strpos($content, 'AuthenticationMiddleware::handle()') === false) {
        $content = $topPhp . "\n" . $content;
    }

    // Replace header user name and identifier
    $content = preg_replace(
        '/<div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-primary text-\[18px\]">person<\/span><\/div>/',
        '<div class="flex items-center gap-2"><span class="text-xs font-mono text-on-surface-variant hidden md:inline"><?= htmlspecialchars($currentUser[\'full_name\']) ?> (<?= htmlspecialchars($currentUser[\'identifier\'] ?? $currentUser[\'role\']) ?>)</span><div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-on-primary text-[18px]">person</span></div></div>',
        $content
    );

    file_put_contents($file, $content);
    echo "Patched " . basename($file) . "\n";
}
