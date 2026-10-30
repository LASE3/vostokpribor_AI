<?php
declare(strict_types=1);
require_once __DIR__ . '/app/bootstrap.php';
use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Logger;
use App\Core\Response;
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $user = Auth::user();
    try { if ($user) Logger::audit('LOGOUT', 'users', (string)$user['id'], 'SUCCESS'); }
    finally { Auth::logout(); }
    Response::redirect(\App\Core\AppUrl::to('login.php'));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>VOSTOKPRIBOR AI • Flight Deck Authentication</title>
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

<main class="flex-1 flex items-center justify-center px-6 py-12"><div class="precision-card rounded-2xl p-8 max-w-md w-full"><h1 class="text-xl font-bold text-[#4C1D95] mb-6">Sign out of the range</h1><form method="post"><button type="submit" class="w-full py-3 rounded-xl bg-[#4C1D95] text-white font-bold text-xs font-mono">Sign out</button></form><a class="block mt-4 text-center text-xs text-[#4C1D95]" href="index.php">Return to range</a></div></main>
    <!-- Footer Strip -->
    <footer class="py-4 text-center text-xs font-mono text-slate-500 border-t border-[#4C1D95]/10 bg-white/50">
        VOSTOKPRIBOR AI • MISSION CONTROL & AVIONICS SPEC 880-B
    </footer>

</body>
</html>
