"""Actual V10 role boundaries and student_test workflow on a guarded isolated installation.

Creates explicit test-only work, never resets an existing account/database, and keeps
random credentials outside source/webroot. Run after isolated admin bootstrap.
"""
from html.parser import HTMLParser
from pathlib import Path
from urllib.parse import quote, unquote, urljoin, urlparse
import json
import os
import secrets
import subprocess
import requests
from http_test_target import preflight_cli_target, credential_file, credentials_for, initialize_session

ROOT = Path(__file__).resolve().parents[1]
PHP = os.environ.get('PHP_BINARY', r'C:\xampp\php\php.exe')
GUARD = preflight_cli_target(ROOT)
BASE = GUARD['base_url']
PRIVATE = credential_file(ROOT)
CREDENTIALS = credentials_for(PRIVATE, GUARD['database'])
PASSED = 0
OBSERVED = []


def check(condition, label):
    global PASSED
    if not condition:
        raise AssertionError(label)
    PASSED += 1
    print('PASS ' + label, flush=True)


class Markup(HTMLParser):
    def __init__(self, text):
        super().__init__()
        self.links = []
        self.interactive = []
        self.feed(text)

    def handle_starttag(self, tag, attrs):
        values = dict(attrs)
        if tag == 'a':
            self.links.append(values)
        for key in ('href', 'action', 'formaction', 'data-href', 'data-url', 'onclick'):
            if values.get(key):
                self.interactive.append(values[key])


def is_soc(value):
    decoded = unquote(value).casefold()
    return 'ai operations center (ai soc)' in decoded or '/soc/' in decoded


class Client:
    def __init__(self):
        self.session = requests.Session()
        self.token = initialize_session(self.session, BASE, GUARD)

    def call(self, method, route, body=None, statuses=(200, 201), files=None):
        response = self.session.request(
            method, BASE + '/api/v1/' + route,
            json=body if files is None else None,
            data=body if files is not None else None,
            files=files, headers={'X-CSRF-Token': self.token}, timeout=25)
        check(response.status_code in statuses, method + ' ' + route + ' HTTP ' + str(response.status_code))
        result = response.json()
        check(result.get('success') is response.ok, 'truthful response envelope')
        data = result.get('data')
        if isinstance(data, dict) and data.get('csrf_token'):
            self.token = data['csrf_token']
        return data

    def login(self, identifier, password):
        return self.call('POST', 'auth/login', {'login': identifier, 'password': password})

    def page(self, path, status=200):
        response = self.session.get(BASE + '/' + quote(path, safe='/?=&%'), timeout=25, allow_redirects=False)
        check(response.status_code == status, 'HTML ' + path + ' HTTP ' + str(status))
        check(not any(value in response.text for value in ['Fatal error', 'Warning:', 'Application Error']), 'safe HTML response')
        return response


def store_credentials(values):
    all_values = json.loads(PRIVATE.read_text(encoding='utf-8'))
    all_values[GUARD['database']].update(values)
    PRIVATE.write_text(json.dumps(all_values, indent=2), encoding='utf-8')


SOC = 'AI Operations Center (AI SOC)/Dashboard.php'
admin = Client()
auth = admin.login('admin', CREDENTIALS['admin_password'])
check(auth['role'] == 'ADMIN', 'administrator role comes from authenticated backend')
check(unquote(auth['redirect_url']).endswith('/' + SOC), 'administrator API login destination is SOC Dashboard')
landing = admin.page('index.php', 302)
check(unquote(landing.headers['Location']).endswith('/' + SOC), 'administrator root redirects server-side to SOC Dashboard')
soc_dashboard = admin.page(SOC)
admin_links = Markup(soc_dashboard.text).links
student_folders = ['AI Project Management', 'Data Center', 'ML Workbench', 'Model Registry & Deployment']
check(not any(any(folder.casefold() in unquote(link.get('href', '')).casefold() for folder in student_folders) for link in admin_links), 'administrator navigation has no student-system destinations')

# Normal provisioning canonicalizes identifiers to uppercase; lower-case login is supported.
existing = admin.call('GET', 'soc/students?search=student_test&limit=100')['items']
existing = [row for row in existing if row['identifier'].casefold() == 'student_test']
if existing:
    check(len(existing) == 1, 'one canonical dedicated test identity')
    saved = CREDENTIALS.get('role_student_test')
    if not isinstance(saved, dict) or int(saved.get('id', 0)) != int(existing[0]['id']):
        raise SystemExit('REFUSED: existing student_test has no matching private credentials; no reset attempted.')
    primary = existing[0]
    primary_password = saved['password']
else:
    issued = secrets.token_urlsafe(32)
    primary = admin.call('POST', 'soc/students', {
        'identifier': 'student_test', 'full_name': 'VOSTOKPRIBOR Test Student',
        'email': 'student-test-' + secrets.token_hex(5) + '@example.invalid',
        'password': issued, 'status': 'ACTIVE'})
    store_credentials({'role_student_test': {'id': int(primary['id']), 'identifier': 'student_test', 'password': issued, 'must_rotate': True}})
    primary_password = issued
check(primary['full_name'] == 'VOSTOKPRIBOR Test Student' and primary['role'] == 'STUDENT' and primary['status'] == 'ACTIVE', 'dedicated active test student provisioned through SOC')
student = Client()
auth = student.login('student_test', primary_password)
check(auth['role'] == 'STUDENT', 'student_test lower-case login resolves canonical student identity')
if auth['must_change_password']:
    check(unquote(auth['redirect_url']).endswith('/change-password.php'), 'initial student password requires real rotation')
    rotated = secrets.token_urlsafe(32)
    student.call('POST', 'auth/change-password', {'current_password': primary_password, 'new_password': rotated})
    primary_password = rotated
    store_credentials({'role_student_test': {'id': int(primary['id']), 'identifier': 'student_test', 'password': rotated, 'must_rotate': False}})
else:
    check(unquote(auth['redirect_url']).endswith('/index.php'), 'rotated student login destination is four-system portal')

account_probe = r'''require $argv[1].'/app/bootstrap.php';
if(App\Core\Env::get('APP_ENV')!=='testing'||!str_ends_with((string)App\Core\Env::get('DB_NAME'),'_test'))throw new Exception('Test database required');
$u=App\Core\Database::queryOne('SELECT identifier,role,status,must_change_password,password_hash FROM users WHERE id=:id',['id'=>(int)$argv[2]]);
$password=stream_get_contents(STDIN);
echo json_encode(['identifier'=>$u['identifier'],'role'=>$u['role'],'status'=>$u['status'],'must_change_password'=>(int)$u['must_change_password'],'password_algorithm'=>password_get_info($u['password_hash'])['algoName'],'password_verifies'=>password_verify($password,$u['password_hash'])]);'''
account = json.loads(subprocess.check_output([PHP, '-r', account_probe, str(ROOT), str(primary['id'])], input=primary_password, text=True, cwd=ROOT))
check(account['identifier'].casefold() == 'student_test' and account['role'] == 'STUDENT' and account['status'] == 'ACTIVE', 'independent SQL confirms dedicated active student identity')
check(account['password_algorithm'] != 'unknown' and account['password_verifies'] and account['must_change_password'] == 0, 'independent SQL confirms hashed rotated password without exposing it')

# Real HTML login must ignore an injected administrator destination.
html_student = Client()
response = html_student.session.post(BASE + '/login.php?redirect=' + quote(SOC, safe=''), data={
    'login': 'student_test', 'password': primary_password, 'csrf_token': html_student.token}, timeout=25, allow_redirects=False)
check(response.status_code == 302 and unquote(response.headers.get('Location', '')).endswith('/index.php'), 'HTML student login ignores attempted SOC redirect')
html_admin = Client()
response = html_admin.session.post(BASE + '/login.php', data={
    'login': 'admin', 'password': CREDENTIALS['admin_password'], 'csrf_token': html_admin.token}, timeout=25, allow_redirects=False)
check(response.status_code == 302 and unquote(response.headers.get('Location', '')).endswith('/' + SOC), 'HTML administrator login routes directly to SOC')
response = student.page('login.php?redirect=' + quote(SOC, safe=''), 302)
check(unquote(response.headers.get('Location', '')).endswith('/index.php'), 'already authenticated student cannot inject SOC login destination')
response = admin.page('login.php?redirect=ML%20Workbench%2FDashboard.php', 302)
check(unquote(response.headers.get('Location', '')).endswith('/' + SOC), 'already authenticated administrator stays in SOC')

portal = student.page('index.php')
markup = Markup(portal.text)
launch = [link['href'] for link in markup.links if 'w-full py-2.5' in link.get('class', '')]
expected = ['AI Project Management/Dashboard.php', 'Data Center/dashboard.php', 'ML Workbench/Dashboard.php', 'Model Registry & Deployment/dashboard.php']
check(len(launch) == 4 and sorted(launch) == sorted(expected), 'student portal has exactly four authorized Dashboard launch controls')
check(not any(is_soc(value) for value in markup.interactive), 'student portal has no interactive SOC destination')
for path in expected:
    response = student.page(path)
    check(not any(is_soc(value) for value in Markup(response.text).interactive), 'student Dashboard has no SOC links: ' + path)
    admin.page(path, 403)
for path in ['Dashboard.php', 'StudentManagement.php', 'DatasetManagement.php', 'TicketsAndScenarios.php', 'ModelManagement.php', 'StudentWorkspaces.php']:
    student.page('AI Operations Center (AI SOC)/' + path, 403)
for path in ['_dashboard_panels.php', '_workspace_admin.php', '_ticket_management_modal.php']:
    student.page('AI Operations Center (AI SOC)/' + path, 403)
    admin.page('AI Operations Center (AI SOC)/' + path, 403)
for route in ['soc/overview', 'soc/students', 'soc/datasets', 'soc/tickets', 'soc/notebooks', 'soc/models', 'soc/submissions']:
    student.call('GET', route, statuses=(403,))

# Two users own independent work produced only through authenticated actions.
tag = secrets.token_hex(6).upper()
issued = secrets.token_urlsafe(32)
second = admin.call('POST', 'soc/students', {
    'identifier': 'IT-V10-OTHER-' + tag, 'full_name': 'V10 Isolation Test Student',
    'email': 'v10-other-' + tag.lower() + '@example.invalid', 'password': issued})
other = Client()
other.login(second['identifier'], issued)
second_password = secrets.token_urlsafe(32)
other.call('POST', 'auth/change-password', {'current_password': issued, 'new_password': second_password})
store_credentials({'role_other_student': {'id': int(second['id']), 'identifier': second['identifier'], 'password': second_password}})
records = []
for index, (user, client) in enumerate([(primary, student), (second, other)]):
    ticket = admin.call('POST', 'soc/tickets', {
        'ticket_code': 'IT-V10-ROLE-T-' + tag + '-' + str(index),
        'title': 'V10 authorized role work ' + str(index), 'student_id': int(user['id']),
        'requirements': 'Save original work and submit through the assigned account.',
        'acceptance_criteria': 'Actual owner, persisted source and administrator review.',
        'deadline': '2027-01-20 10:30:00'})
    tid = int(ticket['id'])
    dataset = admin.call('POST', 'soc/datasets', {
        'code': 'IT-V10-ROLE-D-' + tag + '-' + str(index), 'name': 'V10 role CSV ' + str(index)},
        files={'dataset_file': ('role.csv', b'feature,label\n1,0\n2,1\n', 'text/csv')})
    did = int(dataset['id'])
    detail = admin.call('GET', 'soc/datasets/' + str(did))
    vid = int(detail['dataset_version_id'])
    admin.call('POST', 'soc/datasets/' + str(did) + '/assign', {
        'student_id': int(user['id']), 'ticket_id': tid, 'dataset_version_id': vid})
    client.call('GET', 'project/tickets/' + str(tid))
    client.call('GET', 'data/datasets/' + str(did) + '/preview')
    notebook = client.call('POST', 'workbench/notebooks', {'title': 'V10 owner notebook ' + str(index), 'ticket_id': tid, 'cells': []})
    nid = int(notebook['id'])
    source = '# V10 owner persistence ' + tag + '\nanswer = 42\n'
    client.call('PATCH', 'workbench/notebooks/' + str(nid), {'expected_version': notebook['version'], 'cells': [{'cell_type': 'code', 'source': source}]})
    reloaded = client.call('GET', 'workbench/notebooks/' + str(nid))
    check(reloaded['cells'][0]['source'] == source, 'notebook source survives actual reload for its original owner')
    model = client.call('POST', 'registry/models', {'model_code': 'IT-V10-ROLE-M-' + tag + '-' + str(index), 'name': 'V10 model metadata ' + str(index), 'framework': 'Python', 'ticket_id': tid})
    mid = int(model['id'])
    check(not model.get('versions'), 'metadata registration fabricates no model artifact')
    submission = client.call('POST', 'project/submissions', {'ticket_id': tid, 'notebook_id': nid, 'model_id': mid, 'notes': 'V10 original authorized work', 'request_key': 'V10-ROLE-' + tag + '-' + str(index)})
    subid = int(submission['id'])
    admin.call('GET', 'soc/notebooks/' + str(nid))
    admin.call('GET', 'soc/models/' + str(mid))
    admin.call('POST', 'soc/submissions/' + str(subid) + '/request-changes', {'feedback': 'V10 actual reviewer decision'})
    check(client.call('GET', 'project/submissions/' + str(subid))['status'] == 'CHANGES_REQUESTED', 'student sees SOC review decision')
    check(client.call('GET', 'project/tickets/' + str(tid))['status'] == 'CHANGES_REQUESTED', 'SOC decision synchronizes ticket state')
    records.append({'student_id': int(user['id']), 'ticket_id': tid, 'dataset_id': did, 'dataset_version_id': vid, 'notebook_id': nid, 'model_id': mid, 'submission_id': subid})

for client, forbidden in [(student, records[1]), (other, records[0])]:
    for route in ['project/tickets/' + str(forbidden['ticket_id']), 'data/datasets/' + str(forbidden['dataset_id']), 'workbench/notebooks/' + str(forbidden['notebook_id']), 'registry/models/' + str(forbidden['model_id']), 'project/submissions/' + str(forbidden['submission_id'])]:
        client.call('GET', route, statuses=(403, 404))
    client.call('PATCH', 'workbench/notebooks/' + str(forbidden['notebook_id']), {'title': 'Forbidden cross-user edit'}, statuses=(403, 404))
    client.call('POST', 'project/submissions', {'ticket_id': forbidden['ticket_id'], 'notebook_id': forbidden['notebook_id'], 'model_id': forbidden['model_id']}, statuses=(403, 404, 422))

bad = student.session.post(BASE + '/api/v1/project/submissions', json={'ticket_id': records[0]['ticket_id']}, headers={'X-CSRF-Token': 'incorrect'}, timeout=25)
check(bad.status_code == 403, 'incorrect CSRF denied for student_test')
# Dedicated test-only session expiration helper; it cannot select the main instance.
session_id = student.session.cookies.get(GUARD['cookie'])
subprocess.run([PHP, str(ROOT / 'tests/integration_probe.php'), 'expire', session_id], cwd=ROOT, check=True, stdout=subprocess.DEVNULL)
student.call('GET', 'auth/me', statuses=(401,))
student = Client()
student.login('student_test', primary_password)
student.call('POST', 'auth/logout', {})
student.call('GET', 'auth/me', statuses=(401,))

out = ROOT / 'verification/v10-20261101'
out.mkdir(parents=True, exist_ok=True)
(out / 'role-boundaries.json').write_text(json.dumps({
    'database': GUARD['database'], 'environment': 'testing', 'assertions': PASSED,
    'student_login': 'student_test', 'canonical_identifier': primary['identifier'],
    'student_visible_systems': 4, 'admin_destination': SOC,
    'student_work': records, 'main_database_mutated': False,
    'account_SQL_proof': account,
    'credentials_logged_or_packaged': False, 'no_provider_execution_claimed': True
}, indent=2), encoding='utf-8')
print('PASS ALL ' + str(PASSED) + ' V10 actual role/workflow checks on ' + GUARD['database'] + '; private test credentials retained outside source/webroot.')
