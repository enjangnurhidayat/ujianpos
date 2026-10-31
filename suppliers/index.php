<?php
require_once __DIR__ . '/../config/app.php';

$pageTitle = 'Data Supplier';
$keyword = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;

$where = '';
$params = [];

if ($keyword !== '') {
    $where = "WHERE name LIKE ? OR email LIKE ? OR phone LIKE ?";
    $search = "%{$keyword}%";
    $params = [$search, $search, $search];
}

$count = $pdo->prepare("SELECT COUNT(*) FROM suppliers $where");
$count->execute($params);

$totalData = (int)$count->fetchColumn();
$totalPages = max(1, (int)ceil($totalData / $limit));
$page = min($page, $totalPages);
$offset = ($page - 1) * $limit;

$stmt = $pdo->prepare("
    SELECT id, name, address, phone, email
    FROM suppliers
    $where
    ORDER BY id DESC
    LIMIT $limit OFFSET $offset
");
$stmt->execute($params);
$suppliers = $stmt->fetchAll();

require __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Data Supplier</h2>
        <p class="text-secondary mb-0">Kelola informasi supplier UjianPOS.</p>
    </div>

    <a href="add.php" class="btn btn-primary">+ Tambah Supplier</a>
</div>

<div class="card p-4">
    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!$suppliers): ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            Data supplier tidak ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>

                <?php 
                $no = $offset + 1;
                foreach ($suppliers as $supplier): 
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-semibold"><?= e($supplier['name']) ?></td>
                        <td><?= e($supplier['address']) ?></td>
                        <td><?= e($supplier['phone']) ?></td>
                        <td><?= e($supplier['email']) ?></td>
                        <td class="text-nowrap">
                            <a
                                href="edit.php?id=<?= (int)$supplier['id'] ?>"
                                class="btn btn-sm btn-warning"
                            >Edit</a>

                            <form
                                action="delete.php"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus supplier ini? Transaksi terkait juga akan terhapus.');"
                            >
                                <?= csrf_field() ?>
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= (int)$supplier['id'] ?>"
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

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <small class="text-secondary">
            Menampilkan <?= count($suppliers) ?>
            dari <?= $totalData ?> supplier
        </small>

        <nav>
            <ul class="pagination pagination-sm mb-0">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $page === $i ? 'active' : '' ?>">
                        <a
                            class="page-link"
                            href="?q=<?= urlencode($keyword) ?>&page=<?= $i ?>"
                        ><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>