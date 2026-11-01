"""Real local HTTP code-exchange/ownership checks; no remote Google execution is claimed."""
from pathlib import Path
import json, os, secrets, subprocess
import requests
from http_test_target import preflight_cli_target, credential_file, credentials_for, initialize_session
ROOT=Path(__file__).resolve().parents[1]
GUARD=preflight_cli_target(ROOT); BASE=GUARD['base_url']; CREDS=credentials_for(credential_file(ROOT),GUARD['database'])
passed=0
def check(ok,label):
 global passed
 assert ok,label
 passed+=1;print('PASS '+label,flush=True)
class Client:
 def __init__(self):
  self.s=requests.Session(); self.token=initialize_session(self.s,BASE,GUARD)
 def call(self,method,path,body=None,files=None,status=(200,201)):
  r=self.s.request(method,BASE+'/api/v1/'+path,json=body if files is None else None,data=body if files else None,files=files,headers={'X-CSRF-Token':self.token},timeout=25)
  check(r.status_code in status,method+' '+path+' HTTP '+str(r.status_code))
  data=r.json().get('data')
  if isinstance(data,dict) and data.get('csrf_token'):self.token=data['csrf_token']
  return data
 def login(self,identifier,password):return self.call('POST','auth/login',{'login':identifier,'password':password})
admin=Client();admin.login('admin',CREDS['admin_password'])
student=Client();student.login('student_test',CREDS['role_student_test']['password'])
other=Client();other.login(CREDS['role_other_student']['identifier'],CREDS['role_other_student']['password'])
tag=secrets.token_hex(5);source='literal = "</textarea><script>text</script>"\nprint(2+2)\n# '+tag
nb=student.call('POST','workbench/notebooks',{'title':'Colab exchange '+tag,'cells':[{'cell_type':'code','source':source,'outputs':['forged success']}]});nid=int(nb['id'])
route=f'workbench/notebooks/{nid}/export'
r=student.s.get(BASE+'/api/v1/'+route,timeout=25);check(r.status_code==200,'authorized notebook export')
doc=r.json();check(doc['nbformat']==4 and doc['cells'][0]['source']==source,'actual saved code exported byte-for-byte')
check(doc['cells'][0]['outputs']==[] and doc['cells'][0]['execution_count'] is None,'export is code only, no claimed execution')
check('attachment;' in r.headers['Content-Disposition'] and '.ipynb' in r.headers['Content-Disposition'] and r.headers['Cache-Control']=='no-store','safe private attachment headers')
other.call('GET',route,status=(403,404));anonymous=requests.get(BASE+'/api/v1/'+route,timeout=25);check(anonymous.status_code==401,'anonymous export denied')
soc=admin.s.get(BASE+f'/api/v1/soc/notebooks/{nid}/export',timeout=25);check(soc.status_code==200 and soc.content==r.content,'SOC reads original notebook export')
student.call('GET',f'soc/notebooks/{nid}/export',status=(403,))
doc['metadata']={'foreign_owner':999,'provider_verified':True};doc['cells'][0]['outputs']=[{'output_type':'display_data','data':{'text/html':'<script>forged</script>'}}];doc['cells'][0]['execution_count']=900
payload=json.dumps(doc).encode()
imported=student.call('POST','workbench/notebooks/import',{'title':'Imported code '+tag},files={'notebook_file':('colab.ipynb',payload,'application/json')})
check(imported['id']!=nid and imported['student_id']==nb['student_id'],'import creates new original student-owned notebook')
saved=student.call('GET',f'workbench/notebooks/{imported["id"]}')
check(saved['cells'][0]['source']==source and not saved['cells'][0].get('output_json') and not saved['cells'][0].get('execution_count'),'reload persists literal code and discards untrusted output')
for filename,content in [('notebook.txt',payload),('bad.ipynb',b'{'),('version.ipynb',b'{"nbformat":3,"cells":[]}'),('oversize.ipynb',b'x'*(2097152+1))]:
 student.call('POST','workbench/notebooks/import',{'title':'Reject invalid import'},files={'notebook_file':(filename,content,'application/json')},status=(422,))
student.call('POST','workbench/notebooks/import',{'title':'Missing file'},status=(422,))
bad=student.s.post(BASE+'/api/v1/workbench/notebooks/import',data={'title':'Bad CSRF'},files={'notebook_file':('bad.ipynb',payload,'application/json')},headers={'X-CSRF-Token':'incorrect'},timeout=25);check(bad.status_code==403,'multipart import CSRF rejected')
admin.call('POST','workbench/notebooks/import',{'title':'Admin cannot author'},files={'notebook_file':('colab.ipynb',payload,'application/json')},status=(403,))
availability=student.call('GET','workbench/execution-status');check(availability['can_execute'] is False and availability['configuration_status']=='NOT_CONFIGURED','live execution unavailable without configured project')
check(not any(key in availability for key in ['credentials_file','access_token','runtime_password','project']),'student availability discloses no provider credentials/configuration')
student.call('GET','soc/execution-provider',status=(403,));inspection=admin.call('GET','soc/execution-provider');check(inspection['can_execute'] is False and inspection['dataset_transfer_enabled'] is False,'SOC correctly reports provider/data-transfer gates')
student.call('POST','execution-jobs',{'notebook_id':nid,'code_to_execute':source},status=(503,))
other.call('POST','execution-jobs',{'notebook_id':nid,'code_to_execute':source},status=(403,))
html=student.s.get(BASE+'/ML%20Workbench/NotebookWorkbench.php?id='+str(nid),timeout=25)
check(html.status_code==200 and 'Download for Colab' in html.text and 'Open Google Colab' in html.text and 'Import code only' in html.text,'existing workbench renders actual exchange controls')
check('https://colab.research.google.com/' in html.text and 'transfers no code or datasets automatically' in html.text,'manual external workflow explicitly explains data handling')
out=ROOT/'verification/v10-20261101';out.mkdir(parents=True,exist_ok=True)
(out/'colab-http.json').write_text(json.dumps({'database':GUARD['database'],'assertions':passed,'notebook_id':nid,'imported_notebook_id':int(imported['id']),'real_HTTP':True,'Google_network_requests':0,'provider_execution':'BLOCKED_NO_CLOUD_PROJECT','manual_outputs_trusted':False,'main_modified':False},indent=2))
print(f'PASS ALL {passed} actual local Colab code-exchange checks; no remote provider execution claimed.')
