<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__ . '/../app/bootstrap.php';
use App\Core\Auth;
use App\Core\Database;
use App\Core\Env;
use App\Repositories\ExecutionRepository;
if (Env::get('APP_ENV') !== 'testing' || !str_ends_with((string)Env::get('DB_NAME', ''), '_test')
    || !in_array(Env::get('DB_HOST'), ['127.0.0.1', 'localhost', '::1'], true)) {
    fwrite(STDERR, "REFUSED: APP_ENV=testing and a loopback _test database are mandatory.\n"); exit(1);
}
$checks = [];
$check = function (bool $condition, string $label) use (&$checks): void {
    if (!$condition) throw new RuntimeException('FAIL: ' . $label);
    $checks[] = $label;
};
$pdo = Database::getConnection();
$db = Database::getInstance();
$marker = 'SEC-' . bin2hex(random_bytes(6));
try {
    $pdo->beginTransaction();
    $id = $db->insert('users', ['role' => 'STUDENT', 'email' => $marker . '@example.invalid', 'identifier' => $marker,
        'full_name' => 'Transaction Test', 'password_hash' => password_hash(bin2hex(random_bytes(24)), PASSWORD_DEFAULT), 'status' => 'ACTIVE']);
    $check($id > 0 && (int)Database::queryOne('SELECT id FROM users WHERE id=:id', ['id' => $id])['id'] === $id, 'Strict insert persists parameter values');
    try {
        Database::transaction(function () use ($id) {
            Database::execute('UPDATE users SET full_name=:name WHERE id=:id', ['name' => 'Nested rollback', 'id' => $id]);
            throw new RuntimeException('EXPECTED_NESTED_ROLLBACK');
        });
    } catch (RuntimeException $e) { if ($e->getMessage() !== 'EXPECTED_NESTED_ROLLBACK') throw $e; }
    $check(Database::queryOne('SELECT full_name FROM users WHERE id=:id', ['id' => $id])['full_name'] === 'Transaction Test', 'Nested transaction rolls back to its savepoint');
    $db->update('users', ['full_name' => 'Updated'], 'id=:id', ['id' => $id]);
    $check(Database::queryOne('SELECT full_name FROM users WHERE id=:id', ['id' => $id])['full_name'] === 'Updated', 'Strict update persists parameter values');
    $notebookId = $db->insert('notebooks', ['code' => $marker, 'title' => 'Cancellation Test', 'student_id' => $id]);
    $_SESSION['user_id'] = $id;
    $_SESSION['last_activity'] = time();
    $repo = new ExecutionRepository();
    $uuid = $repo->createJob(['notebook_id' => $notebookId, 'student_id' => $id, 'code_to_execute' => '# never executed']);
    $check($repo->findByUuid($uuid)['status'] === 'QUEUED', 'Repository queued state is explicit');
    $check(!$repo->cancelJob($uuid, $id + 999999), 'Another student cannot cancel job');
    $check($repo->cancelJob($uuid, $id) && $repo->findByUuid($uuid)['status'] === 'CANCELLED', 'Queued cancellation persists');
    $check(!$repo->cancelJob($uuid, $id), 'Terminal cancellation cannot be repeated');
    Database::execute("UPDATE execution_jobs SET status='RUNNING' WHERE job_uuid=:uuid", ['uuid' => $uuid]);
    $check($repo->cancelJob($uuid, $id), 'Running state can be marked cancelled');
    Database::execute("UPDATE execution_jobs SET status='COMPLETED' WHERE job_uuid=:uuid", ['uuid' => $uuid]);
    $check(!$repo->cancelJob($uuid, $id), 'Completed job cannot be cancelled');
    $service = new \App\Services\ExecutionService();
    $before = (int)$pdo->query('SELECT COUNT(*) FROM execution_jobs')->fetchColumn();
    try { $service->submitJob(['notebook_id' => $notebookId, 'code_to_execute' => 'raise Exception()'], $id); throw new RuntimeException('Unsafe execution accepted.'); }
    catch (DomainException $e) { $check(str_contains($e->getMessage(), 'Execution unavailable'), 'Student execution refuses unavailable isolation'); }
    $check((int)$pdo->query('SELECT COUNT(*) FROM execution_jobs')->fetchColumn() === $before, 'Refused execution creates no queued work');
    $pdo->rollBack();
    $check(Database::queryOne('SELECT id FROM users WHERE identifier=:identifier', ['identifier' => $marker]) === null, 'Outer rollback removes all test records');
    foreach ($checks as $label) echo "PASS: $label\n";
    echo count($checks) . " database security checks passed on " . Env::get('DB_NAME') . "; all mutations rolled back.\n";
} catch (Throwable $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    fwrite(STDERR, $e->getMessage() . "\n"); exit(1);
}
