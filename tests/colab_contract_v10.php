<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') exit(1);
spl_autoload_register(function($class){if(str_starts_with($class,'App\\'))require __DIR__.'/../app/'.str_replace('\\','/',substr($class,4)).'.php';});
use App\Execution\{NotebookDocument,ColabEnterpriseProvider};
$passed=0;
$check=function($condition,$label)use(&$passed){if(!$condition)throw new RuntimeException($label);$passed++;echo 'PASS '.$label.PHP_EOL;};
$reject=function(callable $action,$label)use($check){try{$action();}catch(InvalidArgumentException $e){$check(true,$label);return;}throw new RuntimeException($label.' was accepted');};
$source="# Unicode Ω\nliteral = '</textarea><script>text</script>'\nprint(2+2)\n";
$nb=['student_id'=>7,'title'=>'Own notebook','id'=>99,'password'=>'must-not-export','cells'=>[
 ['cell_type'=>'markdown','source'=>'# Heading','outputs'=>['secret']],[ 'cell_type'=>'code','source'=>$source,'outputs'=>['untrusted'],'execution_count'=>42]]];
$json=NotebookDocument::encode($nb);$doc=json_decode($json,true);
$check($doc['nbformat']===4 && $doc['metadata']['kernelspec']['name']==='python3','standard Python nbformat4 document');
$check(count($doc['cells'])===2 && $doc['cells'][1]['source']===$source,'literal source and ordered cells preserved');
$check($doc['nbformat_minor']===5 && $doc['cells'][0]['id']==='cell-1' && $doc['cells'][1]['id']==='cell-2','nbformat4.5 exports required unique cell identifiers');
$check($doc['cells'][1]['outputs']===[] && $doc['cells'][1]['execution_count']===null,'export excludes execution output and counts');
$check(!str_contains($json,'must-not-export')&&!str_contains($json,'untrusted')&&!isset($doc['student_id']),'export excludes DB identity and unrelated fields');
$round=NotebookDocument::decode($json);$check($round[1]===['cell_type'=>'code','source'=>$source],'import roundtrip retains exact source only');
$in=$doc;$in['cells'][1]['source']=["print(1)\n","print(2)\n"];$in['cells'][1]['outputs']=[['data'=>['text/html'=>'<script>untrusted</script>']]];
$cells=NotebookDocument::decode(json_encode($in));$check($cells[1]['source']==="print(1)\nprint(2)\n" && !isset($cells[1]['outputs']),'Colab source arrays merge; rich outputs are discarded');
foreach(['','{','null','[]',json_encode(['nbformat'=>3,'cells'=>[]]),json_encode(['nbformat'=>4,'cells'=>['bad']]),json_encode(['nbformat'=>4,'cells'=>[['cell_type'=>'raw','source'=>'x']]]),json_encode(['nbformat'=>4,'cells'=>[['cell_type'=>'code','source'=>[42]]]])] as $i=>$invalid)$reject(fn()=>NotebookDocument::decode($invalid),'malformed/unsupported import '.$i.' rejected');
$reject(fn()=>NotebookDocument::decode(str_repeat('x',NotebookDocument::MAX_BYTES+1)),'oversize document rejected');
$reject(fn()=>NotebookDocument::decode(json_encode(['nbformat'=>4,'cells'=>array_fill(0,201,['cell_type'=>'code','source'=>''])])),'cell count cap enforced');
$reject(fn()=>NotebookDocument::decode(json_encode(['nbformat'=>4,'cells'=>[['cell_type'=>'code','source'=>str_repeat('x',262145)]]])),'cell size cap enforced');
$cfg=['project'=>'vostok-project','location'=>'us-central1','runtime_template'=>'projects/vostok-project/locations/us-central1/notebookRuntimeTemplates/reviewed-template','output_bucket'=>'vostok-output','credentials_file'=>'operator-configured-outside-webroot.json','timeout_seconds'=>600,'execution_service_accounts'=>['7'=>'student-seven@vostok-project.iam.gserviceaccount.com']];
$provider=new ColabEnterpriseProvider($cfg);$plan=$provider->prepare($nb,7,'vostok-local-contract-123');
$check($plan['method']==='POST' && str_contains($plan['url'],'us-central1-aiplatform.googleapis.com/v1/projects/vostok-project/locations/us-central1/notebookExecutionJobs?notebookExecutionJobId='),'documented create endpoint and explicit job ID');
$body=$plan['body'];$check(NotebookDocument::decode(base64_decode($body['directNotebookSource']['content']))===$round,'documented base64 directNotebookSource');
$check($body['serviceAccount']===$cfg['execution_service_accounts']['7'] && str_ends_with($body['gcsOutputUri'],'/students/7/jobs/vostok-local-contract-123'),'per-student identity and bounded job output prefix');
$check($body['executionTimeout']==='600s' && $plan['submitted']===false && $plan['automatic_dataset_transfer']===false,'bounded prepared plan sends no code or datasets');
$reject(fn()=>$provider->prepare($nb,8,'vostok-local-contract-123'),'foreign owner rejected');
$reject(fn()=>$provider->prepare($nb,7,'../bad'),'path injection job ID rejected');
foreach(['location'=>'https://untrusted.invalid','runtime_template'=>'projects/foreign/locations/us-central1/notebookRuntimeTemplates/x','timeout_seconds'=>86400,'output_bucket'=>'bucket/../../secret'] as $key=>$bad){$c=$cfg;$c[$key]=$bad;$reject(fn()=>(new ColabEnterpriseProvider($c))->prepare($nb,7,'vostok-local-contract-123'),'invalid provider '.$key.' rejected');}
$c=$cfg;$c['execution_service_accounts']['8']=$c['execution_service_accounts']['7'];$reject(fn()=>(new ColabEnterpriseProvider($c))->prepare($nb,7,'vostok-local-contract-123'),'shared student runtime identity rejected');
$c=$cfg;$c['execution_service_accounts']='bad';$reject(fn()=>(new ColabEnterpriseProvider($c))->prepare($nb,7,'vostok-local-contract-123'),'invalid identity map rejected');
$large=$nb;$large['cells']=array_fill(0,8,['cell_type'=>'code','source'=>str_repeat('a',220000)]);$reject(fn()=>$provider->prepare($large,7,'vostok-local-contract-123'),'base64 expansion respects actual HTTPS request cap');
$check($provider->availability()['can_execute']===false && !$provider->availability()['supports_verified_cancellation'],'configuration never claims verified activation/cancellation');
try{$provider->submit($nb);throw new RuntimeException('Submission enabled');}catch(DomainException $e){$check(true,'submission blocked before any provider side effect');}
try{$provider->cancel('anything');throw new RuntimeException('Cancellation claimed');}catch(DomainException $e){$check(true,'unsupported cancellation cannot falsely report success');}
$check((new ColabEnterpriseProvider([]))->availability()['configuration_status']==='NOT_CONFIGURED','empty setup truthfully unavailable');
echo 'PASS ALL '.$passed.' offline Colab/document contracts; no network, database or Python execution.'.PHP_EOL;
