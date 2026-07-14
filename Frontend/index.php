<?php
require_once '../Backend/koneksi.php';
/** @var mysqli $conn */

// ===== FILTER PARAMETERS =====
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date   = isset($_GET['end_date'])   ? $_GET['end_date']   : '';

$search     = isset($_GET['search'])     ? $_GET['search']     : '';
$page       = isset($_GET['page'])       ? max(1, (int)$_GET['page']) : 1;
$per_page   = 5;

// ===== BUILD WHERE CLAUSE =====
$where = [];

if ($start_date && $end_date) {
    $s = mysqli_real_escape_string($conn, $start_date);
    $e = mysqli_real_escape_string($conn, $end_date);
    $where[] = "tgl_penjualan BETWEEN '$s' AND '$e'";
} elseif ($start_date) {
    $s = mysqli_real_escape_string($conn, $start_date);
    $where[] = "tgl_penjualan >= '$s'";
} elseif ($end_date) {
    $e = mysqli_real_escape_string($conn, $end_date);
    $where[] = "tgl_penjualan <= '$e'";
}



if ($search) {
    $q = mysqli_real_escape_string($conn, $search);
    $where[] = "no_nota LIKE '%$q%'";
}

$where_sql = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

// ===== TOTAL STATS (ALL DATA) =====
$query_all_pendapatan = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM nota_penjualan");
$total_pendapatan_all = mysqli_fetch_assoc($query_all_pendapatan)['total'] ?? 0;

$query_all_transaksi = mysqli_query($conn, "SELECT COUNT(*) as count FROM nota_penjualan");
$total_transaksi_all = mysqli_fetch_assoc($query_all_transaksi)['count'] ?? 0;

$rata_rata_all = $total_transaksi_all > 0 ? $total_pendapatan_all / $total_transaksi_all : 0;

// ===== FILTERED COUNTS =====
$count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM nota_penjualan $where_sql");
$total_filtered = mysqli_fetch_assoc($count_query)['total'];
$total_pages = max(1, ceil($total_filtered / $per_page));

// Clamp page
$page = min($page, $total_pages);
$offset = ($page - 1) * $per_page;

// ===== FETCH PAGINATED DATA =====
$query_recent = mysqli_query($conn, "
    SELECT no_nota, total_harga, tgl_penjualan 
    FROM nota_penjualan 
    $where_sql 
    ORDER BY tgl_penjualan DESC, no_nota DESC 
    LIMIT $per_page OFFSET $offset
");

// ===== BUILD QUERY STRING HELPER =====
function buildQs($overrides = []) {
    $params = [
        'start_date' => $_GET['start_date'] ?? '',
        'end_date'   => $_GET['end_date'] ?? '',
        'search'     => $_GET['search'] ?? '',
        'page'       => $_GET['page'] ?? 1,
    ];
    $params = array_merge($params, $overrides);
    // Remove empty
    $params = array_filter($params, function($v, $k) {
        if ($k === 'page' && $v == 1) return false;
        return $v !== '';
    }, ARRAY_FILTER_USE_BOTH);
    return http_build_query($params);
}

// Label for date range display
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
    <title>Apotek Syahdan - Dashboard</title>
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




        /* Smooth transitions */
        .fade-in { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased">
    <?php include 'sidebar.php'; ?>
    <?php include 'toast.php'; ?>
    
    <main class="ml-64 p-10 min-h-screen">
        <div class="mb-10 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">Dashboard</h2>
                <p class="text-gray-500">Kelola dan pantau semua transaksi penjualan</p>
            </div>
            <a href="laporan.php" class="bg-white border border-brand-500 text-brand-600 hover:bg-brand-50 px-5 py-2.5 rounded-lg font-medium shadow-sm transition inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Export Data
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center mb-4 text-brand-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">Rp <?php echo number_format($total_pendapatan_all, 0, ',', '.'); ?></h3>
                    <p class="text-xs font-medium text-brand-600 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Sepanjang waktu
                    </p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center mb-4 text-brand-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2"><?php echo number_format($total_transaksi_all, 0, ',', '.'); ?></h3>
                    <p class="text-xs font-medium text-brand-600 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Nota tercatat
                    </p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center mb-4 text-brand-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p class="text-sm font-medium text-gray-600">Rata-rata Penjualan</p>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-2">Rp <?php echo number_format($rata_rata_all, 0, ',', '.'); ?></h3>
                    <p class="text-xs font-medium text-gray-500 flex items-center">
                        Per transaksi
                    </p>
                </div>
            </div>
        </div>

        <!-- Transaction Table with Filters -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Filter Bar -->
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
                <div class="flex space-x-3">
                    <!-- Date Range Filter -->
                    <div class="relative" id="dateFilterContainer">
                        <button type="button" id="dateFilterBtn" class="flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600 cursor-pointer hover:bg-gray-100 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span id="dateBtnLabel"><?php echo htmlspecialchars($date_label); ?></span>
                        </button>
                        <div class="date-popup" id="datePopup">
                            <form method="GET" action="index.php" id="dateForm">
                                <!-- Preserve other filters -->
                                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="startDateInput" value="<?php echo htmlspecialchars($start_date); ?>" class="mb-3">
                                
                                <label for="end_date">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="endDateInput" value="<?php echo htmlspecialchars($end_date); ?>" class="mb-4">
                                
                                <div class="flex space-x-2">
                                    <button type="submit" class="flex-1 bg-brand-500 text-white text-sm font-semibold py-2 rounded-lg hover:bg-brand-600 transition">Terapkan</button>
                                    <a href="index.php?<?php echo buildQs(['start_date' => '', 'end_date' => '', 'page' => 1]); ?>" class="flex-1 bg-gray-100 text-gray-600 text-sm font-semibold py-2 rounded-lg hover:bg-gray-200 transition text-center">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>


                <!-- Search -->
                <form method="GET" action="index.php" class="relative" id="searchForm">
                    <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                    <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">

                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari ID Transaksi / No. Nota" class="w-72 bg-gray-50 border border-gray-200 text-sm rounded-lg pl-10 pr-4 py-2 outline-none focus:border-brand-500 transition">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </form>
            </div>

            <!-- Active Filters Indicator -->
            <?php if ($start_date || $end_date || $search): ?>
            <div class="px-6 py-3 bg-brand-50 border-b border-brand-100 flex items-center justify-between fade-in">
                <div class="flex items-center space-x-2 text-sm text-brand-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    <span class="font-medium">Filter aktif:</span>
                    <?php if ($start_date || $end_date): ?>
                        <span class="bg-white px-2 py-1 rounded-md text-xs font-semibold border border-brand-200"><?php echo $date_label; ?></span>
                    <?php endif; ?>

                    <?php if ($search): ?>
                        <span class="bg-white px-2 py-1 rounded-md text-xs font-semibold border border-brand-200">"<?php echo htmlspecialchars($search); ?>"</span>
                    <?php endif; ?>
                </div>
                <a href="index.php" class="text-xs text-brand-600 hover:text-brand-800 font-semibold transition">Hapus Semua Filter</a>
            </div>
            <?php endif; ?>
            
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-4 font-semibold tracking-wider">No. Nota</th>
                            <th scope="col" class="px-6 py-4 text-right font-semibold tracking-wider">Total Harga</th>
                            <th scope="col" class="px-6 py-4 text-center font-semibold tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if ($query_recent && mysqli_num_rows($query_recent) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($query_recent)): 
                                $datetime = date('d M Y', strtotime($row['tgl_penjualan']));
                            ?>
                            <tr class="hover:bg-gray-50 transition fade-in">
                                <td class="px-6 py-4 text-gray-700"><?php echo $datetime; ?></td>
                                <td class="px-6 py-4 font-medium text-brand-600">#<?php echo htmlspecialchars($row['no_nota']); ?></td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                <td class="px-6 py-4 text-center">
                                    <a href="struk.php?no_nota=<?php echo urlencode($row['no_nota']); ?>" class="text-gray-400 hover:text-brand-600 transition">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="text-gray-500 font-medium">Belum ada transaksi.</p>
                                    <p class="text-gray-400 text-xs mt-1">Coba ubah filter atau tambahkan transaksi baru.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="p-4 border-t border-gray-100 flex items-center justify-between bg-white text-sm">
                <span class="text-gray-500">
                    Menampilkan <?php echo min($total_filtered, $per_page); ?> dari <?php echo $total_filtered; ?> transaksi
                </span>
                <div class="flex space-x-1">
                    <!-- Previous Button -->
                    <?php if ($page > 1): ?>
                        <a href="index.php?<?php echo buildQs(['page' => $page - 1]); ?>" class="px-3 py-1 border border-gray-200 rounded text-gray-600 bg-white hover:bg-gray-50 transition">&lsaquo;</a>
                    <?php else: ?>
                        <button class="px-3 py-1 border border-gray-200 rounded text-gray-400 bg-white cursor-not-allowed" disabled>&lsaquo;</button>
                    <?php endif; ?>

                    <!-- Page Numbers -->
                    <?php
                    // Show pages intelligently
                    $range = 2; // Show 2 pages around current
                    $show_pages = [];
                    
                    // Always show page 1
                    $show_pages[] = 1;
                    
                    // Pages around current
                    for ($i = max(2, $page - $range); $i <= min($total_pages - 1, $page + $range); $i++) {
                        $show_pages[] = $i;
                    }
                    
                    // Always show last page if more than 1
                    if ($total_pages > 1) {
                        $show_pages[] = $total_pages;
                    }
                    
                    $show_pages = array_unique($show_pages);
                    sort($show_pages);
                    
                    $prev = 0;
                    foreach ($show_pages as $p):
                        // Add ellipsis if gap
                        if ($p - $prev > 1):
                    ?>
                        <span class="px-2 py-1 text-gray-400">...</span>
                    <?php endif; ?>
                    
                    <?php if ($p == $page): ?>
                        <button class="px-3 py-1 border border-brand-600 rounded text-white bg-brand-600 font-medium"><?php echo $p; ?></button>
                    <?php else: ?>
                        <a href="index.php?<?php echo buildQs(['page' => $p]); ?>" class="px-3 py-1 border border-gray-200 rounded text-gray-600 bg-white hover:bg-gray-50 transition"><?php echo $p; ?></a>
                    <?php endif; ?>
                    
                    <?php $prev = $p; endforeach; ?>

                    <!-- Next Button -->
                    <?php if ($page < $total_pages): ?>
                        <a href="index.php?<?php echo buildQs(['page' => $page + 1]); ?>" class="px-3 py-1 border border-gray-200 rounded text-gray-600 bg-white hover:bg-gray-50 transition">&rsaquo;</a>
                    <?php else: ?>
                        <button class="px-3 py-1 border border-gray-200 rounded text-gray-400 bg-white cursor-not-allowed" disabled>&rsaquo;</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        // ===== Date Range Popup Toggle =====
        const dateBtn = document.getElementById('dateFilterBtn');
        const datePopup = document.getElementById('datePopup');
        const dateContainer = document.getElementById('dateFilterContainer');

        dateBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            datePopup.classList.toggle('show');
        });

        // ===== Close dropdowns on outside click =====
        document.addEventListener('click', (e) => {
            if (!dateContainer.contains(e.target)) {
                datePopup.classList.remove('show');
            }
        });

        // ===== Search on Enter =====
        const searchInput = document.querySelector('#searchForm input[name="search"]');
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                document.getElementById('searchForm').submit();
            }
        });

        // ===== Debounced search (auto-submit after 500ms) =====
        let searchTimeout;
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('searchForm').submit();
            }, 600);
        });
    </script>
</body>
</html>