<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/Views/Layout/AppLayout.php';

use App\Middleware\AuthenticationMiddleware;
use App\Views\Layout\AppLayout;

$currentUser = AuthenticationMiddleware::handle();
$rangePage = 'Tickets';

AppLayout::start([
    'pageTitle' => 'VOSTOKPRIBOR AI · Assigned Tickets',
    'systemKey' => 'project',
    'activePage' => 'Tickets.php',
    'currentUser' => $currentUser,
]);

require __DIR__ . '/../app/Views/ProjectPage.php';

AppLayout::end([
    'extraScriptsHtml' => '<script src="../assets/js/range-client.js"></script>',
]);
