<?php
use App\Core\Database;
use App\Services\DatasetService;
use App\Repositories\DatasetRepository;
require_once __DIR__ . '/RangeUi.php';
$service = new DatasetService();
$datasets = $service->listForUser((int)$currentUser['id'], $currentUser['role']);
$admin = $currentUser['role'] === 'ADMIN';
$message = '';
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    try {
        if (!\App\Core\Csrf::validate($_POST['csrf_token'] ?? null)) throw new RuntimeException('Invalid CSRF token.');
        switch ($_POST['action'] ?? '') {
            case 'upload_master':
                if (!$admin) throw new RuntimeException('Administrator required.');
                $service->uploadDataset($_FILES['dataset_file'] ?? [], $_POST, (int)$currentUser['id']);
                $message = 'Dataset uploaded and saved.'; break;
            case 'assign':
                $service->assignDataset((int)($_POST['dataset_id'] ?? 0), (int)($_POST['student_id'] ?? 0), (int)$currentUser['id'], (int)($_POST['ticket_id'] ?? 0));
                $message = 'Dataset assignment saved.'; break;
            case 'upload_processed':
                $service->uploadProcessedDataset((int)($_POST['source_dataset_id'] ?? 0), (int)$currentUser['id'], (int)($_POST['ticket_id'] ?? 0), $_FILES['processed_file'] ?? [], $_POST);
                $message = 'Processed data saved.'; break;
            default: throw new RuntimeException('Unsupported action.');
        }
        $datasets = $service->listForUser((int)$currentUser['id'], $currentUser['role']);
    } catch (Throwable $e) { http_response_code(422); $message = $e->getMessage(); }
}
$titles = ['dashboard'=>'Data Center', 'DatasetCatalog'=>'Dataset Catalog', 'MyDataSet'=>'My Datasets', 'DataProfilingAndQuality'=>'Data Profiling & Quality', 'QueryWorkspace'=>'Query Workspace', 'RecentActivityAndAudit'=>'Recent Activity & Audit', 'UploadProcessedData'=>'Upload Processed Data', 'DatasetManagement'=>'Dataset Management'];
echo '<div class="flex flex-col gap-5 pt-2"><div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2"><h1 class="text-2xl font-bold font-sans text-primary tracking-tight">' . rangeEscape($titles[$rangePage] ?? 'Data Center') . '</h1><div class="relative flex items-center max-w-xs w-full"><span class="material-symbols-outlined absolute left-3 text-slate-400 text-[18px]">search</span><input class="w-full h-9 pl-9 pr-3 rounded-lg bg-white border border-[#F5DEB3] text-xs font-mono text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#4C1D95] focus:ring-1 focus:ring-[#4C1D95] transition-all shadow-xs" data-range-search placeholder="Filter displayed datasets…" type="text" /></div></div>';
if ($message) rangeCard('Result', '<p role="status">' . rangeEscape($message) . '</p>');
$datasetOptions=[]; foreach ($datasets as $d) $datasetOptions[$d['id']] = $d['code'] . ' — ' . $d['name'];
$apiBase = '../api/v1/';
if ($rangePage === 'QueryWorkspace') {
    rangeCard('Query execution unavailable', '<p class="text-on-surface-variant">A restricted dataset query engine has not been deployed. No query has run. Use the authorized file preview below to inspect uploaded rows.</p><textarea class="p-3 font-code-sm text-code-sm bg-surface-container-low rounded" rows="6" placeholder="SQL editor — execution unavailable" aria-label="SQL editor"></textarea><button disabled class="px-4 py-2 rounded bg-surface-container text-outline">Execution unavailable</button>');
}
if (in_array($rangePage, ['dashboard','MyDataSet'], true)) {
    $processed = $admin ? Database::query('SELECT * FROM processed_datasets ORDER BY id DESC') : (new DatasetRepository())->listProcessedForStudent((int)$currentUser['id']);
    rangeCard('Storage & records', '<div class="grid grid-cols-1 md:grid-cols-3 gap-5"><div><span>Datasets</span><p class="text-3xl text-primary font-bold">' . count($datasets) . '</p></div><div><span>Processed uploads</span><p class="text-3xl text-primary font-bold">' . count($processed) . '</p></div><div><span>Uploaded bytes</span><p class="text-3xl text-primary font-bold">' . array_sum(array_column($datasets, 'file_size')) . '</p></div></div><p class="text-on-surface-variant">Service telemetry and storage quota: NOT AVAILABLE.</p>');
    $rows=[]; foreach($processed as $p) $rows[]=[rangeEscape($p['name']),rangeEscape($p['source_dataset_id']),rangeEscape($p['ticket_id']),rangeEscape($p['row_count']),rangeEscape($p['checksum_sha256'])];
    rangeCard('Processed datasets', rangeTable(['Name','Source dataset','Ticket','Rows','SHA-256'], $rows, 'No processed datasets'));
}
if ($rangePage === 'RecentActivityAndAudit') {
    $logs = $admin ? Database::query('SELECT * FROM audit_logs ORDER BY id DESC LIMIT 100') : Database::query('SELECT * FROM audit_logs WHERE actor_id=:id ORDER BY id DESC LIMIT 100', ['id'=>$currentUser['id']]);
    $rows=[];foreach($logs as $l) $rows[]=[rangeEscape($l['created_at']),rangeEscape($l['action']),rangeEscape($l['resource_type']),rangeEscape($l['resource_id']),rangeEscape($l['outcome'])];
    rangeCard('Audit events', rangeTable(['Time','Action','Resource','ID','Outcome'],$rows,'No audit events'));
} else {
    $rows=[]; foreach($datasets as $d) {
        $url=$apiBase.'datasets/'.(int)$d['id'];
        $rows[]=[rangeEscape($d['code']),rangeEscape($d['name']),rangeEscape(strtoupper($d['format'])),rangeEscape($d['row_count']),rangeEscape($d['column_count']),rangeEscape($d['file_size']),'<a class="text-primary underline" href="?id='.(int)$d['id'].'">Preview</a> · <a class="text-primary underline" href="'.$url.'/download">Download</a>'];
    }
    rangeCard('Authorized datasets', rangeTable(['Code','Name','Format','Rows','Columns','Bytes','Actions'],$rows,'No datasets'));
    if (!empty($_GET['id'])) {
        try {
            $preview=$service->getPreview((int)$_GET['id'],(int)$currentUser['id'],$currentUser['role']);
            $rows=[]; foreach($preview['preview_rows'] as $row) { $r=[]; foreach($preview['columns'] as $col) { $v=$row[$col]??null;$r[]=rangeEscape(is_scalar($v)||$v===null?$v:json_encode($v)); } $rows[]=$r; }
            rangeCard('File preview — '. $preview['dataset']['name'],rangeTable($preview['columns'],$rows,'No data rows') . '<p class="font-code-sm text-code-sm break-all">SHA-256: '.rangeEscape($preview['dataset']['checksum_sha256']).'</p><p>Row and column counts come from the uploaded file. Quality evaluation: NOT EVALUATED.</p>');
        } catch(Throwable $e) {http_response_code(403);rangeCard('Dataset unavailable',rangeEscape($e->getMessage()));}
    }
}
if ($admin && in_array($rangePage,['DatasetCatalog','DatasetManagement','dashboard'],true)) {
    $scenarios=Database::query('SELECT id,code,title FROM scenarios ORDER BY id DESC');$opts=[];foreach($scenarios as $s)$opts[$s['id']]=$s['code'].' — '.$s['title'];
    rangeCard('Upload master dataset',rangeForm('upload_master',rangeInput('code','Dataset code').rangeInput('name','Name').rangeInput('description','Description','text',false).rangeInput('dataset_file','CSV / JSON file','file'), 'Upload real file',true));
    $students=Database::query("SELECT id,full_name,identifier FROM users WHERE role='STUDENT' AND status='ACTIVE'");$opts=[];foreach($students as $s)$opts[$s['id']]=$s['identifier'].' — '.$s['full_name'];
    $tickets=Database::query('SELECT id,ticket_code,title FROM tickets ORDER BY id DESC');$topt=[];foreach($tickets as $t)$topt[$t['id']]=$t['ticket_code'].' — '.$t['title'];
    rangeCard('Assign dataset to student & ticket',rangeForm('assign',rangeSelect('dataset_id','Dataset',$datasetOptions).rangeSelect('student_id','Student',$opts).rangeSelect('ticket_id','Assigned ticket',$topt),'Save assignment'));
}
if (!$admin && $rangePage === 'UploadProcessedData') {
    $tickets=Database::query('SELECT t.id,t.ticket_code FROM tickets t JOIN ticket_assignments a ON a.ticket_id=t.id WHERE a.student_id=:id',['id'=>$currentUser['id']]);$opts=[];foreach($tickets as $t)$opts[$t['id']]=$t['ticket_code'];
    rangeCard('Upload processed data',rangeForm('upload_processed',rangeSelect('source_dataset_id','Assigned master dataset',$datasetOptions).rangeSelect('ticket_id','Assigned ticket',$opts).rangeInput('name','Name').rangeInput('transformation_notes','Transformation notes').rangeInput('processed_file','CSV / JSON file','file'),'Save processed dataset',true));
}
echo '</div>';
