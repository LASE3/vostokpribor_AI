"""Guard legacy HTTP tests before writes; no public identity endpoint or database names sent."""
from pathlib import Path
from urllib.parse import urlsplit
import json, os, re
LOOPBACK = ('localhost', '127.0.0.1', '::1')

def preflight_cli_target(root):
    """Verify CLI identity and the HTTP instance cookie before any legacy test can log in."""
    import subprocess
    import requests
    code = ("require $argv[1]; echo json_encode(['environment'=>App\\Core\\Env::get('APP_ENV'),"
            "'database'=>App\\Core\\Env::get('DB_NAME'),'host'=>App\\Core\\Env::get('DB_HOST'),"
            "'app_url'=>App\\Core\\Env::get('APP_URL'),'cookie'=>App\\Core\\Env::get('SESSION_COOKIE_NAME')]);")
    probe = json.loads(subprocess.check_output([os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe'),'-r',code,str(Path(root)/'app/bootstrap.php')],cwd=root,text=True))
    base = guarded_target(probe)
    if probe.get('host') not in LOOPBACK:
        raise SystemExit('REFUSED: HTTP tests require a loopback testing database host.')
    with requests.Session() as session:
        initialize_session(session,base,probe)
    return dict(probe,base_url=base)

def guarded_target(probe):
    if probe.get('environment') != 'testing' or not str(probe.get('database', '')).endswith('_test'):
        raise SystemExit('REFUSED: dedicated APP_ENV=testing and _test database required.')
    base = str(probe.get('app_url', '')).rstrip('/')
    parsed = urlsplit(base)
    if parsed.scheme not in ('http', 'https') or parsed.hostname not in LOOPBACK or parsed.username or parsed.password or parsed.query or parsed.fragment:
        raise SystemExit('REFUSED: configured test APP_URL must be a plain loopback installation URL.')
    override = os.environ.get('TEST_BASE_URL', base).rstrip('/')
    if override != base:
        raise SystemExit('REFUSED: TEST_BASE_URL must exactly match the guarded CLI APP_URL.')
    cookie = str(probe.get('cookie', ''))
    if not re.fullmatch(r'[A-Za-z][A-Za-z0-9_]*_test', cookie):
        raise SystemExit('REFUSED: tests require a separate session cookie name ending in _test.')
    return base

def initialize_session(session, base, probe):
    response = session.get(base + '/api/v1/auth/csrf', timeout=20)
    if response.status_code != 200 or not any(item.name == probe['cookie'] for item in session.cookies):
        raise SystemExit('REFUSED: HTTP target did not issue the guarded testing instance cookie; no write attempted.')
    payload = response.json()
    token = payload.get('data', {}).get('csrf_token')
    if payload.get('success') is not True or not isinstance(token, str) or not re.fullmatch(r'[a-f0-9]{64}', token):
        raise SystemExit('REFUSED: HTTP target returned an invalid CSRF envelope; no write attempted.')
    return token

def credential_file(root):
    configured = os.environ.get('TEST_CREDENTIALS_FILE')
    path = (Path(configured) if configured else Path.home()/'.codex/tmp/vostok-integration-20261030-credentials.json').expanduser().resolve()
    boundaries = [Path(root).resolve(), Path(r'C:\xampp\htdocs').resolve()]
    if any(path == boundary or boundary in path.parents for boundary in boundaries):
        raise SystemExit('REFUSED: test credentials must stay outside source and web root.')
    return path

def credentials_for(path, database):
    if not path.is_file():
        raise SystemExit('REFUSED: supply the private TEST_CREDENTIALS_FILE created for this test database.')
    value = json.loads(path.read_text(encoding='utf-8')).get(database)
    if not isinstance(value, dict) or not isinstance(value.get('admin_password'), str) or not value['admin_password']:
        raise SystemExit('REFUSED: private credential file has no account for this exact test database.')
    return value
