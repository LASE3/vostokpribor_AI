<?php

declare(strict_types=1);

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Unified Sidebar Navigation List Component
 */

require_once __DIR__ . '/SidebarItem.php';

/**
 * @param array{
 *     systemKey: string,
 *     activePage?: string,
 *     basePath?: string
 * } $params
 */
function renderSidebarNavigation(array $params): string
{
    $systemKey = $params['systemKey'] ?? 'project';
    $activePage = strtolower(trim((string)($params['activePage'] ?? '')));

    // If activePage is not set, derive from current script name
    if ($activePage === '') {
        $activePage = strtolower(basename((string)($_SERVER['SCRIPT_FILENAME'] ?? '')));
    } else {
        // Normalize: if passed "Dashboard", "Dashboard.php", or "dashboard"
        $activePage = strtolower(basename($activePage));
        if (!str_ends_with($activePage, '.php') && !str_contains($activePage, '-')) {
            $activePage .= '.php';
        }
    }

    $navigationConfig = require __DIR__ . '/../../../config/navigation.php';
    $systemConfig = $navigationConfig[$systemKey] ?? $navigationConfig['project'];
    $items = $systemConfig['items'] ?? [];

    $html = '<nav class="vp-sidebar-nav-container" aria-label="System Navigation">';

    $currentSection = null;
    $hasSections = false;

    // Check if any item defines a section
    foreach ($items as $item) {
        if (!empty($item['section'])) {
            $hasSections = true;
            break;
        }
    }

    if ($hasSections) {
        $grouped = [];
        foreach ($items as $item) {
            $sec = $item['section'] ?? '';
            $grouped[$sec][] = $item;
        }

        foreach ($grouped as $secTitle => $secItems) {
            $html .= '<div class="vp-sidebar-section">';
            if ($secTitle !== '') {
                $safeTitle = htmlspecialchars($secTitle, ENT_QUOTES, 'UTF-8');
                $html .= "<div class=\"vp-sidebar-section-title\">{$safeTitle}</div>";
                $html .= '<div class="vp-sidebar-section-divider" aria-hidden="true"></div>';
            }
            foreach ($secItems as $item) {
                $itemFile = strtolower(basename($item['file'] ?? ''));
                $itemId = strtolower($item['id'] ?? '');
                $isActive = ($itemFile === $activePage || $itemId === $activePage || $itemId === str_replace('.php', '', $activePage));
                $html .= renderSidebarItem($item, $isActive);
            }
            $html .= '</div>';
        }
    } else {
        foreach ($items as $item) {
            $itemFile = strtolower(basename($item['file'] ?? ''));
            $itemId = strtolower($item['id'] ?? '');
            $isActive = ($itemFile === $activePage || $itemId === $activePage || $itemId === str_replace('.php', '', $activePage));
            $html .= renderSidebarItem($item, $isActive);
        }
    }

    $html .= '</nav>';
    return $html;
}
