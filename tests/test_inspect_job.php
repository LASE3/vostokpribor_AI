<?php
require_once __DIR__ . '/../app/bootstrap.php';
use App\Core\Database;

$db = Database::getInstance();
$job = $db->fetchOne("SELECT id, job_uuid, status, exit_code, execution_time_ms, stdout, stderr FROM execution_jobs WHERE id = 1");
print_r($job);
