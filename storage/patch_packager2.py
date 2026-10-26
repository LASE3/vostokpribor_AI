from pathlib import Path
p=Path('bin/package_release.py');s=p.read_text()
s=s.replace("elif path.name == '.env': reason = 'local environment secrets'", "elif path.name.startswith('.env') and path.name != '.env.example': reason = 'local environment secrets'\n        elif rel == 'database/vostokpribor_ai.sql': reason = 'old database dump containing prior work records; backup retained on disk'")
s=s.replace("elif rel in TEMP_SCRIPTS: reason = 'one-off patch script containing previous fixture literals'", "elif rel in TEMP_SCRIPTS or (rel.startswith('storage/') and path.suffix.lower() == '.py'): reason = 'one-off patch script containing previous fixture literals'")
p.write_text(s)
