<?php
namespace App\Repositories;

use App\Core\Database;

class DatasetRepository
{
    private function artifactColumns(): string
    {
        return 'v.id AS dataset_version_id,v.version,v.format,v.file_path,v.file_size,v.checksum_sha256,v.row_count,v.column_count,v.schema_json';
    }

    public function listForUser(int $userId, string $role, ?string $format = null): array
    {
        $params=[];
        if ($role==='ADMIN') {
            $sql='SELECT d.*,'.$this->artifactColumns().',u.full_name AS uploader_name,s.title AS scenario_title,
                (SELECT COUNT(*) FROM dataset_assignments a WHERE a.dataset_id=d.id AND a.revoked_at IS NULL) AS assignments_count
                FROM datasets d LEFT JOIN dataset_versions v ON v.id=d.current_version_id
                LEFT JOIN users u ON u.id=d.uploaded_by LEFT JOIN scenarios s ON s.id=d.scenario_id WHERE 1=1';
        } else {
            // A single visible row per dataset, pinned to the latest active assignment version.
            $sql="SELECT d.*,".$this->artifactColumns().",u.full_name AS uploader_name,s.title AS scenario_title,
                a.ticket_id AS assigned_ticket_id,a.created_at AS assigned_at
                FROM datasets d JOIN dataset_assignments a ON a.dataset_id=d.id
                JOIN ticket_assignments ta ON ta.ticket_id=a.ticket_id AND ta.student_id=a.student_id AND ta.revoked_at IS NULL
                JOIN tickets t ON t.id=a.ticket_id AND t.status<>'CANCELLED'
                JOIN dataset_versions v ON v.id=a.dataset_version_id AND v.dataset_id=d.id
                LEFT JOIN users u ON u.id=d.uploaded_by LEFT JOIN scenarios s ON s.id=d.scenario_id
                WHERE a.student_id=:uid AND a.revoked_at IS NULL AND d.archived_at IS NULL
                AND a.id=(SELECT MAX(a2.id) FROM dataset_assignments a2
                    JOIN ticket_assignments ta2 ON ta2.ticket_id=a2.ticket_id AND ta2.student_id=a2.student_id AND ta2.revoked_at IS NULL
                    JOIN tickets t2 ON t2.id=a2.ticket_id AND t2.status<>'CANCELLED'
                    WHERE a2.dataset_id=d.id AND a2.student_id=:uid2 AND a2.revoked_at IS NULL)";
            $params=['uid'=>$userId,'uid2'=>$userId];
        }
        if($format!==null&&$format!==''){$sql.=' AND v.format=:format';$params['format']=strtolower($format);}
        return Database::query($sql.' ORDER BY d.created_at DESC,d.id DESC',$params);
    }

    public function findById(int $id): ?array
    {
        return Database::queryOne('SELECT d.*,'.$this->artifactColumns().',u.full_name AS uploader_name,s.title AS scenario_title
            FROM datasets d LEFT JOIN dataset_versions v ON v.id=d.current_version_id LEFT JOIN users u ON u.id=d.uploaded_by
            LEFT JOIN scenarios s ON s.id=d.scenario_id WHERE d.id=:id',['id'=>$id]);
    }

    public function findByCode(string $code): ?array
    {
        return Database::queryOne('SELECT * FROM datasets WHERE code=:code',['code'=>$code]);
    }

    public function authorizedVersion(int $datasetId,int $studentId,?int $versionId=null,?int $ticketId=null): ?array
    {
        $sql="SELECT a.*,v.version FROM dataset_assignments a
            JOIN datasets d ON d.id=a.dataset_id AND d.archived_at IS NULL
            JOIN dataset_versions v ON v.id=a.dataset_version_id AND v.dataset_id=d.id
            JOIN ticket_assignments ta ON ta.ticket_id=a.ticket_id AND ta.student_id=a.student_id AND ta.revoked_at IS NULL
            JOIN tickets t ON t.id=a.ticket_id AND t.status<>'CANCELLED'
            WHERE a.dataset_id=:did AND a.student_id=:uid AND a.revoked_at IS NULL";
        $params=['did'=>$datasetId,'uid'=>$studentId];
        if($versionId!==null){$sql.=' AND a.dataset_version_id=:vid';$params['vid']=$versionId;}
        if($ticketId!==null){$sql.=' AND a.ticket_id=:tid';$params['tid']=$ticketId;}
        return Database::queryOne($sql.' ORDER BY a.id DESC LIMIT 1',$params);
    }

    public function isAssignedToStudent(int $datasetId,int $studentId):bool
    {
        return $this->authorizedVersion($datasetId,$studentId)!==null;
    }

    public function version(int $datasetId,int $versionId):?array
    {
        return Database::queryOne('SELECT * FROM dataset_versions WHERE dataset_id=:did AND id=:vid',['did'=>$datasetId,'vid'=>$versionId]);
    }

    public function versions(int $datasetId,?int $studentId=null):array
    {
        if($studentId===null)return Database::query('SELECT v.*,u.full_name AS uploader_name FROM dataset_versions v JOIN users u ON u.id=v.uploaded_by WHERE v.dataset_id=:did ORDER BY v.id DESC',['did'=>$datasetId]);
        return Database::query("SELECT DISTINCT v.*,u.full_name AS uploader_name FROM dataset_versions v
            JOIN dataset_assignments a ON a.dataset_version_id=v.id AND a.dataset_id=v.dataset_id AND a.revoked_at IS NULL
            JOIN ticket_assignments ta ON ta.ticket_id=a.ticket_id AND ta.student_id=a.student_id AND ta.revoked_at IS NULL
            JOIN tickets t ON t.id=a.ticket_id AND t.status<>'CANCELLED'
            JOIN datasets d ON d.id=v.dataset_id AND d.archived_at IS NULL
            JOIN users u ON u.id=v.uploaded_by WHERE v.dataset_id=:did AND a.student_id=:uid ORDER BY v.id DESC",['did'=>$datasetId,'uid'=>$studentId]);
    }

    public function create(array $data):int
    {
        $data['schema_json']=json_encode($data['schema_json'],JSON_THROW_ON_ERROR);
        return Database::getInstance()->insert('datasets',$data);
    }

    public function createVersion(int $datasetId,array $file,string $version,int $actor):int
    {
        return Database::getInstance()->insert('dataset_versions',[
            'dataset_id'=>$datasetId,'version'=>$version,'format'=>$file['format'],'file_path'=>$file['file_path'],
            'file_size'=>$file['file_size'],'checksum_sha256'=>$file['checksum_sha256'],'row_count'=>$file['row_count'],
            'column_count'=>$file['column_count'],'schema_json'=>json_encode($file['schema_json'],JSON_THROW_ON_ERROR),'uploaded_by'=>$actor
        ]);
    }

    public function setCurrentVersion(int $datasetId,int $versionId,array $file,string $version):void
    {
        Database::getInstance()->update('datasets',[
            'current_version_id'=>$versionId,'version'=>$version,'format'=>$file['format'],'file_path'=>$file['file_path'],
            'file_size'=>$file['file_size'],'checksum_sha256'=>$file['checksum_sha256'],'row_count'=>$file['row_count'],
            'column_count'=>$file['column_count'],'schema_json'=>json_encode($file['schema_json'],JSON_THROW_ON_ERROR)
        ],'id=:id',['id'=>$datasetId]);
    }

    public function assignments(int $datasetId):array
    {
        return Database::query('SELECT a.*,u.full_name,u.identifier,t.ticket_code,v.version
            FROM dataset_assignments a JOIN users u ON u.id=a.student_id LEFT JOIN tickets t ON t.id=a.ticket_id
            LEFT JOIN dataset_versions v ON v.id=a.dataset_version_id WHERE a.dataset_id=:did ORDER BY a.id DESC',['did'=>$datasetId]);
    }

    public function createProcessedDataset(array $data):int
    {
        if(isset($data['schema_json']))$data['schema_json']=json_encode($data['schema_json'],JSON_THROW_ON_ERROR);
        return Database::getInstance()->insert('processed_datasets',$data);
    }

    public function listProcessedForStudent(int $studentId):array
    {
        return Database::query('SELECT p.*,d.code AS source_dataset_code,d.name AS source_dataset_name,t.ticket_code,v.version AS source_version
            FROM processed_datasets p JOIN datasets d ON d.id=p.source_dataset_id
            LEFT JOIN dataset_versions v ON v.id=p.source_dataset_version_id LEFT JOIN tickets t ON t.id=p.ticket_id
            WHERE p.student_id=:uid ORDER BY p.id DESC',['uid'=>$studentId]);
    }

    public function listProcessedForUser(int $id,string $role):array
    {
        if($role!=='ADMIN')return $this->listProcessedForStudent($id);
        return Database::query('SELECT p.*,d.code AS source_dataset_code,d.name AS source_dataset_name,t.ticket_code,v.version AS source_version,u.full_name AS student_name
            FROM processed_datasets p JOIN datasets d ON d.id=p.source_dataset_id JOIN users u ON u.id=p.student_id
            LEFT JOIN dataset_versions v ON v.id=p.source_dataset_version_id LEFT JOIN tickets t ON t.id=p.ticket_id ORDER BY p.id DESC');
    }

    public function processedById(int $id):?array
    {
        return Database::queryOne('SELECT p.*,d.code AS source_dataset_code,d.name AS source_dataset_name,t.ticket_code,v.version AS source_version
            FROM processed_datasets p JOIN datasets d ON d.id=p.source_dataset_id LEFT JOIN dataset_versions v ON v.id=p.source_dataset_version_id
            LEFT JOIN tickets t ON t.id=p.ticket_id WHERE p.id=:id',['id'=>$id]);
    }
}
