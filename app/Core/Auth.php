<?php

namespace App\Core;

class Auth
{
    private static ?array $currentUser = null;

    public static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.use_strict_mode', '1');
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

        // The intentionally weak first-install credential is accepted only from a
        // loopback client on an explicitly local development installation.
        if ($password === 'admin' && !self::isLocalDevelopmentRequest()) {
            return null;
        }

        // Commit the authenticated audit before granting a session. A failed audit
        // must never leave a successful login behind an HTTP 500 response.
        Database::transaction(function () use ($user) {
            Database::execute('UPDATE users SET last_login_at=NOW() WHERE id=:id', ['id'=>$user['id']]);
            Logger::audit('LOGIN_SUCCESS','users',(string)$user['id'],'SUCCESS',['role'=>$user['role']],(int)$user['id']);
        });

        // Regenerate session ID to prevent fixation
        if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
            session_regenerate_id(true);
        }

        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['session_version'] = (int)$user['session_version'];
        $_SESSION['last_activity'] = time();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

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
            "SELECT id, role, email, full_name, identifier, cohort, department, status, must_change_password, session_version, created_at FROM users WHERE id = :id AND status = 'ACTIVE' LIMIT 1",
            ['id' => $userId]
        );

        if (!$user || (int)($_SESSION['session_version'] ?? 0) !== (int)$user['session_version']) {
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

    public static function isLocalDevelopmentRequest(): bool
    {
        $environment = strtolower((string)Env::get('APP_ENV', 'production'));
        $client = $_SERVER['REMOTE_ADDR'] ?? '';
        $server = $_SERVER['SERVER_ADDR'] ?? '';
        $configuredUrl = parse_url((string)Env::get('APP_URL', ''));
        $configuredHost = strtolower((string)($configuredUrl['host'] ?? ''));
        $requestHost = (string)($_SERVER['HTTP_HOST'] ?? '');

        // A public reverse proxy may connect from loopback. The weak initial
        // credential is never accepted on forwarded requests or public hosts.
        foreach ($_SERVER as $key => $value) {
            $header = strtoupper((string)$key);
            if ($header === 'HTTP_FORWARDED' || $header === 'HTTP_X_REAL_IP'
                || $header === 'HTTP_X_FORWARDED' || str_starts_with($header, 'HTTP_X_FORWARDED_')) {
                return false;
            }
        }
        if (!is_array($configuredUrl) || isset($configuredUrl['user']) || isset($configuredUrl['pass'])
            || !in_array($configuredHost, ['localhost', '127.0.0.1', '::1', '[::1]'], true)
            || !preg_match('/^(localhost|127\.0\.0\.1|\[::1\])(?::([0-9]{1,5}))?$/iD', $requestHost, $hostParts)
            || (isset($hostParts[2]) && ((int)$hostParts[2] < 1 || (int)$hostParts[2] > 65535))) {
            return false;
        }
        return in_array($environment, ['local', 'development', 'dev', 'testing'], true)
            && in_array($client, ['127.0.0.1', '::1'], true)
            && in_array($server, ['127.0.0.1', '::1'], true);
    }

    public static function changePassword(string $currentPassword, string $newPassword): void
    {
        $user = self::user();
        if (!$user) throw new \RuntimeException('Authentication required.');
        $stored = Database::queryOne('SELECT password_hash FROM users WHERE id = :id', ['id' => $user['id']]);
        if (!$stored || !password_verify($currentPassword, $stored['password_hash'])) {
            throw new \InvalidArgumentException('The current password is incorrect.');
        }
        if (strlen($newPassword) < 12 || strlen($newPassword) > 72 || $newPassword === $currentPassword) {
            throw new \InvalidArgumentException('Choose a different password containing 12 to 72 characters.');
        }
        Database::transaction(function () use ($newPassword, $user) {
            Database::execute('UPDATE users SET password_hash = :hash, must_change_password = 0, session_version = session_version + 1, updated_at = NOW() WHERE id = :id', [
                'hash' => password_hash($newPassword, PASSWORD_DEFAULT), 'id' => $user['id']
            ]);
            Logger::audit('PASSWORD_CHANGED', 'users', (string)$user['id'], 'SUCCESS', null, (int)$user['id']);
        });
        self::$currentUser = null;
        $_SESSION['session_version'] = (int)Database::queryOne('SELECT session_version FROM users WHERE id = :id', ['id' => $user['id']])['session_version'];
        session_regenerate_id(true);
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
