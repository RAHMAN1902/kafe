<?php
session_start();
include '../config/koneksi.php';

// Ambil isi keranjang dari session
$keranjang = $_SESSION['keranjang'] ?? [];

// Persiapkan variabel data
$items = [];
$total = 0;

// Ambil data menu berdasarkan id di keranjang
if (!empty($keranjang)) {
    $ids = implode(',', array_map('intval', array_keys($keranjang)));
    $query = "SELECT * FROM menu WHERE id IN ($ids)";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $id_menu = $row['id'];
        $jumlah = $keranjang[$id_menu];

        $row['jumlah'] = $jumlah;
        $row['subtotal'] = $row['harga'] * $jumlah;
        $total += $row['subtotal'];

        $items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang | Kafe</title>
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
        <h4 class="mb-4 text-center">Keranjang Pesanan</h4>

        <?php if (empty($items)) { ?>
            <div class="alert alert-warning text-center">
                Keranjang masih kosong.<br>
            </div>
        <?php } else { ?>
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item) { ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama']) ?></td>
                            <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td><?= $item['jumlah'] ?></td>
                            <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                            <td>
                                <a href="hapus_keranjang.php?id=<?= $item['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Hapus menu ini dari keranjang?')">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr class="table-secondary fw-bold">
                        <td colspan="3" class="text-end">Total</td>
                        <td colspan="2">Rp <?= number_format($total, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>

            <form action="pesan.php" method="POST" class="mt-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="meja" class="form-label">Nomor Meja</label>
                        <select name="meja" id="meja" class="form-select" required>
                            <option value="">-- Pilih Meja --</option>
                            <?php for ($i = 1; $i <= 10; $i++) { ?>
                                <option value="<?= $i ?>">Meja <?= $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="pembayaran" class="form-label">Metode Pembayaran</label>
                        <select name="pembayaran" id="pembayaran" class="form-select" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="cash">Cash</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Pesan Sekarang</button>
                </div>
            </form>
        <?php } ?>
    </div>

    <!-- Tombol kembali DI LUAR card box -->
    <div class="d-flex justify-content-start">
        <a href="index.php" class="btn btn-secondary sticky-back">← Kembali ke Menu</a>
    </div>
</div>
</body>
</html>
