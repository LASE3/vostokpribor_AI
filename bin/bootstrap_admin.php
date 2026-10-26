<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/bootstrap.php';

use App\Core\Database;
use App\Core\Logger;

echo "=============================================================\n";
echo "   VOSTOKPRIBOR AI • INITIAL ADMINISTRATOR BOOTSTRAP (CLI)   \n";
echo "=============================================================\n";

// Ensure this script is only run from CLI
if (php_sapi_name() !== 'cli') {
    fwrite(STDERR, "Error: This command can only be executed from the CLI.\n");
    exit(1);
}

// Check if an administrator already exists
$adminCount = (int)Database::queryOne("SELECT COUNT(*) as cnt FROM users WHERE role = 'ADMIN'")['cnt'];
$options = getopt('', ['email:', 'password:', 'name:', 'identifier:', 'force']);

if ($adminCount > 0 && !isset($options['force'])) {
    fwrite(STDERR, "SECURITY NOTICE: An administrator account already exists ({$adminCount} active/configured).\n");
    fwrite(STDERR, "Unrestricted administrator creation is locked. Pass --force to provision an additional administrator.\n");
    exit(1);
}

$email = $options['email'] ?? null;
$password = $options['password'] ?? null;
$name = $options['name'] ?? null;
$identifier = $options['identifier'] ?? null;

// Read interactively if arguments not provided
if (!$email) {
    echo "Enter Administrator Email (e.g. admin@vostokpribor.space): ";
    $email = trim((string)fgets(STDIN));
}
if (!$name) {
    echo "Enter Administrator Full Name (e.g. Chief Instructor K. Voronin): ";
    $name = trim((string)fgets(STDIN));
}
if (!$identifier) {
    echo "Enter Administrator Identifier (e.g. VK-ADMIN-01): ";
    $identifier = trim((string)fgets(STDIN));
}
if (!$password) {
    echo "Enter Strong Password (minimum 8 characters): ";
    $password = trim((string)fgets(STDIN));
}

// Validate Inputs
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fwrite(STDERR, "Validation Error: Invalid email format.\n");
    exit(1);
}

if (strlen($password) < 8) {
    fwrite(STDERR, "Validation Error: Password must be at least 8 characters long.\n");
    exit(1);
}

if (empty($name) || empty($identifier)) {
    fwrite(STDERR, "Validation Error: Name and Identifier cannot be empty.\n");
    exit(1);
}

// Check uniqueness
$existing = Database::queryOne(
    "SELECT id FROM users WHERE email = :email OR identifier = :ident LIMIT 1",
    ['email' => $email, 'ident' => $identifier]
);

if ($existing) {
    fwrite(STDERR, "Conflict Error: A user with this email or identifier already exists.\n");
    exit(1);
}

// Hash password
$passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

Database::execute(
    "INSERT INTO users (role, email, password_hash, full_name, identifier, cohort, department, status, must_change_password, created_at)
     VALUES ('ADMIN', :email, :hash, :name, :ident, 'Mission Control', 'AI Operations Center (AI SOC)', 'ACTIVE', 0, NOW())",
    [
        'email' => $email,
        'hash'  => $passwordHash,
        'name'  => $name,
        'ident' => $identifier
    ]
);

$adminId = (int)Database::lastInsertId();

Logger::audit(
    'BOOTSTRAP_ADMIN_CREATED',
    'users',
    (string)$adminId,
    'SUCCESS',
    ['email' => $email, 'identifier' => $identifier, 'via' => 'CLI_BOOTSTRAP'],
    $adminId
);

echo "\n[SUCCESS] Administrator account successfully created!\n";
echo "ID:         $adminId\n";
echo "Name:       $name\n";
echo "Identifier: $identifier\n";
echo "Email:      $email\n";
echo "Role:       ADMIN\n";
echo "Status:     ACTIVE\n";
echo "=============================================================\n";
