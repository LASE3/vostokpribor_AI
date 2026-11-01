<?php

namespace App\Core;

class RateLimiter
{
    public static function check(string $key, int $maxAttempts = 5, int $decaySeconds = 60): bool
    {
        $now = time();
        $record = Database::queryOne(
            "SELECT id, hits, reset_at FROM rate_limits WHERE rate_key = :k LIMIT 1",
            ['k' => $key]
        );

        if (!$record) {
            return true;
        }

        return $now >= (int)$record['reset_at'] || (int)$record['hits'] < $maxAttempts;
    }

    /** Reserve admission atomically; concurrent first hits share the same row lock. */
    public static function consume(string $key, int $maxAttempts = 5, int $decaySeconds = 60): array
    {
        if ($key === '' || strlen($key) > 128 || $maxAttempts < 1 || $decaySeconds < 1) {
            throw new \InvalidArgumentException('Invalid rate-limit policy.');
        }
        return Database::transaction(function () use ($key, $maxAttempts, $decaySeconds) {
            $now = time();
            Database::execute(
                'INSERT INTO rate_limits (rate_key,hits,reset_at) VALUES (:k,0,:r) ON DUPLICATE KEY UPDATE id=id',
                ['k' => $key, 'r' => $now + $decaySeconds]
            );
            $record = Database::queryOne('SELECT id,hits,reset_at FROM rate_limits WHERE rate_key=:k FOR UPDATE', ['k'=>$key]);
            $reset = $now >= (int)$record['reset_at'] ? $now + $decaySeconds : (int)$record['reset_at'];
            $hits = $now >= (int)$record['reset_at'] ? 0 : (int)$record['hits'];
            $allowed = $hits < $maxAttempts;
            if ($allowed) {
                $hits++;
                Database::execute('UPDATE rate_limits SET hits=:hits,reset_at=:reset WHERE id=:id', ['hits'=>$hits,'reset'=>$reset,'id'=>$record['id']]);
            }
            return ['allowed'=>$allowed,'hits'=>$hits,'remaining'=>max(0,$maxAttempts-$hits),'reset_at'=>$reset,'retry_after'=>max(1,$reset-$now)];
        });
    }

    public static function hit(string $key, int $decaySeconds = 60): int
    {
        return self::consume($key, PHP_INT_MAX, $decaySeconds)['hits'];
    }

    /** Refund a successful login's reservation, preserving concurrent failures. */
    public static function refund(string $key, int $resetAt): void
    {
        Database::execute('UPDATE rate_limits SET hits=GREATEST(hits-1,0) WHERE rate_key=:key AND reset_at=:reset', ['key'=>$key,'reset'=>$resetAt]);
    }

    public static function enforce(string $key, int $maxAttempts, int $decaySeconds = 60, bool $isApi = true): array
    {
        $admission = self::consume($key, $maxAttempts, $decaySeconds);
        if (!$admission['allowed']) {
            header('Retry-After: '.$admission['retry_after']);
            if(!$isApi){http_response_code(429);header('Content-Type: text/plain; charset=utf-8');exit('Too many requests. No changes were made. Wait '.$admission['retry_after'].' seconds before trying again.');}
            Response::error('Too many requests. Wait before trying again.', 'RATE_LIMITED', 429,
                ['retry_after'=>$admission['retry_after']]
            );
        }
        return $admission;
    }

    /** One admission policy for authenticated API and legacy HTML writes. */
    public static function authenticatedMutation(int $actorId, bool $isApi = true): void
    {
        $window=max(1,(int)Env::get('API_RATE_WINDOW_SECONDS',60));
        self::enforce('api_mutation_user_'.$actorId,max(1,(int)Env::get('API_MUTATION_LIMIT',120)),$window,$isApi);
        if(str_starts_with(strtolower((string)($_SERVER['CONTENT_TYPE']??'')),'multipart/form-data')){
            self::enforce('api_upload_user_'.$actorId,max(1,(int)Env::get('API_UPLOAD_LIMIT',20)),$window,$isApi);
        }
    }

    /** Known file-heavy or unbounded aggregate/catalog reads, aliases included. */
    public static function isExpensiveRead(string $method, string $uri): bool
    {
        if (strtoupper($method) !== 'GET') return false;
        // Apache/Windows accepts case variants, repeated slashes and dot
        // segments. Classify the same logical resource before admission.
        $canonical = static function (string $path): string {
            $segments = [];
            foreach (explode('/', rawurldecode($path)) as $segment) {
                if ($segment === '' || $segment === '.') continue;
                if ($segment === '..') { array_pop($segments); continue; }
                $segments[] = $segment;
            }
            return '/' . strtolower(implode('/', $segments));
        };
        $path = $canonical((string)(parse_url($uri, PHP_URL_PATH) ?? ''));
        $base = rtrim($canonical(AppUrl::basePath()), '/');
        if (!str_starts_with($path, $base . '/')) return false;
        $relative = substr($path, strlen($base) + 1);
        if (str_starts_with($relative, 'api/v1/')) {
            $route = rtrim(substr($relative, 7), '/');
            if (preg_match('#^(?:(?:data/|soc/)?datasets/[0-9]+/(?:preview|download)|data/processed/[0-9]+/download)$#D', $route)) return true;
            if (preg_match('#^soc/(?:tickets|datasets|models)/summary$#D', $route)) return true;
            if (preg_match('#^soc/students/[0-9]+/(?:progress|summary)$#D', $route)) return true;
            return in_array($route, [
                'soc/overview', 'admin/overview', 'soc/students', 'users',
                'soc/scenarios', 'scenarios', 'models', 'registry/models',
                'experiment-runs', 'workbench/experiment-runs',
                'execution-jobs', 'workbench/execution-jobs',
            ], true);
        }
        return in_array($relative, array_map('strtolower', [
            'api/models.php', 'api/exchange.php', 'api/status.php', 'index.php',
            'AI Operations Center (AI SOC)/Dashboard.php',
            'AI Operations Center (AI SOC)/TicketsAndScenarios.php',
            'AI Operations Center (AI SOC)/StudentManagement.php',
            'Data Center/DatasetCatalog.php', 'Data Center/MyDataSet.php',
            'Data Center/DataProfilingAndQuality.php', 'Data Center/QueryWorkspace.php',
            'Model Registry & Deployment/ModelRegistry.php',
        ]), true);
    }

    public static function expensiveRead(int $actorId, bool $isApi = true): void
    {
        self::enforce('expensive_read_user_' . $actorId,
            max(1, (int)Env::get('API_EXPENSIVE_READ_LIMIT', 60)),
            max(1, (int)Env::get('API_RATE_WINDOW_SECONDS', 60)), $isApi);
    }

    public static function clear(string $key): void
    {
        Database::execute("DELETE FROM rate_limits WHERE rate_key = :k", ['k' => $key]);
    }
}
