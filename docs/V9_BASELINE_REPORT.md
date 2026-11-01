# V9 baseline report

Branch main; baseline309d92e; checkpoint codex/v9-baseline-20261101. The supplied prompt labels the predecessor Version8; the actual clean checkout is the V7 commit. No missing V8 implementation is assumed.

Observed OS: Windows-11-10.0.26300-SP0

Source counts: {".php": 188, ".js": 15, ".py": 32, ".cjs": 5, ".sql": 8}; seven migrations. Native PDO diagnostics selected the existing configured database without credentials or data reset. Full metadata/counts: protected verification/v9-20261101/baseline-database.json.

- VERIFIED WORKING: baseline-security; PASS: Ownership and stale-editor form status codes remain accurate / 49 security checks passed; no database connection made.
- VERIFIED WORKING: baseline-policy; PASS another installation prefix is not accidentally classified / 89 security policy checks passed; no real environment, session or database accessed.
- VERIFIED WORKING: baseline-client; PASS API failure reports truthful backend error instead of success / 23 mocked RangeClient security checks passed; no network/database accessed.
- VERIFIED WORKING: baseline-async; PASS snapshot success preserves edits typed while request was pending / 67 deterministic async frontend checks passed; no HTTP/database access.
- VERIFIED WORKING: baseline-package; PASS: Output inside web root is refused / 30 production source packaging checks passed; no workspace data or database accessed.
- VERIFIED WORKING: baseline-contracts; PASS POST workbench/runs / PASS 113 required contracts; 183 total routes; all handlers real, no duplicates, SOC gates present.
- VERIFIED WORKING: baseline-http-central; PASS real acting-user audit evidence recorded / PASS ALL 398 central SOC HTTP/HTML checks on vostok_range_20261030_main_http_test; existing data never reset.
- VERIFIED WORKING: baseline-sql-http; PASS HTML does not disclose configured database name / PASS ALL 132 V7 HTTP/independent SQL checks; 30 workflow proof rows; only new IT-V7 work in vostok_range_20261030_main_http_test.

VERIFIED WORKING: persisted non-execution training/admin workflow within the executed baseline. PARTIALLY IMPLEMENTED: bounded collection clients/pagination, production recovery/least-privilege deployment. BLOCKED: reviewed isolated runner/evaluator/serving provider absent pending infrastructure assessment. NOT IMPLEMENTED: dataset SQL execution. NOT DEPLOYED / NOT ACCEPTED: public production deployment. Runtime support and production gates require fresh assessment; this baseline is not a production-readiness claim.
