<?php
require_once __DIR__ . '/../config/database.php';

try {
    $pdo->beginTransaction();

    $supplierCount = (int) $pdo->query(
        "SELECT COUNT(*) FROM suppliers"
    )->fetchColumn();

    if ($supplierCount < 100) {
        $names = [
            'PT Maju Jaya', 'CV Sumber Rezeki',
            'PT Berkah Abadi', 'CV Mitra Sejahtera',
            'PT Nusantara Makmur', 'CV Cahaya Baru',
            'PT Teknologi Indonesia', 'CV Sinar Dunia',
            'PT Gemilang Persada', 'CV Karya Mandiri'
        ];

        $stmt = $pdo->prepare(
            "INSERT INTO suppliers (name, address, phone, email)
             VALUES (?, ?, ?, ?)"
        );

        for ($i = $supplierCount + 1; $i <= 100; $i++) {
            $name = $names[($i - 1) % count($names)] . " $i";

            $stmt->execute([
                $name,
                "Jl. Contoh No. $i, Indonesia",
                "08123456" . str_pad((string)$i, 4, '0', STR_PAD_LEFT),
                "supplier$i@example.com"
            ]);
        }
    }

    $supplierIds = $pdo->query(
        "SELECT id FROM suppliers"
    )->fetchAll(PDO::FETCH_COLUMN);

    if (!$supplierIds) {
        throw new Exception("Data supplier belum tersedia.");
    }

    $salesCount = (int) $pdo->query(
        "SELECT COUNT(*) FROM sales"
    )->fetchColumn();

    if ($salesCount < 200) {
        $stmt = $pdo->prepare(
            "INSERT INTO sales (supplier_id, total)
             VALUES (?, ?)"
        );

        for ($i = $salesCount + 1; $i <= 200; $i++) {
            $supplierId = $supplierIds[($i - 1) % count($supplierIds)];
            $total = random_int(50000, 2000000);

            $stmt->execute([$supplierId, $total]);
        }
    }

    $pdo->commit();

    echo "Seeder berhasil dijalankan!\n";
    echo "Jumlah supplier: " .
        $pdo->query("SELECT COUNT(*) FROM suppliers")->fetchColumn() . "\n";
    echo "Jumlah sales: " .
        $pdo->query("SELECT COUNT(*) FROM sales")->fetchColumn() . "\n";

} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "Seeder gagal: " . $e->getMessage() . "\n";
    exit(1);
}
