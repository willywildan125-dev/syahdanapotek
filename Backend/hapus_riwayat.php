<?php
require_once 'koneksi.php';

// Hapus semua data dari nota_penjualan
// Karena tabel detail_penjualan memiliki relasi ON DELETE CASCADE,
// maka otomatis detail transaksinya juga akan terhapus.
$query = mysqli_query($conn, "DELETE FROM nota_penjualan");

if ($query) {
    echo "<script>
        alert('Semua riwayat penjualan berhasil dihapus!');
        window.location.href = '../Frontend/laporan.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus riwayat penjualan: " . mysqli_error($conn) . "');
        window.location.href = '../Frontend/laporan.php';
    </script>";
}
?>
