<?php
declare(strict_types=1);
/** Forward-only migration preservation proof on a new, never-reused testing schema. */
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
require_once __DIR__.'/../bin/lib/setup.php';
use App\Core\Env;
if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_test')||!in_array(Env::get('DB_HOST'),['localhost','127.0.0.1','::1'],true)){
 fwrite(STDERR,"REFUSED: current configuration must be loopback APP_ENV=testing and a _test database.\n");exit(1);
}
$target=$argv[1]??'vostok_range_20261030_425e_migration_test';
if(!preg_match('/^vostok_range_[0-9]{8}_[a-z0-9_]+_migration(?:_[a-z0-9]+)?_test$/D',$target)||strlen($target)>64){fwrite(STDERR,"A distinct vostok_range_YYYYMMDD_*_migration_test database name is required.\n");exit(1);}
$checkCount=0;$check=function(bool $ok,string $label)use(&$checkCount):void{if(!$ok)throw new RuntimeException('FAIL '.$label);$checkCount++;echo 'PASS '.$label.PHP_EOL;};
try{
 $server=new PDO('mysql:host='.Env::get('DB_HOST').';port='.Env::get('DB_PORT','3306').';charset=utf8mb4',(string)Env::get('DB_USER'),(string)Env::get('DB_PASS',''),[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
 $exists=$server->prepare('SELECT COUNT(*) FROM information_schema.SCHEMATA WHERE SCHEMA_NAME=:name');$exists->execute(['name'=>$target]);
 if((int)$exists->fetchColumn()!==0)throw new RuntimeException('REFUSED: target already exists. Choose another NEW test database; no records were reset.');
 $server->exec('CREATE DATABASE '.$target.' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');$server->exec('USE '.$target);
 echo 'NEW TEST DATABASE '.$target.PHP_EOL;
 foreach(['001_initial_schema.sql','002_scenario_metadata.sql','003_measurement_states.sql'] as $migration){
  $server->exec(file_get_contents(__DIR__.'/../database/migrations/'.$migration));$s=$server->prepare('INSERT INTO migrations(migration) VALUES(:name)');$s->execute(['name'=>$migration]);echo 'APPLIED '.$migration.PHP_EOL;
 }
 $insert=function(string $table,array $data)use($server):int{
  $columns=implode(',',array_keys($data));$keys=implode(',',array_map(fn($v)=>':'.$v,array_keys($data)));
  $q=$server->prepare('INSERT INTO '.$table.' ('.$columns.') VALUES ('.$keys.')');$q->execute($data);return (int)$server->lastInsertId();
 };
 $tag='MIGRATION-'.strtoupper(bin2hex(random_bytes(5)));$createdFiles=[];
 $admin=$insert('users',['role'=>'ADMIN','email'=>strtolower($tag).'-admin@example.invalid','password_hash'=>password_hash(bin2hex(random_bytes(24)),PASSWORD_DEFAULT),'full_name'=>'Migration test administrator','identifier'=>$tag.'-ADMIN','must_change_password'=>1,'status'=>'ACTIVE']);
 $student=$insert('users',['role'=>'STUDENT','email'=>strtolower($tag).'-student@example.invalid','password_hash'=>password_hash(bin2hex(random_bytes(24)),PASSWORD_DEFAULT),'full_name'=>'Migration test student','identifier'=>$tag.'-STUDENT','status'=>'ACTIVE']);
 $scenario=$insert('scenarios',['code'=>$tag,'title'=>'Preserved scenario','description'=>'Actual pre-migration test work','author_id'=>$admin,'builder_metadata'=>json_encode(['schema_version'=>1,'form_fields'=>['edit-title'=>'Preserved scenario']])]);
 $ticket=$insert('tickets',['ticket_code'=>$tag,'scenario_id'=>$scenario,'title'=>'Preserved assignment','description'=>'Original instructions','requirements'=>'Keep every record and file','acceptance_criteria'=>'Same IDs and checksums after forward migrations','status'=>'IN_PROGRESS','created_by'=>$admin]);
 $assignment=$insert('ticket_assignments',['ticket_id'=>$ticket,'student_id'=>$student,'assigned_by'=>$admin,'notes'=>'Original historical assignment']);
 $makeFile=function(string $directory,string $extension,string $bytes)use(&$createdFiles):array{
  $dir=dirname(__DIR__).'/storage/private/'.$directory;if(!is_dir($dir)&&!mkdir($dir,0700,true))throw new RuntimeException('Cannot create private test directory.');
  $name='migration_preservation_'.bin2hex(random_bytes(12)).'.'.$extension;$path=$dir.'/'.$name;$f=fopen($path,'x');if(!$f)throw new RuntimeException('Cannot create own file.');fwrite($f,$bytes);fclose($f);$createdFiles[]=$path;
  return ['file_path'=>$name,'file_size'=>strlen($bytes),'checksum_sha256'=>hash('sha256',$bytes)];
 };
 $master=$makeFile('datasets','csv',"feature,label\n10,0\n20,1\n");
 $dataset=$insert('datasets',$master+['code'=>$tag,'name'=>'Preserved master dataset','description'=>'Original metadata','format'=>'csv','row_count'=>2,'column_count'=>2,'schema_json'=>json_encode(['feature','label']),'version'=>'legacy_v1','scenario_id'=>$scenario,'uploaded_by'=>$admin]);
 $dataAssignment=$insert('dataset_assignments',['dataset_id'=>$dataset,'student_id'=>$student,'ticket_id'=>$ticket,'assigned_by'=>$admin]);
 $processedFile=$makeFile('datasets','json','[{"feature":20,"label":1}]');
 $processed=$insert('processed_datasets',$processedFile+['source_dataset_id'=>$dataset,'student_id'=>$student,'ticket_id'=>$ticket,'name'=>'Preserved processed work','format'=>'json','row_count'=>1,'transformation_notes'=>'Filtered one original row']);
 $notebook=$insert('notebooks',['code'=>$tag,'title'=>'Preserved notebook','student_id'=>$student,'ticket_id'=>$ticket,'scenario_id'=>$scenario,'status'=>'SAVED']);
 $cell=$insert('notebook_cells',['notebook_id'=>$notebook,'cell_order'=>0,'cell_type'=>'code','source'=>"values = [10, 20]\n# Original saved code; never executed\n"]);
 $experiment=$insert('experiments',['code'=>$tag,'name'=>'Preserved experiment metadata','student_id'=>$student,'ticket_id'=>$ticket,'scenario_id'=>$scenario]);
 $model=$insert('models',['model_code'=>$tag,'name'=>'Preserved model metadata','framework'=>'opaque-json','student_id'=>$student,'ticket_id'=>$ticket,'scenario_id'=>$scenario,'metadata_json'=>json_encode(['user_reported'=>true])]);
 $modelFile=$makeFile('models','json','{"model_type":"migration-test","weights":[1]}');
 $modelVersion=$insert('model_versions',['model_id'=>$model,'version'=>'legacy_v1','artifact_path'=>$modelFile['file_path'],'artifact_format'=>'json','checksum_sha256'=>$modelFile['checksum_sha256'],'file_size'=>$modelFile['file_size']]);
 $submission=$insert('submissions',['submission_code'=>$tag,'ticket_id'=>$ticket,'student_id'=>$student,'iteration'=>1,'notes'=>'Preserved submitted work','model_id'=>$model,'notebook_id'=>$notebook,'status'=>'SUBMITTED']);
 $insert('audit_logs',['actor_id'=>$admin,'action'=>'MIGRATION_TEST_CREATED','resource_type'=>'datasets','resource_id'=>(string)$dataset,'outcome'=>'SUCCESS','metadata_json'=>json_encode(['purpose'=>'Forward migration preservation test'])]);
 $tables=['users','scenarios','tickets','ticket_assignments','datasets','dataset_assignments','processed_datasets','notebooks','notebook_cells','experiments','models','model_versions','submissions','audit_logs'];$before=[];
 foreach($tables as $table)$before[$table]=$server->query('SELECT * FROM '.$table.' ORDER BY id')->fetchAll();
 $expected=count(glob(__DIR__.'/../database/migrations/*.sql'))-3;
 $applied=setupMigrate($server);$check($applied===$expected,'Exactly the '.(string)$expected.' new forward migrations were applied');
 foreach($tables as $table){
  $after=$server->query('SELECT * FROM '.$table.' ORDER BY id')->fetchAll();$check(count($after)===count($before[$table]),$table.' row count preserved');
  foreach($before[$table] as $i=>$old)foreach($old as $column=>$value)if($after[$i][$column]!==$value)throw new RuntimeException('Changed original value '.$table.'.'.$column);
 }
 $check(true,'All original columns, IDs, source code, ownership, paths and checksums unchanged');
 $v=$server->query('SELECT * FROM dataset_versions WHERE dataset_id='.$dataset)->fetchAll();$check(count($v)===1,'Existing actual dataset backfilled to exactly one immutable version');
 $check($v[0]['file_path']===$master['file_path']&&$v[0]['checksum_sha256']===$master['checksum_sha256']&&$v[0]['version']==='legacy_v1','Version backfill references original bytes and version label without copying/overwriting files');
 $vid=(int)$v[0]['id'];$d=$server->query('SELECT current_version_id FROM datasets WHERE id='.$dataset)->fetch();$a=$server->query('SELECT dataset_version_id,revoked_at FROM dataset_assignments WHERE id='.$dataAssignment)->fetch();$p=$server->query('SELECT source_dataset_version_id FROM processed_datasets WHERE id='.$processed)->fetch();
 $check((int)$d['current_version_id']===$vid,'Master current version points at actual backfilled version');
 $check((int)$a['dataset_version_id']===$vid&&$a['revoked_at']===null,'Original dataset assignment remains active and pinned');
 $check((int)$p['source_dataset_version_id']===$vid,'Processed result retains source dataset and gains its version reference');
 $check((int)$server->query('SELECT session_version FROM users WHERE id='.$student)->fetchColumn()===1,'Existing student receives session version without credential/account reset');
 foreach([$master,$processedFile] as $file)$check(is_file(dirname(__DIR__).'/storage/private/datasets/'.$file['file_path'])&&hash_file('sha256',dirname(__DIR__).'/storage/private/datasets/'.$file['file_path'])===$file['checksum_sha256'],'Referenced dataset file preserved with matching checksum');
 $check(is_file(dirname(__DIR__).'/storage/private/models/'.$modelFile['file_path'])&&hash_file('sha256',dirname(__DIR__).'/storage/private/models/'.$modelFile['file_path'])===$modelFile['checksum_sha256'],'Referenced model artifact preserved with matching checksum');
 $check(setupMigrate($server)===0,'Second migration run is a no-op with no new records');
 $check((int)$server->query('SELECT COUNT(*) FROM dataset_versions')->fetchColumn()===1,'Second migration run does not duplicate version records');
 echo $checkCount.' forward migration preservation checks passed. Test database and '.count($createdFiles).' actual referenced files retained for inspection; no existing database reset or dropped.'.PHP_EOL;
 echo 'DATABASE '.$target.PHP_EOL;foreach($createdFiles as $path)echo 'PRESERVED FILE '.$path.PHP_EOL;
}catch(Throwable $e){fwrite(STDERR,$e->getMessage().PHP_EOL);exit(1);}
