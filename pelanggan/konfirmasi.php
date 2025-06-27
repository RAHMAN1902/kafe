<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Pesanan Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="bg-white p-5 rounded shadow text-center">
        <h2 class="text-success">Pesanan Berhasil 🥳!</h2>
        <p class="mt-3">Terima kasih, Pesanan anda sedang diproses.</p>

        <?php if (isset($_SESSION['metode_pembayaran']) && $_SESSION['metode_pembayaran'] === 'qris') : ?>
            <div class="mt-4">
                <h5>Silakan scan QRIS untuk pembayaran:</h5>
                <img src="../assets/img/qris.png" width="250" alt="QRIS" class="mt-2">
            </div>
        <?php endif; ?>

        <a href="index.php" class="btn btn-primary mt-4">Kembali ke Menu</a>
    </div>
</div>
</body>
</html>

<?php
// Hapus session supaya tidak muncul terus
unset($_SESSION['metode_pembayaran']);
?>
