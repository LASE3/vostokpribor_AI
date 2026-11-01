"""Real HTTP heavy-read admission, with only one new random _test student bucket primed."""
from pathlib import Path
from urllib.parse import urlparse
import json,os,secrets,subprocess,requests
ROOT=Path(__file__).resolve().parents[1]
PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
PROBE=ROOT/'tests/security_read_probe.php'
def probe(mode,uid=None):
 args=[PHP,str(PROBE),mode]
 if uid is not None:args.append(str(uid))
 return json.loads(subprocess.check_output(args,cwd=ROOT,text=True))
state=probe('environment')
assert state['environment']=='testing' and state['database'].endswith('_test') and state['host'] in ('127.0.0.1','localhost','::1')
BASE=state['base_url'].rstrip('/')
assert urlparse(BASE).hostname in ('127.0.0.1','localhost','::1')
private=Path(os.environ.get('TEST_CREDENTIALS_FILE',str(Path.home()/'.codex/tmp/vostok-integration-20261030-credentials.json')))
credential=json.loads(private.read_text())[state['database']]
passed=0
def check(ok,label):
 global passed
 if not ok:raise AssertionError(label)
 passed+=1;print('PASS '+label,flush=True)
def session():
 s=requests.Session();r=s.get(BASE+'/api/v1/auth/csrf',timeout=20);assert r.status_code==200;s.headers['X-CSRF-Token']=r.json()['data']['csrf_token'];return s
def post(s,path,payload):
 r=s.post(BASE+'/api/v1/'+path,json=payload,timeout=20)
 if r.ok and isinstance(r.json().get('data'),dict) and r.json()['data'].get('csrf_token'):s.headers['X-CSRF-Token']=r.json()['data']['csrf_token']
 return r
admin=session();r=post(admin,'auth/login',{'login':'admin','password':credential['admin_password']});check(r.status_code==200,'administrator authenticates with unchanged private test credential')
identifier='V7-READ-'+secrets.token_hex(8).upper();password=secrets.token_urlsafe(28)
r=post(admin,'soc/students',{'full_name':'Heavy-read admission regression','identifier':identifier,'email':identifier.lower()+'@example.invalid','password':password});check(r.status_code==201,'one explicit random test student is stored through SOC API');uid=int(r.json()['data']['id'])
student=session();r=post(student,'auth/login',{'login':identifier,'password':password});check(r.status_code==200,'own test student authenticates')
r=post(student,'auth/change-password',{'current_password':password,'new_password':secrets.token_urlsafe(28)});check(r.status_code==200,'own test student rotates password through API')
initial=probe('state',uid);check(initial['bucket'] is None,'ordinary auth and rotation create no expensive-read quota row')
primed=probe('prime',uid);check(primed['student_id']==uid and primed['bucket']['hits']==primed['limit']-1,'only own random test student bucket primed one admission below limit')
r=student.get(BASE+'/api/v1/registry/models',timeout=20);check(r.status_code==200 and r.json()['data']==[],'canonical model catalog consumes final admission and returns only actual empty records')
full=probe('state',uid);check(full['bucket']['hits']==full['limit'],'admission atomically stops at configured limit')
r=student.get(BASE+'/api/models.php',timeout=20);check(r.status_code==429 and r.json()['error']['code']=='RATE_LIMITED','legacy model catalog shares same user quota and returns JSON429');check(1<=int(r.headers.get('Retry-After','0'))<=60,'API429 provides bounded Retry-After')
for path in ['API/models.php','api//models.php','api/v1//registry/models']:
 r=student.get(BASE+'/'+path,timeout=20);check(r.status_code==429 and r.json()['error']['code']=='RATE_LIMITED','Apache normalized alias shares quota and JSON429: '+path)
r=student.get(BASE+'/Model%20Registry%20%26%20Deployment/ModelRegistry.php',timeout=20);check(r.status_code==429 and 'Too many requests.' in r.text,'HTML model catalog shares quota and returns explanatory429');check(1<=int(r.headers.get('Retry-After','0'))<=60,'HTML429 provides Retry-After')
r=student.get(BASE+'/api/v1/auth/me',timeout=20);check(r.status_code==200 and int(r.json()['data']['id'])==uid,'session recovery read remains available while expensive reads are exhausted')
r=student.get(BASE+'/api/v1/auth/csrf',timeout=20);check(r.status_code==200,'CSRF recovery remains available')
r=student.head(BASE+'/api/v1/registry/models',timeout=20);check(r.status_code==404,'HEAD never invokes registered GET catalog handler')
r=student.options(BASE+'/api/v1/registry/models',timeout=20);check(r.status_code==404,'OPTIONS never invokes registered GET catalog handler')
after=probe('state',uid);check(after['bucket']==full['bucket'],'rejected reads/auth recovery/HEAD/OPTIONS do not increase exhausted bucket')
check(after['work_counts']==initial['work_counts'],'read admission and rejections create no work/audit/notification records')
probe('expire',uid)
r=student.get(BASE+'/api/models.php',timeout=20);check(r.status_code==200 and r.json()['total_models']==0,'expiring only own test bucket restores legacy model catalog')
restored=probe('state',uid);check(restored['bucket']['hits']==1,'expired own bucket resets to one genuine read')
check(restored['work_counts']==initial['work_counts'],'post-expiry read also preserves all own work/audit/notification counts')
print('PASS '+str(passed)+' heavy-read HTTP/independent-DB checks on '+state['database']+'; new test student'+str(uid)+' retained, no existing user quota or work reset.')
