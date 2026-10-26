from pathlib import Path
p=Path('bin/package_release.py');s=p.read_text(encoding='utf-8')
s=s.replace('this repository. All private runtime contents are excluded from the release ZIP,\nwhile every upload remains untouched on disk. The old inventory documents prior data.', 'this repository. Only unchanged inventoried old files and exact inventoried test\nartifacts are omitted. Future or modified real uploads remain in the ZIP and on\ndisk, with an explicit retained-runtime section in the release manifest.')
s=s.replace('def build(output: Path, inventory_path: Path, tests_path: Path | None) -> None:', 'def build(output: Path, inventory_path: Path, tests_path: Path) -> None:')
a=s.index('    test_files = set()')
b=s.index('    # Always keep private directory structure',a)
s=s[:a]+'''    test_inventory = json.loads(tests_path.read_text(encoding='utf-8'))
    if isinstance(test_inventory, dict) and 'source_root' in test_inventory and Path(test_inventory['source_root']).resolve() != ROOT:
        raise ValueError('Test artifact inventory belongs to a different repository.')
    test_entries = test_inventory if isinstance(test_inventory, list) else test_inventory['files']
    test_files = {}
    for entry in test_entries:
        if not isinstance(entry, dict) or not re.fullmatch(r'[a-f0-9]{64}', str(entry.get('sha256', ''))):
            raise ValueError('Each exact test artifact requires path and SHA-256; blanket/path-only exclusions are refused.')
        relative = str(entry['path']).replace('\\\\', '/')
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
'''+s[b:]
s=s.replace('import json\n', 'import json\nimport re\n')
s=s.replace("'old_inventory': str(inventory_path), 'included_files'", "'old_inventory': str(inventory_path), 'test_artifact_inventory': str(tests_path), 'retained_runtime_files': retained_runtime, 'included_files'")
s=s.replace("'excluded_files': len(omitted), 'source_files_deleted'", "'excluded_files': len(omitted), 'retained_runtime_files': len(retained_runtime), 'source_files_deleted'")
s=s.replace("        if not args.old_inventory: parser.error('--build requires --old-inventory')\n        build(external(args.build), Path(args.old_inventory).resolve(), Path(args.test_artifacts).resolve() if args.test_artifacts else None)", "        if not args.old_inventory or not args.test_artifacts: parser.error('--build requires --old-inventory and --test-artifacts (exact path/SHA-256 inventory, possibly empty)')\n        build(external(args.build), Path(args.old_inventory).resolve(), Path(args.test_artifacts).resolve())")
p.write_text(s,encoding='utf-8')
