"""Read-only-to-workspace package policy test using a verified temporary directory."""
import contextlib
import hashlib
import importlib.util
import io
import json
from pathlib import Path
import tempfile
import zipfile

SOURCE_ROOT = Path(__file__).resolve().parents[1]
spec = importlib.util.spec_from_file_location('release_policy', SOURCE_ROOT / 'bin/package_release.py')
policy = importlib.util.module_from_spec(spec)
spec.loader.exec_module(policy)
checks = 0

def check(value, label):
    global checks
    if not value:
        raise AssertionError(label)
    checks += 1
    print('PASS: ' + label)

temporary = tempfile.TemporaryDirectory(prefix='vostok_packaging_guard_')
sandbox = Path(temporary.name).resolve()
assert sandbox.parent == Path(tempfile.gettempdir()).resolve() and sandbox.name.startswith('vostok_packaging_guard_')
try:
    source = sandbox / 'source'
    source.mkdir()
    policy.ROOT = source
    for directory in policy.RUNTIME_ROOTS:
        (source / directory).mkdir(parents=True, exist_ok=True)
    def write(relative, content):
        target = source / relative
        target.parent.mkdir(parents=True, exist_ok=True)
        target.write_bytes(content)
        return target
    write('.env.example', b'APP_ENV=local\n')
    write('.env', b'not a real credential\n')
    write('.git/objects/old-history', b'old history fixture')
    write('.htaccess', b'Options -Indexes\n')
    write('storage/private/.htaccess', b'Require all denied\n')
    write('database/migrations/001_schema.sql', b'CREATE TABLE preserved (id INT);\n')
    write('database/vostokpribor_ai.sql', b'-- previous data artifact\n')
    write('verification/verified.log', b'PASS: retained test evidence\n')
    old = write('storage/private/datasets/old.csv', b'old bytes\n')
    changed = write('storage/private/models/changed.bin', b'previous bytes')
    inventory = sandbox / 'old.json'
    with contextlib.redirect_stdout(io.StringIO()):
        policy.snapshot(inventory)
    changed.write_bytes(b'real replacement after baseline')
    future = write('storage/private/datasets/real.csv', b'actual new bytes\n')
    future_code = write('storage/private/sandboxes/new-user/workload.py', b'# future real code must not be removed\n')
    fixture = write('storage/private/datasets/test.csv', b'guarded test fixture\n')
    tests = sandbox / 'tests.json'
    tests.write_text(json.dumps({'source_root': str(source), 'files': [{'path': fixture.relative_to(source).as_posix(), 'sha256': hashlib.sha256(fixture.read_bytes()).hexdigest()}]}), encoding='utf-8')
    result = sandbox / 'release.zip'
    with contextlib.redirect_stdout(io.StringIO()):
        policy.build(result, inventory, tests)
    with zipfile.ZipFile(result) as archive:
        names = set(archive.namelist())
        check('storage/private/datasets/old.csv' not in names, 'Unchanged inventoried old upload omitted only from ZIP')
        check('storage/private/datasets/test.csv' not in names, 'Exact inventoried test upload omitted only from ZIP')
        check('storage/private/datasets/real.csv' in names and archive.read('storage/private/datasets/real.csv') == future.read_bytes(), 'Future real upload preserved byte-for-byte in ZIP')
        check('storage/private/models/changed.bin' in names and archive.read('storage/private/models/changed.bin') == changed.read_bytes(), 'Modified old upload is preserved as new real data')
        check('storage/private/sandboxes/new-user/workload.py' in names, 'Future sandbox code bypasses one-off helper exclusion')
        check('.env' not in names and not any(name.startswith('.git/') for name in names), 'Environment secrets and Git history omitted')
        check('.env.example' in names and '.htaccess' in names and 'storage/private/.htaccess' in names, 'Example configuration and access control retained')
        check('database/migrations/001_schema.sql' in names and 'database/vostokpribor_ai.sql' not in names, 'Essential migration kept and old data dump omitted')
        check('verification/verified.log' in names, 'Current verification logs remain in deliverable')
        check(all(directory + '/' in names for directory in policy.RUNTIME_ROOTS), 'All required private storage directory entries retained')
        check(archive.testzip() is None, 'ZIP CRC integrity passes')
    manifest = json.loads(result.with_suffix('.manifest.json').read_text(encoding='utf-8'))
    check(len(manifest['retained_runtime_files']) == 3, 'Manifest explicitly identifies all preserved future or modified files')
    check(old.exists() and fixture.exists() and future.exists() and future_code.exists() and changed.exists(), 'Packaging never deletes any source or upload on disk')
    print(str(checks) + ' packaging preservation checks passed; no workspace data or database accessed.')
finally:
    # This exact absolute generated target was checked above to stay under the OS
    # temporary directory with the test-specific name prefix before recursive cleanup.
    temporary.cleanup()
