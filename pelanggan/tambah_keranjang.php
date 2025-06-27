<?php
session_start();

// Ambil data dari POST
$id_menu = isset($_POST['id_menu']) ? (int) $_POST['id_menu'] : 0;
$jumlah = isset($_POST['jumlah']) ? (int) $_POST['jumlah'] : 1;

// Validasi
if ($id_menu < 1 || $jumlah < 1) {
    die("Data tidak valid.");
}

// Inisialisasi keranjang
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Tambah atau update jumlah
if (isset($_SESSION['keranjang'][$id_menu])) {
    $_SESSION['keranjang'][$id_menu] += $jumlah;
} else {
    $_SESSION['keranjang'][$id_menu] = $jumlah;
}

header("Location: index.php");
exit;
