"""Verify truly empty student pages on the isolated localhost testing installation."""
from pathlib import Path
from urllib.parse import quote
import json, os, secrets, subprocess
import requests
ROOT=Path(__file__).resolve().parents[1]
probe=json.loads(subprocess.check_output([os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe'),str(ROOT/'tests/db_probe.php')],cwd=ROOT,text=True))
assert probe['environment']=='testing' and probe['database'].endswith('_test')
base='http://localhost/vostokpribor_AI'
credentials=json.loads((Path(os.environ['USERPROFILE'])/'.codex/backups/vostokpribor/browser-test-credentials.json').read_text(encoding='utf-8'))
def client():
    s=requests.Session(); token=s.get(base+'/api/v1/auth/csrf',timeout=20).json()['data']['csrf_token'];s.headers['X-CSRF-Token']=token;return s
def call(s,path,data):
    r=s.post(base+'/api/v1/'+path,json=data,timeout=20);assert r.status_code in (200,201),(path,r.status_code,r.text[:200]);d=r.json()['data']
    if isinstance(d,dict) and d.get('csrf_token'):s.headers['X-CSRF-Token']=d['csrf_token']
    return d
admin=client();call(admin,'auth/login',{'login':'admin','password':credentials['admin_password']})
tag=secrets.token_hex(6); password=secrets.token_urlsafe(24);identifier='EMPTY-'+tag
call(admin,'users',{'full_name':'Empty State Verification','email':tag+'@example.invalid','identifier':identifier,'password':password})
student=client();call(student,'auth/login',{'login':identifier,'password':password});call(student,'auth/change-password',{'current_password':password,'new_password':secrets.token_urlsafe(24)})
def counts():return json.loads(subprocess.check_output([os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe'),str(ROOT/'tests/db_probe.php')],cwd=ROOT,text=True))['counts']
before=counts()
pages={
 'AI Project Management/Dashboard.php':'No assigned tickets',
 'AI Project Management/Tickets.php':'No assigned tickets',
 'AI Project Management/Submissions.php':'No submissions',
 'AI Project Management/StudentProfile.php':'No notifications',
 'Data Center/dashboard.php':'No datasets',
 'Data Center/DatasetCatalog.php':'No datasets',
 'Data Center/MyDataSet.php':'No datasets',
 'Data Center/DataProfilingAndQuality.php':'No datasets',
 'Data Center/QueryWorkspace.php':'Query execution unavailable',
 'Data Center/RecentActivityAndAudit.php':'PASSWORD_CHANGED',
 'Data Center/UploadProcessedData.php':'No datasets',
 'ML Workbench/NotebookWorkbench.php':'No notebooks',
 'ML Workbench/ExperimentRuns.php':'No experiment runs',
 'ML Workbench/HyperparameterMatrix.php':'No experiment runs',
 'ML Workbench/MetricTelemetry.php':'No metrics available',
 'ML Workbench/ModelArtifacts.php':'No model artifacts',
 'ML Workbench/RangeEvaluation.php':'NOT EVALUATED',
 'ML Workbench/TensorInspector.php':'No runtime tensors',
 'Model Registry & Deployment/dashboard.php':'No models',
 'Model Registry & Deployment/ModelRegistry.php':'No models',
 'Model Registry & Deployment/ValidationPipeline.php':'No metrics available',
 'Model Registry & Deployment/ValidationReports.php':'No validation',
 'Model Registry & Deployment/DeploymentConfig.php':'Deployment unavailable',
 'Model Registry & Deployment/DeployedEndpoints.php':'No verified deployed endpoints'
}
passed=0
for path,expected in pages.items():
    r=student.get(base+'/'+quote(path,safe='/'),timeout=20)
    assert r.status_code==200,(path,r.status_code)
    assert expected.lower() in r.text.lower(),(path,'Expected empty state:',expected)
    assert not any(x in r.text for x in ['Application Error','Fatal error','Warning:','SCN-904-ALPHA','99.98%'])
    print('PASS empty HTML:',path,'->',expected,flush=True);passed+=1
after=counts()
# A separate browser scenario test may run concurrently; assert work-table stability.
tables=['notebooks','notebook_cells','models','model_versions','datasets','processed_datasets','deployment_requests','execution_jobs','submissions']
assert all(before[t]==after[t] for t in tables),'GET created work records'
print(f'PASS {passed} empty student pages; no GET creates work records on {probe["database"]}.')
