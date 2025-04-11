<?php 
    require_once "./components/function/kasirproses.php";

    // Default harga untuk setiap jenis cucian
    $harga_per_item = [
        'kiloan'   => 10000,
        'selimut'  => 25000,
        'bed_cover'=> 30000,
        'kaos'     => 15000,
        'lain'     => 20000
    ];

    // Harga untuk paket cuci
    $harga_paket = [
        'reguler' => 0,
        'Express' => 10000,
        'Premium' => 15000
    ];

    // Cek jika jenis cucian dipilih (default menggunakan 'kiloan')
    $jenis_cuci = isset($_POST['jenis']) ? $_POST['jenis'] : 'kiloan';
    $qty        = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
    $paket      = isset($_POST['namapaket']) ? $_POST['namapaket'] : 'reguler';
    $harga      = $harga_per_item[$jenis_cuci] + $harga_paket[$paket];
    // Ambil total dari input form jika tersedia, atau hitung dari harga dan quantity
    $total      = isset($_POST['total']) ? (int)$_POST['total'] : ($harga * $qty);
    $item_name  = ucfirst($jenis_cuci); 
?>
<main id="kasir" class="pt-24 md:p-6 px-6 min-h-screen">
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-2 text-center">Form Transaksi</h2>
        <hr class="mb-6">
        
        <!-- Form Input -->
        <form action="" method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nama -->
                <div class="mb-4">
                    <label for="nama" class="block mb-1 text-gray-700 font-medium">Nama:</label>
                    <input type="text" name="nama" id="nama" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                        required>
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamat" class="block mb-1 text-gray-700 font-medium">Alamat:</label>
                    <input type="text" name="alamat" id="alamat" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                        required>
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-4">
                    <label for="jeniskelamin" class="block mb-1 text-gray-700 font-medium">Jenis Kelamin:</label>
                    <select name="jeniskelamin" id="jeniskelamin" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                        required>
                        <option disabled selected>-- Jenis Kelamin --</option>
                        <option value="L">Pria</option>
                        <option value="P">Wanita</option>
                    </select>
                </div>

                <!-- Telepon -->
                <div class="mb-4">
                    <label for="tlp" class="block mb-1 text-gray-700 font-medium">Telepon:</label>
                    <input type="text" name="tlp" id="tlp" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                        required pattern="\d+" maxlength="15">
                </div>
            </div>

            <!-- Jenis Cuci dan Paket -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="jenis" class="block mb-1 text-gray-700 font-medium">Jenis Cuci:</label>
                    <select name="jenis" id="jenis" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                        onchange="updateItem()" required>
                        <option disabled selected>-- Jenis Cuci --</option>
                        <option value="kiloan">Kiloan</option>
                        <option value="selimut">Selimut</option>
                        <option value="bed_cover">Bed Cover</option>
                        <option value="kaos">Kaos</option>
                        <option value="lain">Lain-lain</option>
                    </select>
                </div>

                <div>
                    <label for="Paket" class="block mb-1 text-gray-700 font-medium">Paket Cuci:</label>
                    <select name="namapaket" id="Paket" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                        onchange="updateItem()" required>
                        <option disabled selected>-- Paket --</option>
                        <option value="reguler">Reguler</option>
                        <option value="Express">Express</option>
                        <option value="Premium">Premium</option>
                    </select>
                </div>
            </div>
            <!-- Tabel Transaksi (Responsif) -->
            <div class="overflow-x-auto mb-6 hidden md:block">
                <table class="min-w-full border-collapse border border-gray-300 table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2 text-left">Item</th>
                            <th class="border px-4 py-2 text-left">Paket</th>
                            <th class="border px-4 py-2 text-right">Harga per Item</th>
                            <th class="border px-4 py-2 text-center">Qty (kg)</th>
                            <th class="border px-4 py-2 text-right">Harga Paket</th>
                            <th class="border px-4 py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2" id="item_name"><?php echo $item_name; ?></td>
                            <td class="border px-4 py-2 text-left" id="item_paket">Reguler</td>
                            <td class="border px-4 py-2 text-right" id="item_price">Rp <?php echo number_format($harga_per_item[$jenis_cuci], 0, ',', '.'); ?></td>
                            <td class="border px-4 py-2 text-center">
                                <input type="number" id="qty" name="qty" value="<?php echo $qty; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md" onchange="updateTotal()">
                            </td>
                            <td class="border px-4 py-2 text-right" id="paket_price">Rp <?php echo number_format($harga_paket[$paket], 0, ',', '.'); ?></td>
                            <td class="border px-4 py-2 text-right">
                                <input type="text" id="total" value="Rp <?php echo number_format($total, 0, ',', '.'); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="md:hidden">
                <ul>
                    <li>Item:</li>
                    <li>Paket:</li>
                    <li>Harga PerItem:</li>
                    <li>Harga per Item:</li>
                    <li>Qty (kg):</li>
                    <li>Harga Paket:</li>
                    <li>Total:</li>
                </ul>
            </div>

            <!-- Subtotal dan Tombol -->
            <!-- Bagian subtotal/grandtotal dapat diaktifkan bila diperlukan -->
            <!--
            <div class="text-center md:text-left mb-6">
                <p class="text-gray-700">Sub Total: Rp <span id="subtotal"><?php echo number_format($total, 0, ',', '.'); ?></span></p>
                <p class="text-gray-700">Diskon: Rp 0</p>
                <p class="font-semibold text-gray-800">Grand Total: Rp <span id="grandtotal"><?php echo number_format($total, 0, ',', '.'); ?></span></p>
            </div>
            -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                <button type="submit" name="submit" 
                    class="bg-blue-500 text-white font-medium py-2 px-6 rounded-md hover:bg-blue-600 shadow-md">
                    Proses Pembayaran
                </button>
            </div>

            <!-- Input tersembunyi untuk total -->
            <input type="hidden" name="total" id="hidden_total" value="<?php echo $total; ?>">
        </form>
    </div>
</main>

<script>
// Fungsi untuk memperbarui item dan paket berdasarkan jenis cucian
function updateItem() {
    var jenisCuci = document.getElementById('jenis').value;
    var hargaPerItem = {
        'kiloan': 10000,
        'selimut': 25000,
        'bed_cover': 30000,
        'kaos': 15000,
        'lain': 20000
    };
    var paketHarga = {
        'reguler' : 0,
        'Express' : 10000,
        'Premium' : 15000
    };
    var itemNames = {
        'kiloan': 'Kiloan',
        'selimut': 'Selimut',
        'bed_cover': 'Bed Cover',
        'kaos': 'Kaos',
        'lain': 'Lain-lain'
    };

    var harga = hargaPerItem[jenisCuci];
    var itemName = itemNames[jenisCuci];
    var paketValue = document.getElementById('Paket').value;
    
    // Memperbarui nama item dan harga
    document.getElementById('item_name').textContent = itemName;
    document.getElementById('item_price').textContent = 'Rp ' + harga.toLocaleString('id-ID');

    // Memperbarui paket di tabel
    document.getElementById('item_paket').textContent = paketValue.charAt(0).toUpperCase() + paketValue.slice(1);
    document.getElementById('paket_price').textContent = 'Rp ' + paketHarga[paketValue].toLocaleString('id-ID');

    // Memperbarui total setelah perubahan jenis cucian atau paket
    updateTotal();
}

// Fungsi untuk memperbarui total harga secara langsung
function updateTotal() {
    var jenisCuci = document.getElementById('jenis').value;
    var paketValue = document.getElementById('Paket').value;
    var qty = parseInt(document.getElementById('qty').value) || 0;

    var hargaPerItem = {
        'kiloan': 10000,
        'selimut': 25000,
        'bed_cover': 30000,
        'kaos': 15000,
        'lain': 20000
    };
    var paketHarga = {
        'reguler': 0,
        'Express': 10000,
        'Premium': 15000
    };

    var total = (hargaPerItem[jenisCuci] + paketHarga[paketValue]) * qty;

    // Update tampilan total di input dan juga hidden input
    document.getElementById('total').value = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('hidden_total').value = total;
}

</script>
