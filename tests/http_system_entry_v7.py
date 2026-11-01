"""Role-specific system entry links/directories resolve to dashboards on isolated Apache.
V10: student portal exposes four systems; administrator enters SOC only.
"""
from html.parser import HTMLParser
from pathlib import Path
from urllib.parse import quote,urljoin,urlparse,unquote
import json,os,subprocess
import requests
ROOT=Path(__file__).resolve().parents[1];PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
from http_test_target import preflight_cli_target, credential_file, credentials_for
_TARGET=preflight_cli_target(ROOT)
guard=json.loads(subprocess.check_output([PHP,str(ROOT/'tests/integration_probe.php')],cwd=ROOT,text=True));BASE=guard['app_url'].rstrip('/')
assert guard['environment']=='testing' and guard['database'].endswith('_test') and urlparse(BASE).hostname in ('localhost','127.0.0.1','::1')
cred=credentials_for(credential_file(ROOT),guard['database'])
passed=0;observed=[]
def check(ok,label):
 global passed
 assert ok,label
 passed+=1;print('PASS '+label,flush=True)
class Markup(HTMLParser):
 def __init__(self,text):self.links=[];self.resources=[];super().__init__();self.feed(text)
 def handle_starttag(self,tag,attrs):
  values=dict(attrs)
  if tag=='a':self.links.append(values)
  if tag in ('script','link','img'):
   value=values.get('src') or (values.get('href') if values.get('rel')=='stylesheet' else None)
   if value:self.resources.append(value)
def login(identifier,password):
 client=requests.Session();client.headers['X-CSRF-Token']=client.get(BASE+'/api/v1/auth/csrf',timeout=20).json()['data']['csrf_token']
 r=client.post(BASE+'/api/v1/auth/login',json={'login':identifier,'password':password},timeout=20);check(r.status_code==200,'isolated account authenticated');return client
role_student=cred.get('role_student_test',{})
student_identifier=cred.get('student_identifier') or role_student.get('identifier')
student_password=cred.get('student_password') or role_student.get('password')
if not student_identifier or not student_password:raise SystemExit('REFUSED: create a guarded test student and private credentials first.')
admin=login('admin',cred['admin_password']);student=login(student_identifier,student_password)
systems=[('AI Project Management','Dashboard.php','Project Management'),('Data Center','dashboard.php','Data Center'),('ML Workbench','Dashboard.php','ML Workbench Dashboard'),('Model Registry & Deployment','dashboard.php','Model Registry'),('AI Operations Center (AI SOC)','Dashboard.php','Dashboard')]
admin_portal=admin.get(BASE+'/index.php',timeout=20,allow_redirects=False)
check(admin_portal.status_code==302 and unquote(admin_portal.headers.get('Location','')).endswith('/AI Operations Center (AI SOC)/Dashboard.php'),'administrator root routes directly to SOC Dashboard')
portal=student.get(BASE+'/index.php',timeout=20);check(portal.status_code==200,'student portal remains available');markup=Markup(portal.text)
launch=[link['href'] for link in markup.links if 'w-full py-2.5' in link.get('class','')]
check(len(launch)==4,'student portal has exactly four system launch controls')
check(not any('AI Operations Center (AI SOC)' in unquote(link.get('href','')) for link in markup.links),'student portal has no SOC destination')
for folder,dashboard,title in systems:
 expected=folder+'/'+dashboard
 is_soc='AI SOC' in folder;client=admin if is_soc else student
 if not is_soc:check(expected in launch,'student system launch opens '+expected)
 for target in [expected,folder+'/']:
  r=client.get(BASE+'/'+quote(target,safe='/'),timeout=20);check(r.status_code==200,'authorized role Dashboard entry '+target)
  page=Markup(r.text);current=[a for a in page.links if a.get('aria-current')=='page']
  check(len(current)==1 and current[0].get('href','').lower()=='dashboard.php','Dashboard is selected on entry '+target)
  for resource in page.resources:
   url=urljoin(r.url,resource)
   if urlparse(url).netloc==urlparse(BASE).netloc:
    asset=client.get(url,timeout=20);check(asset.status_code==200,'local dashboard resource exists '+urlparse(url).path.rsplit('/',1)[-1])
  observed.append({'system':folder,'entry':target,'status':r.status_code,'selected_page':'Dashboard'})
 forbidden=student if is_soc else admin
 r=forbidden.get(BASE+'/'+quote(folder+'/',safe='/'),timeout=20,allow_redirects=False)
 check(r.status_code==403,'other role is denied directory entry '+folder)
for path in ['project/dashboard','data/datasets','workbench/notebooks','registry/models','soc/scenarios']:
 r=admin.get(BASE+'/api/v1/'+path,timeout=20);check(r.status_code==200 and r.json()['success'] is True,'each system API responds without404 '+path)
out=ROOT/'verification/v10-20261101';out.mkdir(parents=True,exist_ok=True);(out/'system-dashboard-entries.json').write_text(json.dumps({'database':guard['database'],'assertions':passed,'entries':observed,'work_records_modified':False},indent=2),encoding='utf-8')
print(f'PASS ALL {passed} system entry/resource/API checks; four student systems and administrator SOC open Dashboard for the correct role; no work records created.')
