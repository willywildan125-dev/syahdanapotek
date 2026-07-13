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
    <div style="padding:16px 20px;border-top:1px solid #f3f4f6;flex-shrink:0;">
        <button id="notifBellBtn" class="notif-bell-btn" onclick="toggleNotifPanel()" title="Notifikasi Kadaluwarsa" style="width:100%;border-radius:12px;display:flex;align-items:center;padding:10px 16px;gap:12px;cursor:pointer;border:none;background:transparent;transition:all 0.2s;text-align:left;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background=this.classList.contains('has-alerts')?'#fef2f2':'transparent'">
            <div class="notif-bell-wrapper">
                <svg class="w-5 h-5" style="color:#9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span id="notifBadge" class="notif-badge" style="display:none;">0</span>
            </div>
            <span style="font-size:13px;font-weight:500;color:#6b7280;">Notifikasi</span>
        </button>
    </div>
</aside>
<?php include 'notifikasi.php'; ?>