<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="w-64 bg-white border-r border-gray-200 min-h-screen flex flex-col fixed left-0 top-0">
    <div class="p-6 border-b border-gray-100 flex items-center">
        <div class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center font-bold text-xl mr-3">+</div>
        <h1 class="text-xl font-bold text-gray-800">Apotek <span class="text-blue-600">Syahdan</span></h1>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="index.php" class="flex items-center px-4 py-3 rounded-lg font-medium <?php echo ($current_page == 'index.php' || $current_page == '') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100'; ?>">
            Dashboard
        </a>
        <a href="kasir.php" class="flex items-center px-4 py-3 rounded-lg font-medium <?php echo ($current_page == 'kasir.php') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100'; ?>">
            Kasir
        </a>
        <a href="persediaan.php" class="flex items-center px-4 py-3 rounded-lg font-medium <?php echo ($current_page == 'persediaan.php') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100'; ?>">
            Persediaan barang
        </a>
        <a href="laporan.php" class="flex items-center px-4 py-3 rounded-lg font-medium <?php echo ($current_page == 'laporan.php') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100'; ?>">
            Laporan keuangan
        </a>
    </nav>
</aside>