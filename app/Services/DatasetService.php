<?php

namespace App\Services;

use App\Repositories\DatasetRepository;
use App\Core\Logger;
use InvalidArgumentException;
use RuntimeException;

class DatasetService
{
    private DatasetRepository $datasetRepo;
    private string $storageDir;

    public function __construct()
    {
        $this->datasetRepo = new DatasetRepository();
        $this->storageDir = dirname(__DIR__, 2) . '/storage/private/datasets';
        if (!is_dir($this->storageDir)) {
            mkdir($this->storageDir, 0755, true);
        }
    }

    public function listForUser(int $userId, string $role, ?string $format = null): array
    {
        return $this->datasetRepo->listForUser($userId, $role, $format);
    }

    public function getDataset(int $id, int $userId, string $role): array
    {
        $dataset = $this->datasetRepo->findById($id);
        if (!$dataset) {
            throw new RuntimeException('Dataset not found.');
        }

        if ($role !== 'ADMIN' && !$this->datasetRepo->isAssignedToStudent($id, $userId)) {
            throw new RuntimeException('Access denied. This dataset is not assigned to your cadet profile.');
        }

        return $dataset;
    }

    public function getPreview(int $id, int $userId, string $role, int $limit = 20): array
    {
        $dataset = $this->getDataset($id, $userId, $role);
        $fullPath = $this->storageDir . '/' . basename($dataset['file_path']);

        if (!file_exists($fullPath)) {
            throw new RuntimeException('Dataset storage artifact not found on disk.');
        }

        $format = strtolower($dataset['format']);
        $rows = [];
        $columns = [];

        if ($format === 'csv') {
            $handle = fopen($fullPath, 'r');
            if ($handle !== false) {
                $header = fgetcsv($handle);
                if ($header !== false) {
                    $columns = $header;
                    $count = 0;
                    while (($row = fgetcsv($handle)) !== false && $count < $limit) {
                        $rowAssoc = [];
                        foreach ($columns as $idx => $colName) {
                            $rowAssoc[$colName] = $row[$idx] ?? '';
                        }
                        $rows[] = $rowAssoc;
                        $count++;
                    }
                }
                fclose($handle);
            }
        } elseif ($format === 'json') {
            $content = file_get_contents($fullPath);
            $decoded = json_decode($content, true);
            if (is_array($decoded)) {
                $slice = array_slice($decoded, 0, $limit);
                if (!empty($slice)) {
                    $columns = array_keys($slice[0]);
                    $rows = $slice;
                }
            }
        }

        return [
            'dataset' => [
                'id'         => $dataset['id'],
                'code'       => $dataset['code'],
                'name'       => $dataset['name'],
                'format'     => $dataset['format'],
                'row_count'  => $dataset['row_count'],
                'column_count' => $dataset['column_count']
            ],
            'columns' => $columns,
            'preview_rows' => $rows,
            'preview_limit' => $limit
        ];
    }

    public function getDownloadPath(int $id, int $userId, string $role): string
    {
        $dataset = $this->getDataset($id, $userId, $role);
        $fullPath = $this->storageDir . '/' . basename($dataset['file_path']);

        if (!file_exists($fullPath)) {
            throw new RuntimeException('File artifact missing on storage node.');
        }

        Logger::audit('DATASET_DOWNLOADED', 'datasets', (string)$id, 'SUCCESS', [
            'code' => $dataset['code']
        ], $userId);

        return $fullPath;
    }

    public function uploadDataset(array $fileInfo, array $metadata, int $actorId): array
    {
        if (empty($fileInfo['tmp_name']) || !file_exists($fileInfo['tmp_name'])) {
            throw new InvalidArgumentException('No valid dataset file uploaded.');
        }

        $maxSize = 50 * 1024 * 1024; // 50MB
        if ($fileInfo['size'] > $maxSize) {
            throw new InvalidArgumentException('Uploaded file exceeds maximum limit of 50MB.');
        }

        $ext = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['csv', 'json'])) {
            throw new InvalidArgumentException('Unsupported dataset format. Permitted formats: CSV, JSON.');
        }

        $code = strtoupper(trim($metadata['code'] ?? 'DS-' . uniqid()));
        if ($this->datasetRepo->findByCode($code)) {
            throw new InvalidArgumentException('A dataset with this code already exists.');
        }

        $name = trim($metadata['name'] ?? $fileInfo['name']);
        $storageFilename = 'ds_' . uniqid() . '.' . $ext;
        $targetPath = $this->storageDir . '/' . $storageFilename;

        if (!move_uploaded_file($fileInfo['tmp_name'], $targetPath)) {
            // In case of local copy for testing
            copy($fileInfo['tmp_name'], $targetPath);
        }

        $sha256 = hash_file('sha256', $targetPath);
        $fileSize = filesize($targetPath);

        // Calculate rows and columns
        $rowCount = 0;
        $colCount = 0;
        $schema = [];

        if ($ext === 'csv') {
            $handle = fopen($targetPath, 'r');
            if ($handle) {
                $header = fgetcsv($handle);
                if ($header) {
                    $colCount = count($header);
                    $schema = $header;
                    while (fgets($handle) !== false) {
                        $rowCount++;
                    }
                }
                fclose($handle);
            }
        } elseif ($ext === 'json') {
            $content = file_get_contents($targetPath);
            $decoded = json_decode($content, true);
            if (is_array($decoded)) {
                $rowCount = count($decoded);
                if ($rowCount > 0 && is_array($decoded[0])) {
                    $colCount = count($decoded[0]);
                    $schema = array_keys($decoded[0]);
                }
            }
        }

        $datasetId = $this->datasetRepo->create([
            'code'            => $code,
            'name'            => $name,
            'description'     => trim($metadata['description'] ?? ''),
            'format'          => $ext,
            'file_path'       => $storageFilename,
            'file_size'       => $fileSize,
            'checksum_sha256' => $sha256,
            'row_count'       => $rowCount,
            'column_count'    => $colCount,
            'schema_json'     => $schema,
            'is_master'       => 1,
            'version'         => $metadata['version'] ?? 'v1.0',
            'scenario_id'     => !empty($metadata['scenario_id']) ? (int)$metadata['scenario_id'] : null,
            'uploaded_by'     => $actorId
        ]);

        Logger::audit('DATASET_UPLOADED', 'datasets', (string)$datasetId, 'SUCCESS', [
            'code'  => $code,
            'size'  => $fileSize,
            'sha'   => $sha256
        ], $actorId);

        return $this->datasetRepo->findById($datasetId);
    }

    public function assignDataset(int $datasetId, int $studentId, int $actorId, ?int $ticketId = null): void
    {
        $dataset = $this->datasetRepo->findById($datasetId);
        if (!$dataset) {
            throw new RuntimeException('Dataset not found.');
        }

        $this->datasetRepo->assignToStudent($datasetId, $studentId, $actorId, $ticketId);

        Logger::audit('DATASET_ASSIGNED', 'datasets', (string)$datasetId, 'SUCCESS', [
            'student_id' => $studentId,
            'ticket_id'  => $ticketId
        ], $actorId);
    }

    public function uploadProcessedDataset(int $sourceDatasetId, int $studentId, ?int $ticketId, array $fileInfo, array $metadata): array
    {
        $source = $this->datasetRepo->findById($sourceDatasetId);
        if (!$source) {
            throw new RuntimeException('Source dataset not found.');
        }

        // Enforce student authorization: student must be assigned to source dataset
        $userRepo = new \App\Repositories\UserRepository();
        $user = $userRepo->findById($studentId);
        $role = $user['role'] ?? 'STUDENT';
        if ($role !== 'ADMIN' && !$this->datasetRepo->isAssignedToStudent($sourceDatasetId, $studentId)) {
            throw new RuntimeException('Access Denied: You are not assigned to this source dataset.');
        }

        if (empty($fileInfo['tmp_name']) || !file_exists($fileInfo['tmp_name'])) {
            throw new InvalidArgumentException('No processed dataset file provided.');
        }

        $ext = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['csv', 'json'])) {
            throw new InvalidArgumentException('Unsupported processed dataset format. Permitted: CSV, JSON.');
        }

        $storageFilename = 'proc_' . uniqid() . '.' . $ext;
        $targetPath = $this->storageDir . '/' . $storageFilename;
        if (!move_uploaded_file($fileInfo['tmp_name'], $targetPath)) {
            copy($fileInfo['tmp_name'], $targetPath);
        }

        $sha256 = hash_file('sha256', $targetPath);
        $fileSize = filesize($targetPath);

        $rowCount = 0;
        if ($ext === 'csv') {
            $handle = fopen($targetPath, 'r');
            if ($handle) {
                fgetcsv($handle);
                while (fgets($handle) !== false) $rowCount++;
                fclose($handle);
            }
        }

        $id = $this->datasetRepo->createProcessedDataset([
            'source_dataset_id'    => $sourceDatasetId,
            'student_id'           => $studentId,
            'ticket_id'            => $ticketId,
            'name'                 => trim($metadata['name'] ?? $fileInfo['name']),
            'description'          => trim($metadata['description'] ?? ''),
            'format'               => $ext,
            'file_path'            => $storageFilename,
            'file_size'            => $fileSize,
            'checksum_sha256'      => $sha256,
            'row_count'            => $rowCount,
            'transformation_notes' => trim($metadata['transformation_notes'] ?? '')
        ]);

        Logger::audit('PROCESSED_DATASET_UPLOADED', 'processed_datasets', (string)$id, 'SUCCESS', [
            'source_id' => $sourceDatasetId,
            'ticket_id' => $ticketId
        ], $studentId);

        return [
            'id'                => $id,
            'source_dataset_id' => $sourceDatasetId,
            'name'              => $metadata['name'] ?? $fileInfo['name'],
            'row_count'         => $rowCount,
            'file_size'         => $fileSize,
            'created_at'        => date('Y-m-d H:i:s')
        ];
    }
}
