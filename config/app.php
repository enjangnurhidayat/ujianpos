<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/database.php';

define('BASE_URL', '/35/ujianpos');

function e($value) {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function rupiah($value) {
    return 'Rp ' . number_format((float)$value, 0, ',', '.');
}

function redirect($url) {
    header("Location: " . $url);
    exit;
}

function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' .
        e(csrf_token()) . '">';
}

function verify_csrf() {
    $token = $_POST['csrf_token'] ?? '';

    if (!is_string($token) ||
        !hash_equals(csrf_token(), $token)) {
        die('Token keamanan tidak valid.');
    }
}

function flash($message = null, $type = 'success') {
    if ($message !== null) {
        $_SESSION['flash'] = [
            'message' => $message,
            'type' => $type
        ];

        return;
    }

    if (!empty($_SESSION['flash'])) {
        $data = $_SESSION['flash'];

        echo '<div class="alert alert-' . e($data['type']) . ' alert-dismissible fade show">';
        echo e($data['message']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        echo '</div>';

        unset($_SESSION['flash']);
    }
}
