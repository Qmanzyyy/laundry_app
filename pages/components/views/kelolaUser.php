<?php 
require "./../config/db.php";
require_once "./components/function/editUser.php";
$query = "SELECT u.id, u.nama, k.alamat, k.no_telp, k.shift_kerja, u.username, u.role 
          FROM tb_user u 
          JOIN tb_karyawan k ON u.id = k.id_user
          WHERE u.role != 'owner'";
$users = query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kelola Karyawan</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<main class="md:p-6 px-4 md:px-6 pt-24 bg-gray-100 min-h-screen">
  <div class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-semibold text-gray-800">Kelola Karyawan</h1>
    <p class="text-gray-500 mb-4">Gunakan tabel di bawah untuk mengelola karyawan. Anda bisa mengedit atau menghapus data yang diperlukan.</p>
    <!-- Tabel untuk layar besar -->
    <div class="hidden md:block overflow-x-auto max-w-full">
      <table class="w-full border border-gray-300 bg-white rounded-lg overflow-hidden shadow-md">
        <thead class="bg-blue-600 text-white uppercase text-xs md:text-sm leading-normal">
          <tr>
            <th class="py-2 md:py-3 px-4 text-left">No</th>
            <th class="py-2 md:py-3 px-4 text-left">Nama</th>
            <th class="py-2 md:py-3 px-4 text-left">Alamat</th>
            <th class="py-2 md:py-3 px-4 text-left">Telepon</th>
            <th class="py-2 md:py-3 px-4 text-left">Shift</th>
            <th class="py-2 md:py-3 px-4 text-left">Username</th>
            <th class="py-2 md:py-3 px-4 text-left">Role</th>
            <th class="py-2 md:py-3 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="text-gray-700 text-xs md:text-sm font-light">
          <?php $no = 1; ?>
          <?php foreach ($users as $user): ?>
          <tr class="border-b border-gray-200 hover:bg-gray-100 transition">
            <td class="py-2 md:py-3 px-4"><?= $no++ ?></td>
            <td class="py-2 md:py-3 px-4"><?= htmlspecialchars($user['nama']) ?></td>
            <td class="py-2 md:py-3 px-4"><?= htmlspecialchars($user['alamat']) ?></td>
            <td class="py-2 md:py-3 px-4"><?= htmlspecialchars($user['no_telp']) ?></td>
            <td class="py-2 md:py-3 px-4"><?= htmlspecialchars($user['shift_kerja']) ?></td>
            <td class="py-2 md:py-3 px-4"><?= htmlspecialchars($user['username']) ?></td>
            <td class="py-2 md:py-3 px-4">
              <span class="px-3 py-1 rounded-full text-white text-xs font-semibold <?= $user['role'] == 'admin' ? 'bg-blue-500' : ($user['role'] == 'kasir' ? 'bg-yellow-500' : 'bg-green-500') ?>">
                <?= htmlspecialchars(ucfirst($user['role'])) ?>
              </span>
            </td>
            <td class="py-2 md:py-3 px-4 text-center flex justify-center gap-2 flex-wrap">
              <a href="javascript:void(0);" 
                 onclick="openEditModal(this)"
                 data-id="<?= $user['id'] ?>" 
                 data-nama="<?= htmlspecialchars($user['nama']) ?>" 
                 data-alamat="<?= htmlspecialchars($user['alamat']) ?>" 
                 data-telp="<?= htmlspecialchars($user['no_telp']) ?>" 
                 data-shift="<?= htmlspecialchars($user['shift_kerja']) ?>" 
                 data-username="<?= htmlspecialchars($user['username']) ?>" 
                 data-role="<?= $user['role'] ?>"
                 class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition">
                Edit
              </a>
              <a href="#" 
                 class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-700 transition"
                 onclick="confirmDelete(<?= $user['id'] ?>)">
                Hapus
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <!-- Tampilan untuk layar kecil (Mobile Card View) -->
    <div class="md:hidden space-y-4">
      <?php foreach ($users as $user): ?>
      <div class="bg-white p-4 rounded-lg shadow-2xl">
        <h2 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($user['nama']) ?></h2>
        <p class="text-gray-600 text-sm"><?= htmlspecialchars($user['alamat']) ?></p>
        <p class="text-gray-600 text-sm">Telepon: <?= htmlspecialchars($user['no_telp']) ?></p>
        <p class="text-gray-600 text-sm">Shift: <?= htmlspecialchars($user['shift_kerja']) ?></p>
        <p class="text-gray-600 text-sm">Username: <?= htmlspecialchars($user['username']) ?></p>
        <p class="text-gray-600 text-sm">
          Role: <span class="px-3 py-1 rounded-full text-white text-xs font-semibold <?= $user['role'] == 'admin' ? 'bg-cyan-500' : ($user['role'] == 'kasir' ? 'bg-yellow-500' : 'bg-green-500') ?>">
          <?= htmlspecialchars(ucfirst($user['role'])) ?>
          </span>
        </p>
        <div class="flex justify-end mt-4">
          <button onclick="openEditModal(this)"
                  data-id="<?= $user['id'] ?>" 
                  data-nama="<?= htmlspecialchars($user['nama']) ?>" 
                  data-alamat="<?= htmlspecialchars($user['alamat']) ?>" 
                  data-telp="<?= htmlspecialchars($user['no_telp']) ?>" 
                  data-shift="<?= htmlspecialchars($user['shift_kerja']) ?>" 
                  data-username="<?= htmlspecialchars($user['username']) ?>" 
                  data-role="<?= $user['role'] ?>"
                  class="bg-blue-500 text-white px-3 py-2 rounded-lg text-xs shadow-md hover:bg-blue-700 transition">
            Edit
          </button>
          <button onclick="confirmDelete(<?= $user['id'] ?>)"
                  class="bg-red-500 text-white px-3 py-2 rounded-lg text-xs shadow-md hover:bg-red-700 transition">
            Hapus
          </button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</main>

<!-- Modal Edit User -->
<div id="editModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 items-center justify-center flex hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Karyawan</h2>
    <form id="editForm" action="" method="POST">
      <input type="hidden" name="id" id="edit_id">
      <div class="mb-4">
        <label class="block text-gray-600 font-medium">Nama</label>
        <input type="text" name="nama" id="edit_nama" required class="w-full px-4 py-2 border rounded-lg">
      </div>
      <div class="mb-4">
        <label class="block text-gray-600 font-medium">Alamat</label>
        <input type="text" name="alamat" id="edit_alamat" required class="w-full px-4 py-2 border rounded-lg">
      </div>
      <input type="hidden" name="username" id="edit_username">
      <div class="mb-4">
        <label class="block text-gray-600 font-medium">Telepon</label>
        <input type="text" name="no_telp" id="edit_telp" required class="w-full px-4 py-2 border rounded-lg">
      </div>
      <div class="mb-4">
        <label class="block text-gray-600 font-medium">Shift</label>
        <select name="shift_kerja" id="edit_shift" required class="w-full px-4 py-2 border rounded-lg">
          <option value="pagi">Pagi</option>
          <option value="malam">Malam</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block text-gray-600 font-medium">Role</label>
        <select name="role" id="edit_role" required class="w-full px-4 py-2 border rounded-lg">
          <option value="admin">Admin</option>
          <option value="kasir">Kasir</option>
          <option value="owner">Owner</option>
          <option value="petugas">Petugas</option>
        </select>
      </div>
      <div class="flex justify-end gap-4">
        <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</button>
        <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<script>
function confirmDelete(userId) {
  console.log("confirmDelete() dipanggil dengan userId:", userId);
  Swal.fire({
    title: "Apakah Anda yakin?",
    text: "Data karyawan ini akan dihapus!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Ya, Hapus!",
    cancelButtonText: "Batal"
  }).then((result) => {
    if (result.isConfirmed) {
      console.log("User mengonfirmasi hapus, mengirim request POST...");
      fetch("./components/function/deleteUser.php", {
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

function openEditModal(button) {
  document.getElementById('edit_id').value = button.getAttribute('data-id');
  document.getElementById('edit_nama').value = button.getAttribute('data-nama');
  document.getElementById('edit_alamat').value = button.getAttribute('data-alamat');
  document.getElementById('edit_telp').value = button.getAttribute('data-telp');
  document.getElementById('edit_shift').value = button.getAttribute('data-shift');
  document.getElementById('edit_role').value = button.getAttribute('data-role');
  document.getElementById('edit_username').value = button.getAttribute('data-username');
  document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
  document.getElementById('editModal').classList.add('hidden');
}
</script>
</body>
</html>