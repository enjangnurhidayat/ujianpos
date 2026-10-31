<?php

require_once __DIR__ . '/../config/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

verify_csrf();

$id      = (int)($_POST['id'] ?? 0);
$name    = trim($_POST['name'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$email   = trim($_POST['email'] ?? '');

if ($id < 1) {
    flash('ID supplier tidak valid.', 'danger');
    redirect('index.php');
}

if (
    strlen($name) > 50 ||
    strlen($address) > 255 ||
    strlen($phone) > 50 ||
    strlen($email) > 50
) {
    flash('Panjang data melebihi batas kolom.', 'danger');
    redirect('edit.php?id=' . $id);
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash('Format email tidak valid.', 'danger');
    redirect('edit.php?id=' . $id);
}

$stmt = $pdo->prepare("
    UPDATE suppliers
    SET name = ?,
        address = ?,
        phone = ?,
        email = ?
    WHERE id = ?
");

$stmt->execute([
    $name !== '' ? $name : null,
    $address !== '' ? $address : null,
    $phone !== '' ? $phone : null,
    $email !== '' ? $email : null,
    $id
]);

flash('Data supplier berhasil diperbarui.');

redirect('index.php');
