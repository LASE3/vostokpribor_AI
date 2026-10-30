<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\AccessDeniedException;
use App\Core\Database;
use App\Core\Env;
use App\Repositories\DatasetRepository;
use App\Services\DatasetService;
if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_test')||!in_array(Env::get('DB_HOST'),['localhost','127.0.0.1','::1'],true)){fwrite(STDERR,"REFUSED: loopback testing _test database required.\n");exit(1);}
$checks=[];$check=function(bool $ok,string $label)use(&$checks):void{if(!$ok)throw new RuntimeException('FAIL '.$label);$checks[]=$label;};
$reject=function(callable $action,string $label)use($check):void{try{$action();}catch(AccessDeniedException|InvalidArgumentException $e){$check(true,$label);return;}throw new RuntimeException('FAIL '.$label);};
$pdo=Database::getConnection();$db=Database::getInstance();$repo=new DatasetRepository();$service=new DatasetService();$tag='DATALIFE-'.strtoupper(bin2hex(random_bytes(5)));$files=[];
$dir=dirname(__DIR__).'/storage/private/datasets';if(!is_dir($dir))mkdir($dir,0700,true);
try{
 $admin=(int)(Database::queryOne("SELECT id FROM users WHERE role='ADMIN' AND status='ACTIVE' ORDER BY id LIMIT 1")['id']??0);if(!$admin)throw new RuntimeException('Test administrator required.');
 $pdo->beginTransaction();
 $students=[];for($i=0;$i<2;$i++)$students[]=$db->insert('users',['role'=>'STUDENT','identifier'=>$tag.'-'.$i,'email'=>strtolower($tag).'-'.$i.'@example.invalid','full_name'=>'Dataset transaction test','password_hash'=>password_hash(bin2hex(random_bytes(24)),PASSWORD_DEFAULT),'status'=>'ACTIVE']);
 [$student,$other]=$students;
 $ticket=$db->insert('tickets',['ticket_code'=>$tag,'title'=>'Dataset lifecycle test ticket','status'=>'ASSIGNED','created_by'=>$admin]);
 $db->insert('ticket_assignments',['ticket_id'=>$ticket,'student_id'=>$student,'assigned_by'=>$admin]);
 $artifacts=[];foreach(["feature,label\n1,0\n2,1\n","feature,label\n1,0\n2,1\n3,1\n"] as $i=>$bytes){$filename='test_data_lifecycle_'.bin2hex(random_bytes(12)).'.csv';$path=$dir.'/'.$filename;$handle=fopen($path,'x');if(!$handle)throw new RuntimeException('Cannot create own test file.');fwrite($handle,$bytes);fclose($handle);$files[]=$path;$artifacts[]=['format'=>'csv','file_path'=>$filename,'file_size'=>strlen($bytes),'checksum_sha256'=>hash('sha256',$bytes),'row_count'=>$i+2,'column_count'=>2,'schema_json'=>['feature','label']];}
 $dataset=$repo->create($artifacts[0]+['code'=>$tag,'name'=>'Lifecycle measurements','description'=>'Actual test CSV','is_master'=>1,'version'=>'v1','uploaded_by'=>$admin]);
 $v1=$repo->createVersion($dataset,$artifacts[0],'v1',$admin);$repo->setCurrentVersion($dataset,$v1,$artifacts[0],'v1');
 $service->assignDataset($dataset,$student,$admin,$ticket);
 $auditBefore=(int)Database::queryOne("SELECT COUNT(*) AS n FROM audit_logs WHERE resource_type='datasets' AND resource_id=:id",['id'=>(string)$dataset])['n'];
 $notificationsBefore=(int)Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id=:uid',['uid'=>$student])['n'];
 $service->assignDataset($dataset,$student,$admin,$ticket);
 $check((int)Database::queryOne('SELECT COUNT(*) AS n FROM dataset_assignments WHERE dataset_id=:id',['id'=>$dataset])['n']===1,'Assignment retry creates no duplicate assignment');
 $check((int)Database::queryOne("SELECT COUNT(*) AS n FROM audit_logs WHERE resource_type='datasets' AND resource_id=:id",['id'=>(string)$dataset])['n']===$auditBefore,'Assignment retry creates no duplicate audit event');
 $check((int)Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id=:uid',['uid'=>$student])['n']===$notificationsBefore,'Assignment retry creates no duplicate notification');
 try{Database::transaction(function()use($service,$dataset,$student,$admin,$ticket){$service->revokeDataset($dataset,$student,$admin,$ticket);throw new RuntimeException('EXPECTED_ROLLBACK');});}catch(RuntimeException $e){if($e->getMessage()!=='EXPECTED_ROLLBACK')throw $e;}
 $check($repo->authorizedVersion($dataset,$student)!==null,'Failed enclosing transaction rolls revocation back');
 $check((int)Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id=:uid',['uid'=>$student])['n']===$notificationsBefore,'Failed transaction rolls notification back');
 $check(count($service->listForUser($student,'STUDENT'))===1,'Student sees only authorized dataset');
 $reject(fn()=>$service->getDataset($dataset,$other,'STUDENT'),'Foreign student cannot inspect master dataset');
 $reject(fn()=>$service->updateMetadata($dataset,['name'=>'Denied'],$student),'Student cannot edit master metadata');
 $service->updateMetadata($dataset,['name'=>'Revised measurements'],$admin);$check($service->getDataset($dataset,$student,'STUDENT')['name']==='Revised measurements','SOC metadata edits appear on student reads');
 $v2=$repo->createVersion($dataset,$artifacts[1],'v2',$admin);$repo->setCurrentVersion($dataset,$v2,$artifacts[1],'v2');
 $check((int)$service->getDataset($dataset,$student,'STUDENT')['dataset_version_id']===$v1,'New version does not silently change pinned student assignment');
 $check(count($service->versions($dataset,$student,'STUDENT'))===1&&count($service->versions($dataset,$admin,'ADMIN'))===2,'Version listing respects explicit version authorization');
 $check(count($service->getPreview($dataset,$student,'STUDENT')['preview_rows'])===2,'Pinned preview reads original file bytes');
 $reject(fn()=>$service->getDataset($dataset,$student,'STUDENT',$v2),'Unassigned newer version cannot be read');
 $service->assignDataset($dataset,$student,$admin,$ticket,$v2);
 $check(count($service->getPreview($dataset,$student,'STUDENT')['preview_rows'])===3,'Explicit version reassignment exposes new immutable bytes');
 $processed=$repo->createProcessedDataset($artifacts[1]+['source_dataset_id'=>$dataset,'source_dataset_version_id'=>$v2,'student_id'=>$student,'ticket_id'=>$ticket,'name'=>'Processed measurements','description'=>'Own processing','transformation_notes'=>'Preserved source']);
 $check((int)$service->getProcessed($processed,$student,'STUDENT')['source_dataset_version_id']===$v2,'Processed result records actual immutable source version');
 $reject(fn()=>$service->getProcessed($processed,$other,'STUDENT'),'Foreign student cannot inspect processed result');
 $service->revokeDataset($dataset,$student,$admin,$ticket);$afterRevoke=(int)Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id=:uid',['uid'=>$student])['n'];$service->revokeDataset($dataset,$student,$admin,$ticket);
 $check((int)Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id=:uid',['uid'=>$student])['n']===$afterRevoke,'Revocation retry creates no duplicate notification');
 $reject(fn()=>$service->getDownloadPath($dataset,$student,'STUDENT'),'Revocation blocks master download');
 $check($service->listForUser($student,'STUDENT')===[],'Revoked master disappears from student catalog');
 $check((int)$service->getProcessed($processed,$student,'STUDENT')['id']===$processed,'Revocation preserves access to own processed history');
 $reject(fn()=>$service->uploadProcessedDataset($dataset,$student,$ticket,[],['name'=>'Denied']),'Revoked assignment blocks new processed upload before file handling');
 $service->assignDataset($dataset,$student,$admin,$ticket,$v1);$service->archiveDataset($dataset,$admin);$afterArchive=(int)Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id=:uid',['uid'=>$student])['n'];$service->archiveDataset($dataset,$admin);
 $check((int)Database::queryOne('SELECT COUNT(*) AS n FROM notifications WHERE user_id=:uid',['uid'=>$student])['n']===$afterArchive,'Archive retry creates no duplicate notification');
 $check(count($service->versions($dataset,$admin,'ADMIN'))===2&&is_file($files[0])&&is_file($files[1]),'Archive preserves every version and file');
 $check($service->listForUser($student,'STUDENT')===[],'Archived master unavailable to student');
 $reject(fn()=>$service->assignDataset($dataset,$student,$admin,$ticket),'Archived master cannot be assigned');
 $check((int)$service->getProcessed($processed,$student,'STUDENT')['id']===$processed,'Archive preserves processed history and ownership');
 $pdo->rollBack();
 $check(Database::queryOne('SELECT id FROM datasets WHERE code=:code',['code'=>$tag])===null,'Outer rollback removes all generated database records');
 foreach($checks as $label)echo 'PASS '.$label.PHP_EOL;
 echo count($checks).' dataset lifecycle checks passed on '.Env::get('DB_NAME').'; all generated rows rolled back.'.PHP_EOL;
}catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();fwrite(STDERR,$e->getMessage().PHP_EOL);exit(1);}
finally{foreach($files as $file)if(dirname($file)===$dir&&is_file($file))unlink($file);}
