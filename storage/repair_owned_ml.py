from pathlib import Path
p=Path('app/Repositories/ModelRepository.php')
s=p.read_text()
s=s.replace("$data['framework'] ?? 'XGBoost 1.7.5'", "$data['framework'] ?? ''")
a=s.index('    public function addVersion(')
b=s.index('    public function findVersionById', a)
s=s[:a]+'''    public function addVersion(int $modelId, array $data): int
    {
        Database::execute(
            "INSERT INTO model_versions (model_id, version, artifact_path, artifact_format, checksum_sha256, file_size, metrics, status) VALUES (:mid,:ver,:path,:fmt,:sha,:size,:metrics,'REGISTERED')",
            ['mid' => $modelId, 'ver' => $data['version'], 'path' => $data['artifact_path'], 'fmt' => $data['artifact_format'], 'sha' => $data['checksum_sha256'], 'size' => $data['file_size'], 'metrics' => isset($data['metrics']) ? json_encode($data['metrics'], JSON_THROW_ON_ERROR) : null]
        );
        $id = (int)Database::lastInsertId();
        Database::execute('UPDATE models SET current_version = :ver, updated_at = NOW() WHERE id = :id', ['ver' => $data['version'], 'id' => $modelId]);
        return $id;
    }

'''+s[b:]
p.write_text(s)
p=Path('app/Services/ExperimentService.php');s=p.read_text();s=s.replace("        $id = $this->expRepo->createExperiment([", "        $ticketId = !empty($data['ticket_id']) ? (int)$data['ticket_id'] : null;\n        $scenarioId = WorkOwnership::ticket($ticketId, $studentId, !empty($data['scenario_id']) ? (int)$data['scenario_id'] : null);\n        $id = $this->expRepo->createExperiment([");s=s.replace("'ticket_id'   => !empty($data['ticket_id']) ? (int)$data['ticket_id'] : null", "'ticket_id'   => $ticketId").replace("'scenario_id' => !empty($data['scenario_id']) ? (int)$data['scenario_id'] : null", "'scenario_id' => $scenarioId");s=s.replace("        $runUuid = $this->expRepo->recordRun([", "        WorkOwnership::owned('experiments', (int)$data['experiment_id'], $studentId);\n        if (!empty($data['notebook_id'])) { WorkOwnership::owned('notebooks', (int)$data['notebook_id'], $studentId); }\n        $runUuid = $this->expRepo->recordRun([");s=s.replace("'status'           => $data['status'] ?? 'COMPLETED'", "'status'           => 'RECORDED'");s=s.replace("'artifacts'        => $data['artifacts'] ?? []", "'artifacts'        => []");s=s.replace("'duration_seconds' => !empty($data['duration_seconds']) ? (float)$data['duration_seconds'] : null", "'duration_seconds' => null");p.write_text(s)
p=Path('app/Repositories/ExperimentRepository.php');s=p.read_text().replace("$data['status'] ?? 'COMPLETED'", "'RECORDED'");p.write_text(s)
p=Path('app/Controllers/ValidationController.php');s=p.read_text().replace("'Automated validation checks executed'", "'Artifact integrity checked; quality NOT_EVALUATED without a trusted evaluator'");p.write_text(s)
