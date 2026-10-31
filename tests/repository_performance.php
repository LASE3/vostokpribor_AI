<?php
declare(strict_types=1);
/** Dedicated, rollback-only volume probe. No live data copy, DDL, files or runtime execution. */
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\Database;
use App\Core\Env;
use App\Repositories\DatasetRepository;
use App\Repositories\ModelRepository;
use App\Repositories\SocWorkspaceRepository;
use App\Repositories\TicketRepository;
use App\Repositories\UserRepository;

if (Env::get('APP_ENV') !== 'testing'
    || !preg_match('/^vostok_range_v6_[A-Za-z0-9_]+_perf_test$/D', (string)Env::get('DB_NAME'))
    || !in_array(Env::get('DB_HOST'), ['127.0.0.1','localhost','::1'], true)) {
    fwrite(STDERR,"REFUSED: new dedicated loopback V6 performance _test DB required.\n"); exit(1);
}
final class PerformanceStatement extends PDOStatement
{
    public static bool $record = false;
    public static array $queries = [];
    protected function __construct() {}
    public function execute(?array $params = null): bool
    {
        if (self::$record) self::$queries[] = ['sql'=>$this->queryString,'params'=>$params ?? []];
        return parent::execute($params);
    }
}
$pdo = Database::getConnection();
$pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS, [PerformanceStatement::class, []]);
$tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
$counts = static function() use ($pdo,$tables): array {
    $result=[];
    foreach ($tables as $table) {
        if (!preg_match('/^[a-z_]+$/D',$table)) throw new RuntimeException('Unexpected table name.');
        $result[$table]=(int)$pdo->query('SELECT COUNT(*) FROM `'.$table.'`')->fetchColumn();
    }
    return $result;
};
$before=$counts();
if (($before['users']??0)!==1 || array_sum(array_diff_key($before,['users'=>1,'migrations'=>1]))!==0) {
    throw new RuntimeException('REFUSED: performance DB must contain only its initial admin and migrations.');
}
$insert = static function(string $table,array $values) use ($pdo): int {
    static $statements=[];
    $columns=array_keys($values); $key=$table.'|'.implode(',',$columns);
    if (!isset($statements[$key])) {
        foreach (array_merge([$table],$columns) as $name) if (!preg_match('/^[a-z_][a-z0-9_]*$/D',$name)) throw new RuntimeException('Invalid fixture identifier.');
        $statements[$key]=$pdo->prepare('INSERT INTO `'.$table.'` (`'.implode('`,`',$columns).'`) VALUES ('.implode(',',array_fill(0,count($columns),'?')).')');
    }
    $statements[$key]->execute(array_values($values)); return (int)$pdo->lastInsertId();
};
$report=['database'=>Env::get('DB_NAME'),'server_version'=>$pdo->getAttribute(PDO::ATTR_SERVER_VERSION),'native_prepares'=>!$pdo->getAttribute(PDO::ATTR_EMULATE_PREPARES),'runs'=>7,'warmups'=>2,'fixture'=>[],'measurements'=>[]];
$benchmark = static function(string $name,callable $action) use (&$report,$pdo): array {
    for($i=0;$i<2;$i++)$action();
    $times=[];$rows=[];
    for($i=0;$i<7;$i++) {
        PerformanceStatement::$queries=[];PerformanceStatement::$record=true;
        $start=hrtime(true); $rows=$action(); $times[]=(hrtime(true)-$start)/1000000;
        PerformanceStatement::$record=false;
        $queries=PerformanceStatement::$queries;
    }
    sort($times);$plans=[];
    foreach($queries as $query) {
        $statement=$pdo->prepare('EXPLAIN '.$query['sql']);$statement->execute($query['params']);
        $plans[]=['sql'=>$query['sql'],'params'=>$query['params'],'plan'=>$statement->fetchAll(PDO::FETCH_ASSOC)];
    }
    $report['measurements'][$name]=['median_ms'=>round($times[3],3),'min_ms'=>round($times[0],3),'max_ms'=>round($times[6],3),'rows'=>count($rows),'json_bytes'=>strlen(json_encode($rows,JSON_THROW_ON_ERROR)),'query_count'=>count($queries),'explain'=>$plans];
    echo $name.': '.json_encode(array_diff_key($report['measurements'][$name],['explain'=>1]),JSON_THROW_ON_ERROR).PHP_EOL;
    return $rows;
};
try {
    $pdo->beginTransaction();$tag='V6PERF-'.bin2hex(random_bytes(5));$admin=(int)$pdo->query("SELECT id FROM users WHERE role='ADMIN'")->fetchColumn();
    // Random inaccessible hash; no reusable test password and no fixture login.
    $hash=password_hash(bin2hex(random_bytes(32)),PASSWORD_DEFAULT);$students=[];$datasets=[];$tickets=[];$notebooks=[];$models=[];
    $csv="feature,label\n1,0\n2,1\n";$sha=hash('sha256',$csv);
    $json=json_encode(['source'=>'synthetic performance fixture, not trusted quality evidence','parameters'=>array_fill(0,100,str_repeat('metadata',8))],JSON_THROW_ON_ERROR);
    $long=str_repeat("# synthetic persisted code for volume test; never executed\n",1000);
    $started=hrtime(true);
    for($i=0;$i<300;$i++) {
        $students[]=$insert('users',['role'=>'STUDENT','email'=>$tag.'-'.$i.'@example.invalid','identifier'=>$tag.'-'.$i,'password_hash'=>$hash,'full_name'=>'Performance fixture '.$i,'status'=>'ACTIVE']);
        $did=$insert('datasets',['code'=>$tag.'-D'.$i,'name'=>'Synthetic metadata '.$i,'format'=>'csv','file_path'=>'UNAVAILABLE-PERFORMANCE-FIXTURE.csv','checksum_sha256'=>$sha,'file_size'=>strlen($csv),'row_count'=>2,'column_count'=>2,'schema_json'=>'["feature","label"]','uploaded_by'=>$admin]);
        $vid=$insert('dataset_versions',['dataset_id'=>$did,'version'=>'v1','format'=>'csv','file_path'=>'UNAVAILABLE-PERFORMANCE-FIXTURE.csv','checksum_sha256'=>$sha,'file_size'=>strlen($csv),'row_count'=>2,'column_count'=>2,'schema_json'=>'["feature","label"]','uploaded_by'=>$admin]);
        $pdo->prepare('UPDATE datasets SET current_version_id=? WHERE id=?')->execute([$vid,$did]);$datasets[]=[$did,$vid];
    }
    for($i=0;$i<3000;$i++) {
        $student=$students[$i%300];[$did,$vid]=$datasets[$i%300];
        $ticket=$insert('tickets',['ticket_code'=>$tag.'-T'.$i,'title'=>'Performance ticket '.$i,'status'=>'ASSIGNED','created_by'=>$admin]);$tickets[]=$ticket;
        $insert('ticket_assignments',['ticket_id'=>$ticket,'student_id'=>$student,'assigned_by'=>$admin]);
        $insert('dataset_assignments',['dataset_id'=>$did,'dataset_version_id'=>$vid,'ticket_id'=>$ticket,'student_id'=>$student,'assigned_by'=>$admin]);
        $notebook=$insert('notebooks',['code'=>$tag.'-N'.$i,'title'=>'Saved notebook '.$i,'student_id'=>$student,'ticket_id'=>$ticket,'status'=>'SAVED']);$notebooks[]=$notebook;
        for($cell=0;$cell<3;$cell++)$insert('notebook_cells',['notebook_id'=>$notebook,'cell_order'=>$cell,'cell_type'=>'code','source'=>'# saved test code '.$i.' '.$cell]);
        $experiment=$insert('experiments',['code'=>$tag.'-E'.$i,'name'=>'Recorded experiment '.$i,'student_id'=>$student,'ticket_id'=>$ticket]);
        $run=$insert('experiment_runs',['run_uuid'=>$tag.'-R'.$i,'experiment_id'=>$experiment,'student_id'=>$student,'notebook_id'=>$notebook,'run_name'=>'Recorded run '.$i,'status'=>'RECORDED','parameters'=>$json,'metrics'=>null,'artifacts'=>null]);
        $model=$insert('models',['model_code'=>$tag.'-M'.$i,'name'=>'Model metadata '.$i,'framework'=>'metadata-only','student_id'=>$student,'ticket_id'=>$ticket,'experiment_run_id'=>$run,'metadata_json'=>$json,'status'=>'REGISTERED']);$models[]=$model;
        $insert('submissions',['submission_code'=>$tag.'-S'.$i,'ticket_id'=>$ticket,'student_id'=>$student,'notebook_id'=>$notebook,'model_id'=>$model,'status'=>'SUBMITTED']);
        if($i<200) {
            $insert('execution_jobs',['job_uuid'=>$tag.'-J'.$i,'student_id'=>$student,'notebook_id'=>$notebook,'status'=>'CANCELLED','code_to_execute'=>$long,'stdout'=>$long,'stderr'=>null]);
            $version=$insert('model_versions',['model_id'=>$model,'version'=>'metadata-fixture','artifact_path'=>'UNAVAILABLE-PERFORMANCE-FIXTURE.json','artifact_format'=>'json','checksum_sha256'=>$sha,'file_size'=>0]);
            $insert('validation_runs',['model_id'=>$model,'model_version_id'=>$version,'requested_by'=>$student,'status'=>'NOT_EVALUATED','report_json'=>$json]);
            $insert('deployment_requests',['model_id'=>$model,'model_version_id'=>$version,'requested_by'=>$student,'status'=>'PENDING','provider_state'=>'NOT_CONFIGURED']);
        }
    }
    $report['fixture']=['students'=>300,'tickets'=>3000,'ticket_assignments'=>3000,'datasets'=>300,'dataset_versions'=>300,'dataset_assignments'=>3000,'notebooks'=>3000,'cells'=>9000,'experiments'=>3000,'runs'=>3000,'models'=>3000,'submissions'=>3000,'jobs'=>200,'model_version_metadata'=>200,'not_evaluated_validations'=>200,'pending_requests'=>200,'generation_seconds'=>round((hrtime(true)-$started)/1e9,3),'artifact_files'=>0,'artifact_availability'=>'UNAVAILABLE; metadata-only invalid paths are intentional test fixtures, never claimed valid'];
    echo 'FIXTURE '.json_encode($report['fixture'],JSON_THROW_ON_ERROR).PHP_EOL;
    $workspace=new SocWorkspaceRepository();$modelRepo=new ModelRepository();$dataRepo=new DatasetRepository();$ticketRepo=new TicketRepository();
    foreach(['notebooks','experiments','runs','jobs','models','validations','requests'] as $resource)$benchmark('soc_'.$resource.'_100',fn()=>$workspace->list($resource,['limit'=>100]));
    // Original 0b8cd08 queries measured on the SAME fixture/connection/statistics as the final code.
    $benchmark('baseline_soc_jobs_original',fn()=>Database::query('SELECT j.*,u.full_name AS student_name,u.identifier AS student_identifier,n.title AS notebook_title,n.ticket_id,t.ticket_code FROM execution_jobs j JOIN users u ON u.id=j.student_id JOIN notebooks n ON n.id=j.notebook_id LEFT JOIN tickets t ON t.id=n.ticket_id WHERE 1=1 ORDER BY j.id DESC LIMIT 100 OFFSET 0'));
    $benchmark('baseline_soc_models_original',fn()=>Database::query('SELECT m.*,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code,(SELECT COUNT(*) FROM model_versions mv WHERE mv.model_id=m.id) AS versions_count FROM models m JOIN users u ON u.id=m.student_id LEFT JOIN tickets t ON t.id=m.ticket_id WHERE 1=1 ORDER BY m.id DESC LIMIT 100 OFFSET 0'));
    $benchmark('baseline_soc_experiments_original',fn()=>Database::query('SELECT e.*,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code,(SELECT COUNT(*) FROM experiment_runs er WHERE er.experiment_id=e.id) AS runs_count FROM experiments e JOIN users u ON u.id=e.student_id LEFT JOIN tickets t ON t.id=e.ticket_id WHERE 1=1 ORDER BY e.id DESC LIMIT 100 OFFSET 0'));
    $benchmark('baseline_soc_runs_original',fn()=>Database::query('SELECT er.*,e.code AS experiment_code,e.name AS experiment_name,e.ticket_id,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code FROM experiment_runs er JOIN experiments e ON e.id=er.experiment_id JOIN users u ON u.id=er.student_id LEFT JOIN tickets t ON t.id=e.ticket_id WHERE 1=1 ORDER BY er.id DESC LIMIT 100 OFFSET 0'));
    $benchmark('soc_models_200_filtered',fn()=>$workspace->list('models',['student_id'=>$students[0],'limit'=>200]));
    $benchmark('models_admin_all',fn()=>$modelRepo->listForUser($admin,'ADMIN'));
    $benchmark('models_student',fn()=>$modelRepo->listForUser($students[0],'STUDENT'));
    $benchmark('datasets_admin_all',fn()=>$dataRepo->listForUser($admin,'ADMIN'));
    $benchmark('datasets_student',fn()=>$dataRepo->listForUser($students[0],'STUDENT'));
    $benchmark('tickets_admin_all',fn()=>$ticketRepo->listForUser($admin,'ADMIN'));
    $benchmark('tickets_student',fn()=>$ticketRepo->listForUser($students[0],'STUDENT'));
    // Candidate projection only: no source edit and no default pagination changes.
    $benchmark('candidate_soc_jobs_summary',fn()=>Database::query('SELECT j.id,j.job_uuid,j.notebook_id,j.cell_id,j.student_id,j.status,j.exit_code,j.execution_time_ms,j.memory_peak_mb,j.started_at,j.completed_at,j.created_at,u.full_name AS student_name,u.identifier AS student_identifier,n.title AS notebook_title,n.ticket_id,t.ticket_code FROM execution_jobs j JOIN users u ON u.id=j.student_id JOIN notebooks n ON n.id=j.notebook_id LEFT JOIN tickets t ON t.id=n.ticket_id ORDER BY j.id DESC LIMIT 100'));
    $benchmark('candidate_soc_models_summary',fn()=>Database::query('SELECT m.id,m.model_code,m.name,m.framework,m.student_id,m.ticket_id,m.scenario_id,m.experiment_run_id,m.current_version,m.status,m.created_at,m.updated_at,m.admin_updated_by,m.admin_updated_at,u.full_name AS student_name,u.identifier AS student_identifier,t.ticket_code,(SELECT COUNT(*) FROM model_versions mv WHERE mv.model_id=m.id) AS versions_count FROM models m JOIN users u ON u.id=m.student_id LEFT JOIN tickets t ON t.id=m.ticket_id ORDER BY m.id DESC LIMIT 100'));
    $checks=0;$check=static function(bool $ok,string $label)use(&$checks):void{if(!$ok)throw new RuntimeException('FAIL '.$label);$checks++;echo 'PASS '.$label.PHP_EOL;};
    foreach(['notebooks','experiments','runs','jobs','models','validations','requests'] as $resource) {
        $rows=$workspace->list($resource,['limit'=>7,'offset'=>3]);
        $all=$workspace->list($resource,['limit'=>20]);
        $check(array_column($rows,'id')===array_slice(array_column($all,'id'),3,7),$resource.' stable limit/offset descending page');
        $filtered=$workspace->list($resource,['student_id'=>$students[0],'ticket_id'=>$tickets[0],'limit'=>1]);
        $check(count($filtered)===1&&(int)$filtered[0]['student_id']===$students[0]&&(int)$filtered[0]['ticket_id']===$tickets[0],$resource.' owner and linked ticket filters applied before limit');
        $check($workspace->list($resource,['student_id'=>$students[1],'ticket_id'=>$tickets[0]])===[],$resource.' foreign owner filter cannot leak ticket work');
    }
    $check(count($workspace->list('models',['limit'=>9999]))===200,'SOC maximum list bound stays 200');
    $check((int)$workspace->list('notebooks',['ticket_id'=>$tickets[0]])[0]['cells_count']===3,'Notebook cell count survives bounded join');
    $check((int)$workspace->list('experiments',['ticket_id'=>$tickets[0]])[0]['runs_count']===1,'Experiment run count survives bounded join');
    $check(count($workspace->list('runs',['status'=>'RECORDED','student_id'=>$students[0]]))===10&&$workspace->list('runs',['status'=>'FAILED'])===[],'Run status filter preserves recorded state');
    $check($workspace->list('runs',['ticket_id'=>$tickets[0]])[0]['parameters']===$json,'Recorded run inline parameters preserved for existing UI');
    $jobSummary=$workspace->list('jobs',['ticket_id'=>$tickets[0]])[0];
    $check(!array_key_exists('code_to_execute',$jobSummary)&&!array_key_exists('stdout',$jobSummary),'Job list omits full code and logs');
    $jobDetail=(new App\Repositories\ExecutionRepository())->findByUuid($jobSummary['job_uuid']);
    $check($jobDetail['code_to_execute']===$long&&$jobDetail['stdout']===$long,'Job detail retains identical full code and logs');
    $modelSummary=$workspace->list('models',['ticket_id'=>$tickets[0]])[0];
    $check(!array_key_exists('metadata_json',$modelSummary),'SOC model list omits original full metadata');
    $check($modelRepo->findById($models[0])['metadata_json']===$json,'Model detail retains identical original metadata');
    $check(count($modelRepo->listForUser($students[0],'STUDENT'))===10,'Student registry remains complete without hidden pagination');
    $check((int)$dataRepo->listForUser($students[0],'STUDENT')[0]['dataset_version_id']===$datasets[0][1],'Student dataset remains pinned to active granted version');
    $report['regression_checks']=$checks;
    $report['peak_memory_bytes']=memory_get_peak_usage(true);
    $pdo->rollBack();$after=$counts();$report['rollback_counts_match']=$before===$after;
    if(!$report['rollback_counts_match'])throw new RuntimeException('Fixture rollback count mismatch.');
    $report['counts_after']=$after;
    $out=(string)($argv[1]??(__DIR__.'/../verification/v6-20261031/data-performance-baseline.json'));
    if(!is_dir(dirname($out)))mkdir(dirname($out),0700,true);
    file_put_contents($out,json_encode($report,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));
    echo 'PASS all fixture rows rolled back; every table count unchanged; evidence '.$out.PHP_EOL;
} catch(Throwable $e) {
    PerformanceStatement::$record=false;
    if($pdo->inTransaction())$pdo->rollBack();
    fwrite(STDERR,$e->getMessage().PHP_EOL);exit(1);
}
