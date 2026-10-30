<?php
declare(strict_types=1);
require_once __DIR__.'/../app/bootstrap.php';
use App\Core\Auth;
use App\Middleware\AuthorizationMiddleware;
use App\Services\SocSystemService;
use App\Views\Layout\AppLayout;
AuthorizationMiddleware::requireAdmin();$currentUser=Auth::user();$error='';
try{$events=(new SocSystemService())->activity((int)$currentUser['id'],$_GET);}catch(\InvalidArgumentException $e){http_response_code(422);$error=$e->getMessage();$events=['items'=>[],'total'=>0,'offset'=>0,'limit'=>50];}
$h=static fn($v)=>htmlspecialchars((string)($v??''),ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');
AppLayout::start(['systemKey'=>'soc','activePage'=>'AuditLogs.php','pageTitle'=>'Audit Logs','contentTitle'=>'Audit Logs','contentDescription'=>'Persisted actor, resource and outcome evidence','currentUser'=>$currentUser]);
?>
<section class="vp-card"><div class="vp-card-header"><h2 class="vp-card-title">Filter actual events</h2></div><form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4"><label class="vp-form-group"><span class="vp-label">Action</span><input class="vp-input" name="action" value="<?= $h(is_scalar($_GET['action']??'')?$_GET['action']??'':'') ?>"></label><label class="vp-form-group"><span class="vp-label">Actor ID</span><input class="vp-input" name="actor_id" type="number" min="1" value="<?= $h(is_scalar($_GET['actor_id']??'')?$_GET['actor_id']??'':'') ?>"></label><label class="vp-form-group"><span class="vp-label">Outcome</span><select class="vp-select" name="outcome"><option value="">All outcomes</option><?php foreach(['SUCCESS','FAILURE','DENIED'] as $value):?><option <?= ($_GET['outcome']??'')===$value?'selected':'' ?>><?= $value ?></option><?php endforeach;?></select></label><button class="vp-btn vp-btn-primary self-end" type="submit">Apply filters</button></form></section>
<?php if($error):?><p class="vp-card mt-6 text-rose-700" role="alert"><?= $h($error) ?></p><?php endif;?>
<section class="vp-card mt-6"><div class="vp-card-header"><h2 class="vp-card-title"><?= (int)$events['total'] ?> matching events</h2></div><div class="vp-table-container"><table class="vp-table"><thead><tr><th>Time</th><th>Actor</th><th>Action</th><th>Resource</th><th>Outcome</th><th>Metadata</th></tr></thead><tbody><?php if(!$events['items']):?><tr><td colspan="6" class="p-10 text-center">No audit events</td></tr><?php endif;foreach($events['items'] as $row):?><tr><td><?= $h($row['created_at']) ?></td><td><?= $h($row['actor_name']??'System') ?> #<?= $h($row['actor_id']) ?></td><td><?= $h($row['action']) ?></td><td><?= $h($row['resource_type']) ?> #<?= $h($row['resource_id']) ?></td><td><?= $h($row['outcome']) ?></td><td class="max-w-sm break-all text-xs font-mono"><?= $h($row['metadata_json']) ?></td></tr><?php endforeach;?></tbody></table></div><?php if($events['offset']+$events['limit']<$events['total']):?><a class="vp-btn vp-btn-secondary mt-4" href="?<?= $h(http_build_query(array_merge($_GET,['offset'=>$events['offset']+$events['limit']]))) ?>">Older events</a><?php endif;?></section>
<?php AppLayout::end(['extraScriptsHtml'=>'<script src="../assets/js/range-client.js"></script>']); ?>
