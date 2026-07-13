<?php
// MENGAKTIFKAN DETEKSI ERROR KETAT: Jika ada salah 1 huruf di database, langsung ketahuan!
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once 'koneksi.php';
header('Content-Type: application/json');

try {
    // Menerima data JSON dari JavaScript Kasir
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data || empty($data['items'])) {
        throw new Exception('Keranjang kosong!');
    }

    // Generate Nomor Nota
    $no_nota = 'TRX-' . date('dmyHis'); 
    $total_harga = $data['total_harga'];
    $tgl_penjualan = date('Y-m-d'); // Sesuai dengan tipe data DATE di database

    // Mulai transaksi database
    mysqli_begin_transaction($conn);

    // 1. Simpan ke tabel nota_penjualan
    $sql_nota = "INSERT INTO nota_penjualan (no_nota, total_harga, tgl_penjualan) 
                 VALUES ('$no_nota', '$total_harga', '$tgl_penjualan')";
    mysqli_query($conn, $sql_nota);

    // 2. Simpan setiap barang ke tabel detail_penjualan dan kurangi stok
    foreach ($data['items'] as $item) {
        $kode_obat = mysqli_real_escape_string($conn, $item['kode_obat']);
        $qty = (int)$item['qty'];

        // Cek apakah data barang terkirim dengan benar
        if (empty($kode_obat)) {
            throw new Exception("Kode obat kosong dari kasir!");
        }

        // Insert Detail ke tabel detail_penjualan (Sesuai dengan database yang kamu kirim: no_nota, kode_obat, jumlah_beli)
        $sql_detail = "INSERT INTO detail_penjualan (no_nota, kode_obat, jumlah_beli) 
                       VALUES ('$no_nota', '$kode_obat', '$qty')";
        mysqli_query($conn, $sql_detail);

        // Update/Kurangi Stok Obat
        $sql_stok = "UPDATE stock SET jumlah_stock = jumlah_stock - $qty WHERE kode_obat = '$kode_obat'";
        mysqli_query($conn, $sql_stok);
    }

    // Jika semua berhasil tanpa error sedikitpun, simpan permanen
    mysqli_commit($conn);
    
    // Beri respon sukses ke Frontend
    echo json_encode(['success' => true, 'no_nota' => $no_nota]);

} catch (Exception $e) {
    // Jika ada error, batalkan semua perubahan (termasuk nota_penjualan)
    if (isset($conn)) {
        mysqli_rollback($conn);
    }
    // Kirim pesan error yang SPESIFIK ke layar kasir
    echo json_encode(['success' => false, 'message' => 'Detail Error DB: ' . $e->getMessage()]);
}
?>