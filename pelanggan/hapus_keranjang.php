<?php
session_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if (isset($_SESSION['keranjang'][$id])) {
        unset($_SESSION['keranjang'][$id]);
    }
}

header("Location: keranjang.php");
exit;
