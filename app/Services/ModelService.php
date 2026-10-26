<?php
namespace App\Services;

use App\Repositories\ModelRepository;
use App\Core\Database;
use App\Core\Env;
use App\Core\Logger;
use InvalidArgumentException;
use RuntimeException;

class ModelService
{
    private ModelRepository $modelRepo;
    private string $storageDir;
    public function __construct()
    {
        $this->modelRepo = new ModelRepository();
        $this->storageDir = dirname(__DIR__, 2) . '/storage/private/models';
    }
    public function listModels(int $userId, string $role, ?string $status = null): array { return $this->modelRepo->listForUser($userId, $role, $status); }
    public function getModel(int $id, int $userId, string $role): array
    {
        $model = $this->modelRepo->findById($id);
        if (!$model || ($role !== 'ADMIN' && (int)$model['student_id'] !== $userId)) { throw new \App\Core\AccessDeniedException('Model not found or access denied.'); }
        return $model;
    }
    public function registerModel(array $data, int $studentId): array
    {
        $code = strtoupper(trim((string)($data['model_code'] ?? '')));
        $name = trim((string)($data['name'] ?? ''));
        $framework = trim((string)($data['framework'] ?? ''));
        if (!preg_match('/^[A-Z0-9][A-Z0-9_.-]{2,63}$/D', $code) || strlen($name) < 2 || strlen($name) > 255 || strlen($framework) < 2 || strlen($framework) > 64) {
            throw new InvalidArgumentException('Model requires a unique 3-64 character code, a name, and a framework.');
        }
        if ($this->modelRepo->findByCode($code)) { throw new InvalidArgumentException('Model code is already registered.'); }
        $ticketId = !empty($data['ticket_id']) ? (int)$data['ticket_id'] : null;
        $scenarioId = WorkOwnership::ticket($ticketId, $studentId, !empty($data['scenario_id']) ? (int)$data['scenario_id'] : null);
        $runId = !empty($data['experiment_run_id']) ? (int)$data['experiment_run_id'] : null;
        if ($runId) { WorkOwnership::owned('experiment_runs', $runId, $studentId); }
        return Database::transaction(function () use ($data, $code, $name, $framework, $studentId, $ticketId, $scenarioId, $runId) {
            $id = $this->modelRepo->create(['model_code' => $code, 'name' => $name, 'framework' => $framework, 'student_id' => $studentId, 'ticket_id' => $ticketId, 'scenario_id' => $scenarioId, 'experiment_run_id' => $runId, 'current_version' => '', 'status' => 'REGISTERED', 'description' => trim((string)($data['description'] ?? '')), 'metadata_json' => $data['metadata'] ?? []]);
            Logger::audit('MODEL_REGISTERED', 'models', (string)$id, 'SUCCESS', ['code' => $code, 'artifact_uploaded' => false], $studentId);
            return $this->modelRepo->findById($id);
        });
    }
    public function addVersion(int $modelId, array $fileInfo, array $metadata, int $userId, string $role): array
    {
        $model = $this->getModel($modelId, $userId, $role);
        if (($fileInfo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || empty($fileInfo['tmp_name']) || !is_uploaded_file($fileInfo['tmp_name'])) {
            throw new InvalidArgumentException('A genuine HTTP-uploaded model artifact is required.');
        }
        $size = filesize($fileInfo['tmp_name']);
        $limit = max(1, (int)Env::get('MAX_UPLOAD_SIZE_MB', 50)) * 1024 * 1024;
        if ($size === false || $size < 1 || $size > $limit) { throw new InvalidArgumentException('Artifact is empty or exceeds the upload limit.'); }
        $ext = strtolower(pathinfo((string)$fileInfo['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['onnx','joblib','json','pt','bin'], true)) { throw new InvalidArgumentException('Unsupported artifact format.'); }
        // These are accepted as opaque files, never deserialized or certified safe by extension.
        if ($ext === 'json') {
            json_decode((string)file_get_contents($fileInfo['tmp_name']), true);
            if (json_last_error() !== JSON_ERROR_NONE) { throw new InvalidArgumentException('JSON artifact is invalid JSON.'); }
        }
        $version = trim((string)($metadata['version'] ?? ''));
        if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9_.-]{0,31}$/D', $version)) { throw new InvalidArgumentException('Version must contain 1-32 letters, digits, dots, hyphens, or underscores.'); }
        if (Database::queryOne('SELECT id FROM model_versions WHERE model_id = :id AND version = :ver', ['id' => $modelId, 'ver' => $version])) { throw new InvalidArgumentException('This version already exists. Upload a new immutable version.'); }
        if (!is_dir($this->storageDir) && !mkdir($this->storageDir, 0700, true)) { throw new RuntimeException('Private model storage is unavailable.'); }
        $filename = 'mod_' . $modelId . '_' . bin2hex(random_bytes(16)) . '.' . $ext;
        $path = $this->storageDir . '/' . $filename;
        if (!move_uploaded_file($fileInfo['tmp_name'], $path)) { throw new RuntimeException('Artifact could not be stored.'); }
        try {
            return Database::transaction(function () use ($modelId, $metadata, $version, $filename, $path, $ext, $size, $userId) {
                $sha = hash_file('sha256', $path);
                $metrics = $metadata['metrics'] ?? null;
                if (is_string($metrics)) { $metrics = json_decode($metrics, true, 32, JSON_THROW_ON_ERROR); }
                $id = $this->modelRepo->addVersion($modelId, ['version' => $version, 'artifact_path' => $filename, 'artifact_format' => $ext, 'checksum_sha256' => $sha, 'file_size' => $size, 'metrics' => $metrics, 'status' => 'REGISTERED']);
                $this->modelRepo->updateStatus($modelId, 'REGISTERED');
                Logger::audit('MODEL_VERSION_ADDED', 'model_versions', (string)$id, 'SUCCESS', ['model_id' => $modelId, 'version' => $version, 'sha256' => $sha, 'metrics_provenance' => 'USER_REPORTED_UNTRUSTED'], $userId);
                return ['id' => $id, 'model_id' => $modelId, 'version' => $version, 'format' => $ext, 'sha256' => $sha, 'file_size' => $size];
            });
        } catch (\Throwable $e) {
            if (is_file($path)) { unlink($path); }
            throw $e;
        }
    }
}
