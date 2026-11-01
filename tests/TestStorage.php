<?php
declare(strict_types=1);
/** File-writing tests require a separately prepared code/storage tree, not process overrides alone. */
function testRequireIsolatedStorage(bool $prepare=false):void
{
    if(PHP_SAPI!=='cli')throw new RuntimeException('CLI-only test storage.');
    $root=realpath(dirname(__DIR__));$saved=[];
    if(!is_file($root.'/.env'))throw new RuntimeException('REFUSED: a saved isolated testing configuration is required.');
    foreach(file($root.'/.env',FILE_IGNORE_NEW_LINES)?:[] as $line){
        if(!preg_match('/^\s*([A-Z][A-Z0-9_]*)\s*=\s*(.*?)\s*$/D',$line,$match))continue;
        $value=trim($match[2]);if(strlen($value)>1&&(($value[0]==='"'&&str_ends_with($value,'"'))||($value[0]==="'"&&str_ends_with($value,"'"))))$value=substr($value,1,-1);
        $saved[$match[1]]=$value;
    }
    foreach(['APP_ENV','DB_NAME','DB_HOST','APP_URL','SESSION_COOKIE_NAME'] as $key)if(!isset($saved[$key])||$saved[$key]!==\App\Core\Env::get($key))throw new RuntimeException('REFUSED: saved test configuration must match the executed instance; environment-only overrides cannot select test storage.');
    if($saved['APP_ENV']!=='testing'||!str_ends_with($saved['DB_NAME'],'_test')||!str_ends_with($saved['SESSION_COOKIE_NAME'],'_test')||!in_array($saved['DB_HOST'],['localhost','127.0.0.1','::1'],true)||!in_array(parse_url($saved['APP_URL'],PHP_URL_HOST),['localhost','127.0.0.1','::1'],true))throw new RuntimeException('REFUSED: isolated saved testing instance required.');
    $marker=$root.'/.vostok-test-storage';$identity=['root'=>str_replace('\\','/',$root),'database'=>$saved['DB_NAME']];
    if($prepare&&!is_file($marker)){
        foreach(['datasets','models','sandboxes'] as $folder){
            $directory=$root.'/storage/private/'.$folder;if(!is_dir($directory))throw new RuntimeException('Missing storage control directory.');
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory,FilesystemIterator::SKIP_DOTS)) as $file)if($file->isLink()||($file->isFile()&&!in_array($file->getFilename(),['.gitkeep','.htaccess'],true)))throw new RuntimeException('REFUSED: test storage preparation requires empty payload directories; no uploads were removed.');
        }
        $handle=fopen($marker,'x');if(!$handle)throw new RuntimeException('Cannot exclusively create storage marker.');fwrite($handle,json_encode($identity,JSON_THROW_ON_ERROR));fclose($handle);
    }
    if(!is_file($marker)||is_link($marker)||json_decode(file_get_contents($marker),true,16,JSON_THROW_ON_ERROR)!==$identity)throw new RuntimeException('REFUSED: prepare a separate empty test code/storage tree before file-writing tests.');
}
