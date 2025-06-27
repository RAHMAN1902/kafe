<?php
session_start();
include '../config/koneksi.php';

// Ambil data dari form
$menu = $_POST['menu']; // array menu[]
$meja = $_POST['meja'];
$pembayaran = $_POST['pembayaran'];

// Simpan metode ke session (untuk QRIS)
$_SESSION['metode_pembayaran'] = $pembayaran;

// Simpan semua pesanan ke database
foreach ($menu as $id_menu) {
    mysqli_query($koneksi, "INSERT INTO pesanan (id_menu, meja, metode_pembayaran) 
                            VALUES ('$id_menu', '$meja', '$pembayaran')");
}

// Hapus isi keranjang dari session
unset($_SESSION['keranjang']);

// Redirect ke halaman konfirmasi
header("Location: konfirmasi.php");
exit;
?>
