<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Dashboard</title>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <?php include 'sidebar.php'; ?>
    
    <main class="ml-64 p-8 min-h-screen">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
                <p class="text-gray-500">Kelola dan pantau semua transaksi penjualan</p>
            </div>
            <a href="tambah-produk.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm transition inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Produk
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <p class="text-sm text-gray-500 mb-1 font-medium">Total Pendapatan</p>
                <h3 class="text-2xl font-bold text-gray-900">Rp 24.500.000</h3>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <p class="text-sm text-gray-500 mb-1 font-medium">Total Transaksi</p>
                <h3 class="text-2xl font-bold text-gray-900">142</h3>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <p class="text-sm text-gray-500 mb-1 font-medium">Rata-rata Penjualan</p>
                <h3 class="text-2xl font-bold text-gray-900">Rp 172.535</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800 text-lg">Riwayat Transaksi Terakhir</h3>
            </div>
            <div class="overflow-x-auto p-5 text-center text-gray-500">
                Data transaksi dinamis belum dihubungkan.
            </div>
        </div>
    </main>
</body>
</html>