<?php

declare(strict_types=1);

require_once __DIR__ . '/app/bootstrap.php';

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\RateLimiter;
use App\Core\Logger;
use App\Core\Response;

// If already logged in, redirect to main portal
if (Auth::check()) {
    $redirect = \App\Core\AppUrl::safeReturn($_GET['redirect'] ?? 'index.php');
    Response::redirect(!empty(Auth::user()['must_change_password']) ? 'change-password.php' : $redirect);
}

$error = null;
$clientIp = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$rateKey = "login_attempt_{$clientIp}";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = (string)($_POST['password'] ?? '');
    $csrfToken = $_POST['csrf_token'] ?? '';

    if (!Csrf::validate($csrfToken)) {
        $error = 'Security session expired. Please refresh and try again.';
    } elseif (!RateLimiter::check($rateKey, 5, 120)) {
        $error = 'Too many failed login attempts. Gateway locked for 2 minutes.';
        Logger::audit('LOGIN_RATE_LIMITED', 'users', $login, 'DENIED', ['ip' => $clientIp]);
    } elseif (empty($login) || empty($password)) {
        $error = 'Please enter your email or cadet ID and password.';
    } else {
        $result = Auth::attempt($login, $password);
        if ($result === null) {
            RateLimiter::hit($rateKey, 120);
            Logger::audit('LOGIN_FAILED', 'users', $login, 'FAILURE', ['ip' => $clientIp]);
            $error = 'Invalid credentials. Access rejected by flight security gate.';
        } elseif (isset($result['status_error'])) {
            $error = 'Account is deactivated or suspended. Contact range administrator.';
            Logger::audit('LOGIN_INACTIVE', 'users', $login, 'DENIED', ['ip' => $clientIp]);
        } else {
            RateLimiter::clear($rateKey);

            $redirect = \App\Core\AppUrl::safeReturn($_GET['redirect'] ?? 'index.php');
            // Prevent open redirect to external domains
            if (preg_match('#^(https?:|//|\\\\)#i', $redirect)) {
                $redirect = 'index.php';
            }
            Response::redirect(!empty(Auth::user()['must_change_password']) ? 'change-password.php' : $redirect);
        }
    }
}

$csrfToken = Csrf::getToken();
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
                <img src="assets/branding/logo.svg" alt="VOSTOKPRIBOR Logo" class="w-10 h-10 object-contain" />
                <div>
                    <span class="text-sm font-extrabold font-mono tracking-wider uppercase text-[#4C1D95] block">VOSTOKPRIBOR</span>
                    <span class="text-[11px] text-slate-500 font-mono">AI ENGINEERING RANGE · Security Ingress</span>
                </div>
            </div>
            <div class="flex items-center gap-2 font-mono text-xs text-slate-500">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>GATEWAY SECURE</span>
            </div>
        </div>
    </header>

    <!-- Main Auth Card -->
    <main class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="max-w-md w-full">
            <div class="precision-card rounded-2xl p-8 bg-white border border-[#4C1D95]/15 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#F3E8FF]/60 rounded-full blur-2xl pointer-events-none"></div>

                <div class="mb-8 text-center">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#F3E8FF] border border-[#D8B4FE] text-[#4C1D95] mb-4 shadow-sm">
                        <span class="material-symbols-outlined text-3xl">lock</span>
                    </div>
                    <h1 class="text-2xl font-bold font-mono text-[#4C1D95] tracking-tight">Range Access Ingress</h1>
                    <p class="text-xs text-slate-600 mt-2 font-mono">
                        Authenticate with your assigned administrator or cadet credentials to enter the AI Engineering Range.
                    </p>
                </div>

                <?php if ($error): ?>
                    <div class="mb-6 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-mono flex items-start gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-base text-rose-600 shrink-0">error</span>
                        <div class="leading-relaxed"><?= htmlspecialchars($error) ?></div>
                    </div>
                <?php endif; ?>

                <form method="POST" action="login.php<?= isset($_GET['redirect']) ? '?redirect=' . htmlspecialchars($_GET['redirect']) : '' ?>" class="space-y-5">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>" />

                    <div>
                        <label class="block text-xs font-mono font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Cadet ID or Email Address
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">badge</span>
                            <input
                                type="text"
                                name="login"
                                required
                                autofocus
                                placeholder="e.g. admin@vostokpribor.space or VK-88219"
                                value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
                                class="w-full bg-[#F6F9FF] border border-[#4C1D95]/20 rounded-xl pl-10 pr-4 py-2.5 text-xs font-mono text-slate-900 placeholder-slate-400 focus:border-[#4C1D95] focus:ring-2 focus:ring-[#D8B4FE]/50 outline-none transition-all shadow-sm"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-mono font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Access Password
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">key</span>
                            <input
                                type="password"
                                name="password"
                                required
                                placeholder="••••••••••••"
                                class="w-full bg-[#F6F9FF] border border-[#4C1D95]/20 rounded-xl pl-10 pr-4 py-2.5 text-xs font-mono text-slate-900 placeholder-slate-400 focus:border-[#4C1D95] focus:ring-2 focus:ring-[#D8B4FE]/50 outline-none transition-all shadow-sm"
                            />
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3 rounded-xl bg-[#4C1D95] hover:bg-[#3B1578] text-white font-bold text-xs font-mono transition-all flex items-center justify-center gap-2 shadow-md hover:shadow-lg mt-6"
                    >
                        <span>Authenticate Mission Ingress</span>
                        <span class="material-symbols-outlined text-sm text-[#E8C9A0]">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-[#4C1D95]/10 text-center">
                    <div class="text-[11px] text-slate-500 font-mono">
                        <span class="font-semibold text-slate-700">Restricted Range Facility</span>
                        <p class="mt-1">Public registration is prohibited. Cadets must receive credentials from their flight instructor.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer Strip -->
    <footer class="py-4 text-center text-xs font-mono text-slate-500 border-t border-[#4C1D95]/10 bg-white/50">
        VOSTOKPRIBOR AI • MISSION CONTROL & AVIONICS SPEC 880-B
    </footer>

</body>
</html>
