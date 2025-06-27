<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != 'kasir') {
    header("Location: login.php");
    exit;
}
include '../config/koneksi.php';

if (isset($_GET['id']) && isset($_GET['jenis'])) {
    $id = intval($_GET['id']);
    $jenis = $_GET['jenis']; // 'makanan' atau 'minuman'

    // Hapus menu
    mysqli_query($koneksi, "DELETE FROM menu WHERE id = $id");

    // Redirect sesuai jenis menu
    if ($jenis == 'makanan') {
        header("Location: makanan.php?pesan=hapus_berhasil");
    } elseif ($jenis == 'minuman') {
        header("Location: minuman.php?pesan=hapus_berhasil");
    } else {
        header("Location: makanan.php?pesan=hapus_berhasil");
    }
    exit;
} else {
    // Jika tidak ada ID atau jenis, kembalikan ke halaman makanan
    header("Location: makanan.php");
    exit;
}
