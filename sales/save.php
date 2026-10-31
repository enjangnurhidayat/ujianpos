<?php

require_once __DIR__ . '/../config/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

verify_csrf();

$supplierId = (int)($_POST['supplier_id'] ?? 0);

$total = filter_var(
    $_POST['total'] ?? null,
    FILTER_VALIDATE_INT
);

$check = $pdo->prepare("
    SELECT COUNT(*)
    FROM suppliers
    WHERE id = ?
");

$check->execute([$supplierId]);

$supplierExists = (int)$check->fetchColumn();

if (
    $supplierId < 1 ||
    !$supplierExists ||
    $total === false ||
    $total < 0 ||
    $total > 4294967295
) {

    flash('Data transaksi tidak valid.', 'danger');

    redirect('add.php');
}

$stmt = $pdo->prepare("
    INSERT INTO sales
    (supplier_id, total)
    VALUES (?, ?)
");

$stmt->execute([
    $supplierId,
    $total
]);

flash('Transaksi berhasil ditambahkan.');

redirect('index.php');
