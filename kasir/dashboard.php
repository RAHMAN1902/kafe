<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'kasir') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: url('../assets/img/kafe.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .main-box {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

    </style>
</head>
<body>
    <div class="container py-5">
        <div class="main-box">
            <div class="navbar-custom d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4>Eskala Kafe</h4>
                    <small class="text-white">Selamat datang, Kasir!</small>
                </div>
                <div>
                    <a href="logout.php" class="btn btn-outline-dark btn-sm">
                        <i class="fa fa-sign-out-alt"></i> Keluar
                    </a>
                </div>
            </div>

            <div class="mt-4">
                <h5 class="mb-4">Menu Utama</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <a href="makanan.php" class="text-decoration-none text-dark">
                            <div class="bg-light card-menu shadow">
                                <i class="fas fa-utensils"></i>
                                <h6 class="mt-2">Kelola Makanan</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="minuman.php" class="text-decoration-none text-dark">
                            <div class="bg-light card-menu shadow">
                                <i class="fas fa-coffee"></i>
                                <h6 class="mt-2">Kelola Minuman</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="pesanan.php" class="text-decoration-none text-dark">
                            <div class="bg-light card-menu shadow">
                                <i class="fas fa-list"></i>
                                <h6 class="mt-2">Daftar Pesanan</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a href="riwayat.php" class="text-decoration-none text-dark">
                            <div class="bg-light card-menu shadow">
                                <i class="fas fa-history"></i>
                                <h6 class="mt-2">Riwayat Pesanan</h6>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
