<?php
namespace App\Services;

use App\Core\Database;
use App\Core\Logger;
use App\Repositories\ScenarioRepository;
use InvalidArgumentException;
use RuntimeException;

class ScenarioService
{
    public const TRANSITIONS = [
        'DRAFT' => ['READY_FOR_REVIEW', 'ARCHIVED'],
        'READY_FOR_REVIEW' => ['DRAFT', 'PUBLISHED', 'ARCHIVED'],
        'PUBLISHED' => ['ACTIVE', 'DRAFT', 'ARCHIVED'],
        'ACTIVE' => ['COMPLETED', 'PUBLISHED', 'ARCHIVED'],
        'COMPLETED' => ['ACTIVE', 'ARCHIVED'],
        'ARCHIVED' => ['DRAFT'],
    ];
    private ScenarioRepository $scenarioRepo;
    public function __construct() { $this->scenarioRepo = new ScenarioRepository(); }
    public function listAll(?string $status = null): array
    {
        if ($status !== null && !isset(self::TRANSITIONS[$status])) throw new InvalidArgumentException('Unsupported scenario status.');
        return $this->scenarioRepo->listAll($status);
    }
    public function getScenario(int $id): array
    {
        return $this->scenarioRepo->findById($id) ?? throw new \App\Core\NotFoundException('Scenario not found.');
    }
    private function administrator(int $id): array
    {
        return Database::queryOne("SELECT id, full_name FROM users WHERE id=:id AND role='ADMIN' AND status='ACTIVE'", ['id'=>$id])
            ?? throw new RuntimeException('Administrator access required.');
    }
    private function validate(array $data, ?array $previous = null): array
    {
        $merged = array_merge($previous ?? [], $data);
        foreach (['code'=>64, 'title'=>255, 'difficulty'=>32, 'department'=>120, 'version'=>32] as $key=>$limit) {
            $value = $merged[$key] ?? match ($key) { 'difficulty'=>'Level 1', 'department'=>'', 'version'=>'v1.0', default=>'' };
            if (!is_string($value) || strlen(trim($value)) > $limit || (in_array($key,['code','title']) && strlen(trim($value)) < 3)) throw new InvalidArgumentException('Invalid '.$key.'.');
            $merged[$key] = trim($value);
        }
        $merged['code'] = strtoupper($merged['code']);
        if (!preg_match('/^[A-Z0-9][A-Z0-9_.-]{2,63}$/D', $merged['code'])) throw new InvalidArgumentException('Code must use letters, digits, dot, underscore or hyphen.');
        if ($previous && $merged['code'] !== $previous['code']) throw new InvalidArgumentException('Scenario code cannot change; duplicate to create a new code.');
        foreach (['description','objectives','acceptance_criteria'] as $key) {
            if (isset($merged[$key]) && (!is_string($merged[$key]) || strlen($merged[$key]) > 60000)) throw new InvalidArgumentException('Invalid '.$key.'.');
            $merged[$key] = $merged[$key] ?? '';
        }
        $status = $merged['status'] ?? 'DRAFT';
        if (!is_string($status) || !isset(self::TRANSITIONS[$status])) throw new InvalidArgumentException('Unsupported scenario status.');
        if ($previous && $status !== $previous['status'] && !in_array($status,self::TRANSITIONS[$previous['status']],true)) throw new InvalidArgumentException('Invalid scenario lifecycle transition.');
        // Imported/new records always begin as a draft; lifecycle approval is explicit.
        if (!$previous && $status !== 'DRAFT') throw new InvalidArgumentException('New scenarios must start in DRAFT.');
        $merged['status'] = $status;
        $metadata = $merged['builder_metadata'] ?? ['schema_version'=>1,'form_fields'=>[],'datasets'=>[],'workflow'=>[]];
        if (is_string($metadata)) {
            try { $metadata = json_decode($metadata,true,32,JSON_THROW_ON_ERROR); }
            catch (\JsonException $e) { throw new InvalidArgumentException('Builder metadata contains invalid JSON.'); }
        }
        if (!is_array($metadata) || array_is_list($metadata) || strlen(json_encode($metadata,JSON_THROW_ON_ERROR)) > 200000) throw new InvalidArgumentException('Builder metadata must be an object of at most 200 KB.');
        if (isset($metadata['form_fields']) && !is_array($metadata['form_fields'])) throw new InvalidArgumentException('Builder fields must be an object.');
        foreach (($metadata['form_fields'] ?? []) as $key=>$value) {
            if (!is_string($key) || !preg_match('/^(edit-|dim-weight-|deliv-|int-sys-)/',$key) || (!is_scalar($value) && $value !== null) || (is_string($value) && strlen($value)>60000)) throw new InvalidArgumentException('Invalid builder field.');
        }
        foreach (['edit-start-date','edit-deadline'] as $dateField) {
            $date=$metadata['form_fields'][$dateField]??'';
            if ($date!=='') {
                if (!is_string($date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/D',$date)) throw new InvalidArgumentException('Invalid publication date.');
                $parsedDate=\DateTimeImmutable::createFromFormat('!Y-m-d',$date);
                if (!$parsedDate || $parsedDate->format('Y-m-d')!==$date) throw new InvalidArgumentException('Invalid publication date.');
            }
        }
        $start=$metadata['form_fields']['edit-start-date']??'';$deadline=$metadata['form_fields']['edit-deadline']??'';
        if ($start && $deadline && $deadline<$start) throw new InvalidArgumentException('Publication deadline precedes start date.');
        if (isset($metadata['datasets']) && !is_array($metadata['datasets'])) throw new InvalidArgumentException('Datasets must be an array.');
        foreach (($metadata['datasets'] ?? []) as $dataset) {
            foreach (['name','role','access','version'] as $field) if (isset($dataset[$field]) && (!is_string($dataset[$field]) || strlen($dataset[$field])>255)) throw new InvalidArgumentException('Invalid dataset specification.');
            if (!is_array($dataset) || empty($dataset['id']) || !Database::queryOne('SELECT id FROM datasets WHERE id=:id',['id'=>(int)$dataset['id']])) throw new InvalidArgumentException('Select an existing uploaded dataset.');
        }
        if (isset($metadata['workflow']) && !is_array($metadata['workflow'])) throw new InvalidArgumentException('Workflow must be an array.');
        foreach (($metadata['workflow'] ?? []) as $stage) {
            if (!is_array($stage) || !is_string($stage['action'] ?? '') || strlen($stage['action'] ?? '')>10000) throw new InvalidArgumentException('Invalid workflow stage.');
        }
        $weights = [];
        foreach (($metadata['form_fields'] ?? []) as $key=>$value) if (str_starts_with($key,'dim-weight-')) {
            if (!is_numeric($value) || (float)$value < 0 || (float)$value > 100) throw new InvalidArgumentException('Invalid rubric weight.');
            $weights[]=(float)$value;
        }
        if (in_array($status,['PUBLISHED','ACTIVE','COMPLETED'],true) && count($weights)>0 && abs(array_sum($weights)-100)>0.001) throw new InvalidArgumentException('Published rubric weights must total 100.');
        $metadata['schema_version'] = 1;
        unset($metadata['versionHistory'], $metadata['ticketsCount'], $metadata['studentsCount']);
        $merged['builder_metadata'] = $metadata;
        return $merged;
    }
    public function createScenario(array $data, int $authorId): array
    {
        $author = $this->administrator($authorId);
        $data = $this->validate($data);
        if ($this->scenarioRepo->findByCode($data['code'])) throw new InvalidArgumentException('A scenario with this code already exists.');
        $data['author_id']=$authorId;
        $data['builder_metadata']['history']=[['version'=>$data['version'],'author'=>$author['full_name'],'actor_id'=>$authorId,'date'=>gmdate('c'),'changelog'=>trim((string)($data['changelog']??'Created'))]];
        return Database::transaction(function() use($data,$authorId) {
            $id=$this->scenarioRepo->create($data);
            Logger::audit('SCENARIO_CREATED','scenarios',(string)$id,'SUCCESS',['code'=>$data['code']],$authorId);
            return $this->getScenario($id);
        });
    }
    public function updateScenario(int $id, array $data, int $actorId): array
    {
        $author=$this->administrator($actorId);
        $previous=$this->getScenario($id);
        $data=$this->validate($data,$previous);
        $data['builder_metadata']['history']=$previous['builder_metadata']['history']??[];
        array_unshift($data['builder_metadata']['history'],['version'=>$data['version'],'author'=>$author['full_name'],'actor_id'=>$actorId,'date'=>gmdate('c'),'changelog'=>trim((string)($data['changelog']??'Updated'))]);
        $data['builder_metadata']['history']=array_slice($data['builder_metadata']['history'],0,100);
        return Database::transaction(function() use($id,$data,$actorId) {
            $this->scenarioRepo->update($id,$data);
            Logger::audit('SCENARIO_UPDATED','scenarios',(string)$id,'SUCCESS',['status'=>$data['status']],$actorId);
            return $this->getScenario($id);
        });
    }
}
