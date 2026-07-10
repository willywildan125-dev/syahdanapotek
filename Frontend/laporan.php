<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Laporan Keuangan</title>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <?php include 'sidebar.php'; ?>
    <main class="ml-64 p-8 min-h-screen">
        
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-1">Laporan Laba Rugi</h2>
                <p class="text-gray-500">Tinjauan kinerja keuangan periode terpilih.</p>
            </div>
            <div class="flex items-center space-x-3">
                <select class="border border-gray-300 bg-white rounded-lg px-4 py-2.5 text-sm text-gray-700 outline-none shadow-sm font-medium">
                    <option>01 Okt 2023 - 31 Okt 2023</option>
                </select>
                <button class="border border-gray-300 px-5 py-2.5 bg-white rounded-lg font-medium shadow-sm hover:bg-gray-50 transition text-gray-700">Ekspor</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <p class="text-sm text-gray-500 font-bold mb-2">TOTAL PENDAPATAN</p>
                <h3 class="text-3xl font-bold text-green-600">Rp 125.400.000</h3>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <svg class="w-3 h-3 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    <span class="text-green-600 font-medium">8.2%</span> <span class="ml-1">vs bulan lalu</span>
                </p>
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <p class="text-sm text-gray-500 font-bold mb-2">TOTAL PENGELUARAN</p>
                <h3 class="text-3xl font-bold text-red-600">Rp 82.150.000</h3>
                <p class="text-xs text-gray-500 mt-2 flex items-center">
                    <svg class="w-3 h-3 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                    <span class="text-red-600 font-medium">2.1%</span> <span class="ml-1">vs bulan lalu</span>
                </p>
            </div>
            <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 shadow-sm">
                <p class="text-sm text-blue-700 font-bold mb-2">LABA BERSIH</p>
                <h3 class="text-3xl font-bold text-blue-800">Rp 43.250.000</h3>
                <p class="text-xs text-blue-600 mt-2 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    <span class="font-medium">12.5%</span> <span class="ml-1 opacity-80">vs bulan lalu</span>
                </p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-xl text-gray-900">Rincian Laba Rugi</h3>
                <span class="text-sm text-gray-500">Periode: 01 Okt - 31 Okt 2023</span>
            </div>
            <table class="w-full text-sm">
                <thead class="border-b-2 border-gray-800">
                    <tr>
                        <th class="py-3 text-left text-gray-600 font-bold tracking-wide">KETERANGAN</th>
                        <th class="py-3 text-right text-gray-600 font-bold tracking-wide">JUMLAH (RP)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="bg-gray-50"><td class="py-3 px-2 font-bold text-gray-800" colspan="2">Pendapatan</td></tr>
                    <tr><td class="py-3 pl-6 text-gray-600">Penjualan Obat</td><td class="py-3 px-2 text-right font-medium">95.000.000</td></tr>
                    <tr><td class="py-3 pl-6 text-gray-600">Penjualan Alkes</td><td class="py-3 px-2 text-right font-medium">25.400.000</td></tr>
                    <tr><td class="py-3 pl-6 text-gray-600">Jasa Layanan</td><td class="py-3 px-2 text-right font-medium">5.000.000</td></tr>
                    <tr class="font-bold text-gray-900 bg-gray-50/50"><td class="py-3 px-2">Total Pendapatan</td><td class="py-3 px-2 text-right">125.400.000</td></tr>

                    <tr class="bg-gray-50"><td class="py-3 px-2 font-bold text-gray-800" colspan="2">Harga Pokok Penjualan (HPP)</td></tr>
                    <tr><td class="py-3 pl-6 text-gray-600">HPP Obat & Alkes</td><td class="py-3 px-2 text-right font-medium text-red-600">(65.000.000)</td></tr>
                    <tr class="font-bold text-blue-700 bg-blue-50/30"><td class="py-3 px-2">Laba Kotor</td><td class="py-3 px-2 text-right">60.400.000</td></tr>

                    <tr class="bg-gray-50"><td class="py-3 px-2 font-bold text-gray-800" colspan="2">Beban Operasional</td></tr>
                    <tr><td class="py-3 pl-6 text-gray-600">Sewa Gedung</td><td class="py-3 px-2 text-right font-medium">5.000.000</td></tr>
                    <tr><td class="py-3 pl-6 text-gray-600">Listrik & Air</td><td class="py-3 px-2 text-right font-medium">1.500.000</td></tr>
                    <tr><td class="py-3 pl-6 text-gray-600">Gaji Karyawan</td><td class="py-3 px-2 text-right font-medium">9.000.000</td></tr>
                    <tr><td class="py-3 pl-6 text-gray-600">Pemasaran</td><td class="py-3 px-2 text-right font-medium">1.650.000</td></tr>
                    <tr class="font-bold text-red-600 bg-red-50/30"><td class="py-3 px-2">Total Beban Operasional</td><td class="py-3 px-2 text-right">(17.150.000)</td></tr>

                    <tr class="border-t-2 border-gray-800 mt-2">
                        <td class="py-5 px-2 font-bold text-lg text-gray-900">Laba Bersih</td>
                        <td class="py-5 px-2 text-right font-bold text-xl text-blue-700">Rp 43.250.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>