<?php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $kode_obat         = mysqli_real_escape_string($conn, $_POST['kode_obat'] ?? '');
    
    // Auto-generate SKU if not provided
    if (empty($kode_obat)) {
        $sku_query = mysqli_query($conn, "SELECT kode_obat FROM obat WHERE kode_obat LIKE 'OBT-%' ORDER BY kode_obat DESC LIMIT 1");
        $next_num = 1;
        if ($sku_query && mysqli_num_rows($sku_query) > 0) {
            $sku_row = mysqli_fetch_assoc($sku_query);
            $next_num = (int) substr($sku_row['kode_obat'], 4) + 1;
        }
        $count_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM obat");
        $count_r = mysqli_fetch_assoc($count_q);
        $next_num = max($next_num, (int)$count_r['total'] + 1);
        $kode_obat = 'OBT-' . str_pad($next_num, 4, '0', STR_PAD_LEFT);
    }
    $nama_obat         = mysqli_real_escape_string($conn, $_POST['nama_obat'] ?? '');
    $harga_jual        = (int)($_POST['harga_jual'] ?? 0);
    $id_kategori       = mysqli_real_escape_string($conn, $_POST['id_kategori'] ?? '');
    $no_rak            = mysqli_real_escape_string($conn, $_POST['no_rak'] ?? '');
    $satuan_terkecil   = mysqli_real_escape_string($conn, $_POST['satuan_terkecil'] ?? '');
    $harga_beli        = (int)($_POST['harga_beli'] ?? 0);
    $kadaluwarsa       = mysqli_real_escape_string($conn, $_POST['kadaluwarsa'] ?? '');
    $stok_awal         = (int)($_POST['STOK'] ?? $_POST['stok_awal'] ?? 0);
    
    $id_kategori_sql = empty($id_kategori) ? "NULL" : "'" . $id_kategori . "'";
    $no_rak_sql      = empty($no_rak) ? "NULL" : "'" . $no_rak . "'";
    
    $id_stock = "STK-" . $kode_obat . "-" . date('ymd');
    $tgl_masuk = date('Y-m-d');

    mysqli_begin_transaction($conn);

    try {
        $query_obat = "INSERT INTO obat (kode_obat, nama_obat, harga_jual, kadaluwarsa, satuan, id_kategori, no_rak) 
                       VALUES ('$kode_obat', '$nama_obat', '$harga_jual', '$kadaluwarsa', '$satuan_terkecil', $id_kategori_sql, $no_rak_sql)";
        
        mysqli_query($conn, $query_obat);

        if ($stok_awal > 0) {
            $query_stock = "INSERT INTO stock (id_stock, jumlah_stock, tgl_masuk, harga_awal, kode_obat) 
                            VALUES ('$id_stock', '$stok_awal', '$tgl_masuk', '$harga_beli', '$kode_obat')";
            mysqli_query($conn, $query_stock);
        }

        mysqli_commit($conn);
        header("Location: ../Frontend/persediaan.php?msg=success&text=" . urlencode('Produk berhasil ditambahkan!'));
        exit();

    } catch (Exception $e) {
        mysqli_rollback($conn);
        $error_msg = $e->getMessage();
        header("Location: ../Frontend/tambah-produk.php?msg=error&text=" . urlencode('Gagal menambahkan produk! ' . $error_msg));
        exit();
    }
} else {
    header("Location: ../Frontend/tambah-produk.php");
    exit();
}
?>