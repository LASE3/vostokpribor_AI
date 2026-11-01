"""Anonymous loopback routing probes: no credentials, valid CSRF, or successful mutations.
All registered GETs must reach PHP authentication, rather than an Apache404.
Unsafe methods must be denied by CSRF before any handler can write records.
"""
from pathlib import Path
from urllib.parse import urlparse
import argparse,json,os,subprocess
import requests
parser=argparse.ArgumentParser(description=__doc__);parser.add_argument('--base',required=True);parser.add_argument('--output',required=True);args=parser.parse_args()
ROOT=Path(__file__).resolve().parents[1];BASE=args.base.rstrip('/')
assert urlparse(BASE).hostname in ('localhost','127.0.0.1','::1') and not urlparse(BASE).username
code="require $argv[1]; $router=new App\\Core\\Router(); App\\Core\\ApiRoutes::register($router); echo json_encode($router->definitions());"
routes=json.loads(subprocess.check_output([os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe'),'-r',code,str(ROOT/'app/bootstrap.php')],cwd=ROOT,text=True))
observed=[]
for route in routes:
 path=route['path'].replace('{id}','1');method=route['method']
 # Deliberately no session/cookies/token reuse, including after public CSRF GET.
 response=requests.request(method,BASE+'/api/v1/'+path,json={} if method not in ('GET','HEAD','OPTIONS') else None,timeout=20)
 expected=200 if path=='auth/csrf' else 401 if method=='GET' else 403
 is_json=response.headers.get('Content-Type','').startswith('application/json')
 assert response.status_code==expected and is_json,(method,path,response.status_code,'expected',expected)
 observed.append({'method':method,'path':route['path'],'actual_http_status':response.status_code,'expected':expected,'json':is_json})
out=Path(args.output);out.parent.mkdir(parents=True,exist_ok=True)
out.write_text(json.dumps({'base':BASE,'routes':len(routes),'results':observed,'credentials_used':False,'valid_csrf_sent':False,'successful_mutations':0},indent=2),encoding='utf-8')
print(f'PASS {len(observed)} anonymous routing probes: registered routes reach authentication/CSRF, no Apache404, no successful mutations.')
