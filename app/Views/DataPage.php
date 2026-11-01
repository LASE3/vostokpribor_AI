<?php
use App\Core\Database;
use App\Services\DatasetService;
use App\Repositories\DatasetRepository;
require_once __DIR__ . '/RangeUi.php';
$service = new DatasetService();
$datasetPage=$service->pageForUser((int)$currentUser['id'],$currentUser['role'],null,\App\Core\Pagination::from(['limit'=>50,'offset'=>$_GET['datasets_offset']??0]));
$datasets=$datasetPage['items'];
$admin = $currentUser['role'] === 'ADMIN';
$message = $_SESSION['dataset_flash'] ?? '';
unset($_SESSION['dataset_flash']);
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    try {
        if (!\App\Core\Csrf::validate($_POST['csrf_token'] ?? null)) throw new RuntimeException('Invalid CSRF token.');
        if ($admin && $rangePage !== 'DatasetManagement') throw new \App\Core\AccessDeniedException('Administrative editing is available in AI SOC Dataset Management.');
        switch ($_POST['action'] ?? '') {
            case 'upload_master':
                if (!$admin) throw new RuntimeException('Administrator required.');
                $service->uploadDataset($_FILES['dataset_file'] ?? [], $_POST, (int)$currentUser['id']);
                $message = 'Dataset uploaded and saved.'; break;
            case 'assign':
                $service->assignDataset((int)($_POST['dataset_id'] ?? 0), (int)($_POST['student_id'] ?? 0), (int)$currentUser['id'], (int)($_POST['ticket_id'] ?? 0), !empty($_POST['dataset_version_id']) ? (int)$_POST['dataset_version_id'] : null);
                $message = 'Dataset assignment saved.'; break;
            case 'edit_metadata':
                $service->updateMetadata((int)($_POST['dataset_id'] ?? 0), $_POST, (int)$currentUser['id']);
                $message = 'Dataset metadata saved.'; break;
            case 'upload_version':
                $service->addVersion((int)($_POST['dataset_id'] ?? 0), $_FILES['dataset_file'] ?? [], $_POST, (int)$currentUser['id']);
                $message = 'Immutable dataset version saved; prior assignments retain their versions.'; break;
            case 'revoke':
                $service->revokeDataset((int)($_POST['dataset_id'] ?? 0), (int)($_POST['student_id'] ?? 0), (int)$currentUser['id'], !empty($_POST['ticket_id']) ? (int)$_POST['ticket_id'] : null);
                $message = 'Dataset access revoked; saved work retained.'; break;
            case 'archive':
                $service->archiveDataset((int)($_POST['dataset_id'] ?? 0), (int)$currentUser['id']);
                $message = 'Dataset archived; files and historical work retained.'; break;
            case 'upload_processed':
                $service->uploadProcessedDataset((int)($_POST['source_dataset_id'] ?? 0), (int)$currentUser['id'], (int)($_POST['ticket_id'] ?? 0), $_FILES['processed_file'] ?? [], $_POST);
                $message = 'Processed data saved.'; break;
            default: throw new InvalidArgumentException('Unsupported action.');
        }
        $_SESSION['dataset_flash'] = $message;
        header('Location: ' . basename($_SERVER['SCRIPT_FILENAME']) . (!empty($_POST['dataset_id']) ? '?id=' . (int)$_POST['dataset_id'] : ''), true, 303); exit;
    } catch (\App\Core\AccessDeniedException $e) { http_response_code(403); $message = \App\Core\Diagnostic::publicMessage($e); }
    catch (Throwable $e) { http_response_code(\App\Core\Diagnostic::status($e)); $message = \App\Core\Diagnostic::publicMessage($e); }
}
$titles = ['dashboard'=>'Data Center', 'DatasetCatalog'=>'Dataset Catalog', 'MyDataSet'=>'My Datasets', 'DataProfilingAndQuality'=>'Data Profiling & Quality', 'QueryWorkspace'=>'Query Workspace', 'RecentActivityAndAudit'=>'Recent Activity & Audit', 'UploadProcessedData'=>'Upload Processed Data', 'DatasetManagement'=>'Dataset Management'];
echo '<div class="flex flex-col gap-5 pt-2"><div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2"><h1 class="text-2xl font-bold font-sans text-primary tracking-tight">' . rangeEscape($titles[$rangePage] ?? 'Data Center') . '</h1><div class="relative flex items-center max-w-xs w-full"><span class="material-symbols-outlined absolute left-3 text-slate-400 text-[18px]">search</span><input class="w-full h-9 pl-9 pr-3 rounded-lg bg-white border border-[#F5DEB3] text-xs font-mono text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#4C1D95] focus:ring-1 focus:ring-[#4C1D95] transition-all shadow-xs" data-range-search placeholder="Filter displayed datasets…" type="text" /></div></div>';
if ($message) rangeCard('Result', '<p role="status">' . rangeEscape($message) . '</p>');
$datasetOptions=[]; foreach ($datasets as $d) if (!$d['archived_at']) $datasetOptions[$d['id']] = $d['code'] . ' — ' . $d['name'];
function datasetForm(string $action, string $fields, string $button, string $endpoint, string $method='POST', bool $upload=false): string {
    return str_replace('<form ', '<form data-dataset-api="'.rangeEscape($endpoint).'" data-dataset-method="'.rangeEscape($method).'" ', rangeForm($action,$fields,$button,$upload));
}
$apiBase = '../api/v1/';
if ($rangePage === 'QueryWorkspace') {
    rangeCard('Query execution unavailable', '<p class="text-on-surface-variant">A restricted dataset query engine has not been deployed. No query has run. Use the authorized file preview below to inspect uploaded rows.</p><textarea class="p-3 font-code-sm text-code-sm bg-surface-container-low rounded" rows="6" placeholder="SQL editor — execution unavailable" aria-label="SQL editor"></textarea><button disabled class="px-4 py-2 rounded bg-surface-container text-outline">Execution unavailable</button>');
}
if (in_array($rangePage, ['dashboard','MyDataSet'], true)) {
    $processedPage=$service->pageProcessed((int)$currentUser['id'],$currentUser['role'],\App\Core\Pagination::from(['limit'=>50,'offset'=>$_GET['processed_offset']??0]));$processed=$processedPage['items'];
    $datasetTotals=$service->totalsForUser((int)$currentUser['id'],$currentUser['role']);
    rangeCard('Storage & records', '<div class="grid grid-cols-1 md:grid-cols-3 gap-5"><div><span>Datasets</span><p class="text-3xl text-primary font-bold">' . (int)$datasetTotals['total'] . '</p></div><div><span>Processed uploads</span><p class="text-3xl text-primary font-bold">' . (int)$processedPage['total'] . '</p></div><div><span>Uploaded bytes</span><p class="text-3xl text-primary font-bold">' . (int)$datasetTotals['bytes'] . '</p></div></div><p class="text-on-surface-variant">Service telemetry and storage quota: NOT AVAILABLE.</p>');
    $rows=[]; foreach($processed as $p) $rows[]=[rangeEscape($p['name']),rangeEscape($p['source_dataset_code']),rangeEscape($p['source_version']),rangeEscape($p['ticket_id']),rangeEscape($p['row_count']),'<span class="break-all">'.rangeEscape($p['checksum_sha256']).'</span> · <a class="text-primary underline" href="'.$apiBase.'data/processed/'.(int)$p['id'].'/download">Download</a>'];
    rangeCard('Processed datasets', rangeTable(['Name','Source dataset','Source version','Ticket','Rows','SHA-256 / file'], $rows, 'No processed datasets').rangePagination($processedPage,'processed_offset'));
}
if ($rangePage === 'RecentActivityAndAudit') {
    $logs = $service->activityForUser((int)$currentUser['id'], $currentUser['role']);
    $rows=[];foreach($logs as $l) $rows[]=[rangeEscape($l['created_at']),rangeEscape($l['action']),rangeEscape($l['resource_type']),rangeEscape($l['resource_id']),rangeEscape($l['outcome'])];
    rangeCard('Audit events', rangeTable(['Time','Action','Resource','ID','Outcome'],$rows,'No audit events'));
} else {
    $rows=[]; foreach($datasets as $d) {
        $url=$apiBase.'data/datasets/'.(int)$d['id'];
        $rows[]=[rangeEscape($d['code']),rangeEscape($d['name']).'<div class="text-xs text-slate-500">'.rangeEscape($d['version']).($d['archived_at'] ? ' · ARCHIVED' : '').'</div>',rangeEscape(strtoupper($d['format'])),rangeEscape($d['row_count']),rangeEscape($d['column_count']),rangeEscape($d['file_size']),'<a class="text-primary underline" href="?id='.(int)$d['id'].'">Preview</a> · <a class="text-primary underline" href="'.$url.'/download">Download</a>'];
    }
    rangeCard('Authorized datasets', rangeTable(['Code','Name','Format','Rows','Columns','Bytes','Actions'],$rows,'No datasets').rangePagination($datasetPage,'datasets_offset'));
    if (!empty($_GET['id'])) {
        try {
            $preview=$service->getPreview((int)$_GET['id'],(int)$currentUser['id'],$currentUser['role'],20,!empty($_GET['version_id'])?(int)$_GET['version_id']:null);
            $rows=[]; foreach($preview['preview_rows'] as $row) { $r=[]; foreach($preview['columns'] as $col) { $v=$row[$col]??null;$r[]=rangeEscape(is_scalar($v)||$v===null?$v:json_encode($v)); } $rows[]=$r; }
            rangeCard('File preview — '. $preview['dataset']['name'],rangeTable($preview['columns'],$rows,'No data rows') . '<p class="font-code-sm text-code-sm break-all">SHA-256: '.rangeEscape($preview['dataset']['checksum_sha256']).'</p><p>Row and column counts come from the uploaded file. Quality evaluation: NOT EVALUATED.</p>');
        } catch(Throwable $e) {http_response_code(\App\Core\Diagnostic::status($e));rangeCard('Dataset unavailable',rangeEscape(\App\Core\Diagnostic::publicMessage($e)));}
    }
}
if ($admin && in_array($rangePage,['DatasetCatalog','DatasetManagement','dashboard'],true)) {
    $scenarioPage=\App\Core\Pagination::query('SELECT id,code,title FROM scenarios ORDER BY id DESC',[],\App\Core\Pagination::from(['limit'=>50,'offset'=>$_GET['scenarios_offset']??0]));$scenarios=$scenarioPage['items'];$scenarioOptions=[];foreach($scenarios as $s)$scenarioOptions[$s['id']]=$s['code'].' — '.$s['title'];
    $scenarioSelect=str_replace(' required ',' ',rangeSelect('scenario_id','Scenario (optional)',$scenarioOptions));
    if ($rangePage === 'DatasetManagement') {
        rangeCard('Scenario selector',rangePagination($scenarioPage,'scenarios_offset'));
        rangeCard('Upload master dataset',datasetForm('upload_master',rangeInput('code','Dataset code').rangeInput('name','Name').rangeInput('description','Description','text',false).$scenarioSelect.rangeInput('dataset_file','CSV / JSON file','file'), 'Upload real file','soc/datasets','POST',true));
    } else {
        rangeCard('Administrator management','<p>Master dataset administration is centralized in AI SOC.</p><a class="vp-btn vp-btn-primary" href="../AI Operations Center (AI SOC)/DatasetManagement.php">Open SOC Dataset Management</a>');
    }
    $studentPage=\App\Core\Pagination::query("SELECT id,full_name,identifier FROM users WHERE role='STUDENT' AND status='ACTIVE' ORDER BY id DESC",[],\App\Core\Pagination::from(['limit'=>50,'offset'=>$_GET['students_offset']??0]));$students=$studentPage['items'];$opts=[];foreach($students as $s)$opts[$s['id']]=$s['identifier'].' — '.$s['full_name'];
    $ticketPage=\App\Core\Pagination::query('SELECT id,ticket_code,title FROM tickets ORDER BY id DESC',[],\App\Core\Pagination::from(['limit'=>50,'offset'=>$_GET['tickets_offset']??0]));$tickets=$ticketPage['items'];$topt=[];foreach($tickets as $t)$topt[$t['id']]=$t['ticket_code'].' — '.$t['title'];
    if ($rangePage === 'DatasetManagement') rangeCard('Assignment selectors','<p>Use the dataset, student and ticket pages to reach every saved record. Changing a page reloads unsaved form input.</p>'.rangePagination($datasetPage,'datasets_offset').rangePagination($studentPage,'students_offset').rangePagination($ticketPage,'tickets_offset'));
    if ($rangePage === 'DatasetManagement') rangeCard('Assign dataset to student & ticket',datasetForm('assign',rangeSelect('dataset_id','Dataset',$datasetOptions).rangeSelect('student_id','Student',$opts).rangeSelect('ticket_id','Assigned ticket',$topt).rangeInput('dataset_version_id','Version ID (optional; latest if blank)','number',false),'Save assignment','soc/datasets/{dataset_id}/assign'));
}
if (!$admin && $rangePage === 'UploadProcessedData') {
    $ticketPage=\App\Core\Pagination::query('SELECT t.id,t.ticket_code FROM tickets t JOIN ticket_assignments a ON a.ticket_id=t.id WHERE a.student_id=:id AND a.revoked_at IS NULL AND t.status<>\'CANCELLED\' ORDER BY t.id DESC',['id'=>$currentUser['id']],\App\Core\Pagination::from(['limit'=>50,'offset'=>$_GET['tickets_offset']??0]));$tickets=$ticketPage['items'];$opts=[];foreach($tickets as $t)$opts[$t['id']]=$t['ticket_code'];
    rangeCard('Upload selectors','<p>Dataset and ticket selectors show the current page of assigned records.</p>'.rangePagination($datasetPage,'datasets_offset').rangePagination($ticketPage,'tickets_offset'));
    rangeCard('Upload processed data',datasetForm('upload_processed',rangeSelect('source_dataset_id','Assigned master dataset',$datasetOptions).rangeSelect('ticket_id','Assigned ticket',$opts).rangeInput('name','Name').rangeInput('transformation_notes','Transformation notes').rangeInput('processed_file','CSV / JSON file','file'),'Save processed dataset','data/processed','POST',true));
}

if (!empty($_GET['id'])) {
    try {
        $selected=$service->getDataset((int)$_GET['id'],(int)$currentUser['id'],$currentUser['role']);
        $versionPage=$service->pageVersions((int)$selected['id'],(int)$currentUser['id'],$currentUser['role'],\App\Core\Pagination::from(['limit'=>50,'offset'=>$_GET['versions_offset']??0]));$versions=$versionPage['items'];
        $rows=[];foreach($versions as $v)$rows[]=[rangeEscape($v['id']),rangeEscape($v['version']),rangeEscape($v['format']),rangeEscape($v['row_count']),rangeEscape($v['file_size']),'<span class="break-all">'.rangeEscape($v['checksum_sha256']).'</span>','<a class="text-primary underline" href="?id='.(int)$selected['id'].'&version_id='.(int)$v['id'].'">Preview</a> · <a class="text-primary underline" href="'.$apiBase.'data/datasets/'.(int)$selected['id'].'/download?version_id='.(int)$v['id'].'">Download</a>'];
        rangeCard('Immutable versions — '.$selected['code'],rangeTable(['Version ID','Version','Format','Rows','Bytes','SHA-256','Actions'],$rows,'No dataset versions').rangePagination($versionPage,'versions_offset'));
        if($admin && $rangePage === 'DatasetManagement'){
            if(!empty($selected['scenario_id'])&&!isset($scenarioOptions[$selected['scenario_id']])){
                $savedScenario=Database::queryOne('SELECT id,code,title FROM scenarios WHERE id=:id',['id'=>$selected['scenario_id']]);
                if($savedScenario)$scenarioOptions[$savedScenario['id']]=$savedScenario['code'].' — '.$savedScenario['title'];
            }
            $id=(int)$selected['id'];$hidden='<input type="hidden" name="dataset_id" value="'.$id.'">';
            $nameField='<label class="vp-form-group">Name<input name="name" class="vp-input" required maxlength="255" value="'.rangeEscape($selected['name']).'"></label>';
            $descriptionField='<label class="vp-form-group">Description<textarea name="description" class="vp-input" rows="3">'.rangeEscape($selected['description']).'</textarea></label>';
            $selection='<label class="vp-form-group">Scenario<select name="scenario_id" class="vp-select"><option value="">No scenario</option>';
            foreach(($scenarioOptions??[]) as $sid=>$label)$selection.='<option value="'.(int)$sid.'" '.((int)$selected['scenario_id']===(int)$sid?'selected':'').'>'.rangeEscape($label).'</option>';
            $selection.='</select></label>';
            rangeCard('Edit dataset metadata',datasetForm('edit_metadata',$hidden.$nameField.$descriptionField.$selection,'Save metadata','soc/datasets/'.$id,'PATCH'));
            if(!$selected['archived_at']){
                rangeCard('Upload immutable version',datasetForm('upload_version',$hidden.rangeInput('version','New version label').rangeInput('dataset_file','CSV / JSON file','file'),'Save new version','soc/datasets/'.$id.'/versions','POST',true).'<p class="text-xs text-slate-500">New versions preserve every old file. Existing assignments remain pinned until explicitly reassigned.</p>');
                rangeCard('Archive dataset',datasetForm('archive',$hidden,'Archive and revoke active access','soc/datasets/'.$id.'/archive').'<p class="text-xs text-slate-500">Archival retains master files, version history and students’ processed uploads.</p>');
            }
            $assignmentPage=$service->pageAssignments($id,(int)$currentUser['id'],\App\Core\Pagination::from(['limit'=>50,'offset'=>$_GET['assignments_offset']??0]));$assignments=$assignmentPage['items'];$rows=[];
            foreach($assignments as $a){
                $action=$a['revoked_at']?'Revoked '.rangeEscape($a['revoked_at']):datasetForm('revoke',$hidden.'<input type="hidden" name="student_id" value="'.(int)$a['student_id'].'"><input type="hidden" name="ticket_id" value="'.(int)$a['ticket_id'].'">','Revoke access','soc/datasets/'.$id.'/revoke');
                $rows[]=[rangeEscape($a['identifier']),rangeEscape($a['ticket_code']),rangeEscape($a['version']),rangeEscape($a['created_at']),$action];
            }
            rangeCard('Dataset assignments & usage',rangeTable(['Student','Ticket','Pinned version','Assigned','Access'],$rows,'No assignments').rangePagination($assignmentPage,'assignments_offset'));
            $selectedProcessedPage=$service->pageProcessed((int)$currentUser['id'],$currentUser['role'],\App\Core\Pagination::from(['limit'=>50,'offset'=>$_GET['results_offset']??0]),$id);$rows=[];foreach($selectedProcessedPage['items'] as $processed)$rows[]=[rangeEscape($processed['student_name']),rangeEscape($processed['name']),rangeEscape($processed['source_version']),rangeEscape($processed['ticket_code']),'<a class="text-primary underline" href="'.$apiBase.'data/processed/'.(int)$processed['id'].'/download">Download processed file</a>'];
            rangeCard('Student processed results',rangeTable(['Student','Name','Pinned source version','Ticket','File'],$rows,'No processed results').rangePagination($selectedProcessedPage,'results_offset'));
            $rows=[];foreach($service->activity($id,(int)$currentUser['id']) as $event)$rows[]=[rangeEscape($event['created_at']),rangeEscape($event['actor_name']),rangeEscape($event['action']),rangeEscape($event['outcome'])];
            rangeCard('Dataset activity',rangeTable(['Time','Actor','Action','Outcome'],$rows,'No dataset activity'));
        }
    } catch(Throwable $e) { http_response_code(\App\Core\Diagnostic::status($e)); rangeCard('Dataset inspection unavailable',rangeEscape(\App\Core\Diagnostic::publicMessage($e))); }
}
echo '<script src="../assets/js/dataset-management.js"></script>';

echo '</div>';
