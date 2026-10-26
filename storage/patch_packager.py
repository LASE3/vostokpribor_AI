from pathlib import Path
p=Path('bin/package_release.py');s=p.read_text();s=s.replace('this repository. New real uploads absent from the inventory are preserved.\nExplicit test-generated artifacts can be listed in --test-artifacts JSON.', 'this repository. All private runtime contents are excluded from the release ZIP,\nwhile every upload remains untouched on disk. The old inventory documents prior data.')
s=s.replace("        elif rel in test_files: reason = 'explicit isolated-test artifact'", "        elif rel in test_files: reason = 'explicit isolated-test artifact'\n        elif any(rel.startswith(base + '/') for base in RUNTIME_ROOTS) and path.name not in {'.htaccess', '.gitkeep'}: reason = 'private runtime content omitted from clean release; source file preserved'")
p.write_text(s)
