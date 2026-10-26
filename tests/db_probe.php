<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__ . '/../app/bootstrap.php';
use App\Core\Database;
use App\Core\Env;
if (Env::get('APP_ENV') !== 'testing' || !str_ends_with((string)Env::get('DB_NAME'), '_test') || !in_array(Env::get('DB_HOST'), ['127.0.0.1','localhost','::1'], true)) { fwrite(STDERR, "REFUSED: testing _test DB required.\n"); exit(1); }
$counts=[];foreach(Database::query('SHOW TABLES') as $row){$table=reset($row);if(!preg_match('/^[a-z_]+$/D',$table))throw new RuntimeException('Bad table');$counts[$table]=(int)Database::queryOne('SELECT COUNT(*) AS c FROM `'.$table.'`')['c'];}
echo json_encode(['environment'=>Env::get('APP_ENV'),'database'=>Env::get('DB_NAME'),'counts'=>$counts,
    'tickets'=>Database::query('SELECT id,ticket_code,status FROM tickets ORDER BY id'),
    'notebooks'=>Database::query('SELECT id,student_id,status FROM notebooks ORDER BY id'),
    'submissions'=>Database::query('SELECT id,student_id,status,feedback FROM submissions ORDER BY id'),
    'validations'=>Database::query('SELECT id,status,score FROM validation_runs ORDER BY id'),
    'audit_actions'=>Database::query('SELECT action,COUNT(*) AS total FROM audit_logs GROUP BY action')],JSON_PRETTY_PRINT);
