"""Mutating integration suite. Requires localhost XAMPP + APP_ENV=testing + *_test DB.
No fixture imports, no table reset, no host code execution. Created work stays in the test DB.
"""
from pathlib import Path
from urllib.parse import urlparse, quote
import json, os, secrets, subprocess, sys
import requests

ROOT = Path(__file__).resolve().parents[1]
PHP = os.environ.get('PHP_BINARY', r'C:\xampp\php\php.exe')
BASE = os.environ.get('TEST_BASE_URL', 'http://localhost/vostokpribor_AI').rstrip('/')
if urlparse(BASE).hostname not in ('localhost', '127.0.0.1', '::1'):
    raise SystemExit('REFUSED: HTTP test URL must be localhost.')
def probe():
    return json.loads(subprocess.check_output([PHP, str(ROOT/'tests/db_probe.php')], cwd=ROOT, text=True))
initial = probe()
assert initial['environment'] == 'testing' and initial['database'].endswith('_test')
PASS = 0
def check(value, label):
    global PASS
    if not value: raise AssertionError(label)
    PASS += 1; print('[PASS] '+label, flush=True)

class Client:
    def __init__(self):
        self.s = requests.Session(); self.token = self.s.get(BASE+'/api/v1/auth/csrf', timeout=20).json()['data']['csrf_token']
    def call(self, method, path, body=None, expected=(200,201), files=None, label=None):
        headers={'X-CSRF-Token':self.token}
        response=self.s.request(method, BASE+'/api/v1/'+path, json=body if files is None else None, data=body if files else None, files=files, headers=headers, timeout=30)
        check(response.status_code in expected, (label or method+' '+path)+' HTTP '+str(response.status_code)+' expected '+str(expected)+' '+(response.text[:250] if response.status_code not in expected else ''))
        result=response.json()
        if isinstance(result.get('data'),dict) and result['data'].get('csrf_token'): self.token=result['data']['csrf_token']
        return result.get('data') if response.ok else result
    def login(self, login, password):
        return self.call('POST','auth/login',{'login':login,'password':password})
    def page(self, path, expected=(200,), contains=None):
        response=self.s.get(BASE+'/'+quote(path, safe='/?=&'), timeout=30, allow_redirects=False)
        check(response.status_code in expected,'HTML '+path+' HTTP '+str(response.status_code))
        check(not any(x in response.text for x in ['Application Error','Fatal error','Warning:','SCN-904-ALPHA','Cadet E. Vance','99.98%','GPU A100']), 'HTML '+path+' has no error or known fixture')
        if contains:check(contains in response.text,'HTML '+path+' displays '+contains)
        return response

check(initial['counts']['users']==1 and initial['counts']['scenarios']==0 and initial['counts']['tickets']==0 and initial['counts']['audit_logs']==0,'test DB starts with one admin and zero work/audit records')
anon=Client()
r=anon.s.post(BASE+'/api/v1/auth/login',json={'login':'admin','password':'admin'},timeout=20)
check(r.status_code==403,'login without CSRF rejected')
anon.call('GET','users',expected=(401,))
anon.call('POST','auth/register',{},expected=(404,))
admin=Client(); data=admin.login('admin','admin');check(data['must_change_password'],'initial admin password requires rotation')
admin.call('GET','admin/overview',expected=(403,))
admin.call('POST','auth/change-password',{'current_password':'wrong','new_password':secrets.token_urlsafe(20)},expected=(422,))
admin_pw=secrets.token_urlsafe(24)
admin.call('POST','auth/change-password',{'current_password':'admin','new_password':admin_pw})
private=Path(os.environ.get('USERPROFILE',str(Path.home())))/'.codex/backups/vostokpribor/browser-test-credentials.json'
private.parent.mkdir(parents=True,exist_ok=True)
private.write_text(json.dumps({'admin_password':admin_pw}),encoding='utf-8')
overview=admin.call('GET','admin/overview');check(overview['students']['total']==0 and overview['tickets']['total']==0 and overview['datasets']['master']==0 and overview['models']['registered']==0,'admin dashboard counts empty actual DB')
for path in ['AI Operations Center (AI SOC)/Dashboard.php','AI Operations Center (AI SOC)/OperationsDashboard.php','AI Operations Center (AI SOC)/TicketsAndScenarios.php','AI Operations Center (AI SOC)/StudentManagement.php','AI Operations Center (AI SOC)/DatasetManagement.php','AI Operations Center (AI SOC)/WorkspaceConfiguration.php']:
    admin.page(path)
nonce=secrets.token_hex(4).upper()
students=[]
for i in range(2):
    password=secrets.token_urlsafe(24);identifier='HTTP-'+nonce+'-'+str(i)
    user=admin.call('POST','users',{'full_name':'Workflow Test '+str(i),'email':identifier.lower()+'@example.invalid','identifier':identifier,'password':password},expected=(201,))
    c=Client();c.login(identifier,password);c.call('GET','tickets',expected=(403,));new=secrets.token_urlsafe(24);c.call('POST','auth/change-password',{'current_password':password,'new_password':new});students.append((user,c,new))
    check(c.call('GET','tickets')==[] and c.call('GET','datasets')==[] and c.call('GET','notebooks')==[] and c.call('GET','models')==[],'new student has zero assigned work and no auto-created records')
u1,s1,pw1=students[0];u2,s2,pw2=students[1]
scenario=admin.call('POST','scenarios',{'code':'SC-'+nonce,'title':'Persisted HTTP workflow','description':'Created by explicit test POST','builder_metadata':{'schema_version':1,'form_fields':{'edit-title':'Persisted HTTP workflow','edit-industry':'Real uploaded data','dim-weight-0':'100','deliv-notebooks':True},'workflow':[{'stage':'Frame','action':'Define requirements'}]}},expected=(201,))
sid=int(scenario['id']);meta=scenario['builder_metadata']
changed=admin.call('PATCH',f'scenarios/{sid}',{'description':'Edited through API','builder_metadata':meta})
persisted=admin.call('GET',f'scenarios/{sid}');check(persisted['description']=='Edited through API' and persisted['builder_metadata']['form_fields']==meta['form_fields'] and persisted['builder_metadata']['workflow']==meta['workflow'],'scenario builder fields and edit survive independent GET with server audit history')
admin.call('PATCH',f'scenarios/{sid}',{'status':'ACTIVE'},expected=(422,))
for status in ['READY_FOR_REVIEW','PUBLISHED','ACTIVE','COMPLETED','ARCHIVED','DRAFT']:
    changed=admin.call('PATCH',f'scenarios/{sid}',{'status':status});check(changed['status']==status,'scenario lifecycle persisted '+status)
ticket=admin.call('POST','tickets',{'ticket_code':'T-'+nonce,'title':'Assigned file preparation','scenario_id':sid,'description':'Inspect uploaded rows','requirements':'Clean actual data and save notebook','acceptance_criteria':'Submitted code persists; no execution claim','deadline':'2027-01-15 12:00:00','priority':'HIGH'},expected=(201,))
tid=int(ticket['id']);admin.call('POST',f'tickets/{tid}/assignments',{'student_id':u1['id']})
check(len(s1.call('GET','tickets'))==1 and s2.call('GET','tickets')==[],'student sees only assigned ticket')
dataset=admin.call('POST','datasets',{'code':'DS-'+nonce,'name':'Uploaded measurements','scenario_id':sid},files={'dataset_file':('measurements.csv',b'feature,label\n1,0\n2,1\n3,1\n','text/csv')},expected=(201,))
did=int(dataset['id']);check(int(dataset['row_count'])==3 and int(dataset['column_count'])==2 and len(dataset['checksum_sha256'])==64,'master CSV byte-derived rows columns checksum persisted')
admin.call('POST',f'datasets/{did}/assignments',{'student_id':u2['id'],'ticket_id':tid},expected=(422,))
admin.call('POST',f'datasets/{did}/assignments',{'student_id':u1['id'],'ticket_id':tid})
check(len(s1.call('GET','datasets'))==1 and s2.call('GET','datasets')==[],'dataset visibility follows assignment')
preview=s1.call('GET',f'datasets/{did}/preview');check(len(preview['preview_rows'])==3 and preview['columns']==['feature','label'],'authorized preview reads actual uploaded bytes')
admin.call('POST','datasets',{'code':'BAD-'+nonce,'name':'Malformed JSON'},files={'dataset_file':('bad.json',b'{ broken','application/json')},expected=(422,))
s1.call('PATCH',f'tickets/{tid}',{'status':'IN_PROGRESS'});s1.call('POST',f'tickets/{tid}/comments',{'comment':'Actual preprocessing progress'})
processed=s1.call('POST','datasets/processed',{'source_dataset_id':did,'ticket_id':tid,'name':'Prepared data','transformation_notes':'Removed unused rows'},files={'processed_file':('prepared.json',b'[{"feature":2,"label":1},{"feature":3,"label":1}]','application/json')},expected=(201,))
check(int(processed['row_count'])==2,'processed JSON count derives from uploaded file')
s2.call('POST','datasets/processed',{'source_dataset_id':did,'ticket_id':tid,'name':'Denied'},files={'processed_file':('unauthorized.csv',b'x\n1\n','text/csv')},expected=(422,))
before=probe()['counts']
for p in ['AI Project Management/Dashboard.php','AI Project Management/Tickets.php','AI Project Management/TicketDetails.php?id='+str(tid),'AI Project Management/Submissions.php','AI Project Management/StudentProfile.php','Data Center/dashboard.php','Data Center/DatasetCatalog.php?id='+str(did),'Data Center/MyDataSet.php','Data Center/DataProfilingAndQuality.php?id='+str(did),'Data Center/QueryWorkspace.php','Data Center/RecentActivityAndAudit.php','Data Center/UploadProcessedData.php','ML Workbench/NotebookWorkbench.php','ML Workbench/ExperimentRuns.php','ML Workbench/HyperparameterMatrix.php','ML Workbench/MetricTelemetry.php','ML Workbench/ModelArtifacts.php','ML Workbench/RangeEvaluation.php','ML Workbench/TensorInspector.php','Model Registry & Deployment/dashboard.php','Model Registry & Deployment/ModelRegistry.php','Model Registry & Deployment/ValidationPipeline.php','Model Registry & Deployment/ValidationReports.php','Model Registry & Deployment/DeploymentConfig.php','Model Registry & Deployment/DeployedEndpoints.php']:
    s1.page(p)
after=probe()['counts'];check(before==after,'all student pages GET cause zero new database records')
code='values = [2, 3]\nprint(sum(values))\n# saved, never executed'
nb=s1.call('POST','notebooks',{'title':'Persisted analysis','ticket_id':tid,'cells':[{'cell_type':'code','source':code}]},expected=(201,))
nid=int(nb['id']);code+='\nresult = 5'
s1.call('PATCH',f'notebooks/{nid}',{'cells':[{'cell_type':'code','source':code,'output_text':'FAKE PASS'}]})
saved=s1.call('GET',f'notebooks/{nid}');check(saved['cells'][0]['source']==code and not saved['cells'][0]['output_text'],'notebook saved source identical; student cannot forge output')
s1.call('POST','execution-jobs',{'notebook_id':nid,'code_to_execute':'raise Exception("must not run")'},expected=(503,))
model=s1.call('POST','models',{'model_code':'M-'+nonce,'name':'Metadata registration','framework':'ONNX','ticket_id':tid},expected=(201,));mid=int(model['id'])
check(probe()['counts']['model_versions']==0,'model metadata registration creates no artifact version')
s1.call('POST','validation-runs',{'model_id':mid,'model_version_id':0},expected=(422,))
s1.call('POST','deployment-requests',{'model_id':mid,'model_version_id':0},expected=(422,))
version=s1.call('POST',f'models/{mid}/versions',{'version':'v1','metrics':json.dumps({'accuracy':1.0,'f1':1.0,'latency_ms':0.1})},files={'artifact_file':('opaque.json',b'{"opaque_model_bytes":true}','application/json')},expected=(201,));vid=int(version['id'])
validation=s1.call('POST','validation-runs',{'model_id':mid,'model_version_id':vid},expected=(201,200))
check(validation['status']=='NOT_EVALUATED' and validation['score'] is None,'student perfect metrics do not certify quality; missing trusted evidence NOT_EVALUATED')
s1.call('POST','deployment-requests',{'model_id':mid,'model_version_id':vid},expected=(422,503))
sub=s1.call('POST','submissions',{'ticket_id':tid,'notebook_id':nid,'model_id':mid,'notes':'Prepared file, saved code, opaque artifact; execution unavailable.'},expected=(201,));subid=int(sub['id'])
for path in [f'tickets/{tid}',f'datasets/{did}',f'datasets/{did}/preview',f'datasets/{did}/download',f'notebooks/{nid}',f'models/{mid}',f'submissions/{subid}',f'validation-runs/{validation["id"]}',f'users/{u1["id"]}']:
    s2.call('GET',path,expected=(403,404))
s2.call('PATCH',f'notebooks/{nid}',{'cells':[]},expected=(403,404))
s2.call('PATCH',f'tickets/{tid}',{'status':'IN_PROGRESS'},expected=(403,404))
s2.call('POST',f'tickets/{tid}/comments',{'comment':'denied'},expected=(403,404))
s2.call('POST','submissions',{'ticket_id':tid,'notebook_id':nid,'model_id':mid},expected=(403,404,422))
s2.call('POST','scenarios',{'code':'DENIED','title':'Denied'},expected=(403,))
s2.call('GET','admin/overview',expected=(403,))
s2.page('AI Operations Center (AI SOC)/StudentManagement.php',expected=(403,))
bad=s1.s.post(BASE+'/api/v1/notebooks',json={'title':'Bad csrf'},headers={'X-CSRF-Token':'incorrect'},timeout=20);check(bad.status_code==403,'incorrect authenticated CSRF rejected')
bad=s1.s.post(BASE+'/AI Project Management/TicketDetails.php?id='+str(tid),data={'action':'progress','ticket_id':tid,'csrf_token':'wrong'},timeout=20);check(bad.status_code==403,'incorrect HTML CSRF rejected')
review=admin.call('POST',f'submissions/{subid}/review',{'status':'CHANGES_REQUESTED','feedback':'Explain the transformations.'})
check(s1.call('GET',f'submissions/{subid}')['feedback']=='Explain the transformations.' and s1.call('GET',f'tickets/{tid}')['status']=='CHANGES_REQUESTED','review feedback and ticket change persist for student')
s1.call('PATCH',f'tickets/{tid}',{'status':'IN_PROGRESS'})
resub=s1.call('POST','submissions',{'ticket_id':tid,'notebook_id':nid,'model_id':mid,'notes':'Transformation explanation added.'},expected=(201,))
admin.call('POST',f'submissions/{resub["id"]}/review',{'status':'APPROVED','feedback':'Accepted non-execution deliverables.','total_score':85})
check(s1.call('GET',f'tickets/{tid}')['status']=='APPROVED','approved review updates actual ticket status')
s1.page('AI Project Management/Submissions.php',contains='Accepted non-execution deliverables.')
admin.page('AI Operations Center (AI SOC)/WorkspaceConfiguration.php')
counts=probe();check(counts['counts']['deployment_requests']==0 and counts['counts']['execution_jobs']==0,'no false deployment or execution jobs created')
overview=admin.call('GET','admin/overview');check(overview['students']['total']==2 and overview['tickets']['total']==1 and overview['datasets']['master']==1 and overview['datasets']['processed']==1 and overview['models']['registered']==1 and overview['submissions']['total']==2,'SOC counts match actual end-to-end persisted records')
actions={a['action'] for a in counts['audit_actions']}
check({'STUDENT_CREATED','SCENARIO_CREATED','TICKET_CREATED','DATASET_UPLOADED','DATASET_ASSIGNED','PROCESSED_DATASET_UPLOADED','NOTEBOOK_CREATED','NOTEBOOK_SAVED','MODEL_REGISTERED','SUBMISSION_CREATED'}.issubset(actions),'workflow creates actual schema-valid audit events')
out=ROOT/'verification';out.mkdir(exist_ok=True)
(out/'http-db-observed.json').write_text(json.dumps(counts,indent=2),encoding='utf-8')
private=Path(os.environ.get('USERPROFILE',str(Path.home())))/'.codex/backups/vostokpribor/browser-test-credentials.json'
private.parent.mkdir(parents=True,exist_ok=True)
private.write_text(json.dumps({'admin_password':admin_pw,'student_identifier':u1['identifier'],'student_password':pw1,'ticket_id':tid,'dataset_id':did,'notebook_id':nid,'model_id':mid}),encoding='utf-8')
print(f'ALL {PASS} HTTP/HTML workflow checks passed on {initial["database"]}. No fresh DB mutations.',flush=True)
