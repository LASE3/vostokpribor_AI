<?php

declare(strict_types=1);

namespace App\Views\Layout;

use App\Core\Database;

require_once __DIR__ . '/Header.php';
require_once __DIR__ . '/Sidebar.php';
require_once __DIR__ . '/PageContainer.php';

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Master Application Layout
 */
class AppLayout
{
    /**
     * Compute relative base path from the executing script to the project root.
     */
    public static function getBasePath(): string
    {
        $scriptDir = dirname($_SERVER['SCRIPT_FILENAME'] ?? '');
        $rootName = 'vostokpribor_AI';
        
        if (basename($scriptDir) === $rootName) {
            return '.';
        }
        return '..';
    }

    /**
     * Fetch unread notification count for the signed-in user.
     */
    public static function getUnreadNotificationsCount(int $userId): int
    {
        if ($userId <= 0) return 0;
        try {
            return (int)(Database::queryOne(
                'SELECT COUNT(*) AS n FROM notifications WHERE user_id = :id AND is_read = 0',
                ['id' => $userId]
            )['n'] ?? 0);
        } catch (\Throwable) {
            return 0;
        }
    }

    /**
     * Render the opening HTML document, <head>, Header, Sidebar, and Page Container start.
     *
     * @param array{
     *     pageTitle?: string,
     *     systemKey: string,
     *     activePage?: string,
     *     currentUser: array,
     *     unreadCount?: int,
     *     basePath?: string,
     *     extraHeadHtml?: string,
     *     contentTitle?: string,
     *     contentDescription?: string,
     *     contentActions?: string
     * } $options
     */
    public static function start(array $options): void
    {
        $basePath = $options['basePath'] ?? self::getBasePath();
        $currentUser = $options['currentUser'] ?? [];
        $systemKey = $options['systemKey'] ?? 'project';
        $activePage = $options['activePage'] ?? '';
        $pageTitle = $options['pageTitle'] ?? 'VOSTOKPRIBOR AI Engineering Range';
        $extraHead = $options['extraHeadHtml'] ?? '';

        $unreadCount = $options['unreadCount'] ?? self::getUnreadNotificationsCount((int)($currentUser['id'] ?? 0));

        $safeTitle = htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8');
        $safeBasePath = htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8');

        echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#4C1D95" />
    <title>{$safeTitle}</title>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    <!-- Tailwind CSS (Shared Utilities) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    colors: {
                        primary: '#4C1D95',
                        'primary-hover': '#3B0764',
                        'primary-container': '#4C1D95',
                        'on-primary': '#FFFFFF',
                        secondary: '#D8B4FE',
                        'secondary-fixed': '#F3E8FF',
                        lavender: '#F3E8FF',
                        accent: '#E8C9A0',
                        'tertiary-fixed': '#E8C9A0',
                        cream: '#FDF6F0',
                        wheat: '#F5DEB3',
                        border: '#F5DEB3',
                        'surface-container-lowest': '#FFFFFF',
                        'surface-container-low': '#FDF6F0',
                        'surface-container': '#F8F4EF',
                        'surface-container-high': '#F3E8FF',
                        'on-surface': '#2E1065',
                        'on-surface-variant': '#6B7280',
                    }
                }
            }
        };
    </script>

    <!-- Unified VOSTOKPRIBOR Design System -->
    <link rel="stylesheet" href="{$safeBasePath}/assets/css/design-tokens.css" />
    <link rel="stylesheet" href="{$safeBasePath}/assets/css/app-layout.css" />
    <link rel="stylesheet" href="{$safeBasePath}/assets/css/components.css" />
    <link rel="stylesheet" href="{$safeBasePath}/assets/css/responsive.css" />

    {$extraHead}
</head>
<body class="vp-fiberglass-bg font-sans text-slate-800 antialiased selection:bg-[#F3E8FF] selection:text-[#4C1D95]">
    <div class="vp-page-shell">
HTML;

        // Render Global Header
        echo renderHeader([
            'currentUser' => $currentUser,
            'unreadCount' => $unreadCount,
            'basePath' => $basePath,
        ]);

        // Render Global Auto-Collapsing Sidebar
        echo renderSidebar([
            'systemKey' => $systemKey,
            'activePage' => $activePage,
            'basePath' => $basePath,
        ]);

        // Render Mobile Backdrop
        echo '<div id="vp-sidebar-backdrop" class="vp-sidebar-backdrop" aria-hidden="true"></div>';

        // Open Page Container
        echo renderPageStart([
            'title' => $options['contentTitle'] ?? null,
            'description' => $options['contentDescription'] ?? null,
            'actionsHtml' => $options['contentActions'] ?? '',
        ]);
    }

    /**
     * Render the closing Page Container, scripts, and HTML document end.
     *
     * @param array{
     *     basePath?: string,
     *     extraScriptsHtml?: string
     * } $options
     */
    public static function end(array $options = []): void
    {
        $basePath = $options['basePath'] ?? self::getBasePath();
        $safeBasePath = htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8');
        $extraScripts = $options['extraScriptsHtml'] ?? '';

        echo renderPageEnd();

        echo <<<HTML
    </div>

    <!-- Unified VOSTOKPRIBOR Layout Scripts -->
    <script src="{$safeBasePath}/assets/js/sidebar.js"></script>
    <script src="{$safeBasePath}/assets/js/navigation.js"></script>
    <script src="{$safeBasePath}/assets/js/app-layout.js"></script>

    {$extraScripts}
</body>
</html>
HTML;
    }
}
