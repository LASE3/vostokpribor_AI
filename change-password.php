<?php
declare(strict_types=1);
require_once __DIR__ . '/app/bootstrap.php';
use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
$user = AuthenticationMiddleware::handle();
$error = null;
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    try {
        if ((string)($_POST['new_password'] ?? '') !== (string)($_POST['confirm_password'] ?? '')) {
            throw new \InvalidArgumentException('New passwords do not match.');
        }
        Auth::changePassword((string)($_POST['current_password'] ?? ''), (string)($_POST['new_password'] ?? ''));
        Response::redirect(\App\Core\AppUrl::to('index.php'));
    } catch (\InvalidArgumentException $e) { $error = $e->getMessage(); }
}
header('Cache-Control: no-store');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>VOSTOKPRIBOR AI • Change Access Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        mono: ['IBM Plex Mono', 'monospace'],
                    },
                    colors: {
                        brand: {
                            purple: '#4C1D95',
                            lilac: '#D8B4FE',
                            lavender: '#F3E8FF',
                            rosegold: '#E8C9A0',
                            cream: '#FDF6F0',
                            wheat: '#F5DEB3',
                            bg: '#EAF4FF',
                            bgSub: '#DCEEFF',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .fiberglass-bg {
            background-color: #EAF4FF;
            background-image:
                radial-gradient(ellipse at 50% 0%, rgba(216, 180, 254, 0.22) 0%, transparent 65%),
                linear-gradient(135deg, rgba(220, 238, 255, 0.45) 25%, transparent 25%),
                linear-gradient(225deg, rgba(220, 238, 255, 0.45) 25%, transparent 25%),
                linear-gradient(315deg, rgba(245, 222, 179, 0.12) 25%, transparent 25%),
                linear-gradient(45deg, rgba(245, 222, 179, 0.12) 25%, transparent 25%);
            background-size: 100% 100%, 28px 28px, 28px 28px, 28px 28px, 28px 28px;
            background-position: 0 0, 0 0, 14px 0, 14px -14px, 0px 14px;
        }
        .precision-card {
            background: #FFFFFF;
            border: 1px solid rgba(76, 29, 149, 0.12);
            box-shadow: 0 1px 3px rgba(76, 29, 149, 0.04), 0 4px 14px rgba(220, 238, 255, 0.6);
        }
    </style>
</head>
<body class="fiberglass-bg text-slate-800 antialiased min-h-screen font-sans flex flex-col justify-between selection:bg-[#F3E8FF] selection:text-[#4C1D95]">

    <!-- Header Strip -->
    <header class="bg-white/90 backdrop-blur-md border-b border-[#4C1D95]/15 py-4 px-6 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#4C1D95] flex items-center justify-center text-white shadow-sm">
                    <span class="material-symbols-outlined text-2xl text-[#E8C9A0]">satellite_alt</span>
                </div>
                <div>
                    <span class="text-sm font-extrabold font-mono tracking-wider uppercase text-[#4C1D95] block">VOSTOKPRIBOR AI</span>
                    <span class="text-[11px] text-slate-500 font-mono">Mission Control Security Ingress</span>
                </div>
            </div>
            <div class="flex items-center gap-2 font-mono text-xs text-slate-500">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>GATEWAY SECURE</span>
            </div>
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="max-w-md w-full">
            <div class="precision-card rounded-2xl p-8 bg-white border border-[#4C1D95]/15 shadow-xl relative overflow-hidden">
                <div class="mb-8 text-center">
                    <h1 class="text-xl font-extrabold text-[#4C1D95]">Change Access Password</h1>
                    <p class="text-xs text-slate-500 mt-2">Choose a unique password containing 12 to 72 characters. Initial passwords must be changed before using the range.</p>
                </div>
                <?php if ($error): ?><p role="alert" class="text-red-700 text-xs mb-4"><?= htmlspecialchars($error) ?></p><?php endif; ?>
                <form method="post" class="space-y-4">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::getToken()) ?>">
                    <div><label class="block text-xs font-mono font-bold mb-2" for="current_password">Current Password</label><input id="current_password" name="current_password" type="password" autocomplete="current-password" required class="w-full bg-[#F6F9FF] border border-[#4C1D95]/20 rounded-xl px-4 py-2.5 text-xs"></div>
                    <div><label class="block text-xs font-mono font-bold mb-2" for="new_password">New Password</label><input id="new_password" name="new_password" type="password" minlength="12" maxlength="72" autocomplete="new-password" required class="w-full bg-[#F6F9FF] border border-[#4C1D95]/20 rounded-xl px-4 py-2.5 text-xs"></div>
                    <div><label class="block text-xs font-mono font-bold mb-2" for="confirm_password">Confirm New Password</label><input id="confirm_password" name="confirm_password" type="password" minlength="12" maxlength="72" autocomplete="new-password" required class="w-full bg-[#F6F9FF] border border-[#4C1D95]/20 rounded-xl px-4 py-2.5 text-xs"></div>
                    <button type="submit" class="w-full py-3 rounded-xl bg-[#4C1D95] hover:bg-[#3B1578] text-white font-bold text-xs font-mono">Save New Password</button>
                </form>
                <a href="logout.php" class="block text-center text-xs text-[#4C1D95] mt-6">Sign out</a>
            </div>
        </div>
    </main>
    <!-- Footer Strip -->
    <footer class="py-4 text-center text-xs font-mono text-slate-500 border-t border-[#4C1D95]/10 bg-white/50">
        VOSTOKPRIBOR AI • MISSION CONTROL & AVIONICS SPEC 880-B
    </footer>

</body>
</html>
