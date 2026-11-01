"""Explicit, uniquely named HTTP test work in an isolated _test installation; never startup data."""
from pathlib import Path
import json, os, secrets, subprocess
import requests
from http_test_target import guarded_target, initialize_session, credential_file, credentials_for

ROOT=Path(__file__).resolve().parents[1]
probe=json.loads(subprocess.check_output([os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe'),str(ROOT/'tests/db_probe.php')],cwd=ROOT,text=True))
BASE=guarded_target(probe);access=credentials_for(credential_file(ROOT),probe['database'])
session=requests.Session();token=initialize_session(session,BASE,probe)
response=session.post(BASE+'/api/v1/auth/login',json={'login':'admin','password':access['admin_password']},headers={'X-CSRF-Token':token},timeout=20)
assert response.status_code==200;session.headers['X-CSRF-Token']=response.json()['data']['csrf_token']
tag='IT-V9-PAGE-'+secrets.token_hex(5).upper();created={'scenarios':[],'students':[]};checks=0
def check(ok,label):
    global checks
    assert ok,label
    checks+=1;print('PASS '+label,flush=True)
for number in range(26):
    for kind,payload in [
        ('scenarios',{'code':tag+'-S'+str(number),'title':tag+' literal 50%_coverage '+str(number),'department':'V9 pagination test','builder_metadata':{'form_fields':{'edit-level':'Level 2','edit-category':'GenAI & RAG'}}}),
        ('students',{'identifier':tag+'-U'+str(number),'full_name':'Isolated pagination account '+str(number),'email':tag.lower()+str(number)+'@example.invalid','password':secrets.token_urlsafe(32)}),
    ]:
        response=session.post(BASE+'/api/v1/soc/'+kind,json=payload,timeout=20)
        check(response.status_code==201,'Explicit isolated '+kind+' POST persists')
        created[kind].append(int(response.json()['data']['id']))
for kind in ['scenarios','students']:
    observed=[];offset=0
    while True:
        response=session.get(BASE+'/api/v1/soc/'+kind,params={'search':tag,'limit':7,'offset':offset},timeout=20);check(response.status_code==200,'Paged '+kind+' read succeeds')
        result=response.json();items=result['data'] if kind=='scenarios' else result['data']['items'];page=result['pagination'] if kind=='scenarios' else result['data']
        check(page['total']==26 and len(items)<=7,'Filtered '+kind+' total counts full collection')
        observed.extend(int(row['id']) for row in items)
        offset+=7
        if offset>=page['total']:break
    check(len(observed)==len(set(observed))==26 and set(observed)==set(created[kind]),'No skipped or duplicated '+kind+' across equal-timestamp page boundaries')
response=session.get(BASE+'/api/v1/soc/scenarios',params={'search':'50%_coverage','department':'V9 pagination test','level':'Level 2','category':'GenAI & RAG','limit':1},timeout=20)
check(response.status_code==200 and response.json()['pagination']['total']==26,'Scenario literal wildcard, department, level and category filters execute on server')
for query in ['limit=0','offset=-1','limit[]=7','offset=1.2']:
    response=session.get(BASE+'/api/v1/soc/scenarios?'+query,timeout=20);check(response.status_code==422,'Invalid collection window rejected '+query)
out=ROOT/'verification/v9-20261101';out.mkdir(parents=True,exist_ok=True)
(out/'http-pagination.json').write_text(json.dumps({'database':probe['database'],'checks':checks,'tag':tag,'created':created,'existing_records_deleted':0,'result':'PASS'},indent=2),encoding='utf-8')
print(f'PASS ALL {checks} real HTTP pagination checks; explicit test records retained only in {probe["database"]}.')
