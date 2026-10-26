<?php

namespace App\Services;

use App\Repositories\ModelRepository;
use App\Core\Logger;
use App\Core\Validator;
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
        if (!is_dir($this->storageDir)) {
            mkdir($this->storageDir, 0755, true);
        }
    }

    public function listModels(int $userId, string $role, ?string $status = null): array
    {
        return $this->modelRepo->listForUser($userId, $role, $status);
    }

    public function getModel(int $id, int $userId, string $role): array
    {
        $model = $this->modelRepo->findById($id);
        if (!$model) {
            throw new RuntimeException('Model record not found.');
        }

        if ($role !== 'ADMIN' && (int)$model['student_id'] !== $userId) {
            throw new RuntimeException('Access denied. You do not own this model registration.');
        }

        return $model;
    }

    public function registerModel(array $data, int $studentId): array
    {
        $validator = new Validator();
        $valid = $validator->validate($data, [
            'model_code' => 'required|string|min:3|max:64',
            'name'       => 'required|string|min:2|max:255',
            'framework'  => 'required|string|min:2|max:64'
        ]);

        if (!$valid) {
            throw new InvalidArgumentException($validator->getFirstError() ?? 'Validation failed.');
        }

        $code = strtoupper(trim($data['model_code']));
        if ($this->modelRepo->findByCode($code)) {
            throw new InvalidArgumentException('Model code is already registered.');
        }

        $modelId = $this->modelRepo->create([
            'model_code'        => $code,
            'name'              => trim($data['name']),
            'framework'         => trim($data['framework']),
            'student_id'        => $studentId,
            'ticket_id'         => !empty($data['ticket_id']) ? (int)$data['ticket_id'] : null,
            'scenario_id'       => !empty($data['scenario_id']) ? (int)$data['scenario_id'] : null,
            'experiment_run_id' => !empty($data['experiment_run_id']) ? (int)$data['experiment_run_id'] : null,
            'current_version'   => $data['version'] ?? 'v1.0.0',
            'status'            => 'REGISTERED',
            'description'       => trim($data['description'] ?? ''),
            'metadata_json'     => $data['metadata'] ?? []
        ]);

        Logger::audit('MODEL_REGISTERED', 'models', (string)$modelId, 'SUCCESS', [
            'code' => $code,
            'name' => $data['name']
        ], $studentId);

        return $this->modelRepo->findById($modelId);
    }

    public function addVersion(int $modelId, array $fileInfo, array $metadata, int $userId, string $role): array
    {
        $model = $this->getModel($modelId, $userId, $role);

        if (empty($fileInfo['tmp_name']) || !file_exists($fileInfo['tmp_name'])) {
            throw new InvalidArgumentException('Missing model artifact file.');
        }

        $ext = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
        // Disallow arbitrary executable or unsafe formats
        $allowed = ['onnx', 'joblib', 'json', 'pt', 'bin'];
        if (!in_array($ext, $allowed)) {
            throw new InvalidArgumentException("Unsupported model artifact format [.$ext]. Approved formats: " . implode(', ', $allowed));
        }

        $version = trim($metadata['version'] ?? 'v' . date('Ymd.His'));
        $storageFilename = 'mod_' . $model['id'] . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $version) . '.' . $ext;
        $targetPath = $this->storageDir . '/' . $storageFilename;

        if (!move_uploaded_file($fileInfo['tmp_name'], $targetPath)) {
            copy($fileInfo['tmp_name'], $targetPath);
        }

        $sha256 = hash_file('sha256', $targetPath);
        $fileSize = filesize($targetPath);

        $versionId = $this->modelRepo->addVersion($modelId, [
            'version'         => $version,
            'artifact_path'   => $storageFilename,
            'artifact_format' => $ext,
            'checksum_sha256' => $sha256,
            'file_size'       => $fileSize,
            'metrics'         => $metadata['metrics'] ?? null,
            'status'          => 'REGISTERED'
        ]);

        Logger::audit('MODEL_VERSION_ADDED', 'model_versions', (string)$versionId, 'SUCCESS', [
            'model_id' => $modelId,
            'version'  => $version,
            'sha256'   => $sha256
        ], $userId);

        return [
            'id'       => $versionId,
            'model_id' => $modelId,
            'version'  => $version,
            'format'   => $ext,
            'sha256'   => $sha256
        ];
    }
}
