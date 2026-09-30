<?php
/**
 * VOSTOKPRIBOR AI • Database Setup & Seed Tool
 */

require_once __DIR__ . '/../config/config.php';
apply_perf_headers();

$status = null;
$message = '';
$details = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['auto'])) {
    try {
        // Connect to MySQL server without database first
        $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        
        $sql = file_get_contents(__DIR__ . '/schema.sql');
        
        // Execute multi-query schema
        $pdo->exec($sql);
        
        $status = 'success';
        $message = 'Database and tables successfully initialized and seeded!';
        $details[] = 'Database `vostokpribor_ai` verified.';
        $details[] = 'Created tables: systems, models, datasets, incidents, tickets, telemetry_logs.';
        $details[] = 'Default operational records successfully seeded.';
    } catch (PDOException $e) {
        $status = 'error';
        $message = 'Database initialization failed: ' . $e->getMessage();
        $details[] = 'Please check that MySQL service is running in XAMPP on port ' . DB_PORT . '.';
        $details[] = 'Credentials used: ' . DB_USER . '@' . DB_HOST;
    }
}
?>
<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Database Initializer • VOSTOKPRIBOR AI</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/global.css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#00142a] text-[#d3e4ff] min-h-screen flex items-center justify-center p-6 bg-radial-glow font-sans">
    <div class="max-w-xl w-full bg-[#000f21] border border-[#1f3651] rounded-2xl p-8 shadow-2xl">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-[#331e00] border border-[#ffb956]/40 flex items-center justify-center text-[#ffb956]">
                <span class="material-symbols-outlined text-2xl">database</span>
            </div>
            <div>
                <h1 class="text-xl font-bold font-mono tracking-tight text-white">VOSTOKPRIBOR AI // DB SETUP</h1>
                <p class="text-xs text-[#8e9197] font-mono">Cross-System Information Exchange Protocol</p>
            </div>
        </div>

        <?php if ($status === 'success'): ?>
            <div class="p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/50 text-emerald-300 text-xs mb-6">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    <?= htmlspecialchars($message) ?>
                </div>
                <ul class="list-disc list-inside mt-2 space-y-1 text-emerald-400/90 font-mono text-[11px]">
                    <?php foreach ($details as $d): ?>
                        <li><?= htmlspecialchars($d) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php elseif ($status === 'error'): ?>
            <div class="p-4 rounded-xl bg-rose-950/60 border border-rose-500/50 text-rose-300 text-xs mb-6">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <span class="material-symbols-outlined text-sm">error</span>
                    <?= htmlspecialchars($message) ?>
                </div>
                <ul class="list-disc list-inside mt-2 space-y-1 text-rose-400/90 font-mono text-[11px]">
                    <?php foreach ($details as $d): ?>
                        <li><?= htmlspecialchars($d) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="p-4 rounded-xl bg-[#06203a] border border-[#1f3651] text-xs text-[#c4c6cd] mb-6 space-y-2">
                <p>Click below to execute <code class="text-[#ffb956] font-mono">db/schema.sql</code> and create the database tables for the 5 AI systems.</p>
                <div class="p-2.5 rounded bg-[#000f21] border border-[#132b45] font-mono text-[11px] text-[#8e9197]">
                    Host: <strong><?= DB_HOST ?>:<?= DB_PORT ?></strong> • User: <strong><?= DB_USER ?></strong> • Database: <strong><?= DB_NAME ?></strong>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" class="flex items-center justify-between gap-4">
            <a href="../index.php" class="px-4 py-2.5 rounded-lg bg-[#06203a] hover:bg-[#132b45] text-xs text-[#c4c6cd] hover:text-white font-mono transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back to Mission Control
            </a>
            <button type="submit" class="px-5 py-2.5 rounded-lg bg-[#ffb956] text-[#331e00] font-bold text-xs font-mono hover:bg-[#ffddb5] shadow-lg shadow-[#ffb956]/20 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">play_arrow</span>
                Execute Schema Init
            </button>
        </form>
    </div>
</body>
</html>
