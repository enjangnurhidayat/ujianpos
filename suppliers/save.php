<?php

require_once __DIR__ . '/../config/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

verify_csrf();

$name    = trim($_POST['name'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$email   = trim($_POST['email'] ?? '');

if (
    strlen($name) > 50 ||
    strlen($address) > 255 ||
    strlen($phone) > 50 ||
    strlen($email) > 50
) {
    flash('Panjang data melebihi batas kolom.', 'danger');
    redirect('add.php');
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flash('Format email tidak valid.', 'danger');
    redirect('add.php');
}

$stmt = $pdo->prepare("
    INSERT INTO suppliers
    (name, address, phone, email)
    VALUES (?, ?, ?, ?)
");

$stmt->execute([
    $name !== '' ? $name : null,
    $address !== '' ? $address : null,
    $phone !== '' ? $phone : null,
    $email !== '' ? $email : null
]);

flash('Supplier berhasil ditambahkan.');

redirect('index.php');
