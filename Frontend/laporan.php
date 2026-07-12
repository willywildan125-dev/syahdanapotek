<?php
require_once '../Backend/koneksi.php';

// Ambil data laporan
$query_laporan = mysqli_query($conn, "
    SELECT 
        DATE(tgl_penjualan) as tanggal,
        COUNT(no_nota) as total_transaksi,
        SUM(total_harga) as pendapatan
    FROM nota_penjualan 
    GROUP BY DATE(tgl_penjualan)
    ORDER BY tanggal DESC
");

$laporan_data = [];
$total_pendapatan = 0;
while ($row = mysqli_fetch_assoc($query_laporan)) {
    $laporan_data[] = $row;
    $total_pendapatan += $row['pendapatan'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Laporan Keuangan</title>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">
    <?php include 'sidebar.php'; ?>
    
    <main class="ml-64 p-10 min-h-screen">
        <div class="mb-10 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Laporan Keuangan</h2>
                <p class="text-gray-500">Ringkasan transaksi dan pendapatan harian</p>
            </div>
            <button class="bg-brand-50 hover:bg-brand-100 text-brand-700 px-5 py-2.5 rounded-lg font-medium shadow-sm transition border border-brand-200 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export PDF
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                    <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></h3>
                    <p class="text-xs font-medium text-brand-600">Sepanjang Waktu</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex gap-4 items-center bg-white">
                <h3 class="font-bold text-lg text-gray-900">Rekap Pendapatan Harian</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="text-[11px] text-gray-500 font-bold uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-4 tracking-wider text-center">Total Transaksi</th>
                            <th scope="col" class="px-6 py-4 tracking-wider text-right">Pendapatan (Total Harga)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($laporan_data as $row): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <?php echo date('d M Y', strtotime($row['tanggal'])); ?>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-700">
                                <?php echo $row['total_transaksi']; ?>
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-brand-700">
                                Rp <?php echo number_format($row['pendapatan'], 0, ',', '.'); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($laporan_data)): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada data transaksi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>