<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'kasir') {
    header("Location: login.php");
    exit;
}

include '../config/koneksi.php';

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: makanan.php");
    exit;
}

$id = (int) $_GET['id'];

// Ambil data menu
$data = mysqli_query($koneksi, "SELECT * FROM menu WHERE id = $id");
$menu = mysqli_fetch_assoc($data);

// Jika tidak ditemukan
if (!$menu) {
    echo "<script>alert('Menu tidak ditemukan!');window.location='makanan.php';</script>";
    exit;
}

// Ambil jenis dari data (default fallback ke makanan)
$jenis = $menu['kategori'] ?? 'makanan';

// Proses Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama  = htmlspecialchars(trim($_POST['nama']));
    $harga = (int) $_POST['harga'];

    if (!empty($nama) && $harga > 0) {
        $query = "UPDATE menu SET nama = '$nama', harga = $harga WHERE id = $id";
        mysqli_query($koneksi, $query);

        $redirect = ($jenis === 'minuman') ? 'minuman.php' : 'makanan.php';
        header("Location: $redirect?pesan=update_berhasil");
        exit;
    } else {
        $error = "Nama dan harga tidak boleh kosong atau salah.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="bg-white p-4 shadow rounded">
        <h4 class="mb-4">Edit Menu - <?= ucfirst($jenis) ?></h4>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Menu</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= htmlspecialchars($menu['nama']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" class="form-control" value="<?= $menu['harga'] ?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?= ($jenis === 'minuman' ? 'minuman.php' : 'makanan.php') ?>" class="btn btn-secondary">← Batal</a>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
