<?php
require_once __DIR__ . '/../config/app.php';

$pageTitle = 'Tambah Transaksi';

$suppliers = $pdo->query("
    SELECT id, name
    FROM suppliers
    ORDER BY name ASC
")->fetchAll();

require __DIR__ . '/../includes/header.php';
?>

<h2 class="fw-bold mb-4">Tambah Transaksi Sales</h2>

<div class="card p-4">

    <?php if (!$suppliers): ?>

        <div class="alert alert-warning">
            Belum ada supplier. Tambahkan supplier terlebih dahulu.
        </div>

    <?php else: ?>

        <form action="save.php" method="POST">

            <?= csrf_field() ?>

            <div class="mb-3">

                <label class="form-label">
                    Pilih Supplier
                </label>

                <select
                    name="supplier_id"
                    class="form-select"
                    required
                >

                    <option value="">
                        -- Pilih Supplier --
                    </option>

                    <?php foreach ($suppliers as $supplier): ?>

                        <option value="<?= (int)$supplier['id'] ?>">

                            <?= e($supplier['name']) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="mb-3">
                <label class="form-label">
                    Total
                </label>
                <input
                    type="number"
                    name="total"
                    class="form-control"
                    min="0"
                    max="4294967295"
                    step="1"
                    required
                >
            </div>

            <button class="btn btn-primary">
                Simpan Transaksi
            </button>

            <a href="index.php" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    <?php endif; ?>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>