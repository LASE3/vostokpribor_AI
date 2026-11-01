"""Read-only/denied HTTP checks; never authenticates or mutates work data."""
from pathlib import Path
import json,os,secrets,subprocess
import requests
from http_test_target import guarded_target, initialize_session
ROOT=Path(__file__).resolve().parents[1]
probe=json.loads(subprocess.check_output([os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe'),str(ROOT/'tests/db_probe.php')],cwd=ROOT,text=True))
BASE=guarded_target(probe)
DENIED_PASSWORD=secrets.token_urlsafe(24)
s=requests.Session();initialize_session(s,BASE,probe);passed=0
def check(r,status,label):
    global passed
    assert r.status_code==status,(label,r.status_code,r.text[:120]);passed+=1;print('PASS',label,'HTTP',status,flush=True)
for path in ['.env','.git/config','database/vostokpribor_ai.sql','db/schema.sql','bin/migrate.php','bin/install_fresh.php','workers/python_worker.py','tests/database_security.php','app/Core/Auth.php','storage/private/datasets/test.csv']:
    check(s.get(BASE+'/'+path,timeout=20),403,'private '+path)
for path in ['api/models.php','api/exchange.php','api/status.php','api/v1/admin/overview']:
    check(s.get(BASE+'/'+path,timeout=20),401,'unauthenticated '+path)
check(s.post(BASE+'/api/v1/auth/login?next=auth/login',json={'login':'admin','password':DENIED_PASSWORD},timeout=20),403,'login query cannot exempt CSRF')
check(s.post(BASE+'/login.php',data={'login':'admin','password':DENIED_PASSWORD},timeout=20),403,'HTML login requires CSRF')
for token in [[],{},1,True,'wrong']:
    check(s.post(BASE+'/api/v1/auth/login',json={'login':'admin','password':DENIED_PASSWORD,'csrf_token':token},timeout=20),403,'malformed or incorrect CSRF '+type(token).__name__)
r=s.get(BASE+'/login.php',timeout=20);check(r,200,'HTML login page');assert 'name="csrf_token"' in r.text and 'name="csrf-token"' in r.text
r=s.get(BASE+'/api/v1/auth/csrf',timeout=20);check(r,200,'session-bound public CSRF token');s.headers['X-CSRF-Token']=r.json()['data']['csrf_token']
check(s.post(BASE+'/api/v1/auth/register',json={},timeout=20),404,'no public registration route')
print(f'PASS {passed} read-only/denied XAMPP security checks; no valid login attempted.')
