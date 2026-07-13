<?php
require_once 'koneksi.php';
/** @var mysqli $conn */

header('Content-Type: application/json');

$kode_obat = mysqli_real_escape_string($conn, $_GET['kode_obat'] ?? '');

if (empty($kode_obat)) {
    echo json_encode(['success' => false, 'message' => 'Kode obat tidak valid']);
    exit();
}

$query = mysqli_query($conn, "
    SELECT 
        o.*,
        k.nama_kategori,
        IFNULL(SUM(s.jumlah_stock), 0) as total_stock,
        IFNULL(MAX(s.harga_awal), 0) as hpp
    FROM obat o
    LEFT JOIN kategori k ON o.id_kategori = k.id_kategori
    LEFT JOIN stock s ON o.kode_obat = s.kode_obat
    WHERE o.kode_obat = '$kode_obat'
    GROUP BY o.kode_obat
");

if ($query && mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    echo json_encode(['success' => true, 'data' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => 'Produk tidak ditemukan']);
}
?>
