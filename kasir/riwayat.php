<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'kasir') {
    header("Location: login.php");
    exit;
}
include '../config/koneksi.php';

$query = "
    SELECT 
        orders.id AS order_id,
        orders.meja,
        orders.metode_pembayaran,
        orders.status,
        orders.waktu,
        GROUP_CONCAT(CONCAT(menu.nama, ' x', order_items.jumlah) SEPARATOR '<br>') AS daftar_menu,
        SUM(menu.harga * order_items.jumlah) AS total_harga
    FROM orders
    JOIN order_items ON orders.id = order_items.order_id
    JOIN menu ON order_items.id_menu = menu.id
    WHERE orders.status = 'selesai'
    GROUP BY orders.id
    ORDER BY orders.waktu DESC
";

$pesanan = mysqli_query($koneksi, $query);
if (!$pesanan) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body {
            background: url('../assets/img/kafe.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .content-box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="content-box mb-4">
        <h4 class="mb-4 text-center">Riwayat Pesanan</h4>

        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Menu Dipesan</th>
                    <th>Total Harga</th>
                    <th>Meja</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Cetak</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($p = mysqli_fetch_assoc($pesanan)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $p['daftar_menu'] ?></td>
                        <td>Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
                        <td><?= $p['meja'] ?></td>
                        <td><?= strtoupper($p['metode_pembayaran']) ?></td>
                        <td><span class="badge bg-danger"><?= ucfirst($p['status']) ?></span></td>
                        <td><?= $p['waktu'] ?></td>
                        <td>
                            <a href="cetak.php?id=<?= $p['order_id'] ?>" target="_blank" class="btn btn-sm btn-secondary">Cetak</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="dashboard.php" class="btn btn-secondary sticky-back">← Kembali ke Dashboard</a>
    </div>
</div>
</body>
</html>
