"""Read-only contextual credential scan. Outputs locations/types/counts, never values."""
from pathlib import Path
import collections, json, re, subprocess

ROOT = Path(__file__).resolve().parents[2]
OUT = Path(__file__).with_name('data-secret-audit.json')
PATTERNS = {
    'private_key_material': re.compile(r'-----BEGIN (?:RSA |EC |OPENSSH |DSA )?PRIVATE KEY-----'),
    'aws_access_key': re.compile(r'\b(?:AKIA|ASIA)[A-Z0-9]{16}\b'),
    'github_access_token': re.compile(r'\b(?:gh[pousr]_[A-Za-z0-9]{30,255}|github_pat_[A-Za-z0-9_]{50,255})\b'),
    'google_api_key': re.compile(r'\bAIza[A-Za-z0-9_-]{35}\b'),
    'openai_api_key': re.compile(r'\bsk-(?:proj-|svcacct-)[A-Za-z0-9_-]{30,255}\b'),
    'legacy_api_key': re.compile(r'\bsk-[A-Za-z0-9]{40,64}\b'),
    'slack_access_token': re.compile(r'\bxox[baprs]-[A-Za-z0-9-]{20,255}\b'),
    'stripe_live_key': re.compile(r'\b(?:sk|rk)_live_[A-Za-z0-9]{20,255}\b'),
    'credential_connection_uri': re.compile(r'\b(?:mysql|postgres(?:ql)?|mongodb(?:\+srv)?|https?)://[^\s/:@]+:[^\s/@]{5,255}@'),
    'literal_bearer_or_jwt': re.compile(r'\bBearer\s+[A-Za-z0-9_.~-]{24,255}|\beyJ[A-Za-z0-9_-]{10,}\.[A-Za-z0-9_-]{10,}\.[A-Za-z0-9_-]{10,}\b'),
    'bcrypt_password_hash': re.compile(r'\$2[aby]\$\d\d\$[./A-Za-z0-9]{53}'),
    'credential_literal_candidate': re.compile(r'''(?i)(?:["']?(?:password|db_pass|client_secret|api_key|access_token|refresh_token|csrf_token|session_id)["']?\s*(?:=>|[:=])\s*["'])([^"'\r\n]{8,255})["']'''),
    'session_cookie_candidate': re.compile(r'(?i)\bPHPSESSID[=\s:]+["\']?([a-z0-9,-]{20,100})'),
}

def inspect(data, path):
    if b'\0' in data[:8192]:
        return [], 'binary_not_text'
    try:
        content = data.decode('utf-8-sig')
    except UnicodeDecodeError:
        try: content = data.decode('cp1251')
        except UnicodeDecodeError: return [], 'undecodable_not_text'
    findings=[]
    for line_number,line in enumerate(content.splitlines(),1):
        for category,pattern in PATTERNS.items():
            matches=list(pattern.finditer(line))
            if not matches: continue
            # These known scanner definitions and examples are patterns, not credentials.
            if path.endswith('masked_secret_audit.py'): continue
            findings.append({'path':path,'line':line_number,'type':category,'count':len(matches)})
        if Path(path).name.startswith('.env') and not line.strip().startswith('#') and '=' in line:
            key,value=line.split('=',1);key=key.strip();value=value.strip().strip('"\'')
            if re.search(r'(?i)(password|db_pass|secret|token|api_key|app_key)',key) and value and not key.endswith('_NAME'):
                findings.append({'path':path,'line':line_number,'type':'environment_sensitive_value','count':1,'variable':key})
    return findings,'text_scanned'

working=[];statuses=collections.Counter();files=0
for path in sorted(ROOT.rglob('*')):
    if not path.is_file() or '.git' in path.relative_to(ROOT).parts: continue
    if path == OUT: continue
    files+=1
    found,status=inspect(path.read_bytes(),path.relative_to(ROOT).as_posix())
    statuses[status]+=1;working.extend(found)

# Rev-list includes every reachable branch/tag/history object. Scan each blob once.
def git(*args): return subprocess.check_output(['git',*args],cwd=ROOT)
objects=[]
for line in git('rev-list','--objects','--all').decode().splitlines():
    oid,_,path=line.partition(' ')
    objects.append((oid,path))
batch=subprocess.Popen(['git','cat-file','--batch'],cwd=ROOT,stdin=subprocess.PIPE,stdout=subprocess.PIPE)
history=[];blob_count=0;blob_statuses=collections.Counter()
for oid,path in objects:
    batch.stdin.write((oid+'\n').encode());batch.stdin.flush()
    header=batch.stdout.readline().decode().split()
    if len(header)<3: continue
    kind=header[1];size=int(header[2]);data=batch.stdout.read(size);batch.stdout.read(1)
    if kind!='blob': continue
    blob_count+=1;found,status=inspect(data,path)
    blob_statuses[status]+=1
    for finding in found: finding['blob']=oid
    history.extend(found)
batch.stdin.close();batch.wait()
report={
    'result':'REVIEW_FINDINGS' if working or history else 'NO_KNOWN_PATTERN_MATCHES',
    'method':'All regular working-tree files including ignored environment/private paths; all reachable git blobs scanned once. Binary files inventory only; no secret snippets/values copied or printed. Contextual candidates require manual classification; this is not a guarantee that arbitrary unknown secrets are absent.',
    'working_tree':{'files':files,'statuses':dict(statuses),'findings':working},
    'git_history':{'reachable_objects':len(objects),'blobs':blob_count,'statuses':dict(blob_statuses),'findings':history},
    'rotation_plan':'Never rewrite history automatically. For any actual credential, revoke/rotate at its provider, invalidate old sessions, replace local environment value privately and remove tracked secret in a reviewed forward commit. Local testing fixtures are not production credentials; invalidate them before any exposure. Old password hashes/data dumps remain private and are excluded from source release.'
}
for scope in ['working_tree','git_history']:
    for finding in report[scope]['findings']:
        path=finding['path']
        if finding['type']=='bcrypt_password_hash':
            finding['classification']='sensitive_legacy_database_password_hash; source ZIP excludes old dump; verify whether any corresponding account/password is still used before deployment'
        elif finding['type']!='credential_literal_candidate':
            finding['classification']='high_confidence_pattern_requires_manual_review_and_rotation_if_actual; filename never exempts key material'
        elif path.startswith('tests/'):
            finding['classification']='synthetic_test_literal_or_retired_fixture; never authorize a nonlocal account with these values'
        elif path.endswith('.patch'):
            finding['classification']='code_patch_candidate; mirrors dynamic templates, route names, policy denylist and mocked test literals; no raw actual token found on review'
        elif path.endswith('StudentManagement.php'):
            finding['classification']='dynamic_CSRF_template_expression_or_historical_UI_configuration; no persisted credential value'
        elif path.endswith('modules/soc.php'):
            finding['classification']='route_to_resetPassword_handler_name; not an access credential'
        elif path.endswith('Services/UserService.php'):
            finding['classification']='weak_password_denylist_literal; not a configured account password'
        else:
            finding['classification']='manual_review_required'
env_path=ROOT/'.env'
if env_path.exists():
    env={}
    for line in env_path.read_text(encoding='utf-8-sig').splitlines():
        if '=' in line and not line.lstrip().startswith('#'):
            key,value=line.split('=',1);env[key.strip()]=value.strip().strip('"\'')
    report['local_environment_review']={
        'path':'.env','tracked':subprocess.run(['git','ls-files','--error-unmatch','.env'],cwd=ROOT,capture_output=True).returncode==0,
        'database_account_privileged':env.get('DB_USER','').lower() in ['root','admin'],
        'database_password_empty':not bool(env.get('DB_PASS','')),
        'remediation':'Loopback local test configuration only; production requires independent restricted DB credentials and current patched runtime. Values withheld; file unchanged.'
    }
OUT.write_text(json.dumps(report,indent=2),encoding='utf-8')
print(json.dumps({'working_tree_files':files,'working_tree_types':dict(collections.Counter(x['type'] for x in working)),'history_blobs':blob_count,'history_types':dict(collections.Counter(x['type'] for x in history)),'output':str(OUT)},indent=2))
