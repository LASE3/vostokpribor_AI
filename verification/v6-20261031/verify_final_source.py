"""Final read-only source/design proof. Run only after the root's final-hook-ready signal.

python verification/v6-20261031/verify_final_source.py --ready
No application database is opened, no source/private files are changed, no ZIP is built.
Only verification evidence is written. The existing contract suite also refreshes
its standard verification/integration-20261030/api-route-inventory.json output.
"""
from pathlib import Path
import argparse, collections, hashlib, importlib.util, json, os, re, subprocess, sys
from datetime import datetime, timezone

ROOT=Path(__file__).resolve().parents[2]
OUT=Path(__file__).resolve().parent
BASELINE='0b8cd08'
PHP='C:/xampp/php/php.exe'
SOURCE_EXTENSIONS={'.php','.js','.sql','.py'}
PROTECTED=[
    'app/Views/Layout/Header.php','app/Views/Layout/Sidebar.php',
    'app/Views/Layout/PageContainer.php','app/Views/Layout/SidebarItem.php',
    'app/Views/Layout/SidebarNavigation.php','app/Views/Layout/UserProfile.php',
    'assets/css/components.css',
]
CSS_EXCEPTIONS={'assets/css/app-layout.css','assets/css/design-tokens.css','assets/css/responsive.css'}
RULES={
    'browser_storage':re.compile(r'\b(?:localStorage|sessionStorage)\b'),
    'random_telemetry':re.compile(r'\bMath\.random\s*\('),
    'old_fixture_identifier':re.compile(r'\b(?:Vance|Voronin|A100)\b|SCN-904(?:-ALPHA)?|99\.98%|DEFAULT_INITIAL_SCENARIOS',re.I),
    'static_false_success':re.compile(r'>\s*(?:SYNCED|ENGAGED|KERNEL CONNECTED|100% DAG|10\s*/\s*10 CHECKS VERIFIED)\s*<',re.I),
    'fixture_word':re.compile(r'\b(?:demo|samples?|mocks?|fixtures?|seeded|fictitious|fabricated|fake)\b',re.I),
    'sql_insert':re.compile(r'^\s*(?:INSERT\s+INTO|REPLACE\s+INTO)\s+[`a-z_]',re.I),
    'merge_conflict':re.compile(r'^\s*(?:<{7}(?:\s.*)?|={7}|>{7}(?:\s.*)?)\s*$'),
}

def run(args,env=None):
    result=subprocess.run(args,cwd=ROOT,env=env,capture_output=True,text=True,encoding='utf-8',errors='replace',timeout=90)
    return result.returncode,result.stdout,result.stderr

def git(*args):
    return subprocess.check_output(['git',*args],cwd=ROOT,stderr=subprocess.DEVNULL)

def norm(data): return data.decode('utf-8-sig').replace('\r\n','\n')
def sha(data): return hashlib.sha256(data).hexdigest()
def save(name,value): (OUT/name).write_text(json.dumps(value,indent=2,ensure_ascii=False)+'\n',encoding='utf-8')

def scope(relative,policy):
    if relative.startswith('storage/private/'): return 'private_runtime_not_application_source'
    if relative.startswith('verification/'): return 'verification_evidence_or_audit_tool'
    if relative.startswith('tests/'): return 'test_source_or_retired_test'
    if relative in {'bin/audit_source.py','bin/package_release.py'}: return 'audit_packaging_rule_source'
    reason=policy.excluded(ROOT/relative,relative)
    return 'release_excluded_retained_artifact' if reason else 'application_source'

def classify(relative,kind,line,category):
    if category!='application_source': return category
    if kind=='sql_insert' and relative=='database/migrations/004_dataset_lifecycle.sql':
        return 'forward_only_backfill_of_actual_preexisting_metadata'
    if kind=='fixture_word':
        if relative=='bin/migrate.php' and 'No demo records are created' in line: return 'initializer_no_seed_explanation'
        if relative.endswith('_dashboard_panels.php') and 'No verified deployments or endpoint health/latency samples' in line: return 'unavailable_telemetry_explanation'
        if relative.endswith('TicketsAndScenarios.php') and 'id="deliv-demo"' in line: return 'editor_control_id_no_operational_record'
        if relative=='Model Registry & Deployment/js/main.js' and line.lstrip().startswith('//') and 'No fabricated inference or traffic telemetry' in line: return 'disabled_inference_explanation'
    return 'REVIEW_REQUIRED'

def main():
    parser=argparse.ArgumentParser(description=__doc__)
    parser.add_argument('--ready',action='store_true',help='Root has confirmed final editor hook/source readiness.')
    args=parser.parse_args()
    if not args.ready:
        print('PREPARED ONLY: final checks require --ready after the final-hook-ready signal. No checks/DB/ZIP access performed.')
        return 2
    spec=importlib.util.spec_from_file_location('v6_release_policy',ROOT/'bin/package_release.py')
    policy=importlib.util.module_from_spec(spec);spec.loader.exec_module(policy)
    failures=[];inventory=[];findings=[];encoding_errors=[];syntax=[]
    files=[p for p in sorted(ROOT.rglob('*')) if p.is_file() and '.git' not in p.relative_to(ROOT).parts and p.suffix.lower() in SOURCE_EXTENSIONS]
    for path in files:
        relative=path.relative_to(ROOT).as_posix();category=scope(relative,policy);data=path.read_bytes()
        inventory.append({'path':relative,'bytes':len(data),'sha256':sha(data),'scope':category,'source_release_included':policy.excluded(path,relative) is None})
        try: text=norm(data)
        except UnicodeDecodeError as error:
            encoding_errors.append({'path':relative,'byte_offset':error.start,'scope':category})
            if category=='application_source':failures.append('UTF8 '+relative)
            text=data.decode('utf-8-sig',errors='replace')
        for line_number,line in enumerate(text.splitlines(),1):
            for kind,pattern in RULES.items():
                if kind=='sql_insert' and path.suffix.lower()!='.sql':continue
                if not pattern.search(line):continue
                classification=classify(relative,kind,line,category)
                item={'path':relative,'line':line_number,'rule':kind,'classification':classification}
                findings.append(item)
                if classification=='REVIEW_REQUIRED':failures.append(kind+' '+relative+':'+str(line_number))
        if path.suffix.lower()=='.sql':continue
        if category=='private_runtime_not_application_source':
            syntax.append({'path':relative,'result':'EXCLUDED_PRIVATE_USER_CODE','scope':category});continue
        if path.suffix.lower()=='.php':code,stdout,stderr=run([PHP,'-l',str(path)])
        elif path.suffix.lower()=='.js':code,stdout,stderr=run(['node','--check',str(path)])
        else:
            try:compile(data,str(path),'exec');code,stdout,stderr=0,'',''
            except (SyntaxError,UnicodeError) as error:code,stdout,stderr=1,'',type(error).__name__+' at line '+str(getattr(error,'lineno',None))
        entry={'path':relative,'result':'PASS' if code==0 else 'FAIL','scope':category}
        if code:entry['error_output_sha256']=sha((stdout+stderr).encode());failures.append('SYNTAX '+relative)
        syntax.append(entry)
    save('final-source-inventory.json',inventory)
    save('final-operational-scan.json',{'recursive':True,'extensions':sorted(SOURCE_EXTENSIONS),'findings':findings,'encoding_errors':encoding_errors,'limitations':'Location/type/classification only, no private contents. Pattern scans accompany manual and real HTTP/browser tests; arbitrary fabrication cannot be disproved by a regex.'})
    save('final-syntax-inventory.json',syntax)

    baseline_inventory={row['path']:row for row in json.loads((OUT/'baseline-file-inventory.json').read_text(encoding='utf-8-sig'))}
    design=[]
    def record(label,passed,**extra):
        design.append({'check':label,'result':'PASS' if passed else 'FAIL',**extra})
        if not passed:failures.append('DESIGN '+label)
    baseline_paths=git('ls-tree','-r','--name-only',BASELINE).decode().splitlines()
    branding=[p for p in baseline_paths if p.startswith('assets/branding/') or Path(p).stem.lower()=='logo']
    for relative in PROTECTED+branding:
        baseline=git('show',BASELINE+':'+relative);current=(ROOT/relative).read_bytes()
        record(relative+' protected source unchanged',norm(baseline)==norm(current),baseline_git_blob=git('rev-parse',BASELINE+':'+relative).decode().strip(),current_sha256=sha(current))
        if relative in baseline_inventory:
            record(relative+' baseline working bytes unchanged',sha(current)==baseline_inventory[relative]['sha256'],baseline_sha256=baseline_inventory[relative]['sha256'],current_sha256=sha(current))
    before=norm(git('show',BASELINE+':app/Views/Layout/NotificationsButton.php'))
    expected=before.replace('/AI Operations Center (AI SOC)/OperationsDashboard.php','/AI Operations Center (AI SOC)/Dashboard.php').replace('Open SOC Operations Telemetry \u2192','Open SOC Dashboard \u2192')
    record('NotificationsButton canonical link/label exception only',norm((ROOT/'app/Views/Layout/NotificationsButton.php').read_bytes())==expected)
    markup=lambda value:re.findall(r'(?:echo|\$markup\s*=)\s*<<<HTML\n(.*?)\nHTML;',value,re.S)
    record('AppLayout emitted source markup unchanged (cache URL wrapper exception)',markup(norm(git('show',BASELINE+':app/Views/Layout/AppLayout.php')))==markup(norm((ROOT/'app/Views/Layout/AppLayout.php').read_bytes())))
    css_variables=lambda value:collections.defaultdict(list,((name,values) for name,values in _variables(value).items()))
    for relative in [p for p in baseline_paths if p.endswith('.css')]:
        old=norm(git('show',BASELINE+':'+relative));new=norm((ROOT/relative).read_bytes())
        old_vars=css_variables(old);new_vars=css_variables(new)
        allowed={'--z-tooltip':['55'],'--z-drawer':['65']} if relative=='assets/css/design-tokens.css' else {}
        expected=dict(old_vars);expected.update(allowed)
        record(relative+' existing CSS variables unchanged; only approved new stacking tokens',dict(new_vars)==expected)
        colors=lambda value:re.findall(r'#[0-9a-fA-F]{3,8}\b|\b(?:rgba?|hsla?)\([^)]*\)',re.sub(r'/\*.*?\*/','',value,flags=re.S))
        record(relative+' literal color palette unchanged',colors(old)==colors(new))
        if relative not in CSS_EXCEPTIONS:record(relative+' untouched stylesheet',old==new)
    protected_paths=PROTECTED+branding+sorted(CSS_EXCEPTIONS)+['app/Views/Layout/AppLayout.php','app/Views/Layout/NotificationsButton.php']
    (OUT/'final-protected-design.diff').write_bytes(git('diff',BASELINE,'--',*protected_paths))
    save('final-design-protection.json',{'baseline':BASELINE,'checks':design,'exceptions':['three scoped CSS responsiveness/stacking fixes','two added z-index variables only','AppLayout local CSS/JS cache URL wrapper; emitted markup unchanged','NotificationsButton canonical SOC Dashboard link/label only']})

    environment=os.environ.copy();environment.update({'APP_ENV':'testing','DB_NAME':'vostok_range_v6_20261031_static_test'})
    contract_code='require "tests/api_contracts.php"; $property=(new ReflectionClass(App\\Core\\Database::class))->getProperty("instance"); if($property->getValue()!==null)throw new RuntimeException("Static contract suite unexpectedly opened PDO."); echo "PASS static contract suite left PDO disconnected.\\n";'
    code,stdout,stderr=run([PHP,'-r',contract_code],environment)
    (OUT/'final-api-contracts.log').write_text(stdout+stderr,encoding='utf-8')
    record_routes=bool(code==0 and '113 required contracts; 183 total routes' in stdout)
    contract_no_pdo='PASS static contract suite left PDO disconnected.' in stdout
    if not record_routes:failures.append('API required113/total183 contract scope')
    code,stdout,stderr=run([sys.executable,str(OUT/'masked_secret_audit.py')])
    (OUT/'final-masked-secret-scan.log').write_text(stdout+stderr,encoding='utf-8')
    secret_report=json.loads((OUT/'data-secret-audit.json').read_text(encoding='utf-8')) if code==0 else {}
    secret_review=[item for area in ['working_tree','git_history'] for item in secret_report.get(area,{}).get('findings',[]) if item.get('classification')=='manual_review_required' or item.get('classification','').startswith('high_confidence_pattern_requires')]
    secret_review += [item for item in secret_report.get('working_tree',{}).get('findings',[]) if item.get('type')=='bcrypt_password_hash' and item.get('path')!='database/vostokpribor_ai.sql']
    legacy_hash_count=sum(item.get('count',1) for item in secret_report.get('working_tree',{}).get('findings',[]) if item.get('type')=='bcrypt_password_hash' and item.get('path')=='database/vostokpribor_ai.sql')
    secret_ok=code==0 and not secret_review
    if not secret_ok:failures.append('Masked secret scan requires review; see locations/types only in data-secret-audit.json')
    code,stdout,stderr=run(['git','diff','--check',BASELINE,'--','.',':(glob,exclude)verification/**/*.diff',':(glob,exclude)verification/**/*.patch'])
    diff_check={'excluded_format_artifacts':'Byte-exact .diff/.patch evidence contains required context-line whitespace; all source/docs still checked.','result':'PASS' if code==0 else 'FAIL','output_sha256':sha((stdout+stderr).encode())}
    if code:failures.append('git diff --check')
    summary={'generated_at_utc':datetime.now(timezone.utc).isoformat(),'result':'PASS' if not failures else 'REVIEW_REQUIRED','baseline':BASELINE,'files_by_extension':dict(collections.Counter(Path(x['path']).suffix for x in inventory)),'syntax_by_result':dict(collections.Counter(x['result'] for x in syntax)),'findings_by_classification':dict(collections.Counter(x['classification'] for x in findings)),'design_checks':len(design),'api_113_required_183_total':record_routes,'api_contract_PDO_disconnected':contract_no_pdo,'masked_secret_scan_passed_no_new_unclassified_keys':secret_ok,'known_legacy_hash_material_preserved_and_release_excluded':legacy_hash_count,'diff_check':diff_check,'failures':failures,'database_accessed':False,'private_files_modified':False,'source_files_modified':False,'archive_built':False}
    save('final-source-verification.json',summary)
    lines=[json.dumps(summary,indent=2),'All detailed results are in final-source-inventory.json, final-operational-scan.json, final-syntax-inventory.json, final-design-protection.json and final-api-contracts.log.']
    (OUT/'final-source-verification.log').write_text('\n'.join(lines)+'\n',encoding='utf-8')
    print('\n'.join(lines));return 0 if not failures else 1

def _variables(value):
    result=collections.defaultdict(list)
    for name,item in re.findall(r'(--[A-Za-z0-9_-]+)\s*:\s*([^;]+);',re.sub(r'/\*.*?\*/','',value,flags=re.S)):
        result[name].append(re.sub(r'\s+',' ',item).strip())
    return dict(result)

if __name__=='__main__':sys.exit(main())
