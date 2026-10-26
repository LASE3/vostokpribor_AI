<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Core\Logger;
use App\Core\Validator;
use InvalidArgumentException;
use RuntimeException;

class UserService
{
    private UserRepository $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function listStudents(array $filters = [], int $limit = 50, int $offset = 0): array
    {
        $items = $this->userRepo->listStudents($filters, $limit, $offset);
        $total = $this->userRepo->countStudents($filters);

        return [
            'items' => $items,
            'total' => $total,
            'limit' => $limit,
            'offset' => $offset
        ];
    }

    public function getStudentDossier(int $id): ?array
    {
        return $this->userRepo->getStudentDossier($id);
    }

    public function createStudent(array $data, int $actorId): array
    {
        $validator = new Validator();
        $valid = $validator->validate($data, [
            'full_name'  => 'required|string|min:2|max:120',
            'email'      => 'required|email|max:191',
            'identifier' => 'required|string|min:3|max:64',
            'cohort'     => 'string|max:64',
            'department' => 'string|max:120',
            'password'   => 'required|string|min:8',
            'status'     => 'in:ACTIVE,INACTIVE,SUSPENDED'
        ]);

        if (!$valid) {
            throw new InvalidArgumentException($validator->getFirstError() ?? 'Validation failed.');
        }

        // Check unique email and identifier
        if ($this->userRepo->findByEmailOrIdentifier($data['email'])) {
            throw new InvalidArgumentException('A user with this email address already exists.');
        }

        if ($this->userRepo->findByEmailOrIdentifier($data['identifier'])) {
            throw new InvalidArgumentException('A user with this student identifier already exists.');
        }

        $passwordHash = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);

        $createData = [
            'email'                => strtolower(trim($data['email'])),
            'password_hash'        => $passwordHash,
            'full_name'            => trim($data['full_name']),
            'identifier'           => strtoupper(trim($data['identifier'])),
            'cohort'               => trim($data['cohort'] ?? 'Cohort 2025-A'),
            'department'           => trim($data['department'] ?? 'Avionics AI Cadet Cohort'),
            'status'               => $data['status'] ?? 'ACTIVE',
            'must_change_password' => !empty($data['must_change_password']) ? 1 : 0
        ];

        $studentId = $this->userRepo->createStudent($createData);

        Logger::audit(
            'STUDENT_CREATED',
            'users',
            (string)$studentId,
            'SUCCESS',
            [
                'identifier' => $createData['identifier'],
                'email'      => $createData['email'],
                'cohort'     => $createData['cohort']
            ],
            $actorId
        );

        return $this->userRepo->findById($studentId);
    }

    public function updateStudent(int $id, array $data, int $actorId): array
    {
        $student = $this->userRepo->findById($id);
        if (!$student || $student['role'] !== 'STUDENT') {
            throw new RuntimeException('Student not found.');
        }

        $updateData = [];

        if (isset($data['full_name'])) {
            $updateData['full_name'] = trim($data['full_name']);
        }

        if (isset($data['email'])) {
            $email = strtolower(trim($data['email']));
            $existing = $this->userRepo->findByEmailOrIdentifier($email);
            if ($existing && (int)$existing['id'] !== $id) {
                throw new InvalidArgumentException('Email address is already in use by another user.');
            }
            $updateData['email'] = $email;
        }

        if (isset($data['cohort'])) {
            $updateData['cohort'] = trim($data['cohort']);
        }

        if (isset($data['department'])) {
            $updateData['department'] = trim($data['department']);
        }

        if (isset($data['status'])) {
            if (!in_array($data['status'], ['ACTIVE', 'INACTIVE', 'SUSPENDED'])) {
                throw new InvalidArgumentException('Invalid student status value.');
            }
            $updateData['status'] = $data['status'];
        }

        if (!empty($data['password'])) {
            if (strlen($data['password']) < 8) {
                throw new InvalidArgumentException('Password must be at least 8 characters long.');
            }
            $updateData['password_hash'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
            $updateData['must_change_password'] = 1;
        }

        $this->userRepo->updateStudent($id, $updateData);

        Logger::audit(
            'STUDENT_UPDATED',
            'users',
            (string)$id,
            'SUCCESS',
            array_keys($updateData),
            $actorId
        );

        return $this->userRepo->findById($id);
    }

    public function resetPassword(int $id, string $newPassword, int $actorId): void
    {
        if (strlen($newPassword) < 8) {
            throw new InvalidArgumentException('New password must be at least 8 characters long.');
        }

        $student = $this->userRepo->findById($id);
        if (!$student) {
            throw new RuntimeException('Student not found.');
        }

        $hash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
        $this->userRepo->updateStudent($id, [
            'password_hash' => $hash,
            'must_change_password' => 1
        ]);

        Logger::audit(
            'STUDENT_PASSWORD_RESET',
            'users',
            (string)$id,
            'SUCCESS',
            ['reset_by' => $actorId],
            $actorId
        );
    }
}
