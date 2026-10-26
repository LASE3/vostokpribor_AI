<?php

declare(strict_types=1);

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Unified Sidebar Component
 * 
 * Auto-collapsing navigation sidebar:
 * - Collapsed by default (72px)
 * - Expands smoothly on mouse enter / hover (260px)
 * - Collapses smoothly on mouse leave
 * - Accessible via keyboard focus-within
 * - Mobile drawer mode with backdrop
 * - Completely removes unnecessary telemetry/storage/health boxes
 */

require_once __DIR__ . '/SidebarNavigation.php';

/**
 * @param array{
 *     systemKey: string,
 *     activePage?: string,
 *     basePath?: string
 * } $params
 */
function renderSidebar(array $params): string
{
    $systemKey = $params['systemKey'] ?? 'project';
    $activePage = $params['activePage'] ?? '';
    $basePath = rtrim((string)($params['basePath'] ?? '..'), '/');

    $navHtml = renderSidebarNavigation([
        'systemKey' => $systemKey,
        'activePage' => $activePage,
        'basePath' => $basePath,
    ]);

    $homeUrl = htmlspecialchars($basePath . '/index.php', ENT_QUOTES, 'UTF-8');

    return <<<HTML
    <aside id="vp-sidebar" class="vp-sidebar" aria-label="Main Navigation">
        <!-- Mobile Drawer Header with Close Button -->
        <div class="lg:hidden flex items-center justify-between p-3 border-b border-border/40">
            <span class="font-mono text-xs font-bold text-primary uppercase tracking-wider">Navigation Menu</span>
            <button type="button" id="vp-sidebar-close" class="p-1 rounded text-slate-500 hover:text-primary hover:bg-lavender transition-colors" aria-label="Close navigation menu">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto">
            {$navHtml}
        </div>

        <!-- Persistent Navigation to Flight Deck Home -->
        <div class="vp-sidebar-footer">
            <a href="{$homeUrl}" class="vp-sidebar-item" data-tooltip="Flight Deck Home" title="Return to Avionics Flight Deck Home">
                <div class="vp-sidebar-icon-wrap" aria-hidden="true">
                    <span class="material-symbols-outlined text-primary">home</span>
                </div>
                <span class="vp-sidebar-label">Flight Deck Home</span>
            </a>
        </div>
    </aside>
HTML;
}
