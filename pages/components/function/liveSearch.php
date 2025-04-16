<?php
session_start();
require_once "../../../config/db.php";
$role = $_SESSION['user_role'];
$keyword = $_GET["keyword"] ?? ""; 
$query = "
    SELECT 
        u.id, u.nama, k.alamat, k.no_telp, k.shift_kerja, 
        u.username, u.role, o.nama AS nama_outlet
    FROM tb_user u
    JOIN tb_karyawan k ON u.id = k.id_user
    JOIN tb_outlet o ON o.id = u.id_outlet
    WHERE u.role != 'owner' && u.role != '$role'
";

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


$result = mysqli_query($conn, $query);
$users = [];
$dataFound = false;

if ($result && mysqli_num_rows($result) > 0) {
    $dataFound = true;
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

?>
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
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                    </svg>
                    <p>Edit</p>
                </a>
                <a href="#"
                   class="button-hapus bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-700 transition flex justify-center items-center gap-2"
                   onclick="confirmDelete(<?= $user['id'] ?>)">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
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
            Data tidak ditemukan
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
