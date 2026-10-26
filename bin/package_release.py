#!/usr/bin/env python3
"""Build a clean source ZIP without deleting, moving, or modifying any source/upload.

First capture the pre-install runtime files with --snapshot-old PATH. After docs
and tests, use --build OUTPUT.zip --old-inventory PATH. Paths must be outside
this repository. Only unchanged inventoried old files and exact inventoried test
artifacts are omitted. Future or modified real uploads remain in the ZIP and on
disk, with an explicit retained-runtime section in the release manifest.
"""
from __future__ import annotations
import argparse
import hashlib
import json
import re
from datetime import datetime, timezone
from pathlib import Path
import zipfile

ROOT = Path(__file__).resolve().parents[1]
RUNTIME_ROOTS = ('storage/private/datasets', 'storage/private/models', 'storage/private/sandboxes')
RETIRED_TESTS = {'tests/test_audit_fixes.php', 'tests/test_full_platform.php', 'tests/test_inspect_job.php', 'tests/test_worker.php'}
TEMP_SCRIPTS = {'storage/audit_page_shells.py', 'storage/audit_home.py', 'storage/repair_owned_ml.py', 'storage/replace_range_panels.py', 'storage/soc_backend_patch.py', 'storage/soc_dashboard_patch.py', 'storage/soc_page_patch.py', 'storage/soc_final_patch.py', 'storage/soc_student_patch.py', 'storage/soc_workspace_patch.py'}
CACHE_DIRS = {'__pycache__', '.pytest_cache', '.mypy_cache', '.cache', 'cache', 'caches'}

def sha(path: Path) -> str:
    h = hashlib.sha256()
    with path.open('rb') as f:
        for block in iter(lambda: f.read(1024 * 1024), b''):
            h.update(block)
    return h.hexdigest()

def external(path: str) -> Path:
    target = Path(path).resolve()
    if target == ROOT or ROOT in target.parents:
        raise ValueError('Release outputs and inventories must be outside the source repository.')
    target.parent.mkdir(parents=True, exist_ok=True)
    return target

def write_new(path: Path, payload: dict) -> None:
    with path.open('x', encoding='utf-8', newline='\n') as f:
        json.dump(payload, f, ensure_ascii=False, indent=2)
        f.write('\n')

def snapshot(path: Path) -> None:
    records = []
    for directory in RUNTIME_ROOTS:
        for item in sorted((ROOT / directory).rglob('*')):
            if item.is_file() and item.name not in {'.htaccess', '.gitkeep'}:
                records.append({'path': item.relative_to(ROOT).as_posix(), 'bytes': item.stat().st_size, 'sha256': sha(item)})
    write_new(path, {'source_root': str(ROOT), 'created_at_utc': datetime.now(timezone.utc).isoformat(), 'purpose': 'Pre-install runtime file inventory; no files were removed.', 'files': records})
    print(json.dumps({'inventory': str(path), 'old_runtime_files': len(records), 'source_files_deleted': 0}))

def build(output: Path, inventory_path: Path, tests_path: Path) -> None:
    if output.exists():
        raise ValueError('Refusing to overwrite an existing release ZIP.')
    inventory = json.loads(inventory_path.read_text(encoding='utf-8'))
    if Path(inventory['source_root']).resolve() != ROOT:
        raise ValueError('Old-file inventory belongs to a different repository.')
    old_files = {entry['path']: entry['sha256'] for entry in inventory['files']}
    test_inventory = json.loads(tests_path.read_text(encoding='utf-8'))
    if isinstance(test_inventory, dict) and 'source_root' in test_inventory and Path(test_inventory['source_root']).resolve() != ROOT:
        raise ValueError('Test artifact inventory belongs to a different repository.')
    test_entries = test_inventory if isinstance(test_inventory, list) else test_inventory['files']
    test_files = {}
    for entry in test_entries:
        if not isinstance(entry, dict) or not re.fullmatch(r'[a-f0-9]{64}', str(entry.get('sha256', ''))):
            raise ValueError('Each exact test artifact requires path and SHA-256; blanket/path-only exclusions are refused.')
        relative = str(entry['path']).replace('\\', '/')
        resolved = (ROOT / relative).resolve()
        if ROOT not in resolved.parents or not any(relative.startswith(base + '/') for base in RUNTIME_ROOTS):
            raise ValueError('Test artifact exclusions must name exact private-runtime files inside the repository.')
        test_files[relative] = entry['sha256']
    included, omitted, directories, retained_runtime = [], [], [], []
    for path in sorted(ROOT.rglob('*')):
        rel = path.relative_to(ROOT).as_posix()
        parts = path.relative_to(ROOT).parts
        if path.is_symlink():
            raise ValueError('Symlinks require explicit release review: ' + rel)
        runtime = any(rel.startswith(base + '/') for base in RUNTIME_ROOTS)
        reason = None
        digest = sha(path) if path.is_file() else None
        if runtime:
            # Future real files, including modified old paths, never fall through to
            # generic log/cache/helper exclusions. Preserve them with an explicit manifest.
            if path.is_file() and path.name not in {'.htaccess', '.gitkeep'}:
                if rel in old_files and digest == old_files[rel]: reason = 'unchanged pre-install runtime artifact'
                elif rel in test_files and digest == test_files[rel]: reason = 'unchanged inventoried isolated-test artifact'
                else: retained_runtime.append({'path': rel, 'bytes': path.stat().st_size, 'sha256': digest, 'reason': 'post-baseline or modified runtime file preserved'})
        elif '.git' in parts: reason = 'bundled Git history'
        elif path.name.startswith('.env') and path.name != '.env.example': reason = 'local environment secrets'
        elif rel == 'database/vostokpribor_ai.sql': reason = 'old database dump containing prior work records; backup retained on disk'
        elif any(part in CACHE_DIRS for part in parts): reason = 'runtime cache'
        elif path.is_file() and not rel.startswith('verification/') and (path.suffix.lower() == '.log' or path.name.lower() in {'debug.log', 'error_log'}): reason = 'debug/runtime log'
        elif rel in RETIRED_TESTS: reason = 'retired fixture test'
        elif rel in TEMP_SCRIPTS or (path.parent == ROOT / 'storage' and path.suffix.lower() == '.py'): reason = 'one-off patch script containing previous fixture literals'
        if reason:
            if path.is_file(): omitted.append({'path': rel, 'reason': reason, 'bytes': path.stat().st_size, 'sha256': digest})
            continue
        if path.is_dir(): directories.append(rel + '/')
        elif path.is_file(): included.append({'path': rel, 'bytes': path.stat().st_size, 'sha256': digest})
    # Empty historical job subdirectories are runtime artifacts, while all storage
    # roots and directories needed by retained real files remain in the archive.
    included_paths = [item['path'] for item in included]
    directories = [directory for directory in directories if not any(directory.startswith(base + '/') for base in RUNTIME_ROOTS) or any(name.startswith(directory) for name in included_paths)]
    # Always keep private directory structure and every applicable access-control file.
    for directory in ('storage/', 'storage/private/', *(name + '/' for name in RUNTIME_ROOTS)):
        if directory not in directories: directories.append(directory)
    manifest_path = output.with_suffix('.manifest.json')
    if manifest_path.exists(): raise ValueError('Refusing to overwrite a release manifest.')
    with zipfile.ZipFile(output, 'x', compression=zipfile.ZIP_DEFLATED, compresslevel=9) as archive:
        for directory in sorted(set(directories)): archive.writestr(directory, b'')
        for record in included: archive.write(ROOT / record['path'], record['path'])
    with zipfile.ZipFile(output) as archive:
        bad = archive.testzip()
        if bad: raise ValueError('ZIP integrity verification failed: ' + bad)
        names = set(archive.namelist())
        if '.env' in names or any(name.startswith('.git/') for name in names): raise ValueError('Sensitive artifact escaped exclusion.')
        for required in ('.env.example', '.htaccess', 'storage/private/.htaccess', *[name + '/' for name in RUNTIME_ROOTS]):
            if required not in names: raise ValueError('Required packaging entry missing: ' + required)
    write_new(manifest_path, {'source_root': str(ROOT), 'created_at_utc': datetime.now(timezone.utc).isoformat(), 'zip': str(output), 'zip_sha256': sha(output), 'old_inventory': str(inventory_path), 'test_artifact_inventory': str(tests_path), 'retained_runtime_files': retained_runtime, 'included_files': included, 'excluded_files': omitted, 'source_files_deleted': 0, 'zip_integrity': 'PASSED'})
    print(json.dumps({'zip': str(output), 'manifest': str(manifest_path), 'included_files': len(included), 'excluded_files': len(omitted), 'retained_runtime_files': len(retained_runtime), 'source_files_deleted': 0, 'sha256': sha(output)}))

if __name__ == '__main__':
    parser = argparse.ArgumentParser(description=__doc__)
    group = parser.add_mutually_exclusive_group(required=True)
    group.add_argument('--snapshot-old', metavar='JSON')
    group.add_argument('--build', metavar='ZIP')
    parser.add_argument('--old-inventory', metavar='JSON')
    parser.add_argument('--test-artifacts', metavar='JSON')
    args = parser.parse_args()
    if args.snapshot_old: snapshot(external(args.snapshot_old))
    else:
        if not args.old_inventory or not args.test_artifacts: parser.error('--build requires --old-inventory and --test-artifacts (exact path/SHA-256 inventory, possibly empty)')
        build(external(args.build), Path(args.old_inventory).resolve(), Path(args.test_artifacts).resolve())
