<?php
require_once "./components/function/editJenisCuci.php";
require_once "./components/function/ubahTambahProdukProccess.php";

// Query untuk mengambil semua data paket cuci
$query = "
SELECT * FROM tb_paket_cuci
";

$result = mysqli_query($conn, $query);

$dataTransaksi = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataTransaksi[] = $row;
}
?>

<main class="p-6 min-h-dvh">
  <div class="max-w-5xl mx-auto p-6">
    <h1 class="md:text-3xl text-xl font-bold text-center text-blue-600 mb-10">Kelola Paket</h1>
    <div class="flex mb-5">
      <button class="hover:bg-blue-700 flex items-center text-xs md:text-base mr-2 bg-blue-600 text-white p-2 font-bold rounded-lg mb-3">
        <svg class="md:w-6 md:h-6 w-3 h-3 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
          <path fill-rule="evenodd" d="M9.586 2.586A2 2 0 0 1 11 2h2a2 2 0 0 1 2 2v.089l.473.196.063-.063a2.002 2.002 0 0 1 2.828 0l1.414 1.414a2 2 0 0 1 0 2.827l-.063.064.196.473H20a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-.089l-.196.473.063.063a2.002 2.002 0 0 1 0 2.828l-1.414 1.414a2 2 0 0 1-2.828 0l-.063-.063-.473.196V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.089l-.473-.196-.063.063a2.002 2.002 0 0 1-2.828 0l-1.414-1.414a2 2 0 0 1 0-2.827l.063-.064L4.089 15H4a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h.09l.195-.473-.063-.063a2 2 0 0 1 0-2.828l1.414-1.414a2 2 0 0 1 2.827 0l.064.063L9 4.089V4a2 2 0 0 1 .586-1.414ZM8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"/>
        </svg>
        <a href="?tab=kelolaProdukPaket">Kelola Jenis Cuci</a>
      </button>
      <button onclick="openTambahPaketModal()" id="tambahPaketBtn" class="hover:bg-blue-700 flex items-center text-xs md:text-base bg-blue-600 text-white p-2 font-bold rounded-lg mb-3">
        <svg class="md:w-6 md:h-6 w-3 h-3 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
        </svg>
        <a>Tambah Paket</a>
      </button>
    </div>

    <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
      <div class="hidden md:block">
      <table class="min-w-full text-xs md:text-sm">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="px-2 md:px-6 py-3 text-left font-semibold">No</th>
            <th class="px-2 md:px-6 py-3 text-left font-semibold">Paket</th>
            <th class="px-2 md:px-6 py-3 text-left font-semibold">Harga Paket</th>
            <th class="px-2 md:px-6 py-3 text-center font-semibold">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <?php $no = 1; foreach ($dataTransaksi as $row): ?>
            <tr class="hover:bg-blue-50 transition">
              <td class="px-2 md:px-6 py-4 text-left"><?= $no++ ?></td>
              <td class="px-2 md:px-6 py-4 text-left"><?= $row['paket_cuci'] ?></td>
              <td class="px-2 md:px-6 py-4 text-left">Rp<?= number_format($row['harga_paket'], 0, ',', '.') ?></td>
              <td class="px-2 md:px-6 py-4 text-left flex justify-center gap-2 flex-wrap">
                <div class="flex flex-col sm:flex-row gap-2">
                  <button onclick="openEditJensiCuciModal(this)" data-id="<?= $row['id'] ?>" data-nama="<?= htmlspecialchars($row['paket_cuci']) ?>" data-alamat="<?= htmlspecialchars($row['harga_paket']) ?>" class="flex items-center justify-center gap-2 px-2 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md w-full sm:basis-1/2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M15.232 5.232l3.536 3.536M4 13.5V19h5.5l10-10-5.5-5.5-10 10z"/>
                    </svg>
                    <span>Edit</span>
                  </button>

                  <button onclick="softDelete(<?= $row['id'] ?>)" class="flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-md w-full sm:basis-1/2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                    </svg>
                    <span>Hapus</span>
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
      </div>
      <!-- Mobile Card View (untuk layar kecil) -->
      <div class="md:hidden space-y-4">
        <?php $no = 1; foreach ($dataTransaksi as $row): ?>
          <div class="bg-white p-4 rounded-lg shadow-2xl">
            <h2 class="text-base font-semibold text-gray-800"><?= $no++ ?>. <?= htmlspecialchars($row['paket_cuci']) ?></h2>
            <p class="text-gray-600 text-sm">Harga: Rp<?= number_format($row['harga_paket'], 0, ',', '.') ?></p>
            <div class="flex justify-end gap-2 mt-4 flex-wrap">
              <button onclick="openEditJensiCuciModal(this)" data-id="<?= $row['id'] ?>" data-nama="<?= htmlspecialchars($row['paket_cuci']) ?>" data-alamat="<?= htmlspecialchars($row['harga_paket']) ?>" class="bg-blue-600 text-white px-3 py-2 rounded-lg text-xs shadow-md hover:bg-blue-700 transition w-full sm:w-auto">
                Edit
              </button>
              <button onclick="softDelete(<?= $row['id'] ?>)" class="bg-red-600 text-white px-3 py-2 rounded-lg text-xs shadow-md hover:bg-red-700 transition w-full sm:w-auto">
                Hapus
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</main>

<!-- Modal Edit Jenis Paket -->
<div id="editModal" class="fixed inset-0 bg-black/50 items-center justify-center flex hidden z-50">
  <div class="bg-white w-11/12 sm:w-1/3 p-6 rounded-lg shadow-xl">
    <h3 class="font-semibold text-lg text-center mb-4">Edit Paket Cuci</h3>
    <form action="" method="POST">
      <div class="mb-4">
        <label for="edit_paket" class="block text-sm font-semibold">Nama Paket</label>
        <input type="text" name="paket_cuci" id="edit_paket" class="w-full p-2 border rounded-lg mt-1" required>
      </div>
      <div class="mb-4">
        <label for="edit_harga" class="block text-sm font-semibold">Harga Paket</label>
        <input type="number" name="harga_paket" id="edit_harga" class="w-full p-2 border rounded-lg mt-1" required>
      </div>
      <input type="hidden" name="id" id="edit_id">
      <div class="flex justify-end gap-3 pt-2">
        <button type="button" onclick="closeEditModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Batal</button>
        <button type="submit" name="updateJenisCuci" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">Simpan</button>
      </div>
    </form>
  </div>
</div>
<!-- Modal Tambah Paket -->
<div id="TambahPaketModal" class="fixed inset-0 bg-black/50 items-center justify-center flex hidden z-50">
    <div class="bg-white w-11/12 sm:w-1/3 p-6 rounded-lg shadow-xl">
        <h3 class="font-semibold text-lg text-center mb-4">Tambah Paket Cuci</h3>
        <form action="" method="POST">
            <div class="mb-4">
                <label for="paket_cuci" class="block text-sm font-semibold">Nama Paket</label>
                <input type="text" name="Paket" id="paket_cuci" class="w-full p-2 border rounded-lg mt-1" required>
            </div>
            <div class="mb-4">
                <label for="harga_paket" class="block text-sm font-semibold">Harga Paket</label>
                <input type="number" name="HargaPaket" id="harga_paket" class="w-full p-2 border rounded-lg mt-1" required>
            </div>
            <button type="submitPaket" name="submitPaket" class="w-full bg-blue-600 text-white py-2 rounded-lg">Tambah Paket</button>
        </form>
    </div>
</div>

<script>
function openEditJensiCuciModal(el) {
    const id = el.dataset.id;
    const nama = el.dataset.nama;
    const harga = el.dataset.alamat;

    // Set value dari input form modal
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_paket').value = nama; // Sesuaikan dengan input field
    document.getElementById('edit_harga').value = harga; // Sesuaikan dengan input field

    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Close modal when clicking outside the modal box
window.addEventListener('click', function (e) {
    const modal = document.getElementById('editModal');
    if (e.target === modal) {
        closeEditModal();
    }
});

// Fungsi buat buka modal tambah paket
function openTambahPaketModal() {
    document.getElementById("TambahPaketModal").classList.remove("hidden");
}

// Fungsi buat tutup modal tambah paket
function closeTambahPaketModal() {
    document.getElementById("TambahPaketModal").classList.add("hidden");
}

// Opsional: tutup modal kalau klik di luar kontennya
window.addEventListener("click", function (e) {
    const modal = document.getElementById("TambahPaketModal");
    if (e.target === modal) {
        closeTambahPaketModal();
    }
});

</script>