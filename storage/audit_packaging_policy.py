from pathlib import Path
p=Path('bin/audit_source.py');s=p.read_text(encoding='utf-8')
s=s.replace('retained_private_runtime_excluded_from_zip', 'retained_private_runtime_not_executed')
s=s.replace('Prior runtime files and the old SQL backup stay on disk and are excluded only from the release ZIP.', 'Prior inventoried runtime artifacts and the old SQL backup stay on disk. Only exact old/test hashes are omitted from the ZIP; unknown or changed future real uploads are preserved with a manifest.')
p.write_text(s,encoding='utf-8')
