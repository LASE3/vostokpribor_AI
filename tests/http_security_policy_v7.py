"""Read-only/denied HTTP security policy checks; no login or database writes.
Optional fixture is a disposable isolated local copy with no valid DB credentials.
"""
from urllib.parse import urlparse
import json,os,requests,urllib3
BASE=os.environ.get('TEST_BASE_URL','http://127.0.0.1/vostokpribor_AI').rstrip('/')
assert urlparse(BASE).hostname in ('127.0.0.1','localhost','::1')
passed=0
observed=[]
def check(ok,label):
 global passed
 if not ok:raise AssertionError(label)
 passed+=1;print('PASS '+label,flush=True)
def policy(response,where):
 headers=response.headers
 for name,value in [('X-Content-Type-Options','nosniff'),('X-Frame-Options','SAMEORIGIN'),('Referrer-Policy','strict-origin-when-cross-origin'),('Permissions-Policy','camera=(), microphone=(), geolocation=(), payment=(), usb=()')]:
  check(headers.get(name)==value,where+' exact singular '+name)
 check('X-Powered-By' not in headers,where+' hides PHP banner')
 check(not any(key.lower().startswith('access-control-allow-') for key in headers),where+' grants no cross-origin access')
 observed.append({'path':response.url,'status':response.status_code,'security_headers':{key:value for key,value in headers.items() if key.lower() in ('content-security-policy','referrer-policy','permissions-policy','strict-transport-security','x-frame-options','x-content-type-options','cache-control')}})
s=requests.Session()
for path,status in [('login.php',200),('api/v1/auth/csrf',200),('api/v1/auth/me',401),('api/models.php',401),('api/exchange.php',401)]:
 r=s.get(BASE+'/'+path,timeout=20);check(r.status_code==status,path+' expected status');policy(r,path)
 csp=r.headers.get('Content-Security-Policy','')
 check("script-src 'self' 'unsafe-inline'" in csp and 'unsafe-eval' not in csp and 'cdn.tailwindcss.com' not in csp,path+' enforced static-asset CSP')
 check('no-store' in r.headers.get('Cache-Control',''),path+' cannot cache private/session response')
 check('Strict-Transport-Security' not in r.headers,path+' local environment never enables HSTS')
for path in ['.env','.env.backup','.git/config','.htaccess','database/vostokpribor_ai.sql','storage/private/datasets/.gitkeep','storage/private/models/.gitkeep','app/Core/Env.php','config/navigation.php','bin/migrate.php','workers/python_worker.py','tests/security_unit.php','verification/v6-20261031/final-http-backend.log','verification/v6-20261031/notebook-browser-persistence.png','build/tailwind.shared.config.cjs','scratch/anything.txt','package.json','package-lock.json','v7-security-canary.bak','v7-security-canary.php.old','v7-security-canary.log','v7-security-canary.sql','assets/js/range-client.js.map']:
 r=s.get(BASE+'/'+path,timeout=20);check(r.status_code==403,'HTTP cannot retrieve '+path);policy(r,path)
for path in ['api/models.php/ignored','api/exchange.php/ignored','api/status.php/ignored']:
 r=s.get(BASE+'/'+path,timeout=20);check(r.status_code==404,'unsupported PHP PATH_INFO cannot bypass route/method/admission checks: '+path)
for path in ['assets/js/range-client.js','assets/css/app-layout.css','assets/css/tailwind-shared.css']:
 r=s.get(BASE+'/'+path,timeout=20);check(r.status_code==200 and len(r.content)>100,'required public asset remains available '+path)
r=s.get(BASE+'/api/v1/auth/csrf',timeout=20);token=r.json()['data']['csrf_token']
for origin in ['https://untrusted.invalid','null','http://127.0.0.1:65534']:
 r=s.post(BASE+'/api/v1/auth/login',json={},headers={'Origin':origin,'X-CSRF-Token':token},timeout=20)
 check(r.status_code==403 and r.json()['error']['code']=='ORIGIN_DENIED','foreign Origin denied even with a valid session CSRF token');policy(r,'origin rejection')
 r=s.post(BASE+'/login.php',data={'csrf_token':token},headers={'Origin':origin},timeout=20)
 check(r.status_code==403 and 'Cross-origin writes' in r.text,'HTML foreign Origin denied before any login attempt')
origin=urlparse(BASE).scheme+'://'+urlparse(BASE).netloc
r=s.post(BASE+'/api/v1/auth/login',json={},headers={'Origin':origin,'X-CSRF-Token':token},timeout=20)
check(r.status_code==422 and r.json()['error']['code']=='VALIDATION_ERROR','same-origin request reaches blank-input validation without database mutation')
r=s.post(BASE+'/api/v1/auth/login',json={},headers={'Origin':origin,'X-CSRF-Token':'wrong'},timeout=20)
check(r.status_code==403 and r.json()['error']['code']=='CSRF_MISMATCH','same-origin Origin never bypasses CSRF')
r=s.options(BASE+'/api/v1/auth/me',headers={'Origin':'https://untrusted.invalid','Access-Control-Request-Method':'POST','Access-Control-Request-Headers':'X-CSRF-Token'},timeout=20)
check(not any(key.lower().startswith('access-control-allow-') for key in r.headers),'unauthorized CORS preflight grants no origins, methods or headers')
fixture=os.environ.get('V7_SECURITY_FIXTURE_BASE')
if fixture:
 assert urlparse(fixture).hostname in ('localhost','127.0.0.1','::1') and urlparse(fixture).scheme=='https'
 urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)
 for path in ['failure.php','api/v1/failure.php']:
  r=requests.get(fixture.rstrip('/')+'/production/'+path,verify=False,timeout=20)
  check(r.status_code==500,'actual HTTPS production '+path+' returns500');check(r.headers.get('X-V7-Fixture-Reached')=='yes','production bootstrap completed before intended fixture exception');policy(r,'production500')
  check('TEST_ONLY_PRIVATE_EXCEPTION_SENTINEL' not in r.text and 'C:\\' not in r.text and 'failure.php' not in r.text,'production500 hides exception message and filesystem location')
  check(r.headers.get('Strict-Transport-Security')=='max-age=31536000','production HTTPS500 carries HSTS')
  cookie=r.headers.get('Set-Cookie','').lower()
  check('; secure' in cookie and '; httponly' in cookie and '; samesite=lax' in cookie,'production session cookie is Secure, HttpOnly and SameSite=Lax without exposing its value')
  check('no-store' in r.headers.get('Cache-Control',''),'production500 cannot be cached')
  if path.startswith('api/'):
   check(r.json()['error']['code']=='INTERNAL_ERROR' and 'details' not in r.json()['error'],'production API500 returns generic envelope without details')
 r=requests.get(fixture.rstrip('/')+'/invalid-debug/failure.php',verify=False,timeout=20)
 check(r.status_code==503 and r.text=='Application configuration is unavailable. Contact the administrator.' and 'X-V7-Fixture-Reached' not in r.headers,'APP_DEBUG=true production configuration fails closed without executing endpoint')
 check('TEST_ONLY' not in r.text and 'APP_DEBUG' not in r.text,'invalid production configuration reveals no values or key diagnostics')
 r=requests.get(fixture.rstrip('/')+'/invalid-debug/api/v1/failure.php',verify=False,timeout=20)
 check(r.status_code==503 and r.json()['success'] is False and r.json()['error']['code']=='CONFIGURATION_UNAVAILABLE','invalid production API configuration returns generic JSON503')
 check('details' not in r.json()['error'] and 'APP_DEBUG' not in r.text and 'X-V7-Fixture-Reached' not in r.headers,'configuration JSON503 exposes no values/diagnostics and never executes endpoint')
 r=requests.get(fixture.replace('https:','http:',1).rstrip('/')+'/production/failure.php',timeout=20)
 check(r.status_code==503 and 'Strict-Transport-Security' not in r.headers,'production plaintext HTTP fails closed without HSTS')
 r=requests.get(fixture.replace('https:','http:',1).rstrip('/')+'/invalid-type/failure.php',timeout=20)
 check(r.status_code==503 and r.text=='Application configuration is unavailable. Contact the administrator.','malformed local configuration fails closed with generic response')
output=os.environ.get('V7_SECURITY_OBSERVATIONS')
if output:
 from pathlib import Path
 Path(output).write_text(json.dumps({'base':BASE,'assertions':passed,'requests':observed,'database_mutations':0},indent=2),encoding='utf-8')
print('PASS '+str(passed)+' real HTTP security-header/exposure/CORS/production checks; no authenticated user or database writes.')
