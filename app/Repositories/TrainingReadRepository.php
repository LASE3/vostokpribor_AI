<?php
namespace App\Repositories;
use App\Core\Database;
class TrainingReadRepository {
    public function studentActivity(int $id):array {return Database::query('SELECT id,action,resource_type,resource_id,outcome,created_at FROM audit_logs WHERE actor_id=:id ORDER BY id DESC LIMIT 100',['id'=>$id]);}
    public function notifications(int $id):array{return Database::query('SELECT id,title,message,type,link,is_read,created_at FROM notifications WHERE user_id=:id ORDER BY id DESC LIMIT 100',['id'=>$id]);}
    public function ticketStudents(int $id):array{return Database::query('SELECT ta.*,u.full_name,u.identifier,u.status AS student_status FROM ticket_assignments ta JOIN users u ON u.id=ta.student_id WHERE ta.ticket_id=:id ORDER BY ta.assigned_at DESC',['id'=>$id]);}
    public function ticketDatasets(int $id):array{return Database::query('SELECT da.*,d.code,d.name,d.format,d.archived_at,u.full_name AS student_name FROM dataset_assignments da JOIN datasets d ON d.id=da.dataset_id JOIN users u ON u.id=da.student_id WHERE da.ticket_id=:id ORDER BY da.id DESC',['id'=>$id]);}
    public function ticketSubmissions(int $id):array{return Database::query('SELECT s.*,u.full_name AS student_name FROM submissions s JOIN users u ON u.id=s.student_id WHERE s.ticket_id=:id ORDER BY s.id DESC',['id'=>$id]);}
    public function scenarioTickets(int $id):array{return Database::query('SELECT * FROM tickets WHERE scenario_id=:id ORDER BY id DESC',['id'=>$id]);}
    public function scenarioDatasets(int $id):array{return Database::query('SELECT id,code,name,format,version,current_version_id,archived_at FROM datasets WHERE scenario_id=:id ORDER BY id DESC',['id'=>$id]);}
    public function scenarioStudents(int $id):array{return Database::query('SELECT DISTINCT u.id,u.full_name,u.identifier,u.status FROM users u JOIN ticket_assignments ta ON ta.student_id=u.id AND ta.revoked_at IS NULL JOIN tickets t ON t.id=ta.ticket_id WHERE t.scenario_id=:id ORDER BY u.id',['id'=>$id]);}
}
