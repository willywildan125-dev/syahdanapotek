<?php
require_once 'koneksi.php';
/** @var mysqli $conn */

header('Content-Type: application/json');

// Get medicines that are expired or expiring within 30 days
$today = date('Y-m-d');
$threshold = date('Y-m-d', strtotime('+30 days'));

$query = mysqli_query($conn, "
    SELECT 
        o.kode_obat,
        o.nama_obat,
        o.kadaluwarsa,
        o.satuan,
        k.nama_kategori,
        IFNULL(SUM(s.jumlah_stock), 0) as total_stock,
        DATEDIFF(o.kadaluwarsa, '$today') as sisa_hari
    FROM obat o
    LEFT JOIN kategori k ON o.id_kategori = k.id_kategori
    LEFT JOIN stock s ON o.kode_obat = s.kode_obat
    WHERE o.kadaluwarsa <= '$threshold'
    GROUP BY o.kode_obat
    ORDER BY o.kadaluwarsa ASC
");

$expired = [];
$expiring_soon = [];

while ($row = mysqli_fetch_assoc($query)) {
    $row['sisa_hari'] = (int)$row['sisa_hari'];
    $row['total_stock'] = (int)$row['total_stock'];
    
    if ($row['sisa_hari'] < 0) {
        $row['status'] = 'expired';
        $expired[] = $row;
    } else {
        $row['status'] = 'expiring_soon';
        $expiring_soon[] = $row;
    }
}

echo json_encode([
    'expired' => $expired,
    'expiring_soon' => $expiring_soon,
    'total_expired' => count($expired),
    'total_expiring_soon' => count($expiring_soon),
    'total_alerts' => count($expired) + count($expiring_soon)
]);
?>
