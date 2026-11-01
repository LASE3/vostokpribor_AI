<?php
/** Shared authenticated data for SYS-03 / SYS-04; all reads are side-effect free. */
require_once __DIR__ . '/../bootstrap.php';

use App\Core\Database;
use App\Core\Pagination;
use App\Core\Csrf;
use App\Services\NotebookService;
use App\Services\ModelService;
use App\Services\ValidationService;
use App\Services\ExperimentService;
use App\Middleware\AuthenticationMiddleware;

$currentUser = AuthenticationMiddleware::handle();
$rangeError = '';
$rangeNotice = '';
$rangeNotebookDraft = null;
$rangeNotebookExpectedVersion = null;
$rangeNotebookService = new NotebookService();
$rangeModelService = new ModelService();
$rangeAdmin = $currentUser['role'] === 'ADMIN';
$rangeUserId = (int)$currentUser['id'];
$rangeParams = $rangeAdmin ? [] : ['sid' => $rangeUserId];
$rangeWhere = $rangeAdmin ? '' : ' WHERE student_id = :sid';
$rangeTickets = [];
$rangeCollections = [];
$rangeTotals = [];
// The heading needs one real assignment, not every ticket and all its requirements.
$activeTicket = Database::queryOne($rangeAdmin
    ? 'SELECT t.id,t.ticket_code,t.title,t.scenario_id,s.title AS scenario_title FROM tickets t LEFT JOIN scenarios s ON s.id=t.scenario_id ORDER BY t.updated_at DESC,t.id DESC LIMIT 1'
    : "SELECT t.id,t.ticket_code,t.title,t.scenario_id,s.title AS scenario_title FROM tickets t JOIN ticket_assignments ta ON ta.ticket_id=t.id LEFT JOIN scenarios s ON s.id=t.scenario_id WHERE ta.student_id=:sid AND ta.revoked_at IS NULL AND t.status<>'CANCELLED' ORDER BY t.updated_at DESC,t.id DESC LIMIT 1", $rangeParams);
$rangeContextName = $activeTicket['scenario_title'] ?? 'No assigned scenario';
function range_paging(string $key): array {
    return Pagination::from(['limit'=>$_GET[$key.'_limit']??50,'offset'=>$_GET[$key.'_offset']??0]);
}
function range_collection(string $key,string $label,string $sql,array $params=[],?string $countSql=null): array {
    global $rangeCollections,$rangeTotals;
    $page=Pagination::query($sql,$params,range_paging($key),$countSql);
    $rangeCollections[$key]=['label'=>$label,'page'=>$page]; $rangeTotals[$key]=$page['total'];
    return $page['items'];
}
function range_url(array $changes): string {
    return '?'.http_build_query(array_replace($_GET,$changes));
}
$rangeNotificationCount = (int)(Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id = :id AND is_read = 0', ['id' => $rangeUserId])['n'] ?? 0);

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!Csrf::validate($_POST['csrf_token'] ?? '')) { http_response_code(419); $rangeError = 'Incorrect CSRF token. No changes were saved.'; }
    else {
        try {
            if ($rangeAdmin) throw new \App\Core\AccessDeniedException('Student work pages are read-only for administrators. Manage work in AI SOC.');
            $action = (string)($_POST['action'] ?? '');
            if ($rangePage === 'NotebookWorkbench' && $action === 'create_notebook') {
                $created = $rangeNotebookService->createNotebook($_POST, $rangeUserId);
                header('Location: NotebookWorkbench.php?id=' . $created['id'], true, 303); exit;
            } elseif ($rangePage === 'NotebookWorkbench' && $action === 'save_notebook') {
                $sources = $_POST['source'] ?? [];
                $types = $_POST['cell_type'] ?? [];
                if (!is_array($sources) || !is_array($types)) { throw new InvalidArgumentException('Invalid notebook cells.'); }
                $cells = [];
                foreach ($sources as $i => $source) {
                    if (!is_string($source) || !is_string($types[$i] ?? 'code')) throw new InvalidArgumentException('Invalid notebook cells.');
                    $cells[] = ['source' => $source, 'cell_type' => $types[$i] ?? 'code'];
                }
                $rangeNotebookDraft = $cells;
                $submittedVersion = $_POST['expected_version'] ?? '';
                $rangeNotebookExpectedVersion = is_string($submittedVersion) ? $submittedVersion : '';
                if (!preg_match('/^[1-9][0-9]*$/D', $rangeNotebookExpectedVersion)) throw new InvalidArgumentException('Reload the notebook to obtain its saved version before editing. Your code has been preserved.');
                $saved = $rangeNotebookService->saveNotebook((int)$_POST['notebook_id'], ['cells' => $cells, 'expected_version' => $rangeNotebookExpectedVersion], $rangeUserId, $currentUser['role']);
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
            } elseif ($rangePage === 'DeploymentConfig' && $action === 'request_deployment') {
                $request = (new \App\Services\DeploymentService())->requestDeployment($_POST, $rangeUserId);
                header('Location: DeploymentConfig.php?request_id=' . (int)$request['id'],true,303); exit;
            } else { throw new InvalidArgumentException('Unsupported action for this page.'); }
        } catch (Throwable $e) {
            $conflict = $e instanceof RuntimeException && $e->getCode() === 409;
            http_response_code(\App\Core\Diagnostic::status($e));
            $rangeError = \App\Core\Diagnostic::publicMessage($e) . ($conflict ? ' Your entered code is preserved below. Copy your changes, then reload the latest notebook before saving again.' : '');
        }
    }
}
// Load only collections rendered on this page. JSON/code stays in the selected detail.
$rangeNotebooks=$rangeExperiments=$rangeRuns=$rangeModels=$rangeVersions=$rangeValidations=$rangeDeployments=$rangeDatasets=[];
$ownerWhere=$rangeAdmin?'':' WHERE student_id=:sid';
$modelWhere=$rangeAdmin?'':' WHERE m.student_id=:sid';
if (in_array($rangePage,['NotebookWorkbench','ModelRegistry','ExperimentRuns'],true)) {
    $ticketSql=$rangeAdmin?'SELECT t.id,t.ticket_code,t.title FROM tickets t':'SELECT t.id,t.ticket_code,t.title FROM tickets t JOIN ticket_assignments ta ON ta.ticket_id=t.id WHERE ta.student_id=:sid AND ta.revoked_at IS NULL';
    $rangeTickets=range_collection('tickets','Ticket choices',$ticketSql.' ORDER BY t.updated_at DESC,t.id DESC',$rangeParams);
}
if ($rangePage==='NotebookWorkbench') {
    $rangeNotebooks=range_collection('notebooks','Notebooks','SELECT id,title,student_id,ticket_id,updated_at FROM notebooks'.$ownerWhere.' ORDER BY updated_at DESC,id DESC',$rangeParams,'SELECT COUNT(*) AS total FROM notebooks'.$ownerWhere);
    $rangeTotals['runs']=(int)(Database::queryOne('SELECT COUNT(*) AS total FROM experiment_runs'.$ownerWhere,$rangeParams)['total']??0);
    $datasetPage=(new \App\Services\DatasetService())->pageForUser($rangeUserId,$currentUser['role'],null,range_paging('datasets'));
    $rangeDatasets=$datasetPage['items'];$rangeTotals['datasets']=$datasetPage['total'];$rangeCollections['datasets']=['label'=>'Assigned datasets','page'=>$datasetPage];
}
if ($rangePage==='ExperimentRuns') $rangeExperiments=range_collection('experiments','Experiments','SELECT id,code,name FROM experiments'.$ownerWhere.' ORDER BY created_at DESC,id DESC',$rangeParams,'SELECT COUNT(*) AS total FROM experiments'.$ownerWhere);
if (in_array($rangePage,['ExperimentRuns','HyperparameterMatrix','MetricTelemetry'],true)) {
    $rangeRuns=range_collection('runs','Saved runs','SELECT id,run_uuid,run_name,status,parameters,metrics,measurement_source,dataset_version_id,created_at FROM experiment_runs'.$ownerWhere.' ORDER BY created_at DESC,id DESC',$rangeParams,'SELECT COUNT(*) AS total FROM experiment_runs'.$ownerWhere);
}
if (in_array($rangePage,['ModelRegistry','ModelArtifacts','ValidationPipeline','RangeEvaluation','DeploymentConfig'],true)) {
    $modelPage=$rangeModelService->pageModels($rangeUserId,$currentUser['role'],null,range_paging('models'),true);
    $rangeModels=$modelPage['items'];$rangeTotals['models']=$modelPage['total'];$rangeCollections['models']=['label'=>'Models / model choices','page'=>$modelPage];
}
if (in_array($rangePage,['ModelArtifacts','ValidationPipeline','RangeEvaluation','DeploymentConfig'],true)) $rangeVersions=range_collection('versions','Artifacts / version choices','SELECT mv.id,mv.model_id,mv.version,mv.artifact_format,mv.file_size,mv.checksum_sha256,mv.created_at,m.name AS model_name,m.model_code FROM model_versions mv JOIN models m ON m.id=mv.model_id'.$modelWhere.' ORDER BY mv.created_at DESC,mv.id DESC',$rangeParams,'SELECT COUNT(*) AS total FROM model_versions mv JOIN models m ON m.id=mv.model_id'.$modelWhere);
if (in_array($rangePage,['dashboard','ValidationPipeline','RangeEvaluation','ValidationReports'],true)) $rangeValidations=range_collection('validations','Validation reports','SELECT vr.id,vr.status,vr.score,vr.created_at,m.name AS model_name,m.model_code FROM validation_runs vr JOIN models m ON m.id=vr.model_id'.$modelWhere.' ORDER BY vr.created_at DESC,vr.id DESC',$rangeParams,'SELECT COUNT(*) AS total FROM validation_runs vr JOIN models m ON m.id=vr.model_id'.$modelWhere);
if (in_array($rangePage,['DeploymentConfig','DeployedEndpoints'],true)) $rangeDeployments=range_collection('deployments','Deployment requests','SELECT dr.id,dr.environment,dr.status,dr.created_at,m.name AS model_name,m.model_code FROM deployment_requests dr JOIN models m ON m.id=dr.model_id'.$modelWhere.' ORDER BY dr.created_at DESC,dr.id DESC',$rangeParams,'SELECT COUNT(*) AS total FROM deployment_requests dr JOIN models m ON m.id=dr.model_id'.$modelWhere);
if ($rangePage==='dashboard') {
    $rangeTotals['models']=(int)(Database::queryOne('SELECT COUNT(*) AS total FROM models'.$ownerWhere,$rangeParams)['total']??0);
    $rangeTotals['versions']=(int)(Database::queryOne('SELECT COUNT(*) AS total FROM model_versions mv JOIN models m ON m.id=mv.model_id'.$modelWhere,$rangeParams)['total']??0);
    $rangeTotals['pending']=(int)(Database::queryOne("SELECT COUNT(*) AS total FROM models".($rangeAdmin?' WHERE':$ownerWhere.' AND')." status='VALIDATION_PENDING'",$rangeParams)['total']??0);
    $rangeTotals['deployments']=(int)(Database::queryOne('SELECT COUNT(*) AS total FROM deployment_requests dr JOIN models m ON m.id=dr.model_id'.$modelWhere,$rangeParams)['total']??0);
}
$rangeNotebook = null;
if ($rangePage === 'NotebookWorkbench') {
    $id = (int)($_GET['id'] ?? ($rangeNotebookDraft !== null ? ($_POST['notebook_id'] ?? 0) : ($rangeNotebooks[0]['id'] ?? 0)));
    if ($id) {
        try {
            $rangeNotebook = $rangeNotebookService->getNotebook($id, $rangeUserId, $currentUser['role']);
            if ($rangeNotebookDraft !== null && $id === (int)($_POST['notebook_id'] ?? 0) && $rangeError !== '') $rangeNotebook['cells'] = $rangeNotebookDraft;
        }
        catch (Throwable $e) { http_response_code(404); $rangeError = 'Notebook not found or access denied.'; }
    }
}
$rangeReport = null;
if ($rangePage === 'ValidationReports' && !empty($_GET['id'])) {
    try { $rangeReport = (new ValidationService())->getRun((int)$_GET['id'], $rangeUserId, $currentUser['role']); }
    catch (Throwable $e) { http_response_code(404); $rangeError = 'Validation report not found or access denied.'; }
}
function range_h(mixed $value): string { return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8'); }
function range_empty(string $label, string $detail = '', string $icon = 'inventory_2'): void {
    $detailHtml = $detail !== '' ? '<p class="text-xs text-on-surface-variant max-w-sm mx-auto leading-relaxed mt-1">' . range_h($detail) . '</p>' : '';
    echo '<div class="vp-empty-state py-8 px-4 text-center my-auto"><span class="material-symbols-outlined text-3xl text-secondary mb-1.5">' . range_h($icon) . '</span><p class="font-bold text-sm text-primary">' . range_h($label) . '</p>' . $detailHtml . '</div>';
}
function range_ticket_options(array $tickets): void { echo '<option value="">No linked ticket</option>'; foreach ($tickets as $t) { echo '<option value="' . (int)$t['id'] . '">' . range_h($t['ticket_code'] . ' — ' . $t['title']) . '</option>'; } }
