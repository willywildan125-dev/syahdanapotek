<?php
require_once '../Backend/koneksi.php';
/** @var mysqli $conn */
// Fetch Total Pendapatan
$query_pendapatan = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM nota_penjualan");
$row_pendapatan = mysqli_fetch_assoc($query_pendapatan);
$total_pendapatan = $row_pendapatan['total'] ? $row_pendapatan['total'] : 0;

// Fetch Total Transaksi
$query_transaksi = mysqli_query($conn, "SELECT COUNT(*) as count FROM nota_penjualan");
$row_transaksi = mysqli_fetch_assoc($query_transaksi);
$total_transaksi = $row_transaksi['count'] ? $row_transaksi['count'] : 0;

// Rata-rata Penjualan
$rata_rata = $total_transaksi > 0 ? $total_pendapatan / $total_transaksi : 0;

// Fetch Recent Transactions
$query_recent = mysqli_query($conn, "SELECT * FROM nota_penjualan ORDER BY waktu_penjualan DESC, tgl_penjualan DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Dashboard</title>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">
    <?php include 'sidebar.php'; ?>
    
    <main class="ml-64 p-10 min-h-screen">
        <div class="mb-10 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Dashboard</h2>
                <p class="text-gray-500">Kelola dan pantau semua transaksi penjualan</p>
            </div>
            <a href="laporan.php" class="bg-white border border-brand-500 text-brand-600 hover:bg-brand-50 px-5 py-2.5 rounded-lg font-medium shadow-sm transition inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Data
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Card 1 -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center mb-4 text-brand-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></h3>
                    <p class="text-xs font-medium text-brand-600 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        +12.5% dari kemarin
                    </p>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center mb-4 text-brand-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2"><?php echo number_format($total_transaksi, 0, ',', '.'); ?></h3>
                    <p class="text-xs font-medium text-brand-600 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        +5.2% dari kemarin
                    </p>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center mb-4 text-brand-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p class="text-sm font-medium text-gray-600">Rata-rata Penjualan</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">Rp <?php echo number_format($rata_rata, 0, ',', '.'); ?></h3>
                    <p class="text-xs font-medium text-gray-500 flex items-center">
                        Per transaksi hari ini
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
                <div class="flex space-x-3">
                    <div class="flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-pointer hover:bg-gray-100 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        01 Nov 2023 - 30 Nov 2023
                    </div>
                    <div class="flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-pointer hover:bg-gray-100 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Semua Metode
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                <div class="relative">
                    <input type="text" placeholder="Cari ID Transaksi / Pelanggan" class="w-72 bg-gray-50 border border-gray-200 text-sm rounded-lg pl-10 pr-4 py-2 outline-none focus:border-brand-500 transition">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Tanggal & Waktu</th>
                            <th scope="col" class="px-6 py-4 font-semibold tracking-wider">ID Transaksi</th>
                            <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Pelanggan</th>
                            <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Metode</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold tracking-wider">Total Harga</th>
                            <th scope="col" class="px-6 py-4 text-center font-semibold tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-center font-semibold tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (mysqli_num_rows($query_recent) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($query_recent)): 
                                $statusClass = ($row['status'] == 'Selesai') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                                $datetime = !empty($row['waktu_penjualan']) ? date('d M Y, H:i', strtotime($row['waktu_penjualan'])) : date('d M Y, H:i', strtotime($row['tgl_penjualan']));
                            ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-700"><?php echo $datetime; ?></td>
                                <td class="px-6 py-4 font-medium text-brand-600">#<?php echo $row['no_nota']; ?></td>
                                <td class="px-6 py-4 text-gray-700"><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                                <td class="px-6 py-4 text-gray-700 flex items-center">
                                    <?php if ($row['metode_pembayaran'] == 'Tunai'): ?>
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <?php else: ?>
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($row['metode_pembayaran']); ?>
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full <?php echo $statusClass; ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-gray-400 hover:text-brand-600 transition">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada transaksi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-100 flex items-center justify-between bg-white text-sm">
                <span class="text-gray-500">Menampilkan <?php echo min($total_transaksi, 5); ?> dari <?php echo $total_transaksi; ?> transaksi</span>
                <div class="flex space-x-1">
                    <button class="px-3 py-1 border border-gray-200 rounded text-gray-400 bg-white cursor-not-allowed">&lsaquo;</button>
                    <button class="px-3 py-1 border border-brand-600 rounded text-white bg-brand-600 font-medium">1</button>
                    <button class="px-3 py-1 border border-gray-200 rounded text-gray-600 bg-white hover:bg-gray-50">2</button>
                    <button class="px-3 py-1 border border-gray-200 rounded text-gray-600 bg-white hover:bg-gray-50">3</button>
                    <span class="px-2 py-1 text-gray-400">...</span>
                    <button class="px-3 py-1 border border-gray-200 rounded text-gray-600 bg-white hover:bg-gray-50">&rsaquo;</button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>