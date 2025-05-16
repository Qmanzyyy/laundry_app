<?php 
require_once "./components/function/tambahOutletProcces.php";
$query = "
SELECT * FROM tb_outlet
";

$result = mysqli_query($conn, $query);

$dataTransaksi = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataTransaksi[] = $row;
}
?>
<main class="p-6 min-h-dvh">
    <div class="max-w-5xl mx-auto p-6">
    <h1 class="md:text-3xl text-xl font-bold text-center mb-10 text-blue-600">Kelola Outlet</h1>
    <div class="flex mb-5">
      <button
        onclick="openTambahOutletModal()"
       class="hover:bg-blue-700 flex items-center justify-center bg-blue-600 text-xs md:text-base text-white p-2 font-bold rounded-lg mb-3"><svg class="md:w-6 md:h-6 mr-2 h-3 w-3 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/></svg><a>Tambah Outlet</a></button>
    </div>

    <div class="overflow-x-auto shadow-lg rounded-lg bg-white">
      <div class="hidden md:block">
      <table class="min-w-full text-xs md:text-sm">
        <thead class="bg-blue-600 text-white">
          <tr>
            <th class="px-2 md:px-6 py-3 text-left font-semibold ">No</th>
            <th class="px-2 md:px-6 py-3 text-left font-semibold ">Nama Outlet</th>
            <th class="px-2 md:px-6 py-3 text-left font-semibold ">Alamat Outlet</th>
            <th class="px-2 md:px-6 py-3 text-left font-semibold ">Tlp Outlet</th>
            <th class="px-2 md:px-6 py-3 text-center font-semibold ">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <!-- Data Transaksi -->
          <?php $no = 1; foreach ($dataTransaksi as $row): ?>
            <tr class="hover:bg-blue-50 transition">
              <td class="px-2 md:px-6 py-4 text-left"><?= $no++ ?></td>
              <td class="px-2 md:px-6 py-4 text-left"><?= $row['nama'] ?></td>
              <td class="px-2 md:px-6 py-4 text-left"><?= $row['alamat'] ?></td>
              <td class="px-2 md:px-6 py-4 text-left"><?= $row['tlp'] ?></td>
              <td class="px-2 md:px-6 py-4 text-left flex justify-center gap-2 flex-wrap">
                <div class="flex flex-col sm:flex-row gap-2">
                  <button
                    onclick="openEditOutletModal(this)"
                    data-id="<?= $row['id'] ?>"
                    data-nama="<?= htmlspecialchars($row['nama']) ?>"
                    data-alamat="<?= htmlspecialchars($row['alamat']) ?>"
                    data-tlp="<?= htmlspecialchars($row['tlp']) ?>"
                    class="flex items-center justify-center gap-2 px-2 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md w-full sm:basis-1/2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M15.232 5.232l3.536 3.536M4 13.5V19h5.5l10-10-5.5-5.5-10 10z"/>
                    </svg>
                    <span>Edit</span>
                  </button>
                  <button
                    onclick="confirmDeleteOutlet(<?= $row['id'] ?>)"
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
            <h2 class="text-base font-semibold text-gray-800"><?= $no++ ?>. <?= htmlspecialchars($row['nama']) ?></h2>
            <p class="text-gray-600 text-sm truncate">Alamat: <?= $row['alamat'] ?></p>
            <div class="flex justify-end gap-2 mt-4 flex-wrap">
              <button
                onclick="openEditOutletModal(this)"
                data-id="<?= $row['id'] ?>"
                data-nama="<?= htmlspecialchars($row['nama']) ?>"
                data-alamat="<?= htmlspecialchars($row['alamat']) ?>"
                data-tlp="<?= htmlspecialchars($row['tlp']) ?>"
                class="bg-blue-600 text-white px-3 py-2 rounded-lg text-xs shadow-md hover:bg-blue-700 transition w-full sm:w-auto">
                Edit
              </button>
              <button
                onclick="confirmDeleteOutlet(<?= $row['id'] ?>)"
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
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Outlet</h2>
    <form id="editForm" action="" method="POST" class="space-y-4">
      <input type="hidden" name="id" id="edit_id">
      <div>
        <label class="block text-gray-600 font-medium mb-1">Nama Outlet</label>
        <input type="text" name="nama" id="edit_nama" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
      </div>
      <div>
        <label class="block text-gray-600 font-medium mb-1">Alamat Outlet</label>
        <input type="text" name="alamat" id="edit_alamat" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
      </div>
      <div>
        <label class="block text-gray-600 font-medium mb-1">Telepon</label>
        <input type="tel" name="tlp" id="edit_tlp" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
      </div>
      <div class="flex justify-end gap-3 pt-2">
        <button type="button" onclick="closeEditModal()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Batal</button>
        <button type="submit" name="updateJenisCuci" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">Simpan</button>
      </div>
    </form>
  </div>
</div>
<!-- Tambah Outlet Modal -->
<div  id="TambahOutletModal"  class="fixed inset-0 bg-black/50 items-center justify-center flex hidden z-50">
    <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md relative animate-fade-in" >
<form action="" method="post" class="space-y-4">
    <h2 class="text-2xl font-bold text-center text-blue-600">Tambah Outlet</h2>
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
<div  class="flex justify-end gap-3 pt-2">
<button type="submit" name="submit"
    class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
Buat!
</button>
<button type="button" onclick="closeTambahOutletModal()" class="w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Batal</button>
</div>
</form>
</div>
</div>
<script>
    function confirmDeleteOutlet(userId) {
    console.log("confirmDelete() dipanggil dengan userId:", userId);
    Swal.fire({
      title: "Apakah Anda yakin?",
      text: "Data Outlet ini akan dihapus!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        console.log("User mengonfirmasi hapus, mengirim request POST...");
        fetch("./components/function/deleteOutlet.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: "id=" + encodeURIComponent(userId)
        })
        .then(response => {
          console.log("Response dari server:", response);
          return response.text();
        })
        .then(text => {
          console.log("Response text:", text);
          if (text.indexOf("Success:") !== -1) {
            Swal.fire({ title: "Berhasil!", text: text, icon: "success" })
              .then(() => window.location.reload());
          } else {
            Swal.fire({ title: "Error!", text: text, icon: "error" });
          }
        })
        .catch(error => {
          console.error("Error dalam fetch:", error);
          Swal.fire({ title: "Error!", text: "Terjadi kesalahan saat menghapus data: " + error, icon: "error" });
        });
      }
    });
  }
    function openTambahOutletModal() {
    document.getElementById("TambahOutletModal").classList.remove("hidden");
  }
  function closeTambahOutletModal(){
    document.getElementById("TambahOutletModal").classList.add("hidden");
  }
function openEditOutletModal(el) {
    const id = el.dataset.id;
    const nama = el.dataset.nama;
    const alamat = el.dataset.alamat;
    const tlp = el.dataset.tlp;

    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_alamat').value = alamat;
    document.getElementById('edit_tlp').value = tlp;

    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

</script>
