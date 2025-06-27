<?php
session_start();
include '../config/koneksi.php';

// Ambil makanan & minuman terpisah
$makanan = mysqli_query($koneksi, "SELECT * FROM menu WHERE kategori = 'makanan'");
$minuman = mysqli_query($koneksi, "SELECT * FROM menu WHERE kategori = 'minuman'");
$makanan = mysqli_fetch_all($makanan, MYSQLI_ASSOC);
$minuman = mysqli_fetch_all($minuman, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pesan Menu | Kafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .card-menu {
            transition: 0.3s;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .heading-bg {
            display: inline-block;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 6px 16px;
            border-radius: 12px;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
    </style>

</head>
<body>
<div class="container py-5">
    <h2 class="text-center mb-5">Selamat Datang di Koffie & Chill</h2>
    <h3 class="text-center mb-5">Menu</h3>

    <!-- Bagian Makanan -->
    <h4 class="mb-3"><span class="heading-bg">🍽️ Makanan</span></h4>
    <div class="row">
        <?php foreach ($makanan as $i => $m): 
            $rowNum = floor($i / 4);
            $animasi = ($rowNum % 2 == 0) ? 'fade-left' : 'fade-right';
        ?>
        <div class="col-md-3 mb-4" data-aos="<?= $animasi ?>" data-aos-delay="<?= ($i % 4) * 100 ?>">
            <div class="card-menu">
                <img src="../uploads/<?= htmlspecialchars($m['gambar']) ?>" class="w-100" alt="<?= htmlspecialchars($m['nama']) ?>">
                <div class="p-3">
                    <h5><?= htmlspecialchars($m['nama']) ?></h5>
                    <p class="text-muted small">Cocok untuk mengisi perut yang lapar</p>
                    <div class="menu-harga mb-2">Rp <?= number_format($m['harga'], 0, ',', '.') ?></div>
                    <button class="btn btn-success w-100 btn-tambah" onclick="tampilkanForm(this)">+ Tambah</button>
                    <form action="tambah_keranjang.php" method="POST" class="input-pesan">
                        <input type="hidden" name="id_menu" value="<?= $m['id'] ?>">
                        <div class="input-group mt-2">
                            <input type="number" name="jumlah" min="1" value="1" class="form-control" required>
                            <button type="submit" name="submit" value="tambah" class="btn btn-primary">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Bagian Minuman -->
    <h4 class="mt-5 mb-3"><span class="heading-bg">🥤 Minuman</span></h4>
    <div class="row">
        <?php foreach ($minuman as $i => $m): 
            $rowNum = floor($i / 4);
            $animasi = ($rowNum % 2 == 0) ? 'fade-left' : 'fade-right';
        ?>
        <div class="col-md-3 mb-4" data-aos="<?= $animasi ?>" data-aos-delay="<?= ($i % 4) * 100 ?>">
            <div class="card-menu">
                <img src="../uploads/<?= htmlspecialchars($m['gambar']) ?>" class="w-100" alt="<?= htmlspecialchars($m['nama']) ?>">
                <div class="p-3">
                    <h5><?= htmlspecialchars($m['nama']) ?></h5>
                    <p class="text-muted small">Haus? Beli dong</p>
                    <div class="menu-harga mb-2">Rp <?= number_format($m['harga'], 0, ',', '.') ?></div>
                    <button class="btn btn-success w-100 btn-tambah" onclick="tampilkanForm(this)">+ Tambah</button>
                    <form action="tambah_keranjang.php" method="POST" class="input-pesan">
                        <input type="hidden" name="id_menu" value="<?= $m['id'] ?>">
                        <div class="input-group mt-2">
                            <input type="number" name="jumlah" min="1" value="1" class="form-control" required>
                            <button type="submit" name="submit" value="tambah" class="btn btn-primary">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Tombol keranjang -->
    <a href="keranjang.php" class="btn btn-primary keranjang-btn">
        🛒 Lihat Keranjang
    </a>
</div>

<!-- Footer -->
<footer class="bg-dark text-light mt-5 py-4 footer-animasi" data-aos="fade-up" data-aos-duration="1200">
    <div class="container">
        <div class="row">
            <!-- Tentang Kami -->
            <div class="col-md-4 mb-3">
                <h5>Tentang Kami</h5>
                <p>Kafe kami menyediakan aneka makanan dan minuman dengan bahan berkualitas tinggi serta suasana nyaman. Anda nyaman kami senang</p>
            </div>

            <!-- Kontak Kami -->
            <div class="col-md-4 mb-3">
                <h5>Kontak Kami</h5>
                <p>Email: info@rahman.com<br>
                Telp: 0895-3780-07078<br>
                Jl. Kaliurang Km.12,5</p>
            </div>

            <!-- Lokasi -->
            <div class="col-md-4 mb-3">
                <h5>Lokasi</h5>
                <p>
                    <a href="https://maps.app.goo.gl/oURGhKUZLW9ptzcPA" target="_blank" class="text-light text-decoration-none">
                        Lihat di Google Maps
                    </a>
                </p>
                <p>Jam Buka: 09.00 - 23.59 WIB</p>
            </div>
        </div>
        <hr class="bg-secondary">
        <div class="text-center small">
            &copy; <?= date('Y') ?> Koffie & Chill. By. Rahman
        </div>
    </div>
</footer>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init();
    function tampilkanForm(btn) {
        const parent = btn.closest('.card-menu');
        const form = parent.querySelector('.input-pesan');
        btn.style.display = 'none';
        form.style.display = 'block';
    }
</script>

</body>
</html>
