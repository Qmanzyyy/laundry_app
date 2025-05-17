<?php
$sql = "
    SELECT o.nama AS outlet
    FROM tb_user u
    JOIN tb_outlet o ON u.id_outlet = o.id
";

if (isset($_SESSION['user_outlet'])) {
    $outlet = (int) $_SESSION['user_outlet'];
    $sql .= " WHERE o.id = $outlet";
}

$userOutlet = query($sql); // Misal hasilnya array of rows
$namaOutlet = isset($userOutlet[0]['outlet']) ? $userOutlet[0]['outlet'] : 'Tidak diketahui';
?>


<main class="md:p-6 px-6 py-6 ">
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center space-x-4">
            <div class="p-3  text-white rounded-full">
                <!-- Contoh ikon -->
                <img class="w-16 rounded-full" src="<?= htmlspecialchars($photo); ?>" alt="Profile Photo">
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">
                    Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?>!
                </h1>
                <p class="text-gray-600 text-sm">
                    Your Role: <span class="font-semibold text-blue-500"><?= htmlspecialchars($_SESSION['user_role']); ?></span>
                </p>
                <p class="text-gray-600 text-sm">
                    Your Outlet: <span class="font-semibold text-blue-500"><?= htmlspecialchars($namaOutlet); ?> (<?= $_SESSION['user_outlet']; ?>)</span>
                </p>
            </div>
        </div>
        <hr class="my-4 border-gray-200">
        <p class="text-gray-500">How can we assist you today? Choose an option from the Hamburger Menu.</p>
    </div>
</main>
