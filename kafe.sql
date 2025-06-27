-- Buat database
CREATE DATABASE IF NOT EXISTS kafe;
USE kafe;

-- Tabel pengguna
CREATE TABLE IF NOT EXISTS pengguna (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    level ENUM('kasir', 'admin') DEFAULT 'kasir'
);

INSERT INTO pengguna (username, password, level) VALUES
('kasir1', MD5('12345'), 'kasir');

-- Tabel menu
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    gambar VARCHAR(255) DEFAULT NULL,
    kategori VARCHAR(20) -- tambahkan kolom kategori
);

-- Data menu awal, lengkap dengan kategori
INSERT INTO menu (nama, harga, kategori) VALUES
('Kopi Hitam', 10000, 'minuman'),
('Kopi Susu', 15000, 'minuman'),
('Nasi Goreng', 20000, 'makanan');

-- Tabel order utama (1 baris = 1 transaksi pelanggan)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    meja INT NOT NULL,
    metode_pembayaran ENUM('cash', 'qris') NOT NULL,
    status ENUM('pending', 'proses', 'selesai') DEFAULT 'pending',
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel detail menu per transaksi
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    id_menu INT NOT NULL,
    jumlah INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (id_menu) REFERENCES menu(id) ON DELETE CASCADE
);
