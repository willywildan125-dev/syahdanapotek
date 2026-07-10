<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Apotek Syahdan - Tambah Produk</title>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <?php include 'sidebar.php'; ?>
    <main class="ml-64 p-8 min-h-screen">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mt-2">Tambah Produk Baru</h2>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-8 max-w-4xl shadow-sm">
            <form action="../Backend/proses_tambah.php" method="POST">
                
                <h3 class="font-bold text-lg text-gray-800 mb-5 pb-2 border-b border-gray-100">Informasi Produk</h3>
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">NAMA PRODUK *</label>
                        <input type="text" name="nama_obat" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">SKU / KODE OBAT *</label>
                        <input type="text" name="kode_obat" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">ID KATEGORI</label>
                        <input type="text" name="id_kategori" placeholder="Contoh: K01" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">TANGGAL KADALUWARSA *</label>
                        <input type="date" name="kadaluwarsa" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 outline-none focus:border-blue-500">
                    </div>
                </div>

                <h3 class="font-bold text-lg text-gray-800 mb-5 pb-2 border-b border-gray-100">Stok & Harga</h3>
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">STOK AWAL</label>
                        <input type="number" name="jumlah_stock" value="0" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">HARGA JUAL *</label>
                        <input type="number" name="harga_jual" required placeholder="Rp 0" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="flex justify-end space-x-4 border-t border-gray-200 pt-6">
                    <a href="persediaan.php" class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition shadow-sm">Simpan Produk</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>