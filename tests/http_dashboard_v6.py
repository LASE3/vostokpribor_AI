"""Canonical dashboard/runtime semantics on real isolated Apache; read operations plus login audits only."""
from pathlib import Path
from urllib.parse import urlsplit,unquote
import json,os,subprocess,requests
ROOT=Path(__file__).resolve().parents[1];PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
from http_test_target import preflight_cli_target, credential_file, credentials_for
_TARGET=preflight_cli_target(ROOT)
state=json.loads(subprocess.check_output([PHP,str(ROOT/'tests/integration_probe.php')],cwd=ROOT,text=True));assert state['environment']=='testing' and state['database'].endswith('_test')
BASE=state['app_url'].rstrip('/');assert urlsplit(BASE).hostname in ['localhost','127.0.0.1','::1']
private=credential_file(ROOT)
cred=credentials_for(private,state['database']);passed=0

def check(ok,label):
 global passed
 assert ok,label
 passed+=1;print('PASS '+label,flush=True)
def login(identifier,password):
 s=requests.Session();r=s.get(BASE+'/api/v1/auth/csrf',timeout=20);s.headers['X-CSRF-Token']=r.json()['data']['csrf_token'];r=s.post(BASE+'/api/v1/auth/login',json={'login':identifier,'password':password},timeout=20);check(r.status_code==200,'actual test account login');return s
def get(s,path):
 r=s.get(BASE+'/api/v1/'+path,timeout=20);check(r.status_code==200,'GET '+path+'200');check(r.json()['success'] is True,'truthful read envelope');return r.json()
a=login('admin',cred['admin_password']);o=get(a,'soc/overview')['data'];students=get(a,'soc/students?limit=1')['data'];active=get(a,'soc/students?status=ACTIVE&limit=1')['data']
check(o['students']['total']==students['total'] and o['students']['active']==active['total'],'aggregate total/active agree with independent filtered total even page limit1')
requests_data=get(a,'soc/deployment-requests')['data'];check(len(requests_data)>0,'actual persisted deployment request history exists')
for path in ['soc/deployments','registry/deployments','deployments']:
 result=get(a,path);check(result['data']==[] and result['availability']=={'status':'NOT_CONFIGURED','runtime_enabled':False},'runtime list does not present requests as endpoints: '+path)
check(o['models']['deployed']==0 and o['models']['deployment_availability']=='NOT_CONFIGURED','dashboard count represents verified runtime inventory only')
folder='/AI%20Operations%20Center%20(AI%20SOC)/';r=a.get(BASE+folder+'OperationsDashboard.php?bookmark=kept',allow_redirects=False,timeout=20)
check(r.status_code==308,'legacy bookmark permanent308');target=urlsplit(r.headers['Location']);check(unquote(target.path)==unquote(urlsplit(BASE+folder+'Dashboard.php').path) and target.query=='bookmark=kept' and 'C:' not in target.path,'redirect correct nested installation path/query without filesystem leak')
r=a.get(r.headers['Location'],timeout=20);check(r.status_code==200 and 'AI SOC Mission Control' in r.text,'authenticated legacy bookmark reaches canonical dashboard')
check('OperationsDashboard.php' not in r.text and 'Operations Telemetry' not in r.text,'canonical page has no duplicate navigation or legacy links')
check('Validation provider NOT_CONFIGURED' in r.text and 'Inference provider NOT_CONFIGURED' in r.text and ' experiments' in r.text,'all monitoring sections retained')
check(' recent / ' in r.text and 'active cadets' not in r.text,'recent student list no longer claims limited rows are all active cadets')
s=login(cred['student_identifier'],cred['student_password']);r=s.get(BASE+folder+'OperationsDashboard.php',timeout=20);check(r.status_code==403,'student old bookmark still denies canonical SOC')
r=s.get(BASE+'/api/v1/soc/deployments',timeout=20);check(r.status_code==403,'runtime endpoint retains SOC administrator gate')
check(get(s,'registry/deployments')['data']==[],'student runtime inventory also truthful')
r=s.get(BASE+'/api/models.php',timeout=20);check(r.status_code==200,'legacy model catalog retains authorized read contract')
legacy=r.json()['registered_models'];check(bool(legacy) and all(unquote(x['record_url']).startswith(unquote(urlsplit(BASE).path)+'/api/v1/models/') for x in legacy),'legacy model links remain in the current nested installation')
print(f'PASS ALL {passed} canonical dashboard/deployment HTTP checks; no work records created.')
