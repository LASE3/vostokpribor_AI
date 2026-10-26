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

        if ($now > $record['reset_at']) {
            Database::execute("DELETE FROM rate_limits WHERE id = :id", ['id' => $record['id']]);
            return true;
        }

        return $record['hits'] < $maxAttempts;
    }

    public static function hit(string $key, int $decaySeconds = 60): int
    {
        $now = time();
        $record = Database::queryOne(
            "SELECT id, hits, reset_at FROM rate_limits WHERE rate_key = :k LIMIT 1",
            ['k' => $key]
        );

        if (!$record) {
            Database::execute(
                "INSERT INTO rate_limits (rate_key, hits, reset_at) VALUES (:k, 1, :r)",
                ['k' => $key, 'r' => $now + $decaySeconds]
            );
            return 1;
        }

        if ($now > $record['reset_at']) {
            Database::execute(
                "UPDATE rate_limits SET hits = 1, reset_at = :r WHERE id = :id",
                ['r' => $now + $decaySeconds, 'id' => $record['id']]
            );
            return 1;
        }

        $newHits = $record['hits'] + 1;
        Database::execute(
            "UPDATE rate_limits SET hits = :h WHERE id = :id",
            ['h' => $newHits, 'id' => $record['id']]
        );
        return $newHits;
    }

    public static function clear(string $key): void
    {
        Database::execute("DELETE FROM rate_limits WHERE rate_key = :k", ['k' => $key]);
    }
}
