<?php
// Backend/get_persediaan.php

// 1. Panggil koneksi (karena satu folder, cukup panggil nama filenya)
require_once 'koneksi.php';

// 2. Siapkan Query SQL
$query = "
    SELECT 
        o.kode_obat, 
        o.nama_obat, 
        o.harga_jual, 
        k.nama_kategori,
        COALESCE(SUM(s.jumlah_stock), 0) AS total_stok
    FROM obat o
    LEFT JOIN kategori k ON o.id_kategori = k.id_kategori
    LEFT JOIN stock s ON o.kode_obat = s.kode_obat
    GROUP BY o.kode_obat
    ORDER BY o.nama_obat ASC
";

$result = mysqli_query($conn, $query);

// 3. Simpan hasil query ke dalam sebuah Array Kosong
$data_produk = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data_produk[] = $row; // Masukkan setiap baris data ke dalam array
    }
}

// Sekarang kita punya variabel $data_produk yang siap dipakai oleh Frontend!
?>