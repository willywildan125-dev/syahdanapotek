<?php
/**
 * API untuk mengambil data transaksi dengan filter dan pagination.
 * 
 * Query params:
 *   - start_date  : Tanggal mulai (Y-m-d)
 *   - end_date    : Tanggal akhir (Y-m-d)
 *   - search      : Cari berdasarkan no_nota
 *   - page        : Halaman saat ini (default 1)
 *   - per_page    : Jumlah data per halaman (default 5)
 */
require_once 'koneksi.php';
header('Content-Type: application/json');

$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : '';
$end_date   = isset($_GET['end_date'])   ? mysqli_real_escape_string($conn, $_GET['end_date'])   : '';

$search     = isset($_GET['search'])     ? mysqli_real_escape_string($conn, $_GET['search'])     : '';
$page       = isset($_GET['page'])       ? max(1, (int)$_GET['page'])                           : 1;
$per_page   = isset($_GET['per_page'])   ? max(1, (int)$_GET['per_page'])                       : 5;

$where = [];

if ($start_date && $end_date) {
    $where[] = "tgl_penjualan BETWEEN '$start_date' AND '$end_date'";
} elseif ($start_date) {
    $where[] = "tgl_penjualan >= '$start_date'";
} elseif ($end_date) {
    $where[] = "tgl_penjualan <= '$end_date'";
}



if ($search) {
    $where[] = "no_nota LIKE '%$search%'";
}

$where_sql = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

// Count total for pagination
$count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM nota_penjualan $where_sql");
$total_data = mysqli_fetch_assoc($count_query)['total'];
$total_pages = max(1, ceil($total_data / $per_page));

// Ensure page is within bounds
$page = min($page, $total_pages);
$offset = ($page - 1) * $per_page;

// Fetch filtered + paginated data
$data_query = mysqli_query($conn, "
    SELECT no_nota, total_harga, tgl_penjualan 
    FROM nota_penjualan 
    $where_sql 
    ORDER BY tgl_penjualan DESC, no_nota DESC 
    LIMIT $per_page OFFSET $offset
");

$transactions = [];
while ($row = mysqli_fetch_assoc($data_query)) {
    $transactions[] = $row;
}

// Get summary stats (total pendapatan for filtered results)
$sum_query = mysqli_query($conn, "SELECT SUM(total_harga) as total_pendapatan, COUNT(*) as total_transaksi FROM nota_penjualan $where_sql");
$summary = mysqli_fetch_assoc($sum_query);

echo json_encode([
    'success'       => true,
    'data'          => $transactions,
    'pagination'    => [
        'current_page'  => $page,
        'per_page'      => $per_page,
        'total_data'    => (int)$total_data,
        'total_pages'   => $total_pages
    ],
    'summary'       => [
        'total_pendapatan' => (int)($summary['total_pendapatan'] ?? 0),
        'total_transaksi'  => (int)($summary['total_transaksi'] ?? 0)
    ]
]);
?>
