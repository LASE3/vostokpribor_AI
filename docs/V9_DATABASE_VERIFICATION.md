# V9 database and recovery verification

The existing main database remains `vostok_range_20261026_fresh`. No DROP/TRUNCATE, fixture import, administrator-password reset or upload deletion was performed. Configuration remains unchanged. Migration008 added fields/indexes after backup and an isolated restoration/migration test; all existing non-migration rows and all private file fingerprints matched before/after the local migration. There are 29 application tables and eight migrations.

## Installation and isolation

`staging-fresh-install.log` and `staging-fresh-verifier.log` prove forward creation of a newly named database with exactly one ADMIN, identifier admin, a password_hash-verifiable local initial password and must_change_password=1. Every other work/audit/notification/rate/session table was zero before HTTP activity. Subsequent test-created records and login audits are real actions in dedicated `_test` databases, not initial fixtures. Main work records remain separate.

The clean extracted staging instance uses APP_ENV=testing, a separate cookie, private storage tree and DML-only runtime credentials. The operator/migration identity is separate. Database GRANT underscores are escaped: backticks alone do not remove wildcard semantics. Actual SHOW GRANTS validation, DML success, rejected CREATE TABLE and rejected access to the source database are tested. Main runtime credentials were not silently changed.

## Migration008

`experiment_runs.dataset_version_id` is a nullable FK to immutable dataset_versions. `measurement_source` is an enum UNKNOWN, USER_REPORTED, SYSTEM_MEASURED, INDEPENDENTLY_VALIDATED, default UNKNOWN. New HTTP manual records authoritatively store USER_REPORTED and remain untrusted. There is no UPDATE promoting old metrics. Model sort indexes cover `(updated_at,id)` and `(student_id,updated_at,id)`. The existing schema/tables are retained.

Applied first to `vostok_range_v9_20261101_main_restore_a_test`, then isolated performance/metrics/HTTP schemas. `migration-main-preservation.json` records seven→eight migrations with identical existing row hashes/counts, private files and .env. `pagination_collections-final.log` tests valid, foreign-student and wrong-ticket dataset version references against actual MySQL.

## Combined recovery

`bin/backup_range.php` accepts a separate 24–1024-byte recovery passphrase in stdin JSON. It encrypts SQL, all private files, original .env and effective configuration with AES-256 ZIP encryption. It checks before/after full database, file, migration and configuration fingerprints and refuses concurrent change. Output must be new and outside source/webroot. No plaintext dump/configuration is shipped in the source release.

`bin/restore_range.php` refuses an existing database, an activated .env, private target payloads, wrong migration files, unsafe SQL, bad archive paths, incorrect checksums, broad runtime grants and wrong passwords. Automatic restore is deliberately restricted to a new loopback `_test` database and code-only tree. It never activates source credentials or overwrites the original installation. Production recovery requires an independently reviewed operator procedure; this test tool is not permission to reset production.

The actual main snapshot is `C:\Users\nijim\.codex\artifacts\v9-recovery-20261101\main-before-v9-schema-20261101.zip`, SHA-256 `7c7c9933f46f97dfbca945c4abe7a3ab5eb28d267a17ec5239d5fd87cf8460e7`. It captured 29 tables and 52 private files, including storage control files. Passphrase material is kept separately outside webroot; it is excluded from release/evidence archives.

Local operator key custody: `C:\Users\nijim\.codex\artifacts\v9-recovery-20261101\main-access-172328c51bdea288\secrets.json`. This is a pointer for the authorized local operator, not key material; never copy its contents into source, logs or release packages. Protect and retain the key independently of the archive.

`recovery-final.log`: 77 passing assertions on newly created source/restored test databases, including literal Unicode notebook source, real uploaded-file bytes, complete row/DDL fingerprints, encryption, safety refusals, restricted runtime behavior and original-source preservation.

`restored-main-before-migration.log`: the main snapshot restored into a separate database/tree with all fingerprints matching. `recovery-rto-http.json`: a second actual main-snapshot restore, forward migration and current-source activation reached HTTP login200 and CSRF200 with its own cookie. Measured automated local restoration→HTTP startup was **1.852 seconds** on this small local snapshot; SQL/private-file restore phase including local preparation was0.943seconds. This excludes operator response, off-site retrieval and infrastructure replacement and is not a production RTO guarantee.

Operational RPO is the last verified manual snapshot. No recurring backup/PITR/off-site retention service is configured. There is no claimed production RPO. A production owner must establish backup cadence, protected key custody, off-site copies, alerting and timed recovery drills before acceptance.

## Host privilege-table repair

During GRANT testing, CHECK TABLE reported mysql.db as corrupt. Its Aria files and logical rows were preserved outside webroot before `REPAIR TABLE mysql.db QUICK`; QUICK repairs the index without modifying the data file. Repair/CHECK returned OK, and all four original privilege rows matched canonically. This follows the [MariaDB REPAIR TABLE documentation](https://mariadb.com/docs/server/reference/sql-statements/table-statements/repair-table). The evidence file is `mysql-privilege-index-repair.json`. No application schema/data was reset.

All evidence paths above are beneath protected `verification/v9-20261101/` unless an absolute private archive path is given. Dedicated test schemas and generated test work were retained; no earlier data were deleted to force a pass.
