<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\Database;
use App\Core\Env;
if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_test')){fwrite(STDERR,"REFUSED: testing database required.\n");exit(1);}
$prefix=$argv[1]??'';
if(!preg_match('/^vostok_range_[0-9]{8}_$/D',$prefix)){fwrite(STDERR,"Usage: php tests/collect_artifacts.php vostok_range_YYYYMMDD_\n");exit(1);}
$paths=[];$databases=[];
foreach(Database::query('SHOW DATABASES') as $row){$name=reset($row);if(!str_starts_with($name,$prefix)||!str_ends_with($name,'_test')||!preg_match('/^[a-z0-9_]+$/D',$name))continue;
 $databases[]=$name;
 foreach(['datasets'=>'datasets','processed_datasets'=>'datasets','model_versions'=>'models'] as $table=>$directory){
  $column=$table==='model_versions'?'artifact_path':'file_path';
  foreach(Database::query('SELECT `'.$column.'` AS path FROM `'.$name.'`.`'.$table.'`') as $file){$filename=basename($file['path']);if($filename===$file['path'])$paths[]='storage/private/'.$directory.'/'.$filename;}
 }
}
$paths=array_values(array_unique($paths));sort($paths);$root=dirname(__DIR__);$files=[];
foreach($paths as $path){if(is_file($root.'/'.$path))$files[]=['path'=>$path,'sha256'=>hash_file('sha256',$root.'/'.$path)];}
echo json_encode(['source_root'=>str_replace('\\','/',$root),'purpose'=>'Explicit HTTP integration test file references; read-only inventory, no files deleted','databases'=>$databases,'files'=>$files],JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
