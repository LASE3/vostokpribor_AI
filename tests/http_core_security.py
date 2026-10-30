"""Real HTTP audit-failure/security regression on a dedicated local _test snapshot.
The only trigger failures target this suite's own random student ID and exact action.
Administrator credentials are read from the private supplied test credential file;
the administrator password is never changed. No existing user/work records reset.
"""
from pathlib import Path
from urllib.parse import urlparse
import json,os,re,secrets,subprocess,sys
import requests
ROOT=Path(__file__).resolve().parents[1]
PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
CREDENTIALS=Path(os.environ.get('TEST_CREDENTIALS_FILE',r'C:\Users\nijim\.codex\tmp\vostok-integration-20261030-credentials.json'))
KEY=os.environ.get('TEST_DATABASE_KEY','vostok_range_20261030_main_http_test')
BASE=os.environ.get('TEST_BASE_URL','http://127.0.0.1/vostokpribor_integration_main_20261030/vostokpribor_AI').rstrip('/')
assert urlparse(BASE).hostname in ('localhost','127.0.0.1','::1') and KEY.endswith('_test')
# Resolve this executed copy's actual environment before sending any mutation.
guardcode="require $argv[1]; echo json_encode(['environment'=>App\\Core\\Env::get('APP_ENV'),'database'=>App\\Core\\Env::get('DB_NAME'),'host'=>App\\Core\\Env::get('DB_HOST')]);"
guard=json.loads(subprocess.check_output([PHP,'-r',guardcode,str(ROOT/'app/bootstrap.php')],cwd=ROOT,text=True))
assert guard['environment']=='testing' and guard['database']==KEY and guard['host'] in ('localhost','127.0.0.1','::1'),guard
credential=json.loads(CREDENTIALS.read_text(encoding='utf-8'))[KEY]
passed=0
def check(ok,label):
 global passed
 if not ok:raise AssertionError(label)
 passed+=1;print('PASS '+label,flush=True)
def session():
 s=requests.Session();r=s.get(BASE+'/api/v1/auth/csrf',timeout=20);assert r.status_code==200
 s.headers['X-CSRF-Token']=r.json()['data']['csrf_token'];return s
def api(s,path,data):
 r=s.post(BASE+'/api/v1/'+path,json=data,timeout=20)
 if r.ok:
  d=r.json().get('data')
  if isinstance(d,dict) and d.get('csrf_token'):s.headers['X-CSRF-Token']=d['csrf_token']
 return r
admin=session();r=api(admin,'auth/login',{'login':'admin','password':credential['admin_password']})
check(r.status_code==200,'administrator authenticates with existing test credential; no rotation/reset')
identifier='CORESEC-'+secrets.token_hex(8).upper();password=secrets.token_urlsafe(28)
r=api(admin,'soc/students',{'full_name':'Core audit-failure regression','email':identifier.lower()+'@example.invalid','identifier':identifier,'password':password})
check(r.status_code==201,'created one explicit random security-test student through authenticated SOC API')
uid=int(r.json()['data']['id'])
def probe(mode,action=None):
 args=[PHP,str(ROOT/'tests/core_security_probe.php'),mode,str(uid)]
 if action:args.append(action)
 return json.loads(subprocess.check_output(args,cwd=ROOT,text=True))
active=set()
def trigger_on(action):
 result=probe('trigger-on',action);active.add(action);return result
def trigger_off(action):
 result=probe('trigger-off',action);active.discard(action);return result
try:
 baseline=probe('state');check(baseline['student']['last_login_at'] is None and baseline['login_audits']==0,'new test target starts without last-login/audit')
 installed=trigger_on('LOGIN_SUCCESS')
 check(installed['actor_id']==uid and installed['resource_id']==str(uid) and installed['action']=='LOGIN_SUCCESS','failure trigger scoped to exact own student/action/resource')
 anonymous=session()
 r=api(anonymous,'auth/login',{'login':identifier,'password':password})
 check(r.status_code==500 and r.json()['success'] is False,'API login reports audit-storage failure')
 check(anonymous.get(BASE+'/api/v1/auth/me',timeout=20).status_code==401,'audit-failed API login grants no authenticated session')
 after=probe('state');check(after['student']['last_login_at'] is None and after['login_audits']==0,'audit-failed API login rolls back last_login_at and audit')
 html=requests.Session();page=html.get(BASE+'/login.php',timeout=20)
 token=re.search(r'name="csrf_token"\s+value="([^"]+)"',page.text).group(1)
 r=html.post(BASE+'/login.php',data={'login':identifier,'password':password,'csrf_token':token},timeout=20,allow_redirects=False)
 check(r.status_code==500,'HTML login also reports scoped audit failure')
 check(html.get(BASE+'/api/v1/auth/me',timeout=20).status_code==401,'audit-failed HTML login grants no authenticated session')
 check(probe('state')['student']['last_login_at'] is None,'HTML failure also preserves rollback of last_login_at')
 trigger_off('LOGIN_SUCCESS')
 student=session();r=api(student,'auth/login',{'login':identifier,'password':password})
 check(r.status_code==200,'removing only own login-failure trigger restores ordinary login')
 newpassword=secrets.token_urlsafe(28)
 r=api(student,'auth/change-password',{'current_password':password,'new_password':newpassword})
 check(r.status_code==200,'security-test student rotates only its own initial credential')
 long_path='/api/v1/soc/overview?core_probe='+identifier+'-'+'x'*500
 r=student.get(BASE+long_path,timeout=20)
 check(r.status_code==403,'long SOC denial URI remains403 instead of audit-column failure')
 denied=probe('state')['last_denied'];expected_uri=urlparse(BASE).path+long_path
 check(denied is not None and denied['resource_id']==expected_uri[:64] and len(denied['resource_id'])==64,'audit resource_id deliberately bounded to schema64 characters')
 check(denied['metadata']['resource_id_full']==expected_uri,'full denied URI retained accurately in audit metadata')
 trigger_on('LOGOUT')
 r=api(student,'auth/logout',{})
 check(r.status_code==500 and r.json()['success'] is False,'API logout reports expected scoped audit-storage failure')
 check(student.get(BASE+'/api/v1/auth/me',timeout=20).status_code==401,'API logout still clears session despite audit failure')
 check(probe('state')['logout_audits']==0,'failed logout audit was not falsely recorded as successful')
 html=session();r=api(html,'auth/login',{'login':identifier,'password':newpassword})
 check(r.status_code==200,'exact logout-only trigger does not affect valid login')
 r=html.post(BASE+'/logout.php',data={'csrf_token':html.headers['X-CSRF-Token']},timeout=20,allow_redirects=False)
 check(r.status_code==500,'HTML logout reports expected scoped audit-storage failure')
 check(html.get(BASE+'/api/v1/auth/me',timeout=20).status_code==401,'HTML logout still clears session despite audit failure')
 trigger_off('LOGOUT')
 # None of the injected failures can block or revoke the separate administrator.
 check(admin.get(BASE+'/api/v1/soc/overview',timeout=20).status_code==200,'independent administrator session unaffected by resource-scoped failures')
 check(not active,'all exact own failure triggers removed')
 print(f'{passed} core HTTP security checks passed on {KEY}; explicit security student id {uid}. No main/local environment, original record or administrator password modified.')
finally:
 for action in tuple(active):
  try:trigger_off(action)
  except Exception as e:print('CLEANUP FAILURE for own '+action+' trigger: '+str(e),file=sys.stderr)
