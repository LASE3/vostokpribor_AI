<?php

namespace App\Repositories;

use App\Core\Database;

class DatasetRepository
{
    public function listForUser(int $userId, string $role, ?string $format = null): array
    {
        $params = [];
        if ($role === 'ADMIN') {
            $sql = "SELECT d.*, u.full_name as uploader_name, s.title as scenario_title,
                           (SELECT COUNT(*) FROM dataset_assignments da WHERE da.dataset_id = d.id) as assignments_count
                    FROM datasets d
                    LEFT JOIN users u ON d.uploaded_by = u.id
                    LEFT JOIN scenarios s ON d.scenario_id = s.id
                    WHERE 1=1";
        } else {
            // Student: STRICTLY ONLY assigned datasets
            $sql = "SELECT d.*, u.full_name as uploader_name, s.title as scenario_title,
                           da.created_at as assigned_at, da.ticket_id as assigned_ticket_id
                    FROM datasets d
                    JOIN dataset_assignments da ON d.id = da.dataset_id
                    LEFT JOIN users u ON d.uploaded_by = u.id
                    LEFT JOIN scenarios s ON d.scenario_id = s.id
                    WHERE da.student_id = :student_id";
            $params['student_id'] = $userId;
        }

        if ($format) {
            $sql .= " AND d.format = :fmt";
            $params['fmt'] = strtolower($format);
        }

        $sql .= " ORDER BY d.created_at DESC";
        return Database::query($sql, $params);
    }

    public function findById(int $id): ?array
    {
        return Database::queryOne(
            "SELECT d.*, u.full_name as uploader_name, s.title as scenario_title
             FROM datasets d
             LEFT JOIN users u ON d.uploaded_by = u.id
             LEFT JOIN scenarios s ON d.scenario_id = s.id
             WHERE d.id = :id LIMIT 1",
            ['id' => $id]
        );
    }

    public function findByCode(string $code): ?array
    {
        return Database::queryOne("SELECT * FROM datasets WHERE code = :code LIMIT 1", ['code' => $code]);
    }

    public function isAssignedToStudent(int $datasetId, int $studentId): bool
    {
        $res = Database::queryOne(
            "SELECT id FROM dataset_assignments WHERE dataset_id = :d_id AND student_id = :s_id LIMIT 1",
            ['d_id' => $datasetId, 's_id' => $studentId]
        );
        return $res !== null;
    }

    public function create(array $data): int
    {
        Database::execute(
            "INSERT INTO datasets (code, name, description, format, file_path, file_size, checksum_sha256, row_count, column_count, schema_json, is_master, version, scenario_id, uploaded_by, created_at)
             VALUES (:code, :name, :desc, :fmt, :path, :size, :sha, :rows, :cols, :schema, :master, :ver, :scen_id, :up_by, NOW())",
            [
                'code'     => $data['code'],
                'name'     => $data['name'],
                'desc'     => $data['description'] ?? null,
                'fmt'      => $data['format'],
                'path'     => $data['file_path'],
                'size'     => $data['file_size'],
                'sha'      => $data['checksum_sha256'],
                'rows'     => $data['row_count'],
                'cols'     => $data['column_count'],
                'schema'   => !empty($data['schema_json']) ? json_encode($data['schema_json']) : null,
                'master'   => $data['is_master'] ?? 1,
                'ver'      => $data['version'] ?? 'v1.0',
                'scen_id'  => $data['scenario_id'] ?? null,
                'up_by'    => $data['uploaded_by']
            ]
        );

        return (int)Database::lastInsertId();
    }

    public function assignToStudent(int $datasetId, int $studentId, int $assignedBy, ?int $ticketId = null): void
    {
        Database::execute(
            "INSERT INTO dataset_assignments (dataset_id, student_id, ticket_id, assigned_by, created_at)
             VALUES (:d_id, :s_id, :t_id, :a_by, NOW())
             ON DUPLICATE KEY UPDATE ticket_id = :t_id2, assigned_by = :a_by2",
            [
                'd_id'  => $datasetId,
                's_id'  => $studentId,
                't_id'  => $ticketId,
                'a_by'  => $assignedBy,
                't_id2' => $ticketId,
                'a_by2' => $assignedBy
            ]
        );
    }

    public function createProcessedDataset(array $data): int
    {
        Database::execute(
            "INSERT INTO processed_datasets (source_dataset_id, student_id, ticket_id, name, description, format, file_path, file_size, checksum_sha256, row_count, transformation_notes, created_at)
             VALUES (:src_id, :s_id, :t_id, :name, :desc, :fmt, :path, :size, :sha, :rows, :notes, NOW())",
            [
                'src_id' => $data['source_dataset_id'],
                's_id'   => $data['student_id'],
                't_id'   => $data['ticket_id'] ?? null,
                'name'   => $data['name'],
                'desc'   => $data['description'] ?? null,
                'fmt'    => $data['format'],
                'path'   => $data['file_path'],
                'size'   => $data['file_size'],
                'sha'    => $data['checksum_sha256'],
                'rows'   => $data['row_count'],
                'notes'  => $data['transformation_notes'] ?? null
            ]
        );

        return (int)Database::lastInsertId();
    }

    public function listProcessedForStudent(int $studentId): array
    {
        return Database::query(
            "SELECT pd.*, d.code as source_dataset_code, d.name as source_dataset_name, t.ticket_code
             FROM processed_datasets pd
             JOIN datasets d ON pd.source_dataset_id = d.id
             LEFT JOIN tickets t ON pd.ticket_id = t.id
             WHERE pd.student_id = :s_id
             ORDER BY pd.created_at DESC",
            ['s_id' => $studentId]
        );
    }
}
