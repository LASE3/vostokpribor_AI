<?php
namespace App\Services;

use App\Core\Database;
use InvalidArgumentException;

/** Checks references at the point of creation; caller-supplied foreign keys never grant access. */
final class WorkOwnership
{
    public static function ticket(?int $ticketId, int $studentId, ?int $scenarioId = null): ?int
    {
        if (!$ticketId) {
            if ($scenarioId) {
                throw new InvalidArgumentException('A scenario must be linked through an assigned ticket.');
            }
            return null;
        }
        $ticket = Database::queryOne(
            'SELECT t.id, t.scenario_id FROM tickets t JOIN ticket_assignments ta ON ta.ticket_id = t.id WHERE t.id = :tid AND ta.student_id = :sid',
            ['tid' => $ticketId, 'sid' => $studentId]
        );
        if (!$ticket) {
            throw new \App\Core\AccessDeniedException('Ticket is not assigned to this student.');
        }
        $actualScenario = $ticket['scenario_id'] !== null ? (int)$ticket['scenario_id'] : null;
        if ($scenarioId && $scenarioId !== $actualScenario) {
            throw new \App\Core\AccessDeniedException('Scenario does not belong to the assigned ticket.');
        }
        return $actualScenario;
    }

    public static function owned(string $table, int $id, int $studentId): array
    {
        if (!in_array($table, ['notebooks', 'experiments', 'experiment_runs'], true)) {
            throw new InvalidArgumentException('Invalid resource type.');
        }
        $record = Database::queryOne("SELECT * FROM `$table` WHERE id = :id AND student_id = :sid", ['id' => $id, 'sid' => $studentId]);
        if (!$record) {
            throw new \App\Core\AccessDeniedException('Related resource does not belong to this student.');
        }
        return $record;
    }
}
