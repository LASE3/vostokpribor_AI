<?php

declare(strict_types=1);

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Unified Header Mini User Profile Component
 */

/**
 * @param array{
 *     currentUser: array,
 *     basePath?: string
 * } $params
 */
function renderUserProfile(array $params): string
{
    $user = $params['currentUser'] ?? [];
    $fullName = trim((string)($user['full_name'] ?? 'User'));
    $role = strtoupper(trim((string)($user['role'] ?? 'CADET')));
    $identifier = trim((string)($user['identifier'] ?? $user['email'] ?? ''));

    // Format readable display role
    $displayRole = $role === 'ADMIN' ? 'Commander (Admin)' : 'Cadet (' . ($identifier ?: 'Student') . ')';

    // Generate avatar initials (e.g. "SA" or "VP")
    $words = explode(' ', $fullName);
    $initials = '';
    if (!empty($words[0])) {
        $initials .= mb_substr($words[0], 0, 1);
    }
    if (count($words) > 1 && !empty($words[count($words) - 1])) {
        $initials .= mb_substr($words[count($words) - 1], 0, 1);
    }
    $initials = strtoupper($initials ?: 'VP');

    $safeName = htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8');
    $safeRole = htmlspecialchars($displayRole, ENT_QUOTES, 'UTF-8');

    return <<<HTML
    <div class="vp-user-profile" title="Signed in as {$safeName} ({$safeRole})">
        <div class="vp-user-avatar" aria-hidden="true">
            {$initials}
        </div>
        <div class="vp-user-info">
            <span class="vp-user-name">{$safeName}</span>
            <span class="vp-user-role">{$safeRole}</span>
        </div>
    </div>
HTML;
}
