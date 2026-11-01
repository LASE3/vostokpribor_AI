<?php
namespace App\Core;

use InvalidArgumentException;

/** Bounded, stable collection windows. Callers supply trusted SQL and ownership filters. */
final class Pagination
{
    public static function from(array $query, int $default = 100, int $maximum = 200): array
    {
        $limit = self::integer($query['limit'] ?? $default, 'limit', 1);
        $offset = self::integer($query['offset'] ?? 0, 'offset', 0);
        return ['limit' => min($limit, $maximum), 'offset' => $offset];
    }

    private static function integer(mixed $value, string $name, int $minimum): int
    {
        if ((!is_int($value) && !is_string($value)) || !preg_match('/^\d+$/D', (string)$value)
            || strlen((string)$value) > 10 || (float)$value > 2147483647 || (int)$value < $minimum) {
            throw new InvalidArgumentException("Invalid {$name}; a whole number of at least {$minimum} is required.");
        }
        return (int)$value;
    }

    public static function query(string $sql, array $params = [], array $paging = [], ?string $countSql = null, ?array $countParams = null): array
    {
        $paging = self::from($paging);
        $total = (int)(Database::queryOne($countSql ?? ('SELECT COUNT(*) AS total FROM (' . $sql . ') collection_count'), $countParams ?? $params)['total'] ?? 0);
        // Only validated integers are interpolated: native PDO treats generic bound values as strings.
        $items = Database::query($sql . ' LIMIT ' . $paging['limit'] . ' OFFSET ' . $paging['offset'], $params);
        return self::result($items, $total, $paging);
    }

    public static function result(array $items, int $total, array $paging = []): array
    {
        $paging = self::from($paging);
        $returned = count($items);
        $hasMore = $paging['offset'] + $returned < $total;
        return $paging + ['items' => $items, 'total' => $total, 'returned' => $returned, 'has_more' => $hasMore,
            'next_offset' => $hasMore ? $paging['offset'] + $paging['limit'] : null,
            'previous_offset' => $paging['offset'] > 0 ? max(0, $paging['offset'] - $paging['limit']) : null];
    }

    public static function metadata(array $page): array
    {
        return array_intersect_key($page, array_flip(['total','limit','offset','returned','has_more','next_offset','previous_offset']));
    }
}
