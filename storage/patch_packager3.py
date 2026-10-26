from pathlib import Path
p=Path('bin/package_release.py');s=p.read_text();s=s.replace("elif path.is_file() and (path.suffix.lower() == '.log' or path.name.lower() in {'debug.log', 'error_log'}): reason = 'debug/runtime log'", "elif path.is_file() and not rel.startswith('verification/') and (path.suffix.lower() == '.log' or path.name.lower() in {'debug.log', 'error_log'}): reason = 'debug/runtime log'")
p.write_text(s)
