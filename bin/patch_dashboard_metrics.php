<?php
$file = __DIR__ . '/../AI Project Management/Dashboard.php';
$content = file_get_contents($file);

$content = preg_replace(
    '/(<span class="font-headline-xl text-headline-xl text-primary font-bold">)8(<\/span>[\s\S]*?total backlog)/',
    '$1<?= $ticketCount ?>$2',
    $content,
    1
);
$content = preg_replace(
    '/(<span class="font-headline-xl text-headline-xl text-primary font-bold">)3(<\/span>[\s\S]*?tickets)/',
    '$1<?= count($activeTickets) ?>$2',
    $content,
    1
);
$content = preg_replace(
    '/(<span class="font-headline-xl text-headline-xl text-primary font-bold">)2(<\/span>[\s\S]*?locked)/',
    '$1<?= $submissionCount ?>$2',
    $content,
    1
);
$content = preg_replace(
    '/(<span class="font-headline-xl text-headline-xl text-primary font-bold">)3(<\/span>[\s\S]*?passed)/',
    '$1<?= $approvedCount ?>$2',
    $content,
    1
);

file_put_contents($file, $content);
echo "Dashboard.php patched successfully.\n";
