<?php
require_once 'koneksi.php';
header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['items'])) {
    echo json_encode(['success' => false, 'message' => 'Data pesanan kosong']);
    exit;
}

$items = $data['items'];
$total_harga = $data['total_harga'];
$subtotal = $data['subtotal'];
$tax = $data['tax'];
$discount = $data['discount'];

// Generate No Nota (e.g. TRX-XXXX)
$no_nota = 'TRX-' . rand(1000, 9999);
$tgl_penjualan = date('Y-m-d');
$waktu_penjualan = date('Y-m-d H:i:s');

mysqli_begin_transaction($conn);

try {
    // 1. Insert to nota_penjualan
    // UBAH BARIS INI DI Backend/proses_transaksi.php:
$query_nota = "INSERT INTO nota_penjualan (no_nota, total_harga, tgl_penjualan) VALUES ('$no_nota', $total_harga, '$tgl_penjualan')";
    if (!mysqli_query($conn, $query_nota)) throw new Exception("Gagal menyimpan nota: " . mysqli_error($conn));

    // 2. Insert detail_penjualan and update stock
    foreach ($items as $item) {
        $kode_obat = $item['kode_obat'];
        $jumlah = $item['qty'];

        // Insert detail
        $query_detail = "INSERT INTO detail_penjualan (no_nota, kode_obat, jumlah_beli) VALUES ('$no_nota', '$kode_obat', $jumlah)";
        if (!mysqli_query($conn, $query_detail)) throw new Exception("Gagal menyimpan detail: " . mysqli_error($conn));

        // Deduct stock (simplified: just delete from stock table or we can just ignore for now if structure is complex, but wait, `stock` table has `id_stock`, `jumlah_stock`. We should deduct the oldest stock or create a minus entry. For simplicity, let's just insert a negative stock entry to represent deduction, or update an existing one).
        // Let's create a minus entry in stock table for deduction.
        $id_stock = 'OUT-' . rand(1000, 9999);
        $query_stock = "INSERT INTO stock (id_stock, jumlah_stock, tgl_masuk, kode_obat) VALUES ('$id_stock', -$jumlah, '$tgl_penjualan', '$kode_obat')";
        if (!mysqli_query($conn, $query_stock)) throw new Exception("Gagal memotong stok: " . mysqli_error($conn));
    }

    mysqli_commit($conn);
    echo json_encode(['success' => true, 'no_nota' => $no_nota]);

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
