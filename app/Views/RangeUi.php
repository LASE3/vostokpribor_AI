<?php

declare(strict_types=1);

/**
 * VOSTOKPRIBOR AI Engineering Range
 * Shared rendering inside subsystem page shells with unified design system styling.
 */

function rangeEscape(mixed $value): string
{
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function rangeCard(string $title, string $body): void
{
    echo '<section class="vp-card mb-6 shadow-sm flex flex-col gap-4 bg-white border border-[#F5DEB3] rounded-xl p-6">'
        . '<div class="vp-card-header flex items-center justify-between pb-3 border-b border-[#F5DEB3]/60">'
        . '<h2 class="vp-card-title text-lg font-bold text-[#4C1D95] tracking-tight">' . rangeEscape($title) . '</h2>'
        . '</div>'
        . '<div class="space-y-4 text-slate-700 leading-relaxed">' . $body . '</div>'
        . '</section>';
}

function rangeTable(array $columns, array $rows, string $empty): string
{
    $html = '<div class="vp-table-container overflow-x-auto rounded-xl border border-[#F5DEB3] bg-white shadow-xs mb-4"><table class="vp-table w-full text-left font-sans text-xs md:text-sm"><thead class="bg-[#F3E8FF] border-b border-[#D8B4FE]"><tr>';
    foreach ($columns as $label) {
        $html .= '<th class="p-3.5 font-mono text-[11px] font-bold text-[#4C1D95] uppercase tracking-wider">' . rangeEscape($label) . '</th>';
    }
    $html .= '</tr></thead><tbody class="divide-y divide-[#F5DEB3]/40">';
    if (!$rows) {
        $html .= '<tr><td colspan="' . count($columns) . '" class="p-10 text-center text-slate-500 font-mono text-xs"><div class="flex flex-col items-center gap-2"><span class="material-symbols-outlined text-3xl text-[#D8B4FE]">inbox</span><span>' . rangeEscape($empty) . '</span></div></td></tr>';
    }
    foreach ($rows as $row) {
        $html .= '<tr class="hover:bg-[#F3E8FF]/30 transition-colors">';
        foreach ($row as $cell) {
            $html .= '<td class="p-3.5 align-top text-slate-700">' . $cell . '</td>';
        }
        $html .= '</tr>';
    }
    return $html . '</tbody></table></div>';
}

function rangeInput(string $name, string $label, string $type = 'text', bool $required = true): string
{
    return '<label class="vp-form-group flex flex-col gap-1.5 font-sans text-xs font-semibold text-[#4C1D95]">'
        . rangeEscape($label)
        . '<input class="vp-input h-10 px-3.5 rounded-lg bg-[#FDF6F0] border border-[#F5DEB3] text-slate-800 text-sm focus:outline-none focus:border-[#4C1D95] focus:bg-white focus:ring-2 focus:ring-[#4C1D95]/15 transition-all" type="'
        . rangeEscape($type)
        . '" name="' . rangeEscape($name) . '" ' . ($required ? 'required' : '') . '></label>';
}

function rangeSelect(string $name, string $label, array $options): string
{
    $h = '<label class="vp-form-group flex flex-col gap-1.5 font-sans text-xs font-semibold text-[#4C1D95]">'
        . rangeEscape($label)
        . '<select required name="' . rangeEscape($name) . '" class="vp-select h-10 px-3.5 rounded-lg bg-[#FDF6F0] border border-[#F5DEB3] text-slate-800 text-sm focus:outline-none focus:border-[#4C1D95] focus:bg-white focus:ring-2 focus:ring-[#4C1D95]/15 transition-all"><option value="">Select…</option>';
    foreach ($options as $key => $value) {
        $h .= '<option value="' . rangeEscape($key) . '">' . rangeEscape($value) . '</option>';
    }
    return $h . '</select></label>';
}

function rangeButton(string $text): string
{
    return '<button type="submit" class="vp-btn vp-btn-primary h-10 px-5 rounded-lg bg-[#4C1D95] hover:bg-[#3B0764] text-white font-sans text-xs font-bold shadow-sm transition-all transform hover:-translate-y-0.5">'
        . rangeEscape($text)
        . '</button>';
}

function rangeForm(string $action, string $fields, string $button, bool $upload = false): string
{
    return '<form method="post" class="flex flex-col gap-4 mt-2" ' . ($upload ? 'enctype="multipart/form-data"' : '') . '>'
        . '<input type="hidden" name="csrf_token" value="' . rangeEscape(\App\Core\Csrf::getToken()) . '">'
        . '<input type="hidden" name="action" value="' . rangeEscape($action) . '">'
        . $fields
        . rangeButton($button)
        . '</form>';
}
