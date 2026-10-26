<?php

namespace App\Services;

use App\Repositories\ModelRepository;
use App\Repositories\DeploymentRepository;
use App\Core\Logger;
use App\Core\Validator;
use InvalidArgumentException;
use RuntimeException;

class DeploymentService
{
    private ModelRepository $modelRepo;
    private DeploymentRepository $deployRepo;

    public function __construct()
    {
        $this->modelRepo = new ModelRepository();
        $this->deployRepo = new DeploymentRepository();
    }

    public function listDeployments(?array $user = null): array
    {
        if ($user && ($user['role'] ?? '') === 'STUDENT') {
            return $this->deployRepo->listForStudent((int)$user['id']);
        }
        return $this->deployRepo->listAll();
    }

    public function requestDeployment(array $data, int $actorId): array
    {
        $validator = new Validator();
        $valid = $validator->validate($data, [
            'model_id'         => 'required|integer',
            'model_version_id' => 'required|integer',
            'environment'      => 'in:canary,staging,production',
            'canary_percentage' => 'integer'
        ]);

        if (!$valid) {
            throw new InvalidArgumentException($validator->getFirstError() ?? 'Validation failed.');
        }

        $modelId = (int)$data['model_id'];
        $model = $this->modelRepo->findById($modelId);
        if (!$model) {
            throw new RuntimeException('Model not found.');
        }

        // Verify model ownership
        $userRepo = new \App\Repositories\UserRepository();
        $user = $userRepo->findById($actorId);
        $role = $user['role'] ?? 'STUDENT';
        if ($role !== 'ADMIN' && (int)$model['student_id'] !== $actorId) {
            throw new RuntimeException('Access Denied: You do not own this candidate model.');
        }

        // Check that model has passed validation
        if (!in_array($model['status'], ['VALIDATION_PASSED', 'APPROVED', 'DEPLOYED'])) {
            throw new RuntimeException('Model must successfully pass automated validation before requesting deployment.');
        }

        $endpointUrl = "/api/v1/models/" . strtolower($model['model_code']) . "/infer";

        $reqId = $this->deployRepo->createRequest([
            'model_id'          => $modelId,
            'model_version_id'  => (int)$data['model_version_id'],
            'requested_by'      => $actorId,
            'environment'       => $data['environment'] ?? 'canary',
            'canary_percentage' => isset($data['canary_percentage']) ? (int)$data['canary_percentage'] : 10,
            'replicas'          => isset($data['replicas']) ? (int)$data['replicas'] : 1,
            'endpoint_url'      => $endpointUrl
        ]);

        $this->modelRepo->updateStatus($modelId, 'DEPLOYMENT_PENDING');

        Logger::audit('DEPLOYMENT_REQUESTED', 'deployment_requests', (string)$reqId, 'SUCCESS', [
            'model_code' => $model['model_code']
        ], $actorId);

        return $this->deployRepo->findById($reqId);
    }

    public function reviewDeployment(int $id, string $decision, int $adminId, ?string $notes = null, ?int $trafficPercent = null): array
    {
        $req = $this->deployRepo->findById($id);
        if (!$req) {
            throw new RuntimeException('Deployment request not found.');
        }

        if (!in_array($decision, ['APPROVED', 'REJECTED', 'DEPLOYED', 'ROLLED_BACK'])) {
            throw new InvalidArgumentException('Invalid deployment decision status.');
        }

        $status = ($decision === 'APPROVED' || $decision === 'DEPLOYED') ? 'DEPLOYED' : $decision;
        $this->deployRepo->updateStatus($id, $status, $adminId, $notes, $trafficPercent);

        if ($status === 'DEPLOYED') {
            $this->modelRepo->updateStatus((int)$req['model_id'], 'DEPLOYED');
        } elseif ($status === 'REJECTED') {
            $this->modelRepo->updateStatus((int)$req['model_id'], 'REJECTED');
        }

        Logger::audit('DEPLOYMENT_DECISION', 'deployment_requests', (string)$id, 'SUCCESS', [
            'decision' => $status,
            'traffic'  => $trafficPercent
        ], $adminId);

        return $this->deployRepo->findById($id);
    }
}
