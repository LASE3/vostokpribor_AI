"""Storage guard refusal/identity tests. No database connection or real upload mutation."""
from pathlib import Path
import json, os, subprocess, tempfile, shutil

ROOT=Path(__file__).resolve().parents[1];PHP=os.environ.get('PHP_BINARY',r'C:\xampp\php\php.exe');checks=0
def check(ok,label):
    global checks
    assert ok,label
    checks+=1;print('PASS '+label)
for name in ['dataset_lifecycle','model_integrity','workspace_integration','backend_concurrency']:
    env=os.environ.copy();env.update(APP_ENV='testing',DB_NAME='v9_storage_mismatched_identity_test',APP_URL='http://127.0.0.1/not-served',SESSION_COOKIE_NAME='v9_storage_other_test')
    result=subprocess.run([PHP,str(ROOT/'tests'/f'{name}.php')],env=env,cwd=ROOT,capture_output=True,text=True)
    check(result.returncode!=0 and 'TestStorage.php' in result.stdout+result.stderr,name+' refuses environment-only database/storage switch before work')
with tempfile.TemporaryDirectory(prefix='vostok_v9_storage_guard_') as directory:
    target=Path(directory).resolve();assert target.parent==Path(tempfile.gettempdir()).resolve() and target.name.startswith('vostok_v9_storage_guard_')
    (target/'tests').mkdir();shutil.copy2(ROOT/'tests/TestStorage.php',target/'tests/TestStorage.php')
    for folder in ['datasets','models','sandboxes']:(target/'storage/private'/folder).mkdir(parents=True)
    env=os.environ.copy()
    for key in ['APP_ENV','DB_NAME','DB_HOST','APP_URL','SESSION_COOKIE_NAME']:env.pop(key,None)
    code='require $argv[1]; App\\Core\\Env::load($argv[2]."/.env"); require $argv[2]."/tests/TestStorage.php"; testRequireIsolatedStorage($argv[3]==="prepare");'
    def run(mode='check'):
        return subprocess.run([PHP,'-r',code,str(ROOT/'app/Core/Env.php'),str(target),mode],env=env,capture_output=True,text=True)
    result=run();check(result.returncode!=0 and 'saved isolated testing configuration' in result.stderr,'Missing saved test configuration is refused')
    config='APP_ENV=testing\nDB_NAME=v9_storage_guard_test\nDB_HOST=127.0.0.1\nAPP_URL=http://127.0.0.1/not-served\nSESSION_COOKIE_NAME=v9_storage_guard_test\n'
    (target/'.env').write_text(config,encoding='utf-8')
    result=run();check(result.returncode!=0 and 'prepare a separate empty' in result.stderr,'No implicit storage identity is created by a test')
    sentinel=target/'storage/private/datasets/retained.csv';sentinel.write_bytes(b'private sentinel\n')
    result=run('prepare');check(result.returncode!=0 and sentinel.read_bytes()==b'private sentinel\n' and not (target/'.vostok-test-storage').exists(),'Preparation refuses existing payloads without deleting them')
    sentinel.unlink()  # Only this test-created sentinel inside the verified OS temporary root.
    result=run('prepare');check(result.returncode==0 and (target/'.vostok-test-storage').is_file(),'Empty isolated tree can be prepared explicitly')
    check(run().returncode==0,'Prepared identity accepts its exact saved test instance')
    identity=json.loads((target/'.vostok-test-storage').read_text());identity['database']='another_test';(target/'.vostok-test-storage').write_text(json.dumps(identity))
    check(run().returncode!=0,'A marker from another database cannot enable file writes')
print(f'PASS ALL {checks} storage-isolation guard assertions; no database connections or original uploads touched.')
