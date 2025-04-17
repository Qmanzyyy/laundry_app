<?php 
require_once "./components/function/ubahTambahProdukProccess.php";
?>
<main class="pt-24 md:p-6 px-6 min-h-dvh">
    <div class="bg-white p-4 rounded-lg">
        <h1 class="text-center text-2xl font-bold text-indigo-600">Ubah & Tambah Produk/Paket</h1>
        <form action="" method="post" class="space-y-6">
            <div>
                <label for="Produk" class="block text-gray-600 font-semibold">Produk</label>
                <input type="text" name="Produk" id="Produk" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
                <label for="HargaProduk" class="block text-gray-600 font-semibold">Harga Produk</label>
                <input type="text" name="HargaProduk" id="HargaProduk" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
            </div>
            <div>
                <label for="Paket" class="block text-gray-600 font-semibold">Paket</label>
                <input type="text" name="Paket" id="Paket" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
                <label for="HargaPaket" class="block text-gray-600 font-semibold">Harga Paket</label>
                <input type="text" name="HargaPaket" id="HargaPaket" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
            </div>        
            <div class="mt-6 flex justify-center">
                <button type="submit" name="submit" 
                    class="w-full md:w-1/2 bg-[#211C84] text-white py-3 rounded-lg font-semibold hover:bg-[#1a166b] transition duration-300 shadow-md">
                    Ubah & Tambah
                </button>
            </div>
        </form>
    </div>
</main>