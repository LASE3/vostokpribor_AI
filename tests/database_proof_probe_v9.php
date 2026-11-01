<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require __DIR__ . '/../app/bootstrap.php';
use App\Core\{Database, Env};
if (Env::get('APP_ENV') !== 'testing' || !str_ends_with((string)Env::get('DB_NAME'), '_test')
    || !in_array(Env::get('DB_HOST'), ['127.0.0.1', 'localhost', '::1'], true)) {
    throw new RuntimeException('REFUSED: dedicated loopback testing database required.');
}
$kind = $argv[1] ?? 'environment'; $id = (int)($argv[2] ?? 0);
if ($kind === 'environment') {
    echo json_encode(['database'=>Env::get('DB_NAME'),'environment'=>Env::get('APP_ENV'),'base_url'=>Env::get('APP_URL'),'app_url'=>Env::get('APP_URL'),'cookie'=>Env::get('SESSION_COOKIE_NAME')]); exit;
}
// Fixed read-only queries: no SQL, table names, filenames or credentials are accepted from callers.
$queries = [
 'user'=>"SELECT id,role,identifier,full_name,status,must_change_password,session_version,password_hash FROM users WHERE id=:id AND identifier LIKE 'IT-V9-%'",
 'scenario'=>"SELECT id,code,title,status,builder_metadata,author_id FROM scenarios WHERE id=:id AND code LIKE 'IT-V9-%'",
 'ticket'=>"SELECT id,ticket_code,title,requirements,acceptance_criteria,deadline,status FROM tickets WHERE id=:id AND ticket_code LIKE 'IT-V9-%'",
 'assignment'=>"SELECT a.ticket_id,a.student_id,a.assigned_by,a.revoked_at FROM ticket_assignments a JOIN tickets t ON t.id=a.ticket_id WHERE t.id=:id AND t.ticket_code LIKE 'IT-V9-%'",
 'dataset'=>"SELECT id,code,name,file_path,file_size,checksum_sha256,current_version_id,uploaded_by FROM datasets WHERE id=:id AND code LIKE 'IT-V9-%'",
 'dataset_assignment'=>"SELECT a.dataset_id,a.student_id,a.ticket_id,a.dataset_version_id,a.assigned_by,a.revoked_at FROM dataset_assignments a JOIN datasets d ON d.id=a.dataset_id WHERE d.id=:id AND d.code LIKE 'IT-V9-%'",
 'processed'=>"SELECT p.id,p.source_dataset_id,p.source_dataset_version_id,p.student_id,p.ticket_id,p.file_path,p.checksum_sha256 FROM processed_datasets p JOIN users u ON u.id=p.student_id WHERE p.id=:id AND u.identifier LIKE 'IT-V9-%'",
 'notebook'=>"SELECT n.id,n.student_id,n.ticket_id,n.version,n.status,n.kernel_state FROM notebooks n JOIN users u ON u.id=n.student_id WHERE n.id=:id AND u.identifier LIKE 'IT-V9-%'",
 'cells'=>"SELECT c.cell_order,c.cell_type,SHA2(c.source,256) AS source_sha256,LENGTH(c.source) AS source_bytes,c.output_text FROM notebook_cells c JOIN notebooks n ON n.id=c.notebook_id JOIN users u ON u.id=n.student_id WHERE n.id=:id AND u.identifier LIKE 'IT-V9-%' ORDER BY c.cell_order",
 'experiment'=>"SELECT e.id,e.name,e.student_id,e.ticket_id FROM experiments e JOIN users u ON u.id=e.student_id WHERE e.id=:id AND u.identifier LIKE 'IT-V9-%'",
 'model'=>"SELECT m.id,m.model_code,m.name,m.student_id,m.ticket_id,m.status FROM models m JOIN users u ON u.id=m.student_id WHERE m.id=:id AND u.identifier LIKE 'IT-V9-%'",
 'artifact'=>"SELECT v.id,v.model_id,v.version,v.artifact_path,v.artifact_format,v.checksum_sha256 FROM model_versions v JOIN models m ON m.id=v.model_id JOIN users u ON u.id=m.student_id WHERE v.id=:id AND u.identifier LIKE 'IT-V9-%'",
 'submission'=>"SELECT s.id,s.ticket_id,s.student_id,s.status,s.notebook_id,s.model_id,s.reviewed_by,s.total_score,s.feedback FROM submissions s JOIN users u ON u.id=s.student_id WHERE s.id=:id AND u.identifier LIKE 'IT-V9-%'",
 'notifications'=>"SELECT n.id,n.user_id,n.title,n.message,n.is_read FROM notifications n JOIN users u ON u.id=n.user_id WHERE u.id=:id AND u.identifier LIKE 'IT-V9-%' ORDER BY n.id",
 'audit'=>"SELECT a.action,a.actor_id,a.resource_type,a.resource_id,a.outcome FROM audit_logs a WHERE (a.resource_type='users' AND a.resource_id=:id) ORDER BY a.id",
 'review_audit'=>"SELECT a.action,a.actor_id,a.resource_type,a.resource_id,a.outcome FROM audit_logs a JOIN submissions s ON CAST(a.resource_id AS UNSIGNED)=s.id AND a.resource_type='submissions' JOIN users u ON u.id=s.student_id WHERE s.id=:id AND u.identifier LIKE 'IT-V9-%' ORDER BY a.id",
];
if (!isset($queries[$kind]) || $id < 1) throw new InvalidArgumentException('Known proof kind and positive identifier required.');
$rows = Database::query($queries[$kind], ['id'=>$id]);
foreach ($rows as &$row) {
    if (isset($row['password_hash'])) { $row['password_algorithm']=password_get_info($row['password_hash'])['algoName']; unset($row['password_hash']); }
    foreach (['file_path','artifact_path'] as $key) if (isset($row[$key])) {
        $base = dirname(__DIR__).'/storage/private/'.($key==='artifact_path'?'models':'datasets').'/';
        $path=$base.basename($row[$key]); $row['private_file_exists']=is_file($path);
        $row['private_file_checksum_matches']=is_file($path)&&hash_equals($row['checksum_sha256'],hash_file('sha256',$path));
        unset($row[$key]);
    }
}
unset($row);
echo json_encode($rows, JSON_THROW_ON_ERROR|JSON_UNESCAPED_SLASHES);
