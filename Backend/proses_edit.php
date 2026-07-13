<?php
require_once 'koneksi.php';
/** @var mysqli $conn */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $kode_obat       = mysqli_real_escape_string($conn, $_POST['kode_obat'] ?? '');
    $nama_obat       = mysqli_real_escape_string($conn, $_POST['nama_obat'] ?? '');
    $harga_jual      = (int)($_POST['harga_jual'] ?? 0);
    $id_kategori     = mysqli_real_escape_string($conn, $_POST['id_kategori'] ?? '');
    $no_rak          = mysqli_real_escape_string($conn, $_POST['no_rak'] ?? '');
    $satuan          = mysqli_real_escape_string($conn, $_POST['satuan'] ?? '');
    $kadaluwarsa     = mysqli_real_escape_string($conn, $_POST['kadaluwarsa'] ?? '');
    $harga_beli      = (int)($_POST['harga_beli'] ?? 0);
    $jumlah_stock    = (int)($_POST['jumlah_stock'] ?? 0);

    if (empty($kode_obat) || empty($nama_obat)) {
        header("Location: ../Frontend/persediaan.php?msg=error&text=" . urlencode('Kode obat dan nama obat harus diisi!'));
        exit();
    }

    $id_kategori_sql = empty($id_kategori) ? "NULL" : "'" . $id_kategori . "'";
    $no_rak_sql      = empty($no_rak) ? "NULL" : "'" . $no_rak . "'";

    mysqli_begin_transaction($conn);

    try {
        // Update obat table
        $query_obat = "UPDATE obat SET 
            nama_obat = '$nama_obat',
            harga_jual = $harga_jual,
            kadaluwarsa = '$kadaluwarsa',
            satuan = '$satuan',
            id_kategori = $id_kategori_sql,
            no_rak = $no_rak_sql
            WHERE kode_obat = '$kode_obat'";
        
        $result = mysqli_query($conn, $query_obat);
        if (!$result) {
            throw new Exception(mysqli_error($conn));
        }

        // Update stock: check if stock entry exists
        $stock_check = mysqli_query($conn, "SELECT id_stock FROM stock WHERE kode_obat = '$kode_obat' LIMIT 1");
        
        if ($stock_check && mysqli_num_rows($stock_check) > 0) {
            $stock_row = mysqli_fetch_assoc($stock_check);
            $query_stock = "UPDATE stock SET 
                jumlah_stock = $jumlah_stock,
                harga_awal = $harga_beli
                WHERE id_stock = '" . mysqli_real_escape_string($conn, $stock_row['id_stock']) . "'";
            $result_stock = mysqli_query($conn, $query_stock);
            if (!$result_stock) {
                throw new Exception(mysqli_error($conn));
            }
        } elseif ($jumlah_stock > 0 || $harga_beli > 0) {
            // Create new stock entry
            $id_stock = "STK-" . $kode_obat . "-" . date('ymd');
            $tgl_masuk = date('Y-m-d');
            $query_stock = "INSERT INTO stock (id_stock, jumlah_stock, tgl_masuk, harga_awal, kode_obat) 
                            VALUES ('$id_stock', $jumlah_stock, '$tgl_masuk', $harga_beli, '$kode_obat')";
            $result_stock = mysqli_query($conn, $query_stock);
            if (!$result_stock) {
                throw new Exception(mysqli_error($conn));
            }
        }

        mysqli_commit($conn);
        header("Location: ../Frontend/persediaan.php?msg=success&text=" . urlencode('Produk berhasil diperbarui!'));
        exit();

    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("Location: ../Frontend/persediaan.php?msg=error&text=" . urlencode('Gagal memperbarui produk! ' . $e->getMessage()));
        exit();
    }
} else {
    header("Location: ../Frontend/persediaan.php");
    exit();
}
?>
