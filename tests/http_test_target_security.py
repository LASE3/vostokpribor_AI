"""Test pre-write target/credential guards without contacting application endpoints."""
from pathlib import Path
import os,tempfile
from unittest.mock import patch
from http_test_target import guarded_target,credential_file
passed=0
valid={'environment':'testing','database':'isolated_test','app_url':'http://127.0.0.1/isolated-range','cookie':'isolated_session_test'}
def check(value,label):
 global passed
 if not value:raise AssertionError(label)
 passed+=1;print('PASS '+label)
def refused(probe,env=None):
 with patch.dict(os.environ,env or {},clear=True):
  try:guarded_target(probe)
  except SystemExit:return True
 return False
with patch.dict(os.environ,{},clear=True):check(guarded_target(valid)==valid['app_url'],'Derives HTTP target from guarded CLI configuration')
for key,value in [('environment','production'),('environment','local'),('database','existing_live'),('cookie','shared_session'),('app_url','https://untrusted.invalid/range'),('app_url','http://admin:secret@localhost/range'),('app_url','http://localhost/range?redirect=1'),('app_url','http://localhost/range#fragment'),('app_url','ftp://localhost/range')]:
 check(refused(valid|{key:value}),'Refuses unsafe target field '+key+' case '+str(passed))
check(refused(valid,{'TEST_BASE_URL':'http://localhost/different-install'}),'A second localhost installation cannot override the configured test target')
with patch.dict(os.environ,{'TEST_CREDENTIALS_FILE':str(Path(__file__).parent/'local-secrets.json')},clear=True):
 try:credential_file(Path(__file__).resolve().parents[1]);denied=False
 except SystemExit:denied=True
 check(denied,'Credentials inside source are refused')
with tempfile.TemporaryDirectory() as folder:
 with patch.dict(os.environ,{'TEST_CREDENTIALS_FILE':str(Path(folder)/'credentials.json')},clear=True):check(credential_file(Path(__file__).resolve().parents[1])==Path(folder).resolve()/'credentials.json','External private credential location is accepted')
print(f'PASS ALL {passed} test-target safety assertions; no network requests or database changes.')
