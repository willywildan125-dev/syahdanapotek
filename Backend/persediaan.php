<?php
// Letakkan ini di baris paling atas persediaan.php
require 'koneksi.php';

// Query JOIN untuk mengambil obat, nama kategori, dan total stok
$query = "
    SELECT 
        o.kode_obat, 
        o.nama_obat, 
        o.harga_jual, 
        k.nama_kategori,
        COALESCE(SUM(s.jumlah_stock), 0) AS total_stok
    FROM obat o
    LEFT JOIN kategori k ON o.id_kategori = k.id_kategori
    LEFT JOIN stock s ON o.kode_obat = s.kode_obat
    GROUP BY o.kode_obat
    ORDER BY o.nama_obat ASC
";
$result_produk = mysqli_query($conn, $query);
?>

<tbody class="divide-y divide-gray-100">
    <?php while($row = mysqli_fetch_assoc($result_produk)) { 
        // Logika Status Stok
        if ($row['total_stok'] <= 0) {
            $status_class = "bg-red-100 text-red-700";
            $status_text = "Habis";
            $stok_class = "text-red-600 font-bold";
        } elseif ($row['total_stok'] <= 10) { // Anggap batas menipis adalah 10
            $status_class = "bg-yellow-100 text-yellow-700";
            $status_text = "Menipis";
            $stok_class = "text-yellow-600 font-bold";
        } else {
            $status_class = "bg-green-100 text-green-700";
            $status_text = "Tersedia";
            $stok_class = "text-gray-800 font-medium";
        }
        
        // Total aset berdasarkan harga jual (karena harga beli tidak ada di DB)
        $total_aset = $row['total_stok'] * $row['harga_jual'];
    ?>
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4">
            <p class="font-bold text-gray-900"><?= htmlspecialchars($row['nama_obat']); ?></p>
            <p class="text-xs text-gray-500 mt-0.5">SKU: <?= htmlspecialchars($row['kode_obat']); ?></p>
        </td>
        <td class="px-6 py-4 text-gray-600"><?= $row['nama_kategori'] ? htmlspecialchars($row['nama_kategori']) : '-'; ?></td>
        <td class="px-6 py-4 <?= $stok_class; ?>"><?= $row['total_stok']; ?></td>
        <td class="px-6 py-4 text-gray-600">Pcs</td> <td class="px-6 py-4 text-gray-600">-</td> <td class="px-6 py-4 text-gray-600">Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?></td>
        <td class="px-6 py-4 font-bold text-gray-900">Rp <?= number_format($total_aset, 0, ',', '.'); ?></td>
        <td class="px-6 py-4">
            <span class="px-3 py-1 <?= $status_class; ?> rounded-full text-xs font-medium"><?= $status_text; ?></span>
        </td>
    </tr>
    <?php } ?>
</tbody>