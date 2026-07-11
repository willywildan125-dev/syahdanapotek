<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Transaction</title>
    <link href="../dist/output.css" rel="stylesheet">
    <style>
        /* Custom scrollbar for cart */
        .cart-scroll::-webkit-scrollbar { width: 4px; }
        .cart-scroll::-webkit-scrollbar-track { background: transparent; }
        .cart-scroll::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-800 antialiased overflow-hidden">
    <?php include 'sidebar.php'; ?>
    
    <main class="ml-64 flex h-screen">
        
        <!-- Left Product Section -->
        <div class="flex-1 p-8 flex flex-col h-full bg-white">
            <!-- Search & Scan -->
            <div class="flex gap-4 mb-6">
                <div class="relative flex-1">
                    <input type="text" id="searchInput" placeholder="Search medicines by name, SKU, or scan barcode..." class="w-full bg-gray-50 border border-gray-100 rounded-xl pl-12 pr-4 py-3.5 text-sm outline-none focus:border-brand-500 transition shadow-sm">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <button class="flex items-center px-6 py-3.5 bg-brand-50 text-brand-700 border border-brand-100 rounded-xl font-medium text-sm hover:bg-brand-100 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Scan
                </button>
            </div>
            
            <!-- Category Filters -->
            <div class="flex space-x-2.5 mb-8 overflow-x-auto pb-2" id="categoryFilters">
                <button class="px-5 py-2 bg-brand-700 text-white rounded-full text-sm font-medium shadow-sm transition" data-category="all">All</button>
                <button class="px-5 py-2 bg-gray-50 border border-gray-100 text-gray-600 hover:bg-gray-100 rounded-full text-sm font-medium transition" data-category="Analgesik">Pain Relief</button>
                <button class="px-5 py-2 bg-gray-50 border border-gray-100 text-gray-600 hover:bg-gray-100 rounded-full text-sm font-medium transition" data-category="Antibiotik">Antibiotics</button>
                <button class="px-5 py-2 bg-gray-50 border border-gray-100 text-gray-600 hover:bg-gray-100 rounded-full text-sm font-medium transition" data-category="Vitamin">Vitamins</button>
                <button class="px-5 py-2 bg-gray-50 border border-gray-100 text-gray-600 hover:bg-gray-100 rounded-full text-sm font-medium transition" data-category="Alkes">First Aid</button>
            </div>

            <!-- Product Grid -->
            <div class="flex-1 overflow-y-auto pr-2">
                <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5" id="productGrid">
                    <!-- Products will be injected here via JS -->
                    <div class="col-span-full text-center text-gray-500 py-10">Memuat produk...</div>
                </div>
            </div>
        </div>

        <!-- Right Cart Section -->
        <div class="w-[400px] bg-gray-50 border-l border-gray-100 flex flex-col shadow-[0_0_15px_rgba(0,0,0,0.02)] z-10">
            <div class="p-6 pb-4 border-b border-gray-200 bg-white flex justify-between items-center">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <h3 class="font-bold text-gray-900 text-lg">Current Order</h3>
                </div>
                <button id="clearCartBtn" class="flex items-center text-red-500 text-sm font-medium hover:text-red-600 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Clear
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6 space-y-4 cart-scroll bg-white" id="cartItems">
                <!-- Cart items will be injected here -->
                <div class="text-center text-gray-400 py-10 flex flex-col items-center">
                    <svg class="w-12 h-12 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p class="text-sm">Keranjang kosong</p>
                </div>
            </div>

            <div class="p-6 bg-gray-50 border-t border-gray-200">
                <div class="flex mb-5">
                    <div class="relative flex-1">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        <input type="text" placeholder="Promo code..." class="w-full bg-white border border-gray-200 rounded-l-lg pl-9 pr-3 py-2 text-sm outline-none focus:border-brand-500">
                    </div>
                    <button class="bg-brand-50 text-brand-700 border border-brand-100 border-l-0 px-4 py-2 rounded-r-lg text-sm font-medium hover:bg-brand-100 transition">Apply</button>
                </div>
                
                <div class="space-y-3 text-sm text-gray-600 mb-5">
                    <div class="flex justify-between">
                        <span>Subtotal (<span id="cartCount">0</span> items)</span>
                        <span class="font-medium text-gray-900" id="subtotalVal">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax (PPN 11%)</span>
                        <span class="font-medium text-gray-900" id="taxVal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-brand-600">
                        <span>Discount</span>
                        <span class="font-medium">- Rp 0</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg pt-4 border-t border-gray-200 text-gray-900">
                        <span>Total Payable</span>
                        <span id="totalVal">Rp 0</span>
                    </div>
                </div>
                
                <div class="flex space-x-3">
                    <button class="w-12 h-12 bg-brand-100 text-brand-700 rounded-xl flex items-center justify-center hover:bg-brand-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </button>
                    <button id="processPaymentBtn" class="flex-1 flex items-center justify-center bg-brand-500 hover:bg-brand-600 text-white py-3 rounded-xl font-semibold transition shadow-[0_4px_14px_0_rgba(16,185,129,0.39)] disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Process Payment
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        let products = [];
        let cart = [];
        const TAX_RATE = 0.11;

        // Formatter
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        };

        // Fetch products on load
        fetch('../Backend/api_obat.php')
            .then(res => res.json())
            .then(data => {
                products = data;
                renderProducts(products);
            });

        function renderProducts(items) {
            const grid = document.getElementById('productGrid');
            grid.innerHTML = '';
            
            if(items.length === 0) {
                grid.innerHTML = '<div class="col-span-full text-center text-gray-500 py-10">Tidak ada produk ditemukan.</div>';
                return;
            }

            items.forEach(product => {
                // Determine stock status styling
                let stockClass = 'bg-brand-100 text-brand-700';
                let stockText = `Stock: ${product.stock}`;
                let opacityClass = '';
                
                if (product.stock <= 0) {
                    stockClass = 'bg-red-50 text-red-500';
                    stockText = 'Stock: 0';
                    opacityClass = 'opacity-60 cursor-not-allowed';
                } else if (product.stock < 10) {
                    stockClass = 'bg-orange-50 text-orange-500';
                }

                const card = document.createElement('div');
                card.className = `bg-white border border-gray-100 rounded-2xl p-5 text-center flex flex-col h-full shadow-sm hover:shadow-md hover:border-brand-200 transition ${opacityClass}`;
                if (product.stock > 0) {
                    card.onclick = () => addToCart(product);
                    card.classList.add('cursor-pointer');
                }

                card.innerHTML = `
                    <div class="h-28 bg-gray-50 rounded-xl mb-4 flex items-center justify-center text-gray-300">
                        ${product.image_path ? `<img src="../${product.image_path}" class="h-full object-contain mix-blend-multiply"/>` : `<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>`}
                    </div>
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 leading-snug mb-1">${product.nama_obat}</h4>
                            <p class="text-xs text-gray-500 mb-3">${product.nama_kategori || 'Obat'} ${product.deskripsi_kemasan ? '- ' + product.deskripsi_kemasan : ''}</p>
                        </div>
                        <div class="flex items-center justify-between mt-auto">
                            <p class="text-brand-600 font-bold">${formatRupiah(product.harga_jual)}</p>
                            <span class="text-[11px] font-semibold px-2 py-1 rounded-lg ${stockClass}">${stockText}</span>
                        </div>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        // Cart Logic
        function addToCart(product) {
            const existing = cart.find(item => item.kode_obat === product.kode_obat);
            if (existing) {
                if (existing.qty < product.stock) {
                    existing.qty++;
                } else {
                    alert('Stok tidak mencukupi!');
                }
            } else {
                cart.push({ ...product, qty: 1 });
            }
            renderCart();
        }

        function updateQty(kode_obat, change) {
            const item = cart.find(i => i.kode_obat === kode_obat);
            if (item) {
                if (change === 1 && item.qty >= item.stock) {
                    alert('Stok tidak mencukupi!');
                    return;
                }
                item.qty += change;
                if (item.qty <= 0) {
                    cart = cart.filter(i => i.kode_obat !== kode_obat);
                }
            }
            renderCart();
        }

        function clearCart() {
            cart = [];
            renderCart();
        }

        function renderCart() {
            const cartItemsContainer = document.getElementById('cartItems');
            const btnProcess = document.getElementById('processPaymentBtn');
            
            if (cart.length === 0) {
                cartItemsContainer.innerHTML = `
                    <div class="text-center text-gray-400 py-10 flex flex-col items-center">
                        <svg class="w-12 h-12 mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <p class="text-sm">Keranjang kosong</p>
                    </div>`;
                updateSummary(0);
                btnProcess.disabled = true;
                return;
            }

            btnProcess.disabled = false;
            let subtotal = 0;
            let totalItems = 0;
            
            cartItemsContainer.innerHTML = cart.map(item => {
                const itemTotal = item.harga_jual * item.qty;
                subtotal += itemTotal;
                totalItems += item.qty;
                
                return `
                <div class="flex justify-between items-start pb-4 border-b border-gray-100 last:border-0">
                    <div class="pr-2">
                        <p class="font-bold text-sm text-gray-900 leading-tight mb-1">${item.nama_obat}</p>
                        <p class="text-xs text-gray-500 mb-2">${item.deskripsi_kemasan || item.nama_kategori}</p>
                        <div class="flex items-center bg-gray-50 rounded-lg w-max border border-gray-200">
                            <button onclick="updateQty('${item.kode_obat}', -1)" class="w-7 h-7 text-gray-500 hover:text-brand-600 flex items-center justify-center font-medium">&minus;</button>
                            <span class="w-6 text-center text-xs font-bold text-gray-800">${item.qty}</span>
                            <button onclick="updateQty('${item.kode_obat}', 1)" class="w-7 h-7 text-gray-500 hover:text-brand-600 flex items-center justify-center font-medium">&plus;</button>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900 text-sm">${formatRupiah(itemTotal)}</p>
                    </div>
                </div>
                `;
            }).join('');
            
            document.getElementById('cartCount').innerText = totalItems;
            updateSummary(subtotal);
        }

        function updateSummary(subtotal) {
            const tax = subtotal * TAX_RATE;
            const total = subtotal + tax; // ignoring discount for now
            
            document.getElementById('subtotalVal').innerText = formatRupiah(subtotal);
            document.getElementById('taxVal').innerText = formatRupiah(tax);
            document.getElementById('totalVal').innerText = formatRupiah(total);
            
            // Store total for checkout
            window.cartSubtotal = subtotal;
            window.cartTax = tax;
            window.cartTotal = total;
        }

        // Search & Filter
        document.getElementById('searchInput').addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const filtered = products.filter(p => p.nama_obat.toLowerCase().includes(query) || p.kode_obat.toLowerCase().includes(query));
            renderProducts(filtered);
        });

        document.getElementById('categoryFilters').addEventListener('click', (e) => {
            if (e.target.tagName === 'BUTTON') {
                // Update active state
                Array.from(document.getElementById('categoryFilters').children).forEach(btn => {
                    btn.className = "px-5 py-2 bg-gray-50 border border-gray-100 text-gray-600 hover:bg-gray-100 rounded-full text-sm font-medium transition";
                });
                e.target.className = "px-5 py-2 bg-brand-700 text-white rounded-full text-sm font-medium shadow-sm transition";
                
                const cat = e.target.getAttribute('data-category');
                if (cat === 'all') {
                    renderProducts(products);
                } else {
                    const filtered = products.filter(p => p.nama_kategori === cat);
                    renderProducts(filtered);
                }
            }
        });

        document.getElementById('clearCartBtn').addEventListener('click', clearCart);

        // Process Payment
        document.getElementById('processPaymentBtn').addEventListener('click', () => {
            if (cart.length === 0) return;
            
            const btn = document.getElementById('processPaymentBtn');
            btn.innerHTML = 'Processing...';
            btn.disabled = true;

            const payload = {
                items: cart,
                subtotal: window.cartSubtotal,
                tax: window.cartTax,
                discount: 0,
                total_harga: window.cartTotal
            };

            fetch('../Backend/proses_transaksi.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Redirect to Struk
                    window.location.href = `struk.php?no_nota=${data.no_nota}`;
                } else {
                    alert('Gagal: ' + data.message);
                    btn.innerHTML = 'Process Payment';
                    btn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan sistem.');
                btn.innerHTML = 'Process Payment';
                btn.disabled = false;
            });
        });

    </script>
</body>
</html>