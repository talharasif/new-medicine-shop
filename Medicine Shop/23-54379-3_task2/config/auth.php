<?php
/*
|--------------------------------------------------------------------------
| TASK 2 DEMO MODE - LOGIN BYPASS
|--------------------------------------------------------------------------
| Login/authentication belongs to Task 1.
| This file automatically creates an admin session so Task 2 can be
| demonstrated independently.
|
| IMPORTANT: Replace this file with the real Task 1 authentication/session
| logic when merging the final group project.
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Demo admin session */
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['name'] = 'Task 2 Demo Admin';
    $_SESSION['role'] = 'admin';
}

function requireAdmin(): void {
    // Demo mode: automatically allow the Task 2 demonstration.
    if (($_SESSION['role'] ?? '') !== 'admin') {
        $_SESSION['user_id'] = 1;
        $_SESSION['name'] = 'Task 2 Demo Admin';
        $_SESSION['role'] = 'admin';
    }
}

function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrf(): bool {
    return isset($_POST['csrf_token'], $_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

function e($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
