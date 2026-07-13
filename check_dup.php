<?php
require_once 'Backend/koneksi.php';
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
$r = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($r)) {
    echo implode(' | ', $row) . "\n";
}
?>
