<?php

require_once __DIR__ . '/../config/app.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT * FROM suppliers WHERE id = ?
");

$stmt->execute([$id]);

$supplier = $stmt->fetch();

if (!$supplier) {
    flash('Data supplier tidak ditemukan.', 'warning');
    redirect('index.php');
}

$pageTitle = 'Edit Supplier';

require __DIR__ . '/../includes/header.php';

?>

<h2 class="fw-bold mb-4">Edit Supplier</h2>

<div class="card p-4">

    <form action="update.php" method="POST">

        <?= csrf_field() ?>

        <input
            type="hidden"
            name="id"
            value="<?= (int)$supplier['id'] ?>"
        >

        <div class="mb-3">
            <label class="form-label">Nama Supplier</label>

            <input
                type="text"
                name="name"
                class="form-control"
                maxlength="50"
                value="<?= e($supplier['name']) ?>"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>

            <textarea
                name="address"
                class="form-control"
                maxlength="255"
                rows="3"
            ><?= e($supplier['address']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Telepon</label>

            <input
                type="text"
                name="phone"
                class="form-control"
                maxlength="50"
                value="<?= e($supplier['phone']) ?>"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>

            <input
                type="email"
                name="email"
                class="form-control"
                maxlength="50"
                value="<?= e($supplier['email']) ?>"
            >
        </div>

        <button class="btn btn-primary">
            Update Supplier
        </button>

        <a href="index.php" class="btn btn-secondary">
            Batal
        </a>

    </form>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
