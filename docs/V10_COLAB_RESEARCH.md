# V10 Colab provider research

Research date:2026-11-01, Asia/Amman. Sources below are official Google service documentation or the primary MCP specification. This document records documented contracts and engineering recommendations. Reading a reference is not a live provider test. No Google account credentials, billed resource, dataset transfer or provider execution was used for this research.

## Decision and scope

For centrally managed, multi-student execution, the preferred production direction is **Colab Enterprise notebook execution jobs** with a reviewed runtime template, per-student execution identity, isolated input/output access and an independently accepted cancellation/cleanup policy. It has documented server-side job resources, IAM and Cloud Storage results. Ordinary Colab REST/MCP is a supported alternative for a separately authorized student's own eligible runtime; a shared administrator Google identity is not an acceptable student boundary. These are engineering conclusions from the contracts below, not a Google certification of this application's deployment.

Keep execution disabled until provider-backed acceptance proves account eligibility, credentials, resource/network/storage isolation, quotas/billing, real outputs, timeout/cancellation and cleanup. An adapter and contract tests can be implemented without claiming those deployment gates passed. Neither an API key nor a configured provider name establishes authorization or isolation. [Ordinary API](https://developers.google.com/colab/api/reference/rest), [Enterprise API](https://docs.cloud.google.com/colab/docs/reference/rest).

## Ordinary Colab REST

Service is `https://colaboratory.googleapis.com`. Documented runtime methods are `POST /v1beta/runtimes`, `GET /v1beta/runtimes`, `GET /v1beta/runtimes/{id}` and `DELETE /v1beta/runtimes/{id}`. Eligibility discovery is `GET /v1beta/runtimespecs`; `GET /v1beta/subscription` reads the requesting user's subscription. There is no ordinary REST `/execute` endpoint in the supplied resource map. Execution uses the documented Jupyter connection or MCP instead. Runtime lists/get operations belong to the requesting user. [REST map](https://developers.google.com/colab/api/reference/rest).

Runtime creation requires OAuth scope `https://www.googleapis.com/auth/colaboratory`. Use a UUID4 `requestId` for request deduplication; create without it is not documented idempotent. `runtimeId`, when specified, follows the published1–63-character lowercase DNS-style rules. Creation returns a long-running operation; HTTP success alone is not a ready runtime. The API enforces per-project and per-user request quotas, and the actual project limits must be inspected after enablement. [Create](https://developers.google.com/colab/api/reference/rest/v1beta/runtimes/create).

The spec discovery result contains runtime keys and an `eligible` flag for the requesting user. Never assume GPU/model entitlement or show a hardcoded accelerator as available. The documented read scopes are `colaboratory` and `colaboratory.readonly`. User-specific eligibility is not proof that a service account or shared pooled identity supports this educational application. That requires actual authorized testing. [Specs](https://developers.google.com/colab/api/reference/rest/v1beta/runtimespecs/list).

Runtime connectionInfo contains a URL, short-lived token and expireTime. Jupyter clients send `X-Colab-Runtime-Proxy-Token`; `runtimes.get` refreshes it near expiry. These values are credentials and must never be included in student JSON, notebook cells, logs or screenshots. Only a validated Google-supplied URL may be contacted; user-controlled arbitrary destinations must not become an SSRF channel. Runtime variants/shapes come from provider specs. [Runtime and connection contract](https://developers.google.com/colab/api/reference/rest/v1beta/runtimes).

## Colab MCP execution

Google's official endpoint is `https://colaboratory.googleapis.com/mcp`. Server setup and authentication are required. The tools include create/list runtimes and create/delete sessions plus execute_code. A provider client must use the provider's actual authenticated capabilities; a browser cookie scraper or unofficial website automation is unnecessary and prohibited for this integration. [MCP service](https://developers.google.com/colab/api/reference/mcp).

`execute_code` accepts `code`, optional UUID `executionId`, and exactly one target: `runtime` or `session`. A runtime target creates a new kernel; a session target shares existing kernel state. Resumption requires the identical call, stable executionId and same session. The documented stream deadline is600seconds. An execution without an ID may continue after disconnection without reconnection support. **After its terminal result is returned, reuse of an ID starts new execution.** It is not a permanent idempotency key; the application must durably retain completion and prevent dispatch retries after terminal acknowledgement or ambiguous completion.

Results contain execution/session identity, executionCount, stdout/stderr, last expression text, executionError and outputTruncated. Only text is returned; plots/widgets are not promised. Truncation must remain visible. A runtime error is failure even when the transport/tool call returned successfully. Google's tool page specifies in-flight `notifications/cancelled`, which interrupts the kernel; provider acknowledgement/state still needs live acceptance before reporting confirmed cancellation. [execute_code contract](https://developers.google.com/colab/api/reference/mcp/tools_list/execute_code).

`create_session` has create-or-get behavior for a supplied sessionId; keep the resulting full resource name bound to its actual owner/runtime in MySQL. IDs are unique within a runtime, not global. Sessions retain memory until closed or the runtime ends. [create_session](https://developers.google.com/colab/api/reference/mcp/tools_list/create_session).

`delete_session` aborts in-flight calls and discards Python memory, but **leaves files on the runtime**. Sessions are therefore not a sufficient cross-student filesystem boundary. Do not allocate one runtime with multiple student sessions merely because the tool descriptions recommend sessions for state reuse. A student runtime must never be reassigned without independently verified lifecycle cleanup. [delete_session](https://developers.google.com/colab/api/reference/mcp/tools_list/delete_session).

Google's MCP authentication guide supports registered OAuth client configuration/ADC/bearer methods according to the service; Dynamic Client Registration and Client ID Metadata Documents are not supported. Bearer credentials expire and require refresh. Service/resource authorization remains separate from transport authentication. Do not infer arbitrary Colab execution authorization from the guide's generic API-key examples for services that do not require a principal. [Google MCP authentication](https://docs.cloud.google.com/mcp/set-up-authentication-mcp-servers).

### Protocol version compatibility

As observed on the research date, MCP `latest` resolves to revision2026-07-28. That revision carries protocol/capability metadata per request, without the older initialize handshake. Legacy2025-11-25 and earlier use initialization. Google's Colab examples are direct tools/call messages and do not establish which revision an account's live server accepts. Select and verify a supported revision against the real endpoint; do not silently mix lifecycle or cancellation rules from different revisions. Google's execute_code cancellation description must be reconciled with the negotiated transport behavior during live acceptance. [Primary versioning specification](https://modelcontextprotocol.io/specification/2026-07-28/basic/versioning), [transport specification](https://modelcontextprotocol.io/specification/2026-07-28/basic/transports).

## Enterprise REST adapter contract

Enterprise uses `aiplatform.googleapis.com` and documents notebookRuntimeTemplates, notebookRuntimes and notebookExecutionJobs. It is distinct from the ordinary `colaboratory.googleapis.com` API. [Enterprise resource map](https://docs.cloud.google.com/colab/docs/reference/rest).

Create through `POST https://{supported-service-endpoint}/v1/projects/{project}/locations/{location}/notebookExecutionJobs`, optionally with query `notebookExecutionJobId`. It requires `aiplatform.notebookExecutionJobs.create` on the parent and returns an operation. Use an application-generated stable job resource ID and reconcile uncertain requests by the known resource rather than blindly generating another job. The create reference does not promise a requestId field. [Create method](https://docs.cloud.google.com/gemini-enterprise-agent-platform/reference/rest/v1/projects.locations.notebookExecutionJobs/create).

The resource supports one notebook source: `directNotebookSource.content` is base64 IPYNB; `gcsNotebookSource` can pin a storage generation. Execution configuration can reference a runtime template. `executionTimeout` is a protobuf seconds duration, default24hours, so the application must send an explicit reviewed limit. `gcsOutputUri` is the result sink. Execution identity can be serviceAccount or executionUser. `jobState`, status and timestamps are provider outputs. Bind input notebook/dataset hashes, owner, ticket, resource name, actual state and results to the existing execution job, without exposing credentials. [Resource schema](https://docs.cloud.google.com/gemini-enterprise-agent-platform/reference/rest/v1/projects.locations.notebookExecutionJobs).

Map only recognized actual job states: QUEUED→QUEUED, PENDING→PREPARING, RUNNING→RUNNING, SUCCEEDED→COMPLETED, FAILED→FAILED, CANCELLED→CANCELLED and EXPIRED→TIMED_OUT, preserving the raw provider value. CANCELLING is not terminal; documentation allows it to end SUCCEEDED or FAILED as well as CANCELLED. Unknown/partial/paused/updating states require explicit treatment, never default success. The shared enum does not prove that every enum state is used by notebook execution jobs. [JobState](https://docs.cloud.google.com/gemini-enterprise-agent-platform/reference/rest/v1/JobState).

### Cancellation limitation

The researched v1 notebookExecutionJobs resource lists **create, get, list, delete**. No notebookExecutionJobs `:cancel` method is documented there. DELETE returns a long-running operation and its reference describes deletion, not guaranteed interruption of a running notebook. Do not invent `:cancel`, equate successful DELETE/404 with confirmed cancellation, delete history to hide unfinished work or present local cancellation as provider termination. Activation needs a separately documented/verified bounded cancellation/cleanup procedure or must remain blocked. [Delete contract](https://docs.cloud.google.com/gemini-enterprise-agent-platform/reference/rest/v1/projects.locations.notebookExecutionJobs/delete).

## Identity, networking, data and cost gates

Enterprise default runtime templates enable public internet and end-user credentials; notebook code can inherit the executing user's Cloud access. Those defaults are inappropriate for server-held administrator credentials executing untrusted student notebooks. Create a reviewed template with end-user credentials and public internet disabled, bounded resources/idle shutdown and a dedicated network. Template creation exposes explicit controls for both settings. This is a configuration plan, not proof of an existing secure template. [Runtime defaults](https://docs.cloud.google.com/colab/docs/runtimes), [template controls](https://docs.cloud.google.com/colab/docs/create-runtime-template).

Separate submission/orchestration identity from the execution identity. Prefer supported ADC/workload identity/service-account impersonation where deployed rather than long-lived keys. Students' runtime identities must be unable to read application secrets, SQL, other students' objects or orchestration credentials. Disabling user ADC does not itself remove the execution service account's capabilities; grant only the assigned input/output scope and test metadata/token abuse. [Programmatic authentication](https://docs.cloud.google.com/colab/docs/authentication).

Google warns that project-level `dataform.repositories.list` can reveal all notebook names and that secrets available to Dataform can become accessible to notebook editors. Do not grant broad default roles to students merely to make a tutorial work. Use reviewed custom/resource IAM and test actual denials. [Enterprise IAM/security implications](https://docs.cloud.google.com/colab/docs/access-control).

Scheduling documentation requires enabled billing and relevant APIs, explains user-versus-service-account execution and Cloud Storage result notebooks. Bucket readers can see code/results and bucket writers can alter result notebooks. Use separate student/job scopes, immutable object generations/hashes and a backend-only result retrieval path. Arbitrary student notebook output is untrusted content even when Google executed it; it is not independent model-quality validation. Dataset export additionally requires recorded permission for the actual data/recipient/region/retention. [Execution guide and result security](https://docs.cloud.google.com/colab/docs/schedule-notebook-run).

VPC Service Controls can add an exfiltration boundary independent of IAM, but require a real perimeter and service configuration. This documentation does not demonstrate a deployed perimeter on this machine. [Service controls](https://docs.cloud.google.com/colab/docs/service-controls).

Enterprise resources consume actual Compute Engine/API/storage quotas and project billing. CPU/GPU/disk/network cost and regional availability must be accepted before provisioning; none is assumed free/unlimited. Check the project's actual limits and budget, rather than showing fixed GPU telemetry. [Quotas](https://docs.cloud.google.com/colab/docs/quotas), [pricing](https://cloud.google.com/colab/pricing).

## Provider-backed acceptance checklist

Required evidence before execution activation:

1. Explicitly authorized Google project/account, enabled APIs, accepted billing/budget and eligible region/runtime; supported OAuth/ADC identity and refresh/revocation behavior.
2. Reviewed template/runtime and independent student identities; negative filesystem/IAM/network/metadata/other-student access tests. No application secret/token embedded in code or output.
3. Explicit authorization for external transfer of each assigned immutable dataset version; only scoped temporary input access, no shared bucket reads/listing or reusable broadly privileged URL.
4. Actual success and Python exception, bounded output/truncation, output retrieval failure, quota denial, expired credentials, network interruption, ambiguous submission and completion persistence/recovery.
5. Bounded execution timeout and actual cancellation acknowledgement, resource cleanup/expiration, orphan reconciliation and retained history. An HTTP timeout does not prove a stopped remote workload.
6. Real authenticated student/SOC ownership and auditing with no cross-student provider reference injection; student code/results remain USER_REPORTED where metrics are student-controlled.
7. No trusted model evaluation or deployed endpoint claim until an independently controlled evaluator/serving provider is actually tested.

Missing credentials or infrastructure must be reported specifically. Contract mocks are useful tests of parsers/request construction and fail-closed behavior, but cannot satisfy any of these live-provider gates. No provider-backed execution success is asserted by this research.
