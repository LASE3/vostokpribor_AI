<?php
namespace App\Services;

use App\Repositories\ModelRepository;
use App\Repositories\ValidationRepository;
use App\Core\Database;
use App\Core\Logger;
use InvalidArgumentException;
use RuntimeException;

class ValidationService
{
    private ModelRepository $modelRepo;
    private ValidationRepository $valRepo;
    public function __construct() { $this->modelRepo = new ModelRepository(); $this->valRepo = new ValidationRepository(); }
    public function runValidation(int $modelId, int $modelVersionId, int $actorId): array
    {
        $user = Database::queryOne("SELECT role FROM users WHERE id = :id AND status = 'ACTIVE'", ['id' => $actorId]);
        if (!$user) { throw new \App\Core\AccessDeniedException('Access denied.'); }
        $model = (new ModelService())->getModel($modelId, $actorId, $user['role']);
        $version = $this->modelRepo->findVersionById($modelVersionId);
        if (!$version || (int)$version['model_id'] !== $modelId) { throw new InvalidArgumentException('A genuine artifact version belonging to this model is required.'); }
        $path = dirname(__DIR__, 2) . '/storage/private/models/' . basename($version['artifact_path']);
        if (!is_file($path) || filesize($path) < 1 || !hash_equals((string)$version['checksum_sha256'], (string)hash_file('sha256', $path))) {
            throw new InvalidArgumentException('Artifact is absent, empty, or its checksum does not match. Validation was not performed.');
        }
        // The application has no trusted isolated evaluator. Student-supplied metrics, extension,
        // and successful file integrity checks cannot prove quality, inference, or serialization safety.
        $report = [
            'model_id' => $modelId, 'model_code' => $model['model_code'], 'version' => $version['version'],
            'overall_status' => 'NOT_EVALUATED', 'score_percent' => null,
            'checks_passed' => 1, 'checks_total' => 4,
            'measurement_provenance' => 'NO_TRUSTED_EVALUATOR',
            'checks' => [
                ['name' => 'Artifact integrity', 'status' => 'PASSED', 'passed' => true, 'details' => 'Stored file exists and its SHA-256 checksum matches the upload record.'],
                ['name' => 'Serialization safety', 'status' => 'NOT_EVALUATED', 'passed' => null, 'details' => 'Artifact is stored as opaque bytes. Extension does not establish serialization safety.'],
                ['name' => 'Inference latency', 'status' => 'NOT_EVALUATED', 'passed' => null, 'details' => 'No trusted isolated benchmark is deployed. User-reported metrics are not accepted as evidence.'],
                ['name' => 'Predictive quality', 'status' => 'INCOMPLETE', 'passed' => null, 'details' => 'No trusted evaluation result bound to this artifact checksum and assigned holdout dataset exists.']
            ],
            'executed_at' => date('Y-m-d H:i:s')
        ];
        return Database::transaction(function () use ($modelId, $modelVersionId, $actorId, $report) {
            $id = $this->valRepo->createRun(['model_id' => $modelId, 'model_version_id' => $modelVersionId, 'requested_by' => $actorId, 'status' => 'NOT_EVALUATED', 'score' => null, 'checks_passed' => 1, 'checks_total' => 4, 'report_json' => $report, 'completed_at' => date('Y-m-d H:i:s')]);
            $this->modelRepo->updateStatus($modelId, 'VALIDATION_PENDING');
            Logger::audit('MODEL_VALIDATION_NOT_EVALUATED', 'validation_runs', (string)$id, 'SUCCESS', ['model_id' => $modelId, 'provenance' => 'NO_TRUSTED_EVALUATOR'], $actorId);
            return $this->valRepo->findById($id);
        });
    }
    public function getRun(int $id, ?int $userId = null, ?string $role = null): array
    {
        $run = $this->valRepo->findById($id);
        if (!$run) { throw new RuntimeException('Validation report not found.'); }
        if ($userId === null || ($role !== 'ADMIN' && (int)$run['model_owner_id'] !== $userId)) { throw new \App\Core\AccessDeniedException('Access Denied: validation report is not yours.'); }
        return $run;
    }
}
