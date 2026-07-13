<?php
// Pastikan tidak ada spasi atau baris kosong sebelum <?php
require_once 'koneksi.php';

// Atur header agar merespons dalam bentuk JSON
header('Content-Type: application/json');

// Query untuk mengambil data obat beserta total stok dan nama kategorinya
// Kita gunakan LEFT JOIN agar obat yang belum punya stok tetap muncul (dengan stok 0)
$query = "
    SELECT 
        MIN(o.kode_obat) AS kode_obat, 
        o.nama_obat, 
        o.harga_jual, 
        o.satuan AS deskripsi_kemasan, 
        o.no_rak,
        k.nama_kategori,
        COALESCE(SUM(s.jumlah_stock), 0) AS stock
    FROM obat o
    LEFT JOIN stock s ON o.kode_obat = s.kode_obat
    LEFT JOIN kategori k ON o.id_kategori = k.id_kategori
    GROUP BY o.nama_obat, o.harga_jual, o.satuan, o.no_rak, k.nama_kategori
";

$result = mysqli_query($conn, $query);

$products = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Memastikan tipe data angka benar (tidak menjadi string)
        $row['harga_jual'] = (int)$row['harga_jual'];
        $row['stock'] = (int)$row['stock'];

        $products[] = $row;
    }
}

// Kembalikan data dalam format JSON
echo json_encode($products);
?>