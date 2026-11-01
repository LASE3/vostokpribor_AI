"""Real MySQL failure in an HTML notebook POST: generic500, no committed row, scoped trigger cleanup."""
from pathlib import Path
from urllib.parse import urlparse
import json,os,secrets,subprocess,requests
ROOT=Path(__file__).resolve().parents[1];PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
def probe(mode='environment',tag=None):
 args=[PHP,str(ROOT/'tests/html_error_probe_v7.php'),mode]
 if tag:args.append(tag)
 return json.loads(subprocess.check_output(args,cwd=ROOT,text=True))
guard=probe();BASE=guard['base_url'].rstrip('/');assert guard['database'].endswith('_test') and urlparse(BASE).hostname in ('localhost','127.0.0.1','::1')
cred=json.loads(Path(os.environ.get('TEST_CREDENTIALS_FILE',str(Path.home()/'.codex/tmp/vostok-integration-20261030-credentials.json'))).read_text(encoding='utf-8'))[guard['database']]
s=requests.Session();token=s.get(BASE+'/api/v1/auth/csrf',timeout=20).json()['data']['csrf_token'];r=s.post(BASE+'/api/v1/auth/login',json={'login':cred['student_identifier'],'password':cred['student_password']},headers={'X-CSRF-Token':token},timeout=20);assert r.status_code==200;token=r.json()['data']['csrf_token']
tag=secrets.token_hex(8);before=probe('state',tag);assert before['matching_notebooks']==0
probe('on',tag)
try:
 r=s.post(BASE+'/ML%20Workbench/NotebookWorkbench.php',data={'csrf_token':token,'action':'create_notebook','title':'IT-V7-ERROR-'+tag},timeout=20,allow_redirects=False)
 assert r.status_code==500,'Unexpected form storage failures must remain HTTP500'
 assert 'An internal server error occurred' in r.text
 assert not any(value in r.text for value in ['TEST_ONLY_SQL_PASSWORD_SENTINEL','SQLSTATE','PDOException','C:\\xampp','Stack trace'])
 assert probe('state',tag)==before,'Failed form POST cannot commit a partial notebook'
 print('PASS 4 real HTML/MySQL failure checks: generic500, no sensitive diagnostics, no partial notebook.')
finally:probe('off',tag)
