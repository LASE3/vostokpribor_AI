<?php
/** Actual encrypted SQL/private-file/config round trip; NEW isolated schemas only, retained afterwards. */
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require __DIR__.'/../app/bootstrap.php';
require __DIR__.'/../bin/lib/setup.php';
require __DIR__.'/../bin/lib/recovery.php';
use App\Core\{Env,Database};
$name=(string)Env::get('DB_NAME','');$host=(string)Env::get('DB_HOST','');
if(Env::get('APP_ENV')!=='testing'||!preg_match('/^vostok_v9_[a-z0-9_]+_recovery_test$/D',$name)||strlen($name)>49||!in_array($host,['localhost','127.0.0.1','::1'],true)){
    fwrite(STDERR,"REFUSED: APP_ENV=testing, loopback and a NEW vostok_v9_*_recovery_test schema are required.\n");exit(1);
}
$count=0;$check=function(bool $ok,string $label)use(&$count){if(!$ok)throw new RuntimeException('FAIL '.$label);$count++;echo 'PASS '.$label.PHP_EOL;};
$refused=function(callable $operation,string $label)use($check){$failed=false;try{$operation();}catch(Throwable){$failed=true;}$check($failed,$label);};
try {
    $destination=$argv[1]??'';if(!is_dir($destination))throw new RuntimeException('An existing private artifact directory outside the web root is required.');
    recoveryExternalParent(rtrim($destination,'/\\').'/new-output.zip',dirname(__DIR__));
    $work=recoveryWorkDirectory(recoveryPath($destination));$sourceRoot=$work.'/source';$targetRoot=$work.'/restored';$restore=substr($name,0,-5).'_restored_test';
    foreach([$sourceRoot,$targetRoot] as $root){mkdir($root.'/app',0700,true);file_put_contents($root.'/app/bootstrap.php',"<?php // Recovery test tree; not served.\n");mkdir($root.'/database/migrations',0700,true);foreach(glob(dirname(__DIR__).'/database/migrations/*.sql') as $migration)copy($migration,$root.'/database/migrations/'.basename($migration));foreach(['datasets','models','sandboxes'] as $dir){mkdir($root.'/storage/private/'.$dir,0700,true);file_put_contents($root.'/storage/private/'.$dir.'/.gitkeep','');}file_put_contents($root.'/storage/private/.htaccess',"Require all denied\n");}
    $options=[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false];
    $server=new PDO('mysql:host='.$host.';port='.Env::get('DB_PORT','3306').';charset=utf8mb4',(string)Env::get('DB_USER'),(string)Env::get('DB_PASS',''),$options);
    $exists=$server->prepare('SELECT COUNT(*) FROM information_schema.SCHEMATA WHERE SCHEMA_NAME IN (:source,:restored)');$exists->execute(['source'=>$name,'restored'=>$restore]);
    if((int)$exists->fetchColumn()!==0)throw new RuntimeException('Both test schemas must be absent. No reset is permitted.');
    $server->exec('CREATE DATABASE `'.recoveryIdentifier($name).'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');$pdo=Database::getConnection();
    $check($pdo->query('SELECT DATABASE()')->fetchColumn()===$name,'Fixture PDO selects only new isolated source schema');
    $check(setupMigrate($pdo)===count(glob(dirname(__DIR__).'/database/migrations/*.sql')),'Forward migrations initialize source without seeded records');
    foreach($pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN) as $table)if($table!=='migrations')$check((int)$pdo->query('SELECT COUNT(*) FROM `'.$table.'`')->fetchColumn()===0,$table.' initially empty');
    $insert=function(string $table,array $data)use($pdo):int{$q=$pdo->prepare('INSERT INTO `'.$table.'` (`'.implode('`,`',array_keys($data)).'`) VALUES ('.implode(',',array_map(fn($key)=>':'.$key,array_keys($data))).')');$q->execute($data);return(int)$pdo->lastInsertId();};
    $tag=bin2hex(random_bytes(5));$admin=$insert('users',['role'=>'ADMIN','email'=>$tag.'-admin@example.invalid','password_hash'=>password_hash(bin2hex(random_bytes(32)),PASSWORD_DEFAULT),'full_name'=>'Isolated recovery administrator','identifier'=>'RECOVERY-'.$tag]);
    $student=$insert('users',['role'=>'STUDENT','email'=>$tag.'-student@example.invalid','password_hash'=>password_hash(bin2hex(random_bytes(32)),PASSWORD_DEFAULT),'full_name'=>'Isolated recovery student','identifier'=>'STUDENT-'.$tag]);
    $ticket=$insert('tickets',['ticket_code'=>'REC-'.$tag,'title'=>'Recovery fixture ticket','created_by'=>$admin]);
    $insert('ticket_assignments',['ticket_id'=>$ticket,'student_id'=>$student,'assigned_by'=>$admin]);
    $code="# Literal Unicode: Я α\nprint(\"not executed; quotes ' and SQL USE other;\")\n";
    $notebook=$insert('notebooks',['code'=>'REC-'.$tag,'title'=>'Persisted source recovery fixture','student_id'=>$student,'ticket_id'=>$ticket]);
    $insert('notebook_cells',['notebook_id'=>$notebook,'cell_order'=>0,'cell_type'=>'code','source'=>$code]);
    $csv="sensor,value\nalpha,12\nbeta,19\n";$processed="sensor,value\nalpha,0.12\nbeta,0.19\n";$model="{\"artifact\":\"recovery-fixture\",\"quality_evidence\":null}\n";
    foreach(['datasets/master.csv'=>$csv,'datasets/processed.csv'=>$processed,'models/artifact.json'=>$model,'sandboxes/retained-source.txt'=>$code] as $path=>$bytes)file_put_contents($sourceRoot.'/storage/private/'.$path,$bytes);
    $dataset=$insert('datasets',['code'=>'REC-'.$tag,'name'=>'Actual CSV recovery fixture','format'=>'csv','file_path'=>'master.csv','file_size'=>strlen($csv),'checksum_sha256'=>hash('sha256',$csv),'row_count'=>2,'column_count'=>2,'uploaded_by'=>$admin]);
    $version=$insert('dataset_versions',['dataset_id'=>$dataset,'version'=>'v1.0','format'=>'csv','file_path'=>'master.csv','file_size'=>strlen($csv),'checksum_sha256'=>hash('sha256',$csv),'row_count'=>2,'column_count'=>2,'uploaded_by'=>$admin]);
    $pdo->exec('UPDATE datasets SET current_version_id='.$version.' WHERE id='.$dataset);
    $insert('dataset_assignments',['dataset_id'=>$dataset,'dataset_version_id'=>$version,'student_id'=>$student,'ticket_id'=>$ticket,'assigned_by'=>$admin]);
    $insert('processed_datasets',['source_dataset_id'=>$dataset,'source_dataset_version_id'=>$version,'student_id'=>$student,'ticket_id'=>$ticket,'name'=>'Actual transformed CSV','format'=>'csv','file_path'=>'processed.csv','file_size'=>strlen($processed),'checksum_sha256'=>hash('sha256',$processed),'row_count'=>2,'column_count'=>2]);
    $modelId=$insert('models',['model_code'=>'REC-'.$tag,'name'=>'Unvalidated uploaded artifact','framework'=>'json','student_id'=>$student,'ticket_id'=>$ticket]);
    $insert('model_versions',['model_id'=>$modelId,'version'=>'v1','artifact_path'=>'artifact.json','artifact_format'=>'json','checksum_sha256'=>hash('sha256',$model),'file_size'=>strlen($model)]);
    $insert('audit_logs',['actor_id'=>$admin,'action'=>'RECOVERY_TEST_CREATED','resource_type'=>'datasets','resource_id'=>(string)$dataset,'outcome'=>'SUCCESS']);
    $config=['APP_ENV'=>'testing','APP_URL'=>'http://127.0.0.1/recovery_fixture','DB_HOST'=>$host,'DB_PORT'=>(string)Env::get('DB_PORT','3306'),'DB_NAME'=>$name,'DB_USER'=>(string)Env::get('DB_USER'),'DB_PASS'=>(string)Env::get('DB_PASS',''),'PRIVATE_PROOF_SECRET'=>bin2hex(random_bytes(24))];
    $originalEnv="APP_ENV=testing\nDB_NAME=".$name."\nPRIVATE_PROOF_SECRET=".$config['PRIVATE_PROOF_SECRET']."\n";file_put_contents($sourceRoot.'/.env',$originalEnv);
    $before=recoveryDatabaseState($pdo);$filesBefore=recoveryFileInventory($sourceRoot);$pass=bin2hex(random_bytes(32));$archive=$work.'/combined.zip';
    $proof=recoveryBackup($pdo,$sourceRoot,$archive,$pass,$config);$check($proof['encrypted']&&$proof['configuration_encrypted'],'Actual mysqldump plus real private files and original config encrypted in one archive');
    $zip=new ZipArchive();$check($zip->open($archive)===true,'Produced archive opens');$check(@$zip->getFromName('manifest.json')===false,'Manifest and database credentials cannot be read without password');$zip->setPassword(str_repeat('wrong-password-',3));$check(@$zip->getFromName('configuration/source.env')===false,'Wrong password cannot read original configuration');$zip->setPassword($pass);$check($zip->getFromName('configuration/source.env')===$originalEnv,'Encrypted original configuration round-trips exact bytes');
    $manifest=json_decode($zip->getFromName('manifest.json'),true,64,JSON_THROW_ON_ERROR);$check($manifest['configuration']['effective']['PRIVATE_PROOF_SECRET']===$config['PRIVATE_PROOF_SECRET'],'Effective environment-only secrets preserved encrypted');
    for($i=0;$i<$zip->numFiles;$i++)$check($zip->statIndex($i)['encryption_method']===ZipArchive::EM_AES_256,'Entry '.$i.' uses AES-256 encryption');$zip->close();
    $refused(fn()=>recoveryBackup($pdo,$sourceRoot,$archive,$pass,$config),'Backup cannot overwrite an existing archive');
    $refused(fn()=>recoveryExternalParent($sourceRoot.'/illegal.zip',$sourceRoot),'Backup refuses output inside source tree');
    foreach(['../escape','storage/private/datasets/../../escape','storage/private/models/C:escape','storage/private/datasets/CON.txt','storage/private/datasets/trailing.','storage/private/datasets/a\\b'] as $bad)$refused(fn()=>recoveryEntryName($bad),'Unsafe archive path refused');
    foreach(['USE `other`;','CREATE DATABASE `other`;','DROP DATABASE `other`;','GRANT ALL ON *.* TO x;','CREATE TABLE `x`(id int) DATA DIRECTORY=\'/tmp\';','INSERT INTO `users` SELECT * FROM `other`.`users`;','SET GLOBAL general_log=1;'] as $bad)$refused(fn()=>recoverySqlSafety($bad,$name,array_keys($before['tables'])),'Unsafe recovery SQL refused');
    $runtimeUser='vr9_'.$tag;$runtimePassword=bin2hex(random_bytes(32));
    file_put_contents($work.'/private-test-access.json',json_encode(['backup_password'=>$pass,'runtime_user'=>$runtimeUser,'runtime_password'=>$runtimePassword],JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR));chmod($work.'/private-test-access.json',0600);
    $q=$server->prepare('SELECT COUNT(*) FROM mysql.user WHERE User=:user');$q->execute(['user'=>$runtimeUser]);if((int)$q->fetchColumn())throw new RuntimeException('Runtime account already exists; never replacing it.');
    $server->exec('CREATE USER '.$server->quote($runtimeUser)."@'localhost' IDENTIFIED BY ".$server->quote($runtimePassword));$server->exec('GRANT SELECT, INSERT, UPDATE, DELETE ON `'.str_replace('_','\\_',$restore).'`.* TO '.$server->quote($runtimeUser)."@'localhost'");
    $runtime=['runtime_user'=>$runtimeUser,'runtime_password'=>$runtimePassword,'app_url'=>'http://127.0.0.1/recovery_'.$tag,'session_cookie'=>'recovery_'.$tag.'_test'];
    $refused(fn()=>recoveryRestore($pdo,$archive,$targetRoot,$restore,str_repeat('wrong-password-',3),$runtime,$config),'Wrong password restore refused before DB creation');
    $q=$server->prepare('SELECT COUNT(*) FROM information_schema.SCHEMATA WHERE SCHEMA_NAME=:name');$q->execute(['name'=>$restore]);$check((int)$q->fetchColumn()===0,'Failed preflight did not create target schema');
    $tampered=$work.'/unsafe.zip';copy($archive,$tampered);$z=new ZipArchive();$z->open($tampered);$z->setPassword($pass);$z->addFromString('../escape','refuse');$z->setEncryptionName('../escape',ZipArchive::EM_AES_256,$pass);$z->close();
    $refused(fn()=>recoveryRestore($pdo,$tampered,$targetRoot,$restore,$pass,$runtime,$config),'Encrypted archive with traversal entry refused before import');
    $restoreProof=recoveryRestore($pdo,$archive,$targetRoot,$restore,$pass,$runtime,$config);$check($restoreProof['database_and_file_fingerprints_match'],'Actual mysql client restores every table and uploaded file to separate target');
    $restored=new PDO('mysql:host='.$host.';port='.$config['DB_PORT'].';dbname='.$restore.';charset=utf8mb4',$runtimeUser,$runtimePassword,$options);
    $after=recoveryDatabaseState($restored);$expected=$before;$expected['database']=$restore;$check($after===$expected,'All restored DDL, row counts, ordered content hashes and migration names match');
    $check(recoveryFileInventory($targetRoot)===$filesBefore,'Every restored private file has exact original bytes and SHA-256');
    $check($restored->query('SELECT source FROM notebook_cells LIMIT 1')->fetchColumn()===$code,'Literal Unicode notebook code survives combined backup and restore');
    $check($restored->query('SELECT @@foreign_key_checks')->fetchColumn()==1,'Restored runtime foreign key enforcement enabled');
    $check((int)$restored->query('SELECT COUNT(*) FROM validation_runs')->fetchColumn()===0,'Restore invents no validation quality evidence');
    $check(str_contains(file_get_contents($targetRoot.'/.env'),'DB_USER="'.$runtimeUser.'"')&&!str_contains(file_get_contents($targetRoot.'/.env'),$config['PRIVATE_PROOF_SECRET']),'Active restored config uses separate runtime credentials, preserving original config only encrypted');
    $restored->beginTransaction();$restored->exec("INSERT INTO system_settings(setting_key,setting_value) VALUES('recovery_dml_proof','inserted')");$restored->exec("UPDATE system_settings SET setting_value='updated' WHERE setting_key='recovery_dml_proof'");$check($restored->query("SELECT setting_value FROM system_settings WHERE setting_key='recovery_dml_proof'")->fetchColumn()==='updated','Runtime SELECT INSERT UPDATE work on own restored schema');$restored->exec("DELETE FROM system_settings WHERE setting_key='recovery_dml_proof'");$restored->rollBack();
    $refused(fn()=>$restored->exec('CREATE TABLE forbidden_ddl(id INT)'),'Runtime DDL denied by actual MySQL grants');
    $refused(fn()=>$restored->query('SELECT * FROM `'.$name.'`.users'),'Runtime access to source database denied by actual MySQL grants');
    $refused(fn()=>recoveryRestore($pdo,$archive,$targetRoot,$restore,$pass,$runtime,$config),'Restore cannot overwrite an activated target or existing schema');
    $check(recoveryDatabaseState($pdo)===$before&&recoveryFileInventory($sourceRoot)===$filesBefore&&file_get_contents($sourceRoot.'/.env')===$originalEnv,'Original source DB, uploads and configuration unchanged after all tests');
    file_put_contents($work.'/private-test-access.json',json_encode(['backup_password'=>$pass]+$runtime,JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR));chmod($work.'/private-test-access.json',0600);
    $report=['result'=>'PASS','checks'=>$count,'source'=>$name,'restored'=>$restore,'archive_sha256'=>hash_file('sha256',$archive),'private_files'=>count($filesBefore),'tables'=>count($before['tables']),'schemas_dropped'=>0,'main_database_modified'=>false,'artifacts'=>$work,'scope'=>'Only these newly created isolated _test schemas. Main restore HTTP proof is separate.'];
    file_put_contents($destination.'/'.$name.'.proof.json',json_encode($report,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));echo 'PASS ALL '.$count.' recovery assertions; source and restored schemas/artifacts retained.'.PHP_EOL;
}catch(Throwable $error){fwrite(STDERR,'Recovery verification failed ['.get_class($error).'] after '.$count.' assertions; SQLSTATE='.(string)$error->getCode().'; driver='.(string)($error instanceof PDOException?($error->errorInfo[1]??''):'').'; private targets retained, credentials and SQL withheld.'.PHP_EOL);exit(1);}
