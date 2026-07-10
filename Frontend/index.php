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
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
            <p class="text-gray-500">Kelola dan pantau semua transaksi penjualan</p>  
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                <h3 class="text-2xl font-bold">Rp 24.500.000</h3>  
                <p class="text-xs text-green-600 mt-2 font-medium">+12.5% dari kemarin</p>  
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Total Transaksi</p>
                <h3 class="text-2xl font-bold">142</h3>  
                <p class="text-xs text-green-600 mt-2 font-medium">+5.2% dari kemarin</p>  
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Rata-rata Penjualan</p>  
                <h3 class="text-2xl font-bold">Rp 172.535</h3>  
                <p class="text-xs text-gray-500 mt-2">Per transaksi hari ini</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="p-5 border-b flex justify-between">
                <div class="flex space-x-3">
                    <select class="border rounded px-3 py-1 text-sm"><option>01 Nov 2023 - 30 Nov 2023</option></select>  
                    <select class="border rounded px-3 py-1 text-sm"><option>Semua Metode</option></select>  
                </div>
                <input type="text" placeholder="Cari ID Transaksi / Pelanggan" class="border rounded px-3 py-1 text-sm w-64">
            </div>
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 text-xs">
                    <tr>
                        <th class="px-6 py-4">TANGGAL & WAKTU</th>  
                        <th class="px-6 py-4">ID TRANSAKSI</th>  
                        <th class="px-6 py-4">PELANGGAN</th>  
                        <th class="px-6 py-4">METODE</th>  
                        <th class="px-6 py-4">TOTAL HARGA</th>  
                        <th class="px-6 py-4">STATUS</th>  
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr>
                        <td class="px-6 py-4">24 Nov 2023, 14:30</td>  
                        <td class="px-6 py-4 font-medium text-blue-600">#TRX-8921-B</td>  
                        <td class="px-6 py-4">Umum (Bpk. Budi)</td>  
                        <td class="px-6 py-4">Tunai</td>  
                        <td class="px-6 py-4 font-medium">Rp 125.000</td>  
                        <td class="px-6 py-4"><span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">Selesai</span></td>  
                    </tr>
                    <tr>
                        <td class="px-6 py-4">24 Nov 2023, 13:15</td>  
                        <td class="px-6 py-4 font-medium text-blue-600">#TRX-8920-A</td>  
                        <td class="px-6 py-4">Ibu Siti (Member)</td>  
                        <td class="px-6 py-4">QRIS</td>  
                        <td class="px-6 py-4 font-medium">Rp 450.000</td>  
                        <td class="px-6 py-4"><span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs">Selesai</span></td>  
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>