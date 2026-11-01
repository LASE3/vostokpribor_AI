#!/usr/bin/env python3
"""Inventory and pattern-audit source as text; never import or execute the target.

Classification supplies context, not a declaration that a finding is safe.
Unknown application directories and migration data writes require review.
"""
import argparse
import collections
import hashlib
import json
import os
import re
import sys
from datetime import datetime, timezone
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
EXTENSIONS = {'.php', '.js', '.mjs', '.cjs', '.sql', '.py'}
CATEGORY_LABELS = {
    'ACTIVE_APPLICATION_CODE': 'ACTIVE APPLICATION CODE',
    'DEVELOPMENT_TOOLS': 'DEVELOPMENT TOOLS',
    'TEST_FILES': 'TEST FILES',
    'DEPENDENCIES': 'DEPENDENCIES',
    'HISTORICAL_MIGRATIONS': 'HISTORICAL MIGRATIONS',
    'GENERATED_ARTIFACTS': 'GENERATED ARTIFACTS',
}
RULES = {
    'browser_business_storage': re.compile(r'\b(?:localStorage|sessionStorage)\b'),
    'fabricated_random_telemetry': re.compile(r'\bMath\.random\s*\('),
    'known_old_fixture_identity': re.compile(r'\b(?:Vance|Voronin|A100)\b|SCN-904(?:-ALPHA)?|99\.98%|DEFAULT_INITIAL_SCENARIOS', re.I),
    'static_operational_success': re.compile(r'>\s*(?:SYNCED|ENGAGED|KERNEL CONNECTED|100% DAG|10\s*/\s*10 CHECKS VERIFIED)\s*<', re.I),
    'sql_data_write': re.compile(r'\b(?:INSERT\s+INTO|REPLACE\s+INTO)\s+[`a-z_]', re.I),
    'demo_or_fixture_word': re.compile(r'\b(?:demo|samples?|mocks?|fixtures?|seeded|fictitious|fabricated|fake)\b', re.I),
}


def category(relative):
    parts = Path(relative).parts
    first = parts[0] if parts else ''
    if first in {'node_modules', 'vendor'}:
        return 'DEPENDENCIES'
    if first == 'tests':
        return 'TEST_FILES'
    if relative.startswith('database/migrations/'):
        return 'HISTORICAL_MIGRATIONS'
    if first in {'storage', 'verification', 'scratch', 'test_output', 'test-results', 'coverage', '.cache', 'cache'}:
        return 'GENERATED_ARTIFACTS'
    if first == 'database' and Path(relative).suffix.lower() == '.sql':
        return 'GENERATED_ARTIFACTS'
    if first in {'bin', 'build', 'docs'}:
        return 'DEVELOPMENT_TOOLS'
    # A tests/vendor-looking name nested inside app is still application code.
    return 'ACTIVE_APPLICATION_CODE'


def subtype(relative):
    if relative.startswith('storage/private/'):
        return 'PRIVATE_RUNTIME_SOURCE_NOT_EXECUTED'
    if relative.startswith('database/') and not relative.startswith('database/migrations/'):
        return 'RETAINED_EXPORT_NOT_IMPORTED'
    if relative.startswith('verification/'):
        return 'VERIFICATION_OUTPUT_OR_REPRODUCTION_TOOL'
    return None


def is_comment(line):
    stripped = line.strip()
    if stripped.startswith(('//', '#', '--')):
        return True
    if stripped.startswith('/*'):
        return stripped.find('*/') == len(stripped) - 2
    return stripped.startswith('<!--') and stripped.find('-->') == len(stripped) - 3


def classification(relative, rule, line, lines, index):
    scope = category(relative)
    if scope not in {'ACTIVE_APPLICATION_CODE', 'HISTORICAL_MIGRATIONS'}:
        return 'CONTEXT_ONLY_' + scope
    if is_comment(line):
        return 'COMMENT_REFERENCE_NOT_OPERATIONAL_VALUE'
    # This migration copies only metadata for already-existing dataset files.
    # Other INSERTs, even in migrations, continue to require review.
    if (relative == 'database/migrations/004_dataset_lifecycle.sql'
            and rule == 'sql_data_write'
            and line.strip() == 'INSERT INTO dataset_versions (dataset_id,version,format,file_path,file_size,checksum_sha256,row_count,column_count,schema_json,uploaded_by,created_at)'
            and index + 1 < len(lines)
            and lines[index + 1].strip() == 'SELECT id,version,format,file_path,file_size,checksum_sha256,row_count,column_count,schema_json,uploaded_by,created_at FROM datasets;'):
        return 'REQUIRED_FORWARD_BACKFILL_OF_EXISTING_METADATA'
    if (relative == 'AI Operations Center (AI SOC)/_dashboard_panels.php'
            and rule == 'demo_or_fixture_word'
            and 'No verified deployments or endpoint health/latency samples are available.' in line):
        return 'EXPLICIT_UNAVAILABLE_STATE_COPY'
    if (relative == 'AI Operations Center (AI SOC)/TicketsAndScenarios.php'
            and rule == 'demo_or_fixture_word' and 'id="deliv-demo"' in line):
        return 'EDITOR_CONTROL_IDENTIFIER_NOT_A_DEMO_RECORD'
    return 'REVIEW_REQUIRED'


def is_link(path):
    return path.is_symlink() or (hasattr(path, 'is_junction') and path.is_junction())


def scan(root):
    root = Path(root).resolve(strict=True)
    if not root.is_dir():
        raise ValueError('root must be a directory')
    findings, inventory, encoding_errors, skipped_paths = [], [], [], []
    for current, directories, filenames in os.walk(root, topdown=True, followlinks=False):
        directory = Path(current)
        kept = []
        for name in sorted(directories):
            path = directory / name
            if name in {'.git', '.svn', '.hg'}:
                continue  # Git history is a separate credential/data audit.
            if is_link(path):
                skipped_paths.append({'path': path.relative_to(root).as_posix(), 'reason': 'LINK_NOT_FOLLOWED'})
            else:
                kept.append(name)
        directories[:] = kept
        for filename in sorted(filenames):
            path = directory / filename
            if path.suffix.lower() not in EXTENSIONS:
                continue
            relative = path.relative_to(root).as_posix()
            scope = category(relative)
            if is_link(path):
                skipped_paths.append({'path': relative, 'reason': 'LINK_NOT_FOLLOWED'})
                continue
            content = path.read_bytes()
            inventory.append({'path': relative, 'bytes': len(content), 'sha256': hashlib.sha256(content).hexdigest(), 'category': scope, 'subtype': subtype(relative)})
            try:
                decoded = content.decode('utf-8-sig', errors='strict')
            except UnicodeDecodeError as error:
                line_number = content[:error.start].count(b'\n') + 1
                encoding_errors.append({'path': relative, 'line': line_number, 'byte_offset': error.start, 'category': scope})
                findings.append({'path': relative, 'line': line_number, 'rule': 'invalid_utf8', 'category': scope, 'classification': 'REVIEW_REQUIRED' if scope in {'ACTIVE_APPLICATION_CODE', 'HISTORICAL_MIGRATIONS'} else 'CONTEXT_ONLY_' + scope})
                decoded = content.decode('utf-8-sig', errors='replace')
            lines = decoded.splitlines()
            for index, line in enumerate(lines):
                for rule, pattern in RULES.items():
                    if rule == 'sql_data_write' and path.suffix.lower() != '.sql':
                        continue
                    if pattern.search(line):
                        findings.append({'path': relative, 'line': index + 1, 'rule': rule, 'category': scope, 'classification': classification(relative, rule, line, lines, index)})
    for skipped in skipped_paths:
        scope = category(skipped['path'])
        findings.append({'path': skipped['path'], 'line': 0, 'rule': 'uninspected_link', 'category': scope, 'classification': 'REVIEW_REQUIRED' if scope in {'ACTIVE_APPLICATION_CODE', 'HISTORICAL_MIGRATIONS'} else 'CONTEXT_ONLY_' + scope})
    blocking = [item for item in findings if item['classification'] == 'REVIEW_REQUIRED']
    report = {
        'schema_version': 2, 'generated_at_utc': datetime.now(timezone.utc).isoformat(),
        'extensions': sorted(EXTENSIONS), 'recursive': True,
        'source_file_count': len(inventory), 'categories': dict(sorted(collections.Counter(item['category'] for item in inventory).items())),
        'category_labels': CATEGORY_LABELS, 'strict_utf8': True,
        'encoding_errors': encoding_errors, 'skipped_paths': skipped_paths,
        'coverage_complete': not skipped_paths, 'findings': findings,
        'operational_blocking_findings': blocking,
        'result': 'PASS' if not blocking else 'REVIEW REQUIRED',
        'limitations': [
            'Patterns are review leads, not proof of exploitability or correct runtime behavior.',
            'All six source scopes are inventoried; context-only findings remain visible.',
            'Unknown application paths and unrecognized migration data writes require review.',
            'Retained private code is read as text only, never imported or executed.',
            'Git history, credential scanning, service inspection, HTTP and browser tests are separate checks.',
            'This command neither packages nor deletes files, modifies source/private files, or accesses a database.',
        ],
    }
    return report, inventory


def output_directory(root, requested):
    root = Path(root).resolve(strict=True)
    candidate = Path(requested).absolute() if requested else root / 'verification'
    # Refuse output through symlinks/junctions; do not overwrite another checkout.
    for component in (candidate, *candidate.parents):
        if component.exists() and is_link(component):
            raise ValueError('linked output directory is not permitted')
    target = candidate.resolve()
    if target.is_relative_to(root):
        if not target.is_relative_to(root / 'verification'):
            raise ValueError('reports inside a checkout must be under verification')
    else:
        # External audit reports may contain private path metadata; keep them out
        # of the observed web document root.
        for ancestor in root.parents:
            if ancestor.name.lower() in {'htdocs', 'public_html', 'wwwroot'} and target.is_relative_to(ancestor):
                raise ValueError('external reports cannot be written into the web document root')
    return target


def main(argv=None):
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument('--root', type=Path, default=ROOT)
    parser.add_argument('--output-dir', type=Path)
    parser.add_argument('--verbose', action='store_true', help='Print finding locations, never source values')
    arguments = parser.parse_args(argv)
    try:
        root = arguments.root.resolve(strict=True)
        out = output_directory(root, arguments.output_dir)
        report, inventory = scan(root)
        out.mkdir(parents=True, exist_ok=True)
        reports = [(out / 'source-audit-current.json', report), (out / 'source-inventory-current.json', inventory)]
        for destination, _ in reports:
            if is_link(destination):
                raise ValueError('linked output file is not permitted')
        for destination, payload in reports:
            destination.write_text(json.dumps(payload, indent=2) + '\n', encoding='utf-8')
    except (OSError, ValueError) as error:
        print('Audit failed: ' + type(error).__name__ + ' (check root, output boundary, and read permissions)', file=sys.stderr)
        return 2
    print(json.dumps({'source_file_count': report['source_file_count'], 'categories': report['categories'], 'encoding_errors': len(report['encoding_errors']), 'skipped_paths': len(report['skipped_paths']), 'operational_blocking_findings': len(report['operational_blocking_findings']), 'result': report['result']}))
    if arguments.verbose:
        for item in report['findings']:
            print(f"{item['path']}:{item['line']} [{item['rule']}] {item['classification']}")
    return 0 if not report['operational_blocking_findings'] else 1


if __name__ == '__main__':
    raise SystemExit(main())
