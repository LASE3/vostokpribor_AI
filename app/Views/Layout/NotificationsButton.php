<?php

declare(strict_types=1);

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Unified Header Notifications Button & Accessible Popover Component
 */

/**
 * @param array{
 *     unreadCount?: int,
 *     basePath?: string,
 *     currentUser?: array
 * } $params
 */
function renderNotificationsButton(array $params = []): string
{
    $unreadCount = (int)($params['unreadCount'] ?? 0);
    $basePath = rtrim((string)($params['basePath'] ?? '..'), '/');
    $currentUser = $params['currentUser'] ?? [];
    $isStudent = strcasecmp((string)($currentUser['role'] ?? ''), 'STUDENT') === 0;

    $badgeHtml = '';
    if ($unreadCount > 0) {
        $displayCount = $unreadCount > 99 ? '99+' : (string)$unreadCount;
        $badgeHtml = '<span class="vp-notif-badge" aria-label="' . $unreadCount . ' unread notifications">'
            . htmlspecialchars($displayCount, ENT_QUOTES, 'UTF-8')
            . '</span>';
    }

    $footerLink = $isStudent
        ? htmlspecialchars($basePath . '/AI Project Management/StudentProfile.php#notifications', ENT_QUOTES, 'UTF-8')
        : htmlspecialchars($basePath . '/AI Operations Center (AI SOC)/OperationsDashboard.php', ENT_QUOTES, 'UTF-8');
    $footerLabel = $isStudent
        ? 'View Cadet Notification History →'
        : 'Open SOC Operations Telemetry →';

    return <<<HTML
    <div class="vp-notif-container" id="vp-notif-container">
        <button type="button" id="vp-notif-btn" class="vp-notif-btn" title="View notifications" aria-label="Notifications" aria-haspopup="true" aria-expanded="false">
            <span class="material-symbols-outlined text-[20px]">notifications</span>
            {$badgeHtml}
        </button>

        <div id="vp-notif-popover" class="vp-notif-popover" role="dialog" aria-label="Operational Notifications" aria-hidden="true">
            <div class="vp-notif-header">
                <span class="vp-notif-title">Operational Notifications</span>
                <span class="font-mono text-[10px] text-slate-500 font-bold bg-lavender px-1.5 py-0.5 rounded">{$unreadCount} UNREAD</span>
            </div>
            <div class="vp-notif-body">
                <div class="vp-empty-state border-0 bg-transparent py-4 text-center">
                    <span class="material-symbols-outlined vp-empty-icon text-2xl text-slate-400 mb-1">notifications_none</span>
                    <p class="vp-empty-title text-xs font-bold text-slate-700">No unread notifications</p>
                    <p class="vp-empty-desc text-[11px] text-slate-500 mt-0.5">All training scenario alerts and range system events are current.</p>
                </div>
            </div>
            <div class="vp-notif-footer">
                <a href="{$footerLink}" class="vp-notif-footer-link">{$footerLabel}</a>
            </div>
        </div>
    </div>
HTML;
}
