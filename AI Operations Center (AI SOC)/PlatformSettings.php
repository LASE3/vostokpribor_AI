<?php
declare(strict_types=1);
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\{Auth,Csrf};
use App\Middleware\AuthorizationMiddleware;
use App\Services\SocSystemService;
use App\Views\Layout\AppLayout;
AuthorizationMiddleware::requireAdmin();$currentUser=Auth::user();$service=new SocSystemService();$error='';
if(($_SERVER['REQUEST_METHOD']??'GET')==='POST'){
    try{$service->saveSetting((int)$currentUser['id'],$_POST);header('Location: PlatformSettings.php?saved=1',true,303);exit;}
    catch(\InvalidArgumentException $e){http_response_code(422);$error=$e->getMessage();}
}
$settings=$service->settings((int)$currentUser['id']);$values=array_column($settings,'setting_value','setting_key');$health=$service->health((int)$currentUser['id']);
$h=static fn($v)=>htmlspecialchars((string)$v,ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');
AppLayout::start(['systemKey'=>'soc','activePage'=>'PlatformSettings.php','pageTitle'=>'Platform Settings','contentTitle'=>'Workspace Configuration','contentDescription'=>'Administrator-authored guidance and measured service availability','currentUser'=>$currentUser]);
?>
<?php if($error):?><div role="alert" class="vp-card text-rose-700 mb-6"><?= $h($error) ?></div><?php endif;?>
<?php if(isset($_GET['saved'])):?><div role="status" class="vp-card mb-6">Setting persisted in MySQL.</div><?php endif;?>
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
<?php foreach(['platform_announcement'=>'Platform announcement','student_help_text'=>'Student help text'] as $key=>$label):?>
<section class="vp-card"><div class="vp-card-header"><h2 class="vp-card-title"><?= $h($label) ?></h2></div>
<form method="post" class="space-y-4" data-soc-setting><input type="hidden" name="csrf_token" value="<?= $h(Csrf::getToken()) ?>"><input type="hidden" name="key" value="<?= $key ?>"><label class="vp-form-group"><span class="vp-label"><?= $h($label) ?></span><textarea class="vp-input w-full min-h-32" name="value" maxlength="4000" rows="6"><?= $h($values[$key]??'') ?></textarea></label><p class="text-xs text-slate-500">Displayed as escaped text in the student project dashboard.</p><button class="vp-btn vp-btn-primary" type="submit">Save setting</button><p role="status" data-result></p></form></section>
<?php endforeach;?></div>
<section class="vp-card mt-6"><div class="vp-card-header"><h2 class="vp-card-title">Service availability</h2></div><div class="vp-table-container"><table class="vp-table"><thead><tr><th>Service</th><th>State</th><th>Evidence / limitation</th></tr></thead><tbody><?php foreach($health as $key=>$state):if(!is_array($state))continue;?><tr><td><?= $h(str_replace('_',' ',$key)) ?></td><td><?= $h($state['status']) ?></td><td><?= $h($state['evidence']??$state['reason']??'') ?></td></tr><?php endforeach;?></tbody></table></div><p class="text-xs text-slate-500">These settings cannot enable execution, certify model quality, or deploy an endpoint.</p></section>
<script>document.querySelectorAll('[data-soc-setting]').forEach(form=>form.addEventListener('submit',async event=>{if(!window.RangeClient)return;event.preventDefault();const button=form.querySelector('button');const result=form.querySelector('[data-result]');button.disabled=true;result.textContent='Saving…';try{const response=await RangeClient.patch('soc/settings',{key:form.elements.key.value,value:form.elements.value.value});result.textContent=response.success?'Setting persisted in MySQL.':response.error?.message||'Save failed.';}finally{button.disabled=false;}}));</script>
<?php AppLayout::end(['extraScriptsHtml'=>'<script src="../assets/js/range-client.js"></script>']); ?>
