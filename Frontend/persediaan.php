<?php
require_once '../Backend/koneksi.php';

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
$items = [];

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
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Rp <br><?php echo number_format($total_nilai_persediaan, 0, ',', '.'); ?></h3>
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
                            <th scope="col" class="px-6 py-4 tracking-wider">HPP</th>
                            <th scope="col" class="px-6 py-4 tracking-wider">Harga Jual</th>
                            <th scope="col" class="px-6 py-4 text-right tracking-wider">Total Aset</th>
                            <th scope="col" class="px-6 py-4 text-center tracking-wider">Status</th>
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
                        ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-bold text-gray-900 text-base mb-1"><?php echo htmlspecialchars($item['nama_obat']); ?></p>
                                <p class="text-gray-500 text-xs">SKU: <?php echo htmlspecialchars($item['kode_obat']); ?></p>
                            </td>
                            <td class="px-6 py-4 text-gray-700"><?php echo htmlspecialchars($item['nama_kategori'] ?? '-'); ?></td>
                            <td class="px-6 py-4 font-bold text-gray-900"><?php echo $item['total_stock']; ?></td>
                            <td class="px-6 py-4 text-gray-700"><?php echo htmlspecialchars($item['satuan'] ?? '-'); ?></td>
                            <td class="px-6 py-4 text-gray-700">Rp <?php echo number_format($hpp, 0, ',', '.'); ?></td>
                            <td class="px-6 py-4 text-gray-700">Rp <?php echo number_format($item['harga_jual'], 0, ',', '.'); ?></td>
                            <td class="px-6 py-4 text-right font-medium text-gray-900">Rp <?php echo number_format($aset, 0, ',', '.'); ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo $statusClass; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada data obat.</td>
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
                        nr.innerHTML = '<td colspan="8" class="px-6 py-8 text-center text-gray-500">Tidak ada produk yang cocok.</td>';
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
</body>
</html>
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