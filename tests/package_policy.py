"""Production source packaging policy tests; only an isolated OS temporary tree is used."""
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

def check(condition, label):
    global checks
    if not condition:
        raise AssertionError(label)
    checks += 1
    print('PASS: ' + label)

temporary = tempfile.TemporaryDirectory(prefix='vostok_source_release_guard_')
sandbox = Path(temporary.name).resolve()
assert sandbox.parent == Path(tempfile.gettempdir()).resolve() and sandbox.name.startswith('vostok_source_release_guard_')
try:
    source = sandbox / 'source'
    source.mkdir()
    policy.ROOT = source
    def write(relative, content):
        file = source / relative
        file.parent.mkdir(parents=True, exist_ok=True)
        file.write_bytes(content)
        return file

    for directory in policy.RUNTIME_ROOTS:
        (source / directory).mkdir(parents=True, exist_ok=True)
    write('.env.example', b'APP_ENV=production\nDB_NAME=configure_explicitly\n')
    write('.env', b'DB_PASS=temporary-secret-sentinel\n')
    write('.env.testing', b'local-only environment\n')
    write('development.env', b'local-only environment\n')
    write('.git/objects/old-history', b'old history')
    write('.gitignore', b'.env\n')
    write('.htaccess', b'Options -Indexes\n')
    write('storage/private/.htaccess', b'Require all denied\n')
    write('storage/private/datasets/.htaccess', b'Require all denied\n')
    write('storage/private/models/.gitkeep', b'')
    write('database/migrations/001_schema.sql', b'CREATE TABLE preserved (id INT);\n')
    write('database/migrations/004_forward_only.sql', b'ALTER TABLE preserved ADD value INT;\n')
    write('database/vostokpribor_ai.sql', b'-- old database data artifact\n')
    write('app/Views/Layout/AppLayout.php', b'<?php /* approved shared layout */\n')
    write('assets/branding/logo.svg', b'<svg><!-- official asset placeholder --></svg>')
    write('api/v1/modules/data.php', b'<?php /* shared API registrations */\n')
    write('change-password.php', b'<?php /* active authentication flow */\n')
    write('tests/dataset_lifecycle.php', b'<?php /* active guarded contract test */\n')
    write('tests/test_full_platform.php', b'<?php /* retired fixture entry point */\n')
    write('bin/patch_old.php', b'<?php /* Retired one-off patcher */\n')
    write('bin/patch_active.php', b'<?php /* active forward maintenance utility */\n')
    write('README.md', b'# Actual implementation and setup\n')
    write('VERIFIED_COMPLETED_FEATURES.md', b'# Verification report\n')
    write('verification/results.log', b'Generated test output omitted from source release\n')
    write('verification/browser.png', b'not a real screenshot')
    write('scratch/debug.py', b'# one-off development inspection\n')
    write('storage/repair_old.py', b'# previous fixture patcher\n')
    write('bin/__pycache__/tool.pyc', b'compiled bytecode')
    write('logs/debug.log', b'development log')
    write('.eslintcache', b'development cache')
    write('.phpunit.result.cache', b'test cache')
    write('tests/test_output/response.json', b'generated HTTP response')
    write('tests/local_credentials.json', b'{"password":"temporary-secret-sentinel"}')
    write('local-test.sqlite', b'local database artifact')

    old = write('storage/private/datasets/old.csv', b'older private bytes\n')
    changed = write('storage/private/models/changed.bin', b'updated genuine private artifact')
    future = write('storage/private/datasets/new_real.csv', b'new real upload after installation\n')
    future_code = write('storage/private/sandboxes/new-user/workload.py', b'# actual student saved work\n')
    before = {str(file.relative_to(source)): hashlib.sha256(file.read_bytes()).hexdigest() for file in source.rglob('*') if file.is_file()}

    archive_path = sandbox / 'release.zip'
    with contextlib.redirect_stdout(io.StringIO()):
        policy.build(archive_path)
    with zipfile.ZipFile(archive_path) as archive:
        names = set(archive.namelist())
        check('storage/private/datasets/old.csv' not in names, 'Old private upload omitted from ZIP')
        check('storage/private/datasets/new_real.csv' not in names, 'New private upload omitted from source ZIP without deleting its original')
        check('storage/private/models/changed.bin' not in names, 'Modified real model artifact omitted from source ZIP without deleting it')
        check('storage/private/sandboxes/new-user/workload.py' not in names, 'Private student sandbox code omitted from source ZIP')
        check('.env' not in names and '.env.testing' not in names and 'development.env' not in names, 'Every local environment file omitted')
        check(not any(name.startswith('.git/') for name in names), 'Bundled Git history omitted')
        check('.gitignore' in names and '.env.example' in names, 'Source ignore rules and example configuration retained')
        check('.htaccess' in names and 'storage/private/.htaccess' in names and 'storage/private/datasets/.htaccess' in names, 'Required access-control files retained')
        check(all(directory + '/' in names for directory in policy.RUNTIME_ROOTS), 'All private storage root directory entries retained')
        check('storage/private/models/.gitkeep' in names, 'Storage directory marker retained')
        check('database/migrations/001_schema.sql' in names and 'database/migrations/004_forward_only.sql' in names, 'Initial and forward-only migrations retained')
        check('database/vostokpribor_ai.sql' not in names and 'local-test.sqlite' not in names, 'Old data dumps and local test databases omitted')
        check('app/Views/Layout/AppLayout.php' in names and 'assets/branding/logo.svg' in names, 'Approved layout and official branding source retained')
        check('api/v1/modules/data.php' in names, 'Active API module source retained')
        check('change-password.php' in names, 'Active password change flow not mistaken for a credential artifact')
        check('tests/dataset_lifecycle.php' in names and 'tests/test_full_platform.php' not in names, 'Current guarded tests retained and retired fixture suite omitted')
        check('bin/patch_old.php' not in names and 'bin/patch_active.php' in names, 'Only verified retired patcher is excluded')
        check(not any(name.startswith('verification/') for name in names), 'Generated test logs and screenshots omitted from production source')
        check('scratch/debug.py' not in names and 'storage/repair_old.py' not in names, 'One-off development helpers omitted')
        check('bin/__pycache__/tool.pyc' not in names and 'logs/debug.log' not in names and '.eslintcache' not in names and '.phpunit.result.cache' not in names, 'Caches and debug logs omitted')
        check('tests/local_credentials.json' not in names and 'tests/test_output/response.json' not in names, 'Local credentials and generated HTTP output omitted')
        check('README.md' in names and 'VERIFIED_COMPLETED_FEATURES.md' in names, 'Implementation and installation documentation retained')
        check(archive.testzip() is None, 'ZIP CRC verification passes')
        check(not any(b'temporary-secret-sentinel' in archive.read(name) for name in names if not name.endswith('/')), 'No temporary credential sentinel enters archive payload')

    manifest = json.loads(archive_path.with_suffix('.manifest.json').read_text(encoding='utf-8'))
    check(manifest['profile'] == 'production_source' and manifest['source_files_deleted'] == 0 and manifest['database_accessed'] is False, 'Manifest records source-only profile with zero file deletion/database access')
    check(hashlib.sha256(archive_path.read_bytes()).hexdigest() == manifest['zip_sha256'], 'Manifest archive SHA-256 matches actual bytes')
    with zipfile.ZipFile(archive_path) as archive:
        check(all(hashlib.sha256(archive.read(item['path'])).hexdigest() == item['sha256'] for item in manifest['included_files']), 'Every included source hash matches archive payload')
    after = {str(file.relative_to(source)): hashlib.sha256(file.read_bytes()).hexdigest() for file in source.rglob('*') if file.is_file()}
    check(before == after and all(file.exists() for file in (old, changed, future, future_code)), 'Every original source/private file stays unchanged on disk')
    try:
        policy.build(archive_path)
        raise AssertionError('Existing archive was overwritten')
    except ValueError:
        check(True, 'Existing release ZIP/manifest cannot be overwritten')
    previous = policy.ROOT
    policy.ROOT = sandbox / 'htdocs' / 'source'
    try:
        policy.external(str(sandbox / 'htdocs' / 'release.zip'))
        raise AssertionError('Web-root output accepted')
    except ValueError:
        check(True, 'Output inside web root is refused')
    finally:
        policy.ROOT = previous
    print(str(checks) + ' production source packaging checks passed; no workspace data or database accessed.')
finally:
    # The exact absolute temporary target was checked above for OS temp parent
    # and our test-specific prefix before recursive cleanup.
    temporary.cleanup()
