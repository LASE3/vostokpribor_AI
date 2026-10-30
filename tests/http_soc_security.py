"""Adversarial real HTTP role tests for EVERY declared SOC management route.
Creates one random, explicit test-only student through a _test-guarded CLI helper.
Does not rotate administrator credentials, reset data, or delete any records.
"""
from pathlib import Path
from urllib.parse import urlparse
import json, os, secrets, subprocess
import requests

ROOT=Path(__file__).resolve().parents[1]
setup=json.loads(subprocess.check_output([os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe'),str(ROOT/'tests/soc_negative_setup.php')],cwd=ROOT,text=True))
base=setup['base_url'].rstrip('/')
assert urlparse(base).hostname in ('localhost','127.0.0.1','::1')
assert setup['database'].endswith('_test')
s=requests.Session();passed=0
def check(ok,label):
 global passed
 if not ok:raise AssertionError(label)
 passed+=1;print('PASS '+label,flush=True)
r=s.get(base+'/api/v1/auth/csrf',timeout=20)
check(r.status_code==200,'session CSRF acquired')
token=r.json()['data']['csrf_token']
s.headers['X-CSRF-Token']=token
r=s.post(base+'/api/v1/auth/login',json={'login':setup['identifier'],'password':setup['password']},timeout=20)
check(r.status_code==200,'random isolated security-test student authenticated through real HTTP')
s.headers['X-CSRF-Token']=r.json()['data']['csrf_token']
r=s.post(base+'/api/v1/auth/change-password',json={'current_password':setup['password'],'new_password':secrets.token_urlsafe(28)},timeout=20)
check(r.status_code==200,'only security-test student rotated its own initial credential')
s.headers['X-CSRF-Token']=r.json()['data']['csrf_token']
seen=set()
for route in setup['routes']:
 method=route['method'];path=route['path'].replace('{id}','1')
 if (method,path) in seen:continue
 seen.add((method,path))
 kwargs={'json':{'role':'ADMIN','student_id':setup['user_id'],'status':'APPROVED'}} if method not in ('GET','HEAD') else {}
 r=s.request(method,base+'/api/v1/'+path,timeout=20,**kwargs)
 check(r.status_code==403 and r.json().get('success') is False,method+' '+path+' rejects student with valid CSRF and forged ADMIN body')
for method,path in [('POST','users'),('PATCH','users/1'),('POST','tickets'),('POST','tickets/1/assignments'),('POST','scenarios'),('PATCH','scenarios/1'),('POST','submissions/1/review'),('PATCH','deployments/1')]:
 r=s.request(method,base+'/api/v1/'+path,json={'role':'ADMIN','status':'APPROVED'},timeout=20)
 check(r.status_code==403,method+' compatibility '+path+' cannot bypass SOC role policy')
for path in ['StudentWorkspaces.php','ModelManagement.php','ValidationReports.php','DeploymentRequests.php','StudentManagement.php','DatasetManagement.php','WorkspaceConfiguration.php','TicketsAndScenarios.php']:
 r=s.get(base+'/AI%20Operations%20Center%20(AI%20SOC)/'+path,timeout=20,allow_redirects=False)
 check(r.status_code==403,'SOC HTML '+path+' rejects student')
r=s.get(base+'/api/v1/workbench/execution-status',timeout=20)
check(r.status_code==200 and r.json()['data']['can_execute'] is False,'workbench execution status remains truthfully disabled')
r=s.post(base+'/api/v1/soc/students?next=auth/login',json={'role':'ADMIN'},headers={'X-CSRF-Token':'wrong'},timeout=20)
check(r.status_code==403,'query auth/login cannot exempt CSRF')
r=s.post(base+'/api/v1/workbench/notebooks',data='{broken',headers={'Content-Type':'application/json'},timeout=20)
check(r.status_code==400 and r.json()['success'] is False,'malformed JSON cannot reach a write handler')
r=s.post(base+'/api/v1/workbench/notebooks',json=[],timeout=20)
check(r.status_code==422 and r.json()['success'] is False,'top-level JSON arrays cannot reach a write handler')
print(f'{passed} adversarial HTTP checks passed across {len(seen)} declared SOC routes on {setup["database"]}; random test student id {setup["user_id"]}. No administrator credential/data reset.')
