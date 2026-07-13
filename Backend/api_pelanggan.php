<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

$pelanggan_list = [];

$check_table = mysqli_query($conn, "SHOW TABLES LIKE 'pelanggan'");
if ($check_table && mysqli_num_rows($check_table) > 0) {
    $query = "SELECT * FROM pelanggan ORDER BY nama_pelanggan ASC";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pelanggan_list[] = [
                'id_pelanggan' => $row['id_pelanggan'] ?? '',
                'nama_pelanggan' => $row['nama_pelanggan'] ?? $row['nama'] ?? '',
                'telepon' => $row['telepon'] ?? '',
                'alamat' => $row['alamat'] ?? ''
            ];
        }
    }
}

echo json_encode($pelanggan_list);
