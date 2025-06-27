<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'kasir') {
    header("Location: login.php");
    exit;
}
include '../config/koneksi.php';

// Ubah status pesanan jika ada request
if (isset($_GET['ubah_status'])) {
    $id = intval($_GET['ubah_status']);
    $allowed = ['pending', 'proses', 'selesai'];
    $status_baru = in_array($_GET['status'], $allowed) ? $_GET['status'] : 'pending';

    mysqli_query($koneksi, "UPDATE orders SET status='$status_baru' WHERE id=$id");
    header("Location: pesanan.php");
    exit;
}

// Gabungkan pesanan berdasarkan order
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
    WHERE orders.status != 'selesai'
    GROUP BY orders.id
    ORDER BY orders.waktu DESC
";


$pesanan = mysqli_query($koneksi, $query);

// Mapping status untuk tampilan
$status_label = [
    'pending' => ['label' => 'Menunggu', 'class' => 'bg-warning'],
    'proses'  => ['label' => 'Diproses', 'class' => 'bg-primary'],
    'selesai' => ['label' => 'Selesai',   'class' => 'bg-success']
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pesanan | Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h4 class="mb-4 text-center">Daftar Pesanan</h4>

        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Menu Dipesan</th>
                    <th>Total Harga</th>
                    <th>Meja</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($p = mysqli_fetch_assoc($pesanan)) { 
                    $status = $p['status'];
                    $label = $status_label[$status]['label'] ?? $status;
                    $badge = $status_label[$status]['class'] ?? 'bg-secondary';
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $p['daftar_menu'] ?></td>
                    <td>Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
                    <td><?= $p['meja'] ?></td>
                    <td><?= strtoupper($p['metode_pembayaran']) ?></td>
                    <td><span class="badge <?= $badge ?>"><?= $label ?></span></td>
                    <td><?= $p['waktu'] ?></td>
                    <td>
                        <?php if ($p['status'] != 'selesai') { ?>
                            <div class="btn-group">
                                <a href="pesanan.php?ubah_status=<?= $p['order_id'] ?>&status=proses" class="btn btn-sm btn-warning">Proses</a>
                                <a href="pesanan.php?ubah_status=<?= $p['order_id'] ?>&status=selesai" class="btn btn-sm btn-success">Selesai</a>
                                <a href="cetak.php?id=<?= $p['order_id'] ?>" target="_blank" class="btn btn-sm btn-secondary">Cetak</a>
                            </div>
                        <?php } else { ?>
                            <a href="cetak.php?id=<?= $p['order_id'] ?>" target="_blank" class="btn btn-sm btn-secondary">Cetak</a>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Tombol kembali -->
    <div class="mt-4">
        <a href="dashboard.php" class="btn btn-secondary sticky-back">← Kembali ke Dashboard</a>
    </div>

</div>
</body>
</html>
