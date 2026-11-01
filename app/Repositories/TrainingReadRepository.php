<?php
namespace App\Repositories;
use App\Core\Pagination;
final class TrainingReadRepository {
    private const QUERIES=[
        'studentActivity'=>'SELECT id,action,resource_type,resource_id,outcome,created_at FROM audit_logs WHERE actor_id=:id ORDER BY id DESC',
        'notifications'=>'SELECT id,title,message,type,link,is_read,created_at FROM notifications WHERE user_id=:id ORDER BY id DESC',
        'ticketStudents'=>'SELECT ta.*,u.full_name,u.identifier,u.status AS student_status FROM ticket_assignments ta JOIN users u ON u.id=ta.student_id WHERE ta.ticket_id=:id ORDER BY ta.assigned_at DESC',
        'ticketDatasets'=>'SELECT da.*,d.code,d.name,d.format,d.archived_at,u.full_name AS student_name FROM dataset_assignments da JOIN datasets d ON d.id=da.dataset_id JOIN users u ON u.id=da.student_id WHERE da.ticket_id=:id ORDER BY da.id DESC',
        'ticketSubmissions'=>'SELECT s.*,u.full_name AS student_name FROM submissions s JOIN users u ON u.id=s.student_id WHERE s.ticket_id=:id ORDER BY s.id DESC',
        'scenarioTickets'=>'SELECT * FROM tickets WHERE scenario_id=:id ORDER BY id DESC',
        'scenarioDatasets'=>'SELECT id,code,name,format,version,current_version_id,archived_at FROM datasets WHERE scenario_id=:id ORDER BY id DESC',
        'scenarioStudents'=>'SELECT DISTINCT u.id,u.full_name,u.identifier,u.status FROM users u JOIN ticket_assignments ta ON ta.student_id=u.id AND ta.revoked_at IS NULL JOIN tickets t ON t.id=ta.ticket_id WHERE t.scenario_id=:id ORDER BY u.id',
    ];
    public function page(string $resource,int $id,array $paging=[]):array {
        if(!isset(self::QUERIES[$resource]))throw new \InvalidArgumentException('Unknown related collection.');
        return Pagination::query(self::QUERIES[$resource],['id'=>$id],$paging);
    }
    public function studentActivity(int $id):array {return $this->page('studentActivity',$id)['items'];}
    public function notifications(int $id):array {return $this->page('notifications',$id)['items'];}
    public function ticketStudents(int $id):array {return $this->page('ticketStudents',$id)['items'];}
    public function ticketDatasets(int $id):array {return $this->page('ticketDatasets',$id)['items'];}
    public function ticketSubmissions(int $id):array {return $this->page('ticketSubmissions',$id)['items'];}
    public function scenarioTickets(int $id):array {return $this->page('scenarioTickets',$id)['items'];}
    public function scenarioDatasets(int $id):array {return $this->page('scenarioDatasets',$id)['items'];}
    public function scenarioStudents(int $id):array {return $this->page('scenarioStudents',$id)['items'];}
}
