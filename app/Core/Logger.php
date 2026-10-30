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
            if ($resourceId !== null && mb_strlen($resourceId) > 64) {
                $metadata = ($metadata ?? []) + ['resource_id_full' => mb_substr($resourceId, 0, 4000)];
                $resourceId = mb_substr($resourceId, 0, 64);
            }
            $action = mb_substr($action, 0, 64);
            $resourceType = mb_substr($resourceType, 0, 64);
            $ip = substr($ip, 0, 45);
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
            error_log("Failed to write audit log: " . $e->getMessage());
            throw new \RuntimeException('Audit storage unavailable; the operation could not be recorded.', 0, $e);
        }
    }

    private static function sanitizeMetadata(?array $data): ?array
    {
        if ($data === null) return null;

        $sensitive = ['password', 'password_hash', 'token', 'csrf_token', 'secret', 'auth', 'authorization'];
        $clean = [];

        foreach ($data as $k => $v) {
            if (in_array(strtolower($k), $sensitive) || preg_match('/password|token|secret|credential|authorization/i', (string)$k)) {
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
