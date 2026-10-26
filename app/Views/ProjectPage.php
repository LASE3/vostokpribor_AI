<?php
use App\Core\Database;
use App\Services\TicketService;
use App\Services\SubmissionService;
require_once __DIR__ . '/RangeUi.php';
$uid=(int)$currentUser['id'];$role=$currentUser['role'];$admin=$role==='ADMIN';
$ticketsService=new TicketService();$submissionService=new SubmissionService();$message='';
if (($_SERVER['REQUEST_METHOD'] ?? 'GET')==='POST') {
    try {
        if (!\App\Core\Csrf::validate($_POST['csrf_token']??null)) throw new RuntimeException('Invalid CSRF token.');
        $id=(int)($_POST['ticket_id']??0);
        switch($_POST['action']??'') {
            case 'progress':$ticketsService->updateTicket($id,['status'=>'IN_PROGRESS'],$uid,$role);$message='Progress saved.';break;
            case 'comment':$ticketsService->addComment($id,$uid,trim($_POST['comment']??''));$message='Comment saved.';break;
            case 'submit':if($admin)throw new RuntimeException('Only students submit work.');$submissionService->createSubmission($_POST,$uid);$message='Submission saved for instructor review.';break;
            default:throw new RuntimeException('Unsupported action.');
        }
    }catch(Throwable $e){http_response_code(422);$message=$e->getMessage();}
}
$tickets=$ticketsService->listTicketsForUser($uid,$role);
$submissions=$submissionService->listSubmissions($uid,$role);
echo '<div class="flex flex-col gap-5 pt-6"><h1 class="font-headline-lg text-headline-lg text-primary font-bold">'.rangeEscape(['Dashboard'=>'Project Management','Tickets'=>'Assigned Tickets','TicketDetails'=>'Ticket Details','Submissions'=>'Submissions','StudentProfile'=>'Student Profile'][$rangePage]).'</h1>';
if($message)rangeCard('Result','<p role="status">'.rangeEscape($message).'</p>');
if($rangePage==='Dashboard'||$rangePage==='StudentProfile'){
    $target=$uid;
    if($admin && !empty($_GET['id'])) $target=(int)$_GET['id'];
    $profile=Database::queryOne('SELECT id,full_name,identifier,email,role,cohort,department FROM users WHERE id=:id',['id'=>$target]);
    if(!$profile){http_response_code(404);rangeCard('Unavailable','Profile not found.');}else{
        $stats=[];foreach(['Assigned tickets'=>'ticket_assignments','Submissions'=>'submissions','Notebooks'=>'notebooks','Models'=>'models','Notifications'=>'notifications'] as $label=>$table){$col=$table==='notifications'?'user_id':'student_id';$stats[$label]=(int)Database::queryOne("SELECT COUNT(*) AS c FROM $table WHERE $col=:id",['id'=>$target])['c'];}
        $body='<p>'.rangeEscape($profile['full_name']).' · '.rangeEscape($profile['identifier']).' · '.rangeEscape($profile['role']).'</p><p>'.rangeEscape($profile['email']).'</p><div class="grid grid-cols-2 lg:grid-cols-5 gap-5">';foreach($stats as $label=>$count)$body.='<div>'.rangeEscape($label).'<p class="text-3xl text-primary font-bold">'.$count.'</p></div>';
        rangeCard('Profile & persisted work',$body.'</div><p>GPU, computing utilization and SLA metrics: NOT AVAILABLE.</p><a class="text-primary underline" href="../change-password.php">Change password</a>');
    }
    $notifications=Database::query('SELECT title,message,created_at FROM notifications WHERE user_id=:id ORDER BY id DESC LIMIT 20',['id'=>$uid]);$rows=[];foreach($notifications as $n)$rows[]=[rangeEscape($n['created_at']),rangeEscape($n['title']),rangeEscape($n['message'])];rangeCard('Notifications',rangeTable(['Time','Title','Message'],$rows,'No notifications'));
}
if($rangePage==='TicketDetails'){
    $id=(int)($_GET['id']??$_POST['ticket_id']??0);
    if(!$id){rangeCard('Assigned ticket','Select a ticket from <a href="Tickets.php" class="text-primary underline">Assigned Tickets</a>.');}
    else try{
        $ticket=$ticketsService->getTicket($id,$uid,$role);
        $body='<p class="font-code-sm text-code-sm">'.rangeEscape($ticket['ticket_code']).' · '.rangeEscape($ticket['status']).'</p><p>'.nl2br(rangeEscape($ticket['description'])).'</p><p>Deadline: '.rangeEscape($ticket['deadline']??'No deadline').'</p><h3 class="font-bold">Requirements</h3><p>'.nl2br(rangeEscape($ticket['requirements'])).'</p><h3 class="font-bold">Acceptance criteria</h3><p>'.nl2br(rangeEscape($ticket['acceptance_criteria'])).'</p>';
        if(!$admin&&in_array($ticket['status'],['ASSIGNED','CHANGES_REQUESTED'],true))$body.=rangeForm('progress','<input type="hidden" name="ticket_id" value="'.$id.'">','Start / resume work');
        rangeCard($ticket['title'],$body);
        $comments=Database::query('SELECT c.comment,c.created_at,u.full_name FROM ticket_comments c JOIN users u ON u.id=c.user_id WHERE c.ticket_id=:id ORDER BY c.id',['id'=>$id]);$rows=[];foreach($comments as $c)$rows[]=[rangeEscape($c['created_at']),rangeEscape($c['full_name']),rangeEscape($c['comment'])];
        rangeCard('Discussion',rangeTable(['Time','Author','Comment'],$rows,'No comments').rangeForm('comment','<input type="hidden" name="ticket_id" value="'.$id.'">'.rangeInput('comment','Comment'),'Save comment'));
        $ds=Database::query('SELECT DISTINCT d.id,d.code,d.name FROM datasets d JOIN dataset_assignments da ON da.dataset_id=d.id WHERE da.ticket_id=:tid'.($admin?'':' AND da.student_id=:uid'),$admin?['tid'=>$id]:['tid'=>$id,'uid'=>$uid]);$rows=[];foreach($ds as $d)$rows[]=[rangeEscape($d['code']),rangeEscape($d['name']),'<a class="text-primary underline" href="../Data Center/DatasetCatalog.php?id='.(int)$d['id'].'">Open assigned dataset</a>'];rangeCard('Assigned datasets',rangeTable(['Code','Name','Actions'],$rows,'No datasets'));
        if(!$admin){$nb=Database::query('SELECT id,title FROM notebooks WHERE student_id=:uid AND ticket_id=:tid',['uid'=>$uid,'tid'=>$id]);$models=Database::query('SELECT id,name FROM models WHERE student_id=:uid AND ticket_id=:tid',['uid'=>$uid,'tid'=>$id]);$nopts=[];$mopts=[];foreach($nb as $n)$nopts[$n['id']]=$n['title'];foreach($models as $m)$mopts[$m['id']]=$m['name'];
            $fields='<input type="hidden" name="ticket_id" value="'.$id.'">'.rangeInput('notes','Submission notes');
            if($nopts)$fields.=str_replace(' required ',' ',rangeSelect('notebook_id','Notebook (optional)',$nopts));
            if($mopts)$fields.=str_replace(' required ',' ',rangeSelect('model_id','Model (optional)',$mopts));
            rangeCard('Submit deliverables',rangeForm('submit',$fields,'Submit for review'));
        }
    }catch(Throwable $e){http_response_code(403);rangeCard('Ticket unavailable',rangeEscape($e->getMessage()));}
}elseif($rangePage!=='StudentProfile'&&$rangePage!=='Submissions'){
    $rows=[];foreach($tickets as $t)$rows[]=[rangeEscape($t['ticket_code']),rangeEscape($t['title']),rangeEscape($t['status']),rangeEscape($t['priority']),rangeEscape($t['deadline']??'No deadline'),'<a class="text-primary underline" href="TicketDetails.php?id='.(int)$t['id'].'">Inspect</a>'];rangeCard('Assigned tickets',rangeTable(['Code','Title','Status','Priority','Deadline','Actions'],$rows,'No assigned tickets'));
}
if(in_array($rangePage,['Dashboard','Submissions','TicketDetails'],true)){
    $rows=[];foreach($submissions as $s){if($rangePage==='TicketDetails'&&(int)$s['ticket_id']!==(int)($_GET['id']??$_POST['ticket_id']??0))continue;$rows[]=[rangeEscape($s['submission_code']),rangeEscape($s['ticket_code']??$s['ticket_id']),rangeEscape($s['status']),rangeEscape($s['notes']),rangeEscape($s['feedback']??'Awaiting review'),rangeEscape($s['total_score']??'NOT EVALUATED')];}rangeCard('Submitted work & reviewer decisions',rangeTable(['Submission','Ticket','Status','Notes','Feedback','Score'],$rows,'No submissions'));
}
echo '</div>';
