<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Kasir</title>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <?php include 'sidebar.php'; ?>
    <main class="ml-64 flex h-screen overflow-hidden">
        
        <div class="flex-1 p-6 overflow-y-auto">
            <div class="mb-6 relative">
                <input type="text" placeholder="Search medicines by name, SKU, or scan barcode..." class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-3 outline-none focus:border-blue-500 shadow-sm">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            
            <div class="flex space-x-2 mb-6 overflow-x-auto pb-2">
                <button class="px-5 py-2 bg-blue-600 text-white rounded-full text-sm font-medium shadow-sm">All</button>
                <button class="px-5 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-full text-sm font-medium">Pain Relief</button>
                <button class="px-5 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-full text-sm font-medium">Antibiotics</button>
                <button class="px-5 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-full text-sm font-medium">Vitamins</button>
                <button class="px-5 py-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-full text-sm font-medium">First Aid</button>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div class="bg-white border border-gray-200 rounded-xl p-4 text-center cursor-pointer hover:border-blue-500 hover:shadow-md transition">
                    <div class="h-24 bg-gray-100 rounded-lg mb-3 flex items-center justify-center text-gray-400 text-xs">Image</div>
                    <h4 class="font-semibold text-sm text-gray-800">Tetracycline</h4>
                    <p class="text-xs text-gray-500 mb-2">Antibiotic Pot</p>
                    <p class="text-blue-600 font-bold">Rp 44.000</p>
                    <p class="text-xs text-gray-500 mt-1">Stock: <span class="font-medium">2</span></p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 text-center cursor-pointer opacity-70">
                    <div class="h-24 bg-gray-100 rounded-lg mb-3 flex items-center justify-center text-gray-400 text-xs">Image</div>
                    <h4 class="font-semibold text-sm text-gray-800">Polident</h4>
                    <p class="text-xs text-gray-500 mb-2">Denture Care</p>
                    <p class="text-blue-600 font-bold">Rp 12.500</p>
                    <p class="text-xs text-red-500 font-medium mt-1">Stock: 0</p>
                </div>
                <div class="bg-white border border-gray-200 rounded-xl p-4 text-center cursor-pointer hover:border-blue-500 hover:shadow-md transition">
                    <div class="h-24 bg-gray-100 rounded-lg mb-3 flex items-center justify-center text-gray-400 text-xs">Image</div>
                    <h4 class="font-semibold text-sm text-gray-800">Paracetamol 500mg</h4>
                    <p class="text-xs text-gray-500 mb-2">Pain Relief</p>
                    <p class="text-blue-600 font-bold">Rp 15.000</p>
                    <p class="text-xs text-gray-500 mt-1">Stock: <span class="font-medium">120</span></p>
                </div>
            </div>
        </div>

        <div class="w-80 bg-white border-l border-gray-200 flex flex-col shadow-sm z-10">
            <div class="p-5 border-b border-gray-200 flex justify-between items-center bg-white">
                <h3 class="font-bold text-gray-800 text-lg">Current Order</h3>
                <button class="text-red-500 text-sm font-medium hover:text-red-700">Clear</button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-5 space-y-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-semibold text-sm text-gray-800">Paracetamol 500mg</p>
                        <div class="flex items-center mt-1">
                            <button class="w-6 h-6 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center text-xs hover:bg-gray-200">-</button>
                            <span class="mx-3 text-sm font-medium">2</span>
                            <button class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs hover:bg-blue-100">+</button>
                        </div>
                    </div>
                    <p class="font-bold text-gray-900">Rp 30.000</p>
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-semibold text-sm text-gray-800">Vitamin C 1000mg</p>
                        <div class="flex items-center mt-1">
                            <button class="w-6 h-6 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center text-xs hover:bg-gray-200">-</button>
                            <span class="mx-3 text-sm font-medium">1</span>
                            <button class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs hover:bg-blue-100">+</button>
                        </div>
                    </div>
                    <p class="font-bold text-gray-900">Rp 55.000</p>
                </div>
            </div>

            <div class="p-5 border-t border-gray-200 bg-gray-50">
                <div class="flex mb-4">
                    <input type="text" placeholder="Promo code..." class="w-full border border-gray-300 rounded-l-lg px-3 py-2 text-sm outline-none">
                    <button class="bg-gray-800 text-white px-4 py-2 rounded-r-lg text-sm font-medium">Apply</button>
                </div>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between"><span>Subtotal (3 items)</span><span class="font-medium text-gray-900">Rp 85.000</span></div>
                    <div class="flex justify-between"><span>Tax (PPN 11%)</span><span class="font-medium text-gray-900">Rp 12.650</span></div>
                    <div class="flex justify-between text-green-600"><span>Discount</span><span class="font-medium">- Rp 0</span></div>
                    <div class="flex justify-between font-bold text-lg pt-3 border-t border-gray-200 mt-2 text-gray-900">
                        <span>Total Payable</span><span>Rp 127.650</span>
                    </div>
                </div>
                <a href="struk.php" class="block text-center w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-bold mt-5 transition shadow-sm">
                    Process Payment
                </a>
            </div>
        </div>
    </main>
</body>
</html>