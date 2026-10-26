<?php

namespace App\Repositories;

use App\Core\Database;

class UserRepository
{
    public function findById(int $id): ?array
    {
        return Database::queryOne(
            "SELECT id, role, email, full_name, identifier, cohort, department, status, must_change_password, last_login_at, created_at, updated_at
             FROM users WHERE id = :id LIMIT 1",
            ['id' => $id]
        );
    }

    public function findByEmailOrIdentifier(string $login): ?array
    {
        return Database::queryOne(
            "SELECT * FROM users WHERE email = :l1 OR identifier = :l2 LIMIT 1",
            ['l1' => $login, 'l2' => $login]
        );
    }

    public function listStudents(array $filters = [], int $limit = 50, int $offset = 0): array
    {
        $sql = "SELECT u.id, u.role, u.email, u.full_name, u.identifier, u.cohort, u.department, u.status, u.last_login_at, u.created_at,
                       (SELECT COUNT(*) FROM ticket_assignments ta WHERE ta.student_id = u.id) as tickets_count,
                       (SELECT COUNT(*) FROM submissions s WHERE s.student_id = u.id) as submissions_count,
                       (SELECT COUNT(*) FROM notebooks n WHERE n.student_id = u.id) as notebooks_count,
                       (SELECT COUNT(*) FROM models m WHERE m.student_id = u.id) as models_count
                FROM users u
                WHERE u.role = 'STUDENT'";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND u.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['cohort'])) {
            $sql .= " AND u.cohort = :cohort";
            $params['cohort'] = $filters['cohort'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (u.full_name LIKE :search OR u.email LIKE :search OR u.identifier LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        $sql .= " ORDER BY u.created_at DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

        return Database::query($sql, $params);
    }

    public function countStudents(array $filters = []): int
    {
        $sql = "SELECT COUNT(*) as cnt FROM users WHERE role = 'STUDENT'";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['cohort'])) {
            $sql .= " AND cohort = :cohort";
            $params['cohort'] = $filters['cohort'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (full_name LIKE :search OR email LIKE :search OR identifier LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        return (int)Database::queryOne($sql, $params)['cnt'];
    }

    public function createStudent(array $data): int
    {
        Database::execute(
            "INSERT INTO users (role, email, password_hash, full_name, identifier, cohort, department, status, must_change_password, created_at)
             VALUES ('STUDENT', :email, :hash, :name, :identifier, :cohort, :department, :status, :must_change, NOW())",
            [
                'email'        => $data['email'],
                'hash'         => $data['password_hash'],
                'name'         => $data['full_name'],
                'identifier'   => $data['identifier'],
                'cohort'       => $data['cohort'] ?? null,
                'department'   => $data['department'] ?? 'Avionics AI Cadet Cohort',
                'status'       => $data['status'] ?? 'ACTIVE',
                'must_change'  => $data['must_change_password'] ?? 0
            ]
        );

        return (int)Database::lastInsertId();
    }

    public function updateStudent(int $id, array $data): void
    {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['full_name'])) {
            $fields[] = "full_name = :full_name";
            $params['full_name'] = $data['full_name'];
        }
        if (isset($data['email'])) {
            $fields[] = "email = :email";
            $params['email'] = $data['email'];
        }
        if (isset($data['cohort'])) {
            $fields[] = "cohort = :cohort";
            $params['cohort'] = $data['cohort'];
        }
        if (isset($data['department'])) {
            $fields[] = "department = :department";
            $params['department'] = $data['department'];
        }
        if (isset($data['status'])) {
            $fields[] = "status = :status";
            $params['status'] = $data['status'];
        }
        if (isset($data['password_hash'])) {
            $fields[] = "password_hash = :password_hash";
            $params['password_hash'] = $data['password_hash'];
        }
        if (isset($data['must_change_password'])) {
            $fields[] = "must_change_password = :must_change_password";
            $params['must_change_password'] = $data['must_change_password'];
        }

        if (!empty($fields)) {
            $sql = "UPDATE users SET " . implode(', ', $fields) . ", updated_at = NOW() WHERE id = :id AND role = 'STUDENT'";
            Database::execute($sql, $params);
        }
    }

    public function getStudentDossier(int $id): ?array
    {
        $student = $this->findById($id);
        if (!$student || $student['role'] !== 'STUDENT') {
            return null;
        }

        // Assigned Tickets
        $tickets = Database::query(
            "SELECT t.id, t.ticket_code, t.title, t.priority, t.status, t.deadline, ta.assigned_at, s.title as scenario_title
             FROM ticket_assignments ta
             JOIN tickets t ON ta.ticket_id = t.id
             LEFT JOIN scenarios s ON t.scenario_id = s.id
             WHERE ta.student_id = :id
             ORDER BY ta.assigned_at DESC",
            ['id' => $id]
        );

        // Assigned Datasets
        $datasets = Database::query(
            "SELECT d.id, d.code, d.name, d.format, d.file_size, d.version, da.created_at as assigned_at
             FROM dataset_assignments da
             JOIN datasets d ON da.dataset_id = d.id
             WHERE da.student_id = :id
             ORDER BY da.created_at DESC",
            ['id' => $id]
        );

        // Processed Datasets
        $processedDatasets = Database::query(
            "SELECT id, name, format, row_count, file_size, created_at
             FROM processed_datasets
             WHERE student_id = :id
             ORDER BY created_at DESC",
            ['id' => $id]
        );

        // Notebooks
        $notebooks = Database::query(
            "SELECT id, code, title, version, status, kernel_state, updated_at
             FROM notebooks
             WHERE student_id = :id
             ORDER BY updated_at DESC",
            ['id' => $id]
        );

        // Experiment Runs
        $experiments = Database::query(
            "SELECT er.id, er.run_name, er.status, er.metrics, er.duration_seconds, er.created_at, e.name as experiment_name
             FROM experiment_runs er
             JOIN experiments e ON er.experiment_id = e.id
             WHERE er.student_id = :id
             ORDER BY er.created_at DESC",
            ['id' => $id]
        );

        // Registered Models
        $models = Database::query(
            "SELECT id, model_code, name, framework, current_version, status, updated_at
             FROM models
             WHERE student_id = :id
             ORDER BY updated_at DESC",
            ['id' => $id]
        );

        // Submissions
        $submissions = Database::query(
            "SELECT s.id, s.submission_code, s.iteration, s.status, s.total_score, s.reviewed_at, s.created_at, t.ticket_code, t.title as ticket_title
             FROM submissions s
             JOIN tickets t ON s.ticket_id = t.id
             WHERE s.student_id = :id
             ORDER BY s.created_at DESC",
            ['id' => $id]
        );

        return [
            'profile'            => $student,
            'tickets'            => $tickets,
            'datasets'           => $datasets,
            'processed_datasets' => $processedDatasets,
            'notebooks'          => $notebooks,
            'experiments'        => $experiments,
            'models'             => $models,
            'submissions'        => $submissions,
        ];
    }
}
