<?php
require_once '../Backend/koneksi.php';

$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : '';
$end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : '';

$where_clause = "";
if ($start_date && $end_date) {
    $where_clause = "WHERE DATE(tgl_penjualan) BETWEEN '$start_date' AND '$end_date'";
} elseif ($start_date) {
    $where_clause = "WHERE DATE(tgl_penjualan) >= '$start_date'";
} elseif ($end_date) {
    $where_clause = "WHERE DATE(tgl_penjualan) <= '$end_date'";
}

$query_laporan = mysqli_query($conn, "
    SELECT 
        DATE(tgl_penjualan) as tanggal,
        COUNT(no_nota) as total_transaksi,
        SUM(total_harga) as pendapatan
    FROM nota_penjualan 
    $where_clause
    GROUP BY DATE(tgl_penjualan)
    ORDER BY tanggal DESC
");

$laporan_data = [];
$total_pendapatan = 0;
while ($row = mysqli_fetch_assoc($query_laporan)) {
    $laporan_data[] = $row;
    $total_pendapatan += $row['pendapatan'];
}

$date_label = 'Semua Tanggal';
if ($start_date && $end_date) {
    $date_label = date('d M Y', strtotime($start_date)) . ' - ' . date('d M Y', strtotime($end_date));
} elseif ($start_date) {
    $date_label = 'Dari ' . date('d M Y', strtotime($start_date));
} elseif ($end_date) {
    $date_label = 'Sampai ' . date('d M Y', strtotime($end_date));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Laporan Keuangan</title>
    <link href="../dist/output.css" rel="stylesheet">
    <style>
        /* Date picker popup */
        .date-popup {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 20px;
            z-index: 100;
            min-width: 300px;
        }
        .date-popup.show { display: block; }
        .date-popup label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            margin-bottom: 6px;
        }
        .date-popup input[type="date"] {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s;
        }
        .date-popup input[type="date"]:focus {
            border-color: #059669;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">
    <?php include 'sidebar.php'; ?>
    
    <main class="ml-64 p-10 min-h-screen">
        <div class="mb-10 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Laporan Keuangan</h2>
                <p class="text-gray-500">Ringkasan transaksi dan pendapatan harian</p>
            </div>
            <?php
                $export_url = "../Backend/export_excel.php";
                if ($start_date || $end_date) {
                    $export_url .= "?start_date=" . urlencode($start_date) . "&end_date=" . urlencode($end_date);
                }
            ?>
            <a href="<?php echo $export_url; ?>" class="bg-brand-50 hover:bg-brand-100 text-brand-700 px-5 py-2.5 rounded-lg font-medium shadow-sm transition border border-brand-200 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export EXCEL
            </a>
        </div>
        

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                    <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></h3>
                    <p class="text-xs font-medium text-brand-600">
                        <?php 
                            if ($start_date && $end_date) {
                                echo date('d/m/Y', strtotime($start_date)) . " - " . date('d/m/Y', strtotime($end_date));
                            } elseif ($start_date) {
                                echo "Sejak " . date('d/m/Y', strtotime($start_date));
                            } elseif ($end_date) {
                                echo "Hingga " . date('d/m/Y', strtotime($end_date));
                            } else {
                                echo "Semua Periode";
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-4 flex justify-between items-center">
            <h3 class="font-bold text-lg text-gray-900">Rekap Pendapatan Harian</h3>
            
            <div class="relative" id="dateFilterContainer">
                <button type="button" id="dateFilterBtn" class="flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 cursor-pointer hover:bg-gray-50 shadow-sm transition">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span id="dateBtnLabel"><?php echo htmlspecialchars($date_label); ?></span>
                </button>
                <div class="date-popup" id="datePopup">
                    <form method="GET" action="laporan.php" id="dateForm">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="startDateInput" value="<?php echo htmlspecialchars($start_date); ?>" class="mb-3">
                        
                        <label for="end_date">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="endDateInput" value="<?php echo htmlspecialchars($end_date); ?>" class="mb-4">
                        
                        <div class="flex space-x-2">
                            <button type="submit" class="flex-1 bg-brand-500 text-white text-sm font-semibold py-2 rounded-lg hover:bg-brand-600 transition">Terapkan</button>
                            <a href="laporan.php" class="flex-1 bg-gray-100 text-gray-600 text-sm font-semibold py-2 rounded-lg hover:bg-gray-200 transition text-center">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="text-[11px] text-gray-500 font-bold uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-4 tracking-wider text-center">Total Transaksi</th>
                            <th scope="col" class="px-6 py-4 tracking-wider text-right">Pendapatan (Total Harga)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($laporan_data as $row): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <?php echo date('d M Y', strtotime($row['tanggal'])); ?>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-700">
                                <?php echo $row['total_transaksi']; ?>
                            </td>
                            <td class="px-6 py-4 text-right font-medium text-brand-700">
                                Rp <?php echo number_format($row['pendapatan'], 0, ',', '.'); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($laporan_data)): ?>
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada data transaksi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        const dateBtn = document.getElementById('dateFilterBtn');
        const datePopup = document.getElementById('datePopup');
        const dateContainer = document.getElementById('dateFilterContainer');

        if(dateBtn && datePopup && dateContainer) {
            dateBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                datePopup.classList.toggle('show');
            });

            document.addEventListener('click', (e) => {
                if (!dateContainer.contains(e.target)) {
                    datePopup.classList.remove('show');
                }
            });
        }
    </script>
</body>
</html>