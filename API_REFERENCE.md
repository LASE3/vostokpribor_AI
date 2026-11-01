# API reference — Version 10

Verified against the executable central router on 2026-11-01: **189 routes**, including 113 required contracts and compatibility aliases. All paths below are relative to the configured installation's `/api/v1/`.

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
| Create experiment/run | Experiment `name,ticket_id?`; run `experiment_id,run_name,notebook_id?,dataset_version_id?`, optional user-reported `parameters,metrics` |
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

## Version 10 Colab exchange and role routing

ADMIN login/password rotation returns the SOC Dashboard in redirect_url; root HTML redirects there. STUDENT returns index.php with exactly four student systems. Student SOC HTML/API requests are403; administrator requests to student HTML systems are403. These HTML boundaries do not remove legitimate administrator object inspection through guarded SOC APIs.

Six additive routes preserve the existing183 contracts:

|Method|Path|Behavior|
|---|---|---|
|GET|workbench/notebooks/{id}/export|Authorized saved notebook as a private .ipynb attachment; outputs/execution claims omitted|
|GET|notebooks/{id}/export|Compatibility alias of the same export|
|POST|workbench/notebooks/import|Multipart notebook_file .ipynb plus title and optional assigned ticket_id; creates a new student-owned code-only notebook|
|POST|notebooks/import|Compatibility alias of the same explicit import|
|GET|soc/notebooks/{id}/export|ADMIN inspection of the original saved notebook code|
|GET|soc/execution-provider|ADMIN view of redacted provider configuration/availability; never a credential or activation endpoint|

Import requires a real uploaded UTF-8 nbformat4 JSON file, at most2MiB/200 code-or-markdown cells/256KiB per source. String/list-of-string sources are accepted. Foreign owner/resource metadata, execution counts, rich outputs, attachments and provenance are discarded. No Python runs. Registration remains explicit POST with normal CSRF/origin/rate/ownership controls. Export returns application/x-ipynb+json and no-store; it reads the saved version, never unsaved browser text. Administrators inspect via SOC and cannot import student-authored work.

GET workbench/execution-status returns provider=GOOGLE_COLAB_ENTERPRISE, status=UNAVAILABLE, can_execute=false, configuration_status=NOT_CONFIGURED/INVALID/PENDING_VERIFICATION, integration_stage=PREPARED_NOT_LIVE_VERIFIED and disabled dataset-transfer/evaluation/inference flags. No credential path/token/project secret is exposed. POST execution-jobs remains503 after ownership checks; no job is fabricated. Existing history/cancellation concerns local legacy queue state only and does not claim Google termination.

The Enterprise adapter prepares the documented notebookExecutionJobs create payload offline; it does not submit even with credentials. colab_preflight.php defaults to offline availability and always exits78; --probe-google is an explicit operator CLI authenticated read-only runtime-template probe. No live probe or Google execution was possible without a project/authentication. Manual Colab exchange is verified; provider-backed execution, result persistence, isolation, cancellation, quality evaluation and serving remain BLOCKED. [Implementation/configuration guide](docs/V10_COLAB_INTEGRATION.md).

## Version 9 collection windows

Resource collections for tickets, datasets, processed datasets, scenarios, notebooks, experiments, runs, models, artifact versions, validations, deployment requests and SOC related-resource lists accept `limit` and `offset`. The shared default is `limit=100,offset=0`; the server clamps a valid limit to200. Values must be whole decimal numbers: limit at least1, offset at least0, each at most2147483647. Invalid values return422. Filters and ownership apply to both the count and the selected window. Stable ordering includes the record ID as a tie breaker.

These responses retain the historical `data` array and add top-level metadata:

```json
{
  "success": true,
  "data": [],
  "pagination": {
    "total": 0,
    "limit": 100,
    "offset": 0,
    "returned": 0,
    "has_more": false,
    "next_offset": null,
    "previous_offset": null
  },
  "message": "Operation completed successfully"
}
```

The example is an empty response shape, not fixture content. `total` is the full authorized, filtered count; `data.length` is only this window. Follow `next_offset` until `has_more=false`, with an advancing-offset guard, when an explicit export needs the full catalog. A limit larger than200 never requests an unbounded export. Browser pages use smaller25/50-record windows and visible controls. Totals used by dashboards come from scoped aggregate queries, not the displayed slice.

Student account lists (`users` and `soc/students`) preserve their older response shape: `data:{items:[],total:0,limit:50,offset:0}`. Their default limit is50 and maximum100. Dossiers return independently paged arrays under `data`, with `data.pagination[collection]`; use a shared `limit` (default50) and `<collection>_offset` for `tickets,datasets,processed_datasets,notebooks,experiments,models,submissions`. The dossier's `experiments` collection contains recorded run summaries. Experiment details expose `runs` and `runs_pagination`; model details expose `versions` and `versions_pagination`. Their nested windows use `limit,offset`. An authorized dataset preview is a file preview, not collection pagination: its `limit` defaults20 and must be1–50.

## Version 9 scenarios and lifecycle

Authenticated ADMIN requests use `GET scenarios` or its `soc/scenarios` alias. The default list includes top-level `pagination` and `summary`. Supported filters are `status,search,department,level,category`; `level` accepts `Level 1`, `Level 2` or `Level 3`. Search covers persisted code/title/description/department/author/tags; department is an exact persisted value. The summary contains unfiltered database totals (`total,active_published,active,tickets,students,cohorts`), so it can differ from a filtered page's count.

`GET scenarios?view=summary` returns those totals under `data`. `view=departments` and `view=cohorts` return paged `data:[{value:...}]` options with optional `search,limit,offset`. Departments originate from saved scenarios; cohorts from active student accounts. Unknown views, unsupported statuses and malformed filters return422. These are views of the existing authenticated GET route, not new public endpoints.

The server supports these transitions; writing the current status again is also accepted:

| Current status | Permitted next statuses |
| --- | --- |
| `DRAFT` | `READY_FOR_REVIEW`, `ARCHIVED` |
| `READY_FOR_REVIEW` | `DRAFT`, `PUBLISHED`, `ARCHIVED` |
| `PUBLISHED` | `ACTIVE`, `DRAFT`, `ARCHIVED` |
| `ACTIVE` | `COMPLETED`, `PUBLISHED`, `ARCHIVED` |
| `COMPLETED` | `ACTIVE`, `ARCHIVED` |
| `ARCHIVED` | `DRAFT` |

UI labels Draft/Review/Published/Active/Completed/Archived map to these exact values; Review means `READY_FOR_REVIEW`. Create/import/duplicate uses an explicit POST and always starts at `DRAFT`. Edit/lifecycle changes use authenticated writes with CSRF and the loaded `expected_revision`. The publish alias explicitly advances a draft through `READY_FOR_REVIEW` and then `PUBLISHED` in one transaction; other publish/archive transitions follow the table. A stale supplied revision returns409 without overwriting. A successful response and subsequent reload establish persistence; browser-local storage is not scenario persistence.

`builder_metadata` is a typed JSON object (schema_version1, maximum200KB) preserving the ten-step editor's `form_fields,datasets,workflow`. Approved form-field prefixes are validated; dataset links must identify existing uploaded datasets. Dates must be real `YYYY-MM-DD` values with deadline on/after start. Published/active/completed rubric weights, when supplied, must total100. The backend derives author, relationship counts and revision; imported counters/history do not establish those facts. Scenario export explicitly pages through the authenticated collection; import performs individual validated writes and reports the number confirmed before a partial failure.

## Version 9 run provenance and disabled execution

`POST workbench/runs` (alias `experiment-runs`) records metadata only. An optional `notebook_id` must belong to the same student and ticket as the experiment. Optional `dataset_version_id` must be a real version actively assigned to that student for that experiment's ticket; a different student's grant, wrong ticket, absent version or missing ticket is rejected. The authorization is checked again within the write transaction.

New manual runs persist `status=RECORDED,measurement_source=USER_REPORTED,duration_seconds=null`, and return `trusted_measurement=false`. Client-supplied status, duration or provenance cannot elevate these claims. Migration008 adds nullable dataset-version provenance and source categories without promoting historical measurements: older rows default `UNKNOWN`. Read responses always retain `trusted_measurement=false` until an actual trusted producer is implemented. Neither manual metrics nor uploaded JSON constitute quality-validation evidence.

`GET workbench/execution-status` returns `status=UNAVAILABLE,can_execute=false` with the missing-isolation reason. The submission route is **`POST execution-jobs`**, with required `notebook_id,code_to_execute`; there is no `workbench/execution/jobs` route. Valid authorized requests receive503 `EXECUTION_UNAVAILABLE` and create no job. Missing fields still return422, and notebook ownership/missing-object checks still apply. No HTTP process launches Python, and a feature flag cannot enable host subprocess execution. `GET execution-jobs/{id}` reads authorized stored history; cancellation changes only a persisted queued/running state and does not claim runtime termination. Trusted evaluation, restricted dataset SQL and inference serving remain unavailable; approval of a deployment request never creates a live endpoint.

## Test targets and installation prefixes

Build URLs from the configured installation prefix, including nested XAMPP paths; do not assume `/api/v1` is at the host root. Authenticated real HTTP tests require a separate saved `APP_ENV=testing`, loopback `_test` database, loopback APP_URL, independent storage and a separate session cookie ending `_test`. Their preflight compares the exact TEST_BASE_URL with CLI configuration and checks the actual HTTP-issued test cookie before loading/sending credentials. TEST_CREDENTIALS_FILE stays outside the source/webroot and is keyed by the exact database. File-writing PHP suites also require `tests/prepare_storage.php` in an empty separate test tree; process environment overrides alone are refused. These controls belong to CLI tests and add no public configuration diagnostic endpoint. See [V9 test results](docs/V9_TEST_RESULTS.md) for observed HTTP/browser/SQL results and blocked acceptance steps.

## Version 7 server routing and security

Actual XAMPP main and nested test prefixes are checked over HTTP. REST/old-dashboard regex quantifiers must be `.*`, not escaped literal asterisks. All183 main anonymous probes now reach PHP authentication/CSRF instead of Apache404. Authenticated isolated calls establish positive business behavior. Unknown routes/missing scoped objects still intentionally return404.

Relational `{id}` parameters must be positive signed-INT values through2147483647; suffixes/overflow/zero/negative IDs return422 after authentication. Execution-job string IDs retain compatibility. JSON media type matching is exact and case insensitive with optional charset; bodies must be objects within parser depth. Malformed nested file metadata returns422.

Legacy `api/models.php`, `api/exchange.php`, `api/status.php` are GET-only catalogs/status. Other methods return405 with `Allow: GET` after authorization; they are not duplicate write APIs. PHP PATH_INFO is unsupported; REST paths use the central rewrite.

Same-origin writes also validate browser Origin, without wildcard/credential CORS grants or permissive preflight. CSRF remains mandatory without Origin. Shared security headers include compatible CSP, frame/nosniff/referrer/permissions/cache controls. CSP permits existing inline handlers/styles and Google font/style origins; it is not a strict nonce policy. HSTS is production+actual HTTPS only. Forwarded client headers do not establish trusted HTTPS.

Production requires APP_DEBUG=false, SESSION_SECURE=true, HTTPS APP_URL/actual webserver HTTPS, non-root DB_USER/nonempty DB_PASS. Invalid settings fail closed with generic503 (JSON CONFIGURATION_UNAVAILABLE for APIs) before session/DB. Actual grants/TLS/runtime support require deployment verification. Nondebug500 responses omit exception/SQL details; expected field/ownership/conflict errors retain useful feedback/status. No public database/config diagnostic endpoint is added.

All five system entry links/folder defaults open their Dashboard. ML Workbench's new dashboard uses scoped persisted counts/bounded recent lists; it adds no duplicate API architecture or runner. Existing named feature URLs remain valid.

## Stability and compatibility

Only `AI Operations Center (AI SOC)/Dashboard.php` renders SOC monitoring. Old OperationsDashboard bookmarks receive308 with their query string preserved; no duplicate PHP dashboard remains.

GET `soc/deployments`, `registry/deployments` and `deployments` now return the verified runtime inventory: `data:[]`, `availability:{status:"NOT_CONFIGURED",runtime_enabled:false}`. Request history remains at `soc/deployment-requests`, `registry/deployment-requests` and `deployment-requests`. Migrate clients that formerly read requests using a deployments URL. Administrative approval never supplies runtime evidence.

Notebook PATCH supports `expected_version` from the loaded notebook. Scenario GET/list returns `revision`; PATCH and publish/archive accept `expected_revision`. A stale supplied precondition is409 CONFLICT with no overwrite. Current editors always send it and retain unsaved input on conflict. Older clients that omit a token keep their compatibility behavior and must migrate to receive stale-editor protection.

Admission is atomic in the existing rate_limits table: failed login5/120s shared HTML/API, authentication requests120/60s; authenticated API and HTML writes120/60s and multipart uploads20/60s per user. API_MUTATION_LIMIT/API_UPLOAD_LIMIT/API_RATE_WINDOW_SECONDS configure writes. CSRF is checked first; exact POST sign-out remains available after exhaustion. Selected file-heavy/full-catalog/SOC-summary GETs share API_EXPENSIVE_READ_LIMIT (default60/window) across canonical/legacy/mixed-case/slash aliases and selected HTML views. Ordinary/auth/recovery reads remain uncounted.429 includes Retry-After and API retry_after details. Upstream anonymous/read abuse controls remain deployment work.

RangeClient deadlines cover fetch and response parsing:15s normal,120s multipart, configurable via VOSTOK_API_TIMEOUT_MS/VOSTOK_UPLOAD_TIMEOUT_MS browser globals or per-request timeoutMs (max600s). Read outcomes TIMEOUT/CANCELLED are failures. Interrupted/network-failed writes report UNKNOWN_OUTCOME: inspect persisted records before another deliberate attempt. No automatic retries occur, including429. HTTP statuses400/401/403/404/409/429/500 preserve failure rather than claiming success; malformed required-null values fail422.

Native PDO is enabled after fixing repeated search placeholders and running the complete contract/HTTP tests. Local CSS/JS asset revisions prevent stale cached handlers; same-origin session/CSRF and multipart behavior remain unchanged. Legacy raw model catalog links use the configured installation prefix.

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
| GET | `registry/deployments` | `App\Controllers\DeploymentController::deployed` | Controller/service scope |
| GET | `deployments` | `App\Controllers\DeploymentController::deployed` | Controller/service scope |
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
| GET | `soc/deployments` | `App\Controllers\SocWorkspaceController::deployments` | Active ADMIN |
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

The route contract and actual HTTP coverage are in `verification/v6-20261031/` (distributed separately in the evidence archive). The disabled execution route is intentionally exercised as 503, not a successful runtime execution.
