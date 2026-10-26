<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/Views/Layout/AppLayout.php';

use App\Middleware\AuthenticationMiddleware;
use App\Views\Layout\AppLayout;

$currentUser = AuthenticationMiddleware::handle();
$rangePage = 'DataProfilingAndQuality';

AppLayout::start([
    'pageTitle' => 'VOSTOKPRIBOR AI · Data Profiling & Quality',
    'systemKey' => 'data',
    'activePage' => 'DataProfilingAndQuality.php',
    'currentUser' => $currentUser,
]);

require __DIR__ . '/../app/Views/DataPage.php';

AppLayout::end([
    'extraScriptsHtml' => '<script src="js/main.js"></script><script src="../assets/js/range-client.js"></script>',
]);
