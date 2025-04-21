<?php 
require_once "./components/function/kasirproses.php";

// Ambil data dari database
$query_jenis = mysqli_query($conn, "SELECT * FROM tb_jenis_cuci");
$query_paket = mysqli_query($conn, "SELECT * FROM tb_paket_cuci");

// Simpan data ke array
$harga_per_item = $nama_jenis_cuci = $harga_paket = $nama_paket = [];

while ($row = mysqli_fetch_assoc($query_jenis)) {
    $harga_per_item[$row['id']] = $row['harga_cuci'];
    $nama_jenis_cuci[$row['id']] = $row['jenis_cuci'];
}

while ($row = mysqli_fetch_assoc($query_paket)) {
    $harga_paket[$row['id']] = $row['harga_paket'];
    $nama_paket[$row['id']] = $row['paket_cuci'];
}

// Input default
$jenis_cuci = $_POST['jenis'] ?? array_key_first($harga_per_item);
$paket      = $_POST['namapaket'] ?? array_key_first($harga_paket);
$qty        = (int) ($_POST['qty'] ?? 1);

$harga = ($harga_per_item[$jenis_cuci] ?? 0) + ($harga_paket[$paket] ?? 0);
$total = $_POST['total'] ?? ($harga * $qty);

$item_name  = ucfirst($nama_jenis_cuci[$jenis_cuci] ?? '');
$paket_name = ucfirst($nama_paket[$paket] ?? '');
?>

<main id="kasir" class="md:p-6 px-6 py-6 min-h-dvh">
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-md p-6">
        <h2 class="text-2xl font-semibold text-blue-600 mb-6 text-center">Form Kasir</h2>
        <form action="" method="POST">
            <!-- Input Pelanggan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="nama" class="block mb-1 font-medium">Nama:</label>
                    <input type="text" name="nama" id="nama" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label for="alamat" class="block mb-1 font-medium">Alamat:</label>
                    <input type="text" name="alamat" id="alamat" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label for="jeniskelamin" class="block mb-1 font-medium">Jenis Kelamin:</label>
                    <select name="jeniskelamin" id="jeniskelamin" required
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                        <option disabled selected>-- Jenis Kelamin --</option>
                        <option value="L">Pria</option>
                        <option value="P">Wanita</option>
                    </select>
                </div>
                <div>
                    <label for="tlp" class="block mb-1 font-medium">Telepon:</label>
                    <input type="text" name="tlp" id="tlp" required pattern="\d+" maxlength="15"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>

            <!-- Jenis Cuci & Paket -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="jenis" class="block mb-1 font-medium">Jenis Cuci:</label>
                    <select name="jenis" id="jenis" required onchange="updateItem()"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                        <option disabled selected>-- Jenis Cuci --</option>
                        <?php foreach ($harga_per_item as $id => $harga): ?>
                            <option value="<?= $id ?>" 
                                data-jeniscuci="<?= $nama_jenis_cuci[$id] ?>" 
                                data-harga="<?= $harga ?>" 
                                <?= $id == $jenis_cuci ? 'selected' : '' ?>>
                                <?= ucfirst($nama_jenis_cuci[$id]) ?> | Rp <?= number_format($harga) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="Paket" class="block mb-1 font-medium">Paket Cuci:</label>
                    <select name="namapaket" id="Paket" required onchange="updateItem()"
                        class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                        <option disabled selected>-- Paket Cuci --</option>
                        <?php foreach ($harga_paket as $id => $harga): ?>
                            <option value="<?= $id ?>" 
                                data-paketcuci="<?= $nama_paket[$id] ?>" 
                                data-harga="<?= $harga ?>" 
                                <?= $id == $paket ? 'selected' : '' ?>>
                                <?= ucfirst($nama_paket[$id]) ?> | Rp <?= number_format($harga) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="md:hidden">
                    <label for="qty-mobile">Qty (kg):</label>
                    <input type="number" id="qty-mobile" name="qty" value="<?= $qty ?>" onchange="updateTotal()"
                        class="w-full px-4 py-2 border rounded-md" />
                </div>
            </div>

            <!-- Tabel Desktop -->
            <div class="overflow-x-auto hidden md:block mb-6">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Item</th>
                            <th class="border px-4 py-2">Paket</th>
                            <th class="border px-4 py-2 text-right">Harga per Item</th>
                            <th class="border px-4 py-2 text-center">Qty (kg)</th>
                            <th class="border px-4 py-2 text-right">Harga Paket</th>
                            <th class="border px-4 py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2" id="item_name"><?= $item_name ?></td>
                            <td class="border px-4 py-2" id="item_paket"><?= $paket_name ?></td>
                            <td class="border px-4 py-2 text-right" id="item_price">Rp <?= number_format($harga_per_item[$jenis_cuci]) ?></td>
                            <td class="border px-4 py-2 text-center">
                                <input type="number" id="qty" name="qty" value="<?= $qty ?>" onchange="updateTotal()"
                                    class="w-full px-4 py-2 border rounded-md" />
                            </td>
                            <td class="border px-4 py-2 text-right" id="paket_price">Rp <?= number_format($harga_paket[$paket]) ?></td>
                            <td class="border px-4 py-2 text-right">
                                <input type="text" id="total" value="Rp <?= number_format($total) ?>" readonly
                                    class="w-full px-4 py-2 border rounded-md" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tampilan Mobile -->
            <div class="md:hidden bg-gray-100 p-4 rounded-md space-y-2">
                <p><strong>Item:</strong> <span id="mobile_item_name"><?= $item_name ?></span></p>
                <p><strong>Paket:</strong> <span id="mobile_item_paket"><?= $paket_name ?></span></p>
                <p><strong>Harga per Item:</strong> <span id="mobile_item_price">Rp <?= number_format($harga_per_item[$jenis_cuci]) ?></span></p>
                <p><strong>Qty (kg):</strong> <span id="mobile_qty"><?= $qty ?></span></p>
                <p><strong>Harga Paket:</strong> <span id="mobile_paket_price">Rp <?= number_format($harga_paket[$paket]) ?></span></p>
                <p><strong>Total:</strong> <span id="mobile_total">Rp <?= number_format($total) ?></span></p>
            </div>

            <!-- Tombol Submit -->
            <div class="flex flex-col md:flex-row justify-between items-center mt-6 space-y-4 md:space-y-0">
                <button type="submit" name="submit"
                    class="bg-blue-600 text-white font-medium py-2 px-6 rounded-md hover:bg-blue-600 shadow-md">
                    Proses Pembayaran
                </button>
            </div>

            <!-- Hidden Total -->
            <input type="hidden" name="total" id="hidden_total" value="<?= $total ?>">
        </form>
    </div>
</main>

<script>
function updateItem() {
    const jenisSelect = document.getElementById('jenis');
    const paketSelect = document.getElementById('Paket');

    const selectedJenis = jenisSelect.options[jenisSelect.selectedIndex];
    const selectedPaket = paketSelect.options[paketSelect.selectedIndex];

    const hargaItem = parseInt(selectedJenis.dataset.harga || 0);
    const itemName = selectedJenis.dataset.jeniscuci || '';
    const hargaPaket = parseInt(selectedPaket.dataset.harga || 0);
    const paketName = selectedPaket.dataset.paketcuci || '';

    // Desktop
    document.getElementById('item_name').textContent = itemName;
    document.getElementById('item_price').textContent = 'Rp ' + hargaItem.toLocaleString('id-ID');
    document.getElementById('item_paket').textContent = paketName;
    document.getElementById('paket_price').textContent = 'Rp ' + hargaPaket.toLocaleString('id-ID');

    // Mobile
    document.getElementById('mobile_item_name').textContent = itemName;
    document.getElementById('mobile_item_price').textContent = 'Rp ' + hargaItem.toLocaleString('id-ID');
    document.getElementById('mobile_item_paket').textContent = paketName;
    document.getElementById('mobile_paket_price').textContent = 'Rp ' + hargaPaket.toLocaleString('id-ID');

    updateTotal();
}

function updateTotal() {
    const jenisSelect = document.getElementById('jenis');
    const paketSelect = document.getElementById('Paket');

    const hargaItem = parseInt(jenisSelect.options[jenisSelect.selectedIndex].dataset.harga || 0);
    const hargaPaket = parseInt(paketSelect.options[paketSelect.selectedIndex].dataset.harga || 0);

    const qtyInput = window.innerWidth <= 768 ? document.getElementById('qty-mobile') : document.getElementById('qty');
    const qty = parseInt(qtyInput.value) || 1;

    const total = (hargaItem + hargaPaket) * qty;

    document.getElementById('total').value = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('hidden_total').value = total;
    document.getElementById('mobile_total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    if (window.innerWidth <= 768) {
        document.getElementById('mobile_qty').textContent = qty;
    }
}
</script>
