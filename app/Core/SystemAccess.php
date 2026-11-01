<?php
declare(strict_types=1);

namespace App\Core;

/** Server-side boundaries for application pages; API object privileges are separate. */
final class SystemAccess
{
    public const STUDENT_SYSTEMS = ['project', 'data', 'workbench', 'registry'];
    public const SOC_HOME = 'AI Operations Center (AI SOC)/Dashboard.php';
    private const FOLDERS = [
        'ai project management' => 'project', 'data center' => 'data',
        'ml workbench' => 'workbench', 'model registry & deployment' => 'registry',
        'ai operations center (ai soc)' => 'soc',
    ];

    public static function allowedSystems(string $role): array
    {
        return match ($role) {
            'ADMIN' => ['soc'], 'STUDENT' => self::STUDENT_SYSTEMS, default => [],
        };
    }

    public static function canOpenSystem(string $role, string $system): bool
    {
        return in_array($system, self::allowedSystems($role), true);
    }

    public static function homePath(string $role): string
    {
        return match ($role) {
            'ADMIN' => self::SOC_HOME, 'STUDENT' => 'index.php', default => 'login.php',
        };
    }

    public static function loginDestination(array $user): string
    {
        return AppUrl::to(!empty($user['must_change_password']) ? 'change-password.php' : self::homePath((string)($user['role'] ?? '')));
    }

    /** Classify the executing PHP file, never a client-supplied return URL. */
    public static function pageSystem(string $script, ?string $root = null): ?string
    {
        $root = $root ?? dirname(__DIR__, 2);
        $root = str_replace('\\', '/', realpath($root) ?: $root);
        $script = str_replace('\\', '/', realpath($script) ?: $script);
        $prefix = rtrim(strtolower($root), '/') . '/';
        if (!str_starts_with(strtolower($script), $prefix)) return null;
        $relative = substr($script, strlen($prefix));
        return self::FOLDERS[strtolower(explode('/', $relative, 2)[0])] ?? null;
    }

    public static function denyPage(string $role): never
    {
        http_response_code(403);
        header('Content-Type: text/html; charset=utf-8');
        $home = htmlspecialchars(AppUrl::to(self::homePath($role)), ENT_QUOTES, 'UTF-8');
        exit('<!doctype html><html><head><title>Access denied</title></head><body><h1>Access denied</h1><p>This application is not available for your account role.</p><a href="' . $home . '">Return to your application</a></body></html>');
    }
}
