<?php
/** Shared authenticated data for SYS-03 / SYS-04; all reads are side-effect free. */
require_once __DIR__ . '/../bootstrap.php';

use App\Core\Database;
use App\Core\Csrf;
use App\Services\NotebookService;
use App\Services\ModelService;
use App\Services\ValidationService;
use App\Services\ExperimentService;
use App\Middleware\AuthenticationMiddleware;

$currentUser = AuthenticationMiddleware::handle();
$rangeError = '';
$rangeNotice = '';
$rangeNotebookService = new NotebookService();
$rangeModelService = new ModelService();
$rangeAdmin = $currentUser['role'] === 'ADMIN';
$rangeUserId = (int)$currentUser['id'];
$rangeParams = $rangeAdmin ? [] : ['sid' => $rangeUserId];
$rangeWhere = $rangeAdmin ? '' : ' WHERE student_id = :sid';
$rangeTickets = Database::query($rangeAdmin
    ? 'SELECT t.* FROM tickets t ORDER BY t.updated_at DESC'
    : 'SELECT t.* FROM tickets t JOIN ticket_assignments ta ON ta.ticket_id = t.id WHERE ta.student_id = :sid ORDER BY t.updated_at DESC', $rangeParams);
$activeTicket = $rangeTickets[0] ?? null;
$rangeActiveScenario = $activeTicket && $activeTicket['scenario_id'] ? Database::queryOne('SELECT title FROM scenarios WHERE id = :id', ['id' => $activeTicket['scenario_id']]) : null;
$rangeContextName = $rangeActiveScenario['title'] ?? 'No assigned scenario';
$rangeNotificationCount = (int)(Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id = :id AND is_read = 0', ['id' => $rangeUserId])['n'] ?? 0);

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) { http_response_code(419); $rangeError = 'Incorrect CSRF token. No changes were saved.'; }
    else {
        try {
            $action = (string)($_POST['action'] ?? '');
            if ($rangePage === 'NotebookWorkbench' && $action === 'create_notebook') {
                $created = $rangeNotebookService->createNotebook($_POST, $rangeUserId);
                header('Location: NotebookWorkbench.php?id=' . $created['id'], true, 303); exit;
            } elseif ($rangePage === 'NotebookWorkbench' && $action === 'save_notebook') {
                $sources = $_POST['source'] ?? [];
                $types = $_POST['cell_type'] ?? [];
                if (!is_array($sources) || !is_array($types)) { throw new InvalidArgumentException('Invalid notebook cells.'); }
                $cells = [];
                foreach ($sources as $i => $source) { $cells[] = ['source' => $source, 'cell_type' => $types[$i] ?? 'code']; }
                $saved = $rangeNotebookService->saveNotebook((int)$_POST['notebook_id'], ['cells' => $cells], $rangeUserId, $currentUser['role']);
                header('Location: NotebookWorkbench.php?id=' . $saved['id'] . '&saved=1', true, 303); exit;
            } elseif ($rangePage === 'ModelRegistry' && $action === 'register_model') {
                $created = $rangeModelService->registerModel($_POST, $rangeUserId);
                header('Location: ModelRegistry.php?id=' . $created['id'] . '&registered=1', true, 303); exit;
            } elseif ($rangePage === 'ModelRegistry' && $action === 'upload_artifact') {
                $rangeModelService->addVersion((int)$_POST['model_id'], $_FILES['artifact_file'] ?? [], $_POST, $rangeUserId, $currentUser['role']);
                header('Location: ModelRegistry.php?id=' . (int)$_POST['model_id'] . '&uploaded=1', true, 303); exit;
            } elseif (in_array($rangePage, ['ValidationPipeline', 'RangeEvaluation'], true) && $action === 'request_validation') {
                $run = (new ValidationService())->runValidation((int)$_POST['model_id'], (int)$_POST['model_version_id'], $rangeUserId);
                header('Location: ' . ($rangeSystem === 'ml' ? '../Model Registry & Deployment/' : '') . 'ValidationReports.php?id=' . $run['id'], true, 303); exit;
            } elseif ($rangePage === 'ExperimentRuns' && $action === 'create_experiment') {
                (new ExperimentService())->createExperiment($_POST, $rangeUserId);
                header('Location: ExperimentRuns.php?created=1', true, 303); exit;
            } else { throw new InvalidArgumentException('Unsupported action for this page.'); }
        } catch (Throwable $e) { http_response_code(422); $rangeError = $e->getMessage(); }
    }
}
$rangeNotebooks = Database::query('SELECT * FROM notebooks' . $rangeWhere . ' ORDER BY updated_at DESC', $rangeParams);
$rangeExperiments = Database::query('SELECT * FROM experiments' . $rangeWhere . ' ORDER BY created_at DESC', $rangeParams);
$rangeRuns = Database::query('SELECT * FROM experiment_runs' . $rangeWhere . ' ORDER BY created_at DESC', $rangeParams);
$rangeModels = $rangeModelService->listModels($rangeUserId, $currentUser['role']);
$rangeVersions = Database::query('SELECT mv.*, m.name AS model_name, m.model_code, m.student_id FROM model_versions mv JOIN models m ON m.id = mv.model_id' . ($rangeAdmin ? '' : ' WHERE m.student_id = :sid') . ' ORDER BY mv.created_at DESC', $rangeParams);
$rangeValidations = Database::query('SELECT vr.*, m.name AS model_name, m.model_code FROM validation_runs vr JOIN models m ON m.id = vr.model_id' . ($rangeAdmin ? '' : ' WHERE m.student_id = :sid') . ' ORDER BY vr.created_at DESC', $rangeParams);
$rangeDeployments = Database::query('SELECT dr.*, m.name AS model_name, m.model_code FROM deployment_requests dr JOIN models m ON m.id = dr.model_id' . ($rangeAdmin ? '' : ' WHERE m.student_id = :sid') . ' ORDER BY dr.created_at DESC', $rangeParams);
$rangeDatasets = Database::query($rangeAdmin ? 'SELECT * FROM datasets ORDER BY created_at DESC' : 'SELECT DISTINCT d.* FROM datasets d JOIN dataset_assignments da ON da.dataset_id = d.id WHERE da.student_id = :sid ORDER BY d.created_at DESC', $rangeParams);
$rangeNotebook = null;
if ($rangePage === 'NotebookWorkbench') {
    $id = (int)($_GET['id'] ?? ($rangeNotebooks[0]['id'] ?? 0));
    if ($id) {
        try { $rangeNotebook = $rangeNotebookService->getNotebook($id, $rangeUserId, $currentUser['role']); }
        catch (Throwable $e) { http_response_code(404); $rangeError = 'Notebook not found or access denied.'; }
    }
}
$rangeReport = null;
if ($rangePage === 'ValidationReports' && !empty($_GET['id'])) {
    try { $rangeReport = (new ValidationService())->getRun((int)$_GET['id'], $rangeUserId, $currentUser['role']); }
    catch (Throwable $e) { http_response_code(404); $rangeError = 'Validation report not found or access denied.'; }
}
function range_h(mixed $value): string { return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8'); }
function range_empty(string $label, string $detail = ''): void { echo '<div class="py-12 px-space-md text-center text-on-surface-variant"><span class="material-symbols-outlined text-4xl mb-2 text-outline">inventory_2</span><p class="font-bold text-primary">' . range_h($label) . '</p><p class="text-label-sm mt-2">' . range_h($detail) . '</p></div>'; }
function range_ticket_options(array $tickets): void { echo '<option value="">No linked ticket</option>'; foreach ($tickets as $t) { echo '<option value="' . (int)$t['id'] . '">' . range_h($t['ticket_code'] . ' — ' . $t['title']) . '</option>'; } }
