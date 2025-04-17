<?php
require_once "./components/function/editJenisCuci.php";
$query = "
SELECT * FROM tb_jenis_cuci
";

$result = mysqli_query($conn, $query);

$dataTransaksi = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataTransaksi[] = $row;
}
?>

<main class="py-10 min-h-screen">
  <div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Kelola Jenis Cuci</h1>
    <button class="bg-indigo-600 text-white p-2 font-bold rounded-lg mb-3"><a href="?tab=kelolaPaket">Kelola Paket</a></button>
    <div class="overflow-x-auto shadow-lg rounded-lg border border-gray-200 bg-white">
      <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-3 text-left font-semibold text-gray-600">No</th>
            <th class="px-6 py-3 text-left font-semibold text-gray-600">Jenis Cuci</th>
            <th class="px-6 py-3 text-left font-semibold text-gray-600">Harga Cuci</th>
            <th class="px-6 py-3 text-center font-semibold text-gray-600">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <?php $no = 1; foreach ($dataTransaksi as $row): ?>
            <tr class="hover:bg-blue-50 transition">
              <td class="px-6 py-4"><?= $no++ ?></td>
              <td class="px-6 py-4"><?= $row['jenis_cuci'] ?></td>
              <td class="px-6 py-4">Rp<?= number_format($row['harga_cuci'], 0, ',', '.') ?></td>
              <td class="px-6 py-4 text-center flex justify-center gap-2 flex-wrap">
                <button
                  onclick="openEditJensiCuciModal(this)"
                  data-id="<?= $row['id'] ?>"
                  data-nama="<?= htmlspecialchars($row['jenis_cuci']) ?>"
                  data-alamat="<?= htmlspecialchars($row['harga_cuci']) ?>"
                  class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                       viewBox="0 0 24 24">
                    <path d="M15.232 5.232l3.536 3.536M4 13.5V19h5.5l10-10-5.5-5.5-10 10z"/>
                  </svg>
                  <span>Edit</span>
                </button>
                <button
                  onclick="softDelete(<?= $row['id'] ?>)"
                  class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-md">
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
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
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

<script>
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
    document.body.classList.add('overflow-hidden');
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
}

// Close modal when clicking outside the modal box
window.addEventListener('click', function (e) {
    const modal = document.getElementById('editModal');
    if (e.target === modal) {
        closeEditModal();
    }
});
</script>
