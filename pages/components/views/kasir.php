<?php 
    require_once "./components/function/kasirproses.php";

    // Default harga untuk setiap jenis cucian
    $harga_per_item = [
        '----' => 0,
        'kiloan' => 10000,
        'selimut' => 25000,
        'bed_cover' => 30000,
        'kaos' => 15000,
        'lain' => 20000
    ];

    // Harga untuk paket cuci
    $harga_paket = [
        'reguler' => 0,
        'Express' => 10000,
        'Premium' => 15000
    ];

    // Cek jika jenis cucian dipilih
    $jenis_cuci = isset($_POST['jenis']) ? $_POST['jenis'] : '----'; // Default jenis 'kiloan'
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1; // Default quantity 1
    $paket = isset($_POST['namapaket']) ? $_POST['namapaket'] : 'reguler'; // Default paket 'reguler'
    $harga = $harga_per_item[$jenis_cuci] + $harga_paket[$paket]; // Harga total per item ditambah paket
    $total = isset($_POST['total']) ? (int)$_POST['total'] : ($harga * $qty); // Tangkap total dari input tersembunyi
    $item_name = ucfirst($jenis_cuci); // Nama item berdasarkan jenis
?>
<main id="kasir" class="pt-24 md:p-6 px-6 bg-gray-50 min-h-screen">
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
            <div class="overflow-x-auto mb-6">
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
                                <input type="number" id="qty" name="jumlah" value="<?php echo $qty; ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md" onchange="updateTotal()">
                            </td>
                            <td class="border px-4 py-2 text-right" id="paket_price">Rp <?php echo number_format($harga_paket[$paket], 0, ',', '.'); ?></td>
                            <td class="border px-4 py-2 text-right">
                                <input type="text" id="total" value="Rp <?php echo number_format($total, 0, ',', '.'); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Subtotal dan Tombol -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                <!-- <div class="text-center md:text-left">
                    <p class="text-gray-700">Sub Total: Rp <span id="subtotal"><?php echo number_format($total, 0, ',', '.'); ?></span></p>
                    <p class="text-gray-700">Diskon: Rp 0</p>
                    <p class="font-semibold text-gray-800">Grand Total: Rp <span id="grandtotal"><?php echo number_format($total, 0, ',', '.'); ?></span></p>
                </div> -->
                <button type="submit" name="submit" 
                    class="bg-blue-500 text-white font-medium py-2 px-6 rounded-md hover:bg-blue-600 shadow-md">
                    Proses Pembayaran
                </button>
            </div>

            <!-- Input tersembunyi untuk total -->
            <input type="hidden" name="harga" id="hidden_total" value="<?php echo $total; ?>">
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
    var paket = {
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
    document.getElementById('item_paket').textContent = paketValue.charAt(0).toUpperCase() + paketValue.slice(1); // Capitalize the first letter
    document.getElementById('paket_price').textContent = 'Rp ' + paket[paketValue].toLocaleString('id-ID');

    // Memperbarui total setelah perubahan jenis cucian
    updateTotal(); // Memanggil updateTotal agar total harga dan format ribuan terupdate
}

// Fungsi untuk memperbarui total harga secara langsung
function updateTotal() {
    var qty = parseInt(document.getElementById('qty').value); // Mengambil nilai quantity
    var hargaPerItem = parseInt(document.getElementById('item_price').textContent.replace('Rp ', '').replace('.', ''));

    var paket = document.getElementById('Paket').value;
    var paketHarga = {
        'reguler': 0,
        'Express': 10000,
        'Premium': 15000
    };

    var hargaPaket = paketHarga[paket];
    var total = (hargaPerItem + hargaPaket) *qty;

    // Memperbarui total harga di input readonly
    document.getElementById('total').value = 'Rp ' + total.toLocaleString('id-ID');

    // Memperbarui subtotal dan grandtotal
    var subtotal = total; // Untuk saat ini subtotal sama dengan total
    var grandTotal = subtotal; // Jika ada diskon, bisa ditambahkan disini

    // Memperbarui tampilan
    document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('grandtotal').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
    document.getElementById('hidden_total').value = total; // Menyimpan total di hidden input
}
</script>
