# V10 Google Colab integration: user and operator guide

Verified scope on2026-11-01: **manual IPYNB code exchange is implemented and locally tested; the Enterprise execution adapter is prepared and disabled**. No authorized Google Cloud project was supplied. No live Colab runtime, Google job execution, GPU, trusted evaluation or inference endpoint is claimed.

The requested official sources are [ordinary Colab REST](https://developers.google.com/colab/api/reference/rest), [Colab MCP execute_code](https://developers.google.com/colab/api/reference/mcp/tools_list/execute_code) and [Colab Enterprise REST](https://docs.cloud.google.com/colab/docs/reference/rest). Ordinary REST manages the requesting user's runtimes; MCP can execute Python in those runtimes. Enterprise supplies IAM-managed notebook job resources. The implemented prepared adapter targets Enterprise, not unofficial Colab browser automation. [Full research and security comparison](V10_COLAB_RESEARCH.md).

## Student workflow that works now

1. Log in as a student, complete mandatory password rotation and open ML Workbench. Student accounts own their notebooks; administrators inspect original student work through AI SOC.
2. Select or explicitly create a notebook, edit cells and **save**. Download for Colab exports the latest saved MySQL code, not unsaved editor text.
3. Select **Download for Colab**. The authorized API returns a real version4 IPYNB download with code/markdown source. Stored execution outputs, attachments, arbitrary notebook metadata and credentials are not exported.
4. **Open Google Colab** opens Google's site in a separate tab. It does not log in for you, upload a notebook or transfer any dataset. Sign in to your own authorized Google account and upload the downloaded notebook yourself.
5. Run it in Google only if your account/runtime is eligible and you are authorized to transfer that code/data. Download the edited IPYNB from Colab when finished.
6. In ML Workbench's **Import Colab notebook** form, provide a new title, optional actively assigned ticket and the real `.ipynb` file. Submit **Import code only**. This explicit CSRF-protected POST creates a **new** student-owned MySQL notebook. It does not overwrite another notebook or import a foreign owner/ticket ID.
7. Reload and inspect the saved cells. Outputs, execution counts, embedded attachments and provenance claims from the uploaded document are discarded. Manual Colab execution is not thereby verified by VOSTOKPRIBOR; imported metrics cannot become SYSTEM_MEASURED or INDEPENDENTLY_VALIDATED.

Notebook exchange accepts at most2MiB, nbformat4, at most200 code/markdown cells and256KiB source per imported cell. Sources may use a string or an array of text lines. Unsupported cells, malformed JSON, invalid ownership/ticket references, absent real uploads and oversized files fail explicitly. A filename extension alone is insufficient. The provider request planner additionally caps its serialized base64-containing body at2MiB, so an exchangeable document may still be too large for a prepared remote request.

Do not upload real Data Center files to Google merely because they are assigned locally. Assignment grants local application access; external transfer requires authorization for the intended recipient, region and retention. There is **no automatic dataset transfer**, signed-download flow, model artifact upload, result ingestion or trusted measurement import in this release.

## APIs and SOC inspection

Paths are relative to the configured application's `/api/v1/`:

|Operation|Route and behavior|
|---|---|
|Student saved notebook download|`GET workbench/notebooks/{id}/export`; authorized own record; attachment rather than JSON|
|Explicit student import|`POST workbench/notebooks/import`; multipart `notebook_file`, `title`, optional `ticket_id`; CSRF required; creates new owned notebook with201|
|Availability|`GET workbench/execution-status`; real availability object; can_execute=false|
|Administrator provider inspection|`GET soc/execution-provider`; ADMIN only; sanitized configuration/availability, no token/path contents|
|Administrator code download|`GET soc/notebooks/{id}/export`; ADMIN route; exports original student's saved source without impersonating that student|
|Execution request|`POST execution-jobs`; session/ownership/payload checked; unavailable requests return503 and create no successful execution|

Compatibility notebook routes use the same service and permissions. AI SOC's Student Workspace Inspection displays the actual configuration status and unavailable-provider explanation. Runtime/GPU/quota usage is not invented. Existing local queue cancellation history is separate from a confirmed remote Google cancellation; it must never be interpreted as provider termination.

## Optional private operator configuration

Configuration prepares inspection/request construction only. **There is no activation flag.** Valid configuration and successful authentication do not make submit/cancel available. Do not broaden runtime MySQL privileges or expose Google credentials to students to make a probe succeed.

`.env.example` contains only the optional `COLAB_CONFIG_FILE=` setting. Leave it blank until an operator has a reviewed Google project. In an operator's private local `.env`, set it to an **absolute file path outside both project and web root**, for example:

```dotenv
COLAB_CONFIG_FILE=C:/Users/YOUR_USER/AppData/Local/VostokPrivate/colab-config.json
```

This path is an example location, not a bundled configuration or secret. Do not copy real configuration/credentials into the repository, storage, notebook contents, database, JavaScript, logs, screenshots or release ZIP. Protect the outside-webroot files using the operator account's Windows ACL and retain keys separately from source releases. Runtime access tokens are held only in PHP process memory, refreshed before expiry and never written to a token cache or MySQL.

The private JSON configuration has this schema; every example value must be replaced with an actually reviewed resource and the actual student ID. The example does not provision anything:

```json
{
  "project": "your-reviewed-project",
  "location": "us-central1",
  "runtime_template": "projects/your-reviewed-project/locations/us-central1/notebookRuntimeTemplates/your-reviewed-template",
  "output_bucket": "your-reviewed-private-output-bucket",
  "credentials_file": "C:/Users/YOUR_USER/AppData/Local/VostokPrivate/google-credentials.json",
  "execution_service_accounts": {
    "7": "vostok-student-7@your-reviewed-project.iam.gserviceaccount.com"
  },
  "timeout_seconds": 600
}
```

`project`, `location`, `runtime_template`, `output_bucket` and `credentials_file` are required for a valid configuration shape. The template must belong to that exact project and region. `execution_service_accounts` is an operator-managed map from actual database student IDs to unique per-student service-account emails in that project; request preparation rejects missing/shared/mismatched identities. `timeout_seconds` is an integer30–1800, default600. A bucket prefix or separate email is a plan, not proof of independently enforced IAM or filesystem isolation.

The prepared request uses the documented Enterprise notebookExecutionJobs create resource: explicit job ID, base64 directNotebookSource, reviewed runtime template, student execution serviceAccount, timeout and a student/job output location. `prepare()` constructs this request **offline** and returns submitted=false. It neither obtains credentials nor submits code or datasets. `submit()` and provider `cancel()` throw unavailable even with a valid plan. Enterprise's documented DELETE method is not treated as a verified cancellation API. [Create contract](https://docs.cloud.google.com/gemini-enterprise-agent-platform/reference/rest/v1/projects.locations.notebookExecutionJobs/create), [delete contract](https://docs.cloud.google.com/gemini-enterprise-agent-platform/reference/rest/v1/projects.locations.notebookExecutionJobs/delete).

## Authentication and transport limits

The explicit private credential file supports Google's `authorized_user` refresh-token format or `service_account` RSA signing format. The application does not generate a Google account, discover ADC automatically, contact a metadata server or implement Workload Identity Federation. Do not paste a credential sample into source. Authorized-user tokens retain their Google-granted permissions; requesting a client object does not establish that account's Colab eligibility.

OAuth exchanges use only `https://oauth2.googleapis.com/token`. Service-account assertions use RS256, intended audience/scope and one-hour lifetime; tokens refresh with a60-second safety margin and failed refresh never reuses stale credentials. The default Enterprise OAuth scope is cloud-platform. Credential files are bounded to128KiB and must stay outside source/web roots. The transport verifies TLS certificates/hostname, forbids redirects/proxies/arbitrary hosts/browser cookies/header injection, has5-second connect/30-second request deadlines, and2MiB request/response limits. Google errors are sanitized. The optional Cloud Storage transport allowance is read-only and does not implement a transfer/result workflow.

Google recommends workload credentials appropriate to the deployment environment. A production keyless/ADC/WIF implementation remains future work; the present explicit-file adapter is not a claim of a deployed keyless identity. Separate orchestration credentials from any execution identity and never run student code with administrator-wide cloud access. [Enterprise authentication](https://docs.cloud.google.com/colab/docs/authentication).

## CLI preflight

From the source tree with PHP and the existing configuration loader:

```powershell
& C:\xampp\php\php.exe bin\colab_preflight.php
```

Default behavior is **offline**. It inspects the private configuration shape if configured and prints sanitized availability, without logging in to Google, creating a runtime/job, running code, transferring data or reading SQL. It exits78 because execution remains unavailable. Expected observed state without configuration: provider=GOOGLE_COLAB_ENTERPRISE, configuration_status=NOT_CONFIGURED, integration_stage=PREPARED_NOT_LIVE_VERIFIED, can_execute=false and all data/evaluation/inference flags false. INVALID means the supplied configuration failed validation; PENDING_VERIFICATION is not an accepted provider.

An explicit operator probe is available only from CLI:

```powershell
& C:\xampp\php\php.exe bin\colab_preflight.php --probe-google
```

This requires actual operator-provided Google credentials/configuration. It may exchange OAuth credentials at the fixed token endpoint, then performs only a **read of the configured runtime template** through the regional Enterprise API. It does not create/change cloud resources, run a notebook or transfer a dataset. Failure output is sanitized. Even a successful authenticated template read reports live_execution_tested=false, isolation_verified=false, cancellation_verified=false, data_transferred=false and can_execute=false, and the CLI still exits78. No successful authenticated Google probe was performed for this release.

## What remains blocked

Before enabling a managed provider, supply an authorized project/region/account and accepted billing/quota budget, verify enabled APIs, review IAM/runtime template and network/storage restrictions, authorize external data handling and perform actual provider-backed tests. Defaults can expose public internet and user credentials; do not adopt them as the student isolation boundary. [Template controls](https://docs.cloud.google.com/colab/docs/create-runtime-template).

Required live tests include actual success/error output, expiration/revocation, output limits/retrieval, ambiguous submission/retry reconciliation, per-student negative access, resource/time quotas, cancellation acknowledgement, cleanup/expiration and orphan reconciliation. A mock HTTP response or parser test cannot replace these tests. Trusted model evaluation and inference serving are separate blocked providers; a notebook that prints accuracy or an administrative approval is not independent evidence or a running endpoint.

## Recorded verification

Protected evidence under `verification/v10-20261101/` records33 actual local HTTP code-exchange checks (`http-colab.log`),35 offline notebook/provider contracts (`colab-contract.log`),62 offline OAuth/HTTPS contracts (`google-auth-contracts.log`) and browser code roundtrip/responsive checks (`browser-colab.json`). These use isolated test data/synthetic credentials. The real browser saved/downloaded/imported code, while the Run control remained unavailable; no remote execution result was fabricated. `colab-preflight.json` records the actual unconfigured disabled state. See the final V10 test/report documents for the full regression and release evidence.
