<?php
$file = __DIR__ . '/../AI Project Management/Submissions.php';
$content = file_get_contents($file);

// 1. Add CSRF token in modal form
if (!str_contains($content, 'name="csrf_token"')) {
    $content = str_replace(
        '<input type="hidden" name="action" value="create_submission">',
        "<input type=\"hidden\" name=\"csrf_token\" value=\"<?= htmlspecialchars(\\App\\Core\\Csrf::getToken()) ?>\" />\n                <input type=\"hidden\" name=\"action\" value=\"create_submission\">",
        $content
    );
}

// 2. Dynamic metrics in cards
$content = preg_replace(
    '/(<span class="font-headline-xl text-headline-xl font-bold text-primary">)14(<\/span>)/',
    '$1<?= $totalSubmissions ?>$2',
    $content,
    1
);
$content = preg_replace(
    '/(<span class="font-label-sm text-label-sm font-code-inline text-primary font-semibold">)7 active tickets(<\/span>)/',
    '$1<?= count($assignedTickets) ?> active tickets$2',
    $content,
    1
);
$content = preg_replace(
    '/(<span class="font-headline-xl text-headline-xl font-bold text-primary">)6(<\/span>)/',
    '$1<?= $approvedCount ?>$2',
    $content,
    1
);
$content = preg_replace(
    '/(<span class="font-headline-xl text-headline-xl font-bold text-on-tertiary-fixed">)2(<\/span>)/',
    '$1<?= $revisionsCount ?>$2',
    $content,
    1
);
$content = preg_replace(
    '/(<span class="font-headline-xl text-headline-xl font-bold text-primary">)1(<\/span>[\s\S]*?in canary run)/',
    '$1<?= $underReviewCount ?>$2',
    $content,
    1
);

file_put_contents($file, $content);
echo "Submissions.php patched successfully.\n";
