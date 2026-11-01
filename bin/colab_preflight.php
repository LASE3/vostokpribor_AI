<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
require __DIR__.'/../app/bootstrap.php';
$provider = new App\Execution\ColabEnterpriseProvider();
$result = $provider->availability();
if (in_array('--probe-google', $argv, true)) {
    try { $result['google_probe'] = $provider->probe(); }
    catch (Throwable $e) { $result['google_probe'] = ['status'=>'FAILED_OR_NOT_CONFIGURED', 'http_status'=>in_array($e->getCode(),[400,401,403,404,429],true)?$e->getCode():null]; }
}
echo json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES).PHP_EOL;
exit(78); // Always unavailable until provider-backed acceptance permits activation.
