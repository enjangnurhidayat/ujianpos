<?php
$pageTitle = $pageTitle ?? 'Dashboard';
$currentPage = basename(dirname($_SERVER['SCRIPT_NAME']));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> | UjianPOS</title>

    <link rel="icon" href="<?= BASE_URL ?>/images/logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            color: #202938;
            min-height: 100vh;
        }

        .navbar {
            background: #14213d;
        }

        .navbar-brand img {
            width: 38px;
            height: 38px;
            object-fit: contain;
            margin-right: 8px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .stat-number {
            font-size: 30px;
            font-weight: bold;
        }

        footer {
            color: #7b8493;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/index.php">
            <img src="<?= BASE_URL ?>/images/logo.png" alt="Logo">
            UjianPOS
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <div class="navbar-nav ms-auto">
                <a class="nav-link <?= $currentPage === 'ujianpos' ? 'active' : '' ?>"
                   href="<?= BASE_URL ?>/index.php">Dashboard</a>

                <a class="nav-link <?= $currentPage === 'suppliers' ? 'active' : '' ?>"
                   href="<?= BASE_URL ?>/suppliers/index.php">Suppliers</a>

                <a class="nav-link <?= $currentPage === 'sales' ? 'active' : '' ?>"
                   href="<?= BASE_URL ?>/sales/index.php">Sales</a>
            </div>
        </div>
    </div>
</nav>

<main class="container py-4">
    <?php flash(); ?>
