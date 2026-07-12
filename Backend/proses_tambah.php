<?php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $kode_obat         = $_POST['kode_obat'];
    $nama_obat         = $_POST['nama_obat'];
    $harga_jual        = $_POST['harga_jual'];
    $id_kategori       = $_POST['id_kategori'];
    $satuan_terkecil   = $_POST['satuan_terkecil'];
    $deskripsi_kemasan = $_POST['deskripsi_kemasan'];
    $stok_awal         = $_POST['stok_awal'];
    $stok_minimum      = $_POST['stok_minimum'];
    $harga_beli        = $_POST['harga_beli'];
    $kadaluwarsa = mysqli_real_escape_string($conn, $_POST['kadaluwarsa']);
    
    $id_kategori_sql = empty($id_kategori) ? "NULL" : "'" . mysqli_real_escape_string($conn, $id_kategori) . "'";
    
    $id_stock = "STK-" . $kode_obat . "-" . date('ymd');
    $tgl_masuk = date('Y-m-d');

    mysqli_begin_transaction($conn);

    try {
        $query_obat = "INSERT INTO obat (kode_obat, nama_obat, harga_jual, kadaluwarsa, id_kategori, satuan_terkecil, deskripsi_kemasan, stok_minimum, harga_beli) 
                       VALUES ('$kode_obat', '$nama_obat', '$harga_jual', '$kadaluwarsa', $id_kategori_sql, '$satuan_terkecil', '$deskripsi_kemasan', '$stok_minimum', '$harga_beli')";
        
        mysqli_query($conn, $query_obat);

        if ($stok_awal > 0) {
            $query_stock = "INSERT INTO stock (id_stock, jumlah_stock, tgl_masuk, kode_obat) 
                            VALUES ('$id_stock', '$stok_awal', '$tgl_masuk', '$kode_obat')";
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