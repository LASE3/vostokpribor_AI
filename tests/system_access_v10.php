<?php
declare(strict_types=1);
// Pure role/navigation contracts: no bootstrap, session, DB connection or user data.
if (PHP_SAPI !== 'cli') { http_response_code(403); exit; }
foreach (['Env', 'AppUrl', 'SystemAccess'] as $class) require_once __DIR__ . '/../app/Core/' . $class . '.php';
require_once __DIR__ . '/../app/Views/Layout/Header.php';
require_once __DIR__ . '/../app/Views/Layout/Sidebar.php';
use App\Core\SystemAccess;
$checks = 0;
$check = static function (bool $condition, string $label) use (&$checks): void {
    if (!$condition) throw new RuntimeException($label);
    ++$checks; echo 'PASS ' . $label . PHP_EOL;
};
$check(SystemAccess::allowedSystems('STUDENT') === ['project','data','workbench','registry'], 'Student systems are exactly the four permitted systems');
$check(SystemAccess::allowedSystems('ADMIN') === ['soc'], 'Administrator application is only SOC');
$check(SystemAccess::allowedSystems('UNKNOWN') === [], 'Unknown roles fail closed');
$root = dirname(__DIR__);
foreach (['AI Project Management'=>'project', 'Data Center'=>'data', 'ML Workbench'=>'workbench', 'Model Registry & Deployment'=>'registry', 'AI Operations Center (AI SOC)'=>'soc'] as $folder => $key) {
    $script = $root . '/' . $folder . '/' . ($key === 'data' || $key === 'registry' ? 'dashboard.php' : 'Dashboard.php');
    $check(SystemAccess::pageSystem($script) === $key, 'Executing file classified: ' . $key);
    $check(SystemAccess::pageSystem(str_replace('/', '\\', $script), $root) === $key, 'Windows separators classified: ' . $key);
    $check(SystemAccess::canOpenSystem('STUDENT', $key) === ($key !== 'soc'), 'Student page boundary: ' . $key);
    $check(SystemAccess::canOpenSystem('ADMIN', $key) === ($key === 'soc'), 'Administrator page boundary: ' . $key);
}
$check(SystemAccess::pageSystem($root . '/api/v1/index.php') === null, 'API privilege decisions remain in API services');
$check(SystemAccess::pageSystem($root . '-other/ML Workbench/Dashboard.php') === null, 'Sibling prefix is not the application root');
putenv('APP_URL=http://127.0.0.1/nested/range');
$check(SystemAccess::loginDestination(['role'=>'ADMIN']) === '/nested/range/' . SystemAccess::SOC_HOME, 'Administrator login uses exact installation prefix and SOC Dashboard');
$check(SystemAccess::loginDestination(['role'=>'STUDENT']) === '/nested/range/index.php', 'Student login opens student portal');
foreach (['ADMIN','STUDENT'] as $role) {
    $check(SystemAccess::loginDestination(['role'=>$role,'must_change_password'=>1]) === '/nested/range/change-password.php', 'Mandatory password change precedes application: ' . $role);
}
$student = ['role'=>'STUDENT','full_name'=>'Navigation Check','identifier'=>'unit'];
$admin = ['role'=>'ADMIN','full_name'=>'Navigation Check','identifier'=>'unit'];
foreach (SystemAccess::STUDENT_SYSTEMS as $key) {
    $sidebar = renderSidebar(['systemKey'=>$key,'currentUser'=>$student,'basePath'=>'..']);
    $header = renderHeader(['currentUser'=>$student,'unreadCount'=>0,'basePath'=>'..']);
    $check(!str_contains($sidebar . $header, 'AI Operations Center') && !str_contains($sidebar . $header, 'SOC Dashboard'), 'Student header and navigation contain no SOC destination: ' . $key);
    $check(str_contains($sidebar, '../index.php'), 'Student system retains student portal navigation: ' . $key);
}
$sidebar = renderSidebar(['systemKey'=>'soc','currentUser'=>$admin,'basePath'=>'..']);
$header = renderHeader(['currentUser'=>$admin,'unreadCount'=>0,'basePath'=>'..']);
foreach (['AI Project Management','Data Center','ML Workbench','Model Registry'] as $folder) {
    $check(!str_contains($sidebar . $header, 'href="../' . $folder . '/'), 'SOC shell does not launch a student application: ' . $folder);
}
$check(str_contains($header, '../AI Operations Center (AI SOC)/Dashboard.php'), 'Administrator header home is SOC Dashboard');
$check(!str_contains(renderSidebarNavigation(['systemKey'=>'soc','currentUser'=>$student]), 'href='), 'Forged student SOC navigation request has no links');
$check(!str_contains(renderSidebarNavigation(['systemKey'=>'project','currentUser'=>$admin]), 'href='), 'Forged administrator student navigation request has no links');
echo 'PASS ALL ' . $checks . ' system-access and navigation checks; no database connection.' . PHP_EOL;
