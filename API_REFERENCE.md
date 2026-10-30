# API reference

Generated from the executable central router on 2026-10-30: **183 routes**, including 113 required contracts and compatibility aliases. All paths below are relative to the configured installation's `/api/v1/`.

The five registration files live in `api/v1/modules/`; `app/Core/ApiRoutes.php` loads them into one `Router`. Controllers call the shared services and repositories. Aliases do not create separate databases or business logic. Direct HTTP access to module files is forbidden.

Use the same cookie session for `GET auth/csrf` and each request. Send `X-CSRF-Token` for every POST/PATCH, including login. Login and password changes return a new token. Login uses `login,password`; own password rotation uses `current_password,new_password`. A required password change blocks business routes. There is no public registration.

Every `soc/*` route has the common active ADMIN gate. Legacy administrative routes still authorize in their controller/service. Student list and object operations are restricted to active assignments or original ownership, including referenced ticket/dataset/notebook/model IDs. Administrators inspect original student artifacts from SOC; student authoring endpoints cannot impersonate students.

Success: `{success:true,data:...,message:...}`. Failure: `{success:false,error:{code:...,message:...}}`. JSON mutations require an object; malformed JSON is 400, wrong shape/invalid fields 422, absent/expired authentication 401, role/CSRF/ownership failure 403, missing scoped object 403/404. Validation errors use 422. Disabled execution uses 503. File downloads return authorized bytes rather than a JSON envelope.

Important write payloads:

| Action | Fields |
| --- | --- |
| Create student | `identifier,full_name,email,password`; optional `cohort,department`; ADMIN only, password 12–72 bytes |
| Update student | Approved profile/status fields; role promotion is rejected |
| Reset student password | `new_password`; existing sessions revoked, mandatory student rotation |
| Create scenario | `code,title`; optional validated `builder_metadata` and descriptive fields; creation/import status must be DRAFT |
| Create/edit ticket | `ticket_code,title,description,requirements,acceptance_criteria,priority,deadline,scenario_id?,student_id?`; deadline `YYYY-MM-DD HH:MM:SS` |
| Assign/reassign ticket | `student_id`, optional `notes`; prior grants revoked, original private work preserved |
| Upload master/version | Multipart `dataset_file` CSV/JSON plus `code,name` for master, `version` for new version |
| Assign dataset | `student_id,ticket_id,dataset_version_id?`; active ticket assignment required |
| Revoke dataset | `student_id,ticket_id?`; historical assignments/files retained |
| Upload processed file | Multipart `processed_file,source_dataset_id,ticket_id,name,transformation_notes`; optional source version must be assigned |
| Create/save notebook | `title,ticket_id?,cells?`; save `cells:[{cell_type,source}]`; saved outputs cannot be forged |
| Create experiment/run | Experiment `name,ticket_id?`; run `experiment_id,run_name,notebook_id?`, optional user-reported parameters/metrics |
| Register/upload model | Metadata `model_code,name,framework,ticket_id?`; actual version multipart `artifact_file,version`, optional user-reported metrics |
| Request validation | `model_id,model_version_id`; actual artifact required, no trusted evaluator means `NOT_EVALUATED` |
| Deployment review request | `model_id,model_version_id,environment?,replicas?,canary_percentage?,idempotency_key?`; actual intact artifact required |
| SOC deployment decision | `status:APPROVED/REJECTED,notes?`; approve/reject aliases accept notes; never creates a runtime endpoint |
| SOC model annotations | `admin_label?,admin_notes?`; `status:ARCHIVED`, or `REGISTERED` for restore; student-authored fields rejected |
| Submit work | `ticket_id,notes,notebook_id?,model_id?,request_key?`; owned references must belong to that ticket |
| Review submission | `feedback,total_score?`; approve/reject/request-changes aliases choose status; fractional score 0–100 allowed |
| Save setting | `key,value`; only `student_help_text` or `platform_announcement`, maximum 4000 bytes |

Retries for progress, assignment, review, model annotations and identical settings avoid duplicate effects. Submission `request_key` and deployment `idempotency_key` prevent duplicate records; reusing a deployment key with different parameters is rejected. For optional scalar fields, send null or omit as documented by the service; do not send UI transport fields in annotation JSON. CSRF goes in the header.

Recorded experiment metrics are user claims. Artifact integrity checks are separate from trusted quality evidence. Deployment approval persists administrative intent only, with `provider_state=NOT_CONFIGURED`, no endpoint and no inference trace.

## Executable route inventory

| Method | Path | Handler | Route gate |
| --- | --- | --- | --- |
| GET | `auth/csrf` | `App\Controllers\AuthController::csrf` | Controller/service scope |
| POST | `auth/login` | `App\Controllers\AuthController::login` | Controller/service scope |
| GET | `auth/me` | `App\Controllers\AuthController::me` | Controller/service scope |
| POST | `auth/change-password` | `App\Controllers\AuthController::changePassword` | Controller/service scope |
| POST | `auth/logout` | `App\Controllers\AuthController::logout` | Controller/service scope |
| GET | `project/tickets` | `App\Controllers\TicketController::index` | Controller/service scope |
| GET | `project/tickets/{id}` | `App\Controllers\TicketController::show` | Controller/service scope |
| GET | `project/tickets/{id}/comments` | `App\Controllers\TicketController::comments` | Controller/service scope |
| POST | `project/tickets/{id}/comments` | `App\Controllers\TicketController::addComment` | Controller/service scope |
| GET | `tickets` | `App\Controllers\TicketController::index` | Controller/service scope |
| GET | `tickets/{id}` | `App\Controllers\TicketController::show` | Controller/service scope |
| GET | `tickets/{id}/comments` | `App\Controllers\TicketController::comments` | Controller/service scope |
| POST | `tickets/{id}/comments` | `App\Controllers\TicketController::addComment` | Controller/service scope |
| POST | `project/tickets/{id}/progress` | `App\Controllers\TicketController::progress` | Controller/service scope |
| GET | `project/dashboard` | `App\Controllers\TicketController::dashboard` | Controller/service scope |
| GET | `project/notifications` | `App\Controllers\TicketController::notifications` | Controller/service scope |
| POST | `tickets` | `App\Controllers\TicketController::store` | Controller/service scope |
| PATCH | `tickets/{id}` | `App\Controllers\TicketController::update` | Controller/service scope |
| POST | `tickets/{id}/assignments` | `App\Controllers\TicketController::assign` | Controller/service scope |
| GET | `project/submissions` | `App\Controllers\SubmissionController::index` | Controller/service scope |
| POST | `project/submissions` | `App\Controllers\SubmissionController::store` | Controller/service scope |
| GET | `project/submissions/{id}` | `App\Controllers\SubmissionController::show` | Controller/service scope |
| GET | `submissions` | `App\Controllers\SubmissionController::index` | Controller/service scope |
| POST | `submissions` | `App\Controllers\SubmissionController::store` | Controller/service scope |
| GET | `submissions/{id}` | `App\Controllers\SubmissionController::show` | Controller/service scope |
| POST | `submissions/{id}/review` | `App\Controllers\SubmissionController::review` | Controller/service scope |
| GET | `data/datasets` | `App\Controllers\DatasetController::index` | Controller/service scope |
| GET | `data/datasets/{id}` | `App\Controllers\DatasetController::show` | Controller/service scope |
| GET | `data/datasets/{id}/preview` | `App\Controllers\DatasetController::preview` | Controller/service scope |
| GET | `data/datasets/{id}/download` | `App\Controllers\DatasetController::download` | Controller/service scope |
| GET | `data/datasets/{id}/versions` | `App\Controllers\DatasetController::versions` | Controller/service scope |
| GET | `data/processed` | `App\Controllers\DatasetController::processedIndex` | Controller/service scope |
| POST | `data/processed` | `App\Controllers\DatasetController::storeProcessed` | Controller/service scope |
| GET | `data/processed/{id}` | `App\Controllers\DatasetController::processedShow` | Controller/service scope |
| GET | `data/processed/{id}/download` | `App\Controllers\DatasetController::processedDownload` | Controller/service scope |
| GET | `data/activity` | `App\Controllers\DatasetController::activityIndex` | Controller/service scope |
| GET | `datasets` | `App\Controllers\DatasetController::index` | Controller/service scope |
| POST | `datasets` | `App\Controllers\DatasetController::store` | Controller/service scope |
| POST | `datasets/processed` | `App\Controllers\DatasetController::storeProcessed` | Controller/service scope |
| GET | `datasets/{id}` | `App\Controllers\DatasetController::show` | Controller/service scope |
| GET | `datasets/{id}/preview` | `App\Controllers\DatasetController::preview` | Controller/service scope |
| GET | `datasets/{id}/download` | `App\Controllers\DatasetController::download` | Controller/service scope |
| GET | `datasets/{id}/versions` | `App\Controllers\DatasetController::versions` | Controller/service scope |
| POST | `datasets/{id}/assignments` | `App\Controllers\DatasetController::assign` | Controller/service scope |
| GET | `workbench/notebooks` | `App\Controllers\NotebookController::index` | Controller/service scope |
| POST | `workbench/notebooks` | `App\Controllers\NotebookController::store` | Controller/service scope |
| GET | `workbench/notebooks/{id}` | `App\Controllers\NotebookController::show` | Controller/service scope |
| PATCH | `workbench/notebooks/{id}` | `App\Controllers\NotebookController::update` | Controller/service scope |
| GET | `notebooks` | `App\Controllers\NotebookController::index` | Controller/service scope |
| POST | `notebooks` | `App\Controllers\NotebookController::store` | Controller/service scope |
| GET | `notebooks/{id}` | `App\Controllers\NotebookController::show` | Controller/service scope |
| PATCH | `notebooks/{id}` | `App\Controllers\NotebookController::update` | Controller/service scope |
| GET | `workbench/experiments` | `App\Controllers\ExperimentController::index` | Controller/service scope |
| POST | `workbench/experiments` | `App\Controllers\ExperimentController::store` | Controller/service scope |
| GET | `workbench/experiments/{id}` | `App\Controllers\ExperimentController::show` | Controller/service scope |
| GET | `experiments` | `App\Controllers\ExperimentController::index` | Controller/service scope |
| POST | `experiments` | `App\Controllers\ExperimentController::store` | Controller/service scope |
| GET | `experiments/{id}` | `App\Controllers\ExperimentController::show` | Controller/service scope |
| GET | `workbench/runs` | `App\Controllers\ExperimentController::listRuns` | Controller/service scope |
| POST | `workbench/runs` | `App\Controllers\ExperimentController::storeRun` | Controller/service scope |
| GET | `experiment-runs` | `App\Controllers\ExperimentController::listRuns` | Controller/service scope |
| POST | `experiment-runs` | `App\Controllers\ExperimentController::storeRun` | Controller/service scope |
| GET | `workbench/artifacts` | `App\Controllers\ModelController::artifacts` | Controller/service scope |
| GET | `workbench/execution-status` | `App\Controllers\ExecutionController::status` | Controller/service scope |
| POST | `execution-jobs` | `App\Controllers\ExecutionController::store` | Controller/service scope |
| GET | `execution-jobs/{id}` | `App\Controllers\ExecutionController::show` | Controller/service scope |
| POST | `execution-jobs/{id}/cancel` | `App\Controllers\ExecutionController::cancel` | Controller/service scope |
| GET | `registry/models` | `App\Controllers\ModelController::index` | Controller/service scope |
| POST | `registry/models` | `App\Controllers\ModelController::store` | Controller/service scope |
| GET | `registry/models/{id}` | `App\Controllers\ModelController::show` | Controller/service scope |
| GET | `registry/models/{id}/versions` | `App\Controllers\ModelController::versions` | Controller/service scope |
| POST | `registry/models/{id}/versions` | `App\Controllers\ModelController::addVersion` | Controller/service scope |
| GET | `models` | `App\Controllers\ModelController::index` | Controller/service scope |
| POST | `models` | `App\Controllers\ModelController::store` | Controller/service scope |
| GET | `models/{id}` | `App\Controllers\ModelController::show` | Controller/service scope |
| GET | `models/{id}/versions` | `App\Controllers\ModelController::versions` | Controller/service scope |
| POST | `models/{id}/versions` | `App\Controllers\ModelController::addVersion` | Controller/service scope |
| GET | `registry/validations` | `App\Controllers\ValidationController::index` | Controller/service scope |
| POST | `registry/validations` | `App\Controllers\ValidationController::store` | Controller/service scope |
| GET | `registry/validations/{id}` | `App\Controllers\ValidationController::show` | Controller/service scope |
| GET | `validation-runs` | `App\Controllers\ValidationController::index` | Controller/service scope |
| POST | `validation-runs` | `App\Controllers\ValidationController::store` | Controller/service scope |
| GET | `validation-runs/{id}` | `App\Controllers\ValidationController::show` | Controller/service scope |
| GET | `registry/deployments` | `App\Controllers\DeploymentController::index` | Controller/service scope |
| GET | `deployments` | `App\Controllers\DeploymentController::index` | Controller/service scope |
| GET | `registry/deployment-requests` | `App\Controllers\DeploymentController::index` | Controller/service scope |
| POST | `registry/deployment-requests` | `App\Controllers\DeploymentController::store` | Controller/service scope |
| GET | `deployment-requests` | `App\Controllers\DeploymentController::index` | Controller/service scope |
| POST | `deployment-requests` | `App\Controllers\DeploymentController::store` | Controller/service scope |
| PATCH | `deployments/{id}` | `App\Controllers\DeploymentController::update` | Controller/service scope |
| GET | `soc/overview` | `App\Controllers\AdminController::overview` | Active ADMIN |
| GET | `soc/system-health` | `App\Controllers\AdminController::health` | Active ADMIN |
| GET | `soc/activity` | `App\Controllers\AdminController::auditLogs` | Active ADMIN |
| GET | `soc/audit-logs` | `App\Controllers\AdminController::auditLogs` | Active ADMIN |
| GET | `soc/settings` | `App\Controllers\AdminController::getSettings` | Active ADMIN |
| PATCH | `soc/settings` | `App\Controllers\AdminController::updateSettings` | Active ADMIN |
| GET | `soc/tickets/summary` | `App\Controllers\AdminController::ticketSummary` | Active ADMIN |
| GET | `soc/datasets/summary` | `App\Controllers\AdminController::datasetSummary` | Active ADMIN |
| GET | `soc/models/summary` | `App\Controllers\AdminController::modelSummary` | Active ADMIN |
| GET | `soc/students` | `App\Controllers\UserController::index` | Active ADMIN |
| POST | `soc/students` | `App\Controllers\UserController::store` | Active ADMIN |
| GET | `soc/students/{id}` | `App\Controllers\UserController::show` | Active ADMIN |
| PATCH | `soc/students/{id}` | `App\Controllers\UserController::update` | Active ADMIN |
| GET | `soc/students/{id}/summary` | `App\Controllers\SocTrainingController::studentProgress` | Active ADMIN |
| GET | `soc/tickets` | `App\Controllers\TicketController::index` | Active ADMIN |
| POST | `soc/tickets` | `App\Controllers\TicketController::store` | Active ADMIN |
| GET | `soc/tickets/{id}` | `App\Controllers\TicketController::show` | Active ADMIN |
| PATCH | `soc/tickets/{id}` | `App\Controllers\TicketController::update` | Active ADMIN |
| POST | `soc/tickets/{id}/assign` | `App\Controllers\TicketController::assign` | Active ADMIN |
| POST | `soc/tickets/{id}/reassign` | `App\Controllers\SocTrainingController::reassignTicket` | Active ADMIN |
| POST | `soc/tickets/{id}/cancel` | `App\Controllers\SocTrainingController::cancelTicket` | Active ADMIN |
| GET | `soc/tickets/{id}/students` | `App\Controllers\SocTrainingController::ticketStudents` | Active ADMIN |
| GET | `soc/tickets/{id}/datasets` | `App\Controllers\SocTrainingController::ticketDatasets` | Active ADMIN |
| GET | `soc/tickets/{id}/submissions` | `App\Controllers\SocTrainingController::ticketSubmissions` | Active ADMIN |
| GET | `soc/scenarios` | `App\Controllers\ScenarioController::index` | Active ADMIN |
| POST | `soc/scenarios` | `App\Controllers\ScenarioController::store` | Active ADMIN |
| GET | `soc/scenarios/{id}` | `App\Controllers\ScenarioController::show` | Active ADMIN |
| PATCH | `soc/scenarios/{id}` | `App\Controllers\ScenarioController::update` | Active ADMIN |
| POST | `soc/scenarios/{id}/publish` | `App\Controllers\SocTrainingController::publishScenario` | Active ADMIN |
| POST | `soc/scenarios/{id}/archive` | `App\Controllers\SocTrainingController::archiveScenario` | Active ADMIN |
| GET | `soc/scenarios/{id}/tickets` | `App\Controllers\SocTrainingController::scenarioTickets` | Active ADMIN |
| GET | `soc/scenarios/{id}/datasets` | `App\Controllers\SocTrainingController::scenarioDatasets` | Active ADMIN |
| GET | `soc/scenarios/{id}/students` | `App\Controllers\SocTrainingController::scenarioStudents` | Active ADMIN |
| GET | `soc/submissions` | `App\Controllers\SubmissionController::index` | Active ADMIN |
| GET | `soc/submissions/{id}` | `App\Controllers\SubmissionController::show` | Active ADMIN |
| POST | `soc/submissions/{id}/approve` | `App\Controllers\SocTrainingController::approveSubmission` | Active ADMIN |
| POST | `soc/submissions/{id}/reject` | `App\Controllers\SocTrainingController::rejectSubmission` | Active ADMIN |
| POST | `soc/submissions/{id}/request-changes` | `App\Controllers\SocTrainingController::requestChanges` | Active ADMIN |
| POST | `soc/students/{id}/activate` | `App\Controllers\SocTrainingController::activate` | Active ADMIN |
| POST | `soc/students/{id}/deactivate` | `App\Controllers\SocTrainingController::deactivate` | Active ADMIN |
| POST | `soc/students/{id}/reset-password` | `App\Controllers\SocTrainingController::resetPassword` | Active ADMIN |
| GET | `soc/students/{id}/progress` | `App\Controllers\SocTrainingController::studentProgress` | Active ADMIN |
| GET | `soc/students/{id}/activity` | `App\Controllers\SocTrainingController::studentActivity` | Active ADMIN |
| GET | `soc/students/{id}/tickets` | `App\Controllers\SocTrainingController::studentTickets` | Active ADMIN |
| GET | `soc/students/{id}/datasets` | `App\Controllers\SocTrainingController::studentDatasets` | Active ADMIN |
| GET | `soc/students/{id}/notebooks` | `App\Controllers\SocTrainingController::studentNotebooks` | Active ADMIN |
| GET | `soc/students/{id}/experiments` | `App\Controllers\SocTrainingController::studentExperiments` | Active ADMIN |
| GET | `soc/students/{id}/models` | `App\Controllers\SocTrainingController::studentModels` | Active ADMIN |
| GET | `soc/students/{id}/submissions` | `App\Controllers\SocTrainingController::studentSubmissions` | Active ADMIN |
| GET | `soc/datasets` | `App\Controllers\SocDatasetController::index` | Active ADMIN |
| POST | `soc/datasets` | `App\Controllers\SocDatasetController::store` | Active ADMIN |
| GET | `soc/datasets/{id}` | `App\Controllers\SocDatasetController::show` | Active ADMIN |
| PATCH | `soc/datasets/{id}` | `App\Controllers\SocDatasetController::update` | Active ADMIN |
| GET | `soc/datasets/{id}/versions` | `App\Controllers\SocDatasetController::versions` | Active ADMIN |
| POST | `soc/datasets/{id}/versions` | `App\Controllers\SocDatasetController::addVersion` | Active ADMIN |
| POST | `soc/datasets/{id}/assign` | `App\Controllers\SocDatasetController::assign` | Active ADMIN |
| POST | `soc/datasets/{id}/revoke` | `App\Controllers\SocDatasetController::revoke` | Active ADMIN |
| POST | `soc/datasets/{id}/archive` | `App\Controllers\SocDatasetController::archive` | Active ADMIN |
| GET | `soc/datasets/{id}/assignments` | `App\Controllers\SocDatasetController::assignments` | Active ADMIN |
| GET | `soc/datasets/{id}/activity` | `App\Controllers\SocDatasetController::activity` | Active ADMIN |
| GET | `soc/datasets/{id}/preview` | `App\Controllers\SocDatasetController::preview` | Active ADMIN |
| GET | `soc/datasets/{id}/download` | `App\Controllers\SocDatasetController::download` | Active ADMIN |
| GET | `soc/notebooks` | `App\Controllers\SocWorkspaceController::notebooks` | Active ADMIN |
| GET | `soc/notebooks/{id}` | `App\Controllers\SocWorkspaceController::notebook` | Active ADMIN |
| GET | `soc/experiments` | `App\Controllers\SocWorkspaceController::experiments` | Active ADMIN |
| GET | `soc/experiments/{id}` | `App\Controllers\SocWorkspaceController::experiment` | Active ADMIN |
| GET | `soc/experiment-runs` | `App\Controllers\SocWorkspaceController::runs` | Active ADMIN |
| GET | `soc/execution-jobs` | `App\Controllers\SocWorkspaceController::jobs` | Active ADMIN |
| GET | `soc/execution-jobs/{id}` | `App\Controllers\SocWorkspaceController::job` | Active ADMIN |
| POST | `soc/execution-jobs/{id}/cancel` | `App\Controllers\SocWorkspaceController::cancelJob` | Active ADMIN |
| GET | `soc/models` | `App\Controllers\SocWorkspaceController::models` | Active ADMIN |
| GET | `soc/models/{id}` | `App\Controllers\SocWorkspaceController::model` | Active ADMIN |
| PATCH | `soc/models/{id}` | `App\Controllers\SocWorkspaceController::updateModel` | Active ADMIN |
| GET | `soc/models/{id}/versions` | `App\Controllers\SocWorkspaceController::versions` | Active ADMIN |
| GET | `soc/validations` | `App\Controllers\SocWorkspaceController::validations` | Active ADMIN |
| GET | `soc/validations/{id}` | `App\Controllers\SocWorkspaceController::validation` | Active ADMIN |
| GET | `soc/deployment-requests` | `App\Controllers\SocWorkspaceController::deploymentRequests` | Active ADMIN |
| GET | `soc/deployments` | `App\Controllers\SocWorkspaceController::deploymentRequests` | Active ADMIN |
| POST | `soc/deployment-requests/{id}/approve` | `App\Controllers\SocWorkspaceController::approveDeployment` | Active ADMIN |
| POST | `soc/deployment-requests/{id}/reject` | `App\Controllers\SocWorkspaceController::rejectDeployment` | Active ADMIN |
| PATCH | `soc/deployment-requests/{id}` | `App\Controllers\SocWorkspaceController::reviewDeployment` | Active ADMIN |
| GET | `users` | `App\Controllers\UserController::index` | Controller/service scope |
| POST | `users` | `App\Controllers\UserController::store` | Controller/service scope |
| GET | `users/{id}` | `App\Controllers\UserController::show` | Controller/service scope |
| PATCH | `users/{id}` | `App\Controllers\UserController::update` | Controller/service scope |
| GET | `scenarios` | `App\Controllers\ScenarioController::index` | Controller/service scope |
| POST | `scenarios` | `App\Controllers\ScenarioController::store` | Controller/service scope |
| GET | `scenarios/{id}` | `App\Controllers\ScenarioController::show` | Controller/service scope |
| PATCH | `scenarios/{id}` | `App\Controllers\ScenarioController::update` | Controller/service scope |
| GET | `admin/overview` | `App\Controllers\AdminController::overview` | Controller/service scope |
| GET | `admin/audit-logs` | `App\Controllers\AdminController::auditLogs` | Controller/service scope |
| GET | `admin/settings` | `App\Controllers\AdminController::getSettings` | Controller/service scope |
| PATCH | `admin/settings` | `App\Controllers\AdminController::updateSettings` | Controller/service scope |

The route contract and actual HTTP coverage are in `verification/integration-20261030/` (distributed separately in the evidence archive). The disabled execution route is intentionally exercised as 503, not a successful runtime execution.
