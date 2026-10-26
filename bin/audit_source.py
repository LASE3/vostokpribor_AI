#!/usr/bin/env python3
"""Read-only recursive source audit. Records retained runtime artifacts separately.
Run after implementation; output contains locations/classification, never row contents.
"""
import hashlib
import json
import re
import sys
from datetime import datetime, timezone
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
RULES = {
    'browser_business_storage': re.compile(r'\b(?:localStorage|sessionStorage)\b'),
    'fabricated_random_telemetry': re.compile(r'\bMath\.random\s*\('),
    'known_old_fixture_identity': re.compile(r'\b(?:Vance|Voronin|A100)\b|SCN-904(?:-ALPHA)?|99\.98%|DEFAULT_INITIAL_SCENARIOS', re.I),
    'static_operational_success': re.compile(r'>\s*(?:SYNCED|ENGAGED|KERNEL CONNECTED|100% DAG|10\s*/\s*10 CHECKS VERIFIED)\s*<', re.I),
    'sql_data_write': re.compile(r'^\s*(?:INSERT\s+INTO|REPLACE\s+INTO)\s+[`a-z_]', re.I),
    'demo_or_fixture_word': re.compile(r'\b(?:demo|sample|mock|fixtures?|seeded|fictitious)\b', re.I),
}

def category(path: str) -> str:
    if path.startswith('storage/private/'): return 'retained_private_runtime_not_executed'
    if path == 'database/vostokpribor_ai.sql': return 'old_database_backup_excluded_from_zip'
    if path.startswith('storage/') and path.endswith('.py'): return 'one_off_repair_helper_excluded_from_zip'
    if path.startswith('tests/'): return 'guarded_test_or_retired_fixture_test'
    if path in {'bin/audit_source.py', 'bin/package_release.py'}: return 'audit_or_packaging_rule'
    if path.startswith('bin/patch') or path.startswith('bin/update_'): return 'retired_nonexecuting_patcher'
    return 'application_source'

findings = []
inventory = []
encoding_errors = []
for path in sorted(ROOT.rglob('*')):
    if not path.is_file() or '.git' in path.relative_to(ROOT).parts or path.suffix.lower() not in {'.php', '.js', '.sql', '.py'}: continue
    relative = path.relative_to(ROOT).as_posix()
    content = path.read_bytes()
    inventory.append({'path': relative, 'bytes': len(content), 'sha256': hashlib.sha256(content).hexdigest(), 'classification': category(relative)})
    try:
        decoded = content.decode('utf-8-sig', errors='strict')
    except UnicodeDecodeError as error:
        line_number = content[:error.start].count(b'\n') + 1
        encoding_errors.append({'path': relative, 'line': line_number, 'byte_offset': error.start, 'classification': category(relative)})
        findings.append({'path': relative, 'line': line_number, 'rule': 'invalid_utf8', 'match': 'invalid byte at offset ' + str(error.start), 'classification': category(relative)})
        decoded = content.decode('utf-8-sig', errors='replace')
    for number, line in enumerate(decoded.splitlines(), 1):
        for name, pattern in RULES.items():
            match = pattern.search(line)
            if not match: continue
            # SQL writes in PHP are authored service statements, not seed imports.
            if name == 'sql_data_write' and path.suffix.lower() != '.sql': continue
            classification = category(relative)
            if classification == 'application_source' and name == 'demo_or_fixture_word':
                if 'No demo records' in line: classification = 'initializer_explanation_no_seed'
                elif 'latency samples' in line: classification = 'empty_telemetry_explanation'
                elif 'id="deliv-demo"' in line: classification = 'scenario_editor_control_id_only'
                else: classification = 'static_copy_requires_review'
            findings.append({'path': relative, 'line': number, 'rule': name, 'match': match.group(0), 'classification': classification})

blocking = [item for item in findings if item['classification'] == 'application_source' and item['rule'] != 'demo_or_fixture_word']
blocking += [item for item in findings if item['classification'] == 'static_copy_requires_review']
by_category = {}
for record in inventory: by_category[record['classification']] = by_category.get(record['classification'], 0) + 1
out = ROOT / 'verification'
out.mkdir(exist_ok=True)
report = {'generated_at_utc': datetime.now(timezone.utc).isoformat(), 'extensions': ['.php', '.js', '.sql', '.py'], 'recursive': True, 'source_file_count': len(inventory), 'categories': by_category, 'strict_utf8': True, 'encoding_errors': encoding_errors, 'findings': findings, 'operational_blocking_findings': blocking, 'result': 'PASS' if not blocking else 'REVIEW REQUIRED', 'limitations': 'Pattern results accompany manual service/page review and real HTTP/browser tests; patterns alone do not establish correctness. Prior inventoried runtime artifacts and the old SQL backup stay on disk. Only exact old/test hashes are omitted from the ZIP; unknown or changed future real uploads are preserved with a manifest.'}
(out / 'source-audit.json').write_text(json.dumps(report, indent=2), encoding='utf-8')
(out / 'source-inventory.json').write_text(json.dumps(inventory, indent=2), encoding='utf-8')
print('Recursive .php/.js/.sql/.py files inspected:', len(inventory))
for key, value in sorted(by_category.items()): print(key + ': ' + str(value))
for item in findings: print(item['path'] + ':' + str(item['line']) + ' [' + item['rule'] + '] ' + item['classification'])
print('UTF-8 encoding failures:', len(encoding_errors))
print('Operational blocking findings:', len(blocking))
print('Result:', report['result'])
sys.exit(0 if not blocking else 1)
