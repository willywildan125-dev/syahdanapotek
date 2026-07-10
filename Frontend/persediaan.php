<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Persediaan Barang</title>
    <link href="./dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <?php include 'sidebar.php'; ?>
    <main class="ml-64 p-8 min-h-screen">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Persediaan Barang</h2> <!-- -->
                <p class="text-gray-500">Kelola dan pantau stok apotek Anda</p> <!-- -->
            </div>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium">+ Tambah Produk</button> <!-- -->
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white p-5 rounded-xl border">
                <p class="text-xs text-gray-500">Total Item Stok</p> <!-- -->
                <h3 class="text-2xl font-bold">1,245</h3> <!-- -->
            </div>
            <div class="bg-white p-5 rounded-xl border">
                <p class="text-xs text-gray-500">Stok Menipis</p> <!-- -->
                <h3 class="text-2xl font-bold text-yellow-500">42</h3> <!-- -->
            </div>
            <div class="bg-white p-5 rounded-xl border">
                <p class="text-xs text-gray-500">Stok Habis</p> <!-- -->
                <h3 class="text-2xl font-bold text-red-500">8</h3> <!-- -->
            </div>
            <div class="bg-white p-5 rounded-xl border">
                <p class="text-xs text-gray-500">Total Nilai Persediaan</p> <!-- -->
                <h3 class="text-xl font-bold">Rp 124.500.000</h3> <!-- -->
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 text-xs">
                    <tr>
                        <th class="px-6 py-4">NAMA PRODUK & SKU</th> <!-- -->
                        <th class="px-6 py-4">KATEGORI</th> <!-- -->
                        <th class="px-6 py-4">STOK FISIK</th> <!-- -->
                        <th class="px-6 py-4">UNIT TERKECIL</th> <!-- -->
                        <th class="px-6 py-4">HPP (RATA-RATA)</th> <!-- -->
                        <th class="px-6 py-4">HARGA JUAL</th> <!-- -->
                        <th class="px-6 py-4">TOTAL ASET</th> <!-- -->
                        <th class="px-6 py-4">STATUS</th> <!-- -->
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr>
                        <td class="px-6 py-4">
                            <p class="font-bold">Paracetamol 500mg</p> <!-- -->
                            <p class="text-xs text-gray-500">SKU: MED-001</p> <!-- -->
                        </td>
                        <td class="px-6 py-4">Analgesik</td> <!-- -->
                        <td class="px-6 py-4">250 Strip</td> <!-- -->
                        <td class="px-6 py-4">Tablet</td> <!-- -->
                        <td class="px-6 py-4">Rp 2.500</td> <!-- -->
                        <td class="px-6 py-4">Rp 3.500</td> <!-- -->
                        <td class="px-6 py-4 font-bold">Rp 625.000</td> <!-- -->
                        <td class="px-6 py-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Tersedia</span></td> <!-- -->
                    </tr>
                    <tr>
                        <td class="px-6 py-4">
                            <p class="font-bold">Amoxicillin 500mg</p> <!-- -->
                            <p class="text-xs text-gray-500">SKU: MED-042</p> <!-- -->
                        </td>
                        <td class="px-6 py-4">Antibiotik</td> <!-- -->
                        <td class="px-6 py-4 text-yellow-600 font-bold">12 Botol</td> <!-- -->
                        <td class="px-6 py-4">Kapsul</td> <!-- -->
                        <td class="px-6 py-4">Rp 15.000</td> <!-- -->
                        <td class="px-6 py-4">Rp 22.000</td> <!-- -->
                        <td class="px-6 py-4 font-bold">Rp 180.000</td> <!-- -->
                        <td class="px-6 py-4"><span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">Menipis</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>