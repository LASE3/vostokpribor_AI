<?php
declare(strict_types=1);
require_once __DIR__.'/../app/bootstrap.php';
require_once __DIR__.'/../app/Views/Layout/AppLayout.php';
\App\Middleware\AuthorizationMiddleware::requireAdmin();
$currentUser=\App\Core\Auth::user();
$socPage='StudentWorkspaces';
\App\Views\Layout\AppLayout::start(['pageTitle'=>'VOSTOKPRIBOR AI · Student Workspace Inspection','systemKey'=>'soc','activePage'=>'StudentWorkspaces.php','currentUser'=>$currentUser]);
require __DIR__.'/_workspace_admin.php';
\App\Views\Layout\AppLayout::end(['extraScriptsHtml'=>'<script src="../assets/js/range-client.js"></script><script src="../assets/js/soc-workspaces.js"></script>']);
