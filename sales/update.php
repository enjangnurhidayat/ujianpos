<?php

require_once __DIR__ . '/../config/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

verify_csrf();

$id = (int)($_POST['id'] ?? 0);

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
    $id < 1 ||
    $supplierId < 1 ||
    !$supplierExists ||
    $total === false ||
    $total < 0 ||
    $total > 4294967295
) {

    flash('Data transaksi tidak valid.', 'danger');

    redirect('index.php');
}

$stmt = $pdo->prepare("
    UPDATE sales
    SET supplier_id = ?,
        total = ?
    WHERE id = ?
");

$stmt->execute([
    $supplierId,
    $total,
    $id
]);

flash('Transaksi berhasil diperbarui.');

redirect('index.php');
