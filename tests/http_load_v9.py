"""Real bounded HTTP reads with independent sessions; guarded isolated local installation only."""
from concurrent.futures import ThreadPoolExecutor
from pathlib import Path
import json, os, subprocess, time, statistics
import requests
from http_test_target import guarded_target, initialize_session, credential_file, credentials_for

ROOT=Path(__file__).resolve().parents[1]
probe=json.loads(subprocess.check_output([os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe'),str(ROOT/'tests/db_probe.php')],cwd=ROOT,text=True))
BASE=guarded_target(probe)
access=credentials_for(credential_file(ROOT),probe['database'])
results=[]
for concurrency in [1,5,10]:
    clients=[]
    for _ in range(concurrency):
        session=requests.Session();token=initialize_session(session,BASE,probe)
        login=session.post(BASE+'/api/v1/auth/login',json={'login':access['student_identifier'],'password':access['student_password']},headers={'X-CSRF-Token':token},timeout=20)
        assert login.status_code==200,('login',login.status_code)
        clients.append(session)
    def read(client):
        samples=[]
        for route in ['project/tickets','registry/models']:
            started=time.perf_counter();response=client.get(BASE+'/api/v1/'+route,params={'limit':25},timeout=20)
            elapsed=(time.perf_counter()-started)*1000
            assert response.status_code==200,(route,response.status_code)
            envelope=response.json();page=envelope['pagination'];items=envelope['data']
            assert envelope['success'] is True and len(items)<=25 and page['total']>=len(items)
            assert all(int(item['student_id'])==int(access['student_id']) for item in items)
            samples.append({'route':route,'ms':round(elapsed,3),'bytes':len(response.content),'http':response.status_code,'rows':len(items)})
        return samples
    started=time.perf_counter()
    with ThreadPoolExecutor(max_workers=concurrency) as pool:
        samples=[sample for group in pool.map(read,clients) for sample in group]
    times=sorted(sample['ms'] for sample in samples)
    result={'concurrent_sessions':concurrency,'requests':len(samples),'elapsed_ms':round((time.perf_counter()-started)*1000,3),'median_ms':round(statistics.median(times),3),'p95_ms':times[min(len(times)-1,int(len(times)*.95))],'errors':0,'samples':samples}
    # A local acceptance budget, not a capacity or public availability guarantee.
    assert result['p95_ms']<2500,('local bounded read latency budget exceeded',result)
    results.append(result)
out=ROOT/'verification/v9-20261101';out.mkdir(parents=True,exist_ok=True)
(out/'http-load.json').write_text(json.dumps({'database':probe['database'],'environment':'testing','fixture_students':probe['counts']['users']-1,'load_scope':'1/5/10 independent sessions of one authorized student; separate repository tests cover10/50/100/500 students','latency_budget_ms':2500,'results':results},indent=2),encoding='utf-8')
print('PASS 32 actual authorized HTTP reads at 1/5/10 independent sessions; zero unexpected errors; each p95 below 2500ms.')
