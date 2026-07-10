<?php
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $kode_obat   = $_POST['kode_obat'];
    $nama_obat   = $_POST['nama_obat'];
    $kadaluwarsa = $_POST['kadaluwarsa'];
    $harga_jual  = $_POST['harga_jual'];
    $jumlah_stock= $_POST['jumlah_stock'];
    
    // PERBAIKAN: Jika form kategori kosong, jadikan NULL (tanpa tanda kutip) untuk SQL. 
    // Jika ada isinya, bungkus dengan tanda kutip tunggal.
    $id_kategori_input = trim($_POST['id_kategori']);
    $id_kategori_sql   = empty($id_kategori_input) ? "NULL" : "'" . mysqli_real_escape_string($conn, $id_kategori_input) . "'";
    
    $id_stock = "STK-" . $kode_obat . "-" . date('ymd');
    $tgl_masuk = date('Y-m-d');

    mysqli_begin_transaction($conn);

    try {
        // PERBAIKAN: Variabel $id_kategori_sql tidak dibungkus tanda kutip tunggal di sini
        $query_obat = "INSERT INTO obat (kode_obat, nama_obat, harga_jual, kadaluwarsa, id_kategori, no_rak) 
                       VALUES ('$kode_obat', '$nama_obat', '$harga_jual', '$kadaluwarsa', $id_kategori_sql, NULL)";
        
        mysqli_query($conn, $query_obat);

        // Jika user mengisi stok lebih dari 0
        if ($jumlah_stock > 0) {
            $query_stock = "INSERT INTO stock (id_stock, jumlah_stock, tgl_masuk, kode_obat) 
                            VALUES ('$id_stock', '$jumlah_stock', '$tgl_masuk', '$kode_obat')";
            mysqli_query($conn, $query_stock);
        }

        mysqli_commit($conn);
        echo "<script>
                alert('Produk berhasil ditambahkan!');
                window.location.href = '../Frontend/persediaan.php';
              </script>";

    } catch (Exception $e) {
        mysqli_rollback($conn);
        // Menampilkan pesan error asli dari MySQL agar mudah di-debug
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