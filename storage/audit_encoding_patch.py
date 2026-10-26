from pathlib import Path
p=Path('bin/audit_source.py')
s=p.read_text(encoding='utf-8')
s=s.replace('findings = []\ninventory = []', 'findings = []\ninventory = []\nencoding_errors = []')
s=s.replace("    for number, line in enumerate(content.decode('utf-8-sig', errors='replace').splitlines(), 1):", "    try:\n        decoded = content.decode('utf-8-sig', errors='strict')\n    except UnicodeDecodeError as error:\n        line_number = content[:error.start].count(b'\\n') + 1\n        encoding_errors.append({'path': relative, 'line': line_number, 'byte_offset': error.start, 'classification': category(relative)})\n        findings.append({'path': relative, 'line': line_number, 'rule': 'invalid_utf8', 'match': 'invalid byte at offset ' + str(error.start), 'classification': category(relative)})\n        decoded = content.decode('utf-8-sig', errors='replace')\n    for number, line in enumerate(decoded.splitlines(), 1):")
s=s.replace("'findings': findings, 'operational_blocking_findings'", "'strict_utf8': True, 'encoding_errors': encoding_errors, 'findings': findings, 'operational_blocking_findings'")
s=s.replace("print('Operational blocking findings:', len(blocking))", "print('UTF-8 encoding failures:', len(encoding_errors))\nprint('Operational blocking findings:', len(blocking))")
p.write_text(s,encoding='utf-8')
