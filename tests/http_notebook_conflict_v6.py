"""Guarded real HTML fallback regression; no deliberate failed login/throttle."""
from pathlib import Path
from urllib.parse import urlparse
import html,json,os,re,secrets,subprocess
import requests
ROOT=Path(__file__).resolve().parents[1];PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
from http_test_target import preflight_cli_target, credential_file, credentials_for
_TARGET=preflight_cli_target(ROOT)
guard=json.loads(subprocess.check_output([PHP,str(ROOT/'tests/backend_security_probe.php'),'environment'],cwd=ROOT,text=True))
BASE=guard['base_url'].rstrip('/');assert guard['environment']=='testing' and guard['database'].endswith('_test') and urlparse(BASE).hostname in ('localhost','127.0.0.1','::1')
credential=credentials_for(credential_file(ROOT),guard['database'])
passed=0
def check(ok,label):
 global passed
 if not ok:raise AssertionError(label)
 passed+=1;print('PASS '+label,flush=True)
def session():
 s=requests.Session();r=s.get(BASE+'/api/v1/auth/csrf',timeout=20);assert r.ok;s.headers['X-CSRF-Token']=r.json()['data']['csrf_token'];return s
def api(s,method,path,payload=None,status=200):
 r=s.request(method,BASE+'/api/v1/'+path,json=payload,timeout=20);check(r.status_code==status,method+' '+path+' HTTP '+str(status));d=r.json().get('data')
 if isinstance(d,dict) and d.get('csrf_token'):s.headers['X-CSRF-Token']=d['csrf_token']
 return d
admin=session();api(admin,'POST','auth/login',{'login':'admin','password':credential['admin_password']})
tag='V6-HTTP-'+secrets.token_hex(6).upper();password=secrets.token_urlsafe(30)
student=api(admin,'POST','soc/students',{'identifier':tag,'full_name':'HTML conflict regression','email':tag.lower()+'@example.invalid','password':password},201)
s=session();api(s,'POST','auth/login',{'login':tag,'password':password});api(s,'POST','auth/change-password',{'current_password':password,'new_password':secrets.token_urlsafe(32)})
book=api(s,'POST','workbench/notebooks',{'title':'HTML conflict private notebook','cells':[{'cell_type':'code','source':'original'}]},201);nid=int(book['id']);version=int(book['version'])
api(s,'PATCH',f'workbench/notebooks/{nid}',{'cells':[{'cell_type':'code','source':'first editor committed'}],'expected_version':version})
marker='</textarea><script>window.v6DraftProbe=1</script>\nprint("unsaved literal source")'
url=BASE+f'/ML%20Workbench/NotebookWorkbench.php?id={nid}'
r=s.post(url,data={'action':'save_notebook','notebook_id':nid,'expected_version':version,'csrf_token':s.headers['X-CSRF-Token'],'source[]':marker,'cell_type[]':'code'},timeout=20,allow_redirects=False)
check(r.status_code==409,'HTML fallback returns409 for stale notebook form')
check(html.escape(marker,quote=True).replace('&#x27;','&#039;') in r.text,'HTML conflict preserves escaped submitted source including closing textarea/script marker')
check('<script>window.v6DraftProbe=1</script>' not in r.text,'malicious-looking notebook code remains inert text')
check(re.search(r'name="expected_version"\s+value="'+str(version)+'"',r.text) is not None,'HTML conflict retains stale submitted token rather than silently adopting newer version')
check('Your entered code is preserved' in r.text,'HTML conflict explains copy/reload recovery')
saved=api(s,'GET',f'workbench/notebooks/{nid}');check(saved['cells'][0]['source']=='first editor committed' and int(saved['version'])==version+1,'stale HTML POST leaves persisted source/version unchanged')
r=s.get(url,timeout=20);check(r.status_code==200 and 'first editor committed' in r.text,'explicit GET reload shows actual current source')
check(re.search(r'name="expected_version"\s+value="'+str(version+1)+'"',r.text) is not None,'explicit reload receives current version token')
print(f'{passed} HTML notebook conflict checks passed on {guard["database"]}; unique student{student["id"]}/notebook{nid}, no existing work reset.')
