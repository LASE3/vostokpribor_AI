<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\Database;
use App\Core\Env;
use App\Services\DeploymentService;

if(Env::get('APP_ENV')!=='testing'||!str_ends_with((string)Env::get('DB_NAME'),'_test')||!in_array(Env::get('DB_HOST'),['127.0.0.1','localhost','::1'],true)){
    fwrite(STDERR,"REFUSED: dedicated loopback testing _test database required.\n");exit(1);
}

/**
 * Deterministically changes this test's own model after the buffered preflight
 * SELECT but before the service obtains its row lock. This represents an
 * intervening committed archive without timing-dependent parallel processes.
 * The service and database are real; there are no production hooks or mocks.
 */
final class DeploymentArchiveInterleavingStatement extends PDOStatement
{
    public static ?int $modelId=null;
    public static bool $interleaved=false;
    public function execute(?array $params=null):bool
    {
        $result=parent::execute($params);
        if(self::$modelId!==null&&str_contains($this->queryString,'FROM models m')&&(int)($params['id']??0)===self::$modelId){
            $modelId=self::$modelId;self::$modelId=null;self::$interleaved=true;
            Database::execute("UPDATE models SET status='ARCHIVED' WHERE id=:id",['id'=>$modelId]);
        }
        return $result;
    }
}

$pdo=Database::getConnection();$db=Database::getInstance();$path=null;$oldStatementClass=$pdo->getAttribute(PDO::ATTR_STATEMENT_CLASS);
$tag='LOCKSTATE-'.strtoupper(bin2hex(random_bytes(6)));$checks=0;
$check=function(bool $ok,string $label)use(&$checks){if(!$ok)throw new RuntimeException('FAIL '.$label);$checks++;echo 'PASS '.$label.PHP_EOL;};
try{
    $pdo->beginTransaction();
    $student=$db->insert('users',['role'=>'STUDENT','identifier'=>$tag,'email'=>strtolower($tag).'@example.invalid','full_name'=>'Deployment lock regression','password_hash'=>password_hash(bin2hex(random_bytes(24)),PASSWORD_DEFAULT),'status'=>'ACTIVE']);
    $model=$db->insert('models',['student_id'=>$student,'model_code'=>$tag,'name'=>'Deployment lock regression','framework'=>'JSON','current_version'=>'','status'=>'REGISTERED']);
    $filename='locked_state_'.bin2hex(random_bytes(16)).'.json';$path=dirname(__DIR__).'/storage/private/models/'.$filename;
    if(!is_dir(dirname($path)))mkdir(dirname($path),0700,true);
    $handle=fopen($path,'x');if($handle===false)throw new RuntimeException('Exclusive regression file could not be created.');
    fwrite($handle,'{"regression":"opaque bytes"}');fclose($handle);
    $version=$db->insert('model_versions',['model_id'=>$model,'version'=>'lock-regression','artifact_path'=>$filename,'artifact_format'=>'json','checksum_sha256'=>hash_file('sha256',$path),'file_size'=>filesize($path)]);
    DeploymentArchiveInterleavingStatement::$modelId=$model;
    $pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS,[DeploymentArchiveInterleavingStatement::class]);
    $failure=null;
    try{(new DeploymentService())->requestDeployment(['model_id'=>$model,'model_version_id'=>$version,'environment'=>'staging','idempotency_key'=>$tag],$student);}
    catch(InvalidArgumentException $e){$failure=$e;}
    finally{$pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS,$oldStatementClass);DeploymentArchiveInterleavingStatement::$modelId=null;}
    $check(DeploymentArchiveInterleavingStatement::$interleaved,'Real model state changed after buffered preflight read and before lock');
    $check($failure!==null&&str_contains($failure->getMessage(),'before this request was committed'),'Current locked ARCHIVED state rejects stale preflight request');
    $check(Database::queryOne('SELECT status FROM models WHERE id=:id',['id'=>$model])['status']==='ARCHIVED','Intervening archive remains effective after rejection');
    $check((int)Database::queryOne('SELECT COUNT(*) AS n FROM deployment_requests WHERE model_id=:id',['id'=>$model])['n']===0,'Archived model receives zero new deployment request records');
    $check((int)Database::queryOne("SELECT COUNT(*) AS n FROM audit_logs WHERE actor_id=:id AND action='DEPLOYMENT_REQUEST_CREATED'",['id'=>$student])['n']===0,'Rejected request creates no success audit');
    $pdo->rollBack();
    $check(Database::queryOne('SELECT id FROM users WHERE identifier=:tag',['tag'=>$tag])===null,'All regression rows rolled back without altering original records');
    echo $checks.' deployment locked-state checks passed on '.Env::get('DB_NAME').'; no inference execution attempted.'.PHP_EOL;
}catch(Throwable $e){if($pdo->inTransaction())$pdo->rollBack();fwrite(STDERR,$e->getMessage().PHP_EOL);exit(1);}
finally{
    $pdo->setAttribute(PDO::ATTR_STATEMENT_CLASS,$oldStatementClass);
    DeploymentArchiveInterleavingStatement::$modelId=null;
    if($path!==null&&is_file($path))unlink($path);
}
