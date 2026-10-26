<?php
namespace App\Services;

use App\Repositories\DeploymentRepository;
use App\Core\Database;
use InvalidArgumentException;
use RuntimeException;

class DeploymentService
{
    private DeploymentRepository $deployRepo;
    public function __construct() { $this->deployRepo = new DeploymentRepository(); }
    public function listDeployments(?array $user = null): array
    {
        if (!$user) { throw new \App\Core\AccessDeniedException('Authentication required.'); }
        return $user['role'] === 'ADMIN' ? $this->deployRepo->listAll() : $this->deployRepo->listForStudent((int)$user['id']);
    }
    public function requestDeployment(array $data, int $actorId): array
    {
        $user = Database::queryOne("SELECT role FROM users WHERE id = :id AND status = 'ACTIVE'", ['id' => $actorId]);
        if (!$user) { throw new \App\Core\AccessDeniedException('Authentication required.'); }
        $model = (new ModelService())->getModel((int)($data['model_id'] ?? 0), $actorId, $user['role']);
        $version = Database::queryOne('SELECT * FROM model_versions WHERE id = :id AND model_id = :mid', ['id' => (int)($data['model_version_id'] ?? 0), 'mid' => $model['id']]);
        if (!$version) { throw new InvalidArgumentException('An uploaded artifact version belonging to this model is required.'); }
        throw new \DomainException('Deployment unavailable: no verified inference provider or trusted validation evidence is configured. No endpoint or deployment was created.');
    }
    public function reviewDeployment(int $id, string $decision, int $adminId, ?string $notes = null, ?int $trafficPercent = null): array
    {
        $admin = Database::queryOne("SELECT id FROM users WHERE id = :id AND role = 'ADMIN' AND status = 'ACTIVE'", ['id' => $adminId]);
        if (!$admin) { throw new \App\Core\AccessDeniedException('Administrator access required.'); }
        throw new \DomainException('Deployment unavailable: a database decision cannot deploy a model. Configure and verify an inference provider first.');
    }
}
