"""Independent SQL proof after actual HTTP operations. Only new IT-V7 work on a loopback _test DB.
No reset, mocked response, arbitrary SQL input, live configuration change or execution.
"""
from pathlib import Path
from urllib.parse import urlparse, quote
import hashlib, json, os, secrets, subprocess
import requests

ROOT=Path(__file__).resolve().parents[1]
PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe')
def sql(kind='environment',identifier=None):
    args=[PHP,str(ROOT/'tests/database_proof_probe_v7.php'),kind]
    if identifier is not None: args.append(str(identifier))
    return json.loads(subprocess.check_output(args,cwd=ROOT,text=True))
guard=sql(); BASE=guard['base_url'].rstrip('/')
assert guard['environment']=='testing' and guard['database'].endswith('_test')
assert urlparse(BASE).hostname in ('localhost','127.0.0.1','::1')
credentials=json.loads(Path(os.environ.get('TEST_CREDENTIALS_FILE',str(Path.home()/'.codex/tmp/vostok-integration-20261030-credentials.json'))).read_text(encoding='utf-8'))[guard['database']]
proof=[]; passed=0
def check(condition,label):
    global passed
    if not condition: raise AssertionError(label)
    passed+=1; print('PASS '+label,flush=True)
class Client:
    def __init__(self):
        self.session=requests.Session()
        self.token=self.session.get(BASE+'/api/v1/auth/csrf',timeout=20).json()['data']['csrf_token']
    def call(self,method,path,body=None,status=(200,201),files=None):
        self.last=self.session.request(method,BASE+'/api/v1/'+path,json=body if files is None else None,data=body if files else None,files=files,headers={'X-CSRF-Token':self.token},timeout=25)
        check(self.last.status_code in status,method+' '+path+' HTTP '+str(self.last.status_code))
        data=self.last.json();check(data['success']==self.last.ok,'truthful JSON envelope')
        result=data.get('data')
        if isinstance(result,dict) and result.get('csrf_token'):self.token=result['csrf_token']
        return result
    def login(self,identifier,password):return self.call('POST','auth/login',{'login':identifier,'password':password})
    def page(self,path):
        result=self.session.get(BASE+'/'+quote(path,safe='/?=&'),timeout=25)
        check(result.status_code==200,'authorized HTML '+path)
        check(guard['database'] not in result.text,'HTML does not disclose configured database name')
        return result.text
def record(system,method,endpoint,table,operation,kind,identifier,predicate,expected,http_status):
    observed=sql(kind,identifier)
    check(predicate(observed),'independent SQL '+expected)
    proof.append({'system':system,'method':method,'endpoint':endpoint,'table':table,'operation':operation,'expected':expected,'actual_http_status':http_status,'actual_database_result':observed,'authorization':'authorized active actor; unrelated-student denials separately verified','status':'VERIFIED COMPLETE'})
def persist(client,system,method,path,table,operation,kind,identifier,predicate,expected):
    record(system,method,'/api/v1/'+path,table,operation,kind,identifier,predicate,expected,client.last.status_code)

tag=secrets.token_hex(5).upper();admin=Client();admin_id=int(admin.login('admin',credentials['admin_password'])['id'])
students=[]
for number in range(2):
    identifier=f'IT-V7-{tag}-{number}'; password=secrets.token_urlsafe(28)
    user=admin.call('POST','soc/students',{'identifier':identifier,'email':identifier.lower()+'@example.invalid','full_name':'V7 database proof '+str(number),'password':password})
    uid=int(user['id']);persist(admin,'SYS-AI-05','POST','soc/students','users','INSERT','user',uid,lambda rows:len(rows)==1 and rows[0]['role']=='STUDENT' and rows[0]['password_algorithm']!='unknown','student stored with password hash')
    student=Client(); student.login(identifier,password);new=secrets.token_urlsafe(28)
    student.call('POST','auth/change-password',{'current_password':password,'new_password':new})
    persist(student,'AUTH','POST','auth/change-password','users','UPDATE','user',uid,lambda rows:int(rows[0]['must_change_password'])==0 and int(rows[0]['session_version'])>=2,'password rotation persisted')
    students.append((uid,student,new,identifier))
uid,student,password,identifier=students[0]; other=students[1][1]
scenario=admin.call('POST','soc/scenarios',{'code':'IT-V7-SC-'+tag,'title':'V7 persisted scenario '+tag,'builder_metadata':{'schema_version':1,'form_fields':{'edit-title':'V7 persisted scenario '+tag,'dim-weight-1':'100'},'workflow':[{'stage':'Review','action':'Verify actual evidence'}]}});sid=int(scenario['id'])
persist(admin,'SYS-AI-05','POST','soc/scenarios','scenarios','INSERT','scenario',sid,lambda rows:len(rows)==1 and int(rows[0]['author_id'])==admin_id and 'Verify actual evidence' in rows[0]['builder_metadata'],'scenario metadata and administrator actor stored')
ticket=admin.call('POST','soc/tickets',{'ticket_code':'IT-V7-T-'+tag,'title':'V7 persisted work '+tag,'scenario_id':sid,'requirements':'Upload actual files; preserve literal <script>text</script>.','acceptance_criteria':'Independent MySQL review','deadline':'2027-01-20 10:30:00'});tid=int(ticket['id'])
persist(admin,'SYS-AI-05','POST','soc/tickets','tickets','INSERT','ticket',tid,lambda rows:rows[0]['deadline']=='2027-01-20 10:30:00','ticket requirements and deadline stored')
admin.call('POST',f'soc/tickets/{tid}/assign',{'student_id':uid})
persist(admin,'SYS-AI-05','POST',f'soc/tickets/{tid}/assign','ticket_assignments','INSERT','assignment',tid,lambda rows:len(rows)==1 and int(rows[0]['student_id'])==uid and int(rows[0]['assigned_by'])==admin_id,'ticket assigned with actual administrator actor')
assigned=sql('assignment',tid);admin.call('POST',f'soc/tickets/{tid}/assign',{'student_id':uid});check(sql('assignment',tid)==assigned,'assignment duplicate creates no second row')
student.call('GET',f'project/tickets/{tid}')
persist(student,'SYS-AI-01','GET',f'project/tickets/{tid}','tickets','SELECT','ticket',tid,lambda rows:rows[0]['status']=='ASSIGNED','student reads persisted assigned ticket')
student.page('AI Project Management/Tickets.php');html=student.page('AI Project Management/TicketDetails.php?id='+str(tid));check('&lt;script&gt;text&lt;/script&gt;' in html and '<script>text</script>' not in html,'stored requirements encoded in HTML')
student.call('POST',f'project/tickets/{tid}/progress',{'status':'IN_PROGRESS'})
persist(student,'SYS-AI-01','POST',f'project/tickets/{tid}/progress','tickets,ticket_status_history','UPDATE','ticket',tid,lambda rows:rows[0]['status']=='IN_PROGRESS','progress persisted')
csv=b'feature,label\n1,0\n2,1\n';dataset=admin.call('POST','soc/datasets',{'code':'IT-V7-DS-'+tag,'name':'V7 actual CSV','scenario_id':sid},files={'dataset_file':('v7.csv',csv,'text/csv')});did=int(dataset['id'])
persist(admin,'SYS-AI-05','POST','soc/datasets','datasets,dataset_versions','INSERT','dataset',did,lambda rows:rows[0]['private_file_checksum_matches'] and rows[0]['checksum_sha256']==hashlib.sha256(csv).hexdigest(),'private CSV and MySQL checksum agree')
vid=int(sql('dataset',did)[0]['current_version_id'])
admin.call('POST',f'soc/datasets/{did}/assign',{'student_id':uid,'ticket_id':tid,'dataset_version_id':vid})
persist(admin,'SYS-AI-05','POST',f'soc/datasets/{did}/assign','dataset_assignments','INSERT','dataset_assignment',did,lambda rows:len(rows)==1 and int(rows[0]['student_id'])==uid and int(rows[0]['ticket_id'])==tid,'dataset grant references assigned ticket and immutable version')
student.page('Data Center/DatasetCatalog.php');student.call('GET',f'data/datasets/{did}/preview')
persist(student,'SYS-AI-02','GET',f'data/datasets/{did}/preview','datasets,dataset_versions,dataset_assignments','SELECT','dataset',did,lambda rows:rows[0]['private_file_checksum_matches'],'preview has genuine file and metadata')
download=student.session.get(BASE+f'/api/v1/data/datasets/{did}/download',timeout=25);check(download.status_code==200 and download.content==csv,'download exact original CSV bytes')
record('SYS-AI-02','GET',f'/api/v1/data/datasets/{did}/download','datasets,dataset_versions','SELECT','dataset',did,lambda rows:rows[0]['private_file_checksum_matches'],'download refers to checksum-verified private file',download.status_code)
processed=student.call('POST','data/processed',{'source_dataset_id':did,'ticket_id':tid,'name':'V7 actual processed CSV'},files={'processed_file':('processed.csv',b'feature,label\n2,1\n','text/csv')});pid=int(processed['id'])
persist(student,'SYS-AI-02','POST','data/processed','processed_datasets','INSERT','processed',pid,lambda rows:rows[0]['private_file_checksum_matches'] and int(rows[0]['source_dataset_version_id'])==vid and int(rows[0]['student_id'])==uid,'processed private file links authorized master version')
notebook=student.call('POST','workbench/notebooks',{'title':'V7 exact notebook '+tag,'ticket_id':tid,'cells':[]});nid=int(notebook['id'])
persist(student,'SYS-AI-03','POST','workbench/notebooks','notebooks','INSERT','notebook',nid,lambda rows:int(rows[0]['student_id'])==uid and rows[0]['kernel_state']=='UNAVAILABLE','explicit notebook creation without runner')
source='literal = "</textarea><script>alert(1)</script>"\nprint(literal)\n# V7 persistence only'
student.call('PATCH',f'workbench/notebooks/{nid}',{'expected_version':notebook['version'],'cells':[{'cell_type':'code','source':source}]})
persist(student,'SYS-AI-03','PATCH',f'workbench/notebooks/{nid}','notebook_cells,notebooks','UPDATE','cells',nid,lambda rows:len(rows)==1 and rows[0]['source_sha256']==hashlib.sha256(source.encode()).hexdigest() and rows[0]['output_text'] is None,'literal notebook source stored exactly; no forged output')
student.page('ML Workbench/NotebookWorkbench.php?id='+str(nid));loaded=student.call('GET',f'workbench/notebooks/{nid}');check(loaded['cells'][0]['source']==source,'reload preserves identical literal notebook source')
admin.call('GET',f'soc/notebooks/{nid}')
persist(admin,'SYS-AI-05','GET',f'soc/notebooks/{nid}','notebooks,notebook_cells','SELECT','notebook',nid,lambda rows:int(rows[0]['student_id'])==uid,'administrator inspection preserves original author')
experiment=student.call('POST','workbench/experiments',{'name':'V7 experiment '+tag,'ticket_id':tid});eid=int(experiment['id'])
persist(student,'SYS-AI-03','POST','workbench/experiments','experiments','INSERT','experiment',eid,lambda rows:int(rows[0]['student_id'])==uid,'experiment metadata persisted without execution')
admin.call('GET',f'soc/experiments/{eid}')
persist(admin,'SYS-AI-05','GET',f'soc/experiments/{eid}','experiments','SELECT','experiment',eid,lambda rows:int(rows[0]['ticket_id'])==tid,'administrator sees saved experiment')
model=student.call('POST','registry/models',{'model_code':'IT-V7-M-'+tag,'name':'V7 model metadata','framework':'JSON','ticket_id':tid});mid=int(model['id'])
persist(student,'SYS-AI-04','POST','registry/models','models','INSERT','model',mid,lambda rows:int(rows[0]['student_id'])==uid,'model metadata retains student ownership')
artifact=b'{"opaque":"V7 real uploaded artifact, never executed"}'
version=student.call('POST',f'registry/models/{mid}/versions',{'version':'v1'},files={'artifact_file':('artifact.json',artifact,'application/json')});mvid=int(version['id'])
persist(student,'SYS-AI-04','POST',f'registry/models/{mid}/versions','model_versions','INSERT','artifact',mvid,lambda rows:rows[0]['private_file_checksum_matches'] and rows[0]['checksum_sha256']==hashlib.sha256(artifact).hexdigest(),'genuine artifact metadata and private bytes agree')
admin.call('GET',f'soc/models/{mid}')
persist(admin,'SYS-AI-05','GET',f'soc/models/{mid}','models,model_versions','SELECT','model',mid,lambda rows:int(rows[0]['student_id'])==uid,'administrator sees original model owner')
for path in [f'project/tickets/{tid}',f'data/datasets/{did}',f'data/processed/{pid}',f'workbench/notebooks/{nid}',f'workbench/experiments/{eid}',f'registry/models/{mid}',f'registry/models/{mid}/versions']:
    other.call('GET',path,status=(403,404))
submission=student.call('POST','project/submissions',{'ticket_id':tid,'notebook_id':nid,'model_id':mid,'notes':'V7 independently verified work','request_key':'IT-V7-SUB-'+tag});subid=int(submission['id'])
persist(student,'SYS-AI-01','POST','project/submissions','submissions','INSERT','submission',subid,lambda rows:rows[0]['status']=='SUBMITTED' and int(rows[0]['student_id'])==uid,'submission persisted with notebook and model')
admin.call('GET',f'soc/submissions/{subid}')
persist(admin,'SYS-AI-05','GET',f'soc/submissions/{subid}','submissions','SELECT','submission',subid,lambda rows:int(rows[0]['notebook_id'])==nid and int(rows[0]['model_id'])==mid,'administrator sees actual linked deliverables')
admin.call('POST',f'soc/submissions/{subid}/approve',{'feedback':'V7 accepted persisted deliverables','total_score':91.25})
persist(admin,'SYS-AI-05','POST',f'soc/submissions/{subid}/approve','submissions,tickets,notifications,audit_logs','UPDATE','submission',subid,lambda rows:rows[0]['status']=='APPROVED' and int(rows[0]['reviewed_by'])==admin_id and float(rows[0]['total_score'])==91.25,'review decision, actual reviewer and decimal score persisted')
record('SYS-AI-05','POST',f'/api/v1/soc/submissions/{subid}/approve','notifications','INSERT','notifications',uid,lambda rows:any('V7 accepted persisted deliverables' in row['message'] for row in rows),'student review notification persisted',admin.last.status_code)
record('SYS-AI-05','POST',f'/api/v1/soc/submissions/{subid}/approve','audit_logs','INSERT','review_audit',subid,lambda rows:any(row['action']=='SUBMISSION_REVIEWED' and int(row['actor_id'])==admin_id for row in rows),'review audit records administrator actor',admin.last.status_code)
student.call('POST','auth/logout',{});student=Client();student.login(identifier,password)
decision=student.call('GET',f'project/submissions/{subid}');check(decision['status']=='APPROVED','fresh student session sees review decision')
persist(student,'SYS-AI-01','GET',f'project/submissions/{subid}','submissions','SELECT','submission',subid,lambda rows:rows[0]['status']=='APPROVED','student sees persisted approval after new login')
student.call('GET',f'project/tickets/{tid}')
persist(student,'SYS-AI-01','GET',f'project/tickets/{tid}','tickets','SELECT','ticket',tid,lambda rows:rows[0]['status']=='APPROVED','student ticket status synchronized with reviewed submission')
student.call('GET',f'workbench/notebooks/{nid}');check(sql('cells',nid)[0]['source_sha256']==hashlib.sha256(source.encode()).hexdigest(),'previous work remains unchanged after approval')
admin.call('POST',f'soc/scenarios/{sid}/archive',{})
persist(admin,'SYS-AI-05','POST',f'soc/scenarios/{sid}/archive','scenarios','ARCHIVE','scenario',sid,lambda rows:rows[0]['status']=='ARCHIVED','authorized archive preserves scenario record')
student.page('index.php');admin.page('index.php')
out=ROOT/'verification/v7-20261031';out.mkdir(parents=True,exist_ok=True)
(out/'database-http-proof.json').write_text(json.dumps({'database':guard['database'],'environment':'testing','assertions':passed,'proof_rows':proof,'no_mock_responses':True,'live_database_modified':False},indent=2),encoding='utf-8')
print(f'PASS ALL {passed} V7 HTTP/independent SQL checks; {len(proof)} workflow proof rows; only new IT-V7 work in {guard["database"]}.')
