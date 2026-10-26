<?php
namespace App\Services;
use App\Core\Database;
use App\Core\Logger;
use App\Repositories\DatasetRepository;
use InvalidArgumentException;
use RuntimeException;

class DatasetService {
    private DatasetRepository $datasetRepo;
    private string $storageDir;
    public function __construct() {
        $this->datasetRepo = new DatasetRepository();
        $this->storageDir = dirname(__DIR__, 2) . '/storage/private/datasets';
    }
    public function listForUser(int $uid, string $role, ?string $format = null): array {
        return $this->datasetRepo->listForUser($uid, $role, $format);
    }
    public function getDataset(int $id, int $uid, string $role): array {
        $d = $this->datasetRepo->findById($id);
        if (!$d || ($role !== 'ADMIN' && !$this->datasetRepo->isAssignedToStudent($id, $uid))) throw new \App\Core\AccessDeniedException('Dataset unavailable or access denied.');
        return $d;
    }
    public function getPreview(int $id, int $uid, string $role, int $limit = 20): array {
        $d = $this->getDataset($id, $uid, $role);
        $p = $this->storageDir . '/' . basename($d['file_path']);
        if (!is_file($p) || !hash_equals($d['checksum_sha256'], hash_file('sha256', $p))) throw new RuntimeException('Dataset file missing or checksum mismatch.');
        $a = $this->inspect($p, $d['format'], max(1, min(50, $limit)));
        unset($d['file_path']);
        return ['dataset' => $d, 'columns' => $a['schema'], 'preview_rows' => $a['preview'], 'preview_limit' => $limit];
    }
    public function getDownloadPath(int $id, int $uid, string $role): string {
        $d = $this->getDataset($id, $uid, $role);
        $p = $this->storageDir . '/' . basename($d['file_path']);
        if (!is_file($p) || !hash_equals($d['checksum_sha256'], hash_file('sha256', $p))) throw new RuntimeException('Dataset file missing or checksum mismatch.');
        Logger::audit('DATASET_DOWNLOADED', 'datasets', (string)$id, 'SUCCESS', null, $uid);
        return $p;
    }
    private function inspect(string $path, string $format, int $limit = 20): array {
        $rows = 0; $preview = []; $schema = [];
        if ($format === 'csv') {
            $h = fopen($path, 'rb');
            if (!$h) throw new InvalidArgumentException('Cannot read CSV.');
            try {
                $schema = fgetcsv($h);
                if (!$schema || count(array_filter($schema, fn($v) => trim((string)$v) !== '')) !== count($schema) || count(array_unique($schema)) !== count($schema)) throw new InvalidArgumentException('CSV requires unique nonempty column headings.');
                while (($row = fgetcsv($h)) !== false) {
                    if ($row === [null]) continue;
                    if (count($row) !== count($schema)) throw new InvalidArgumentException('CSV row has a different number of columns.');
                    if ($rows < $limit) $preview[] = array_combine($schema, $row);
                    $rows++;
                }
            } finally { fclose($h); }
        } else {
            try { $data = json_decode(file_get_contents($path), true, 512, JSON_THROW_ON_ERROR); }
            catch (\JsonException $e) { throw new InvalidArgumentException('Invalid JSON dataset.'); }
            if (!is_array($data) || !array_is_list($data)) throw new InvalidArgumentException('JSON dataset must be an array of row objects.');
            foreach ($data as $row) {
                if (!is_array($row) || array_is_list($row)) throw new InvalidArgumentException('Each JSON row must be a nonempty object.');
                if (!$schema) $schema = array_keys($row);
                $keys = array_keys($row); sort($keys); $expected = $schema; sort($expected);
                if ($keys !== $expected) throw new InvalidArgumentException('JSON rows must use the same columns.');
                if ($rows < $limit) $preview[] = $row;
                $rows++;
            }
        }
        return ['row_count' => $rows, 'column_count' => count($schema), 'schema' => $schema, 'preview' => $preview];
    }
    private function receive(array $f): array {
        if (($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || empty($f['tmp_name']) || !is_uploaded_file($f['tmp_name'])) throw new InvalidArgumentException('A genuine successful HTTP file upload is required.');
        $size = filesize($f['tmp_name']); $max = (int)\App\Core\Env::get('MAX_UPLOAD_SIZE_MB', 50) * 1024 * 1024;
        if ($size < 1 || $size > $max) throw new InvalidArgumentException('File is empty or exceeds the upload size limit.');
        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['csv','json'], true)) throw new InvalidArgumentException('Only CSV and JSON datasets are supported.');
        $a = $this->inspect($f['tmp_name'], $ext);
        if (!is_dir($this->storageDir) && !mkdir($this->storageDir, 0700, true)) throw new RuntimeException('Private storage unavailable.');
        $name = 'ds_' . bin2hex(random_bytes(16)) . '.' . $ext; $p = $this->storageDir . '/' . $name;
        if (!move_uploaded_file($f['tmp_name'], $p)) throw new RuntimeException('Cannot save dataset upload.');
        return ['file_path'=>$name,'file_size'=>$size,'format'=>$ext,'checksum_sha256'=>hash_file('sha256',$p),'row_count'=>$a['row_count'],'column_count'=>$a['column_count'],'schema_json'=>$a['schema']];
    }
    private function requireAdmin(int $id): void {
        if (!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='ADMIN' AND status='ACTIVE'",['id'=>$id])) throw new \App\Core\AccessDeniedException('Administrator required.');
    }
    public function uploadDataset(array $f, array $m, int $uid): array {
        $this->requireAdmin($uid);
        $code = strtoupper(trim($m['code'] ?? ('DS-'.bin2hex(random_bytes(6))))); $name=trim($m['name'] ?? $f['name'] ?? '');
        if (!$name || strlen($name)>255 || !preg_match('/^[A-Z0-9_-]{1,64}$/',$code)) throw new InvalidArgumentException('Valid name and dataset code required.');
        if ($this->datasetRepo->findByCode($code)) throw new InvalidArgumentException('Dataset code already exists.');
        $sid=!empty($m['scenario_id'])?(int)$m['scenario_id']:null;
        if ($sid && !Database::queryOne('SELECT id FROM scenarios WHERE id=:id',['id'=>$sid])) throw new InvalidArgumentException('Scenario does not exist.');
        $stored=$this->receive($f);
        try {
            return Database::transaction(function() use($stored,$m,$uid,$code,$name,$sid) {
                $id=$this->datasetRepo->create($stored+['code'=>$code,'name'=>$name,'description'=>trim($m['description']??''),'is_master'=>1,'version'=>'v1.0','scenario_id'=>$sid,'uploaded_by'=>$uid]);
                Logger::audit('DATASET_UPLOADED','datasets',(string)$id,'SUCCESS',['checksum'=>$stored['checksum_sha256']],$uid);
                return $this->datasetRepo->findById($id);
            });
        } catch(\Throwable $e) { unlink($this->storageDir.'/'.$stored['file_path']); throw $e; }
    }
    public function assignDataset(int $did,int $student,int $admin,?int $tid=null):void {
        $this->requireAdmin($admin);
        if (!$this->datasetRepo->findById($did)) throw new InvalidArgumentException('Dataset does not exist.');
        if (!Database::queryOne("SELECT id FROM users WHERE id=:id AND role='STUDENT' AND status='ACTIVE'",['id'=>$student])) throw new InvalidArgumentException('Active student required.');
        if (!$tid || !Database::queryOne('SELECT id FROM ticket_assignments WHERE ticket_id=:tid AND student_id=:sid',['tid'=>$tid,'sid'=>$student])) throw new InvalidArgumentException('Assign this ticket to the student before assigning its dataset.');
        Database::transaction(function()use($did,$student,$admin,$tid){
            $this->datasetRepo->assignToStudent($did,$student,$admin,$tid);
            Logger::audit('DATASET_ASSIGNED','datasets',(string)$did,'SUCCESS',['student_id'=>$student,'ticket_id'=>$tid],$admin);
        });
    }
    public function uploadProcessedDataset(int $source,int $uid,?int $tid,array $f,array $m):array {
        if (!$tid || !Database::queryOne("SELECT da.id FROM dataset_assignments da JOIN ticket_assignments ta ON ta.ticket_id=da.ticket_id AND ta.student_id=da.student_id JOIN users u ON u.id=da.student_id WHERE da.dataset_id=:did AND da.student_id=:sid AND da.ticket_id=:tid AND u.role='STUDENT' AND u.status='ACTIVE'",['did'=>$source,'sid'=>$uid,'tid'=>$tid])) throw new InvalidArgumentException('The master dataset and ticket must both be assigned to you together.');
        $name=trim($m['name']??$f['name']??'');
        if (!$name || strlen($name)>255) throw new InvalidArgumentException('Valid processed dataset name required.');
        $stored=$this->receive($f);
        try {
            return Database::transaction(function()use($stored,$m,$name,$source,$uid,$tid){
                $id=$this->datasetRepo->createProcessedDataset($stored+['source_dataset_id'=>$source,'student_id'=>$uid,'ticket_id'=>$tid,'name'=>$name,'description'=>trim($m['description']??''),'transformation_notes'=>trim($m['transformation_notes']??'')]);
                Logger::audit('PROCESSED_DATASET_UPLOADED','processed_datasets',(string)$id,'SUCCESS',['source_id'=>$source,'ticket_id'=>$tid],$uid);
                return Database::queryOne('SELECT * FROM processed_datasets WHERE id=:id',['id'=>$id]);
            });
        }catch(\Throwable $e){unlink($this->storageDir.'/'.$stored['file_path']);throw $e;}
    }
}
