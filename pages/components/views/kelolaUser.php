<?php 
require_once "./components/function/editUser.php";
$role = $_SESSION['user_role'];
$query = "
    SELECT 
        u.id, u.nama, k.alamat, k.no_telp, k.shift_kerja, 
        u.username, u.role, o.nama AS nama_outlet
    FROM tb_user u
    JOIN tb_karyawan k ON u.id = k.id_user
    JOIN tb_outlet o ON o.id = u.id_outlet
    WHERE u.role != 'owner' && u.role !='$role' 
";

$keyword = $_GET["keyword"] ?? ""; 

if (!empty($keyword)) {
    $escapedKeyword = mysqli_real_escape_string($conn, $keyword);
    $query .= "
        AND (
            u.nama LIKE '%$escapedKeyword%' 
            OR k.alamat LIKE '%$escapedKeyword%' 
            OR k.no_telp LIKE '%$escapedKeyword%' 
            OR u.username LIKE '%$escapedKeyword%' 
            OR u.role LIKE '%$escapedKeyword%'
            OR o.nama LIKE '%$escapedKeyword%'
        )
    "; 
}

// Urutkan berdasarkan nama teks + angka di akhir jika ada
$query .= "
    ORDER BY 
        CASE 
            WHEN u.nama REGEXP '.*[0-9]+$' THEN SUBSTRING_INDEX(u.nama, ' ', 1)
            ELSE u.nama
        END ASC,
        CASE 
            WHEN u.nama REGEXP '.*[0-9]+$' THEN CAST(SUBSTRING_INDEX(u.nama, ' ', -1) AS UNSIGNED)
            ELSE 0
        END ASC
";


$users = query($query);

// Cek apakah ada hasil
$dataFound = !empty($users);
?>



<style>
  .button-edit, .button-hapus {
  min-width: 100px; /* Sesuaikan lebar minimum sesuai kebutuhan */
  min-height: 40px; /* Sesuaikan tinggi minimum sesuai kebutuhan */
  padding: 8px 16px; /* Pastikan padding sama */
}
</style>
<script>
    if (performance.navigation.type === 1) { // 1 = User menekan refresh
        window.location.href = "dashboard.php?tab=kelolaUser";
    }
</script>

<main class="md:p-6 px-4 md:px-6 py-6 min-dvh bg-gray-200">
  <div class="bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-2xl font-semibold text-blue-600">Kelola Karyawan</h1>
    <!-- ======== search ======== -->
    <form action="" method="get" class="grid md:grid-cols-4">
      <div class="relative">
        <input type="hidden" name="tab" value="kelolaUser">
        <input id="searchValue" name="keyword" placeholder="Cari karyawan" type="text" value="<?= htmlspecialchars($_GET['nama'] ?? '') ?>" class="w-full p-1 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
        <button id="cari" class="w-5 absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer">
          <img src="./../img/search.png" alt="">
        </button>
      </div>
    </form>

    <p class="text-gray-500 mb-4 text-xs">Gunakan tabel di bawah untuk mengelola karyawan. Anda bisa mengedit atau menghapus data yang diperlukan.</p>
    <!-- Tabel untuk layar besar -->
    <div class="hidden md:block overflow-x-auto max-w-full" id="tableBesar">
    <table class="w-full border border-gray-300 bg-white rounded-lg overflow-hidden shadow-md" >
    <thead class="bg-blue-600 text-white uppercase text-xs md:text-sm leading-normal">
        <tr>
            <th class="py-2 md:py-3 px-4 text-left">No</th>
            <th class="py-2 md:py-3 px-4 text-left">Nama</th>
            <th class="py-2 md:py-3 px-4 text-left">Alamat</th>
            <th class="py-2 md:py-3 px-4 text-left">Telepon</th>
            <th class="py-2 md:py-3 px-4 text-left">Shift</th>
            <th class="py-2 md:py-3 px-4 text-left">Username</th>
            <th class="py-2 md:py-3 px-4 text-left">Outlet</th>
            <th class="py-2 md:py-3 px-4 text-left">Role</th>
            <th class="py-2 md:py-3 px-4 text-center">Aksi</th>
        </tr>
    </thead>
    <?php if ($dataFound): ?>
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
            <td class="py-2 md:py-3 px-4"><?= htmlspecialchars($user['nama_outlet']) ?></td> 
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
                   class="button-edit bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition flex justify-center items-center gap-2">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                    </svg>
                    <p>Edit</p>
                </a>
                <a href="#"
                   class="button-hapus bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-700 transition flex justify-center items-center gap-2"
                   onclick="confirmDelete(<?= $user['id'] ?>)">
                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                    </svg>
                    Hapus
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
    <!-- Jika tidak ada data, tampilkan pesan -->
    <tr>
        <td colspan="9" class="text-center text-red-500 p-3">
            Data tidak ditemukan. halaman akan di refresh dalam <span id="countdown">5</span> detik...
        </td>
    </tr>
    <script>
        let countdown = 5;
        let countdownElement = document.getElementById("countdown");

        let interval = setInterval(function() {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = "dashboard.php?tab=kelolaUser"; // Ganti dengan halaman tujuan
            }
        }, 1000); // 1000 ms = 1 detik
    </script>
<?php endif; ?>

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
        <p class="text-gray-600 text-sm">Outlet: <?= htmlspecialchars($user['nama_outlet'])?></p>
        <p class="text-gray-600 text-sm">Role: 
        <span class="px-3 py-1 rounded-full text-white text-xs font-semibold <?= $user['role'] == 'admin' ? 'bg-cyan-500' : ($user['role'] == 'kasir' ? 'bg-yellow-500' : 'bg-green-500') ?>">
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
<div id="editModal" class="fixed inset-0 bg-black/50 bg-opacity-50 items-center justify-center flex hidden">
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
          <?php if($_SESSION['user_role'] == 'owner'):?>
          <option value="admin">Admin</option>
          <?php endif;?>
          <option value="kasir">Kasir</option>
        </select>
      </div>
      <div class="flex justify-end gap-4">
        <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</button>
        <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
<script src="./components/js/liveSearch.js"></script>
