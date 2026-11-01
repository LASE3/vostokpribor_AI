"""All five system entry links/directories resolve to authenticated dashboards on the isolated installation."""
from html.parser import HTMLParser
from pathlib import Path
from urllib.parse import quote,urljoin,urlparse
import json,os,subprocess
import requests
ROOT=Path(__file__).resolve().parents[1];PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
guard=json.loads(subprocess.check_output([PHP,str(ROOT/'tests/integration_probe.php')],cwd=ROOT,text=True));BASE=guard['app_url'].rstrip('/')
assert guard['environment']=='testing' and guard['database'].endswith('_test') and urlparse(BASE).hostname in ('localhost','127.0.0.1','::1')
cred=json.loads(Path(os.environ.get('TEST_CREDENTIALS_FILE',str(Path.home()/'.codex/tmp/vostok-integration-20261030-credentials.json'))).read_text(encoding='utf-8'))[guard['database']]
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
admin=login('admin',cred['admin_password']);student=login(cred['student_identifier'],cred['student_password'])
systems=[('AI Project Management','Dashboard.php','Project Management'),('Data Center','dashboard.php','Data Center'),('ML Workbench','Dashboard.php','ML Workbench Dashboard'),('Model Registry & Deployment','dashboard.php','Model Registry'),('AI Operations Center (AI SOC)','Dashboard.php','Dashboard')]
portal=admin.get(BASE+'/index.php',timeout=20);markup=Markup(portal.text)
launch=[link['href'] for link in markup.links if 'w-full py-2.5' in link.get('class','')]
check(len(launch)==5,'portal has exactly five system launch controls')
for folder,dashboard,title in systems:
 expected=folder+'/'+dashboard;check(expected in launch,'system launch opens '+expected)
 for target in [expected,folder+'/']:
  r=admin.get(BASE+'/'+quote(target,safe='/'),timeout=20);check(r.status_code==200,'administrator dashboard entry '+target)
  page=Markup(r.text);current=[a for a in page.links if a.get('aria-current')=='page']
  check(len(current)==1 and current[0].get('href','').lower()=='dashboard.php','Dashboard is selected on entry '+target)
  for resource in page.resources:
   url=urljoin(r.url,resource)
   if urlparse(url).netloc==urlparse(BASE).netloc:
    asset=admin.get(url,timeout=20);check(asset.status_code==200,'local dashboard resource exists '+urlparse(url).path.rsplit('/',1)[-1])
  observed.append({'system':folder,'entry':target,'status':r.status_code,'selected_page':'Dashboard'})
 r=student.get(BASE+'/'+quote(folder+'/',safe='/'),timeout=20,allow_redirects=False)
 check(r.status_code==(403 if 'AI SOC' in folder else 200),'student role preserved on directory entry '+folder)
for path in ['project/dashboard','data/datasets','workbench/notebooks','registry/models','soc/scenarios']:
 r=admin.get(BASE+'/api/v1/'+path,timeout=20);check(r.status_code==200 and r.json()['success'] is True,'each system API responds without404 '+path)
out=ROOT/'verification/v7-20261031';out.mkdir(parents=True,exist_ok=True);(out/'system-dashboard-entries.json').write_text(json.dumps({'database':guard['database'],'assertions':passed,'entries':observed,'work_records_modified':False},indent=2),encoding='utf-8')
print(f'PASS ALL {passed} system entry/resource/API checks; all five systems open Dashboard; no work records created.')
