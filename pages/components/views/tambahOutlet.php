<?php 
require_once "./components/function/tambahOutletProcces.php";
?>
<main id="kasir" class="pt-24 md:p-6 px-6 bg-gray-50 min-h-screen">
    <div class="max-w-md mx-auto bg-white shadow-xl rounded-2xl p-6 space-y-5">
        <h2 class="text-2xl font-semibold text-center text-indigo-600">Tambah Outlet</h2>
        <form action="" method="post" class="space-y-4">
            <div>
                <label for="nama" class="block mb-1 text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="nama" name="nama" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
            </div>

            <div>
                <label for="alamat" class="block mb-1 text-sm font-medium text-gray-700">Alamat</label>
                <input type="text" id="alamat" name="alamat" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
            </div>

            <div>
                <label for="tlp" class="block mb-1 text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input type="tel" id="tlp" name="tlp" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:outline-none" />
            </div>

            <button type="submit" name="submit"
                    class="w-full bg-indigo-600 text-white font-semibold py-2 rounded-lg hover:bg-indigo-700 transition">
                Buat!
            </button>
        </form>
    </div>
</main>
