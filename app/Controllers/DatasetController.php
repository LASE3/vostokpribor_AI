<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Middleware\AuthenticationMiddleware;
use App\Middleware\AuthorizationMiddleware;
use App\Services\DatasetService;

class DatasetController
{
    private DatasetService $datasetService;

    public function __construct()
    {
        $this->datasetService = new DatasetService();
    }

    public function index(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $format = $request->query('format');
        $datasets = $this->datasetService->listForUser((int)$user['id'], $user['role'], $format);
        Response::success($datasets);
    }

    public function show(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);

        try {
            $dataset = $this->datasetService->getDataset($id, (int)$user['id'], $user['role']);
            Response::success($dataset);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'NOT_FOUND', 404);
        }
    }

    public function preview(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);
        $limit = min(50, max(5, (int)$request->query('limit', 20)));

        try {
            $preview = $this->datasetService->getPreview($id, (int)$user['id'], $user['role'], $limit);
            Response::success($preview);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        }
    }

    public function download(Request $request, array $params): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $id = (int)($params['id'] ?? 0);

        try {
            $filePath = $this->datasetService->getDownloadPath($id, (int)$user['id'], $user['role']);
            $dataset = $this->datasetService->getDataset($id, (int)$user['id'], $user['role']);

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($dataset['name']) . '.' . $dataset['format'] . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'ACCESS_DENIED', 403);
        }
    }

    public function store(Request $request): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $file = $request->file('dataset_file');
        if (!$file) {
            Response::error('Missing dataset file in multipart upload.', 'VALIDATION_ERROR', 422);
        }

        try {
            $dataset = $this->datasetService->uploadDataset($file, $request->body(), Auth::id());
            Response::success($dataset, 'Dataset uploaded and indexed successfully', 201);
        } catch (\InvalidArgumentException $e) {
            Response::error($e->getMessage(), 'VALIDATION_ERROR', 422);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function assign(Request $request, array $params): void
    {
        AuthorizationMiddleware::requireAdmin(true);
        $datasetId = (int)($params['id'] ?? 0);
        $studentId = (int)$request->body('student_id', 0);
        $ticketId = $request->body('ticket_id') ? (int)$request->body('ticket_id') : null;

        if ($studentId <= 0) {
            Response::error('Valid student_id required.', 'VALIDATION_ERROR', 422);
        }

        try {
            $this->datasetService->assignDataset($datasetId, $studentId, Auth::id(), $ticketId);
            Response::success(null, 'Dataset assigned to cadet successfully');
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }

    public function storeProcessed(Request $request): void
    {
        $user = AuthenticationMiddleware::handle(true);
        $file = $request->file('processed_file');
        $sourceId = (int)$request->body('source_dataset_id', 0);
        $ticketId = $request->body('ticket_id') ? (int)$request->body('ticket_id') : null;

        if (!$file || $sourceId <= 0) {
            Response::error('Source dataset ID and processed file are required.', 'VALIDATION_ERROR', 422);
        }

        try {
            $result = $this->datasetService->uploadProcessedDataset($sourceId, (int)$user['id'], $ticketId, $file, $request->body());
            Response::success($result, 'Processed dataset artifact saved', 201);
        } catch (\Throwable $e) {
            Response::error($e->getMessage(), 'SERVER_ERROR', 500);
        }
    }
}
