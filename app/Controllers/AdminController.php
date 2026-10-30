<?php
namespace App\Controllers;
use App\Core\{Auth,Request,Response};
use App\Middleware\AuthorizationMiddleware;
use App\Services\SocSystemService;
final class AdminController
{
    private function run(callable $fn): void { AuthorizationMiddleware::requireAdmin(true);Response::success($fn(new SocSystemService(),(int)Auth::id())); }
    public function overview(Request $r): void {$this->run(fn($s,$a)=>$s->overview($a));}
    public function health(Request $r): void {$this->run(fn($s,$a)=>$s->health($a));}
    public function auditLogs(Request $r): void {$this->run(fn($s,$a)=>$s->activity($a,$r->query()));}
    public function getSettings(Request $r): void {$this->run(fn($s,$a)=>$s->settings($a));}
    public function updateSettings(Request $r): void {$this->run(fn($s,$a)=>$s->saveSetting($a,$r->body()));}
    public function ticketSummary(Request $r): void {$this->run(fn($s,$a)=>$s->summary($a,'tickets'));}
    public function datasetSummary(Request $r): void {$this->run(fn($s,$a)=>$s->summary($a,'datasets'));}
    public function modelSummary(Request $r): void {$this->run(fn($s,$a)=>$s->summary($a,'models'));}
}
