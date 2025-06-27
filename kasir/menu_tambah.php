<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'kasir') {
    header("Location: login.php");
    exit;
}

include '../config/koneksi.php';

// Ambil jenis dari URL (makanan atau minuman)
$kategori = $_GET['jenis'] ?? 'makanan';
$link_kembali = $kategori === 'minuman' ? 'minuman.php' : 'makanan.php';

// Proses simpan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama     = htmlspecialchars(trim($_POST['nama']));
    $harga    = (int) $_POST['harga'];
    $kategori = $_POST['kategori'];
    $gambar   = $_FILES['gambar']['name'];
    $tmp      = $_FILES['gambar']['tmp_name'];
    $folder   = "../uploads/";

    if (!empty($nama) && $harga > 0 && !empty($gambar) && in_array($kategori, ['makanan', 'minuman'])) {
        $ext      = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
        $filename = uniqid('menu_') . '.' . $ext;
        $target   = $folder . $filename;

        if (move_uploaded_file($tmp, $target)) {
            // SIMPAN KE KOLOM kategori BUKAN jenis
            mysqli_query($koneksi, "INSERT INTO menu (nama, harga, kategori, gambar) VALUES ('$nama', $harga, '$kategori', '$filename')");
            header("Location: $link_kembali?pesan=berhasil");
            exit;
        } else {
            $error = "Gagal mengupload gambar.";
        }
    } else {
        $error = "Nama, harga, kategori, dan gambar wajib diisi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="bg-white p-4 shadow rounded">
        <h4 class="mb-4">Tambah Menu Baru</h4>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php } ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="kategori" value="<?= $kategori ?>">

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Menu</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Gambar</label>
                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?= $link_kembali ?>" class="btn btn-secondary">← Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Menu</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
