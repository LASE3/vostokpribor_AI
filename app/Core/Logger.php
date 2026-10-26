<?php

namespace App\Core;

class Logger
{
    public static function audit(
        string $action,
        string $resourceType,
        ?string $resourceId = null,
        string $outcome = 'SUCCESS',
        ?array $metadata = null,
        ?int $actorId = null
    ): void {
        try {
            $actor = $actorId ?? Auth::id();
            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

            // Sanitize metadata to never log sensitive fields (passwords, tokens, raw file contents)
            $cleanMeta = self::sanitizeMetadata($metadata);

            Database::execute(
                "INSERT INTO audit_logs (actor_id, action, resource_type, resource_id, ip_address, outcome, metadata_json, created_at)
                 VALUES (:actor_id, :action, :res_type, :res_id, :ip, :outcome, :meta, NOW())",
                [
                    'actor_id'  => $actor,
                    'action'    => $action,
                    'res_type'  => $resourceType,
                    'res_id'    => $resourceId,
                    'ip'        => $ip,
                    'outcome'   => $outcome,
                    'meta'      => $cleanMeta ? json_encode($cleanMeta) : null,
                ]
            );
        } catch (\Throwable $e) {
            // Fail silently or log to PHP system error log so auditing never crashes the main flow
            error_log("Failed to write audit log: " . $e->getMessage());
        }
    }

    private static function sanitizeMetadata(?array $data): ?array
    {
        if ($data === null) return null;

        $sensitive = ['password', 'password_hash', 'token', 'csrf_token', 'secret', 'auth', 'authorization'];
        $clean = [];

        foreach ($data as $k => $v) {
            if (in_array(strtolower($k), $sensitive)) {
                $clean[$k] = '[REDACTED]';
            } elseif (is_array($v)) {
                $clean[$k] = self::sanitizeMetadata($v);
            } else {
                $clean[$k] = $v;
            }
        }

        return $clean;
    }
}
