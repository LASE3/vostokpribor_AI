<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

use App\Core\Auth;
use App\Core\Logger;
use App\Core\Response;

$user = Auth::user();
if ($user) {
    Logger::audit('LOGOUT', 'users', (string)$user['id'], 'SUCCESS');
}

Auth::logout();
Response::redirect('/vostokpribor_AI/login.php');
