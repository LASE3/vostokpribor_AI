<?php

declare(strict_types=1);

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Unified Header Component
 * 
 * Contains STRICTLY:
 * LEFT SIDE:
 * 1. Official VOSTOKPRIBOR logo (assets/branding/logo.svg)
 * 2. Company name (VOSTOKPRIBOR + AI ENGINEERING RANGE)
 * RIGHT SIDE:
 * 1. Notification icon
 * 2. Mini user profile
 * 3. Sign Out button
 */

require_once __DIR__ . '/NotificationsButton.php';
require_once __DIR__ . '/UserProfile.php';

/**
 * @param array{
 *     currentUser: array,
 *     unreadCount?: int,
 *     basePath?: string
 * } $params
 */
function renderHeader(array $params): string
{
    $currentUser = $params['currentUser'] ?? [];
    $unreadCount = (int)($params['unreadCount'] ?? 0);
    $basePath = rtrim((string)($params['basePath'] ?? '..'), '/');

    $logoUrl = htmlspecialchars($basePath . '/assets/branding/logo.svg', ENT_QUOTES, 'UTF-8');
    $homeUrl = htmlspecialchars($basePath . '/index.php', ENT_QUOTES, 'UTF-8');
    $logoutUrl = htmlspecialchars($basePath . '/logout.php', ENT_QUOTES, 'UTF-8');

    $notifHtml = renderNotificationsButton([
        'unreadCount' => $unreadCount,
        'basePath' => $basePath,
        'currentUser' => $currentUser,
    ]);

    $profileHtml = renderUserProfile([
        'currentUser' => $currentUser,
        'basePath' => $basePath,
    ]);

    return <<<HTML
    <header class="vp-header" role="banner">
        <!-- Left Section: Mobile Menu Button + Official Company Logo & Name -->
        <div class="vp-header-left">
            <button type="button" id="vp-sidebar-toggle" class="vp-header-menu-toggle" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="vp-sidebar">
                <span class="material-symbols-outlined text-[22px]">menu</span>
            </button>

            <a href="{$homeUrl}" class="vp-brand-link" title="VOSTOKPRIBOR Flight Deck Home">
                <img src="{$logoUrl}" alt="VOSTOKPRIBOR Official Logo" class="vp-brand-logo" width="38" height="38" />
                <div class="vp-brand-text">
                    <span class="vp-brand-title">VOSTOKPRIBOR</span>
                    <span class="vp-brand-subtitle">AI ENGINEERING RANGE</span>
                </div>
            </a>
        </div>

        <!-- Right Section: Notifications + Mini Profile + Sign Out -->
        <div class="vp-header-right">
            {$notifHtml}
            {$profileHtml}
            <a href="{$logoutUrl}" class="vp-signout-btn" title="Sign out of flight session">
                <span class="material-symbols-outlined">logout</span>
                <span>Sign Out</span>
            </a>
        </div>
    </header>
HTML;
}
