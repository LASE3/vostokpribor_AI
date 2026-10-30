<?php
namespace App\Services;

use App\Core\AccessDeniedException;
use App\Core\Database;
use App\Core\Env;
use App\Core\Logger;
use App\Repositories\DatasetRepository;
use InvalidArgumentException;
use RuntimeException;

class DatasetService
{
    private DatasetRepository $datasetRepo;
    private string $storageDir;
    public function __construct()
    {
        $this->datasetRepo=new DatasetRepository();
        $this->storageDir=dirname(__DIR__,2).'/storage/private/datasets';
    }

    private function requireAdmin(int $id):void
    {
        if(!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='ADMIN' AND status='ACTIVE'",['id'=>$id]))throw new AccessDeniedException('Active administrator required.');
    }

    public function listForUser(int $uid,string $role,?string $format=null):array
    {
        if($format!==null&&$format!==''&&!in_array(strtolower($format),['csv','json'],true))throw new InvalidArgumentException('Unsupported dataset format filter.');
        return $this->datasetRepo->listForUser($uid,$role,$format);
    }

    public function getDataset(int $id,int $uid,string $role,?int $versionId=null):array
    {
        $dataset=$this->datasetRepo->findById($id);
        if(!$dataset)throw new AccessDeniedException('Dataset unavailable or access denied.');
        if($role!=='ADMIN'){
            $assignment=$this->datasetRepo->authorizedVersion($id,$uid,$versionId);
            if(!$assignment)throw new AccessDeniedException('Dataset unavailable or access denied.');
            $versionId=(int)$assignment['dataset_version_id'];
            $dataset['assigned_ticket_id']=$assignment['ticket_id'];
        }
        $versionId=$versionId??(int)$dataset['current_version_id'];
        $version=$this->datasetRepo->version($id,$versionId);
        if(!$version)throw new InvalidArgumentException('Dataset version does not belong to this dataset.');
        foreach(['version','format','file_path','file_size','checksum_sha256','row_count','column_count','schema_json'] as $key)$dataset[$key]=$version[$key];
        $dataset['dataset_version_id']=$versionId;
        return $dataset;
    }

    public function versions(int $id,int $uid,string $role):array
    {
        $this->getDataset($id,$uid,$role);
        return $this->datasetRepo->versions($id,$role==='ADMIN'?null:$uid);
    }

    private function verifiedPath(array $record):string
    {
        if(!isset($record['file_path'])||basename($record['file_path'])!==$record['file_path'])throw new RuntimeException('Invalid stored artifact reference.');
        $path=$this->storageDir.'/'.$record['file_path'];
        if(!is_file($path)||!hash_equals((string)$record['checksum_sha256'],(string)hash_file('sha256',$path)))throw new RuntimeException('Dataset file missing or checksum mismatch.');
        return $path;
    }

    public function getPreview(int $id,int $uid,string $role,int $limit=20,?int $versionId=null):array
    {
        $d=$this->getDataset($id,$uid,$role,$versionId);$a=$this->inspect($this->verifiedPath($d),$d['format'],max(1,min(50,$limit)));
        unset($d['file_path']);
        return ['dataset'=>$d,'columns'=>$a['schema'],'preview_rows'=>$a['preview'],'preview_limit'=>$limit];
    }

    public function getDownloadPath(int $id,int $uid,string $role,?int $versionId=null):string
    {
        $d=$this->getDataset($id,$uid,$role,$versionId);$path=$this->verifiedPath($d);
        Logger::audit('DATASET_DOWNLOADED','datasets',(string)$id,'SUCCESS',['dataset_version_id'=>$d['dataset_version_id']],$uid);
        return $path;
    }

    private function inspect(string $path,string $format,int $limit=20):array
    {
        $rows=0;$preview=[];$schema=[];
        if($format==='csv'){
            $handle=fopen($path,'rb');if(!$handle)throw new InvalidArgumentException('Cannot read CSV.');
            try{
                $schema=fgetcsv($handle);
                if(!$schema||count(array_filter($schema,fn($v)=>trim((string)$v)!==''))!==count($schema)||count(array_unique($schema))!==count($schema))throw new InvalidArgumentException('CSV requires unique nonempty column headings.');
                while(($row=fgetcsv($handle))!==false){
                    if($row===[null])continue;
                    if(count($row)!==count($schema))throw new InvalidArgumentException('CSV row has a different number of columns.');
                    if($rows<$limit)$preview[]=array_combine($schema,$row);$rows++;
                }
            }finally{fclose($handle);}
        }else{
            try{$data=json_decode(file_get_contents($path),true,512,JSON_THROW_ON_ERROR);}catch(\JsonException){throw new InvalidArgumentException('Invalid JSON dataset.');}
            if(!is_array($data)||!array_is_list($data))throw new InvalidArgumentException('JSON dataset must be an array of row objects.');
            foreach($data as $row){
                if(!is_array($row)||array_is_list($row))throw new InvalidArgumentException('Each JSON row must be a nonempty object.');
                if(!$schema)$schema=array_keys($row);
                $keys=array_keys($row);sort($keys);$expected=$schema;sort($expected);
                if($keys!==$expected)throw new InvalidArgumentException('JSON rows must use the same columns.');
                if($rows<$limit)$preview[]=$row;$rows++;
            }
        }
        return ['row_count'=>$rows,'column_count'=>count($schema),'schema'=>$schema,'preview'=>$preview];
    }

    private function prepareUpload(array $file):array
    {
        if(($file['error']??UPLOAD_ERR_NO_FILE)!==UPLOAD_ERR_OK||empty($file['tmp_name'])||!is_uploaded_file($file['tmp_name']))throw new InvalidArgumentException('A genuine successful HTTP file upload is required.');
        $size=filesize($file['tmp_name']);$max=max(1,(int)Env::get('MAX_UPLOAD_SIZE_MB',50))*1024*1024;
        if($size===false||$size<1||$size>$max)throw new InvalidArgumentException('File is empty or exceeds the upload size limit.');
        $ext=strtolower(pathinfo((string)$file['name'],PATHINFO_EXTENSION));
        if(!in_array($ext,['csv','json'],true))throw new InvalidArgumentException('Only CSV and JSON datasets are supported.');
        $a=$this->inspect($file['tmp_name'],$ext);
        return ['format'=>$ext,'file_size'=>$size,'checksum_sha256'=>hash_file('sha256',$file['tmp_name']),'row_count'=>$a['row_count'],'column_count'=>$a['column_count'],'schema_json'=>$a['schema']];
    }

    private function receive(array $file,array $prepared):array
    {
        if(!is_dir($this->storageDir)&&!mkdir($this->storageDir,0700,true))throw new RuntimeException('Private storage unavailable.');
        $filename='ds_'.bin2hex(random_bytes(16)).'.'.$prepared['format'];
        if(!move_uploaded_file($file['tmp_name'],$this->storageDir.'/'.$filename))throw new RuntimeException('Cannot save dataset upload.');
        return $prepared+['file_path'=>$filename];
    }

    private function versionLabel(mixed $value):string
    {
        if(!is_string($value)||!preg_match('/^[A-Za-z0-9][A-Za-z0-9_.-]{0,31}$/D',$value))throw new InvalidArgumentException('Version must contain 1 to 32 letters, digits, dots, underscores or hyphens.');
        return $value;
    }

    private function metadata(array $data,?array $previous=null):array
    {
        $fields=[];
        foreach(['name'=>255,'description'=>60000] as $key=>$max){
            if($previous!==null&&!array_key_exists($key,$data))continue;
            $value=$data[$key]??'';
            if(!is_string($value)||strlen(trim($value))>$max||($key==='name'&&trim($value)===''))throw new InvalidArgumentException('Invalid dataset '.$key.'.');
            $fields[$key]=trim($value);
        }
        if($previous===null||array_key_exists('scenario_id',$data)){
            $raw=$data['scenario_id']??null;
            $id=$raw===null||$raw===''?null:filter_var($raw,FILTER_VALIDATE_INT);
            if($id===false||($id!==null&&$id<=0))throw new InvalidArgumentException('Invalid scenario identifier.');
            if($id!==null&&!Database::queryOne('SELECT id FROM scenarios WHERE id=:id',['id'=>$id]))throw new InvalidArgumentException('Scenario does not exist.');
            $fields['scenario_id']=$id;
        }
        return $fields;
    }

    public function uploadDataset(array $file,array $data,int $actor):array
    {
        $this->requireAdmin($actor);$data['name']=$data['name']??$file['name']??'';
        $meta=$this->metadata($data);$rawCode=$data['code']??('DS-'.bin2hex(random_bytes(6)));if(!is_string($rawCode))throw new InvalidArgumentException('Dataset code must be a string.');$code=strtoupper(trim($rawCode));
        if(!preg_match('/^[A-Z0-9_-]{1,64}$/D',$code))throw new InvalidArgumentException('Valid dataset code required.');
        $version=$this->versionLabel($data['version']??'v1.0');
        $prepared=$this->prepareUpload($file);
        if($existing=$this->datasetRepo->findByCode($code)){
            if($existing['checksum_sha256']===$prepared['checksum_sha256']&&$existing['name']===$meta['name']&&$existing['description']===$meta['description']&&(int)$existing['scenario_id']===(int)$meta['scenario_id'])return $this->datasetRepo->findById((int)$existing['id']);
            throw new InvalidArgumentException('Dataset code already exists.');
        }
        $stored=$this->receive($file,$prepared);
        try{
            return Database::transaction(function()use($stored,$meta,$code,$version,$actor){
                $id=$this->datasetRepo->create($stored+$meta+['code'=>$code,'is_master'=>1,'version'=>$version,'uploaded_by'=>$actor]);
                $vid=$this->datasetRepo->createVersion($id,$stored,$version,$actor);
                $this->datasetRepo->setCurrentVersion($id,$vid,$stored,$version);
                Logger::audit('DATASET_UPLOADED','datasets',(string)$id,'SUCCESS',['dataset_version_id'=>$vid,'checksum'=>$stored['checksum_sha256']],$actor);
                return $this->datasetRepo->findById($id);
            });
        }catch(\Throwable $e){if(is_file($this->storageDir.'/'.$stored['file_path']))unlink($this->storageDir.'/'.$stored['file_path']);throw $e;}
    }

    public function updateMetadata(int $id,array $data,int $actor):array
    {
        $this->requireAdmin($actor);
        return Database::transaction(function()use($id,$data,$actor){
            $d=Database::queryOne('SELECT * FROM datasets WHERE id=:id FOR UPDATE',['id'=>$id]);
            if(!$d)throw new InvalidArgumentException('Dataset does not exist.');
            $changes=$this->metadata($data,$d);
            if(array_key_exists('scenario_id',$changes)&&$changes['scenario_id']!==null&&Database::queryOne('SELECT a.id FROM dataset_assignments a JOIN tickets t ON t.id=a.ticket_id WHERE a.dataset_id=:did AND a.revoked_at IS NULL AND (t.scenario_id IS NULL OR t.scenario_id<>:sid) LIMIT 1',['did'=>$id,'sid'=>$changes['scenario_id']]))throw new InvalidArgumentException('Scenario would conflict with an active assigned ticket.');
            $changes=array_filter($changes,fn($v,$key)=>$v!=$d[$key],ARRAY_FILTER_USE_BOTH);
            if($changes){Database::getInstance()->update('datasets',$changes,'id=:id',['id'=>$id]);Logger::audit('DATASET_METADATA_UPDATED','datasets',(string)$id,'SUCCESS',['fields'=>array_keys($changes)],$actor);}
            return $this->datasetRepo->findById($id);
        });
    }

    public function addVersion(int $id,array $file,array $data,int $actor):array
    {
        $this->requireAdmin($actor);$version=$this->versionLabel($data['version']??'');$prepared=$this->prepareUpload($file);
        $d=$this->datasetRepo->findById($id);if(!$d||$d['archived_at'])throw new InvalidArgumentException('Active dataset required.');
        $existing=Database::queryOne('SELECT * FROM dataset_versions WHERE dataset_id=:did AND version=:version',['did'=>$id,'version'=>$version]);
        if($existing){
            if(hash_equals($existing['checksum_sha256'],$prepared['checksum_sha256']))return $existing;
            throw new InvalidArgumentException('Immutable dataset version already exists with different file bytes.');
        }
        $stored=$this->receive($file,$prepared);
        try{
            return Database::transaction(function()use($id,$stored,$version,$actor){
                $d=Database::queryOne('SELECT id,archived_at FROM datasets WHERE id=:id FOR UPDATE',['id'=>$id]);
                if(!$d||$d['archived_at'])throw new InvalidArgumentException('Active dataset required.');
                $vid=$this->datasetRepo->createVersion($id,$stored,$version,$actor);
                $this->datasetRepo->setCurrentVersion($id,$vid,$stored,$version);
                Logger::audit('DATASET_VERSION_CREATED','datasets',(string)$id,'SUCCESS',['dataset_version_id'=>$vid,'version'=>$version],$actor);
                return $this->datasetRepo->version($id,$vid);
            });
        }catch(\Throwable $e){if(is_file($this->storageDir.'/'.$stored['file_path']))unlink($this->storageDir.'/'.$stored['file_path']);throw $e;}
    }

    private function notify(int $user,string $title,string $message,string $type='INFO'):void
    {
        Database::getInstance()->insert('notifications',['user_id'=>$user,'title'=>$title,'message'=>$message,'type'=>$type,'link'=>'/vostokpribor_AI/Data Center/MyDataSet.php']);
    }

    public function assignDataset(int $id,int $student,int $actor,?int $ticket=null,?int $versionId=null):void
    {
        $this->requireAdmin($actor);
        Database::transaction(function()use($id,$student,$actor,$ticket,$versionId){
            $d=Database::queryOne('SELECT * FROM datasets WHERE id=:id FOR UPDATE',['id'=>$id]);
            if(!$d||$d['archived_at'])throw new InvalidArgumentException('Active dataset required.');
            if(!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='STUDENT' AND status='ACTIVE' FOR UPDATE",['id'=>$student]))throw new InvalidArgumentException('Active student required.');
            $t=$ticket?Database::queryOne("SELECT t.* FROM tickets t JOIN ticket_assignments a ON a.ticket_id=t.id WHERE t.id=:tid AND a.student_id=:uid AND a.revoked_at IS NULL AND t.status<>'CANCELLED'",['tid'=>$ticket,'uid'=>$student]):null;
            if(!$t)throw new InvalidArgumentException('Assign this active ticket to the student before assigning its dataset.');
            if($d['scenario_id']!==null&&(int)$d['scenario_id']!==(int)$t['scenario_id'])throw new InvalidArgumentException('Dataset and ticket scenarios do not match.');
            $vid=$versionId??(int)$d['current_version_id'];if(!$this->datasetRepo->version($id,$vid))throw new InvalidArgumentException('Version does not belong to this dataset.');
            $existing=Database::queryOne('SELECT * FROM dataset_assignments WHERE dataset_id=:did AND student_id=:uid AND ticket_id=:tid FOR UPDATE',['did'=>$id,'uid'=>$student,'tid'=>$ticket]);
            if($existing&&$existing['revoked_at']===null&&(int)$existing['dataset_version_id']===$vid)return;
            if($existing)Database::execute('UPDATE dataset_assignments SET dataset_version_id=:vid,assigned_by=:actor,revoked_at=NULL,revoked_by=NULL WHERE id=:id',['vid'=>$vid,'actor'=>$actor,'id'=>$existing['id']]);
            else Database::getInstance()->insert('dataset_assignments',['dataset_id'=>$id,'student_id'=>$student,'ticket_id'=>$ticket,'assigned_by'=>$actor,'dataset_version_id'=>$vid]);
            Logger::audit('DATASET_ASSIGNED','datasets',(string)$id,'SUCCESS',['student_id'=>$student,'ticket_id'=>$ticket,'dataset_version_id'=>$vid,'previous_version_id'=>$existing['dataset_version_id']??null],$actor);
            $this->notify($student,'Dataset assigned',$d['code'].' is available for ticket '.$t['ticket_code'].'.');
        });
    }

    public function revokeDataset(int $id,int $student,int $actor,?int $ticket=null):void
    {
        $this->requireAdmin($actor);
        Database::transaction(function()use($id,$student,$actor,$ticket){
            $d=Database::queryOne('SELECT * FROM datasets WHERE id=:id FOR UPDATE',['id'=>$id]);if(!$d)throw new InvalidArgumentException('Dataset does not exist.');
            if(!Database::queryOne("SELECT id FROM users WHERE id=:uid AND role='STUDENT'",['uid'=>$student]))throw new InvalidArgumentException('Student does not exist.');
            $params=['did'=>$id,'uid'=>$student];$where='dataset_id=:did AND student_id=:uid AND revoked_at IS NULL';
            if($ticket!==null){$where.=' AND ticket_id=:tid';$params['tid']=$ticket;}
            $matches=Database::query('SELECT id FROM dataset_assignments WHERE '.$where.' FOR UPDATE',$params);
            if(!$matches)return;
            Database::execute('UPDATE dataset_assignments SET revoked_at=NOW(),revoked_by=:actor WHERE '.$where,$params+['actor'=>$actor]);
            Logger::audit('DATASET_ACCESS_REVOKED','datasets',(string)$id,'SUCCESS',['student_id'=>$student,'ticket_id'=>$ticket,'assignments'=>array_column($matches,'id')],$actor);
            $this->notify($student,'Dataset access revoked',$d['code'].' is no longer available for the revoked assignment. Saved processed work is retained.','WARNING');
        });
    }

    public function archiveDataset(int $id,int $actor):array
    {
        $this->requireAdmin($actor);
        return Database::transaction(function()use($id,$actor){
            $d=Database::queryOne('SELECT * FROM datasets WHERE id=:id FOR UPDATE',['id'=>$id]);if(!$d)throw new InvalidArgumentException('Dataset does not exist.');
            if($d['archived_at']!==null)return $this->datasetRepo->findById($id);
            $affected=Database::query('SELECT DISTINCT student_id FROM dataset_assignments WHERE dataset_id=:did AND revoked_at IS NULL',['did'=>$id]);
            Database::execute('UPDATE datasets SET archived_at=NOW(),archived_by=:actor WHERE id=:id',['actor'=>$actor,'id'=>$id]);
            Database::execute('UPDATE dataset_assignments SET revoked_at=NOW(),revoked_by=:actor WHERE dataset_id=:did AND revoked_at IS NULL',['actor'=>$actor,'did'=>$id]);
            Logger::audit('DATASET_ARCHIVED','datasets',(string)$id,'SUCCESS',['files_retained'=>true,'affected_students'=>array_column($affected,'student_id')],$actor);
            foreach($affected as $row)$this->notify((int)$row['student_id'],'Dataset archived',$d['code'].' was archived. Existing files and your processed work remain preserved.','WARNING');
            return $this->datasetRepo->findById($id);
        });
    }

    public function assignments(int $id,int $actor):array
    {
        $this->requireAdmin($actor);if(!$this->datasetRepo->findById($id))throw new InvalidArgumentException('Dataset does not exist.');
        return $this->datasetRepo->assignments($id);
    }

    public function activity(int $id,int $actor):array
    {
        $this->requireAdmin($actor);if(!$this->datasetRepo->findById($id))throw new InvalidArgumentException('Dataset does not exist.');
        return Database::query("SELECT a.*,u.full_name AS actor_name FROM audit_logs a LEFT JOIN users u ON u.id=a.actor_id WHERE a.resource_type='datasets' AND a.resource_id=:id ORDER BY a.id DESC LIMIT 200",['id'=>(string)$id]);
    }

    public function activityForUser(int $uid,string $role):array
    {
        if($role==='ADMIN'){$this->requireAdmin($uid);return Database::query("SELECT * FROM audit_logs WHERE resource_type IN ('datasets','processed_datasets') ORDER BY id DESC LIMIT 200");}
        return Database::query("SELECT * FROM audit_logs WHERE actor_id=:uid AND resource_type IN ('datasets','processed_datasets') ORDER BY id DESC LIMIT 200",['uid'=>$uid]);
    }

    public function listProcessed(int $uid,string $role):array
    {
        return $this->datasetRepo->listProcessedForUser($uid,$role);
    }

    public function getProcessed(int $id,int $uid,string $role):array
    {
        $p=$this->datasetRepo->processedById($id);
        if(!$p||($role!=='ADMIN'&&(int)$p['student_id']!==$uid))throw new AccessDeniedException('Processed dataset unavailable or access denied.');
        return $p;
    }

    public function processedDownload(int $id,int $uid,string $role):string
    {
        $p=$this->getProcessed($id,$uid,$role);$path=$this->verifiedPath($p);
        Logger::audit('PROCESSED_DATASET_DOWNLOADED','processed_datasets',(string)$id,'SUCCESS',null,$uid);return $path;
    }

    public function uploadProcessedDataset(int $source,int $uid,?int $ticket,array $file,array $data):array
    {
        if(!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='STUDENT' AND status='ACTIVE'",['id'=>$uid]))throw new AccessDeniedException('Active student required for processed uploads.');
        $raw=$data['source_dataset_version_id']??null;$vid=$raw===null||$raw===''?null:filter_var($raw,FILTER_VALIDATE_INT);
        if($vid===false||($vid!==null&&$vid<=0))throw new InvalidArgumentException('Invalid source dataset version.');
        $assignment=$ticket?$this->datasetRepo->authorizedVersion($source,$uid,$vid,$ticket):null;
        if(!$assignment)throw new AccessDeniedException('The master dataset version and active ticket must both be assigned to you together.');
        $rawName=$data['name']??$file['name']??'';if(!is_string($rawName))throw new InvalidArgumentException('Processed dataset name must be a string.');$name=trim($rawName);$notes=$data['transformation_notes']??'';$description=$data['description']??'';
        if($name===''||strlen($name)>255||!is_string($notes)||strlen($notes)>60000||!is_string($description)||strlen($description)>60000)throw new InvalidArgumentException('Valid processed dataset name and notes required.');
        $stored=$this->receive($file,$this->prepareUpload($file));
        try{
            return Database::transaction(function()use($source,$uid,$ticket,$assignment,$stored,$name,$notes,$description){
                // Lock the assignment and recheck after file validation so revocation cannot race acceptance.
                $active=Database::queryOne('SELECT id FROM dataset_assignments WHERE id=:id AND revoked_at IS NULL FOR UPDATE',['id'=>$assignment['id']]);
                if(!$active||!$this->datasetRepo->authorizedVersion($source,$uid,(int)$assignment['dataset_version_id'],$ticket))throw new AccessDeniedException('Dataset assignment was revoked before this upload completed.');
                $id=$this->datasetRepo->createProcessedDataset($stored+['source_dataset_id'=>$source,'source_dataset_version_id'=>$assignment['dataset_version_id'],'student_id'=>$uid,'ticket_id'=>$ticket,'name'=>$name,'description'=>trim($description),'transformation_notes'=>trim($notes)]);
                Logger::audit('PROCESSED_DATASET_UPLOADED','processed_datasets',(string)$id,'SUCCESS',['source_id'=>$source,'source_dataset_version_id'=>$assignment['dataset_version_id'],'ticket_id'=>$ticket],$uid);
                return $this->datasetRepo->processedById($id);
            });
        }catch(\Throwable $e){if(is_file($this->storageDir.'/'.$stored['file_path']))unlink($this->storageDir.'/'.$stored['file_path']);throw $e;}
    }
}
