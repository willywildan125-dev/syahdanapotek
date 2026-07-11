<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$query = "SELECT o.kode_obat, o.nama_obat, o.harga_jual, o.satuan_terkecil, o.deskripsi_kemasan, o.image_path, k.nama_kategori, IFNULL(SUM(s.jumlah_stock), 0) as stock 
          FROM obat o 
          LEFT JOIN kategori k ON o.id_kategori = k.id_kategori
          LEFT JOIN stock s ON o.kode_obat = s.kode_obat
          GROUP BY o.kode_obat";

$result = mysqli_query($conn, $query);

$obat_list = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $obat_list[] = $row;
    }
}

echo json_encode($obat_list);
?>
