<?php
declare(strict_types=1);
namespace App\Execution;

interface ExecutionProvider
{
    public function availability(): array;
    public function submit(array $snapshot): array;
    public function cancel(string $reference): void;
}
