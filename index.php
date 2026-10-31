<?php
require_once __DIR__ . '/config/app.php';

$pageTitle = 'Dashboard';

$totalSuppliers = (int) $pdo
    ->query("SELECT COUNT(*) FROM suppliers")
    ->fetchColumn();

$totalSales = (int) $pdo
    ->query("SELECT COUNT(*) FROM sales")
    ->fetchColumn();

$totalRevenue = $pdo
    ->query("SELECT COALESCE(SUM(total), 0) FROM sales")
    ->fetchColumn();

require __DIR__ . '/includes/header.php';
?>

<div class="row align-items-center mb-5 py-4">
    <div class="col-lg-7">
        <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill mb-3">
            Sistem Point of Sales
        </span>
        <h1 class="display-4 fw-bold text-dark mb-3">
            Kelola Penjualan & Supplier Lebih Efisien
        </h1>
        <p class="fs-5 text-secondary mb-4 leading-relaxed">
            Selamat datang di <strong>UjianPOS</strong>. Platform manajemen transaksi terpadu untuk memantau aktivitas supplier dan mencatat jumlah produk yang terjual secara praktis.</p>
        <div class="d-flex flex-wrap gap-3">
            <a href="<?= BASE_URL ?>/sales/index.php" class="btn btn-primary btn-lg px-4 shadow-sm">
                <i class="bi bi-cart-check me-2"></i> Transaksi Sales
            </a>
            <a href="<?= BASE_URL ?>/suppliers/index.php" class="btn btn-outline-secondary btn-lg px-4">
                Data Supplier
            </a>
        </div>
    </div>
    <div class="col-lg-5 d-none d-lg-block text-center">
        <img src="<?= BASE_URL ?>/images/logo.png" alt="UjianPOS Logo" class="img-fluid" style="max-height: 260px; object-fit: contain;">
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
