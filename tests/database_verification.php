<?php
/** Creates two NEW isolated _test schemas; verifies migrations, constraints and actual dump/restore. */
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
require_once __DIR__.'/../bin/lib/setup.php';
use App\Core\Env;
use App\Core\Database;
$source=(string)Env::get('DB_NAME','');$host=(string)Env::get('DB_HOST','');
if(Env::get('APP_ENV')!=='testing'||!preg_match('/^vostok_range_v7_[0-9]{8}_[a-z0-9_]+_test$/D',$source)||strlen($source)>54||!in_array($host,['localhost','127.0.0.1','::1'],true)){
 fwrite(STDERR,"REFUSED: a NEW vostok_range_v7_YYYYMMDD_*_test database, loopback and APP_ENV=testing are required.\n");exit(1);
}
$restore=substr($source,0,-5).'_restore_test';$count=0;
$check=function(bool $ok,string $label)use(&$count){if(!$ok)throw new RuntimeException('FAIL '.$label);$count++;echo 'PASS '.$label.PHP_EOL;};
$options=[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false];
try{
 $server=new PDO('mysql:host='.$host.';port='.Env::get('DB_PORT','3306').';charset=utf8mb4',(string)Env::get('DB_USER'),(string)Env::get('DB_PASS',''),$options);
 $exists=$server->prepare('SELECT COUNT(*) FROM information_schema.SCHEMATA WHERE SCHEMA_NAME IN (:source,:restore)');$exists->execute(['source'=>$source,'restore'=>$restore]);
 if((int)$exists->fetchColumn()!==0)throw new RuntimeException('REFUSED: source or restore schema already exists; nothing was reset. Choose a new name.');
 $server->exec('CREATE DATABASE `'.$source.'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
 $pdo=Database::getConnection();$check($pdo->query('SELECT DATABASE()')->fetchColumn()===$source,'Application PDO uses only the NEW dedicated test schema');
 $check((int)$pdo->getAttribute(PDO::ATTR_EMULATE_PREPARES)===0,'Application PDO uses native prepared statements');
 $check(setupMigrate($pdo)===7,'All seven forward migrations apply from empty schema');
 $tables=$pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);sort($tables);
 $check(count($tables)===29,'Expected 29 tables exist');
 $check(setupMigrate($pdo)===0,'Repeated migrations are a no-op');
 foreach($tables as $table)if($table!=='migrations')$check((int)$pdo->query('SELECT COUNT(*) FROM `'.$table.'`')->fetchColumn()===0,$table.' has no seeded fixtures');
 $insert=function(string $table,array $data)use($pdo):int{$q=$pdo->prepare('INSERT INTO `'.$table.'` (`'.implode('`,`',array_keys($data)).'`) VALUES ('.implode(',',array_map(fn($k)=>':'.$k,array_keys($data))).')');$q->execute($data);return(int)$pdo->lastInsertId();};
 $tag='DBPROOF-'.strtoupper(bin2hex(random_bytes(6)));$secret=bin2hex(random_bytes(24));
 $admin=$insert('users',['role'=>'ADMIN','email'=>strtolower($tag).'-admin@example.invalid','password_hash'=>password_hash($secret,PASSWORD_DEFAULT),'full_name'=>'Isolated database proof administrator','identifier'=>$tag.'-ADMIN','must_change_password'=>1]);
 $student=$insert('users',['role'=>'STUDENT','email'=>strtolower($tag).'-student@example.invalid','password_hash'=>password_hash(bin2hex(random_bytes(24)),PASSWORD_DEFAULT),'full_name'=>'Isolated database proof student','identifier'=>$tag.'-STUDENT']);
 $q=$pdo->prepare('SELECT password_hash FROM users WHERE id=:id');$q->execute(['id'=>$admin]);$stored=$q->fetchColumn();$check($stored!==$secret&&password_verify($secret,$stored),'Only password_hash values stored; actual secret never printed');unset($secret,$stored);
 $scenario=$insert('scenarios',['code'=>$tag,'title'=>'Isolated backup/restore scenario','author_id'=>$admin]);
 $ticket=$insert('tickets',['ticket_code'=>$tag,'scenario_id'=>$scenario,'title'=>'Isolated backup/restore ticket','created_by'=>$admin]);
 $assignment=$insert('ticket_assignments',['ticket_id'=>$ticket,'student_id'=>$student,'assigned_by'=>$admin]);
 $notebook=Database::transaction(function()use($insert,$tag,$student,$ticket,$scenario){return$insert('notebooks',['code'=>$tag,'title'=>'Preserved notebook source','student_id'=>$student,'ticket_id'=>$ticket,'scenario_id'=>$scenario]);});
 $sourceCode=<<<'CODE'
# Literal code must survive backup/restore
print('<script>& "quoted"</script>')
# Unicode: Я • α
CODE;
 $cell=$insert('notebook_cells',['notebook_id'=>$notebook,'cell_order'=>0,'cell_type'=>'code','source'=>$sourceCode]);
 $check($pdo->query('SELECT source FROM notebook_cells WHERE id='.$cell)->fetchColumn()===$sourceCode,'Committed literal notebook code round-trips unchanged through native PDO');
 $experiment=$insert('experiments',['code'=>$tag,'name'=>'Isolated recorded metadata','student_id'=>$student,'ticket_id'=>$ticket,'scenario_id'=>$scenario]);
 $model=$insert('models',['model_code'=>$tag,'name'=>'Metadata only; no fake artifact','framework'=>'opaque-json','student_id'=>$student,'ticket_id'=>$ticket,'scenario_id'=>$scenario]);
 $submission=$insert('submissions',['submission_code'=>$tag,'ticket_id'=>$ticket,'student_id'=>$student,'iteration'=>1,'notes'=>'Backup restore proof only','model_id'=>$model,'notebook_id'=>$notebook,'request_key'=>$tag]);
 $insert('notifications',['user_id'=>$student,'type'=>'DATABASE_TEST','title'=>'Isolated restore proof','message'=>'No real user data']);
 $insert('audit_logs',['actor_id'=>$admin,'action'=>'DATABASE_TEST_CREATED','resource_type'=>'submissions','resource_id'=>(string)$submission,'outcome'=>'SUCCESS']);
 $check((int)$pdo->query('SELECT COUNT(*) FROM model_versions')->fetchColumn()===0,'Metadata-only models create no artifact/version record');
 $before=(int)$pdo->query('SELECT COUNT(*) FROM tickets')->fetchColumn();
 try{Database::transaction(function()use($insert,$tag,$admin){$insert('tickets',['ticket_code'=>$tag.'-ROLLBACK','title'=>'Will roll back','created_by'=>$admin]);throw new RuntimeException('Deliberate rollback');});}catch(RuntimeException $e){if($e->getMessage()!=='Deliberate rollback')throw $e;}
 $check((int)$pdo->query('SELECT COUNT(*) FROM tickets')->fetchColumn()===$before,'Failed transaction rolls back inserted ticket');
 Database::transaction(function()use($pdo,$check){$before=(int)$pdo->query('SELECT COUNT(*) FROM system_settings')->fetchColumn();try{Database::transaction(function()use($pdo){$pdo->exec("INSERT INTO system_settings(setting_key,setting_value) VALUES('v7_nested_rollback','not committed')");throw new RuntimeException('Rollback savepoint');});}catch(RuntimeException $e){if($e->getMessage()!=='Rollback savepoint')throw $e;}$check((int)$pdo->query('SELECT COUNT(*) FROM system_settings')->fetchColumn()===$before,'Nested transaction rollback preserves outer transaction');});
 $check($pdo->query('SELECT @@foreign_key_checks')->fetchColumn()==1,'Foreign-key enforcement remains enabled');
 $invalid=false;try{$insert('ticket_assignments',['ticket_id'=>$ticket,'student_id'=>2147483647,'assigned_by'=>$admin]);}catch(PDOException $e){$invalid=$e->getCode()==='23000'&&(int)($e->errorInfo[1]??0)===1452;}$check($invalid,'Invalid related student foreign key is rejected');
 $duplicate=false;try{$insert('users',['role'=>'STUDENT','email'=>strtolower($tag).'-different@example.invalid','password_hash'=>password_hash(bin2hex(random_bytes(16)),PASSWORD_DEFAULT),'full_name'=>'Duplicate rejected','identifier'=>$tag.'-STUDENT']);}catch(PDOException $e){$duplicate=$e->getCode()==='23000'&&(int)($e->errorInfo[1]??0)===1062;}$check($duplicate,'Duplicate student identifier is rejected by unique constraint');
 $requestDuplicate=false;try{$insert('submissions',['submission_code'=>$tag.'-DUP','ticket_id'=>$ticket,'student_id'=>$student,'iteration'=>2,'request_key'=>$tag]);}catch(PDOException $e){$requestDuplicate=$e->getCode()==='23000'&&(int)($e->errorInfo[1]??0)===1062;}$check($requestDuplicate,'Submission request key duplicate is rejected by unique constraint');
 $pdo->exec('UPDATE tickets SET title=CONCAT(title,\' [updated]\') WHERE id='.$ticket);$check(str_ends_with((string)$pdo->query('SELECT title FROM tickets WHERE id='.$ticket)->fetchColumn(),' [updated]'),'Native UPDATE persists actual new title');
 $pdo->exec('UPDATE ticket_assignments SET revoked_at=CURRENT_TIMESTAMP WHERE id='.$assignment);$check($pdo->query('SELECT revoked_at FROM ticket_assignments WHERE id='.$assignment)->fetchColumn()!==null,'Assignment archival persists without deleting student work');
 $fingerprints=function(PDO $db)use($tables){$out=[];foreach($tables as $table){$rows=$db->query('SELECT * FROM `'.$table.'` ORDER BY 1')->fetchAll();$out[$table]=['rows'=>count($rows),'sha256'=>hash('sha256',json_encode($rows,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR))];}return$out;};
 $beforeRestore=$fingerprints($pdo);
 $artifactRoot=$argv[1]??'';
 if($artifactRoot===''||!is_dir($artifactRoot)||str_contains(strtolower(str_replace('\\','/',realpath($artifactRoot))),'/xampp/htdocs'))throw new RuntimeException('An existing protected output directory outside the web root is required.');
 $dump=rtrim($artifactRoot,'/\\').DIRECTORY_SEPARATOR.$source.'.sql';if(file_exists($dump))throw new RuntimeException('REFUSED: backup path exists.');
 $dumpProgram='C:/xampp/mysql/bin/mysqldump.exe';$restoreProgram='C:/xampp/mysql/bin/mysql.exe';
 if(!is_file($dumpProgram)||!is_file($restoreProgram))throw new RuntimeException('XAMPP database command tools are unavailable.');
 $environment=getenv();$environment['MYSQL_PWD']=(string)Env::get('DB_PASS','');
 $baseArgs=['--host='.$host,'--port='.(string)Env::get('DB_PORT','3306'),'--user='.(string)Env::get('DB_USER'),'--default-character-set=utf8mb4'];
 $errors=tmpfile();$backupOut=fopen($dump,'x');if(!$errors||!$backupOut)throw new RuntimeException('Cannot open exclusive backup output.');
 $process=proc_open(array_merge([$dumpProgram],$baseArgs,['--single-transaction','--skip-comments','--skip-dump-date','--hex-blob',$source]),[0=>['pipe','r'],1=>$backupOut,2=>$errors],$pipes,null,$environment);
 if(!is_resource($process))throw new RuntimeException('Backup process unavailable.');fclose($pipes[0]);$code=proc_close($process);fclose($backupOut);fclose($errors);$check($code===0&&filesize($dump)>1000,'Actual mysqldump succeeds; no command-line password or data printed');
 $dumpText=file_get_contents($dump);$check(!preg_match('/^\s*(?:USE\s|CREATE\s+DATABASE\s)/mi',$dumpText),'Backup contains no USE or CREATE DATABASE that could redirect restore');unset($dumpText);
 $server->exec('CREATE DATABASE `'.$restore.'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
 $errors=tmpfile();$input=fopen($dump,'r');$process=proc_open(array_merge([$restoreProgram],$baseArgs,['--database='.$restore]),[0=>$input,1=>['pipe','w'],2=>$errors],$pipes,null,$environment);
 if(!is_resource($process))throw new RuntimeException('Restore process unavailable.');stream_get_contents($pipes[1]);fclose($pipes[1]);$code=proc_close($process);fclose($input);fclose($errors);unset($environment['MYSQL_PWD']);$check($code===0,'Actual mysql CLI restores only the NEW distinct restore schema');
 $restored=new PDO('mysql:host='.$host.';port='.Env::get('DB_PORT','3306').';dbname='.$restore.';charset=utf8mb4',(string)Env::get('DB_USER'),(string)Env::get('DB_PASS',''),$options);
 $check($restored->query('SELECT DATABASE()')->fetchColumn()===$restore,'Restored connection confirms distinct target name');
 $afterRestore=$fingerprints($restored);foreach($tables as $table)$check($afterRestore[$table]===$beforeRestore[$table],$table.' exact row count and content fingerprint restored');
 $check($restored->query('SELECT @@foreign_key_checks')->fetchColumn()==1,'Restored connection has foreign-key checks enabled');
 $check($restored->query('SELECT source FROM notebook_cells WHERE id='.$cell)->fetchColumn()===$sourceCode,'Restored notebook literal source matches committed bytes');
 $proof=['source'=>$source,'restore'=>$restore,'backup_path'=>$dump,'backup_sha256'=>hash_file('sha256',$dump),'backup_bytes'=>filesize($dump),'tables'=>$beforeRestore,'checks'=>$count,'result'=>'PASS','live_database_mutated'=>false,'schemas_dropped'=>0,'fixture_scope'=>'Only these two newly created _test schemas; not HTTP acceptance evidence.'];
 file_put_contents(rtrim($artifactRoot,'/\\').DIRECTORY_SEPARATOR.$source.'.proof.json',json_encode($proof,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));
 echo 'PASS ALL '.$count.' database/migration/constraint/rollback/backup-restore assertions. Source '.$source.'; restore '.$restore.'; original database unchanged; both schemas retained.'.PHP_EOL;
}catch(Throwable $e){fwrite(STDERR,'Database verification failed ['.get_class($e).'] code='.$e->getCode().'; inspect the last successful assertion. Credentials/data/exception details withheld.'.PHP_EOL);exit(1);}
