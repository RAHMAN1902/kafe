<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'kasir') {
    header("Location: login.php");
    exit;
}

include '../config/koneksi.php';

$nama   = htmlspecialchars($_POST['nama']);
$harga  = (int) $_POST['harga'];
$jenis  = $_POST['jenis'] ?? 'makanan'; 
$lokasi = $_FILES['gambar']['tmp_name'];

$redirect = ($jenis === 'minuman') ? 'minuman.php' : 'makanan.php';

// Validasi data
if (!empty($nama) && $harga > 0 && in_array($jenis, ['makanan', 'minuman'])) {
    if (!empty($gambar)) {
        $ext        = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
        $nama_baru  = uniqid('menu_') . '.' . $ext;
        $upload_path = '../uploads/' . $nama_baru;

        if (move_uploaded_file($lokasi, $upload_path)) {
            mysqli_query($koneksi, "INSERT INTO menu (nama, harga, jenis, gambar) VALUES ('$nama', $harga, '$jenis', '$nama_baru')");
            header("Location: $redirect?pesan=berhasil");
            exit;
        } else {
            header("Location: menu_tambah.php?jenis=$jenis&pesan=gagal_upload");
            exit;
        }
    } else {
        // Simpan tanpa gambar (kalau diperbolehkan)
        mysqli_query($koneksi, "INSERT INTO menu (nama, harga, jenis) VALUES ('$nama', $harga, '$jenis')");
        header("Location: $redirect?pesan=berhasil");
        exit;
    }
} else {
    header("Location: menu_tambah.php?jenis=$jenis&pesan=invalid");
    exit;
}
?>
