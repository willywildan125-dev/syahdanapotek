<?php $current_page = basename($_SERVER['PHP_SELF']); ?>
<aside class="w-64 bg-white border-r border-gray-100 min-h-screen flex flex-col fixed left-0 top-0 z-50">
    <div class="p-6 pb-8 flex items-center mt-2">
        <h1 class="text-xl font-bold text-gray-800 tracking-tight">Apotek <span class="text-brand-600">Syahdan</span></h1>
    </div>
    <nav class="flex-1 px-4 space-y-1.5">
        <a href="index.php" class="flex items-center px-4 py-3 rounded-xl font-medium transition-colors <?php echo ($current_page == 'index.php' || $current_page == '') ? 'bg-brand-50 text-brand-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'; ?>">
            <svg class="w-5 h-5 mr-3 <?php echo ($current_page == 'index.php' || $current_page == '') ? 'text-brand-700' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>
        <a href="kasir.php" class="flex items-center px-4 py-3 rounded-xl font-medium transition-colors <?php echo ($current_page == 'kasir.php') ? 'bg-brand-50 text-brand-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'; ?>">
            <svg class="w-5 h-5 mr-3 <?php echo ($current_page == 'kasir.php') ? 'text-brand-700' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Kasir
        </a>
        <a href="persediaan.php" class="flex items-center px-4 py-3 rounded-xl font-medium transition-colors <?php echo ($current_page == 'persediaan.php' || $current_page == 'tambah-produk.php') ? 'bg-brand-50 text-brand-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'; ?>">
            <svg class="w-5 h-5 mr-3 <?php echo ($current_page == 'persediaan.php' || $current_page == 'tambah-produk.php') ? 'text-brand-700' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            Persediaan barang
        </a>
        <a href="laporan.php" class="flex items-center px-4 py-3 rounded-xl font-medium transition-colors <?php echo ($current_page == 'laporan.php') ? 'bg-brand-50 text-brand-700' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900'; ?>">
            <svg class="w-5 h-5 mr-3 <?php echo ($current_page == 'laporan.php') ? 'text-brand-700' : 'text-gray-400'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Laporan keuangan
        </a>
    </nav>
</aside>