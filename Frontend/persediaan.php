<?php
require_once '../Backend/koneksi.php';

// Fetch kategori for edit dropdown
$query_kategori = mysqli_query($conn, "SELECT * FROM kategori");
$kategori_options = [];
while ($row_kat = mysqli_fetch_assoc($query_kategori)) {
    $kategori_options[] = $row_kat;
}

// Fetch rak for edit dropdown
$query_rak = mysqli_query($conn, "SELECT no_rak, nama_rak FROM rak ORDER BY no_rak");
$rak_options = [];
while ($row_rak = mysqli_fetch_assoc($query_rak)) {
    $rak_options[] = $row_rak;
}

// Fetch satuan options
$query_satuan = mysqli_query($conn, "SELECT DISTINCT satuan FROM obat ORDER BY satuan");
$satuan_options = [];
while ($row_sat = mysqli_fetch_assoc($query_satuan)) {
    $satuan_options[] = $row_sat;
}

$query = mysqli_query($conn, "
    SELECT 
        o.*, 
        k.nama_kategori, 
        IFNULL(SUM(s.jumlah_stock), 0) as total_stock,
        IFNULL(SUM(s.jumlah_stock * s.harga_awal), 0) as total_aset,
        IFNULL(MAX(s.harga_awal), 0) as hpp
    FROM obat o 
    LEFT JOIN kategori k ON o.id_kategori = k.id_kategori
    LEFT JOIN stock s ON o.kode_obat = s.kode_obat
    GROUP BY o.kode_obat
");

$total_item_stok = 0;
$stok_menipis = 0;
$stok_habis = 0;
$total_nilai_persediaan = 0;
$obat_kadaluwarsa = 0;
$obat_segera_kadaluwarsa = 0;
$items = [];
$today = date('Y-m-d');
$threshold_30 = date('Y-m-d', strtotime('+30 days'));

while ($row = mysqli_fetch_assoc($query)) {
    $stock = $row['total_stock'];
    $unit  = $row['satuan'];
    $hpp   = $row['hpp']; 
    $total_item_stok += $stock;
    $total_nilai_persediaan += $row['total_aset']; 
    
    if ($stock == 0) {
        $stok_habis++;
    } elseif ($stock < 10) {
        $stok_menipis++;
    }
    
    // Check expiry status
    if ($row['kadaluwarsa'] < $today) {
        $obat_kadaluwarsa++;
    } elseif ($row['kadaluwarsa'] <= $threshold_30) {
        $obat_segera_kadaluwarsa++;
    }
    $items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Persediaan Barang</title>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">
    <?php include 'sidebar.php'; ?>
    
    <main class="ml-64 p-10 min-h-screen">
        <div class="mb-10 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Persediaan Barang</h2>
                <p class="text-gray-500">Kelola dan pantau stok apotek Anda</p>
            </div>
            <a href="tambah-produk.php" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm transition inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Produk
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <!-- Card 1 -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-medium text-gray-600">Total Item Stok</p>
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2"><?php echo number_format($total_item_stok, 0, ',', '.'); ?></h3>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-medium text-gray-600">Stok Menipis</p>
                    <div class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2"><?php echo $stok_menipis; ?></h3>
                    <p class="text-xs font-medium text-red-500">Perlu restock segera</p>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-medium text-gray-600">Stok Habis</p>
                    <div class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2"><?php echo $stok_habis; ?></h3>
                    <p class="text-xs font-medium text-gray-500">Item kosong</p>
                </div>
            </div>
            
            <!-- Card 4 -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-medium text-gray-600">Total Nilai Persediaan</p>
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Rp <?php echo number_format($total_nilai_persediaan, 0, ',', '.'); ?></h3>
                    <p class="text-xs font-medium text-blue-600">Berdasarkan HPP</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex gap-4 items-center bg-white">
                <div class="relative flex-1">
                    <input id="searchInput" type="text" placeholder="Cari nama produk atau SKU..." class="w-full bg-gray-50 border border-gray-100 text-sm rounded-lg pl-10 pr-4 py-2.5 outline-none focus:border-blue-500 transition">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="text-[11px] text-gray-500 font-bold uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 tracking-wider">Nama Produk & SKU</th>
                            <th scope="col" class="px-6 py-4 tracking-wider">Kategori</th>
                            <th scope="col" class="px-6 py-4 tracking-wider">Stok Fisik</th>
                            <th scope="col" class="px-6 py-4 tracking-wider">Unit Terkecil</th>
                            <th scope="col" class="px-6 py-4 tracking-wider">Kadaluwarsa</th>
                            <th scope="col" class="px-6 py-4 tracking-wider">HPP</th>
                            <th scope="col" class="px-6 py-4 tracking-wider">Harga Jual</th>
                            <th scope="col" class="px-6 py-4 text-right tracking-wider">Total Aset</th>
                            <th scope="col" class="px-6 py-4 text-center tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-4 text-center tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($items as $item): 
                            $status = 'Tersedia';
                            $statusClass = 'bg-green-100 text-green-700';
                            if ($item['total_stock'] == 0) {
                                $status = 'Habis';
                                $statusClass = 'bg-red-100 text-red-700';
                            } elseif ($item['total_stock'] < 10) {
                                $status = 'Menipis';
                                $statusClass = 'bg-yellow-100 text-yellow-700';
                            }
                            $hpp = $item['hpp'];
                            $aset =$item['total_aset'];
                            
                            // Expiry status
                            $exp_date = $item['kadaluwarsa'];
                            $sisa_hari = (int)((strtotime($exp_date) - strtotime($today)) / 86400);
                            $exp_display = date('d M Y', strtotime($exp_date));
                            $exp_class = '';
                            $exp_label = '';
                            if ($sisa_hari < 0) {
                                $exp_class = 'text-red-600 font-semibold';
                                $exp_label = '<span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-700 mt-1"><svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>Kadaluwarsa</span>';
                            } elseif ($sisa_hari <= 30) {
                                $exp_class = 'text-amber-600 font-semibold';
                                $exp_label = '<span class="inline-flex items-center gap-1 px-2 py-0.5 text-[10px] font-bold rounded-full bg-amber-100 text-amber-700 mt-1"><svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' . $sisa_hari . ' hari lagi</span>';
                            }
                            
                            // Override row class for expired items
                            $rowClass = $sisa_hari < 0 ? 'bg-red-50/50 hover:bg-red-50' : 'hover:bg-gray-50';
                        ?>
                        <tr class="<?php echo $rowClass; ?> transition">
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900 text-base mb-1"><?php echo htmlspecialchars($item['nama_obat']); ?></p>
                                <p class="text-gray-500 text-xs">SKU: <?php echo htmlspecialchars($item['kode_obat']); ?></p>
                            </td>
                            <td class="px-6 py-4 text-gray-700"><?php echo htmlspecialchars($item['nama_kategori'] ?? '-'); ?></td>
                            <td class="px-6 py-4 font-bold text-gray-900"><?php echo $item['total_stock']; ?></td>
                            <td class="px-6 py-4 text-gray-700"><?php echo htmlspecialchars($item['satuan'] ?? '-'); ?></td>
                            <td class="px-6 py-4">
                                <div class="<?php echo $exp_class; ?>"><?php echo $exp_display; ?></div>
                                <?php echo $exp_label; ?>
                            </td>
                            <td class="px-6 py-4 text-gray-700">Rp <?php echo number_format($hpp, 0, ',', '.'); ?></td>
                            <td class="px-6 py-4 text-gray-700">Rp <?php echo number_format($item['harga_jual'], 0, ',', '.'); ?></td>
                            <td class="px-6 py-4 text-right font-medium text-gray-900">Rp <?php echo number_format($aset, 0, ',', '.'); ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo $statusClass; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="openEditModal('<?php echo htmlspecialchars($item['kode_obat']); ?>')" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition" title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <?php if ($sisa_hari < 0): ?>
                                    <button onclick="openDeleteModal('<?php echo htmlspecialchars($item['kode_obat']); ?>', '<?php echo htmlspecialchars(addslashes($item['nama_obat'])); ?>', true)" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-500 text-white hover:bg-red-600 transition shadow-sm" title="Hapus (Kadaluwarsa)">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                    <?php else: ?>
                                    <button onclick="openDeleteModal('<?php echo htmlspecialchars($item['kode_obat']); ?>', '<?php echo htmlspecialchars(addslashes($item['nama_obat'])); ?>', false)" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition" title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-center text-gray-500">Belum ada data obat.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        (function(){
            const input = document.getElementById('searchInput');
            const table = document.querySelector('table');
            if (!input || !table) return;
            const tbody = table.querySelector('tbody');

            function updateNoResults(visibleCount) {
                const existing = document.getElementById('noResultsRow');
                if (visibleCount === 0) {
                    if (!existing) {
                        const nr = document.createElement('tr');
                        nr.id = 'noResultsRow';
                        nr.innerHTML = '<td colspan="10" class="px-6 py-8 text-center text-gray-500">Tidak ada produk yang cocok.</td>';
                        tbody.appendChild(nr);
                    }
                } else {
                    if (existing) existing.remove();
                }
            }

            input.addEventListener('input', function(e){
                const q = (this.value || '').trim().toLowerCase();
                const rows = Array.from(tbody.querySelectorAll('tr'));
                let visible = 0;
                rows.forEach(row => {
                    // ignore rows that are explicitly used as placeholders (check colspan)
                    const colspan = row.querySelector('td') ? row.querySelector('td').getAttribute('colspan') : null;
                    if (colspan && parseInt(colspan) > 1) return;
                    const text = row.textContent.toLowerCase();
                    if (!q || text.indexOf(q) !== -1) {
                        row.style.display = '';
                        visible++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                updateNoResults(visible);
            });
        })();
    </script>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-[9990] hidden">
        <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="closeEditModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative" onclick="event.stopPropagation()">
                <div class="sticky top-0 bg-white border-b border-gray-100 px-8 py-5 flex items-center justify-between rounded-t-2xl z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Edit Produk</h3>
                            <p class="text-xs text-gray-500" id="editModalSku">SKU: -</p>
                        </div>
                    </div>
                    <button onclick="closeEditModal()" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form id="editForm" action="../Backend/proses_edit.php" method="POST">
                    <input type="hidden" name="kode_obat" id="editKodeObat">
                    <div class="p-8 space-y-6">
                        <!-- Informasi Produk -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                Informasi Produk
                            </h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_obat" id="editNamaObat" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kategori</label>
                                    <select name="id_kategori" id="editKategori" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition appearance-none">
                                        <option value="">- Pilih Kategori -</option>
                                        <?php foreach ($kategori_options as $kat): ?>
                                            <option value="<?php echo $kat['id_kategori']; ?>"><?php echo htmlspecialchars($kat['nama_kategori']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Rak</label>
                                    <select name="no_rak" id="editRak" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition appearance-none">
                                        <option value="">- Pilih Rak -</option>
                                        <?php foreach ($rak_options as $rak): ?>
                                            <option value="<?php echo htmlspecialchars($rak['no_rak']); ?>"><?php echo htmlspecialchars($rak['no_rak'] . ' - ' . $rak['nama_rak']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Satuan <span class="text-red-500">*</span></label>
                                    <select name="satuan" id="editSatuan" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition appearance-none">
                                        <option value="">- Pilih Satuan -</option>
                                        <?php foreach ($satuan_options as $sat): ?>
                                            <option value="<?php echo htmlspecialchars($sat['satuan']); ?>"><?php echo htmlspecialchars($sat['satuan']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <!-- Stok & Kadaluwarsa -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Stok & Kadaluwarsa
                            </h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Jumlah Stok</label>
                                    <input type="number" name="jumlah_stock" id="editStok" min="0" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kadaluwarsa <span class="text-red-500">*</span></label>
                                    <input type="date" name="kadaluwarsa" id="editKadaluwarsa" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <!-- Harga -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Informasi Harga
                            </h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">HPP / Harga Beli</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-2.5 text-sm text-gray-400">Rp</span>
                                        <input type="number" name="harga_beli" id="editHpp" min="0" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Harga Jual <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-2.5 text-sm text-gray-400">Rp</span>
                                        <input type="number" name="harga_jual" id="editHargaJual" required min="0" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm outline-none focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="sticky bottom-0 bg-gray-50 border-t border-gray-100 px-8 py-4 flex justify-end gap-3 rounded-b-2xl">
                        <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[9990] hidden">
        <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md relative" onclick="event.stopPropagation()">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Produk?</h3>
                    <p class="text-sm text-gray-500 mb-1">Anda akan menghapus produk:</p>
                    <p class="text-base font-bold text-gray-900 mb-4" id="deleteProductName">-</p>
                    <div id="deleteExpiredBadge" class="hidden mb-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold rounded-full bg-red-100 text-red-700">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            Produk ini sudah kadaluwarsa
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 bg-gray-50 rounded-lg p-3">Data produk, stok, dan riwayat terkait akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="border-t border-gray-100 px-8 py-4 flex gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="flex-1 px-5 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition">Batal</button>
                    <form id="deleteForm" action="../Backend/proses_hapus.php" method="POST" class="flex-1">
                        <input type="hidden" name="kode_obat" id="deleteKodeObat">
                        <button type="submit" class="w-full px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-bold transition shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal Loading Overlay -->
    <style>
        #editModal, #deleteModal {
            transition: opacity 0.2s ease;
        }
        #editModal > div:nth-child(2) > div,
        #deleteModal > div:nth-child(2) > div {
            transform: scale(0.95);
            opacity: 0;
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease;
        }
        #editModal.show > div:nth-child(2) > div,
        #deleteModal.show > div:nth-child(2) > div {
            transform: scale(1);
            opacity: 1;
        }
        .edit-loading {
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            z-index: 20;
        }
        .edit-spinner {
            width: 32px;
            height: 32px;
            border: 3px solid #e5e7eb;
            border-top-color: #3b82f6;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <script>
    function openEditModal(kodeObat) {
        const modal = document.getElementById('editModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => modal.classList.add('show'));

        // Show loading
        const container = modal.querySelector('form').parentElement;
        let loader = container.querySelector('.edit-loading');
        if (!loader) {
            loader = document.createElement('div');
            loader.className = 'edit-loading';
            loader.innerHTML = '<div class="edit-spinner"></div>';
            container.style.position = 'relative';
            container.appendChild(loader);
        }
        loader.style.display = 'flex';

        // Fetch product data
        fetch('../Backend/get_obat.php?kode_obat=' + encodeURIComponent(kodeObat))
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    const d = res.data;
                    document.getElementById('editKodeObat').value = d.kode_obat;
                    document.getElementById('editModalSku').textContent = 'SKU: ' + d.kode_obat;
                    document.getElementById('editNamaObat').value = d.nama_obat;
                    document.getElementById('editKategori').value = d.id_kategori || '';
                    document.getElementById('editRak').value = d.no_rak || '';
                    document.getElementById('editSatuan').value = d.satuan || '';
                    document.getElementById('editStok').value = d.total_stock;
                    document.getElementById('editKadaluwarsa').value = d.kadaluwarsa;
                    document.getElementById('editHpp').value = d.hpp;
                    document.getElementById('editHargaJual').value = d.harga_jual;
                }
                loader.style.display = 'none';
            })
            .catch(err => {
                console.error(err);
                loader.style.display = 'none';
                if (typeof showToast === 'function') {
                    showToast('Gagal memuat data produk!', 'error');
                }
            });
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.remove('show');
        document.body.style.overflow = '';
        setTimeout(() => modal.classList.add('hidden'), 250);
    }

    function openDeleteModal(kodeObat, namaObat, isExpired) {
        const modal = document.getElementById('deleteModal');
        document.getElementById('deleteKodeObat').value = kodeObat;
        document.getElementById('deleteProductName').textContent = namaObat;
        const badge = document.getElementById('deleteExpiredBadge');
        if (isExpired) {
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(() => modal.classList.add('show'));
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('show');
        document.body.style.overflow = '';
        setTimeout(() => modal.classList.add('hidden'), 250);
    }

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditModal();
            closeDeleteModal();
        }
    });
    </script>

<?php include 'toast.php'; ?>
<script>
// Auto-show toast from URL parameters (after redirect from backend)
(function() {
    const params = new URLSearchParams(window.location.search);
    const msg = params.get('msg');
    const text = params.get('text');
    if (msg && text) {
        showToast(decodeURIComponent(text), msg === 'success' ? 'success' : 'error');
        // Clean URL without reload
        window.history.replaceState({}, '', window.location.pathname);
    }
})();
</script>
</body>
</html>