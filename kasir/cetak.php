<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;

include '../config/koneksi.php';

$id = intval($_GET['id']);
$order = mysqli_query($koneksi, "SELECT * FROM orders WHERE id = $id");
if (!$order || mysqli_num_rows($order) == 0) {
    die("Pesanan tidak ditemukan");
}
$o = mysqli_fetch_assoc($order);

$items = mysqli_query($koneksi, "
    SELECT menu.nama, menu.harga, order_items.jumlah 
    FROM order_items 
    JOIN menu ON order_items.id_menu = menu.id 
    WHERE order_items.order_id = $id
");

ob_start();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/struk.css">
</head>
<body class="struk-page">
<div class="struk">
    <h2>Koffie & Chill</h2>
    <p class="center">Jl. Kaliurang KM 12,5</p>
    <hr>
    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            while ($item = mysqli_fetch_assoc($items)) {
                $sub = $item['harga'] * $item['jumlah'];
                $total += $sub;
            ?>
            <tr>
                <td><?= $item['nama'] ?></td>
                <td class="text-center"><?= $item['jumlah'] ?></td>
                <td class="text-right"><?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($sub, 0, ',', '.') ?></td>
            </tr>
            <?php } ?>
            <tr class="total">
                <td colspan="3" class="text-right">TOTAL</td>
                <td class="text-right">Rp <?= number_format($total, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <p><strong>Meja:</strong> <?= $o['meja'] ?></p>
    <p><strong>Metode:</strong> <?= strtoupper($o['metode_pembayaran']) ?></p>
    <p><strong>Status:</strong> <?= ucfirst($o['status']) ?></p>
    <p><strong>Waktu:</strong> <?= $o['waktu'] ?></p>
    <hr>
    <p class="center">Terima kasih! Selamat Menikmati 🥳</p>
</div>
</body>
</html>

<?php
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper([0, 0, 300, 600], 'portrait');
$dompdf->render();
$dompdf->stream("struk-pesanan.pdf", array("Attachment" => false));
?>
