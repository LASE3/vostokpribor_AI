"""Real HTTP validation/throttle regressions; only new V6 work on guarded _test DB.
No generic write retry: a rejected429 is checked for zero effect and explicitly
repeated only after this suite's own seeded bucket reaches its reset timestamp.
"""
from pathlib import Path
from urllib.parse import urlparse
import json,os,secrets,subprocess
import requests
from requests.adapters import HTTPAdapter

ROOT=Path(__file__).resolve().parents[1]
PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
def probe(mode='environment',uid=None,kind=None):
 args=[PHP,str(ROOT/'tests/backend_security_probe.php'),mode]
 if uid is not None:args.append(str(uid))
 if kind is not None:args.append(kind)
 return json.loads(subprocess.check_output(args,cwd=ROOT,text=True))
guard=probe();BASE=guard['base_url'].rstrip('/')
assert guard['environment']=='testing' and guard['database'].endswith('_test') and guard['host'] in ('127.0.0.1','localhost','::1')
assert urlparse(BASE).hostname in ('127.0.0.1','localhost','::1')
credential=json.loads(Path(os.environ.get('TEST_CREDENTIALS_FILE',r'C:\Users\nijim\.codex\tmp\vostok-integration-20261030-credentials.json')).read_text(encoding='utf-8'))[guard['database']]
passed=0
def check(ok,label):
 global passed
 if not ok:raise AssertionError(label)
 passed+=1;print('PASS '+label,flush=True)
def api(s,method,path,data=None,status=200,**kwargs):
 r=s.request(method,BASE+'/api/v1/'+path,json=data,timeout=25,**kwargs)
 check(r.status_code==status,f'{method} {path} HTTP {status}')
 body=r.json();check(body['success']==(status<400),'truthful response envelope')
 if status<400 and isinstance(body.get('data'),dict) and body['data'].get('csrf_token'):s.headers['X-CSRF-Token']=body['data']['csrf_token']
 return r
def session(source=None):
 s=requests.Session()
 if source:
  class SourceAdapter(HTTPAdapter):
   def init_poolmanager(self,*args,**kwargs):kwargs['source_address']=(source,0);return super().init_poolmanager(*args,**kwargs)
  s.mount('http://',SourceAdapter())
 r=s.get(BASE+'/api/v1/auth/csrf',timeout=20);assert r.status_code==200
 s.headers['X-CSRF-Token']=r.json()['data']['csrf_token'];return s
admin=session();api(admin,'POST','auth/login',{'login':'admin','password':credential['admin_password']})
tag='V6-HTTP-'+secrets.token_hex(6).upper();initial=''.join(secrets.choice('0123456789') for _ in range(24))
created=api(admin,'POST','soc/students',{'identifier':tag,'full_name':'987654321','email':tag.lower()+'@example.invalid','password':initial},201).json()['data'];uid=int(created['id'])
check(created['full_name']=='987654321','numeric-looking profile text uses string length rather than numeric max')
ticket=api(admin,'POST','soc/tickets',{'ticket_code':tag,'title':'123456789','student_id':uid},201).json()['data'];tid=int(ticket['id'])
for field in ['full_name','email','status']:
 api(admin,'PATCH',f'soc/students/{uid}',{field:None},422)
for field in ['title','priority']:
 api(admin,'PATCH',f'soc/tickets/{tid}',{field:None},422)
check(api(admin,'GET',f'soc/students/{uid}').json()['data']['profile']['full_name']=='987654321','rejected null profile update preserves original name')
check(api(admin,'GET',f'soc/tickets/{tid}').json()['data']['title']=='123456789','rejected null ticket update preserves original title')
scenario=api(admin,'POST','soc/scenarios',{'code':tag,'title':'Two editor HTTP scenario'},201).json()['data'];scid=int(scenario['id']);revision=scenario['revision']
updated=api(admin,'PATCH',f'soc/scenarios/{scid}',{'description':'First saved description','expected_revision':revision}).json()['data']
r=api(admin,'PATCH',f'soc/scenarios/{scid}',{'title':'Stale overwrite','expected_revision':revision},409);check(r.json()['error']['code']=='CONFLICT','stale scenario has explicit409 conflict code')
observed=api(admin,'GET',f'soc/scenarios/{scid}').json()['data'];check(observed['title']==scenario['title'] and observed['description']=='First saved description' and observed['revision']==updated['revision'],'stale scenario request preserves first editor persisted fields')
api(admin,'POST',f'soc/scenarios/{scid}/archive',{'expected_revision':revision},409)
for path in ['soc/students?search[]=bad','soc/students?status[]=ACTIVE','soc/students?cohort[]=bad','soc/students?limit[]=2','soc/students?offset=-1','soc/tickets?search[]=bad','soc/tickets?status[]=ASSIGNED','soc/tickets?scenario_id[]=1','soc/scenarios?status[]=DRAFT','registry/models?status[]=REGISTERED']:
 api(admin,'GET',path,status=422)
for path in ["soc/students?search=%27%20OR%201%3D1--","soc/tickets?search=%27%20OR%201%3D1--"]:
 data=api(admin,'GET',path).json()['data'];check((data.get('items',[]) if isinstance(data,dict) else data)==[],'injection-looking search remains a bound search value')
student=session();api(student,'POST','auth/login',{'login':tag,'password':initial});rotated=secrets.token_urlsafe(32);api(student,'POST','auth/change-password',{'current_password':initial,'new_password':rotated})
for path,payload in [('workbench/notebooks',{'title':['bad']}),('workbench/notebooks',{'title':'Bad reference','ticket_id':[tid]}),('workbench/experiments',{'name':'Bad reference','ticket_id':[tid]}),('registry/models',{'model_code':tag+'M','name':['bad'],'framework':'JSON'}),('registry/models',{'model_code':tag+'M','name':'Model','framework':'JSON','ticket_id':[tid]}),('registry/validations',{'model_id':[1],'model_version_id':[1]}),('auth/change-password',{'current_password':[],'new_password':'x'})]:
 api(student,'POST',path,payload,422)
for path in ['workbench/notebooks/2147483647','registry/models/2147483647','registry/validations/2147483647','execution-jobs/JOB-V6-ABSENT']:
 api(student,'GET',path,status=404)
api(student,'POST','execution-jobs/JOB-V6-ABSENT/cancel',{},404)
api(student,'POST','execution-jobs',{'notebook_id':2147483647,'code_to_execute':'print(1)'},404)
api(student,'PATCH','workbench/notebooks/2147483647',{'cells':[]},404)
before=probe('state',uid);probe('prime',uid,'mutation')
r=api(student,'POST','workbench/notebooks',{'title':'Must not be created when throttled','ticket_id':tid},429)
check(int(r.headers.get('Retry-After','0'))>0 and r.json()['error']['details']['retry_after']>0,'mutation429 includes positive Retry-After header and JSON detail')
check(probe('state',uid)['notebooks']==before['notebooks'],'rejected mutation creates no notebook')
r=student.post(BASE+'/ML%20Workbench/NotebookWorkbench.php',data={'action':'create_notebook','title':'Rejected HTML quota','csrf_token':student.headers['X-CSRF-Token']},timeout=25)
check(r.status_code==429 and int(r.headers.get('Retry-After','0'))>0 and 'No changes were made' in r.text,'HTML mutation shares API admission bucket and truthful429')
check(probe('state',uid)['notebooks']==before['notebooks'],'HTML quota bypass creates no notebook')
api(student,'GET','workbench/notebooks')
probe('expire',uid,'mutation');saved=api(student,'POST','workbench/notebooks',{'title':'Admission recovered','ticket_id':tid,'cells':[{'cell_type':'code','source':'# retained literal code'}]},201).json()['data'];check(len(saved['cells'])==1,'expired own bucket admits one explicit notebook create')
nid=int(saved['id']);version=int(saved['version']);api(student,'PATCH',f'workbench/notebooks/{nid}',{'cells':[{'cell_type':'code','source':'# first editor retained'}],'expected_version':str(version)})
r=api(student,'PATCH',f'workbench/notebooks/{nid}',{'cells':[{'cell_type':'code','source':'# stale code'}],'expected_version':version},409);check(r.json()['error']['code']=='CONFLICT','stale notebook has explicit409 conflict code')
observed=api(student,'GET',f'workbench/notebooks/{nid}').json()['data'];check(observed['cells'][0]['source']=='# first editor retained' and int(observed['version'])==version+1,'stale notebook request preserves committed source and version')
probe('prime',uid,'upload')
r=student.post(BASE+'/api/v1/data/processed',data={'source_dataset_id':'2147483647','ticket_id':str(tid)},files={'processed_file':('real-test.csv',b'x,y\n1,2\n','text/csv')},timeout=25)
check(r.status_code==429 and r.json()['error']['code']=='RATE_LIMITED' and int(r.headers.get('Retry-After','0'))>0,'excessive multipart uploads are rejected429 before handling file')
check(probe('state',uid)['processed']==before['processed'],'upload throttle creates no processed metadata')
r=student.post(BASE+'/Data%20Center/UploadProcessedData.php',data={'source_dataset_id':'2147483647','ticket_id':str(tid),'csrf_token':student.headers['X-CSRF-Token']},files={'processed_file':('real-test.csv',b'x,y\n1,2\n','text/csv')},timeout=25)
check(r.status_code==429 and int(r.headers.get('Retry-After','0'))>0,'HTML upload shares API upload bucket and cannot bypass429')
check(probe('state',uid)['processed']==before['processed'],'HTML upload rejection preserves metadata count')
probe('expire',uid,'upload')
check(api(student,'GET','workbench/execution-status').json()['data']['can_execute'] is False,'security fixes retain disabled execution')
probe('prime',uid,'mutation');api(student,'POST','auth/logout',{})
api(student,'GET','auth/me',status=401)
again=session();api(again,'POST','auth/login',{'login':tag,'password':rotated});probe('prime',uid,'mutation')
r=again.post(BASE+'/logout.php',data={'csrf_token':again.headers['X-CSRF-Token']},allow_redirects=False,timeout=25)
check(r.status_code==302 and '/login.php' in r.headers.get('Location',''),'HTML logout remains available when mutation quota exhausted')
api(again,'GET','auth/me',status=401)
# The private Apache mount permits only the ordinary loopback source. These
# final checks deliberately exhaust its real login bucket; let Retry-After
# expire naturally before starting another login-based suite. No bucket reset.
if os.environ.get('V6_SKIP_LOGIN_THROTTLE')!='1':
 login_source=None
 for _ in range(5):
  anonymous=session(login_source);api(anonymous,'POST','auth/login',{'login':'UNKNOWN-'+tag,'password':secrets.token_urlsafe(24)},401)
 anonymous=session(login_source);r=api(anonymous,'POST','auth/login',{'login':'UNKNOWN-'+tag,'password':secrets.token_urlsafe(24)},429)
 check(int(r.headers.get('Retry-After','0'))>0,'failed-login429 exposes bounded retry delay')
 html=session(login_source);page=html.get(BASE+'/login.php',timeout=25)
 import re
 token=re.search(r'name="csrf_token"\s+value="([^"]+)"',page.text).group(1)
 r=html.post(BASE+'/login.php',data={'login':'UNKNOWN-'+tag,'password':secrets.token_urlsafe(24),'csrf_token':token},timeout=25)
 check(r.status_code==429 and int(r.headers.get('Retry-After','0'))>0,'HTML login shares API failed-login admission bucket and429')
 print('OBSERVED login Retry-After '+r.headers['Retry-After']+' seconds; no rate bucket reset.',flush=True)
print(f'PASS ALL {passed} V6 backend HTTP assertions on {guard["database"]}; only unique student{uid}/ticket{tid} work and own rate buckets changed.')
