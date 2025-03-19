<main class="md:p-6 overflow-y-auto flex-1 pt-24 px-6" id="contents">
    <!-- Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
        <?php
        foreach ($cards as $card) :
        ?>
        <div class="active:scale-100 hover:scale-105 transition ease-in cursor-pointer text-white rounded-lg shadow-md p-6 flex flex-col h-full hover:shadow-lg <?= $card['color']?>">
            <p class="text-gray-300"><?= $card['title'] ?></p>
            <h2 class="text-4xl font-bold "><?= $card['value'] ?></h2>
            <span class="text-sm text-gray-300 mt-2"><?= $card['desc'] ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Detail Akun -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-4">
        <h2 class="text-lg font-semibold mb-4">Detail Akun</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 cursor-pointer">
            <?php 
            // Definisi warna dan ikon untuk setiap role
            foreach ($usersByRole as $role) : 
                $roleName = strtolower($role['role']);  
                $roleColor = $roleStyles[$roleName]['color'] ?? 'bg-gray-500';
                $roleIcon = $roleStyles[$roleName]['icon'] ?? '👤';
            ?>
            <div class="flex items-center bg-gray-100 p-4 rounded-lg shadow-sm hover:bg-gray-200 transition">
                <div class="w-10 h-10 flex items-center justify-center text-white rounded-md <?= $roleColor ?>">
                    <img src="<?= $roleIcon ?>" alt="">
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
