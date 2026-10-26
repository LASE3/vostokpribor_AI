<?php

declare(strict_types=1);

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Unified Sidebar Navigation Item Component
 */

/**
 * @param array{
 *     id: string,
 *     label: string,
 *     icon: string,
 *     file: string
 * } $item
 * @param bool $isActive
 */
function renderSidebarItem(array $item, bool $isActive = false): string
{
    $label = htmlspecialchars($item['label'] ?? '', ENT_QUOTES, 'UTF-8');
    $icon = htmlspecialchars($item['icon'] ?? 'circle', ENT_QUOTES, 'UTF-8');
    $file = htmlspecialchars($item['file'] ?? '#', ENT_QUOTES, 'UTF-8');
    $id = htmlspecialchars($item['id'] ?? '', ENT_QUOTES, 'UTF-8');

    $activeClass = $isActive ? 'is-active' : '';
    $ariaCurrent = $isActive ? 'aria-current="page"' : '';

    return <<<HTML
    <a href="{$file}" class="vp-sidebar-item {$activeClass}" data-path="{$id}" data-tooltip="{$label}" {$ariaCurrent}>
        <div class="vp-sidebar-icon-wrap" aria-hidden="true">
            <span class="material-symbols-outlined">{$icon}</span>
        </div>
        <span class="vp-sidebar-label">{$label}</span>
    </a>
HTML;
}
