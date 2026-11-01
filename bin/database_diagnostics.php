<?php
/** Read-only PDO/live-schema inventory. No migrations, seeding, passwords or row values. */
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;
use App\Core\Env;

function diagnosticSchema(PDO $pdo, string $database): array
{
    $queries = [
        'tables' => 'SELECT TABLE_NAME,TABLE_TYPE,ENGINE,TABLE_COLLATION FROM information_schema.TABLES WHERE TABLE_SCHEMA=:schema ORDER BY TABLE_NAME',
        'columns' => 'SELECT TABLE_NAME,COLUMN_NAME,ORDINAL_POSITION,COLUMN_DEFAULT,IS_NULLABLE,COLUMN_TYPE,CHARACTER_SET_NAME,COLLATION_NAME,EXTRA,GENERATION_EXPRESSION FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=:schema ORDER BY TABLE_NAME,ORDINAL_POSITION',
        'indexes' => 'SELECT TABLE_NAME,INDEX_NAME,NON_UNIQUE,SEQ_IN_INDEX,COLUMN_NAME,COLLATION,SUB_PART,INDEX_TYPE,NULLABLE FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=:schema ORDER BY TABLE_NAME,INDEX_NAME,SEQ_IN_INDEX',
        'constraints' => 'SELECT TABLE_NAME,CONSTRAINT_NAME,CONSTRAINT_TYPE FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA=:schema ORDER BY TABLE_NAME,CONSTRAINT_NAME',
        'foreign_keys' => 'SELECT k.TABLE_NAME,k.CONSTRAINT_NAME,k.ORDINAL_POSITION,k.COLUMN_NAME,k.REFERENCED_TABLE_NAME,k.REFERENCED_COLUMN_NAME,r.UPDATE_RULE,r.DELETE_RULE FROM information_schema.KEY_COLUMN_USAGE k JOIN information_schema.REFERENTIAL_CONSTRAINTS r ON r.CONSTRAINT_SCHEMA=k.CONSTRAINT_SCHEMA AND r.TABLE_NAME=k.TABLE_NAME AND r.CONSTRAINT_NAME=k.CONSTRAINT_NAME WHERE k.CONSTRAINT_SCHEMA=:schema AND k.REFERENCED_TABLE_NAME IS NOT NULL ORDER BY k.TABLE_NAME,k.CONSTRAINT_NAME,k.ORDINAL_POSITION',
        'checks' => 'SELECT CONSTRAINT_NAME,CHECK_CLAUSE FROM information_schema.CHECK_CONSTRAINTS WHERE CONSTRAINT_SCHEMA=:schema ORDER BY CONSTRAINT_NAME',
    ];
    $result=[];
    foreach ($queries as $kind=>$sql) {
        $query=$pdo->prepare($sql);$query->execute(['schema'=>$database]);$result[$kind]=$query->fetchAll(PDO::FETCH_ASSOC);
    }
    return $result;
}

function diagnosticDifferences(array $actual, array $reference): array
{
    $changes=[];
    foreach ($reference as $kind=>$rows) {
        $current=array_map(fn($r)=>json_encode($r,JSON_UNESCAPED_SLASHES),$actual[$kind]??[]);
        $expected=array_map(fn($r)=>json_encode($r,JSON_UNESCAPED_SLASHES),$rows);
        $missing=array_values(array_diff($expected,$current));$extra=array_values(array_diff($current,$expected));
        if ($missing||$extra) $changes[$kind]=['missing_or_incompatible'=>array_map(fn($r)=>json_decode($r,true),$missing),'additional_or_incompatible'=>array_map(fn($r)=>json_decode($r,true),$extra)];
    }
    return $changes;
}

try {
    $options=getopt('', ['reference:','fingerprints']);
    $reference=$options['reference']??null;
    if ($reference!==null&&(!is_string($reference)||!preg_match('/^[A-Za-z][A-Za-z0-9_]{0,63}$/D',$reference))) throw new InvalidArgumentException('Reference must be a database identifier.');
    $pdo=Database::getConnection();
    $pdo->exec('SET TRANSACTION READ ONLY');$pdo->beginTransaction();
    $connection=$pdo->query('SELECT DATABASE() AS connected_database,VERSION() AS server_version,CURRENT_USER() AS authenticated_account,@@character_set_connection AS connection_charset,@@collation_connection AS connection_collation,@@port AS server_port,@@bind_address AS server_bind_address')->fetch();
    $database=(string)$connection['connected_database'];
    $schema=diagnosticSchema($pdo,$database);
    $result=['generated_at_utc'=>gmdate('c'),'mode'=>'READ_ONLY','configuration'=>[],'connection'=>$connection,'schema'=>$schema,'migrations'=>[],'row_counts'=>[],'grants'=>[]];
    foreach (['APP_ENV','DB_HOST','DB_PORT','DB_NAME','DB_USER','DB_CHARSET'] as $key) $result['configuration'][$key]=Env::get($key);
    foreach($schema['tables'] as $table) {
        $name=$table['TABLE_NAME'];
        if(!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D',$name)) throw new RuntimeException('Unsupported table identifier.');
        $result['row_counts'][$name]=(int)$pdo->query('SELECT COUNT(*) FROM `'.$name.'`')->fetchColumn();
        if(array_key_exists('fingerprints',$options)) {
            $hash=hash_init('sha256');$rows=$pdo->query('SELECT * FROM `'.$name.'` ORDER BY 1');
            while($row=$rows->fetch(PDO::FETCH_ASSOC)) hash_update($hash,json_encode($row,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR)."\n");
            $result['row_fingerprints'][$name]=hash_final($hash);
        }
    }
    if(array_key_exists('migrations',$result['row_counts'])) $result['migrations']=$pdo->query('SELECT migration FROM migrations ORDER BY migration')->fetchAll(PDO::FETCH_COLUMN);
    foreach($pdo->query('SHOW GRANTS')->fetchAll(PDO::FETCH_COLUMN) as $grant) {
        preg_match('/^GRANT (.*?) ON (.*?) TO /',$grant,$match);
        $result['grants'][]=isset($match[2])?['privileges'=>$match[1],'scope'=>$match[2]]:['unparsed'=>true];
    }
    if($reference!==null) {
        $q=$pdo->prepare('SELECT COUNT(*) FROM information_schema.SCHEMATA WHERE SCHEMA_NAME=:schema');$q->execute(['schema'=>$reference]);
        if((int)$q->fetchColumn()!==1) throw new InvalidArgumentException('Reference schema does not exist. No schema was created or modified.');
        $differences=diagnosticDifferences($schema,diagnosticSchema($pdo,$reference));
        $result['comparison']=['reference'=>$reference,'matches'=>$differences===[],'differences'=>$differences];
    }
    $pdo->rollBack();$result['no_mutations']=true;
    echo json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR).PHP_EOL;
} catch (Throwable $error) {
    if(isset($pdo)&&$pdo->inTransaction()) $pdo->rollBack();
    fwrite(STDERR,'Diagnostic failed ['.get_class($error).']. Check protected server configuration; no credentials or exception details were printed.'.PHP_EOL);
    exit(1);
}
