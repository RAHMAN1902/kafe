<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'kasir') {
    header("Location: login.php");
    exit;
}
include '../config/koneksi.php';
$menu = mysqli_query($koneksi, "SELECT * FROM menu WHERE kategori = 'makanan'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Makanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            background: url('../assets/img/kafe.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .menu-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
<div class="container py-5">

    <div class="menu-box mb-4">
        <h4 class="mb-4 text-center">Kelola Makanan</h4>

        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Makanan</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($m = mysqli_fetch_assoc($menu)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($m['nama']) ?></td>
                        <td>Rp <?= number_format($m['harga'], 0, ',', '.') ?></td>
                        <td>
                            <a href="menu_edit.php?id=<?= $m['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="menu_hapus.php?id=<?= $m['id'] ?>&jenis=makanan" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between">
        <a href="dashboard.php" class="btn btn-secondary">← Kembali ke Dashboard</a>
        <a href="menu_tambah.php?jenis=makanan" class="btn btn-primary">+ Tambah Makanan</a>
    </div>

</div>
</body>
</html>
