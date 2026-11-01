<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }

/** Operator-only recovery utilities. Application requests never load this file. */
function recoveryIdentifier(string $value): string
{
    if (!preg_match('/^[A-Za-z][A-Za-z0-9_]{0,63}$/D', $value)) throw new InvalidArgumentException('Invalid database identifier.');
    return $value;
}

function recoveryPath(string $path): string
{
    $real=realpath($path);
    if ($real===false) throw new RuntimeException('An existing absolute path is required.');
    return rtrim(str_replace('\\','/',$real),'/');
}

function recoveryInside(string $path,string $root): bool
{
    return strcasecmp($path,$root)===0 || str_starts_with(strtolower($path),strtolower($root).'/');
}

function recoveryExternalParent(string $output,string $sourceRoot): string
{
    if (!preg_match('~^(?:[A-Za-z]:[/\\\\]|/)~',$output)) throw new InvalidArgumentException('Use an absolute recovery path.');
    $parent=recoveryPath(dirname($output));$sourceRoot=recoveryPath($sourceRoot);
    if (recoveryInside($parent,$sourceRoot)) throw new RuntimeException('Recovery output must be outside the source tree.');
    foreach ([$sourceRoot,$parent] as $candidate) {
        $walk=$candidate;
        while (strlen($walk)>3) {
            if (in_array(strtolower(basename($walk)),['htdocs','public_html','wwwroot'],true) && recoveryInside($parent,$walk)) throw new RuntimeException('Recovery output must be outside every web root.');
            $next=str_replace('\\','/',dirname($walk));if($next===$walk)break;$walk=$next;
        }
    }
    if (file_exists($output)) throw new RuntimeException('Refused: recovery output already exists.');
    return $parent;
}

function recoveryPassword(string $password): void
{
    if (strlen($password)<24 || strlen($password)>1024 || str_contains($password,"\0")) throw new InvalidArgumentException('A separate recovery passphrase of 24–1024 bytes is required on stdin.');
    if (!class_exists(ZipArchive::class) || !ZipArchive::isEncryptionMethodSupported(ZipArchive::EM_AES_256)) throw new RuntimeException('AES-256 ZIP support is required; plaintext fallback is forbidden.');
}

function recoveryWorkDirectory(string $parent): string
{
    $path=$parent.'/.vostok-recovery-'.bin2hex(random_bytes(16));
    if(!mkdir($path,0700))throw new RuntimeException('Cannot create private recovery workspace.');
    if(PHP_OS_FAMILY==='Windows') {
        $identity=(string)getenv('USERDOMAIN').'\\'.(string)getenv('USERNAME');
        if(!preg_match('/^[A-Za-z0-9_. -]+\\\\[A-Za-z0-9_. -]+$/D',$identity))throw new RuntimeException('Cannot establish the recovery workspace owner.');
        $null=fopen('NUL','w');$process=proc_open(['C:/Windows/System32/icacls.exe',$path,'/inheritance:r','/grant:r',$identity.':(OI)(CI)F'],[0=>['pipe','r'],1=>$null,2=>$null],$pipes);
        if(!is_resource($process))throw new RuntimeException('Cannot restrict recovery workspace ACL.');
        fclose($pipes[0]);$code=proc_close($process);fclose($null);
        if($code!==0)throw new RuntimeException('Cannot restrict recovery workspace ACL.');
    } elseif(!chmod($path,0700))throw new RuntimeException('Cannot restrict recovery workspace permissions.');
    return $path;
}

function recoveryRemoveWorkDirectory(string $path): void
{
    // Only our random, directly owned workspace is eligible; never walk links.
    if(!preg_match('/^\.vostok-recovery-[a-f0-9]{32}$/D',basename($path)))throw new RuntimeException('Invalid recovery cleanup boundary.');
    foreach(scandir($path)?:[] as $name) {
        if($name==='.'||$name==='..')continue;
        $file=$path.'/'.$name;
        if(!is_file($file)||is_link($file))throw new RuntimeException('Unexpected recovery workspace entry; preserved for review.');
        if(!unlink($file))throw new RuntimeException('Recovery temporary file cleanup failed.');
    }
    if(!rmdir($path))throw new RuntimeException('Recovery temporary directory cleanup failed.');
}

function recoveryFileInventory(string $root): array
{
    $root=recoveryPath($root);$base=$root.'/storage/private';
    if(!is_dir($base))throw new RuntimeException('Private storage is required.');
    $files=[];$iterator=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($base,FilesystemIterator::SKIP_DOTS),RecursiveIteratorIterator::SELF_FIRST);
    foreach($iterator as $item) {
        $real=recoveryPath($item->getPathname());
        if($item->isLink()||!recoveryInside($real,$base)||strcasecmp($real,str_replace('\\','/',$item->getPathname()))!==0)throw new RuntimeException('Private storage links/junctions are unsupported.');
        if($item->isDir())continue;
        if(!$item->isFile())throw new RuntimeException('Unsupported private storage object.');
        $relative=substr(str_replace('\\','/',$item->getPathname()),strlen($root)+1);
        if(!preg_match('~^storage/private/(?:datasets|models|sandboxes)/[^:]+$~D',$relative) && !in_array($relative,['storage/private/.htaccess','storage/private/.gitkeep'],true))throw new RuntimeException('Unexpected private storage path.');
        recoveryEntryName($relative);$files[$relative]=['bytes'=>$item->getSize(),'sha256'=>hash_file('sha256',$real)];
    }
    ksort($files);return $files;
}

function recoveryDatabaseState(PDO $pdo): array
{
    $database=recoveryIdentifier((string)$pdo->query('SELECT DATABASE()')->fetchColumn());
    $tables=$pdo->query("SELECT TABLE_NAME,ENGINE,TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() ORDER BY TABLE_NAME")->fetchAll(PDO::FETCH_ASSOC);
    $result=['database'=>$database,'tables'=>[]];
    foreach(['TRIGGERS'=>'TRIGGER_SCHEMA','ROUTINES'=>'ROUTINE_SCHEMA','EVENTS'=>'EVENT_SCHEMA'] as $object=>$column) {
        $query=$pdo->prepare('SELECT COUNT(*) FROM information_schema.'.$object.' WHERE '.$column.'=:database');$query->execute(['database'=>$database]);
        if((int)$query->fetchColumn()!==0)throw new RuntimeException('Automatic recovery supports the application table schema only; stored triggers/routines/events need a separately reviewed operator recovery.');
    }
    foreach($tables as $table) {
        $name=recoveryIdentifier($table['TABLE_NAME']);
        if($table['ENGINE']!=='InnoDB'||$table['TABLE_TYPE']!=='BASE TABLE')throw new RuntimeException('Recovery requires reviewed InnoDB application tables.');
        $ddl=$pdo->query('SHOW CREATE TABLE `'.$name.'`')->fetch(PDO::FETCH_NUM)[1];
        $hash=hash_init('sha256');$count=0;$query=$pdo->query('SELECT * FROM `'.$name.'` ORDER BY 1');
        while($row=$query->fetch(PDO::FETCH_ASSOC)){hash_update($hash,json_encode($row,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR)."\n");$count++;}
        $result['tables'][$name]=['rows'=>$count,'sha256'=>hash_final($hash),'ddl_sha256'=>hash('sha256',$ddl)];
    }
    if(!isset($result['tables']['migrations'])||!isset($result['tables']['users']))throw new RuntimeException('An initialized application schema is required.');
    $result['migrations']=$pdo->query('SELECT migration FROM migrations ORDER BY migration')->fetchAll(PDO::FETCH_COLUMN);
    return $result;
}

function recoveryReferences(PDO $pdo,string $root): void
{
    foreach(['SELECT file_path,checksum_sha256 FROM datasets','SELECT file_path,checksum_sha256 FROM dataset_versions','SELECT file_path,checksum_sha256 FROM processed_datasets','SELECT artifact_path AS file_path,checksum_sha256 FROM model_versions'] as $sql) {
        $base=str_contains($sql,'model_versions')?'models':'datasets';
        foreach($pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $name=$row['file_path'];if(!is_string($name)||basename($name)!==$name)throw new RuntimeException('Invalid database artifact reference.');
            $path=$root.'/storage/private/'.$base.'/'.$name;
            if(!is_file($path)||!hash_equals((string)$row['checksum_sha256'],hash_file('sha256',$path)))throw new RuntimeException('A referenced private artifact is missing or corrupt. Backup/restore refused.');
        }
    }
}

function recoveryMysqlProcess(string $program,array $arguments,array $configuration,mixed $input,mixed $output): void
{
    if(!is_file($program))throw new RuntimeException('Configured MySQL command program is unavailable.');
    $environment=getenv();$environment['MYSQL_PWD']=(string)$configuration['DB_PASS'];
    $errors=tmpfile();$process=proc_open(array_merge([$program],['--host='.$configuration['DB_HOST'],'--port='.$configuration['DB_PORT'],'--user='.$configuration['DB_USER'],'--default-character-set=utf8mb4'],$arguments),[0=>$input,1=>$output,2=>$errors],$pipes,null,$environment);
    unset($environment['MYSQL_PWD']);
    if(!is_resource($process)){fclose($errors);throw new RuntimeException('MySQL backup/restore process could not start.');}
    $code=proc_close($process);fclose($errors);
    if($code!==0)throw new RuntimeException('MySQL backup/restore failed; credentials and SQL diagnostics withheld.');
}

function recoveryMigrationFiles(string $root): array
{
    $files=[];
    foreach(glob($root.'/database/migrations/*.sql')?:[] as $file)$files[basename($file)]=hash_file('sha256',$file);
    if(!$files)throw new RuntimeException('Migration sources are required.');ksort($files);return $files;
}

function recoveryBackup(PDO $pdo,string $root,string $output,string $password,array $configuration): array
{
    recoveryPassword($password);$root=recoveryPath($root);$parent=recoveryExternalParent($output,$root);$work=recoveryWorkDirectory($parent);$zip=null;$finished=false;
    try {
        $database=recoveryDatabaseState($pdo);recoveryReferences($pdo,$root);$files=recoveryFileInventory($root);$migrationFiles=recoveryMigrationFiles($root);
        $sourceConfig=is_file($root.'/.env')?file_get_contents($root.'/.env'):null;
        $sql=$work.'/database.sql';$dump=fopen($sql,'x');if(!$dump)throw new RuntimeException('Cannot create private dump file.');chmod($sql,0600);
        $input=fopen(PHP_OS_FAMILY==='Windows'?'NUL':'/dev/null','r');
        try {recoveryMysqlProcess((string)($configuration['MYSQLDUMP_BINARY']??'C:/xampp/mysql/bin/mysqldump.exe'),['--single-transaction','--skip-comments','--skip-dump-date','--hex-blob','--skip-add-locks','--skip-add-drop-table','--skip-disable-keys',$database['database']],$configuration,$input,$dump);} finally {fclose($input);fclose($dump);}
        if(!filesize($sql)||filesize($sql)>64*1024*1024)throw new RuntimeException('Automatic recovery SQL must be nonempty and at most 64MiB; use separately reviewed operator recovery for larger databases.');
        if(count($files)+3>20000||array_sum(array_column($files,'bytes'))+filesize($sql)>2*1024*1024*1024-16*1024*1024)throw new RuntimeException('Backup exceeds the reviewed automatic restore resource limits.');
        $manifest=['format'=>'VOSTOKPRIBOR_RECOVERY_1','created_at_utc'=>gmdate('c'),'database'=>$database,'migrations'=>$migrationFiles,'files'=>$files,'sql'=>['bytes'=>filesize($sql),'sha256'=>hash_file('sha256',$sql)],'configuration'=>['source_file_present'=>$sourceConfig!==null,'source_sha256'=>$sourceConfig!==null?hash('sha256',$sourceConfig):null,'effective'=>$configuration],'consistency'=>'Full before/after DB/files/configuration fingerprints must be identical; use a quiet maintenance window.'];
        $zip=new ZipArchive();if($zip->open($work.'/recovery.zip',ZipArchive::CREATE|ZipArchive::EXCL)!==true)throw new RuntimeException('Cannot create encrypted archive.');
        if(!$zip->setPassword($password))throw new RuntimeException('Cannot set recovery encryption.');
        $entries=['database.sql'=>$sql];foreach($files as $name=>$file)$entries[$name]=$root.'/'.$name;
        foreach($entries as $name=>$path)if(!$zip->addFile($path,$name)||!$zip->setEncryptionName($name,ZipArchive::EM_AES_256,$password))throw new RuntimeException('Cannot encrypt recovery entry.');
        if(!$zip->addFromString('manifest.json',json_encode($manifest,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR))||!$zip->setEncryptionName('manifest.json',ZipArchive::EM_AES_256,$password))throw new RuntimeException('Cannot encrypt recovery manifest.');
        if($sourceConfig!==null && (!$zip->addFromString('configuration/source.env',$sourceConfig)||!$zip->setEncryptionName('configuration/source.env',ZipArchive::EM_AES_256,$password)))throw new RuntimeException('Cannot encrypt configuration.');
        if(!$zip->close())throw new RuntimeException('Cannot finalize recovery encryption.');$zip=null;
        if(recoveryDatabaseState($pdo)!==$database||recoveryFileInventory($root)!==$files||recoveryMigrationFiles($root)!==$migrationFiles||($sourceConfig!==null?file_get_contents($root.'/.env'):null)!==$sourceConfig)throw new RuntimeException('Concurrent changes detected. Backup not published; retry during a quiet maintenance window.');
        $verify=new ZipArchive();if($verify->open($work.'/recovery.zip')!==true||!$verify->setPassword($password))throw new RuntimeException('Archive verification failed.');
        $verified=$verify->getFromName('manifest.json');$verify->close();if($verified!==json_encode($manifest,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_THROW_ON_ERROR))throw new RuntimeException('Encrypted manifest verification failed.');
        // A hard link atomically creates an absent name; unlike rename it cannot overwrite a raced destination.
        if(!link($work.'/recovery.zip',$output))throw new RuntimeException('Refused to overwrite or could not exclusively publish recovery archive.');chmod($output,0600);$finished=true;
        return ['result'=>'PASS','archive'=>$output,'archive_sha256'=>hash_file('sha256',$output),'encrypted'=>true,'tables'=>count($database['tables']),'private_files'=>count($files),'configuration_encrypted'=>$sourceConfig!==null,'source_database'=>$database['database'],'source_mutated'=>false];
    } finally {
        if($zip instanceof ZipArchive)$zip->close();
        // Only our own unpublished output/workspace is cleaned, never original files.
        recoveryRemoveWorkDirectory($work);
    }
}

function recoveryEntryName(string $name): void
{
    if($name===''||str_contains($name,'\\')||str_contains($name,':')||str_starts_with($name,'/')||preg_match('~(?:^|/)\.\.(?:/|$)~',$name)||str_contains($name,"\0"))throw new RuntimeException('Unsafe recovery archive path.');
    if(!in_array($name,['manifest.json','database.sql','configuration/source.env','storage/private/.htaccess','storage/private/.gitkeep'],true)&&!preg_match('~^storage/private/(?:datasets|models|sandboxes)/.+$~uD',$name))throw new RuntimeException('Unexpected recovery archive entry.');
    foreach(explode('/',$name) as $part) {
        if($part===''||$part==='.'||$part==='..'||preg_match('/[<>:"|?*\x00-\x1f]/',$part)||preg_match('/[. ]$/D',$part)||preg_match('/^(?:CON|PRN|AUX|NUL|COM[1-9]|LPT[1-9])(?:\.|$)/iD',$part))throw new RuntimeException('Recovery archive path is unsafe on the target filesystem.');
    }
}

/** Remove data strings/comments while retaining SQL identifiers and executable version comments. */
function recoverySqlSafety(string $sql,string $sourceDatabase,array $tables=[]): void
{
    $normal='';$length=strlen($sql);$state='normal';
    for($i=0;$i<$length;$i++) {
        $char=$sql[$i];$next=$sql[$i+1]??'';
        if($state==='single'||$state==='double') {
            $quote=$state==='single'?"'":'"';
            if($char==='\\'){$i++;continue;}
            if($char===$quote){if($next===$quote){$i++;continue;}$state='normal';$normal.=' ';}continue;
        }
        if($state==='line'){if($char==="\n"){$state='normal';$normal.="\n";}continue;}
        if($state==='comment'){if($char==='*'&&$next==='/'){$state='normal';$i++;$normal.=' ';}continue;}
        if($char==="'"){$state='single';$normal.=' ';continue;}
        if($char==='"'){$state='double';$normal.=' ';continue;}
        if(($char==='-'&&$next==='-'&&ctype_space($sql[$i+2]??' '))||$char==='#'){$state='line';continue;}
        if($char==='/'&&$next==='*') {
            if(($sql[$i+2]??'')==='!'){$i+=2;while(ctype_digit($sql[$i+1]??''))$i++;continue;}
            $state='comment';$i++;continue;
        }
        if($char==='*'&&$next==='/'){$normal.=' ';$i++;continue;}
        $normal.=$char;
    }
    if($state!=='normal'&&$state!=='line')throw new RuntimeException('Unterminated SQL structure in recovery archive.');
    if(preg_match('/\b(?:USE\s+|CREATE\s+(?:OR\s+REPLACE\s+)?DATABASE\b|DROP\s+DATABASE\b|GRANT\s+|CREATE\s+USER\b|INTO\s+OUTFILE\b|INTO\s+DUMPFILE\b)/i',$normal))throw new RuntimeException('Recovery SQL contains a forbidden database/account/file operation.');
    if(preg_match('/(?:`'.preg_quote($sourceDatabase,'/').'`|\b'.preg_quote($sourceDatabase,'/').'\b)\s*\./i',$normal))throw new RuntimeException('Recovery SQL references the source database explicitly.');
    if(preg_match('/`[^`]+`\s*\.\s*`[^`]+`/',$normal)||preg_match('/\b(?:DATA|INDEX)\s+DIRECTORY\b|\b(?:FEDERATED|CONNECT|OUTFILE|DUMPFILE|LOAD_FILE)\b/i',$normal))throw new RuntimeException('Cross-schema identifiers or external storage are unsupported in automatic recovery.');
    foreach(explode(';',$normal) as $statement) {
        $statement=trim($statement);if($statement==='')continue;
        if(preg_match('/^SET\b/i',$statement)) {if(preg_match('/\b(?:GLOBAL|PASSWORD|ROLE)\b|\(/i',$statement))throw new RuntimeException('Unsafe restore session instruction.');continue;}
        if(!preg_match('/^(?:CREATE\s+TABLE|INSERT\s+INTO)\s+`([A-Za-z][A-Za-z0-9_]*)`\s*(.*)$/isD',$statement,$match)||($tables&&!in_array($match[1],$tables,true)))throw new RuntimeException('Unsupported recovery SQL statement.');
        if(str_starts_with(strtoupper($statement),'INSERT')&&!preg_match('/^(?:\([^;]*?\)\s*)?VALUES\s*\(/is',$match[2]))throw new RuntimeException('Only literal dump INSERT values are supported.');
    }
}

function recoveryRuntimeConfiguration(array $input,string $database): array
{
    $database=recoveryIdentifier($database);
    if(!str_ends_with($database,'_test'))throw new RuntimeException('Automatic restore is restricted to a new isolated _test schema.');
    $user=$input['runtime_user']??'';$password=$input['runtime_password']??'';$url=$input['app_url']??'';$cookie=$input['session_cookie']??'';
    if(!is_string($user)||!preg_match('/^[A-Za-z][A-Za-z0-9_]{0,31}$/D',$user)||in_array(strtolower($user),['root','admin'],true)||!is_string($password)||strlen($password)<24||strpbrk($password,"\r\n\0\"")!==false)throw new InvalidArgumentException('A separate restricted runtime identity with a strong secret is required.');
    $parts=is_string($url)&&filter_var($url,FILTER_VALIDATE_URL)?parse_url($url):false;
    if(!$parts||str_contains($url,'"')||!in_array($parts['host']??'', ['localhost','127.0.0.1','::1','[::1]'],true)||!in_array($parts['scheme']??'',['http','https'],true)||isset($parts['user'])||isset($parts['pass'])||isset($parts['query'])||isset($parts['fragment']))throw new InvalidArgumentException('Restore APP_URL must identify a separate loopback staging installation.');
    if(!is_string($cookie)||!preg_match('/^[A-Za-z][A-Za-z0-9_]{1,100}_test$/D',$cookie))throw new InvalidArgumentException('A separate staging cookie ending _test is required.');
    return ['APP_NAME'=>'VOSTOKPRIBOR AI','APP_ENV'=>'testing','APP_DEBUG'=>false,'APP_URL'=>rtrim($url,'/'),'DB_NAME'=>$database,'DB_USER'=>$user,'DB_PASS'=>$password,'DB_CHARSET'=>'utf8mb4','SESSION_COOKIE_NAME'=>$cookie,'SESSION_SECURE'=>($parts['scheme']==='https'),'SESSION_LIFETIME'=>7200,'MAX_UPLOAD_SIZE_MB'=>50];
}

function recoveryRestrictedRuntime(PDO $pdo,string $database): void
{
    $actual=[];
    foreach($pdo->query('SHOW GRANTS')->fetchAll(PDO::FETCH_COLUMN) as $grant) {
        if(!preg_match('/^GRANT (.*?) ON (.*?) TO /',$grant,$match))throw new RuntimeException('Cannot verify runtime grants.');
        $privileges=array_map('trim',explode(',',$match[1]));$scope=str_replace('`','',$match[2]);
        if($scope==='*.*'&&$privileges===['USAGE'])continue;
        // GRANT treats underscores as wildcard characters even in backtick identifiers.
        $exactScope=str_replace('_','\\_',$database).'.*';
        if($scope!==$exactScope||array_diff($privileges,['SELECT','INSERT','UPDATE','DELETE'])||str_contains($grant,'WITH GRANT OPTION'))throw new RuntimeException('Runtime account privileges are broader than the exact restore schema data operations.');
        $actual=array_unique(array_merge($actual,$privileges));
    }
    sort($actual);if($actual!==['DELETE','INSERT','SELECT','UPDATE'])throw new RuntimeException('Runtime identity lacks required data operation grants.');
}

function recoveryRestore(PDO $operator,string $archive,string $targetRoot,string $targetDatabase,string $password,array $runtimeInput,array $operatorConfiguration): array
{
    recoveryPassword($password);$archive=recoveryPath($archive);$targetRoot=recoveryPath($targetRoot);$runtime=recoveryRuntimeConfiguration($runtimeInput,$targetDatabase);
    if(!is_file($targetRoot.'/app/bootstrap.php')||is_file($targetRoot.'/.env'))throw new RuntimeException('A clean code-only application tree without .env is required.');
    foreach(recoveryFileInventory($targetRoot) as $name=>$file)if(!in_array(basename($name),['.htaccess','.gitkeep'],true))throw new RuntimeException('Restore target already contains private payloads; nothing was overwritten.');
    $q=$operator->prepare('SELECT COUNT(*) FROM information_schema.SCHEMATA WHERE SCHEMA_NAME=:database');$q->execute(['database'=>$targetDatabase]);if((int)$q->fetchColumn()!==0)throw new RuntimeException('Restore target database already exists; nothing was reset.');
    $sourceDatabase=(string)$operator->query('SELECT DATABASE()')->fetchColumn();if($sourceDatabase===$targetDatabase)throw new RuntimeException('Restore target must differ from selected database.');
    $parent=recoveryExternalParent(dirname($archive).'/restore-proof-'.bin2hex(random_bytes(10)).'.json',$targetRoot);$work=recoveryWorkDirectory($parent);$zip=new ZipArchive();$zipOpened=false;$createdDatabase=false;$copied=[];
    try {
        if($zip->open($archive)!==true)throw new RuntimeException('Cannot open encrypted recovery archive.');$zipOpened=true;
        if(!$zip->setPassword($password))throw new RuntimeException('Cannot open encrypted recovery archive.');
        $raw=$zip->getFromName('manifest.json',16*1024*1024+1);if(!is_string($raw)||strlen($raw)>16*1024*1024)throw new RuntimeException('Wrong password, corrupt or oversized recovery manifest.');
        $manifest=json_decode($raw,true,64,JSON_THROW_ON_ERROR);if(($manifest['format']??'')!=='VOSTOKPRIBOR_RECOVERY_1')throw new RuntimeException('Unsupported recovery format.');
        if(($manifest['database']['database']??'')===$targetDatabase)throw new RuntimeException('Refused to restore into the backup source database.');
        if($manifest['migrations']!==recoveryMigrationFiles($targetRoot))throw new RuntimeException('Target migration files differ from backup deployment metadata.');
        $expected=['manifest.json'=>true,'database.sql'=>true];foreach($manifest['files'] as $name=>$file){recoveryEntryName($name);$expected[$name]=true;}
        if($manifest['configuration']['source_file_present']??false)$expected['configuration/source.env']=true;
        $seen=[];$total=0;
        for($i=0;$i<$zip->numFiles;$i++) {
            $stat=$zip->statIndex($i);$name=$stat['name'];recoveryEntryName($name);$key=mb_strtolower($name,'UTF-8');$zip->getExternalAttributesIndex($i,$operatingSystem,$attributes);
            if(isset($seen[$key])||!isset($expected[$name])||($stat['encryption_method']??0)!==ZipArchive::EM_AES_256||(($attributes>>16)&0170000)===0120000)throw new RuntimeException('Duplicate, unexpected, unencrypted or linked recovery entry.');
            $seen[$key]=true;$total+=(int)$stat['size'];if($total>2*1024*1024*1024||$zip->numFiles>20000)throw new RuntimeException('Recovery archive exceeds reviewed resource limits.');
        }
        if(count($seen)!==count($expected))throw new RuntimeException('Recovery archive is incomplete.');
        // Fully authenticate/check every payload before creating the target DB or writing storage.
        foreach($expected as $name=>$ignored) {
            if($name==='manifest.json')continue;
            $stream=$zip->getStream($name);if(!is_resource($stream))throw new RuntimeException('Recovery entry authentication failed.');
            $hash=hash_init('sha256');$bytes=0;$sqlHandle=null;
            if($name==='database.sql'){$sqlHandle=fopen($work.'/database.sql','x');chmod($work.'/database.sql',0600);}
            while(!feof($stream)){$chunk=fread($stream,1024*1024);if($chunk===false)throw new RuntimeException('Recovery entry read failed.');$bytes+=strlen($chunk);hash_update($hash,$chunk);if($sqlHandle)fwrite($sqlHandle,$chunk);}
            fclose($stream);if($sqlHandle)fclose($sqlHandle);
            $expectedFile=$name==='database.sql'?$manifest['sql']:($name==='configuration/source.env'?['sha256'=>$manifest['configuration']['source_sha256']]:$manifest['files'][$name]);
            if(!hash_equals((string)$expectedFile['sha256'],hash_final($hash))||(isset($expectedFile['bytes'])&&$bytes!==$expectedFile['bytes']))throw new RuntimeException('Recovery file checksum/size does not match.');
        }
        if(filesize($work.'/database.sql')>64*1024*1024)throw new RuntimeException('Automatic SQL inspection is limited to64MiB; use a reviewed operator recovery for larger databases.');
        recoverySqlSafety(file_get_contents($work.'/database.sql'),recoveryIdentifier($manifest['database']['database']),array_keys($manifest['database']['tables']));
        $operator->exec('CREATE DATABASE `'.recoveryIdentifier($targetDatabase).'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');$createdDatabase=true;
        $input=fopen($work.'/database.sql','r');$null=fopen(PHP_OS_FAMILY==='Windows'?'NUL':'/dev/null','w');
        try{recoveryMysqlProcess((string)($operatorConfiguration['MYSQL_BINARY']??'C:/xampp/mysql/bin/mysql.exe'),['--database='.$targetDatabase],$operatorConfiguration,$input,$null);}finally{fclose($input);fclose($null);}
        $dsn='mysql:host='.$operatorConfiguration['DB_HOST'].';port='.$operatorConfiguration['DB_PORT'].';dbname='.$targetDatabase.';charset=utf8mb4';
        $restored=new PDO($dsn,(string)$operatorConfiguration['DB_USER'],(string)$operatorConfiguration['DB_PASS'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);
        $restoredState=recoveryDatabaseState($restored);$expectedState=$manifest['database'];$expectedState['database']=$targetDatabase;
        if($restoredState!==$expectedState)throw new RuntimeException('Restored database fingerprints/schema do not match. Target retained for investigation.');
        foreach($manifest['files'] as $name=>$file) {
            $target=$targetRoot.'/'.$name;
            if(is_file($target)) {if(hash_file('sha256',$target)!==$file['sha256'])throw new RuntimeException('Existing target storage control differs; nothing overwritten.');continue;}
            if(!is_dir(dirname($target))&&!mkdir(dirname($target),0700,true))throw new RuntimeException('Cannot create target private directory.');
            if(!recoveryInside(recoveryPath(dirname($target)),$targetRoot.'/storage/private'))throw new RuntimeException('Target private path escaped its root.');
            $destination=fopen($target,'x');if(!$destination)throw new RuntimeException('Refused target overwrite.');$stream=$zip->getStream($name);
            stream_copy_to_stream($stream,$destination);fclose($stream);fclose($destination);chmod($target,0600);$copied[]=$target;
            if(!hash_equals($file['sha256'],hash_file('sha256',$target)))throw new RuntimeException('Restored file checksum failed.');
        }
        recoveryReferences($restored,$targetRoot);
        $runtimeConnection=new PDO($dsn,$runtime['DB_USER'],$runtime['DB_PASS'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);recoveryRestrictedRuntime($runtimeConnection,$targetDatabase);
        $runtime['DB_HOST']=$operatorConfiguration['DB_HOST'];$runtime['DB_PORT']=$operatorConfiguration['DB_PORT'];$lines=[];
        foreach($runtime as $key=>$value) {$value=is_bool($value)?($value?'true':'false'):(string)$value;if(strpbrk($value,"\r\n\0")!==false||str_contains($value,'"'))throw new RuntimeException('Invalid staging configuration value.');$lines[]=$key.'="'.$value.'"';}
        $env=fopen($targetRoot.'/.env','x');if(!$env)throw new RuntimeException('Refused to overwrite target configuration.');fwrite($env,implode("\n",$lines)."\n");fclose($env);chmod($targetRoot.'/.env',0600);
        return ['result'=>'PASS','target_database'=>$targetDatabase,'target_root'=>$targetRoot,'tables'=>count($restoredState['tables']),'private_files'=>count($manifest['files']),'database_and_file_fingerprints_match'=>true,'runtime_grants_restricted'=>true,'original_configuration_kept_encrypted'=>true,'source_database_modified'=>false,'schemas_dropped'=>0];
    } finally {if($zipOpened)$zip->close();recoveryRemoveWorkDirectory($work);}
}
