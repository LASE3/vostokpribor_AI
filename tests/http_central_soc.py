"""Real XAMPP integration tests. Never resets a DB; requires APP_ENV=testing + *_test.
Each run creates uniquely named, explicit test work. Credentials stay outside the web root.
"""
from pathlib import Path
from urllib.parse import urlparse, quote
import json, os, secrets, subprocess, requests
ROOT=Path(__file__).resolve().parents[1]
PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
BASE=os.environ.get('TEST_BASE_URL','').rstrip('/')
def probe(mode='state',arg=None):
    args=[PHP,str(ROOT/'tests/integration_probe.php'),mode]
    if arg is not None:args.append(str(arg))
    return json.loads(subprocess.check_output(args,cwd=ROOT,text=True))
initial=probe();assert initial['environment']=='testing' and initial['database'].endswith('_test')
if not BASE:BASE=str(initial['app_url']).rstrip('/')
assert urlparse(BASE).hostname in ['localhost','127.0.0.1','::1']
passed=0;coverage=[]
def check(ok,label):
    global passed
    if not ok:raise AssertionError(label)
    passed+=1;print('PASS '+label,flush=True)
class Client:
    def __init__(self):
        self.s=requests.Session();r=self.s.get(BASE+'/api/v1/auth/csrf',timeout=20);self.token=r.json()['data']['csrf_token']
    def call(self,method,path,body=None,expected=(200,201),files=None,headers=None):
        h={'X-CSRF-Token':self.token};h.update(headers or {})
        r=self.s.request(method,BASE+'/api/v1/'+path,json=body if files is None else None,data=body if files else None,files=files,headers=h,timeout=30)
        coverage.append({'method':method,'path':path,'status':r.status_code})
        check(r.status_code in expected,method+' '+path+' HTTP '+str(r.status_code)+((' '+r.text[:300]) if r.status_code not in expected else ''))
        try:result=r.json()
        except Exception:raise AssertionError('Non-JSON API response: '+r.text[:300])
        check(isinstance(result.get('success'),bool),'API envelope '+method+' '+path)
        data=result.get('data')
        if isinstance(data,dict) and data.get('csrf_token'):self.token=data['csrf_token']
        return data if r.ok else result
    def login(self,identifier,pw):return self.call('POST','auth/login',{'login':identifier,'password':pw})
    def page(self,path,contains=None,expected=(200,)):
        r=self.s.get(BASE+'/'+quote(path,safe='/?=&'),timeout=30,allow_redirects=False)
        check(r.status_code in expected,'HTML '+path+' HTTP '+str(r.status_code))
        check(not any(x in r.text for x in ['Fatal error','Application Error','Warning:','<<<<<<< Updated upstream','>>>>>>> Stashed changes']),'HTML clean '+path)
        if contains:check(contains in r.text,'HTML reflects persisted '+contains)
        return r
tag=secrets.token_hex(5).upper();private=Path(os.environ.get('USERPROFILE',str(Path.home())))/'.codex/tmp/vostok-integration-20261030-credentials.json'
private.parent.mkdir(parents=True,exist_ok=True)
saved=json.loads(private.read_text(encoding='utf-8')) if private.exists() else {}
admin=Client();pw=saved.get(initial['database'],{}).get('admin_password','admin');auth=admin.login('admin',pw)
if auth['must_change_password']:
    admin.call('GET','soc/overview',expected=(403,));new=secrets.token_urlsafe(24)
    admin.call('POST','auth/change-password',{'current_password':pw,'new_password':new});pw=new
saved[initial['database']]={'admin_password':pw};private.write_text(json.dumps(saved,indent=2),encoding='utf-8')
admin.call('GET','soc/overview');health=admin.call('GET','soc/system-health')
check(health['database']['status']=='AVAILABLE' and health['python_worker']['status']=='NOT_CONFIGURED' and not health['inference_provider']['deployment_enabled'],'measured database availability separated from unavailable infrastructure')
students=[]
for n in range(2):
    ident=f'IT-{tag}-{n}';p=secrets.token_urlsafe(24)
    u=admin.call('POST','soc/students',{'identifier':ident,'full_name':f'Integration {tag} {n}','email':ident.lower()+'@example.invalid','password':p},expected=(201,))
    c=Client();c.login(ident,p);c.call('GET','project/tickets',expected=(403,));new=secrets.token_urlsafe(24);c.call('POST','auth/change-password',{'current_password':p,'new_password':new});students.append((u,c,new))
u1,s1,p1=students[0];u2,s2,p2=students[1]
saved[initial['database']].update({'student_identifier':u1['identifier'],'student_password':p1,'student_id':u1['id']});private.write_text(json.dumps(saved,indent=2),encoding='utf-8')
admin.call('PATCH',f'soc/students/{u1["id"]}',{'role':'ADMIN'},expected=(422,))
admin.call('PATCH',f'soc/students/{u1["id"]}',{'full_name':'Edited SOC student','cohort':'Integration cohort'})
check(admin.call('GET',f'soc/students/{u1["id"]}')['profile']['role']=='STUDENT','student edit cannot create administrator')
sc=admin.call('POST','soc/scenarios',{'code':'IT-SC-'+tag,'title':'Central SOC workflow '+tag,'builder_metadata':{'schema_version':1,'form_fields':{'edit-title':'Central SOC workflow '+tag,'dim-weight-1':'100'},'workflow':[{'stage':'Frame','action':'Inspect actual upload'}]}},expected=(201,));sid=int(sc['id'])
check(admin.call('GET',f'soc/scenarios/{sid}')['builder_metadata']['form_fields']['edit-title']=='Central SOC workflow '+tag,'scenario builder metadata survives reload')
admin.call('PATCH',f'soc/scenarios/{sid}',{'description':'Edited centrally'})
admin.call('POST',f'soc/scenarios/{sid}/publish',{})
ticket=admin.call('POST','soc/tickets',{'ticket_code':'IT-T-'+tag,'title':'Central assignment '+tag,'scenario_id':sid,'requirements':'Save actual file and code','acceptance_criteria':'Instructor review','deadline':'2026-12-20 10:30:00','priority':'HIGH'},expected=(201,));tid=int(ticket['id'])
admin.call('PATCH',f'soc/tickets/{tid}',{'description':'Edited ticket requirements visible','deadline':'2026-12-21 11:15:00'})
admin.call('POST',f'soc/tickets/{tid}/assign',{'student_id':u1['id']});counts=probe()['counts'];admin.call('POST',f'soc/tickets/{tid}/assign',{'student_id':u1['id']});after=probe()['counts']
check(counts==after,'repeated ticket assignment creates no duplicate row, notification, or audit')
check(s1.call('GET',f'project/tickets/{tid}')['deadline']=='2026-12-21 11:15:00','SOC edit visible through student ticket API')
s1.call('POST',f'project/tickets/{tid}/progress',{'status':'APPROVED'},expected=(422,));s1.call('POST',f'project/tickets/{tid}/progress',{'priority':'LOW'},expected=(422,));s1.call('POST',f'project/tickets/{tid}/progress',{'status':'IN_PROGRESS'})
s1.call('POST',f'project/tickets/{tid}/comments',{'comment':'Saved progress from student'});comments=s1.call('GET',f'project/tickets/{tid}/comments');check(any(c['comment']=='Saved progress from student' for c in comments),'comments persist in shared ticket')
csv=b'feature,label\n1,0\n2,1\n';dataset=admin.call('POST','soc/datasets',{'code':'IT-DS-'+tag,'name':'Actual uploaded training data','scenario_id':sid},files={'dataset_file':('actual.csv',csv,'text/csv')},expected=(201,));did=int(dataset['id'])
versions=admin.call('GET',f'soc/datasets/{did}/versions');v1=int(versions[0]['id'])
admin.call('PATCH',f'soc/datasets/{did}',{'name':'SOC edited dataset','description':'Real immutable source'})
admin.call('POST',f'soc/datasets/{did}/assign',{'student_id':u1['id'],'ticket_id':tid,'dataset_version_id':v1})
counts=probe()['counts'];admin.call('POST',f'soc/datasets/{did}/assign',{'student_id':u1['id'],'ticket_id':tid,'dataset_version_id':v1});check(counts==probe()['counts'],'duplicate dataset assignment is idempotent')
preview=s1.call('GET',f'data/datasets/{did}/preview');check(len(preview['preview_rows'])==2,'preview reads actual CSV upload')
r=s1.s.get(BASE+f'/api/v1/data/datasets/{did}/download',timeout=20);check(r.status_code==200 and r.content==csv,'authenticated dataset download matches original bytes')
admin.call('POST',f'soc/datasets/{did}/versions',{'version':'v2'},files={'dataset_file':('next.json',b'[{"feature":9,"label":1}]','application/json')},expected=(201,))
check(len(s1.call('GET',f'data/datasets/{did}/preview')['preview_rows'])==2,'new master version does not overwrite pinned assignment')
check(len(s1.call('GET',f'data/datasets/{did}/versions'))==1,'student cannot enumerate unassigned dataset versions')
processed=s1.call('POST','data/processed',{'source_dataset_id':did,'ticket_id':tid,'name':'Processed real file','transformation_notes':'Selected valid rows'},files={'processed_file':('processed.csv',b'feature,label\n2,1\n','text/csv')},expected=(201,));pid=int(processed['id'])
check(int(s1.call('GET',f'data/processed/{pid}')['source_dataset_version_id'])==v1,'processed result records pinned source version')
s1.call('GET','data/processed');s1.call('GET','data/activity')
nb=s1.call('POST','workbench/notebooks',{'title':'Exact saved source '+tag,'ticket_id':tid,'cells':[]},expected=(201,));nid=int(nb['id']);code='values = [1, 2]\nprint(sum(values))\n# persistence only'
s1.call('PATCH',f'workbench/notebooks/{nid}',{'cells':[{'cell_type':'code','source':code,'output_text':'FAKE OUTPUT'}]});loaded=s1.call('GET',f'workbench/notebooks/{nid}');check(loaded['cells'][0]['source']==code and loaded['cells'][0]['output_text'] is None,'notebook exact source persists; user cannot forge execution output')
check(admin.call('GET',f'soc/notebooks/{nid}')['student_id']==u1['id'],'SOC notebook inspection identifies actual student author')
exp=s1.call('POST','workbench/experiments',{'name':'Owned experiment '+tag,'ticket_id':tid},expected=(201,));eid=int(exp['id']);s1.call('GET',f'workbench/experiments/{eid}')
s1.call('POST','workbench/runs',{'experiment_id':eid,'notebook_id':nid,'run_name':'User metadata only','metrics':{'accuracy':1},'status':'COMPLETED'},expected=(201,));runs=s1.call('GET',f'workbench/runs?experiment_id={eid}');check(runs[0]['status']=='RECORDED','metadata run never claims actual execution')
model=s1.call('POST','registry/models',{'model_code':'IT-M-'+tag,'name':'Owned model metadata','framework':'JSON','ticket_id':tid},expected=(201,));mid=int(model['id']);check(s1.call('GET',f'registry/models/{mid}/versions')==[],'model metadata has no fabricated artifact version')
s1.call('POST','registry/validations',{'model_id':mid,'model_version_id':0},expected=(422,));s1.call('POST','registry/deployment-requests',{'model_id':mid,'model_version_id':0},expected=(422,))
artifact=s1.call('POST',f'registry/models/{mid}/versions',{'version':'v1','metrics':json.dumps({'accuracy':1.0,'latency_ms':0.01})},files={'artifact_file':('opaque.json',b'{"opaque":true}','application/json')},expected=(201,));vid=int(artifact['id'])
val=s1.call('POST','registry/validations',{'model_id':mid,'model_version_id':vid},expected=(201,));valid=int(val['id']);check(val['status']=='NOT_EVALUATED' and val['score'] is None,'untrusted perfect student metrics do not certify quality')
request=s1.call('POST','registry/deployment-requests',{'model_id':mid,'model_version_id':vid,'environment':'staging','idempotency_key':'IT-'+tag},expected=(201,));rid=int(request['id']);check(request['status']=='PENDING' and not request['endpoint_url'],'request records administrative state without endpoint')
again=s1.call('POST','registry/deployment-requests',{'model_id':mid,'model_version_id':vid,'environment':'staging','idempotency_key':'IT-'+tag},expected=(201,200));check(again['id']==request['id'],'deployment request retry does not duplicate record')
admin.call('PATCH',f'soc/models/{mid}',{'name':'Overwrite student authoring'},expected=(422,));admin.call('PATCH',f'soc/models/{mid}',{'admin_label':'Reviewed metadata','admin_notes':'No quality assertion'})
check(admin.call('GET',f'soc/models/{mid}')['name']=='Owned model metadata','admin annotations preserve student-authored model name')
admin.call('POST',f'soc/deployment-requests/{rid}/approve',{'notes':'Administrative approval; provider unavailable'})
dep=s1.call('GET','registry/deployment-requests');own=[x for x in dep if int(x['id'])==rid][0];check(own['status']=='APPROVED' and not own['endpoint_url'],'approval remains separate from actual deployment')
admin.call('PATCH',f'soc/deployment-requests/{rid}',{'status':'DEPLOYED'},expected=(422,))
uuid=probe('queue',nid)['uuid'];admin.call('GET',f'soc/execution-jobs/{uuid}');admin.call('POST',f'soc/execution-jobs/{uuid}/cancel',{})
check(admin.call('GET',f'soc/execution-jobs/{uuid}')['status']=='CANCELLED','SOC cancellation persists existing queued state without host execution')
for path in [f'project/tickets/{tid}',f'data/datasets/{did}',f'data/datasets/{did}/preview',f'data/processed/{pid}',f'workbench/notebooks/{nid}',f'workbench/experiments/{eid}',f'registry/models/{mid}',f'registry/validations/{valid}']:
    s2.call('GET',path,expected=(403,404))
sub=s1.call('POST','project/submissions',{'ticket_id':tid,'notebook_id':nid,'model_id':mid,'notes':'Saved actual work','request_key':'IT-SUB-'+tag},expected=(201,));subid=int(sub['id'])
same=s1.call('POST','project/submissions',{'ticket_id':tid,'notebook_id':nid,'model_id':mid,'notes':'Saved actual work','request_key':'IT-SUB-'+tag},expected=(200,201));check(int(same['id'])==subid,'submission retry remains one iteration')
admin.call('POST',f'soc/submissions/{subid}/request-changes',{'feedback':'Explain transformations','total_score':82.25});check(s1.call('GET',f'project/tickets/{tid}')['status']=='CHANGES_REQUESTED','SOC revision review updates student ticket')
counts=probe()['counts'];admin.call('POST',f'soc/submissions/{subid}/request-changes',{'feedback':'Explain transformations','total_score':82.25});check(counts==probe()['counts'],'review retry creates no duplicate audit or notification')
s1.call('POST',f'project/tickets/{tid}/progress',{});revision=s1.call('POST','project/submissions',{'ticket_id':tid,'notes':'Revised explanation','request_key':'IT-REV-'+tag},expected=(201,));admin.call('POST',f'soc/submissions/{revision["id"]}/approve',{'feedback':'Accepted saved deliverables','total_score':92.5});check(s1.call('GET',f'project/tickets/{tid}')['status']=='APPROVED','approval visible in student work and persistent ticket')
admin.call('POST',f'soc/tickets/{tid}/reassign',{'student_id':u2['id']},expected=(422,))
ticket2=admin.call('POST','soc/tickets',{'ticket_code':'IT-RE-'+tag,'title':'Reassignment history','scenario_id':sid,'student_id':u1['id']},expected=(201,));tid2=int(ticket2['id'])
admin.call('POST',f'soc/datasets/{did}/assign',{'student_id':u1['id'],'ticket_id':tid2,'dataset_version_id':v1})
oldwork=s1.call('POST','workbench/notebooks',{'title':'Private historic notebook','ticket_id':tid2},expected=(201,));oldnb=int(oldwork['id'])
admin.call('POST',f'soc/tickets/{tid2}/reassign',{'student_id':u2['id']});s1.call('GET',f'project/tickets/{tid2}',expected=(403,404));s1.call('GET',f'workbench/notebooks/{oldnb}');s2.call('GET',f'workbench/notebooks/{oldnb}',expected=(403,404));check(int(s2.call('GET',f'project/tickets/{tid2}')['id'])==tid2,'reassignment changes authorized ticket without transferring private artifacts')
admin.call('POST',f'soc/datasets/{did}/revoke',{'student_id':u1['id'],'ticket_id':tid});s1.call('GET',f'data/datasets/{did}',expected=(403,404));s1.call('GET',f'data/processed/{pid}')
probe('audit-fail-on',did)
try:admin.call('POST',f'soc/datasets/{did}/assign',{'student_id':u2['id'],'ticket_id':tid2,'dataset_version_id':v1},expected=(500,))
finally:probe('audit-fail-off')
assignments=admin.call('GET',f'soc/datasets/{did}/assignments');check(not any(int(x['student_id'])==int(u2['id']) and not x['revoked_at'] for x in assignments),'audit failure rolls back assignment and associated notifications')
admin.call('POST',f'soc/datasets/{did}/assign',{'student_id':u2['id'],'ticket_id':tid2,'dataset_version_id':v1});admin.call('POST',f'soc/datasets/{did}/archive',{});s2.call('GET',f'data/datasets/{did}',expected=(403,404));check(len(admin.call('GET',f'soc/datasets/{did}/versions'))==2,'dataset archival retains immutable versions')
admin.call('POST',f'soc/tickets/{tid2}/cancel',{});check(s2.call('GET',f'project/tickets/{tid2}')['status']=='CANCELLED','cancelled ticket remains visible with truthful status')
for path in [f'soc/students/{u1["id"]}/'+s for s in ['progress','activity','tickets','datasets','notebooks','experiments','models','submissions','summary']]+[f'soc/tickets/{tid}/'+s for s in ['students','datasets','submissions']]+[f'soc/scenarios/{sid}/'+s for s in ['tickets','datasets','students']]+['soc/tickets/summary','soc/datasets/summary','soc/models/summary','soc/activity','soc/audit-logs','soc/notebooks','soc/experiments','soc/experiment-runs','soc/execution-jobs','soc/models','soc/validations','soc/deployment-requests','soc/deployments']:
    admin.call('GET',path)
admin.call('PATCH','soc/settings',{'key':'platform_announcement','value':'Integration guidance '+tag});check(any(x['setting_value']=='Integration guidance '+tag for x in s1.call('GET','project/dashboard')['guidance']),'SOC setting visible to student dashboard')
admin.call('GET','soc/settings');admin.call('PATCH','soc/settings',{'key':'enable_python','value':'true'},expected=(422,))
admin.call('POST',f'soc/students/{u2["id"]}/deactivate',{});s2.call('GET','auth/me',expected=(401,));admin.call('POST',f'soc/students/{u2["id"]}/activate',{});s2=Client();s2.login(u2['identifier'],p2)
reset=secrets.token_urlsafe(24);admin.call('POST',f'soc/students/{u2["id"]}/reset-password',{'new_password':reset});s2.call('GET','auth/me',expected=(401,));s2=Client();s2.login(u2['identifier'],p2) if False else None
s2.call('POST','auth/login',{'login':u2['identifier'],'password':p2},expected=(401,));s2.login(u2['identifier'],reset);s2.call('GET','project/tickets',expected=(403,));p2=secrets.token_urlsafe(24);s2.call('POST','auth/change-password',{'current_password':reset,'new_password':p2})
cookie=s2.s.cookies.get(initial['cookie']);probe('expire',cookie);s2.call('GET','auth/me',expected=(401,))
bad=s1.s.post(BASE+'/api/v1/project/submissions',json={'ticket_id':tid},headers={'X-CSRF-Token':'wrong'},timeout=20);check(bad.status_code==403,'incorrect mutation CSRF rejected')
s1.call('GET','soc/overview',expected=(403,));s1.page('AI Operations Center (AI SOC)/DatasetManagement.php',expected=(403,))
for path in ['soc/tickets/2147483647','soc/students/2147483647','data/datasets/2147483647','workbench/notebooks/2147483647','registry/models/2147483647']:
    admin.call('GET',path,expected=(403,404))
admin.call('POST',f'soc/tickets/{tid2}/assign',{'student_id':2147483647},expected=(404,422));admin.call('POST','soc/tickets',{},expected=(422,))
admin.call('POST','soc/datasets',{'code':'IT-BAD-'+tag,'name':'Invalid JSON'},files={'dataset_file':('bad.json',b'not json','application/json')},expected=(422,))
for path in ['AI Operations Center (AI SOC)/Dashboard.php','AI Operations Center (AI SOC)/OperationsDashboard.php','AI Operations Center (AI SOC)/StudentManagement.php','AI Operations Center (AI SOC)/TicketsAndScenarios.php','AI Operations Center (AI SOC)/DatasetManagement.php','AI Operations Center (AI SOC)/WorkspaceConfiguration.php','AI Operations Center (AI SOC)/StudentWorkspaces.php?student_id='+str(u1['id']),'AI Operations Center (AI SOC)/ModelManagement.php?student_id='+str(u1['id']),'AI Operations Center (AI SOC)/ValidationReports.php','AI Operations Center (AI SOC)/DeploymentRequests.php','AI Operations Center (AI SOC)/PlatformSettings.php','AI Operations Center (AI SOC)/AuditLogs.php']:
    admin.page(path)
s1.page('AI Project Management/Tickets.php',contains='Central assignment '+tag);s1.page('AI Project Management/Submissions.php',contains='Accepted saved deliverables');s1.page('ML Workbench/NotebookWorkbench.php?id='+str(nid),contains=code.splitlines()[0]);s1.page('Model Registry & Deployment/ModelRegistry.php',contains='Owned model metadata')
for path in ['tickets','datasets','notebooks','models','submissions','admin/overview']:
    admin.call('GET',path)
admin.call('POST',f'soc/scenarios/{sid}/archive',{});admin.call('PATCH',f'soc/models/{mid}',{'status':'ARCHIVED'});check(s1.call('GET',f'registry/models/{mid}')['status']=='ARCHIVED','admin model archive visible without deleting student artifact')
final=probe();relevant=[x for x in final['audit_actions'] if int(x['actor_id'] or 0) in [int(auth['id']),int(u1['id']),int(u2['id'])]];check(any(x['action']=='SUBMISSION_REVIEWED' for x in relevant),'real acting-user audit evidence recorded')
saved[initial['database']].update({'ticket_id':tid,'dataset_id':did,'notebook_id':nid,'model_id':mid,'scenario_id':sid,'submission_id':int(revision['id'])});private.write_text(json.dumps(saved,indent=2),encoding='utf-8')
out=ROOT/'verification/integration-20261030';out.mkdir(parents=True,exist_ok=True);(out/'http-coverage.json').write_text(json.dumps(coverage,indent=2),encoding='utf-8');(out/'http-observed-state.json').write_text(json.dumps(final,indent=2),encoding='utf-8')
print(f'PASS ALL {passed} central SOC HTTP/HTML checks on {initial["database"]}; existing data never reset.',flush=True)
