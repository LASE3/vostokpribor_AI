<?php

declare(strict_types=1);

$rangeSystem = 'ml';
$rangePage = 'ModelArtifacts';

require_once __DIR__ . '/../app/Views/range_context.php';
require_once __DIR__ . '/../app/Views/Layout/AppLayout.php';

use App\Views\Layout\AppLayout;

AppLayout::start([
    'pageTitle' => 'VOSTOKPRIBOR AI · Model Artifacts',
    'systemKey' => 'workbench',
    'activePage' => 'ModelArtifacts.php',
    'currentUser' => $currentUser,
]);

require __DIR__ . '/../app/Views/range_panels.php';

AppLayout::end([
    'extraScriptsHtml' => '<script src="js/main.js"></script><script src="../assets/js/range-client.js"></script>',
]);
