<?php
require_once 'koneksi.php';

header('Content-Type: application/json');

// Get the last kode_obat that matches the OBT-XXXX pattern
$query = mysqli_query($conn, "SELECT kode_obat FROM obat WHERE kode_obat LIKE 'OBT-%' ORDER BY kode_obat DESC LIMIT 1");

$next_number = 1;

if ($query && mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    // Extract the number part from OBT-XXXX
    $last_code = $row['kode_obat'];
    $number_part = (int) substr($last_code, 4); // skip "OBT-"
    $next_number = $number_part + 1;
}

// Also check for any non-OBT codes to avoid collision if user previously used manual codes
// Fallback: just count total obat and add 1 if it's higher
$count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM obat");
$count_row = mysqli_fetch_assoc($count_query);
$total = (int)$count_row['total'];

// Use the higher of the two to be safe
$next_number = max($next_number, $total + 1);

$next_sku = 'OBT-' . str_pad($next_number, 4, '0', STR_PAD_LEFT);

echo json_encode([
    'success' => true,
    'sku' => $next_sku
]);
?>
