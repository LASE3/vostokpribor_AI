#!/usr/bin/env python3
"""Build a production source ZIP without altering source files, uploads, or databases.

The production-source profile omits EVERY private dataset/model/sandbox payload,
local environment/credentials, Git history, caches/debug logs and generated test
output. Actual files remain on disk. Required storage roots and access-control
files remain in the ZIP. Outputs and manifests must stay outside the web root.

--old-inventory and --test-artifacts remain accepted for CLI compatibility, but
cannot override the production exclusion of private payloads.
"""
from __future__ import annotations

import argparse
from datetime import datetime, timezone
import hashlib
import json
import os
from pathlib import Path
import re
import zipfile

ROOT = Path(__file__).resolve().parents[1]
RUNTIME_ROOTS = ('storage/private/datasets', 'storage/private/models', 'storage/private/sandboxes')
RETIRED_TESTS = {'tests/test_audit_fixes.php', 'tests/test_full_platform.php', 'tests/test_inspect_job.php', 'tests/test_worker.php'}
CACHE_DIRS = {'__pycache__', '.pytest_cache', '.mypy_cache', '.ruff_cache', '.cache', 'cache', 'caches', 'node_modules', '.phpunit.cache'}
OUTPUT_DIRS = {'verification', 'scratch', 'test_output', 'test-output', 'test-results', 'playwright-report', 'coverage', 'htmlcov'}
CONTROL_FILES = {'.htaccess', '.gitkeep'}


def sha(path: Path) -> str:
    digest = hashlib.sha256()
    with path.open('rb') as source:
        for chunk in iter(lambda: source.read(1024 * 1024), b''):
            digest.update(chunk)
    return digest.hexdigest()


def external(value: str) -> Path:
    target = Path(value).resolve()
    source = ROOT.resolve()
    if target == source or source in target.parents:
        raise ValueError('Release outputs must be outside the source directory.')
    # A sibling ZIP under htdocs would still expose source and manifests publicly.
    web_roots = [parent for parent in (source, *source.parents) if parent.name.lower() in {'htdocs', 'public_html', 'wwwroot'}]
    if any(target == web or web in target.parents for web in web_roots):
        raise ValueError('Release outputs must be outside the web root.')
    target.parent.mkdir(parents=True, exist_ok=True)
    return target


def write_new(path: Path, payload: dict) -> None:
    with path.open('x', encoding='utf-8', newline='\n') as output:
        json.dump(payload, output, ensure_ascii=False, indent=2)
        output.write('\n')


def entries() -> list[Path]:
    """Enumerate without following links/junctions outside this exact source tree."""
    results = []
    source = ROOT.resolve()
    for parent, directories, filenames in os.walk(source, topdown=True, followlinks=False):
        for name in sorted(directories + filenames):
            item = Path(parent) / name
            if item.is_symlink() or (hasattr(item, 'is_junction') and item.is_junction()):
                raise ValueError('Symlinks/junctions require explicit release review: ' + item.relative_to(source).as_posix())
            results.append(item)
    return sorted(results)


def excluded(path: Path, relative: str) -> str | None:
    parts = tuple(part.lower() for part in path.relative_to(ROOT).parts)
    lower = relative.lower()
    name = path.name.lower()
    if '.git' in parts or '.svn' in parts or '.hg' in parts:
        return 'version-control history'
    if (name.startswith('.env') or name.endswith('.env')) and name != '.env.example':
        return 'local environment and credentials'
    if path.suffix.lower() in {'.pem', '.key', '.pfx', '.p12'}:
        return 'private local key material'
    if path.suffix.lower() in {'.json', '.ini', '.toml', '.yaml', '.yml', '.txt'} and re.search(r'(^|[._-])(credentials?|secrets?|passwords?)([._-]|$)', name) and '.example' not in name:
        return 'local credential artifact'
    if parts and parts[0] == 'storage':
        if path.name in CONTROL_FILES:
            return None
        if path.is_dir():
            return None
        return 'private/runtime payload; omitted from source ZIP only; original file preserved'
    if parts and parts[0] in {'verification', 'scratch'}:
        return 'generated verification output or one-off development inspection helper'
    if any(part in CACHE_DIRS for part in parts):
        return 'runtime/development cache'
    if any(part in OUTPUT_DIRS for part in parts):
        return 'generated test output'
    if any(part in {'.vscode', '.idea'} for part in parts):
        return 'local editor configuration'
    if path.suffix.lower() in {'.log', '.cache', '.pyc', '.pyo', '.sqlite', '.sqlite3', '.db'} or name in {'debug.log', 'error_log', '.ds_store', 'thumbs.db', '.eslintcache', '.phpunit.result.cache', '.coverage'}:
        return 'debug log, bytecode, local database or OS artifact'
    if path.suffix.lower() == '.sql' and not lower.startswith('database/migrations/'):
        return 'old SQL data dump or test database artifact; schema migrations retained'
    if relative in RETIRED_TESTS:
        return 'retired fixture suite'
    if path.is_file() and len(parts) == 2 and parts[0] == 'bin' and (name.startswith('patch_') or name in {'update_ticket_details.php', 'update_tickets_page.php'}):
        if 'retired' in path.read_text(encoding='utf-8-sig', errors='replace')[:512].lower():
            return 'verified retired one-off patcher'
    return None


def snapshot(path: Path) -> None:
    """Optional read-only inventory retained for callers of the earlier CLI."""
    files = []
    for directory in RUNTIME_ROOTS:
        base = ROOT / directory
        if not base.exists():
            continue
        for item in sorted(base.rglob('*')):
            if item.is_file() and item.name not in CONTROL_FILES:
                files.append({'path': item.relative_to(ROOT).as_posix(), 'bytes': item.stat().st_size, 'sha256': sha(item)})
    write_new(path, {'source_root': str(ROOT), 'purpose': 'Read-only private file inventory; source release excludes private payloads regardless of age.', 'files': files})
    print(json.dumps({'inventory': str(path), 'runtime_files_inventoried': len(files), 'source_files_deleted': 0}))


def build(output: Path, inventory_path: Path | None = None, tests_path: Path | None = None) -> None:
    output = external(str(output))
    manifest_path = output.with_suffix('.manifest.json')
    if output.exists() or manifest_path.exists():
        raise ValueError('Refusing to overwrite an existing release ZIP or manifest.')
    included, omitted = [], []
    controls = []
    for path in entries():
        relative = path.relative_to(ROOT).as_posix()
        reason = excluded(path, relative)
        if reason:
            if path.is_file():
                omitted.append({'path': relative, 'bytes': path.stat().st_size, 'reason': reason})
            continue
        if path.is_file():
            record = {'path': relative, 'bytes': path.stat().st_size, 'sha256': sha(path)}
            included.append(record)
            if path.name in CONTROL_FILES:
                controls.append(relative)
    # Retain only necessary source parents and explicit private roots, never old job trees.
    directories = {'storage/', 'storage/private/', *(directory + '/' for directory in RUNTIME_ROOTS)}
    for item in included:
        parent = Path(item['path']).parent
        while parent.as_posix() != '.':
            directories.add(parent.as_posix().rstrip('/') + '/')
            parent = parent.parent
    required = {'.env.example', '.htaccess', 'storage/private/.htaccess'}
    known = {item['path'] for item in included}
    if not required.issubset(known):
        raise ValueError('Missing required example environment or access-control files: ' + ', '.join(sorted(required - known)))
    if not any(item['path'].startswith('database/migrations/') and item['path'].endswith('.sql') for item in included):
        raise ValueError('Essential schema migrations are absent.')
    if not any(item['path'].startswith('app/Views/Layout/') for item in included):
        raise ValueError('Approved shared layout sources are absent.')

    with zipfile.ZipFile(output, 'x', compression=zipfile.ZIP_DEFLATED, compresslevel=9) as archive:
        for directory in sorted(directories):
            archive.writestr(directory, b'')
        for item in included:
            archive.write(ROOT / item['path'], item['path'])
    with zipfile.ZipFile(output) as archive:
        if archive.testzip() is not None:
            raise ValueError('ZIP CRC verification failed.')
        names = set(archive.namelist())
        for item in included:
            digest = hashlib.sha256(archive.read(item['path'])).hexdigest()
            if digest != item['sha256']:
                raise ValueError('A source file changed while packaging: ' + item['path'])
        for name in names:
            if not name.endswith('/') and excluded(ROOT / name, name):
                raise ValueError('An excluded artifact escaped the production source policy: ' + name)
        if any(not name.endswith('/') and name.startswith(base + '/') and Path(name).name not in CONTROL_FILES for name in names for base in RUNTIME_ROOTS):
            raise ValueError('Private runtime payload escaped exclusion.')
        if not required.issubset(names):
            raise ValueError('Required release entries missing.')
    digest = sha(output)
    write_new(manifest_path, {
        'source_root': str(ROOT.resolve()),
        'created_at_utc': datetime.now(timezone.utc).isoformat(),
        'profile': 'production_source',
        'zip': str(output),
        'zip_sha256': digest,
        'included_files': included,
        'excluded_files': omitted,
        'private_payload_policy': 'All private/runtime payloads omitted from archive, including newer uploads; no original files changed or deleted.',
        'legacy_inventory_inputs': {'old_inventory': str(inventory_path) if inventory_path else None, 'test_artifacts': str(tests_path) if tests_path else None},
        'preserved_access_control_files': controls,
        'source_files_deleted': 0,
        'database_accessed': False,
        'zip_integrity': 'PASSED',
        'included_file_hashes': 'PASSED'
    })
    print(json.dumps({'zip': str(output), 'manifest': str(manifest_path), 'included_files': len(included), 'excluded_files': len(omitted), 'private_payloads_included': 0, 'source_files_deleted': 0, 'database_accessed': False, 'sha256': digest}))


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description=__doc__)
    command = parser.add_mutually_exclusive_group(required=True)
    command.add_argument('--build', metavar='ZIP')
    command.add_argument('--snapshot-old', metavar='JSON')
    parser.add_argument('--old-inventory', metavar='JSON', help='Accepted for compatibility; cannot include private data in a production ZIP.')
    parser.add_argument('--test-artifacts', metavar='JSON', help='Accepted for compatibility; cannot include private data in a production ZIP.')
    options = parser.parse_args()
    if options.snapshot_old:
        snapshot(external(options.snapshot_old))
    else:
        build(external(options.build), Path(options.old_inventory).resolve() if options.old_inventory else None, Path(options.test_artifacts).resolve() if options.test_artifacts else None)
