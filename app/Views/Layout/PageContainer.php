<?php

declare(strict_types=1);

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Unified Page Content Container Component
 */

/**
 * @param array{
 *     title?: string,
 *     description?: string,
 *     actionsHtml?: string,
 *     breadcrumbs?: array
 * } $params
 */
function renderPageStart(array $params = []): string
{
    $title = $params['title'] ?? null;
    $desc = $params['description'] ?? null;
    $actions = $params['actionsHtml'] ?? '';

    $headerHtml = '';
    if ($title !== null) {
        $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
        $descHtml = $desc ? '<p class="text-xs md:text-sm text-slate-500 mt-1">' . htmlspecialchars($desc, ENT_QUOTES, 'UTF-8') . '</p>' : '';
        $headerHtml = <<<HTML
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold font-sans text-primary tracking-tight">{$safeTitle}</h1>
                {$descHtml}
            </div>
            <div class="flex items-center gap-3">
                {$actions}
            </div>
        </div>
HTML;
    }

    return <<<HTML
    <main class="vp-main-content" id="vp-main-content" tabindex="-1">
        <div class="vp-content-inner">
            {$headerHtml}
HTML;
}

function renderPageEnd(): string
{
    return <<<HTML
        </div>
    </main>
HTML;
}
