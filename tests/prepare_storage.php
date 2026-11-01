<?php
declare(strict_types=1);
if(PHP_SAPI!=='cli'){http_response_code(403);exit;}
require __DIR__.'/../app/bootstrap.php';require __DIR__.'/TestStorage.php';
try{testRequireIsolatedStorage(true);echo "Prepared isolated test storage identity; no database rows or existing uploads changed.\n";}
catch(Throwable $error){fwrite(STDERR,$error->getMessage().PHP_EOL);exit(1);}
