<?php
/** Shared rendering inside the existing subsystem page shells. */
function rangeEscape(mixed $value): string { return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function rangeCard(string $title, string $body): void {
    echo '<section class="bg-surface-container-lowest rounded-xl p-space-lg p-5 shadow-sm flex flex-col gap-4"><h2 class="font-headline-md text-headline-md text-primary font-semibold">' . rangeEscape($title) . '</h2>' . $body . '</section>';
}
function rangeTable(array $columns, array $rows, string $empty): string {
    $html = '<div class="overflow-x-auto"><table class="w-full text-left font-body-sm text-body-sm"><thead class="bg-surface-container-low"><tr>';
    foreach ($columns as $label) $html .= '<th class="p-3 font-label-sm text-label-sm text-on-surface-variant">' . rangeEscape($label) . '</th>';
    $html .= '</tr></thead><tbody class="divide-y divide-surface-container">';
    if (!$rows) $html .= '<tr><td colspan="' . count($columns) . '" class="p-8 text-center text-on-surface-variant">' . rangeEscape($empty) . '</td></tr>';
    foreach ($rows as $row) { $html .= '<tr>'; foreach ($row as $cell) $html .= '<td class="p-3 align-top">' . $cell . '</td>'; $html .= '</tr>'; }
    return $html . '</tbody></table></div>';
}
function rangeInput(string $name, string $label, string $type = 'text', bool $required = true): string {
    return '<label class="flex flex-col gap-1 font-label-sm text-label-sm">' . rangeEscape($label) . '<input class="p-2 rounded bg-surface-container-low border border-outline-variant/40 text-on-surface" type="' . rangeEscape($type) . '" name="' . rangeEscape($name) . '" ' . ($required ? 'required' : '') . '></label>';
}
function rangeSelect(string $name, string $label, array $options): string {
    $h = '<label class="flex flex-col gap-1 font-label-sm text-label-sm">' . rangeEscape($label) . '<select required name="' . rangeEscape($name) . '" class="p-2 rounded bg-surface-container-low border border-outline-variant/40"><option value="">Select…</option>';
    foreach ($options as $key => $value) $h .= '<option value="' . rangeEscape($key) . '">' . rangeEscape($value) . '</option>';
    return $h . '</select></label>';
}
function rangeButton(string $text): string { return '<button type="submit" class="px-4 py-2 rounded bg-primary text-on-primary font-label-md text-label-md font-bold">' . rangeEscape($text) . '</button>'; }
function rangeForm(string $action, string $fields, string $button, bool $upload = false): string {
    return '<form method="post" class="flex flex-col gap-3" ' . ($upload ? 'enctype="multipart/form-data"' : '') . '><input type="hidden" name="csrf_token" value="' . rangeEscape(\App\Core\Csrf::getToken()) . '"><input type="hidden" name="action" value="' . rangeEscape($action) . '">' . $fields . rangeButton($button) . '</form>';
}
