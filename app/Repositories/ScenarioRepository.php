<?php
namespace App\Repositories;
use App\Core\Database;
class ScenarioRepository
{
    private function decode(array $row): array {
        $row['builder_metadata']=json_decode($row['builder_metadata']??'{}',true)??[];
        $persisted=[];
        foreach(['id','code','title','description','difficulty','department','status','version','objectives','acceptance_criteria','author_id','builder_metadata'] as $field)$persisted[$field]=$row[$field]??null;
        $persisted['id']=(int)$persisted['id'];$persisted['author_id']=(int)$persisted['author_id'];
        $row['revision']=hash('sha256',json_encode($persisted,JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        return $row;
    }
    public function listAll(?string $status=null): array {
        return $this->pageAll($status)['items'];
    }
    public function pageAll(?string $status=null,array $paging=[],array $filters=[]): array {
        $sql="SELECT s.*,u.full_name AS author_name,
        (SELECT COUNT(*) FROM tickets t WHERE t.scenario_id=s.id) AS tickets_count,
        (SELECT COUNT(DISTINCT ta.student_id) FROM ticket_assignments ta JOIN tickets t ON ta.ticket_id=t.id WHERE t.scenario_id=s.id AND ta.revoked_at IS NULL) AS students_count,
        (SELECT COUNT(*) FROM datasets d WHERE d.scenario_id=s.id) AS datasets_count FROM scenarios s LEFT JOIN users u ON u.id=s.author_id";
        $params=[];$where=[];
        if ($status) { $where[]='s.status=:status'; $params['status']=$status; }
        if(!empty($filters['department'])){$where[]='s.department=:department';$params['department']=$filters['department'];}
        foreach(['level'=>'edit-level','category'=>'edit-category'] as $key=>$field)if(!empty($filters[$key])){
            $where[]="JSON_UNQUOTE(JSON_EXTRACT(s.builder_metadata,'$.form_fields.\"".$field."\"')) LIKE :".$key." ESCAPE '!'";
            $params[$key]='%'.strtr($filters[$key],['!'=>'!!','%'=>'!%','_'=>'!_']).'%';
        }
        if(!empty($filters['search'])){
            $clauses=[];
            foreach(['s.code','s.title','s.description','s.department','u.full_name',"JSON_UNQUOTE(JSON_EXTRACT(s.builder_metadata,'$.form_fields.\"edit-tags\"'))"] as $index=>$column){$name='search'.$index;$clauses[]=$column." LIKE :".$name." ESCAPE '!'";$params[$name]='%'.strtr($filters['search'],['!'=>'!!','%'=>'!%','_'=>'!_']).'%';}
            $where[]='('.implode(' OR ',$clauses).')';
        }
        $clause=$where?' WHERE '.implode(' AND ',$where):'';
        $countSql='SELECT COUNT(*) AS total FROM scenarios s LEFT JOIN users u ON u.id=s.author_id'.$clause;
        $page=\App\Core\Pagination::query($sql.$clause.' ORDER BY s.created_at DESC,s.id DESC',$params,$paging,$countSql);
        $page['items']=array_map(fn($r)=>$this->decode($r),$page['items']);
        return $page;
    }
    public function findById(int $id): ?array {
        $r=Database::queryOne('SELECT s.*,u.full_name AS author_name FROM scenarios s LEFT JOIN users u ON s.author_id=u.id WHERE s.id=:id',['id'=>$id]);
        return $r?$this->decode($r):null;
    }
    public function findByCode(string $code): ?array {
        $r=Database::queryOne('SELECT * FROM scenarios WHERE code=:code',['code'=>$code]);return $r?$this->decode($r):null;
    }
    public function create(array $data): int {
        $values=[];
        foreach(['code','title','description','difficulty','department','status','version','objectives','acceptance_criteria','author_id'] as $key) $values[$key]=$data[$key]??null;
        $values['builder_metadata']=json_encode($data['builder_metadata'],JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE);
        return Database::getInstance()->insert('scenarios',$values);
    }
    public function update(int $id,array $data): void {
        $values=[];
        foreach(['title','description','difficulty','department','status','version','objectives','acceptance_criteria'] as $key) if(array_key_exists($key,$data))$values[$key]=$data[$key];
        if(isset($data['builder_metadata']))$values['builder_metadata']=json_encode($data['builder_metadata'],JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE);
        Database::getInstance()->update('scenarios',$values,'id=:id',['id'=>$id]);
    }
}
