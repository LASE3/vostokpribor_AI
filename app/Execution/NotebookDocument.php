<?php
declare(strict_types=1);
namespace App\Execution;

/** Code exchange is not execution evidence. Never export/import outputs or credentials. */
final class NotebookDocument
{
    public const MAX_BYTES = 2097152;

    public static function encode(array $notebook): string
    {
        $cells = [];
        foreach ($notebook['cells'] ?? [] as $cell) {
            $type = $cell['cell_type'] ?? 'code';
            if (!in_array($type, ['code', 'markdown'], true) || !is_string($cell['source'] ?? null)) {
                throw new \InvalidArgumentException('Notebook contains an unsupported cell.');
            }
            $item = ['id'=>'cell-'.(count($cells)+1), 'cell_type'=>$type, 'metadata'=>(object)[], 'source'=>$cell['source']];
            if ($type === 'code') $item += ['execution_count'=>null, 'outputs'=>[]];
            $cells[] = $item;
        }
        $json = json_encode(['nbformat'=>4, 'nbformat_minor'=>5,
            'metadata'=>['kernelspec'=>['display_name'=>'Python 3', 'language'=>'python', 'name'=>'python3'],
                'language_info'=>['name'=>'python']], 'cells'=>$cells], JSON_THROW_ON_ERROR|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        if (strlen($json) > self::MAX_BYTES) throw new \InvalidArgumentException('Notebook exchange is limited to 2 MiB.');
        return $json;
    }

    public static function decode(string $json): array
    {
        if ($json === '' || strlen($json) > self::MAX_BYTES) throw new \InvalidArgumentException('Upload a notebook of at most 2 MiB.');
        try { $data = json_decode($json, true, 64, JSON_THROW_ON_ERROR); }
        catch (\JsonException $e) { throw new \InvalidArgumentException('Notebook must be valid UTF-8 JSON.'); }
        if (!is_array($data) || ($data['nbformat'] ?? null) !== 4 || !is_array($data['cells'] ?? null)
            || !array_is_list($data['cells']) || count($data['cells']) > 200) {
            throw new \InvalidArgumentException('Use a version 4 notebook with at most 200 cells.');
        }
        $cells = [];
        foreach ($data['cells'] as $cell) {
            if (!is_array($cell) || !in_array($cell['cell_type'] ?? '', ['code','markdown'], true)) {
                throw new \InvalidArgumentException('Only code and markdown cells can be imported.');
            }
            $source = $cell['source'] ?? null;
            if (is_array($source) && array_is_list($source) && !array_filter($source, fn($line)=>!is_string($line))) $source = implode('', $source);
            if (!is_string($source) || strlen($source) > 262144) throw new \InvalidArgumentException('Each cell source must be text of at most 256 KiB.');
            $cells[] = ['cell_type'=>$cell['cell_type'], 'source'=>$source];
        }
        return $cells;
    }
}
