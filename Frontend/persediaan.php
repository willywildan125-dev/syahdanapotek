<?php require_once '../Backend/get_persediaan.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Apotek Syahdan - Persediaan Barang</title>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <?php include 'sidebar.php'; ?>
    <main class="ml-64 p-8 min-h-screen">
        
        <div class="flex justify-between items-center mb-8">
            <div><h2 class="text-2xl font-bold text-gray-900">Persediaan Barang</h2></div>
            <a href="tambah-produk.php" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm transition">
                + Tambah Produk
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase">
                        <tr>
                            <th class="px-6 py-4 border-b">NAMA PRODUK & SKU</th>
                            <th class="px-6 py-4 border-b">KATEGORI</th>
                            <th class="px-6 py-4 border-b">STOK FISIK</th>
                            <th class="px-6 py-4 border-b">HARGA JUAL</th>
                            <th class="px-6 py-4 border-b">TOTAL ASET</th>
                            <th class="px-6 py-4 border-b">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($data_produk)): ?>
                            <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data obat.</td></tr>
                        <?php else: ?>
                            <?php foreach ($data_produk as $row): 
                                if ($row['total_stok'] <= 0) {
                                    $status_class = "bg-red-100 text-red-700"; $status_text = "Habis";
                                } elseif ($row['total_stok'] <= 10) { 
                                    $status_class = "bg-yellow-100 text-yellow-700"; $status_text = "Menipis";
                                } else {
                                    $status_class = "bg-green-100 text-green-700"; $status_text = "Tersedia";
                                }
                                $total_aset = $row['total_stok'] * $row['harga_jual'];
                            ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900"><?= htmlspecialchars($row['nama_obat']); ?></p>
                                    <p class="text-xs text-gray-500 mt-0.5">SKU: <?= htmlspecialchars($row['kode_obat']); ?></p>
                                </td>
                                <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($row['nama_kategori'] ?? '-'); ?></td>
                                <td class="px-6 py-4 font-bold"><?= $row['total_stok']; ?></td>
                                <td class="px-6 py-4">Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?></td>
                                <td class="px-6 py-4 font-bold">Rp <?= number_format($total_aset, 0, ',', '.'); ?></td>
                                <td class="px-6 py-4"><span class="px-3 py-1 <?= $status_class; ?> rounded-full text-xs font-medium"><?= $status_text; ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>