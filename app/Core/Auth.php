<?php

namespace App\Core;

class Auth
{
    private static ?array $currentUser = null;

    public static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $cookieName = Env::get('SESSION_COOKIE_NAME', 'vostok_ai_session');
            $lifetime = (int)Env::get('SESSION_LIFETIME', 7200);
            $secure = (bool)Env::get('SESSION_SECURE', false);

            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $secure = true;
            }

            session_name($cookieName);
            session_set_cookie_params([
                'lifetime' => $lifetime,
                'path'     => '/',
                'domain'   => '',
                'secure'   => $secure,
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            session_start();
        }
    }

    public static function attempt(string $emailOrIdentifier, string $password): ?array
    {
        self::initSession();

        $user = Database::queryOne(
            "SELECT * FROM users WHERE (email = :login1 OR identifier = :login2) LIMIT 1",
            ['login1' => $emailOrIdentifier, 'login2' => $emailOrIdentifier]
        );

        if (!$user) {
            return null;
        }

        if ($user['status'] !== 'ACTIVE') {
            return ['status_error' => 'ACCOUNT_INACTIVE'];
        }

        if (!password_verify($password, $user['password_hash'])) {
            return null;
        }

        // Regenerate session ID to prevent fixation
        if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
            session_regenerate_id(true);
        }

        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['last_activity'] = time();

        // Update last login
        Database::execute(
            "UPDATE users SET last_login_at = NOW() WHERE id = :id",
            ['id' => $user['id']]
        );

        self::$currentUser = $user;
        return $user;
    }

    public static function user(): ?array
    {
        if (self::$currentUser !== null) {
            return self::$currentUser;
        }

        self::initSession();
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            return null;
        }

        // Check session lifetime
        $lastActivity = $_SESSION['last_activity'] ?? 0;
        $lifetime = (int)Env::get('SESSION_LIFETIME', 7200);
        if (time() - $lastActivity > $lifetime) {
            self::logout();
            return null;
        }
        $_SESSION['last_activity'] = time();

        $user = Database::queryOne(
            "SELECT id, role, email, full_name, identifier, cohort, department, status, must_change_password, created_at FROM users WHERE id = :id AND status = 'ACTIVE' LIMIT 1",
            ['id' => $userId]
        );

        if (!$user) {
            self::logout();
            return null;
        }

        self::$currentUser = $user;
        return $user;
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function id(): ?int
    {
        $u = self::user();
        return $u ? (int)$u['id'] : null;
    }

    public static function role(): ?string
    {
        $u = self::user();
        return $u ? $u['role'] : null;
    }

    public static function isAdmin(): bool
    {
        return self::role() === 'ADMIN';
    }

    public static function isStudent(): bool
    {
        return self::role() === 'STUDENT';
    }

    public static function logout(): void
    {
        self::initSession();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
        self::$currentUser = null;
    }
}
