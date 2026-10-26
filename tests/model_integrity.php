<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__ . '/../app/bootstrap.php';
use App\Core\Database;
use App\Core\Env;
use App\Services\NotebookService;
use App\Services\ModelService;
use App\Services\ValidationService;
use App\Services\DeploymentService;
use App\Services\ExperimentService;

if (Env::get('APP_ENV') !== 'testing' || !str_ends_with((string)Env::get('DB_NAME'), '_test')
    || !in_array(Env::get('DB_HOST'), ['127.0.0.1', 'localhost', '::1'], true)) {
    fwrite(STDERR, "REFUSED: APP_ENV=testing and a loopback _test database are mandatory.\n"); exit(1);
}
$checks = [];
$check = function (bool $condition, string $label) use (&$checks): void {
    if (!$condition) throw new RuntimeException('FAIL: ' . $label);
    $checks[] = $label;
};
$reject = function (callable $operation, string $class, string $label) use ($check): void {
    try { $operation(); } catch (Throwable $e) {
        if (!$e instanceof $class) throw $e;
        $check(true, $label); return;
    }
    $check(false, $label);
};
$counts = function (): array {
    $out = [];
    foreach (Database::query('SHOW TABLES') as $row) {
        $name = reset($row);
        if (!preg_match('/^[a-z_]+$/D', $name)) throw new RuntimeException('Unexpected table.');
        $out[$name] = (int)Database::queryOne('SELECT COUNT(*) AS n FROM `' . $name . '`')['n'];
    }
    return $out;
};
$pdo = Database::getConnection();
$db = Database::getInstance();
$before = $counts();
$marker = 'INTEGRITY-' . strtoupper(bin2hex(random_bytes(6)));
$ownFile = null;
try {
    $pdo->beginTransaction();
    $ids = [];
    for ($i = 0; $i < 2; $i++) {
        $ids[] = $db->insert('users', ['role' => 'STUDENT', 'email' => $marker . '-' . $i . '@example.invalid', 'identifier' => $marker . '-' . $i, 'full_name' => 'Rollback integrity test', 'password_hash' => password_hash(bin2hex(random_bytes(24)), PASSWORD_DEFAULT), 'status' => 'ACTIVE']);
    }
    [$student, $other] = $ids;
    $admin = (int)Database::queryOne("SELECT id FROM users WHERE role='ADMIN' LIMIT 1")['id'];
    $ticket = $db->insert('tickets', ['ticket_code' => $marker, 'title' => 'Rollback ownership ticket', 'created_by' => $admin]);
    $db->insert('ticket_assignments', ['ticket_id' => $ticket, 'student_id' => $student, 'assigned_by' => $admin]);
    $notebooks = new NotebookService();
    $models = new ModelService();
    $experiments = new ExperimentService();
    $validation = new ValidationService();
    $deployment = new DeploymentService();
    $nb = $notebooks->createNotebook(['title' => 'Explicit empty notebook', 'ticket_id' => $ticket], $student);
    $check($nb['cells'] === [], 'Explicit notebook creation has no default cells or outputs');
    $code = "print('saved only')\n";
    $nb = $notebooks->saveNotebook((int)$nb['id'], ['cells' => [['cell_type' => 'code', 'source' => $code, 'output_text' => 'invented success', 'execution_count' => 99]]], $student, 'STUDENT');
    $check($nb['cells'][0]['source'] === $code && $nb['cells'][0]['output_text'] === null && $nb['cells'][0]['execution_count'] === null, 'Notebook preserves exact code and rejects forged runner output');
    $notebooks->saveNotebook((int)$nb['id'], ['cells' => []], $student, 'STUDENT');
    $check($notebooks->getNotebook((int)$nb['id'], $student, 'STUDENT')['cells'] === [], 'Saving an empty cell list clears cells explicitly');
    $reject(fn() => $notebooks->saveNotebook((int)$nb['id'], ['cells' => []], $other, 'STUDENT'), \App\Core\AccessDeniedException::class, 'Another student cannot modify notebook cells');
    $reject(fn() => $notebooks->createNotebook(['title' => 'Denied ticket reference', 'ticket_id' => $ticket], $other), \App\Core\AccessDeniedException::class, 'Notebook cannot reference another student ticket');
    $metadata = $models->registerModel(['model_code' => $marker, 'name' => 'Metadata only', 'framework' => 'opaque', 'ticket_id' => $ticket], $student);
    $mid = (int)$metadata['id'];
    $check($metadata['versions'] === [] && (int)Database::queryOne('SELECT COUNT(*) AS n FROM model_versions WHERE model_id=:id', ['id' => $mid])['n'] === 0, 'Metadata registration creates zero artifact versions');
    $reject(fn() => $models->registerModel(['model_code' => $marker . '-OTHER', 'name' => 'Denied model', 'framework' => 'opaque', 'ticket_id' => $ticket], $other), \App\Core\AccessDeniedException::class, 'Model cannot reference another student ticket');
    $reject(fn() => $models->addVersion($mid, ['name' => 'absent.json', 'tmp_name' => '', 'error' => UPLOAD_ERR_NO_FILE], ['version' => 'v1'], $student, 'STUDENT'), InvalidArgumentException::class, 'Absent artifact upload is rejected');
    $missing = $db->insert('model_versions', ['model_id' => $mid, 'version' => 'missing', 'artifact_path' => $marker . '-absent.bin', 'artifact_format' => 'bin', 'checksum_sha256' => str_repeat('0', 64), 'file_size' => 8]);
    $reject(fn() => $validation->runValidation($mid, $missing, $student), InvalidArgumentException::class, 'Missing stored artifact cannot validate');
    $dir = dirname(__DIR__) . '/storage/private/models';
    if (!is_dir($dir)) throw new RuntimeException('Expected private model directory.');
    $name = 'integrity_' . bin2hex(random_bytes(16)) . '.json';
    $ownFile = $dir . '/' . $name;
    $handle = fopen($ownFile, 'x');
    if (!$handle) throw new RuntimeException('Cannot create isolated test artifact.');
    fwrite($handle, '{"opaque":true}'); fclose($handle);
    $mismatch = $db->insert('model_versions', ['model_id' => $mid, 'version' => 'mismatch', 'artifact_path' => $name, 'artifact_format' => 'json', 'checksum_sha256' => str_repeat('0', 64), 'file_size' => filesize($ownFile)]);
    $reject(fn() => $validation->runValidation($mid, $mismatch, $student), InvalidArgumentException::class, 'Checksum mismatch cannot validate');
    $check((int)Database::queryOne('SELECT COUNT(*) AS n FROM validation_runs WHERE model_id=:id', ['id' => $mid])['n'] === 0, 'Missing and corrupted artifacts create zero validation reports');
    Database::execute('UPDATE model_versions SET checksum_sha256=:sha,metrics=:metrics WHERE id=:id', ['sha' => hash_file('sha256', $ownFile), 'metrics' => json_encode(['accuracy' => 1.0, 'f1_score' => 1.0, 'latency_ms' => 0.1]), 'id' => $mismatch]);
    $run = $validation->runValidation($mid, $mismatch, $student);
    $check($run['status'] === 'NOT_EVALUATED' && $run['score'] === null, 'Perfect student metrics never pass trusted quality evaluation');
    $report = json_decode($run['report_json'], true);
    $check($report['measurement_provenance'] === 'NO_TRUSTED_EVALUATOR' && $report['checks'][1]['passed'] === null && $report['checks'][2]['passed'] === null, 'File extension and user latency do not prove serialization safety or performance');
    $reject(fn() => $validation->getRun((int)$run['id'], $other, 'STUDENT'), \App\Core\AccessDeniedException::class, 'Another student cannot read validation evidence');
    $reject(fn() => $deployment->requestDeployment(['model_id' => $mid, 'model_version_id' => 0], $student), InvalidArgumentException::class, 'No artifact version means deployment rejected');
    $reject(fn() => $deployment->requestDeployment(['model_id' => $mid, 'model_version_id' => $mismatch], $student), DomainException::class, 'Stored artifact cannot deploy without verified provider');
    $reject(fn() => $deployment->reviewDeployment(0, 'DEPLOYED', $admin), DomainException::class, 'Administrator cannot assert deployment through database decision');
    $check((int)Database::queryOne('SELECT COUNT(*) AS n FROM deployment_requests WHERE model_id=:id', ['id' => $mid])['n'] === 0, 'Blocked deployments create no request or endpoint');
    $exp = $experiments->createExperiment(['name' => 'Owned experiment', 'ticket_id' => $ticket], $student);
    $reject(fn() => $experiments->recordRun(['experiment_id' => $exp['id'], 'run_name' => 'Foreign experiment'], $other), \App\Core\AccessDeniedException::class, 'Cannot record run against another student experiment');
    $otherExp = $experiments->createExperiment(['name' => 'Other owned experiment'], $other);
    $reject(fn() => $experiments->recordRun(['experiment_id' => $otherExp['id'], 'run_name' => 'Foreign notebook', 'notebook_id' => $nb['id']], $other), \App\Core\AccessDeniedException::class, 'Cannot attach another student notebook to experiment run');
    $recorded = $experiments->recordRun(['experiment_id' => $exp['id'], 'run_name' => 'User reported run', 'status' => 'COMPLETED', 'metrics' => ['accuracy' => 1]], $student);
    $savedRun = Database::queryOne('SELECT * FROM experiment_runs WHERE run_uuid=:uuid', ['uuid' => $recorded['run_uuid']]);
    $check($savedRun['status'] === 'RECORDED' && $savedRun['duration_seconds'] === null, 'User run record cannot assert completed execution or timing');
    $reject(fn() => $models->registerModel(['model_code' => $marker . '-FOREIGN', 'name' => 'Foreign run model', 'framework' => 'opaque', 'experiment_run_id' => $savedRun['id']], $other), \App\Core\AccessDeniedException::class, 'Model cannot reference another student experiment run');
    $pdo->rollBack();
    $check($counts() === $before, 'All database mutations rolled back; initial table counts restored');
    foreach ($checks as $label) echo 'PASS: ' . $label . PHP_EOL;
    echo count($checks) . ' model/notebook integrity checks passed on ' . Env::get('DB_NAME') . '; all database mutations rolled back.' . PHP_EOL;
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    fwrite(STDERR, $e->getMessage() . PHP_EOL); exit(1);
} finally {
    if ($ownFile !== null && is_file($ownFile)) unlink($ownFile);
}
