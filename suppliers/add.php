<?php
require_once __DIR__ . '/../config/app.php';

$pageTitle = 'Tambah Supplier';

require __DIR__ . '/../includes/header.php';
?>

<div class="mb-4">
    <h2 class="fw-bold">Tambah Supplier</h2>
    <p class="text-secondary">Masukkan informasi supplier baru.</p>
</div>

<div class="card p-4">
    <form action="save.php" method="POST">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Nama Supplier</label>
            <input
                type="text"
                name="name"
                class="form-control"
                maxlength="50"
                placeholder="Masukkan nama supplier"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea
                name="address"
                class="form-control"
                rows="3"
                maxlength="255"
                placeholder="Masukkan alamat supplier"
            ></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Telepon</label>
            <input
                type="text"
                name="phone"
                class="form-control"
                maxlength="50"
                placeholder="Contoh: 081234567890"
            >
        </div>

        <div class="mb-4">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                maxlength="50"
                placeholder="Masukan alamat email kamu"
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Supplier
        </button>

        <a href="index.php" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
