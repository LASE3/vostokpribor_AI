#!/usr/bin/env python3
"""Deterministic auditor tests. Temporary source is never imported/executed."""
import contextlib
import importlib.util
import io
import json
import os
from pathlib import Path
import tempfile
import unittest

ROOT = Path(__file__).resolve().parents[1]
SPEC = importlib.util.spec_from_file_location('range_source_audit', ROOT / 'bin/audit_source.py')
audit = importlib.util.module_from_spec(SPEC)
SPEC.loader.exec_module(audit)


class SourceAuditTests(unittest.TestCase):
    def setUp(self):
        self.temporary = tempfile.TemporaryDirectory(prefix='vostok_v9_audit_')
        self.root = Path(self.temporary.name)

    def tearDown(self):
        self.temporary.cleanup()

    def write(self, name, value):
        target = self.root / name
        target.parent.mkdir(parents=True, exist_ok=True)
        target.write_bytes(value if isinstance(value, bytes) else value.encode('utf-8'))
        return target

    def test_import_does_not_scan_or_write(self):
        self.assertEqual(list(self.root.iterdir()), [])
        self.assertTrue(callable(audit.main))

    def test_all_six_scopes_are_visible(self):
        locations = ['app/view.js', 'bin/tool.py', 'tests/check.cjs', 'vendor/lib.php', 'database/migrations/001.sql', 'verification/probe.mjs']
        for location in locations:
            self.write(location, 'localStorage.setItem("business", "value");')
        report, inventory = audit.scan(self.root)
        self.assertEqual(set(report['categories']), set(audit.CATEGORY_LABELS))
        self.assertEqual(len(inventory), 6)
        self.assertEqual(len(report['findings']), 6)
        self.assertEqual(len(report['operational_blocking_findings']), 2)

    def test_unknown_paths_and_nested_test_dependency_names_are_active(self):
        for name in ['app/tests/check.js', 'app/vendor/lib.js', 'app/node_modules/private.js', 'new_module/page.js']:
            self.write(name, 'Math.random();')
        report, _ = audit.scan(self.root)
        self.assertEqual(len(report['operational_blocking_findings']), 4)

    def test_migration_seeding_fails_even_inline(self):
        self.write('database/migrations/008.sql', 'START TRANSACTION; INSERT INTO users VALUES (1);')
        report, _ = audit.scan(self.root)
        self.assertEqual(report['result'], 'REVIEW REQUIRED')

    def test_only_exact_existing_metadata_backfill_is_contextual(self):
        insert = 'INSERT INTO dataset_versions (dataset_id,version,format,file_path,file_size,checksum_sha256,row_count,column_count,schema_json,uploaded_by,created_at)'
        select = 'SELECT id,version,format,file_path,file_size,checksum_sha256,row_count,column_count,schema_json,uploaded_by,created_at FROM datasets;'
        self.write('database/migrations/004_dataset_lifecycle.sql', insert + '\n' + select)
        report, _ = audit.scan(self.root)
        self.assertEqual(report['result'], 'PASS')
        self.write('database/migrations/004_dataset_lifecycle.sql', insert + '\nSELECT 1;')
        report, _ = audit.scan(self.root)
        self.assertEqual(report['result'], 'REVIEW REQUIRED')

    def test_comments_and_ui_copy_do_not_hide_executable_lines(self):
        self.write('app/page.js', '// localStorage is forbidden\nconst value = localStorage.getItem("ticket");\n/* comment */ Math.random();')
        report, _ = audit.scan(self.root)
        self.assertEqual(len(report['findings']), 3)
        self.assertEqual(len(report['operational_blocking_findings']), 2)

    def test_sensitive_values_never_appear_in_reports(self):
        marker = 'PRIVATE_VALUE_5acb842e'
        self.write('app/page.js', 'localStorage.setItem("token", "' + marker + '");')
        report, inventory = audit.scan(self.root)
        self.assertNotIn(marker, json.dumps([report, inventory]))

    def test_invalid_application_encoding_fails_but_dependency_is_context(self):
        self.write('app/page.php', b'<?php \xff')
        self.write('node_modules/lib.js', b'\xff')
        report, _ = audit.scan(self.root)
        self.assertEqual(len(report['encoding_errors']), 2)
        self.assertEqual(len(report['operational_blocking_findings']), 1)

    def test_private_python_is_text_only_and_unchanged(self):
        marker = self.root / 'executed.txt'
        source = self.write('storage/private/sandboxes/code.py', 'from pathlib import Path\nPath(' + repr(str(marker)) + ').write_text("bad")\n# sample\n')
        before = source.read_bytes()
        report, _ = audit.scan(self.root)
        self.assertFalse(marker.exists())
        self.assertEqual(before, source.read_bytes())
        self.assertEqual(report['findings'][0]['classification'], 'CONTEXT_ONLY_GENERATED_ARTIFACTS')

    def test_cli_report_names_preserve_historical_evidence(self):
        historical = self.write('verification/source-audit.json', 'retained evidence')
        self.write('app/page.php', '<?php echo "Available";')
        with contextlib.redirect_stdout(io.StringIO()):
            self.assertEqual(audit.main(['--root', str(self.root)]), 0)
        self.assertEqual(historical.read_text(), 'retained evidence')
        self.assertTrue((self.root / 'verification/source-audit-current.json').is_file())

    def test_cli_review_exit_and_no_source_mutation(self):
        source = self.write('app/page.js', 'Math.random();')
        before = source.read_bytes()
        with contextlib.redirect_stdout(io.StringIO()):
            self.assertEqual(audit.main(['--root', str(self.root)]), 1)
        self.assertEqual(before, source.read_bytes())

    def test_output_cannot_overwrite_application_directory(self):
        with self.assertRaises(ValueError):
            audit.output_directory(self.root, self.root / 'app')
        with contextlib.redirect_stderr(io.StringIO()):
            self.assertEqual(audit.main(['--root', str(self.root), '--output-dir', str(self.root / 'app')]), 2)

    def test_external_output_inside_webroot_is_rejected(self):
        root = self.root / 'htdocs/app'
        root.mkdir(parents=True)
        with self.assertRaises(ValueError):
            audit.output_directory(root, self.root / 'htdocs/public-reports')

    def test_links_are_not_followed_and_active_skips_fail_closed(self):
        external = self.root / 'target'
        external.mkdir()
        (external / 'page.js').write_text('Math.random();')
        app = self.root / 'app'
        app.mkdir()
        try:
            (app / 'linked').symlink_to(external, target_is_directory=True)
        except OSError as error:
            self.skipTest('OS account cannot create symlinks: ' + str(error.winerror if hasattr(error, 'winerror') else error.errno))
        report, _ = audit.scan(self.root)
        self.assertFalse(report['coverage_complete'])
        self.assertTrue(any(item['rule'] == 'uninspected_link' for item in report['operational_blocking_findings']))
        with self.assertRaises(ValueError):
            audit.output_directory(self.root, app / 'linked/reports')

    def test_linked_report_destination_cannot_overwrite_source(self):
        source = self.write('app/page.js', 'const a = 1;')
        output = self.root / 'verification'
        output.mkdir()
        try:
            (output / 'source-audit-current.json').symlink_to(source)
        except OSError as error:
            self.skipTest('OS account cannot create symlinks: ' + str(error.winerror if hasattr(error, 'winerror') else error.errno))
        with contextlib.redirect_stderr(io.StringIO()):
            self.assertEqual(audit.main(['--root', str(self.root)]), 2)
        self.assertEqual(source.read_text(), 'const a = 1;')


if __name__ == '__main__':
    unittest.main(verbosity=2)
