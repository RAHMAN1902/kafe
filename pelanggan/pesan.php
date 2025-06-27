<?php
session_start();
include '../config/koneksi.php';

// Ambil data dari form
$meja = $_POST['meja'] ?? '';
$pembayaran = $_POST['pembayaran'] ?? '';
$keranjang = $_SESSION['keranjang'] ?? [];

// Validasi input
if (empty($meja) || empty($pembayaran) || empty($keranjang)) {
    die("Data tidak lengkap atau keranjang kosong.");
}

// Simpan ke tabel orders (transaksi utama)
$queryOrder = "INSERT INTO orders (meja, metode_pembayaran, status) 
               VALUES ('$meja', '$pembayaran', 'pending')";
mysqli_query($koneksi, $queryOrder);

// Ambil ID order yang baru dibuat
$id_order = mysqli_insert_id($koneksi);

// Simpan detail item ke order_items
foreach ($keranjang as $id_menu => $jumlah) {
    $queryItem = "INSERT INTO order_items (order_id, id_menu, jumlah) 
                  VALUES ('$id_order', '$id_menu', '$jumlah')";
    mysqli_query($koneksi, $queryItem);
}

// Simpan metode pembayaran ke session (untuk tampilkan QRIS)
$_SESSION['metode_pembayaran'] = $pembayaran;

// Bersihkan keranjang
unset($_SESSION['keranjang']);

// Redirect ke konfirmasi
header("Location: konfirmasi.php?id=$id_order");
exit;
