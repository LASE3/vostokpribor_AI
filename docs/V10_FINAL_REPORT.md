# V10 final engineering report

Date:2026-11-01. Source `C:/xampp/htdocs/vostokpribor_AI`, branch **main**, V9 baseline **13ae511**, checkpoint `codex/v10-baseline-20261101`. Companion evidence is under protected `verification/v10-20261101/`, distributed separately from source. This report distinguishes locally verified behavior, prepared code and unavailable cloud infrastructure.

## 1. Executive summary

Verified: strict role routing, four-system student portal, administrator-only SOC, the persisted training workflow and manual Colab notebook code exchange. Implemented: bounded Google OAuth/HTTPS support and an Enterprise request-preparation adapter. **Live Google execution is BLOCKED**, not completed. The user confirmed no Google Cloud project and requested local build/tests. No Google job, dataset transfer, quality result or serving endpoint was invented.

## 2. Version 9 baseline

Main started at13ae511 with the persisted non-execution platform and eight migrations. The V9 source package supplied the isolated initial test tree; existing main data/configuration was preserved. V9 reports remain historical. No Laravel, second backend or independent student database was introduced.

## 3. Files audited

Recursive six-category audit:1,147 PHP/JS/CJS/MJS/SQL/Python sources,156 active,871 dependency,19 tools,28 generated,8 migrations,65 tests; zero blocking/encoding/coverage gaps. Contextual occurrences remain in source-audit-current.json. See the exact path inventory/unified patch in the evidence and the cleanup report. A pattern audit does not establish absence of unknown vulnerabilities.

## 4. Bugs found

Administrator/student pages and navigation were not strictly separated. The student portal retained a locked SOC card/shortcuts; administrators could enter student HTML views. No Colab code exchange/provider contract existed. The first exporter omitted required nbformat4.5 cell identifiers; stable unique export IDs now comply with the Jupyter schema. The old central test credential writer could replace other suite-specific credential entries. Retired exit-only patch/fixture stubs remained tracked. Review also found that base64 expansion could exceed the transport body cap.

## 5. Bugs repaired

Trusted server-side role home/page policy now governs login/password/root/layout/navigation. Student pages contain no interactive SOC route. Authenticated role gates preserve SOC shared-service privileges. Code-only .ipynb export/import checks real ownership/files and strips all execution claims. A focused document contract verifies required unique cell IDs. Prepared Enterprise requests enforce owner-specific identity/output prefix, bounded timeout and actual encoded-body size. Test credential updates preserve unrelated entries; only identified retired stubs were removed.

## 6. Student/admin separation

ADMIN login/root routes directly to SOC Dashboard; student HTML systems return403 to ADMIN. STUDENT sees exactly four systems; SOC HTML/API returns403. Backend ADMIN object inspection remains available within SOC. No JavaScript-only role decision. [Role matrix](V10_ROLE_ACCESS_MATRIX.md).

## 7. Student test account

`student_test` was explicitly provisioned through SOC only in `vostok_range_v10_20261101_integration_a_test`, with random outside-source credentials, password_hash and genuine mandatory rotation. Existing normalization stores STUDENT_TEST; lowercase login succeeds. A second student verifies cross-user isolation. No main or packaged account fixture exists. Actual role/workflow assertions205; entry/resource assertions146.

## 8. SOC administrative verification

Actual SOC398 and supplementary244 assertions verify accounts, scenarios, tickets/reassignment/cancellation, real datasets/version grants, original notebook/experiment/model inspection, artifact integrity, submission decisions, administrative requests and acting-user audit. New role tests complete the ticket→student→submission→SOC review cycle without entering student pages as administrator. SOC visibly reports Colab NOT_CONFIGURED/UNAVAILABLE.

## 9. Google provider investigation

All three supplied official references were read. Ordinary Colab REST manages requesting-user runtimes; MCP execute_code is official but sessions share runtime files and replay after terminal completion can start new work. Enterprise has managed notebook jobs, IAM/templates/storage; documented job methods do not promise cancellation. Enterprise is the prepared server-managed candidate; ordinary Colab remains a manual personal workflow. [Primary-source research](V10_COLAB_RESEARCH.md).

## 10. Colab integration implementation

Students download saved .ipynb, manually open/upload in Google Colab, then explicitly import edited code into a new owned notebook. No external upload is automatic. Imported outputs, execution counts, attachments, foreign IDs and provenance are discarded. Real local HTTP33 plus browser download/import/reload and independent SQL proof pass. Enterprise prepare builds the documented regional create URL, base64 directNotebookSource, reviewed-template reference, unique per-student identity/output prefix and timeout, but submit/cancel remain hard disabled. [Guide](V10_COLAB_INTEGRATION.md).

## 11. Colab authentication tests

**62 offline contracts** verify OAuth refresh/expiry/cache, real local RSA signing, sanitized failures, explicit private credentials and HTTPS restrictions. This is not live Google authentication. No Cloud project/billing/API authorization/credentials were supplied. Provider-backed authentication/eligibility/quota tests are BLOCKED. Default CLI preflight exits78 and reports unavailable without network activity.

## 12. Python execution results

No remote or host Python workload was executed. HTTP execution remains503 after authentication/ownership checks; no new job is fabricated. The worker refuses operation. Manual code exchange is not execution verification. Provider-backed output retrieval/persistence is NOT IMPLEMENTED pending safe cloud acceptance.

## 13. Runtime isolation

**BLOCKED.** Per-student service-account mapping in an offline plan is not an IAM/network/storage boundary proof. Runtime credentials, data scope, ADC/public-network defaults, quotas, timeout, cancellation, cleanup and expiration need actual cloud tests. Enterprise cancellation cannot be invented from DELETE; MCP kernel sessions are not student isolation. No environment flag enables execution.

## 14. Experiment tracking

Existing saved runs retain USER_REPORTED/UNKNOWN provenance and authorized immutable dataset-version links. Manual Colab results are not promoted. No SYSTEM_MEASURED or INDEPENDENTLY_VALIDATED record is created from imported output or an unverified notebook run. Actual repository/HTTP provenance regressions pass.

## 15. Model evaluation

Registration/upload/checksum/integrity and authorized validation requests pass. Quality remains NOT_EVALUATED without independently trusted evidence. Untrusted serialized artifacts are never loaded on the PHP host. Live evaluator and task-specific measured quality acceptance are BLOCKED.

## 16. Model deployment

Administrative request/approval/rejection/history works. Actual inference remains unavailable; no DEPLOYED state, fake URL or unprotected endpoint is produced. Colab is not assumed to be a production serving provider. Managed serving requires separate infrastructure/authentication/cost/security acceptance.

## 17. Security findings

Role, ownership, sessions, password rotation, CSRF/origin, upload/download scope, errors, headers/CORS, rate limits and protected paths passed local tests. Google tokens remain in memory on the server, credential/config files must be outside webroot, TLS verification is mandatory, redirects/proxy/browser cookies are rejected and responses are bounded. Explicit credential files support authorized_user/service_account; automatic ADC/metadata/WIF is not implemented. Old host runtime, main operator credentials, public HTTPS/monitoring/security acceptance remain blockers. [Security report](V10_SECURITY_REPORT.md).

## 18. Performance findings

Actual rollback-only10/50/100/500-student MySQL probes completed. At5,000 models: unbounded37,884,471bytes/269.771ms median, bounded757,801bytes/71.597ms, compact UI44,701bytes/63.871ms; compact transient growth181,528bytes, count/window two queries. Local budgets unchanged: median500ms, API2MiB/UI128KiB, transient16MiB. HTTP1/5/10 independent sessions had p95 of25.832/40.091/48.130ms, zero errors, below2500ms local budget. No500-concurrent or Google latency/quotas claim.

## 19. Files modified

Authentication/controller/login/root/password routing; shared layout/navigation; ML panels/context; Notebook/Execution controllers/services and module registrations; environment example; compiled CSS; version metadata; guarded tests and final documentation. Exact names/statuses and full unified lines against13ae511 are supplied in source-change-inventory.json/source-changes.patch; no secret or upload belongs in that diff.

## 20. Files created

Core/SystemAccess, Execution provider interface/Enterprise adapter/NotebookDocument/Google OAuth+transport, CLI preflight, focused role/Colab tests and V10 architecture/matrix/integration/research/security/test/cleanup/deployment/final reports. File presence alone is not credited as live cloud capability.

## 21. Files removed

25 tracked retired exit-only stubs,4,711bytes/92lines, after content/reference/dependency review. Git baseline recovers them. No migration, active test, working endpoint, upload, configuration or database row was deleted. [Exact removal list](V10_CLEANUP_REPORT.md).

## 22. Redundant code removed

Removed the retired no-op bodies, locked student SOC/auxiliary launcher destinations and unreachable student-view administrator banner. Supported compatibility APIs and required layouts/assets/migrations remain. No broad name-based deletion or removal of useful security checks.

## 23. Dependencies

No runtime dependency added. PHP/PDO/cURL/OpenSSL perform bounded server-side contracts; Node remains build/test-only. Version metadata10.0.0; pinned Tailwind3.4.17 unchanged. Compiled assets rebuilt and41 compiler/asset checks pass. Missing cloud infrastructure is not hidden behind an added SDK.

## 24. Database changes/preservation

**No V10 migration required or applied.** Eight migrations/29 main tables retained. Main has one administrator, zero students/training records,19 legitimate audit and5 rate rows. Compared with the V9 snapshot, the original18 audit rows and all training rows are unchanged; one real localhost LOGIN_SUCCESS at15:03:37 preceded isolated tests, with login timestamp/auth-rate changes. It was retained, not reset or attributed to an unverified actor. Administrator password hash, .env and52 original private files are unchanged. See main-preservation.json. Fresh test verifier separately proves one hashed admin/zero all other tables before HTTP.

## 25. API integration

189 registered routes/113 required contracts, including six additive notebook import/export/SOC-provider routes.189 anonymous Apache probes reached correct authentication/CSRF handling with no Apache404 or successful mutation. Existing five modules/shared database retained. Expected object404 and role403 remain correct. [API reference](../API_REFERENCE.md).

## 26. Automated tests

Passed:35 offline document/provider contracts;62 OAuth/HTTPS;44 role/navigation;49 security;89 policy;8 environment;23 client;67 async;31 packaging;41 assets;10 file-storage guard;13 HTTP-target unit. Shipped syntax188 PHP/20 JavaScript/32 Python: zero errors. Actual DB44 training/27 dataset/31 workspace/23 integrity/29 scenario/84 pagination/29 concurrency/50 metrics and77 recovery pass. [Commands/counts/scopes](V10_TEST_RESULTS.md).

## 27. End-to-end tests

205 V10 role/workflow,33 Colab-exchange,146 role-specific entry/resource,398 central SOC,244 supplementary,257 cross-system/30 independent SQL proofs,25 empty pages,75 pagination,98 request security,106 adversarial SOC,35 dashboard,15 HTML conflict,4 fault-safe HTML,24 read-limit SQL,23 injected core failures,244 header/exposure and142 backend assertions passed. The last suite observed real429/Retry-After114; no quota reset. Driver failures (uppercase cell type, narrow test expiry fixture, missing CLI arguments, initial restricted fixture identity, relative browser URL) were corrected and retained separately; they are not omitted or counted as successful application actions.

## 28. Browser tests

Actual browser login verifies four student cards/no SOC, direct SOC denial, administrator direct SOC landing and SOC provider inspection. Download→real file chooser→import→reload preserved literal source in a new notebook; independent SQL confirms STUDENT_TEST ownership/no output/UNAVAILABLE kernel. Desktop1440/laptop1280/tablet768/mobile390 fit without horizontal application overflow; viewport restored. SOC console had zero errors. An incorrectly concatenated test-driver URL was reopened using the actual resolved href; no application404 fix was inferred from it. Screenshots show isolated test records, never seeded main.

## 29. Source package verification

Production-source packager excludes .env/history/Google credentials/private payloads/backups/test credentials/logs/cache/evidence while retaining eight migrations/storage controls/layout/tests. CRC/per-file hashes and clean extraction are verified in the external manifest/evidence. Source ZIP is not a live data backup. No package operation deletes real files. Final staging proof is recorded beside the archive, without circular in-source archive hashes.

## 30. Backup/restoration

77 actual encrypted combined SQL/private-file/configuration recovery assertions passed again in new source/restored test schemas. Existing main encrypted backup/key remain separately protected outside webroot; no key is packaged. Main file/config/row preservation was checked read-only. No public automated/off-site/PITR recovery service is claimed. Historical V9 small1.852s restore timing is not re-labeled as a V10 production RTO.

## 31. Staging

New loopback `_test` schemas, distinct cookie/private storage and exact DML runtime grant were used. Operator authority is supplied only to CLI migrations and narrow injected-failure fixtures, not Apache. Fresh295-file source extraction verified every hash/CRC, initialization with one administrator and zero others, actual DDL/main-DB denials and208 fresh-account role,33 manual-Colab and257 cross-system checks. Test accounts/work remain isolated; no reset of earlier test schemas to force passes.

## 32. Remaining blockers

No Google project/billing/API/IAM/OAuth authorization; no verified provider authentication, runtime/data isolation, output retrieval, execution monitoring or cancellation/cleanup. Live Colab/evaluator/serving disabled. Dataset SQL engine unavailable. Maintained host/runtime rollout, main least-privilege cutover, HTTPS, production monitoring/backups, sustained load and public security/sign-off are unaccepted. [Deployment guide](V10_DEPLOYMENT_GUIDE.md).

## 33. Readiness checklist and weights

Each item has equal weight, full credit only for VERIFIED COMPLETE within its stated acceptance scope. Local checks are not production security certification.

|Core criterion|Status|
|---|---|
|Authentication|VERIFIED COMPLETE — local|
|Four student systems|VERIFIED COMPLETE — local|
|Administrator-only SOC|VERIFIED COMPLETE — local|
|Ticket management|VERIFIED COMPLETE — local|
|Dataset management|VERIFIED COMPLETE — local|
|Notebook persistence|VERIFIED COMPLETE — local|
|Model registration|VERIFIED COMPLETE — local|
|Submission review|VERIFIED COMPLETE — local|
|Shared APIs|VERIFIED COMPLETE — local|
|Database integration|VERIFIED COMPLETE — local|
|Role separation|VERIFIED COMPLETE — local|

Core local acceptance11/11. Complete range adds six mandatory items: verified remote Python execution, safe multi-user runtime isolation, actual experiment execution, trusted evaluation, supported serving deployment and real execution monitoring. All six are BLOCKED. Thus **complete AI range11/17 =64.7%**, not100%. The Enterprise adapter is IMPLEMENTED BUT UNVERIFIED; manual code exchange does not satisfy these six requirements.

|Additional public criterion|Status|
|---|---|
|Supported runtime versions|BLOCKED|
|HTTPS deployment|NOT IMPLEMENTED|
|Protected credentials|PARTIALLY IMPLEMENTED — local/env/OAuth boundary tested; public custody not accepted|
|Secure database privileges|PARTIALLY IMPLEMENTED — staging DML verified, main operator retained|
|Secure storage|PARTIALLY IMPLEMENTED — local/API controls verified, public ACL/hosting unaccepted|
|Verified access controls|VERIFIED COMPLETE — recorded application scope|
|Dependency review|VERIFIED COMPLETE — pinned build tree/reviewed changes; host separately blocked|
|Automated tests|VERIFIED COMPLETE — enabled features only|
|Security acceptance|BLOCKED — public scope|
|Performance acceptance|PARTIALLY IMPLEMENTED — local budgets only|
|Backups|PARTIALLY IMPLEMENTED — actual recovery tested, cadence/off-site unaccepted|
|Monitoring|NOT IMPLEMENTED — production operations|
|Clean release packaging|VERIFIED COMPLETE — source scope|
|Clean staging deployment|VERIFIED COMPLETE — localhost isolation|

Public additional criteria5/14 =35.7%, with partial/blocked items receiving zero credit. Arithmetic cannot override missing infrastructure/security gates. No public deployment was attempted.

## 34. Final verdict

**READY FOR CONTROLLED LOCAL DEMONSTRATION.** Core training, role separation and manual Colab code exchange have actual evidence. **Live Colab integration remains PARTIALLY IMPLEMENTED/BLOCKED; public production is NOT READY.** A Google project alone will not enable execution: authenticated provider-backed isolation, cancellation, results, costs/data handling and acceptance still require implementation and review.
