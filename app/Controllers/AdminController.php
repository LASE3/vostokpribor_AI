<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthorizationMiddleware;

class AdminController
{
    public function overview(Request $request): void
    {
        AuthorizationMiddleware::requireAdmin(true);

        // Calculate REAL metrics from persistent relational storage
        $totalStudents = (int)Database::queryOne("SELECT COUNT(*) as c FROM users WHERE role = 'STUDENT'")['c'];
        $activeStudents = (int)Database::queryOne("SELECT COUNT(*) as c FROM users WHERE role = 'STUDENT' AND status = 'ACTIVE'")['c'];

        $totalTickets = (int)Database::queryOne("SELECT COUNT(*) as c FROM tickets")['c'];
        $assignedTickets = (int)Database::queryOne("SELECT COUNT(*) as c FROM tickets WHERE status = 'ASSIGNED'")['c'];
        $inProgressTickets = (int)Database::queryOne("SELECT COUNT(*) as c FROM tickets WHERE status = 'IN_PROGRESS'")['c'];
        $approvedTickets = (int)Database::queryOne("SELECT COUNT(*) as c FROM tickets WHERE status = 'APPROVED'")['c'];

        $totalSubmissions = (int)Database::queryOne("SELECT COUNT(*) as c FROM submissions")['c'];
        $pendingSubmissions = (int)Database::queryOne("SELECT COUNT(*) as c FROM submissions WHERE status IN ('SUBMITTED', 'UNDER_REVIEW')")['c'];
        $approvedSubmissions = (int)Database::queryOne("SELECT COUNT(*) as c FROM submissions WHERE status = 'APPROVED'")['c'];
        $changesRequestedSubmissions = (int)Database::queryOne("SELECT COUNT(*) as c FROM submissions WHERE status = 'CHANGES_REQUESTED'")['c'];

        $totalDatasets = (int)Database::queryOne("SELECT COUNT(*) as c FROM datasets")['c'];
        $totalProcessedDatasets = (int)Database::queryOne("SELECT COUNT(*) as c FROM processed_datasets")['c'];

        $totalNotebooks = (int)Database::queryOne("SELECT COUNT(*) as c FROM notebooks")['c'];
        $totalExperiments = (int)Database::queryOne("SELECT COUNT(*) as c FROM experiments")['c'];
        $totalExperimentRuns = (int)Database::queryOne("SELECT COUNT(*) as c FROM experiment_runs")['c'];

        $totalModels = (int)Database::queryOne("SELECT COUNT(*) as c FROM models")['c'];
        $deployedModels = (int)Database::queryOne("SELECT COUNT(*) as c FROM models WHERE status = 'DEPLOYED'")['c'];

        $pendingValidations = (int)Database::queryOne("SELECT COUNT(*) as c FROM validation_runs WHERE status = 'PENDING'")['c'];
        $pendingDeployments = (int)Database::queryOne("SELECT COUNT(*) as c FROM deployment_requests WHERE status = 'PENDING'")['c'];

        $queuedJobs = (int)Database::queryOne("SELECT COUNT(*) as c FROM execution_jobs WHERE status = 'QUEUED'")['c'];
        $runningJobs = (int)Database::queryOne("SELECT COUNT(*) as c FROM execution_jobs WHERE status = 'RUNNING'")['c'];
        $completedJobs = (int)Database::queryOne("SELECT COUNT(*) as c FROM execution_jobs WHERE status = 'COMPLETED'")['c'];
        $failedJobs = (int)Database::queryOne("SELECT COUNT(*) as c FROM execution_jobs WHERE status = 'FAILED'")['c'];

        $recentAudits = Database::query(
            "SELECT a.*, u.full_name as actor_name, u.identifier as actor_identifier
             FROM audit_logs a
             LEFT JOIN users u ON a.actor_id = u.id
             ORDER BY a.created_at DESC LIMIT 15"
        );

        $overview = [
            'timestamp' => date('c'),
            'students' => [
                'total'  => $totalStudents,
                'active' => $activeStudents
            ],
            'tickets' => [
                'total'       => $totalTickets,
                'assigned'    => $assignedTickets,
                'in_progress' => $inProgressTickets,
                'approved'    => $approvedTickets
            ],
            'submissions' => [
                'total'             => $totalSubmissions,
                'pending'           => $pendingSubmissions,
                'approved'          => $approvedSubmissions,
                'changes_requested' => $changesRequestedSubmissions
            ],
            'datasets' => [
                'master'    => $totalDatasets,
                'processed' => $totalProcessedDatasets
            ],
            'ml_workbench' => [
                'notebooks'       => $totalNotebooks,
                'experiments'     => $totalExperiments,
                'experiment_runs' => $totalExperimentRuns
            ],
            'models' => [
                'registered'           => $totalModels,
                'deployed'             => $deployedModels,
                'pending_validations'  => $pendingValidations,
                'pending_deployments'  => $pendingDeployments
            ],
            'execution_cluster' => [
                'queued'    => $queuedJobs,
                'running'   => $runningJobs,
                'completed' => $completedJobs,
                'failed'    => $failedJobs
            ],
            'recent_audit_actions' => $recentAudits
        ];

        Response::success($overview);
    }

    public function auditLogs(Request $request): void
    {
        AuthorizationMiddleware::requireAdmin(true);

        $limit = min(100, max(1, (int)$request->query('limit', 50)));
        $offset = max(0, (int)$request->query('offset', 0));
        $action = $request->query('action');

        $sql = "SELECT a.*, u.full_name as actor_name, u.identifier as actor_identifier
                FROM audit_logs a
                LEFT JOIN users u ON a.actor_id = u.id
                WHERE 1=1";
        $params = [];

        if ($action) {
            $sql .= " AND a.action = :act";
            $params['act'] = $action;
        }

        $sql .= " ORDER BY a.created_at DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

        $logs = Database::query($sql, $params);
        $total = (int)Database::queryOne("SELECT COUNT(*) as c FROM audit_logs")['c'];

        Response::success([
            'items'  => $logs,
            'total'  => $total,
            'limit'  => $limit,
            'offset' => $offset
        ]);
    }

    public function getSettings(Request $request): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $settings = Database::query("SELECT * FROM system_settings");
        Response::success($settings);
    }

    public function updateSettings(Request $request): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $key = trim((string)$request->body('key', ''));
        $value = trim((string)$request->body('value', ''));

        if (empty($key)) {
            Response::error('Setting key required.', 'VALIDATION_ERROR', 422);
        }

        Database::execute(
            "INSERT INTO system_settings (setting_key, setting_value, updated_by, updated_at)
             VALUES (:k, :v, :u, NOW())
             ON DUPLICATE KEY UPDATE setting_value = :v2, updated_by = :u2, updated_at = NOW()",
            [
                'k'  => $key,
                'v'  => $value,
                'u'  => Auth::id(),
                'v2' => $value,
                'u2' => Auth::id()
            ]
        );

        Response::success(null, 'Setting saved successfully');
    }
}
