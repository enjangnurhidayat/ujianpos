<?php
require_once __DIR__ . '/../config/app.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT * FROM sales WHERE id = ?
");

$stmt->execute([$id]);

$sale = $stmt->fetch();

if (!$sale) {

    flash('Transaksi tidak ditemukan.', 'warning');

    redirect('index.php');
}

$suppliers = $pdo->query("
    SELECT id, name
    FROM suppliers
    ORDER BY name ASC
")->fetchAll();

$pageTitle = 'Edit Transaksi';

require __DIR__ . '/../includes/header.php';

?>

<h2 class="fw-bold mb-4">Edit Transaksi #<?= $id ?></h2>

<div class="card p-4">

    <form action="update.php" method="POST">

        <?= csrf_field() ?>

        <input
            type="hidden"
            name="id"
            value="<?= (int)$sale['id'] ?>"
        >

        <div class="mb-3">

            <label class="form-label">
                Supplier
            </label>

            <select
                name="supplier_id"
                class="form-select"
                required
            >

                <?php foreach ($suppliers as $supplier): ?>

                    <option
                        value="<?= (int)$supplier['id'] ?>"
                        <?= (int)$sale['supplier_id'] === (int)$supplier['id'] ? 'selected' : '' ?>
                    >

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
                value="<?= (int)$sale['total'] ?>"
                required
            >
        </div>

        <button class="btn btn-primary">
            Update Transaksi
        </button>

        <a href="index.php" class="btn btn-secondary">
            Batal
        </a>

    </form>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>