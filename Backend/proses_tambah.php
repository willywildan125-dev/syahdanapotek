<?php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $kode_obat         = mysqli_real_escape_string($conn, $_POST['kode_obat'] ?? '');
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
        echo "<script>
                alert('Produk berhasil ditambahkan!');
                window.location.href = '../Frontend/persediaan.php';
              </script>";

    } catch (Exception $e) {
        mysqli_rollback($conn);
        $error_msg = $e->getMessage();
        echo "<script>
                alert('Gagal menambahkan produk! Error: " . addslashes($error_msg) . "');
                window.history.back();
              </script>";
    }
} else {
    header("Location: ../Frontend/tambah-produk.php");
    exit();
}
?>