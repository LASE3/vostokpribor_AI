<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';
require_once __DIR__ . '/../app/Views/Layout/AppLayout.php';

use App\Middleware\AuthorizationMiddleware;
use App\Core\Auth;
use App\Views\Layout\AppLayout;

AuthorizationMiddleware::requireAdmin();
$currentUser = Auth::user();
$rangePage = 'DatasetManagement';

AppLayout::start([
    'pageTitle' => 'VOSTOKPRIBOR AI · SOC Dataset Management',
    'systemKey' => 'soc',
    'activePage' => 'DatasetManagement.php',
    'currentUser' => $currentUser,
]);

require __DIR__ . '/../app/Views/DataPage.php';

AppLayout::end([
    'extraScriptsHtml' => '<script src="../assets/js/range-client.js"></script>',
]);
