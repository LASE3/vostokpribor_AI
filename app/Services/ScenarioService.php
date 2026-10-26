<?php

namespace App\Services;

use App\Repositories\ScenarioRepository;
use App\Core\Logger;
use App\Core\Validator;
use InvalidArgumentException;
use RuntimeException;

class ScenarioService
{
    private ScenarioRepository $scenarioRepo;

    public function __construct()
    {
        $this->scenarioRepo = new ScenarioRepository();
    }

    public function listAll(?string $status = null): array
    {
        return $this->scenarioRepo->listAll($status);
    }

    public function getScenario(int $id): array
    {
        $scenario = $this->scenarioRepo->findById($id);
        if (!$scenario) {
            throw new RuntimeException('Scenario blueprint not found.');
        }
        return $scenario;
    }

    public function createScenario(array $data, int $authorId): array
    {
        $validator = new Validator();
        $valid = $validator->validate($data, [
            'code'  => 'required|string|min:3|max:64',
            'title' => 'required|string|min:3|max:255'
        ]);

        if (!$valid) {
            throw new InvalidArgumentException($validator->getFirstError() ?? 'Validation failed.');
        }

        if ($this->scenarioRepo->findByCode($data['code'])) {
            throw new InvalidArgumentException('A scenario with this code already exists.');
        }

        $createData = [
            'code'                => strtoupper(trim($data['code'])),
            'title'               => trim($data['title']),
            'description'         => trim($data['description'] ?? ''),
            'difficulty'          => $data['difficulty'] ?? 'Level 1',
            'department'          => $data['department'] ?? 'Flight Operations Data Core',
            'status'              => $data['status'] ?? 'PUBLISHED',
            'version'             => $data['version'] ?? 'v1.0',
            'objectives'          => $data['objectives'] ?? null,
            'acceptance_criteria' => $data['acceptance_criteria'] ?? null,
            'author_id'           => $authorId
        ];

        $scenarioId = $this->scenarioRepo->create($createData);

        Logger::audit('SCENARIO_CREATED', 'scenarios', (string)$scenarioId, 'SUCCESS', [
            'code'  => $createData['code'],
            'title' => $createData['title']
        ], $authorId);

        return $this->scenarioRepo->findById($scenarioId);
    }

    public function updateScenario(int $id, array $data, int $actorId): array
    {
        $scenario = $this->scenarioRepo->findById($id);
        if (!$scenario) {
            throw new RuntimeException('Scenario not found.');
        }

        $this->scenarioRepo->update($id, $data);

        Logger::audit('SCENARIO_UPDATED', 'scenarios', (string)$id, 'SUCCESS', array_keys($data), $actorId);

        return $this->scenarioRepo->findById($id);
    }
}
