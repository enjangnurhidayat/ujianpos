<?php

require_once __DIR__ . '/../config/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

verify_csrf();

$id = (int)($_POST['id'] ?? 0);

if ($id < 1) {
    flash('ID supplier tidak valid.', 'danger');
    redirect('index.php');
}

$stmt = $pdo->prepare("
    DELETE FROM suppliers WHERE id = ?
");

$stmt->execute([$id]);

if ($stmt->rowCount() > 0) {
    flash('Supplier berhasil dihapus.');
} else {
    flash('Supplier tidak ditemukan.', 'warning');
}

redirect('index.php');
