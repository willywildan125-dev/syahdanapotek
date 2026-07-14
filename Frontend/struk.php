<?php
require_once '../Backend/koneksi.php';

if (!isset($_GET['no_nota'])) {
    die("Nomor nota tidak ditemukan.");
}

$no_nota = mysqli_real_escape_string($conn, $_GET['no_nota']);

// Ambil data transaksi utama
$query_nota = mysqli_query($conn, "SELECT * FROM nota_penjualan WHERE no_nota = '$no_nota'");
$nota = mysqli_fetch_assoc($query_nota);

if (!$nota) {
    die("Transaksi tidak ditemukan di database.");
}

// Ambil data produk yang dibeli beserta harga dari tabel obat
$query_detail = mysqli_query($conn, "
    SELECT 
        d.jumlah_beli as jumlah, 
        o.nama_obat, 
        o.harga_jual as harga,
        (d.jumlah_beli * o.harga_jual) as subtotal
    FROM detail_penjualan d 
    JOIN obat o ON d.kode_obat = o.kode_obat 
    WHERE d.no_nota = '$no_nota'
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - <?php echo htmlspecialchars($nota['no_nota']); ?></title>
    <style>
        body { 
            font-family: 'Courier New', Courier, monospace; 
            font-size: 14px; 
            background: #e5e7eb; 
            margin: 0;
            padding: 40px 20px;
        }
        .struk-container { 
            width: 300px; 
            background: #fff; 
            margin: 0 auto; 
            padding: 20px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
            color: #000;
        }
        .header { text-align: center; margin-bottom: 15px; }
        .header h2 { margin: 0; font-size: 20px; font-weight: bold; }
        .header p { margin: 3px 0; font-size: 12px; }
        .divider { border-bottom: 1px dashed #000; margin: 15px 0; }
        .item-name { width: 100%; margin-bottom: 5px; font-weight: bold; }
        .item-details { display: flex; justify-content: space-between; font-size: 13px; margin-bottom: 10px;}
        .totals { margin-top: 15px; }
        .total-row { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .grand-total { font-weight: bold; font-size: 16px; border-top: 1px dashed #000; padding-top: 10px; margin-top: 10px; }
        .footer { text-align: center; margin-top: 25px; font-size: 12px; font-weight: bold; }
        
        @media print {
            @page { margin: 0; }
            body { background: #fff; padding: 10px; }
            .struk-container { width: 100%; box-shadow: none; margin: 0; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="struk-container">
        <div class="header">
            <p style="font-weight: bold; font-size: 14px; margin-bottom: 10px;">Struk - <?php echo $nota['no_nota']; ?></p>
            <h2>APOTEK SYAHDAN</h2>
            <p>Jl. Wangisagara, Neglasari, Kec. Majalaya</p>
        </div>
        
        <div class="divider"></div>
        
        <div style="font-size: 12px; margin-bottom: 10px;">
            <table style="width: 100%;">
                <tr><td width="35%">No</td><td>: <?php echo $nota['no_nota']; ?></td></tr>
                <tr><td>Tanggal</td><td>: <?php echo date('d M Y', strtotime($nota['tgl_penjualan'])); ?></td></tr>
            </table>
        </div>

        <div class="divider"></div>

        <?php 
        $ada_barang = false;
        while ($item = mysqli_fetch_assoc($query_detail)): 
            $ada_barang = true;
        ?>
            <div class="item-name"><?php echo htmlspecialchars($item['nama_obat']); ?></div>
            <div class="item-details">
                <span><?php echo $item['jumlah']; ?> x <?php echo number_format($item['harga'], 0, ',', '.'); ?></span>
                <span><?php echo number_format($item['subtotal'], 0, ',', '.'); ?></span>
            </div>
        <?php endwhile; ?>

        <?php if(!$ada_barang): ?>
            <div style="text-align:center; color:red; font-size:12px;">Detail barang tidak ditemukan!</div>
        <?php endif; ?>

        <div class="totals">
            <div class="total-row grand-total">
                <span>TOTAL</span>
                <span>Rp <?php echo number_format($nota['total_harga'], 0, ',', '.'); ?></span>
            </div>
        </div>

        <div class="divider"></div>

        <div class="footer">
            <p>Terima Kasih</p>
            <p>Semoga Lekas Sembuh</p>
        </div>

        <div class="no-print" style="margin-top: 30px;">
            <button onclick="window.print()" style="padding: 12px; background: #10b981; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; margin-bottom: 10px;">
                Cetak Struk Sekarang
            </button>
            <a href="kasir.php" style="display: block; text-align:center; padding: 12px; background: #f3f4f6; color: #374151; text-decoration: none; border-radius: 6px; font-weight: bold;">
                Kembali ke Kasir
            </a>
        </div>
    </div>

    <!-- Script auto-print SAYA MATIKAN DULU agar kamu bisa melihat bentuk struknya -->
    <!-- Jika nanti mau dihidupkan lagi, hapus tanda komentar di bawah ini -->
    <!-- <script> window.onload = function() { window.print(); } </script> -->
</body>
</html>