<?php 
// Menghubungkan ke database
require './../config/db.php';

// counter
require './components/function/counter.php';

// Total transaksi yang terdaftar
$transaksi = query("SELECT Count(*) AS total FROM tb_transaksi");
$totaltransaksi = $transaksi[0]['total'];
?>

<main class="md:p-6 overflow-y-auto flex-1 pt-24 px-6" id="contents">
    <!-- Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
        <?php
        $cards = [
            ['title' => 'Total Pesanan', 'value' => $totaltransaksi, 'desc' => 'Jumlah pesanan yang sudah masuk.', 'color' => 'bg-blue-500'],
            ['title' => 'Total Outlet', 'value' => $totaloutlet, 'desc' => 'Jumlah cabang yang aktif saat ini.', 'color' => 'bg-green-500'],
            ['title' => 'Total Akun', 'value' => $totalUser, 'desc' => 'Total pengguna yang terdaftar.', 'color' => 'bg-purple-500'],
            ['title' => 'Total Pegawai', 'value' => $totalPegawai, 'desc' => 'Total pegawai yang dimiliki.', 'color' => 'bg-purple-500']
        ];
        foreach ($cards as $card) :
        ?>
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col h-full hover:shadow-lg transition-shadow">
            <p class="text-gray-500"><?= $card['title'] ?></p>
            <h2 class="text-4xl font-bold text-gray-800"><?= $card['value'] ?></h2>
            <span class="text-sm text-gray-400 mt-2"><?= $card['desc'] ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Detail Akun -->
<div class="bg-white rounded-lg shadow-md p-6 mt-4">
    <h2 class="text-lg font-semibold mb-4">Detail Akun</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <?php 
        // Definisi warna dan ikon untuk setiap role
        $roleStyles = [
            'admin'  => ['color' => 'bg-blue-500', 'icon' => '🛠️'],
            'kasir'  => ['color' => 'bg-yellow-500', 'icon' => '💰'],
            'owner'  => ['color' => 'bg-red-500', 'icon' => '👑'],
            'member' => ['color' => 'bg-green-500', 'icon' => '🙋']
        ];

        foreach ($usersByRole as $role) : 
            $roleName = strtolower($role['role']);
            $roleColor = $roleStyles[$roleName]['color'] ?? 'bg-gray-500';
            $roleIcon = $roleStyles[$roleName]['icon'] ?? '👤';
        ?>
        <div class="flex items-center bg-gray-100 p-4 rounded-lg shadow-sm hover:bg-gray-200 transition">
            <div class="w-10 h-10 flex items-center justify-center text-white rounded-md <?= $roleColor ?>">
                <?= $roleIcon ?>
            </div>
            <div class="ml-4">
                <p class="text-gray-700 font-semibold"><?= ucfirst($roleName) ?></p>
                <p class="text-sm text-gray-500"><?= $role['total'] ?> akun</p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</main>
