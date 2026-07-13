<?php
require_once '../Backend/koneksi.php';

$no_nota = isset($_GET['no_nota']) ? $_GET['no_nota'] : null;

if (!$no_nota) {
    echo "No Nota tidak ditemukan.";
    exit;
}

$query_nota = mysqli_query($conn, "SELECT * FROM nota_penjualan WHERE no_nota = '$no_nota'");
$nota = mysqli_fetch_assoc($query_nota);

if (!$nota) {
    echo "Transaksi tidak ditemukan.";
    exit;
}

$query_detail = mysqli_query($conn, "
    SELECT d.*, o.nama_obat, o.harga_jual 
    FROM detail_penjualan d 
    JOIN obat o ON d.kode_obat = o.kode_obat 
    WHERE d.no_nota = '$no_nota'
");

$subtotal = 0;
$items = [];
while ($row = mysqli_fetch_assoc($query_detail)) {
    $items[] = $row;
    $subtotal += $row['harga_jual'] * $row['jumlah_beli'];
}

$tax = $subtotal * 0.11;
$total = $nota['total_harga'];
$tunai = $total + 27900; // Dummy calculation to simulate change
$kembali = $tunai > $total ? $tunai - $total : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Receipt</title>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">
    <?php include 'sidebar.php'; ?>
    
    <main class="ml-64 p-10 min-h-screen flex items-start justify-center">
        <div class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Left Side: Success Message -->
            <div>
                <div class="bg-brand-50 border border-brand-200 rounded-3xl p-10 text-center mb-6">
                    <div class="w-20 h-20 bg-brand-700 text-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-brand-500/30">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="text-3xl font-bold text-brand-800 mb-3">Pembayaran Berhasil!</h2>
                    <p class="text-brand-700 opacity-80">Transaksi #<?php echo $no_nota; ?> telah selesai diproses.</p>
                </div>
                
                <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
                    <h3 class="font-bold text-lg text-gray-900 mb-5">Tindakan Lanjutan</h3>
                    <button class="w-full flex items-center justify-center bg-brand-700 hover:bg-brand-800 text-white py-3.5 rounded-xl font-semibold mb-4 transition shadow-md shadow-brand-500/20">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print Receipt
                    </button>
                    <a href="kasir.php" class="w-full flex items-center justify-center bg-brand-400 hover:bg-brand-500 text-white py-3.5 rounded-xl font-semibold transition shadow-md shadow-brand-400/20">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Transaksi Baru
                    </a>
                </div>
            </div>

            <!-- Right Side: Receipt Detail -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-10">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 uppercase tracking-widest mb-1">Apotek Syahdan</h2>
                    <p class="text-sm text-gray-500">Jl. Syahdan No. 01, Jakarta</p>
                    <p class="text-sm text-gray-500">Tel: (021) 555-0192</p>
                </div>
                
                <div class="border-t border-b border-dashed border-gray-300 py-4 mb-6 flex justify-between text-sm text-gray-600">
                    <div>
                        <p class="font-medium text-gray-900 mb-1">No: #<?php echo $no_nota; ?></p>
                        <p><?php echo date('H:i', strtotime($nota['waktu_penjualan'])); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900"><?php echo date('d M Y', strtotime($nota['waktu_penjualan'])); ?></p>
                    </div>
                </div>

                <div class="space-y-4 mb-6">
                    <?php foreach ($items as $item): ?>
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-sm text-gray-900"><?php echo htmlspecialchars($item['nama_obat']); ?></p>
                            <p class="text-xs text-gray-500"><?php echo $item['jumlah_beli']; ?> x Rp <?php echo number_format($item['harga_jual'], 0, ',', '.'); ?></p>
                        </div>
                        <p class="font-bold text-sm text-gray-900">Rp <?php echo number_format($item['harga_jual'] * $item['jumlah_beli'], 0, ',', '.'); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="border-t border-gray-200 pt-4 space-y-2 text-sm text-gray-600 mb-6">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-medium text-gray-900">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Discount</span>
                        <span class="font-medium text-gray-900">- Rp 0</span>
                    </div>
                </div>

                <div class="flex justify-between items-center text-lg font-bold text-gray-900 mb-6">
                    <span>TOTAL</span>
                    <span>Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                </div>

                <div class="space-y-2 text-sm text-gray-600 mb-10">
                    <div class="flex justify-between">
                        <span>Tunai</span>
                        <span class="font-medium text-gray-900">Rp <?php echo number_format($tunai, 0, ',', '.'); ?></span>
                    </div>
                    <div class="flex justify-between font-bold text-gray-900">
                        <span>Kembali</span>
                        <span>Rp <?php echo number_format($kembali, 0, ',', '.'); ?></span>
                    </div>
                </div>

                <div class="text-center text-xs text-gray-500">
                    <p class="mb-1">Semoga lekas sembuh!</p>
                    <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
                </div>
            </div>

        </div>
    </main>
</body>
</html>