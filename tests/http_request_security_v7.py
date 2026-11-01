"""Real HTTP malformed request and resource-ID regression checks on a dedicated test installation."""
from pathlib import Path
from urllib.parse import urlparse
import json,os,secrets,subprocess
import requests
ROOT=Path(__file__).resolve().parents[1];PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
guard=json.loads(subprocess.check_output([PHP,str(ROOT/'tests/integration_probe.php')],cwd=ROOT,text=True))
BASE=guard['app_url'].rstrip('/')
assert guard['environment']=='testing' and guard['database'].endswith('_test') and urlparse(BASE).hostname in ('localhost','127.0.0.1','::1')
cred=json.loads(Path(os.environ.get('TEST_CREDENTIALS_FILE',str(Path.home()/'.codex/tmp/vostok-integration-20261030-credentials.json'))).read_text(encoding='utf-8'))[guard['database']]
passed=0
def check(ok,label):
 global passed
 if not ok:raise AssertionError(label)
 passed+=1;print('PASS '+label,flush=True)
def client(identifier,password):
 s=requests.Session();s.headers['X-CSRF-Token']=s.get(BASE+'/api/v1/auth/csrf',timeout=20).json()['data']['csrf_token']
 r=s.post(BASE+'/api/v1/auth/login',json={'login':identifier,'password':password},timeout=20);check(r.status_code==200,'existing test account authenticates')
 s.headers['X-CSRF-Token']=r.json()['data']['csrf_token'];return s
admin=client('admin',cred['admin_password']);student=client(cred['student_identifier'],cred['student_password']);anonymous=requests.Session()
for prefix in ['project/tickets','tickets','data/datasets','workbench/notebooks','notebooks','workbench/experiments','registry/models','models','project/submissions','registry/validations','soc/students','soc/scenarios','soc/datasets','soc/models']:
 for identifier in ['1junk','-1','0','2147483648','1%20OR%201=1']:
  r=admin.get(BASE+'/api/v1/'+prefix+'/'+identifier,timeout=20)
  check(r.status_code==422 and r.json()['error']['code']=='VALIDATION_ERROR','malformed ID rejected: '+prefix+'/'+identifier)
r=student.get(BASE+'/api/v1/soc/students/1junk',timeout=20);check(r.status_code==403,'SOC role authorization precedes malformed-ID validation')
r=anonymous.get(BASE+'/api/v1/workbench/notebooks/1junk',timeout=20);check(r.status_code==401,'anonymous malformed ID cannot skip authentication')
for payload,status in [(b'{',400),(b'[]',422),(b'"text"',422),(b'{"title":"\xff"}',400),(b'{"cells":'+b'['*80+b']'*80+b'}',400)]:
 r=student.post(BASE+'/api/v1/workbench/notebooks',data=payload,headers={'Content-Type':'application/json'},timeout=20)
 check(r.status_code==status and r.json()['success'] is False,'malformed JSON/type/depth rejected without server error')
r=student.post(BASE+'/api/v1/workbench/notebooks',data=json.dumps({'title':'V7 media-type proof '+secrets.token_hex(6)}),headers={'Content-Type':'APPLICATION/JSON; charset=UTF-8'},timeout=20)
check(r.status_code==201 and r.json()['data']['title'].startswith('V7 media-type proof '),'JSON media type is case insensitive with charset parameter')
r=student.post(BASE+'/api/v1/workbench/notebooks',data=json.dumps({'title':'Must not create a JSON-lookalike notebook'}),headers={'Content-Type':'application/jsonx'},timeout=20)
check(r.status_code==422,'lookalike application/jsonx is not interpreted as JSON')
tag=secrets.token_hex(6)
r=admin.post(BASE+'/api/v1/soc/datasets',data={'code':'IT-V7-INVALID-'+tag,'name':'Nested upload metadata is not a file'},files={'dataset_file[name]':('nested.csv',b'x,y\n1,2\n','text/csv')},timeout=20)
check(r.status_code==422,'nested multipart dataset file metadata rejected as field validation')
r=student.post(BASE+'/api/v1/registry/models',json={'model_code':'IT-V7-REQ-'+tag,'name':'V7 upload shape proof','framework':'JSON'},timeout=20)
check(r.status_code==201,'explicit isolated model metadata for upload-shape regression')
model_id=r.json()['data']['id']
r=student.post(BASE+f'/api/v1/registry/models/{model_id}/versions',data={'version':'v1'},files={'artifact_file[name]':('nested.json',b'{"opaque":true}','application/json')},timeout=20)
check(r.status_code==422,'nested multipart artifact metadata rejected as field validation')
r=student.get(BASE+f'/api/v1/registry/models/{model_id}/versions',timeout=20)
check(r.status_code==200 and r.json()['data']==[],'malformed multipart creates no artifact version')
for legacy in ['api/status.php','api/exchange.php','api/models.php']:
 for method in ['HEAD','POST','OPTIONS']:
  r=admin.request(method,BASE+'/'+legacy,json={} if method=='POST' else None,timeout=20)
  check(r.status_code==405 and r.headers.get('Allow')=='GET','legacy '+legacy+' rejects '+method+' with explicit method policy')
for method in ['PUT','DELETE']:
 r=student.request(method,BASE+'/api/v1/workbench/notebooks',json={},timeout=20)
 check(r.status_code==404,'unsupported '+method+' route cannot write')
r=admin.get(BASE+'/api/v1/execution-jobs/JOB-FFFFFFFFFFFF',timeout=20)
check(r.status_code==404 and r.json()['error']['code']=='NOT_FOUND','string execution-job identifiers retain normal lookup behavior')
r=admin.get(BASE+'/api/v1/soc/execution-jobs/JOB-FFFFFFFFFFFF',timeout=20)
check(r.status_code==404,'SOC string job identifiers retain normal lookup behavior')
print(f'PASS ALL {passed} V7 request security assertions; one deliberate notebook and model metadata saved only in the isolated test DB; malformed requests create no artifact version.')
