<?php

declare(strict_types=1);

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Unified Header Notifications Button Component
 */

/**
 * @param array{
 *     unreadCount?: int,
 *     basePath?: string,
 *     link?: string
 * } $params
 */
function renderNotificationsButton(array $params = []): string
{
    $unreadCount = (int)($params['unreadCount'] ?? 0);
    $basePath = rtrim((string)($params['basePath'] ?? '..'), '/');
    $link = (string)($params['link'] ?? '#notifications');

    $badgeHtml = '';
    if ($unreadCount > 0) {
        $displayCount = $unreadCount > 99 ? '99+' : (string)$unreadCount;
        $badgeHtml = '<span class="vp-notif-badge" aria-label="' . $unreadCount . ' unread notifications">'
            . htmlspecialchars($displayCount, ENT_QUOTES, 'UTF-8')
            . '</span>';
    }

    return <<<HTML
    <a href="{$link}" id="vp-notif-btn" class="vp-notif-btn" title="View notifications" aria-label="Notifications">
        <span class="material-symbols-outlined text-[20px]">notifications</span>
        {$badgeHtml}
    </a>
HTML;
}
