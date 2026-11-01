<?php

namespace App\Repositories;

use App\Core\Database;

class UserRepository
{
    public function findById(int $id): ?array
    {
        return Database::queryOne(
            "SELECT id, role, email, full_name, identifier, cohort, department, status, must_change_password, session_version, last_login_at, created_at, updated_at
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
                       (SELECT COUNT(*) FROM ticket_assignments ta WHERE ta.student_id = u.id AND ta.revoked_at IS NULL) as tickets_count,
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
            $sql .= " AND (u.full_name LIKE :search_name OR u.email LIKE :search_email OR u.identifier LIKE :search_identifier)";
            foreach (['search_name','search_email','search_identifier'] as $key) $params[$key] = '%' . $filters['search'] . '%';
        }

        $sql .= " ORDER BY u.created_at DESC,u.id DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

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
            $sql .= " AND (full_name LIKE :search_name OR email LIKE :search_email OR identifier LIKE :search_identifier)";
            foreach (['search_name','search_email','search_identifier'] as $key) $params[$key] = '%' . $filters['search'] . '%';
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

    public function getStudentDossier(int $id,array $query=[]): ?array
    {
        $student=$this->findById($id);
        if(!$student||$student['role']!=='STUDENT')return null;
        $result=['profile'=>$student,'pagination'=>[]];
        $queries=[
            'processed_datasets'=>'SELECT id,name,format,row_count,file_size,created_at FROM processed_datasets WHERE student_id=:id ORDER BY id DESC',
            'notebooks'=>'SELECT id,code,title,version,status,kernel_state,updated_at FROM notebooks WHERE student_id=:id ORDER BY id DESC',
            'experiments'=>'SELECT er.id,er.run_name,er.status,er.metrics,er.duration_seconds,er.created_at,e.name AS experiment_name FROM experiment_runs er JOIN experiments e ON e.id=er.experiment_id WHERE er.student_id=:id ORDER BY er.id DESC',
            'models'=>'SELECT id,model_code,name,framework,current_version,status,updated_at FROM models WHERE student_id=:id ORDER BY id DESC',
            'submissions'=>'SELECT s.id,s.submission_code,s.iteration,s.status,s.total_score,s.reviewed_at,s.created_at,t.ticket_code,t.title AS ticket_title FROM submissions s JOIN tickets t ON t.id=s.ticket_id WHERE s.student_id=:id ORDER BY s.id DESC',
        ];
        foreach(['tickets','datasets',...array_keys($queries)] as $key){
            $paging=\App\Core\Pagination::from(['limit'=>$query['limit']??50,'offset'=>$query[$key.'_offset']??0]);
            $page=match($key){
                'tickets'=>(new TicketRepository())->pageForUser($id,'STUDENT',[],$paging),
                'datasets'=>(new DatasetRepository())->pageForUser($id,'STUDENT',null,$paging),
                default=>\App\Core\Pagination::query($queries[$key],['id'=>$id],$paging)
            };
            $result[$key]=$page['items'];$result['pagination'][$key]=\App\Core\Pagination::metadata($page);
        }
        return $result;
    }
}
