<?php 
require_once "./components/function/kasirproses.php";

// Ambil data dari database
$query_jenis = mysqli_query($conn, "SELECT * FROM tb_jenis_cuci");
$query_paket = mysqli_query($conn, "SELECT * FROM tb_paket_cuci");

// Simpan data ke array
$harga_per_item = $nama_jenis_cuci = $harga_paket = $nama_paket = [];

while ($row = mysqli_fetch_assoc($query_jenis)) {
    $harga_per_item[$row['id']] = (int) $row['harga_cuci'];
    $nama_jenis_cuci[$row['id']] = $row['jenis_cuci'];
}

while ($row = mysqli_fetch_assoc($query_paket)) {
    $harga_paket[$row['id']] = (int) $row['harga_paket'];
    $nama_paket[$row['id']] = $row['paket_cuci'];
}

// Fungsi fallback array key pertama
function get_first_key($array) {
    foreach ($array as $key => $val) return $key;
    return null;
}

// Input default (gunakan fallback jika PHP < 7.3)
$jenis_cuci = $_POST['jenis'] ?? get_first_key($harga_per_item);
$paket      = $_POST['namapaket'] ?? get_first_key($harga_paket);
$qty        = isset($_POST['qty']) ? (int) preg_replace('/[^\d]/', '', $_POST['qty']) : 1;

// Hitung harga
$harga_item  = $harga_per_item[$jenis_cuci] ?? 0;
$harga_pkt   = $harga_paket[$paket] ?? 0;
$harga_total = ($harga_item + $harga_pkt) * $qty;

$total       = isset($_POST['total']) 
    ? (int) preg_replace('/[^\d]/', '', $_POST['total']) 
    : $harga_total;

// Nama item
$item_name  = ucfirst($nama_jenis_cuci[$jenis_cuci] ?? 'Tidak Diketahui');
$paket_name = ucfirst($nama_paket[$paket] ?? 'Tidak Diketahui');
?>

<!-- HTML FORM DAN JS -->
<main id="kasir" class="md:p-6 px-6 py-6 min-h-dvh">
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-md p-6">
        <h2 class="text-2xl font-semibold text-blue-600 mb-6 text-center">Form Kasir</h2>
        <form action="" method="POST">
            <!-- Input Pelanggan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="nama" class="block mb-1 font-medium">Nama:</label>
                    <input type="text" name="nama" id="nama" required class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label for="alamat" class="block mb-1 font-medium">Alamat:</label>
                    <input type="text" name="alamat" id="alamat" required class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label for="jeniskelamin" class="block mb-1 font-medium">Jenis Kelamin:</label>
                    <select name="jeniskelamin" id="jeniskelamin" required class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                        <option disabled selected>-- Jenis Kelamin --</option>
                        <option value="L">Pria</option>
                        <option value="P">Wanita</option>
                    </select>
                </div>
                <div>
                    <label for="tlp" class="block mb-1 font-medium">Telepon:</label>
                    <input type="text" name="tlp" id="tlp" required pattern="\d+" maxlength="15" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>

            <!-- Jenis Cuci & Paket -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="jenis" class="block mb-1 font-medium">Jenis Cuci:</label>
                    <select name="jenis" id="jenis" required onchange="updateItem()" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                        <?php foreach ($harga_per_item as $id => $harga): ?>
                        <option value="<?= $id ?>" data-jeniscuci="<?= $nama_jenis_cuci[$id] ?>" data-harga="<?= $harga ?>" <?= $id == $jenis_cuci ? 'selected' : '' ?>>
                            <?= ucfirst($nama_jenis_cuci[$id]) ?> | Rp <?= number_format($harga) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="Paket" class="block mb-1 font-medium">Paket Cuci:</label>
                    <select name="namapaket" id="Paket" required onchange="updateItem()" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                        <?php foreach ($harga_paket as $id => $harga): ?>
                        <option value="<?= $id ?>" data-paketcuci="<?= $nama_paket[$id] ?>" data-harga="<?= $harga ?>" <?= $id == $paket ? 'selected' : '' ?>>
                            <?= ucfirst($nama_paket[$id]) ?> | Rp <?= number_format($harga) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="md:hidden">
                    <label for="qty-mobile">Qty (kg):</label>
                    <input type="number" id="qty-mobile" name="qty" value="<?= $qty ?>" onchange="updateTotal()" class="w-full px-4 py-2 border rounded-md" />
                </div>
            </div>

            <!-- Metode Bayar -->
            <div class="mb-6">
                <label for="caraBayar" class="block mb-1 font-medium">Cara Bayar</label>
                <select name="carabayar" id="caraBayar" required class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="COD">COD</option>
                    <option value="CASH">Cash</option>
                </select>
            </div>

            <!-- Input Bayar jika Cash -->
            <div class="mb-6" id="Cash"></div>

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
                            <th class="border px-4 py-2 text-right">Total Belanja</th>
                            <th class="border px-4 py-2 text-right">Bayar</th>
                            <th class="border px-4 py-2 text-right">Kembalian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2" id="item_name"><?= $item_name ?></td>
                            <td class="border px-4 py-2" id="item_paket"><?= $paket_name ?></td>
                            <td class="border px-4 py-2 text-right" id="item_price">Rp <?= number_format($harga_item) ?></td>
                            <td class="border px-4 py-2 text-center">
                                <input type="number" id="qty" name="qty" value="<?= $qty ?>" onchange="updateTotal()" class="w-full px-2 py-1 border rounded-md" />
                            </td>
                            <td class="border px-4 py-2 text-right" id="paket_price">Rp <?= number_format($harga_pkt) ?></td>
                            <td class="border px-4 py-2 text-right">
                                <input type="text" id="total" value="Rp <?= number_format($total) ?>" readonly class="w-full px-2 py-1 border rounded-md" />
                            </td>
                            <td class="border px-4 py-2 text-right" id="bayar_td">
                                <span id="dekstop_bayar">Rp 0</span>
                            </td>
                            <td class="border px-4 py-2 text-right">
                                <input type="text" id="kembalian" readonly class="w-full px-2 py-1 border rounded-md" />
                                <input type="hidden" id="hidden_kembalian" name="kembalian" readonly class="w-full px-2 py-1 border rounded-md" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile View -->
            <div class="md:hidden bg-gray-100 p-4 rounded-md space-y-2">
                <p><strong>Item:</strong> <span id="mobile_item_name"><?= $item_name ?></span></p>
                <p><strong>Paket:</strong> <span id="mobile_item_paket"><?= $paket_name ?></span></p>
                <p><strong>Harga per Item:</strong> <span id="mobile_item_price">Rp <?= number_format($harga_item) ?></span></p>
                <p><strong>Qty (kg):</strong> <span id="mobile_qty"><?= $qty ?></span></p>
                <p><strong>Harga Paket:</strong> <span id="mobile_paket_price">Rp <?= number_format($harga_pkt) ?></span></p>
                <p><strong>Total Belanja:</strong> <span id="mobile_total">Rp <?= number_format($total) ?></span></p>
                <p><strong>Dibayar:</strong> <span id="mobile_bayar">-</span></p>
                <p><strong>Kembalian:</strong> <span id="mobile_kembalian">Rp 0</span></p>
            </div>

            <!-- Submit -->
            <div class="flex flex-col md:flex-row justify-between items-center mt-6 space-y-4 md:space-y-0">
                <button type="submit" name="submit" class="bg-blue-600 text-white font-medium py-2 px-6 rounded-md hover:bg-blue-700 shadow-md">
                    Proses Pembayaran
                </button>
            </div>

            <input type="hidden" name="total" id="hidden_total" value="<?= $total ?>">
        </form>
    </div>
</main>

<script>
// Fungsi untuk membersihkan format Rupiah
function cleanRupiah(rp) {
    return parseInt(rp.replace(/[^\d]/g, '')) || 0;
}

// Fungsi untuk memperbarui item dan total
function updateItem() {
    const jenis = document.getElementById('jenis');
    const paket = document.getElementById('Paket');

    const jenisHarga = parseInt(jenis.selectedOptions[0].dataset.harga || 0);
    const jenisNama = jenis.selectedOptions[0].dataset.jeniscuci || '';
    const paketHarga = parseInt(paket.selectedOptions[0].dataset.harga || 0);
    const paketNama = paket.selectedOptions[0].dataset.paketcuci || '';

    document.getElementById('item_name').textContent = jenisNama;
    document.getElementById('item_price').textContent = 'Rp ' + jenisHarga.toLocaleString('id-ID');
    document.getElementById('item_paket').textContent = paketNama;
    document.getElementById('paket_price').textContent = 'Rp ' + paketHarga.toLocaleString('id-ID');

    document.getElementById('mobile_item_name').textContent = jenisNama;
    document.getElementById('mobile_item_price').textContent = 'Rp ' + jenisHarga.toLocaleString('id-ID');
    document.getElementById('mobile_item_paket').textContent = paketNama;
    document.getElementById('mobile_paket_price').textContent = 'Rp ' + paketHarga.toLocaleString('id-ID');

    updateTotal();
}

// Fungsi untuk memperbarui total
function updateTotal() {
    const jenis = document.getElementById('jenis');
    const paket = document.getElementById('Paket');
    const qty = parseInt((document.getElementById('qty') || document.getElementById('qty-mobile')).value) || 1;

    const total = (parseInt(jenis.selectedOptions[0].dataset.harga || 0) + parseInt(paket.selectedOptions[0].dataset.harga || 0)) * qty;

    document.getElementById('total').value = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('hidden_total').value = total;
    document.getElementById('mobile_total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('mobile_qty').textContent = qty;

    hitungKembalian();
}

// Fungsi untuk menghitung kembalian
function hitungKembalian() {
    const total = cleanRupiah(document.getElementById('total').value);
    const bayarInput = document.getElementById('bayar');
    const bayar = bayarInput ? parseInt(bayarInput.value || 0) : 0;
    const kembalian = bayar - total;

    document.getElementById('kembalian').value = 'Rp ' + Math.max(kembalian, 0).toLocaleString('id-ID');
    document.getElementById('hidden_kembalian').value = kembalian;
    document.getElementById('mobile_kembalian').textContent = 'Rp ' + Math.max(kembalian, 0).toLocaleString('id-ID');
    document.getElementById('mobile_bayar').textContent = 'Rp ' + bayar.toLocaleString('id-ID');
    document.getElementById('dekstop_bayar').textContent = 'Rp ' + bayar.toLocaleString('id-ID');
}

// Tampilkan input bayar jika metode Cash
document.getElementById('caraBayar').addEventListener('change', function () {
    const metode = this.value;
    const cashDiv = document.getElementById('Cash');

    if (metode === 'CASH') {
        cashDiv.innerHTML = `
            <label for="bayar" class="block mb-1 font-medium">Bayar:</label>
            <input type="number" id="bayar" name="bayar" onchange="hitungKembalian()" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" />
        `;
    } else {
        cashDiv.innerHTML = '';
        document.getElementById('kembalian').value = 'Rp 0';
        document.getElementById('mobile_kembalian').textContent = 'Rp 0';
    }
});
</script>
