<?php
require_once __DIR__ . '/../config/app.php';

$pageTitle = 'Data Sales';

$keyword = trim($_GET['q'] ?? '');

$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;

$where = '';
$params = [];

if ($keyword !== '') {
    $where = "
        WHERE suppliers.name LIKE ?
        OR CAST(sales.id AS CHAR) LIKE ?
    ";

    $search = "%{$keyword}%";
    $params = [$search, $search];
}

$count = $pdo->prepare("
    SELECT COUNT(*)
    FROM sales
    INNER JOIN suppliers
        ON suppliers.id = sales.supplier_id
    $where
");

$count->execute($params);

$totalData = (int)$count->fetchColumn();
$totalPages = max(1, (int)ceil($totalData / $limit));
$page = min($page, $totalPages);
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare("
    SELECT
        sales.id,
        sales.supplier_id,
        sales.total,
        suppliers.name AS supplier_name
    FROM sales
    INNER JOIN suppliers
        ON suppliers.id = sales.supplier_id
    $where
    ORDER BY sales.id DESC
    LIMIT $limit OFFSET $offset
");

$stmt->execute($params);
$sales = $stmt->fetchAll();

require __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Data Sales</h2>
        <p class="text-secondary">
            Manajemen transaksi penjualan.
        </p>
    </div>

    <a href="add.php" class="btn btn-primary">
        + Tambah Transaksi
    </a>
</div>

<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Supplier</th>
                    <th>Supplier ID</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!$sales): ?>
                    <tr>
                        <td colspan="5" class="text-center">
                            Data sales tidak ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php 
                $no = $offset + 1; 
                $supplierNo = $offset + 1;
                foreach ($sales as $sale): 
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <?= e($sale['supplier_name']) ?>
                        </td>
                        <td>
                            <?= $supplierNo++ ?>
                        </td>
                        <td>
                            <?= number_format((int)$sale['total'], 0, ',', '.') ?>
                        </td>
                        <td class="text-nowrap">
                            <a
                                href="edit.php?id=<?= (int)$sale['id'] ?>"
                                class="btn btn-sm btn-warning"
                            >
                                Edit
                            </a>

                            <form
                                action="delete.php"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');"
                            >
                                <?= csrf_field() ?>
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= (int)$sale['id'] ?>"
                                >
                                <button class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <small class="text-secondary">
            Menampilkan <?= count($sales) ?>
            dari <?= $totalData ?> transaksi
        </small>

        <nav>
            <ul class="pagination pagination-sm mb-0">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $page === $i ? 'active' : '' ?>">
                        <a
                            class="page-link"
                            href="?q=<?= urlencode($keyword) ?>&page=<?= $i ?>"
                        >
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>