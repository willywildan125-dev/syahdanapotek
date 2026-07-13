<?php
require_once '../Backend/koneksi.php';

// Fetch kategori for dropdown
$query_kategori = mysqli_query($conn, "SELECT * FROM kategori");
$kategori_options = [];
while ($row = mysqli_fetch_assoc($query_kategori)) {
    $kategori_options[] = $row;
}

// Fetch rak for dropdown
$query_rak = mysqli_query($conn, "SELECT no_rak, nama_rak FROM rak ORDER BY no_rak");
$rak_options = [];
while ($row = mysqli_fetch_assoc($query_rak)) {
    $rak_options[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Tambah Produk</title>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">
    <?php include 'sidebar.php'; ?>
    
    <main class="ml-64 min-h-screen flex flex-col">
        <!-- Top header area similar to design -->
        <div class="bg-white border-b border-gray-100 py-4 px-10 flex justify-between items-center sticky top-0 z-10">
            <h2 class="text-xl font-bold text-gray-900">Tambah Produk Baru</h2>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Cari obat..." class="w-64 bg-gray-50 border border-gray-100 text-sm rounded-lg pl-10 pr-4 py-2 outline-none focus:border-brand-500 transition">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm space-y-6">
    <h3 class="text-lg font-bold text-brand-700 flex items-center border-b border-gray-100 pb-4">
        <svg class="w-5 h-5 mr-2 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
        Informasi Produk
    </h3>
    
    <div class="space-y-5">
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="nama_obat" required placeholder="Contoh: Paracetamol 500mg" class="w-full bg-gray-50/70 border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Rak</label>
                <div class="relative">
                    <select name="no_rak" class="w-full bg-gray-50/70 border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition appearance-none">
                        <option value="" class="text-gray-400">Pilih rak...</option>
                        <?php foreach ($rak_options as $rak): ?>
                            <option value="<?php echo htmlspecialchars($rak['no_rak']); ?>"><?php echo htmlspecialchars($rak['no_rak'] . ' - ' . $rak['nama_rak']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-5">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">SKU / Barcode <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="text" name="kode_obat" required placeholder="Scan atau ketik kode" class="w-full bg-gray-50/70 border border-gray-200 rounded-xl pl-4 pr-12 py-3 text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition">
                    <div class="absolute right-4 top-3.5 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">Kategori <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select name="id_kategori" required class="w-full bg-gray-50/70 border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:bg-white focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition appearance-none">
                        <option value="" class="text-gray-400">Pilih kategori...</option>
                        <?php foreach ($kategori_options as $kat): ?>
                            <option value="<?php echo $kat['id_kategori']; ?>"><?php echo htmlspecialchars($kat['nama_kategori']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                    <!-- Satuan & Stok -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
                        <h3 class="text-lg font-bold text-brand-700 flex items-center mb-6">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Satuan & Stok
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">SATUAN/UNIT TERKECIL <span class="text-red-500">*</span></label>
                                <select name="satuan_terkecil" required class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-sm outline-none focus:border-brand-500 transition appearance-none">
                                    <option value="Tablet">Tablet</option>
                                    <option value="Kapsul">Kapsul</option>
                                    <option value="Botol">Botol</option>
                                    <option value="Tube">Tube</option>
                                    <option value="Strip">Strip</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">STOK</label>
                                <input type="text" name="STOK" placeholder="Contoh: 10" class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-sm outline-none focus:border-brand-500 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">KADALUWARSA<span class="text-red-500">*</span></label>
                                <input type="date" name="kadaluwarsa" required class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-sm outline-none focus:border-brand-500 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Harga -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm">
                        <h3 class="text-lg font-bold text-brand-700 flex items-center mb-6">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Informasi Harga
                        </h3>
                        
                        <div class="grid grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">HPP / Harga Beli <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-sm text-gray-500">Rp</span>
                                    <input type="number" name="harga_beli" required value="0" min="0" class="w-full bg-gray-50 border border-gray-100 rounded-xl pl-10 pr-4 py-3 text-sm outline-none focus:border-brand-500 transition">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Harga Jual Dasar <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-sm text-gray-500">Rp</span>
                                    <input type="number" name="harga_jual" required value="0" min="0" class="w-full bg-gray-50 border border-gray-100 rounded-xl pl-10 pr-4 py-3 text-sm outline-none focus:border-brand-500 transition">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Pajak (PPN) <span class="text-red-500">*</span></label>
                                <select class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-3 text-sm outline-none focus:border-brand-500 transition appearance-none">
                                    <option value="11">PPN 11% (Termasuk)</option>
                                    <option value="0">Tanpa PPN</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4 pb-10 mt-6">
                        <a href="persediaan.php" class="px-6 py-3 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">Batal</a>
                        <button type="submit" class="px-8 py-3 bg-brand-500 hover:bg-brand-600 text-white rounded-xl text-sm font-bold transition shadow-sm flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Produk
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>
</body>
</html>