<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Syahdan - Pembayaran Berhasil</title>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans text-gray-800 flex items-center justify-center h-screen">
    
    <div class="bg-white rounded-2xl border border-gray-200 shadow-xl w-[400px] p-8 text-center">
        
        <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-1">Pembayaran Berhasil!</h2>
        <p class="text-sm text-gray-500 mb-6">Transaksi #TXN-88921 telah selesai diproses.</p>

        <div class="bg-white border border-dashed border-gray-300 p-5 text-left text-sm mb-6 rounded-lg shadow-[inset_0_0_8px_rgba(0,0,0,0.02)] relative">
            <div class="text-center border-b border-dashed border-gray-300 pb-4 mb-4">
                <h3 class="font-bold text-lg text-gray-900 tracking-wide">APOTEK SYAHDAN</h3>
                <p class="text-xs text-gray-500 mt-1">Jl. Syahdan No. 01, Jakarta</p>
                <p class="text-xs text-gray-500">Tel: (021) 555-0192</p>
            </div>
            
            <div class="flex justify-between text-xs text-gray-500 mb-4 font-medium">
                <span>No: #TXN-88921</span>
                <span>24 Nov 2023, 14:30</span>
            </div>

            <div class="space-y-3 mb-4 text-gray-800">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-semibold">Panadol Extra</p>
                        <p class="text-xs text-gray-500">2 x Rp 12.500</p>
                    </div>
                    <p class="font-medium mt-0.5">Rp 25.000</p>
                </div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-semibold">Amoxicillin 500mg</p>
                        <p class="text-xs text-gray-500">1 x Rp 15.000</p>
                    </div>
                    <p class="font-medium mt-0.5">Rp 15.000</p>
                </div>
            </div>

            <div class="border-t border-dashed border-gray-300 pt-3 space-y-1.5 text-gray-600">
                <div class="flex justify-between"><span>Subtotal</span><span class="font-medium text-gray-800">Rp 40.000</span></div>
                <div class="flex justify-between"><span>Tax (PPN 11%)</span><span class="font-medium text-gray-800">Rp 4.400</span></div>
                <div class="flex justify-between text-lg font-bold mt-2 pt-3 border-t border-gray-300 text-gray-900">
                    <span>TOTAL</span><span>Rp 44.400</span>
                </div>
                <div class="flex justify-between pt-2"><span>Tunai</span><span class="font-medium text-gray-800">Rp 50.000</span></div>
                <div class="flex justify-between"><span>Kembali</span><span class="font-medium text-gray-800">Rp 5.600</span></div>
            </div>
            
            <div class="text-center text-xs text-gray-500 mt-6 italic">
                Semoga lekas sembuh! <br>
                Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.
            </div>
        </div>

        <div class="space-y-3">
            <a href="kasir.php" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-medium transition shadow-sm">+ Transaksi Baru</a>
            <button class="w-full border border-gray-300 hover:bg-gray-50 text-gray-700 py-2.5 rounded-lg font-medium transition">Print Receipt</button>
        </div>
    </div>
</body>
</html>