<?php
require_once "./components/function/editJenisCuci.php";
require_once "./components/function/ubahTambahProdukProccess.php";
$query = "
SELECT * FROM tb_jenis_cuci
";

$result = mysqli_query($conn, $query);

$dataTransaksi = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataTransaksi[] = $row;
}
?>

<main class="p-6 min-h-dvh">
  <div class="max-w-5xl mx-auto p-6">
    <h1 class="md:text-3xl text-xl font-bold text-center mb-10 text-blue-600">Kelola Jenis Cuci</h1>
    <div class="flex mb-5">
      <button class="hover:bg-blue-700 mr-2 flex items-center bg-blue-600 text-xs md:text-base text-white p-2 font-bold rounded-lg mb-3"><svg class="md:w-6 md:h-6 mr-2 h-3 w-3 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9.586 2.586A2 2 0 0 1 11 2h2a2 2 0 0 1 2 2v.089l.473.196.063-.063a2.002 2.002 0 0 1 2.828 0l1.414 1.414a2 2 0 0 1 0 2.827l-.063.064.196.473H20a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-.089l-.196.473.063.063a2.002 2.002 0 0 1 0 2.828l-1.414 1.414a2 2 0 0 1-2.828 0l-.063-.063-.473.196V20a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-.089l-.473-.196-.063.063a2.002 2.002 0 0 1-2.828 0l-1.414-1.414a2 2 0 0 1 0-2.827l.063-.064L4.089 15H4a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h.09l.195-.473-.063-.063a2 2 0 0 1 0-2.828l1.414-1.414a2 2 0 0 1 2.827 0l.064.063L9 4.089V4a2 2 0 0 1 .586-1.414ZM8 12a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd"/></svg><a href="?tab=kelolaPaket">Kelola Paket</a></button>
      <button
        onclick="openTambahCuciModal()"
       class="hover:bg-blue-700 flex items-center justify-center bg-blue-600 text-xs md:text-base text-white p-2 font-bold rounded-lg mb-3"><svg class="md:w-6 md:h-6 mr-2 h-3 w-3 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg><a>Tambah Jenis Cuci</a></button>
    </div>

    <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
      <div class="hidden md:block">
      <table class="min-w-full text-xs md:text-sm">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="px-2 md:px-6 py-3 text-left font-semibold ">No</th>
            <th class="px-2 md:px-6 py-3 text-left font-semibold ">Jenis Cuci</th>
            <th class="px-2 md:px-6 py-3 text-left font-semibold ">Harga Cuci</th>
            <th class="px-2 md:px-6 py-3 text-center font-semibold ">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <!-- Data Transaksi -->
          <?php $no = 1; foreach ($dataTransaksi as $row): ?>
            <tr class="hover:bg-blue-50 transition">
              <td class="px-2 md:px-6 py-4 text-left"><?= $no++ ?></td>
              <td class="px-2 md:px-6 py-4 text-left"><?= $row['jenis_cuci'] ?></td>
              <td class="px-2 md:px-6 py-4 text-left">Rp<?= number_format($row['harga_cuci'], 0, ',', '.') ?></td>
              <td class="px-2 md:px-6 py-4 text-left flex justify-center gap-2 flex-wrap">
                <div class="flex flex-col sm:flex-row gap-2">
                  <button
                    onclick="openEditJensiCuciModal(this)"
                    data-id="<?= $row['id'] ?>"
                    data-nama="<?= htmlspecialchars($row['jenis_cuci']) ?>"
                    data-alamat="<?= htmlspecialchars($row['harga_cuci']) ?>"
                    class="flex items-center justify-center gap-2 px-2 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md w-full sm:basis-1/2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M15.232 5.232l3.536 3.536M4 13.5V19h5.5l10-10-5.5-5.5-10 10z"/>
                    </svg>
                    <span>Edit</span>
                  </button>
                  <button
                    onclick="softDelete(<?= $row['id'] ?>)"
                    class="flex items-center justify-center gap-2 px-2 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-md w-full sm:basis-1/2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd"
                        d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0
                        2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2
                        2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1
                        0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1
                        0-2 0v8a1 1 0 1 0 2 0v-8Z"
                        clip-rule="evenodd"/>
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
      
      <!-- Mobile Card View (hanya muncul di layar kecil) -->
      <div class="md:hidden space-y-4">
        <?php $no = 1; foreach ($dataTransaksi as $row): ?>
          <div class="bg-white p-4 rounded-lg shadow-2xl">
            <h2 class="text-base font-semibold text-gray-800"><?= $no++ ?>. <?= htmlspecialchars($row['jenis_cuci']) ?></h2>
            <p class="text-gray-600 text-sm truncate">Harga: Rp<?= number_format($row['harga_cuci'], 0, ',', '.') ?></p>
            <div class="flex justify-end gap-2 mt-4 flex-wrap">
              <button
                onclick="openEditJensiCuciModal(this)"
                data-id="<?= $row['id'] ?>"
                data-nama="<?= htmlspecialchars($row['jenis_cuci']) ?>"
                data-alamat="<?= htmlspecialchars($row['harga_cuci']) ?>"
                class="bg-blue-600 text-white px-3 py-2 rounded-lg text-xs shadow-md hover:bg-blue-700 transition w-full sm:w-auto">
                Edit
              </button>
              <button
                onclick="softDelete(<?= $row['id'] ?>)"
                class="bg-red-600 text-white px-3 py-2 rounded-lg text-xs shadow-md hover:bg-red-700 transition w-full sm:w-auto">
                Hapus
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</main>


<!-- Modal Edit Jenis Cuci -->
<div id="editModal" class="fixed inset-0 bg-black/50 items-center justify-center flex hidden z-50">
  <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md relative animate-fade-in">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Jenis Cuci</h2>
    <form id="editForm" action="" method="POST" class="space-y-4">
      <input type="hidden" name="id" id="edit_id">
      <div>
        <label class="block text-gray-600 font-medium mb-1">Nama Jenis Cuci</label>
        <input type="text" name="jenis_cuci" id="edit_nama" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
      </div>
      <div>
        <label class="block text-gray-600 font-medium mb-1">Harga</label>
        <input type="number" name="harga_cuci" id="edit_alamat" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
      </div>
      <div class="flex justify-end gap-3 pt-2">
        <button type="button" onclick="closeEditModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Batal</button>
        <button type="submit" name="updateJenisCuci" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">Simpan</button>
      </div>
    </form>
  </div>
</div>
<!-- Modal Tambah Jenis Cuci -->
<div id="TambahCuciModal" class="fixed inset-0 bg-black/50 items-center justify-center flex hidden z-50">
  <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md relative animate-fade-in">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Tambah Jenis Cuci</h2>
    <form id="tambahForm" action="" method="POST" class="space-y-4">
      <div>
        <label class="block text-gray-600 font-medium mb-1">Nama Jenis Cuci</label>
        <input type="text" name="Produk" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
      </div>
      <div>
        <label class="block text-gray-600 font-medium mb-1">Harga Jenis Cuci</label>
        <input type="number" name="HargaProduk" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
      </div>
      <div class="flex justify-end gap-3 pt-2">
        <button type="button" onclick="closeTambahCuciModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Batal</button>
        <button type="submit" name="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
// Function to open the edit modal
function openEditJensiCuciModal(el) {
    const id = el.dataset.id;
    const nama = el.dataset.nama;
    const harga = el.dataset.alamat;

    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_alamat').value = harga;

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

</script>
<script>
  // Fungsi buat buka modal
  function openTambahCuciModal() {
    document.getElementById("TambahCuciModal").classList.remove("hidden");
  }

  // Fungsi buat tutup modal
  function closeTambahCuciModal() {
    document.getElementById("TambahCuciModal").classList.add("hidden");
  }

  // Opsional: tutup modal kalau klik di luar kontennya
  window.addEventListener("click", function (e) {
    const modal = document.getElementById("TambahCuciModal");
    if (e.target === modal) {
      closeTambahCuciModal();
    }
  });
</script>
