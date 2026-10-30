<?php
namespace App\Controllers;

use App\Core\Request;
use App\Middleware\AuthorizationMiddleware;

/** SOC uses the same dataset operations with an explicit independent administrator gate. */
class SocDatasetController extends DatasetController
{
    public function index(Request $r):void{AuthorizationMiddleware::requireAdmin(true);parent::index($r);}
    public function show(Request $r,array $p):void{AuthorizationMiddleware::requireAdmin(true);parent::show($r,$p);}
    public function preview(Request $r,array $p):void{AuthorizationMiddleware::requireAdmin(true);parent::preview($r,$p);}
    public function download(Request $r,array $p):void{AuthorizationMiddleware::requireAdmin(true);parent::download($r,$p);}
    public function versions(Request $r,array $p):void{AuthorizationMiddleware::requireAdmin(true);parent::versions($r,$p);}
}
