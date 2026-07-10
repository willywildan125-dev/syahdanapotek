<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Kasir</title>
    <link href="./dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans text-gray-800">
    <?php include 'sidebar.php'; ?>
    <main class="ml-64 flex h-screen overflow-hidden">
        
        <!-- Bagian Kiri: Daftar Produk -->
        <div class="flex-1 p-6 overflow-y-auto">
            <div class="mb-6 flex space-x-2">
                <input type="text" placeholder="Search medicines by name, SKU, or scan barcode..." class="w-full border rounded-lg px-4 py-2"> <!-- -->
            </div>
            <div class="flex space-x-2 mb-6 overflow-x-auto">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-full text-sm">All</button> <!-- -->
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-full text-sm">Pain Relief</button> <!-- -->
                <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-full text-sm">Antibiotics</button> <!-- -->
            </div>

            <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
                <!-- Item Produk -->
                <div class="bg-white border rounded-xl p-4 text-center cursor-pointer hover:border-blue-500">
                    <div class="h-20 bg-gray-100 rounded mb-3 flex items-center justify-center">Image</div>
                    <h4 class="font-semibold text-sm">Tetracycline</h4> <!-- -->
                    <p class="text-xs text-gray-500 mb-1">Antibiotic Pot</p>
                    <p class="text-blue-600 font-bold">Rp 44.000</p> <!-- -->
                    <p class="text-xs text-gray-400">Stock: 2</p> <!-- -->
                </div>
                <div class="bg-white border rounded-xl p-4 text-center cursor-pointer hover:border-blue-500">
                    <div class="h-20 bg-gray-100 rounded mb-3 flex items-center justify-center">Image</div>
                    <h4 class="font-semibold text-sm">Polident</h4> <!-- -->
                    <p class="text-xs text-gray-500 mb-1">Denture Care</p>
                    <p class="text-blue-600 font-bold">Rp 12.500</p> <!-- -->
                    <p class="text-xs text-red-500">Stock: 0</p> <!-- -->
                </div>
            </div>
        </div>

        <!-- Bagian Kanan: Current Order -->
        <div class="w-80 bg-white border-l flex flex-col">
            <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-lg">Current Order</h3> <!-- -->
                <button class="text-red-500 text-sm">Clear</button>
            </div>
            
            <!-- List Item di Keranjang -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-semibold text-sm">Paracetamol 500mg</p> <!-- -->
                        <p class="text-xs text-gray-500">2x</p>
                    </div>
                    <p class="font-bold">Rp 30.000</p> <!-- -->
                </div>
            </div>

            <!-- Ringkasan Harga -->
            <div class="p-4 border-t bg-gray-50 space-y-2 text-sm">
                <div class="flex justify-between"><span>Subtotal</span><span>Rp 85.000</span></div> <!-- -->
                <div class="flex justify-between"><span>Tax (PPN 11%)</span><span>Rp 12.650</span></div> <!-- -->
                <div class="flex justify-between text-green-600"><span>Discount</span><span>- Rp 0</span></div> <!-- -->
                <div class="flex justify-between font-bold text-lg pt-2 border-t mt-2">
                    <span>Total Payable</span><span>Rp 127.650</span> <!-- -->
                </div>
                <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold mt-4">Process Payment</button> <!-- -->
            </div>
        </div>
    </main>
</body>
</html>