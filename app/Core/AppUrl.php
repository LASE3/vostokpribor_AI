<?php
namespace App\Core;

/** A single configured installation prefix, including nested XAMPP checkouts. */
final class AppUrl
{
    public static function basePath(): string
    {
        $path = (string)(parse_url((string)Env::get('APP_URL', '/vostokpribor_AI'), PHP_URL_PATH) ?? '');
        return '/' . trim($path, '/');
    }
    public static function to(string $path): string { return rtrim(self::basePath(), '/') . '/' . ltrim($path, '/'); }
    public static function safeReturn(mixed $value): string
    {
        if (!is_string($value) || preg_match('/[\r\n\\\\]/', $value) || str_starts_with($value, '//')) return 'index.php';
        $path = parse_url($value, PHP_URL_PATH);
        if (parse_url($value, PHP_URL_SCHEME) || parse_url($value, PHP_URL_HOST) || str_contains(rawurldecode((string)$path), '..')) return 'index.php';
        if (str_starts_with($value, self::basePath() . '/') || preg_match('#^[A-Za-z0-9][A-Za-z0-9_ /%().&=-]*\.php(?:\?[^\r\n]*)?$#D', $value)) return $value;
        return 'index.php';
    }
}
