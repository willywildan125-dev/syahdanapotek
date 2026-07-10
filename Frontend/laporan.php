<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Laporan Keuangan</title>
    <link href="./dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <?php include 'sidebar.php'; ?>
    <main class="ml-64 p-8 min-h-screen">
        
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Laporan Laba Rugi</h2> <!-- -->
                <p class="text-gray-500">Tinjauan kinerja keuangan periode terpilih.</p> <!-- -->
            </div>
            <button class="border px-4 py-2 bg-white rounded-lg font-medium shadow-sm">Ekspor</button> <!-- -->
        </div>

        <!-- Kartu Indikator Keuangan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-500 font-medium mb-1">TOTAL PENDAPATAN</p> <!-- -->
                <h3 class="text-2xl font-bold text-green-600">Rp 125.400.000</h3> <!-- -->
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-500 font-medium mb-1">TOTAL PENGELUARAN</p> <!-- -->
                <h3 class="text-2xl font-bold text-red-600">Rp 82.150.000</h3> <!-- -->
            </div>
            <div class="bg-white p-6 rounded-xl border border-gray-200 bg-blue-50">
                <p class="text-sm text-blue-700 font-medium mb-1">LABA BERSIH</p> <!-- -->
                <h3 class="text-2xl font-bold text-blue-800">Rp 43.250.000</h3> <!-- -->
            </div>
        </div>

        <!-- Tabel Rincian -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-bold text-lg mb-4">Rincian Laba Rugi</h3> <!-- -->
            <table class="w-full text-sm">
                <thead class="border-b-2 border-gray-300">
                    <tr>
                        <th class="py-2 text-left text-gray-600">KETERANGAN</th> <!-- -->
                        <th class="py-2 text-right text-gray-600">JUMLAH (RP)</th> <!-- -->
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- Pendapatan -->
                    <tr class="bg-gray-50"><td class="py-2 font-semibold" colspan="2">Pendapatan</td></tr> <!-- -->
                    <tr><td class="py-2 pl-4">Penjualan Obat</td><td class="py-2 text-right">95.000.000</td></tr> <!-- -->
                    <tr><td class="py-2 pl-4">Penjualan Alkes</td><td class="py-2 text-right">25.400.000</td></tr> <!-- -->
                    <tr><td class="py-2 pl-4">Jasa Layanan</td><td class="py-2 text-right">5.000.000</td></tr> <!-- -->
                    <tr class="font-bold"><td class="py-2">Total Pendapatan</td><td class="py-2 text-right">125.400.000</td></tr> <!-- -->

                    <!-- HPP & Laba Kotor -->
                    <tr class="bg-gray-50"><td class="py-2 font-semibold" colspan="2">Harga Pokok Penjualan (HPP)</td></tr> <!-- -->
                    <tr><td class="py-2 pl-4">HPP Obat & Alkes</td><td class="py-2 text-right text-red-600">(65.000.000)</td></tr> <!-- -->
                    <tr class="font-bold text-blue-700"><td class="py-2">Laba Kotor</td><td class="py-2 text-right">60.400.000</td></tr> <!-- -->

                    <!-- Beban Operasional -->
                    <tr class="bg-gray-50"><td class="py-2 font-semibold" colspan="2">Beban Operasional</td></tr> <!-- -->
                    <tr><td class="py-2 pl-4">Sewa Gedung</td><td class="py-2 text-right">5.000.000</td></tr> <!-- -->
                    <tr><td class="py-2 pl-4">Listrik & Air</td><td class="py-2 text-right">1.500.000</td></tr> <!-- -->
                    <tr><td class="py-2 pl-4">Gaji Karyawan</td><td class="py-2 text-right">9.000.000</td></tr> <!-- -->
                    <tr><td class="py-2 pl-4">Pemasaran</td><td class="py-2 text-right">1.650.000</td></tr> <!-- -->
                    <tr class="font-bold text-red-600"><td class="py-2">Total Beban Operasional</td><td class="py-2 text-right">(17.150.000)</td></tr> <!-- -->

                    <!-- Hasil Akhir -->
                    <tr class="font-bold text-lg border-t-2 border-gray-300 mt-2">
                        <td class="py-4">Laba Bersih</td> <!-- -->
                        <td class="py-4 text-right text-blue-700">Rp 43.250.000</td> <!-- -->
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>