"""Supplementary real HTTP coverage for successful SOC decisions and compatibility paths.
Requires a loopback testing snapshot with APP_ENV=testing and a *_test database.
No data reset, credential reset, deletion, runner execution, or production access.
"""
from pathlib import Path
from urllib.parse import urlparse
import json, os, secrets, subprocess, re
import requests
ROOT=Path(__file__).resolve().parents[1]
PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
def probe(mode='state',arg=None):
    cmd=[PHP,str(ROOT/'tests/integration_probe.php'),mode]
    if arg is not None:cmd.append(str(arg))
    return json.loads(subprocess.check_output(cmd,cwd=ROOT,text=True))
initial=probe()
if initial['environment']!='testing' or not initial['database'].endswith('_test'):raise SystemExit('REFUSED: dedicated testing snapshot required.')
BASE=os.environ.get('TEST_BASE_URL','').rstrip('/')
if urlparse(BASE).hostname not in ['localhost','127.0.0.1','::1']:raise SystemExit('REFUSED: explicit loopback TEST_BASE_URL required.')
private=Path(os.environ.get('USERPROFILE',str(Path.home())))/'.codex/tmp/vostok-integration-20261030-credentials.json'
password=json.loads(private.read_text(encoding='utf-8'))[initial['database']]['admin_password']
passed=0;coverage=[]
def check(ok,label):
    global passed
    if not ok:raise AssertionError(label)
    passed+=1;print('PASS '+label,flush=True)
class Client:
    def __init__(self):
        self.s=requests.Session()
        r=self.s.get(BASE+'/api/v1/auth/csrf',timeout=20)
        coverage.append({'method':'GET','path':'auth/csrf','status':r.status_code})
        check(r.status_code==200,'CSRF token HTTP200');self.token=r.json()['data']['csrf_token']
    def call(self,method,path,body=None,expected=(200,201),files=None):
        r=self.s.request(method,BASE+'/api/v1/'+path,json=body if files is None else None,data=body if files else None,files=files,headers={'X-CSRF-Token':self.token},timeout=30)
        coverage.append({'method':method,'path':path,'status':r.status_code})
        check(r.status_code in expected,method+' '+path+' HTTP '+str(r.status_code)+((' '+r.text[:250]) if r.status_code not in expected else ''))
        result=r.json();check(isinstance(result.get('success'),bool),'JSON envelope '+method+' '+path)
        d=result.get('data')
        if isinstance(d,dict) and d.get('csrf_token'):self.token=d['csrf_token']
        return d if r.ok else result
    def download(self,path,expected):
        r=self.s.get(BASE+'/api/v1/'+path,timeout=30)
        coverage.append({'method':'GET','path':path,'status':r.status_code})
        check(r.status_code==200 and r.content==expected,'authorized binary '+path+' equals uploaded bytes')
        check('attachment' in r.headers.get('Content-Disposition',''),'private download attachment '+path)
        return r
admin=Client();admin.call('POST','auth/login',{'login':'admin','password':password});admin.call('GET','auth/me')
tag=secrets.token_hex(6).upper();ident='IT-EXTRA-'+tag;pw=secrets.token_urlsafe(24)
user=admin.call('POST','users',{'identifier':ident,'full_name':'Supplementary HTTP student','email':ident.lower()+'@example.invalid','password':pw})
uid=int(user['id']);admin.call('PATCH','users/'+str(uid),{'department':'Supplementary coverage'})
check(admin.call('GET','users/'+str(uid))['profile']['department']=='Supplementary coverage','legacy user edit maps to shared student record')
student=Client();student.call('POST','auth/login',{'login':ident,'password':pw});new=secrets.token_urlsafe(24);student.call('POST','auth/change-password',{'current_password':pw,'new_password':new});student.call('GET','auth/me')
sc=admin.call('POST','scenarios',{'code':'EXTRA-SC-'+tag,'title':'Supplementary scenario'})
sid=int(sc['id']);admin.call('PATCH','scenarios/'+str(sid),{'description':'Persisted compatibility edit'});admin.call('GET','scenarios/'+str(sid))
t=admin.call('POST','tickets',{'ticket_code':'EXTRA-T-'+tag,'title':'Supplementary rejected revision work','scenario_id':sid,'requirements':'Save actual files and exact code','acceptance_criteria':'Review demonstrates rejection and revision'})
tid=int(t['id']);admin.call('PATCH','tickets/'+str(tid),{'deadline':'2027-01-12 10:12:23'})
admin.call('POST','tickets/'+str(tid)+'/assignments',{'student_id':uid})
check(student.call('GET','tickets/'+str(tid))['deadline']=='2027-01-12 10:12:23','legacy ticket metadata persists exact deadline seconds')
student.call('POST','project/tickets/'+str(tid)+'/progress',{'status':'IN_PROGRESS'})
student.call('POST','tickets/'+str(tid)+'/comments',{'comment':'Actual legacy comment'})
check(any(x['comment']=='Actual legacy comment' for x in student.call('GET','tickets/'+str(tid)+'/comments')),'legacy comment visible in shared discussion')
csv=b'feature,label\n1,0\n2,1\n'
ds=admin.call('POST','datasets',{'code':'EXTRA-DS-'+tag,'name':'Supplementary genuine file','scenario_id':sid},files={'dataset_file':('extra.csv',csv,'text/csv')})
did=int(ds['id']);versions=admin.call('GET','datasets/'+str(did)+'/versions');dv=int(versions[0]['id'])
admin.call('POST','datasets/'+str(did)+'/assignments',{'student_id':uid,'ticket_id':tid,'dataset_version_id':dv})
for path in ['datasets/'+str(did),'datasets/'+str(did)+'/preview','datasets/'+str(did)+'/versions','data/datasets/'+str(did)]:
    student.call('GET',path)
for path in ['soc/datasets/'+str(did),'soc/datasets/'+str(did)+'/activity','soc/datasets/'+str(did)+'/preview']:
    admin.call('GET',path)
student.download('datasets/'+str(did)+'/download',csv);student.download('data/datasets/'+str(did)+'/download',csv);admin.download('soc/datasets/'+str(did)+'/download',csv)
processed_bytes=b'feature,label\n2,1\n'
processed=student.call('POST','datasets/processed',{'source_dataset_id':did,'ticket_id':tid,'name':'Supplementary transformed file','transformation_notes':'Selected row2'},files={'processed_file':('processed.csv',processed_bytes,'text/csv')})
pid=int(processed['id']);student.download('data/processed/'+str(pid)+'/download',processed_bytes)
nb=student.call('POST','notebooks',{'title':'Supplementary exact code','ticket_id':tid,'cells':[]});nid=int(nb['id'])
source='value = 17\n# supplementary HTTP save, never execute'
student.call('PATCH','notebooks/'+str(nid),{'cells':[{'cell_type':'code','source':source}]})
check(student.call('GET','notebooks/'+str(nid))['cells'][0]['source']==source,'legacy notebook save reload matches exact source')
exp=student.call('POST','experiments',{'name':'Supplementary experiment','ticket_id':tid});eid=int(exp['id'])
student.call('GET','experiments/'+str(eid));admin.call('GET','soc/experiments/'+str(eid))
student.call('POST','experiment-runs',{'experiment_id':eid,'notebook_id':nid,'run_name':'Recorded metadata only','metrics':{'accuracy':1}})
runs=student.call('GET','experiment-runs?experiment_id='+str(eid));check(runs and runs[0]['status']=='RECORDED','legacy run save does not assert actual execution')
model=student.call('POST','models',{'model_code':'EXTRA-M-'+tag,'name':'Supplementary model','framework':'JSON','ticket_id':tid})
mid=int(model['id']);student.call('GET','models/'+str(mid))
artifact=student.call('POST','models/'+str(mid)+'/versions',{'version':'v1','metrics':json.dumps({'accuracy':1.0})},files={'artifact_file':('opaque.json',b'{"opaque_test_artifact":true}','application/json')})
mv=int(artifact['id']);student.call('GET','models/'+str(mid)+'/versions');admin.call('GET','soc/models/'+str(mid)+'/versions')
val=student.call('POST','validation-runs',{'model_id':mid,'model_version_id':mv});valid=int(val['id'])
check(val['status']=='NOT_EVALUATED' and val['score'] is None,'legacy validation cannot certify perfect student metrics')
for path in ['registry/validations/'+str(valid),'validation-runs/'+str(valid)]:student.call('GET',path)
admin.call('GET','soc/validations/'+str(valid))
req=student.call('POST','deployment-requests',{'model_id':mid,'model_version_id':mv,'idempotency_key':'EXTRA-REJECT-'+tag})
rid=int(req['id']);notes='Rejected desired configuration; no inference provider deployed.'
reviewed=admin.call('POST','soc/deployment-requests/'+str(rid)+'/reject',{'notes':notes})
check(reviewed['status']=='REJECTED' and reviewed['deployed'] is False and reviewed['endpoint_url'] is None,'SOC deployment reject persists administrative state without deployment claim')
before_notifications=student.call('GET','project/notifications')
state=probe();before_events=len([a for a in state['audit_actions'] if a['action']=='DEPLOYMENT_REQUEST_REVIEWED' and a['resource_id']==str(rid)])
admin.call('POST','soc/deployment-requests/'+str(rid)+'/reject',{'notes':notes})
check(len(student.call('GET','project/notifications'))==len(before_notifications),'deployment reject retry creates no duplicate notification')
state=probe();check(len([a for a in state['audit_actions'] if a['action']=='DEPLOYMENT_REQUEST_REVIEWED' and a['resource_id']==str(rid)])==before_events,'deployment reject retry creates no duplicate audit')
req2=student.call('POST','registry/deployment-requests',{'model_id':mid,'model_version_id':mv,'environment':'staging','idempotency_key':'EXTRA-PATCH-'+tag})
patch=admin.call('PATCH','soc/deployment-requests/'+str(req2['id']),{'status':'REJECTED','notes':'Rejected through narrowly scoped PATCH'})
check(patch['status']=='REJECTED' and patch['endpoint_url'] is None,'SOC deployment PATCH records rejection only')
req3=student.call('POST','registry/deployment-requests',{'model_id':mid,'model_version_id':mv,'environment':'production','idempotency_key':'EXTRA-LEGACY-'+tag})
admin.call('PATCH','deployments/'+str(req3['id']),{'status':'APPROVED','notes':'Administrative approval only'})
check(any(int(x['id'])==int(req3['id']) and x['status']=='APPROVED' and x['endpoint_url'] is None for x in student.call('GET','registry/deployment-requests')),'legacy deployment approval remains separate from serving')
sub=student.call('POST','submissions',{'ticket_id':tid,'notebook_id':nid,'model_id':mid,'notes':'Initial work to reject','request_key':'EXTRA-SUB1-'+tag});subid=int(sub['id'])
student.call('GET','submissions/'+str(subid));student.call('GET','project/submissions/'+str(subid));admin.call('GET','soc/submissions/'+str(subid))
review=admin.call('POST','soc/submissions/'+str(subid)+'/reject',{'feedback':'Rejection requires a revised explanation','total_score':44.25})
check(review['status']=='REJECTED' and int(review['reviewed_by'])==int(admin.call('GET','auth/me')['id']),'SOC rejection stores actual administrator reviewer')
check(student.call('GET','project/tickets/'+str(tid))['status']=='CHANGES_REQUESTED' and student.call('GET','project/submissions/'+str(subid))['feedback']=='Rejection requires a revised explanation','SOC rejection visible to student with revision-permitted ticket state')
notifs=student.call('GET','project/notifications')
admin.call('POST','soc/submissions/'+str(subid)+'/reject',{'feedback':'Rejection requires a revised explanation','total_score':44.25})
check(len(student.call('GET','project/notifications'))==len(notifs),'submission reject retry is notification-idempotent')
student.call('POST','project/tickets/'+str(tid)+'/progress',{})
sub2=student.call('POST','project/submissions',{'ticket_id':tid,'notes':'First revised explanation','request_key':'EXTRA-SUB2-'+tag})
admin.call('POST','submissions/'+str(sub2['id'])+'/review',{'status':'CHANGES_REQUESTED','feedback':'One more revision','total_score':65.75})
student.call('POST','project/tickets/'+str(tid)+'/progress',{})
sub3=student.call('POST','submissions',{'ticket_id':tid,'notes':'Final revised explanation','request_key':'EXTRA-SUB3-'+tag})
admin.call('POST','submissions/'+str(sub3['id'])+'/review',{'status':'APPROVED','feedback':'Approved revised work','total_score':93.5})
check(student.call('GET','tickets/'+str(tid))['status']=='APPROVED','revision after rejection reaches approved ticket through shared legacy service')
observed=probe();mine=[s for s in observed['submissions'] if int(s['ticket_id'])==tid]
check([s['status'] for s in mine]==['REJECTED','CHANGES_REQUESTED','APPROVED'] and [float(s['total_score']) for s in mine]==[44.25,65.75,93.5],'MySQL stores all rejection/revision decisions and exact fractional scores')
uuid=probe('queue',nid)['uuid'];student.call('GET','execution-jobs/'+uuid);student.call('POST','execution-jobs/'+uuid+'/cancel',{})
check(student.call('GET','execution-jobs/'+uuid)['status']=='CANCELLED','legacy job cancellation persists existing isolated test state without running code')
student.call('POST','execution-jobs',{'notebook_id':nid,'code_to_execute':'raise Exception("must never run")'},expected=(503,))
for path in ['project/tickets','project/submissions','data/datasets','workbench/notebooks','workbench/experiments','workbench/artifacts','workbench/execution-status','registry/models','registry/validations','validation-runs','registry/deployments','deployments','deployment-requests','experiments','models']:
    student.call('GET',path)
for path in ['users','scenarios','soc/students','soc/tickets','soc/tickets/'+str(tid),'soc/scenarios','soc/submissions','soc/datasets','admin/audit-logs','admin/settings']:
    admin.call('GET',path)
admin.call('PATCH','admin/settings',{'key':'student_help_text','value':'Supplementary HTTP guidance '+tag})
check(any(x['setting_value']=='Supplementary HTTP guidance '+tag for x in student.call('GET','project/dashboard')['guidance']),'legacy setting update visible in student dashboard guidance')
student.call('GET','users/'+str(uid))
student.call('POST','auth/logout',{})
student.call('GET','auth/me',expected=(401,))
inventory_path=ROOT/'verification/integration-20261030/api-route-inventory.json'
if inventory_path.exists():
    routes=json.loads(inventory_path.read_text(encoding='utf-8-sig'))
    for item in coverage:
        route=next((r for r in routes if r['method']==item['method'] and re.fullmatch(re.escape(r['path']).replace(r'\{id\}',r'[^/]+'),item['path'].split('?')[0])),None)
        item['route']=route['path'] if route else None
out=ROOT/'verification/integration-20261030';out.mkdir(parents=True,exist_ok=True)
(out/'main-http-extra-coverage.json').write_text(json.dumps(coverage,indent=2),encoding='utf-8')
(out/'main-http-extra-state.json').write_text(json.dumps({'database':initial['database'],'student_id':uid,'ticket_id':tid,'model_id':mid,'submission_ids':[subid,int(sub2['id']),int(sub3['id'])],'request_ids':[rid,int(req2['id']),int(req3['id'])],'submissions':mine,'expected_runtime':'UNAVAILABLE'},indent=2),encoding='utf-8')
print('PASS ALL '+str(passed)+' supplementary real HTTP assertions on '+initial['database']+'; unique test work only, no existing records reset.',flush=True)
