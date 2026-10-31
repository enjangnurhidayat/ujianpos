<?php

require_once __DIR__ . '/../config/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

verify_csrf();

$id = (int)($_POST['id'] ?? 0);

if ($id < 1) {

    flash('ID transaksi tidak valid.', 'danger');

    redirect('index.php');
}

$stmt = $pdo->prepare("
    DELETE FROM sales WHERE id = ?
");

$stmt->execute([$id]);

if ($stmt->rowCount() > 0) {

    flash('Transaksi berhasil dihapus.');

} else {

    flash('Transaksi tidak ditemukan.', 'warning');

}

redirect('index.php');
