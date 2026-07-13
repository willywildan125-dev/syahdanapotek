<?php
/**
 * Script untuk menambahkan kolom metode_pembayaran ke tabel nota_penjualan.
 * Jalankan sekali saja melalui browser: http://localhost/syahdanapotek/Backend/alter_metode.php
 */
require_once 'koneksi.php';

// Cek apakah kolom sudah ada
$check = mysqli_query($conn, "SHOW COLUMNS FROM nota_penjualan LIKE 'metode_pembayaran'");

if (mysqli_num_rows($check) == 0) {
    $sql = "ALTER TABLE nota_penjualan ADD COLUMN metode_pembayaran VARCHAR(20) NOT NULL DEFAULT 'Tunai' AFTER total_harga";
    if (mysqli_query($conn, $sql)) {
        echo "✅ Kolom 'metode_pembayaran' berhasil ditambahkan ke tabel nota_penjualan.";
    } else {
        echo "❌ Gagal menambahkan kolom: " . mysqli_error($conn);
    }
} else {
    echo "ℹ️ Kolom 'metode_pembayaran' sudah ada.";
}
?>
