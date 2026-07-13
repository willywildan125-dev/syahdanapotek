<?php
require_once 'koneksi.php';
/** @var mysqli $conn */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $kode_obat = mysqli_real_escape_string($conn, $_POST['kode_obat'] ?? '');

    if (empty($kode_obat)) {
        header("Location: ../Frontend/persediaan.php?msg=error&text=" . urlencode('Kode obat tidak valid!'));
        exit();
    }

    mysqli_begin_transaction($conn);

    try {
        // Delete detail_penjualan entries referencing this obat
        mysqli_query($conn, "DELETE FROM detail_penjualan WHERE kode_obat = '$kode_obat'");

        // Delete stock entries (CASCADE should handle this, but explicit for safety)
        $result_stock = mysqli_query($conn, "DELETE FROM stock WHERE kode_obat = '$kode_obat'");
        if (!$result_stock) {
            throw new Exception(mysqli_error($conn));
        }

        // Delete the obat record
        $result_obat = mysqli_query($conn, "DELETE FROM obat WHERE kode_obat = '$kode_obat'");
        if (!$result_obat) {
            throw new Exception(mysqli_error($conn));
        }

        if (mysqli_affected_rows($conn) === 0) {
            throw new Exception('Produk tidak ditemukan.');
        }

        mysqli_commit($conn);
        header("Location: ../Frontend/persediaan.php?msg=success&text=" . urlencode('Produk berhasil dihapus!'));
        exit();

    } catch (Exception $e) {
        mysqli_rollback($conn);
        header("Location: ../Frontend/persediaan.php?msg=error&text=" . urlencode('Gagal menghapus produk! ' . $e->getMessage()));
        exit();
    }
} else {
    header("Location: ../Frontend/persediaan.php");
    exit();
}
?>
