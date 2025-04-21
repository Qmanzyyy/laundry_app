<main class="md:p-6 overflow-y-auto flex-1 py-6 px-6" id="contents">
    <!-- Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-4">
        <?php foreach ($cards as $card) : ?>
        <div class="hover:scale-105 transition ease-in cursor-pointer text-white rounded-lg shadow-md p-6 h-full hover:shadow-lg <?= $card['color'] ?> grid grid-cols-3 gap-2">
            <!-- Bagian Teks -->
            <div class="col-span-2 flex flex-col justify-center">
                <p class="text-gray-300"><?= $card['title'] ?></p>
                <h2 class="text-4xl font-bold"><?= $card['value'] ?></h2>
                <span class="text-sm text-gray-300 mt-2"><?= $card['desc'] ?></span>
            </div>
            <!-- Bagian Icon SVG -->
            <div class="flex items-center justify-center">
                <?= $card['icon'] ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Background Section -->
    <div class="relative h-64 w-full rounded-lg overflow-hidden">
        <!-- Background image dengan posisi di atas kiri -->
        <img src="tendou-alice-blue-archive.gif" alt="Gambar" class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-gray-200 via-transparent to-transparent"></div>

        <!-- Content -->
        <div class="relative z-10 p-4 text-white">
        <div class="relative w-64 h-16 overflow-hidden">
            <div id="text-container" class="absolute top-0 transition-all duration-500 ease-in-out">
                <div class="h-16 flex items-center justify-center text-2xl font-semibold">Soul try to figure it out</div>
                <div class="h-16 flex items-center justify-center text-2xl font-semibold">From where I've been escapin'</div>
                <div class="h-16 flex items-center justify-center text-2xl font-semibold">Running to end all the sin</div>
                <div class="h-16 flex items-center justify-center text-2xl font-semibold">Get away from the pressure</div>
                <div class="h-16 flex items-center justify-center text-2xl font-semibold">Wondering to get a love that is so pure</div>
                <div class="h-16 flex items-center justify-center text-2xl font-semibold">Gotta have to always make sure</div>
                <div class="h-16 flex items-center justify-center text-2xl font-semibold">That I'm not just somebody's pleasure</div>
            </div>
        </div>
        </div>
    </div>

    <!-- Detail Akun -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-4">
        <h2 class="text-lg font-semibold mb-4">Detail Akun</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 cursor-pointer">
            <?php foreach ($usersByRole as $role) : 
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
<script>
  const container = document.getElementById('text-container');
  const texts = container.children;
  const itemHeight = 64; // px
  let index = 0;

  // Durasi tampil untuk masing-masing teks (dalam ms)
  const durations = [2000, 2500, 6000, 2500, 6000, 4000, 6000]; // Durasi teks diam setelah muncul

  function slideText() {
    container.style.top = `-${index * itemHeight}px`;  // Geser teks ke atas
    index = (index + 1) % texts.length; // Perulangan kembali ke atas jika sudah mencapai teks terakhir
  }

  function updateText() {
    slideText();  // Teks berpindah
    setTimeout(updateText, durations[index]);  // Tunggu selama durasi sebelum berpindah ke teks selanjutnya
  }

  // Menunggu waktu sebelum teks pertama muncul
  setTimeout(updateText, durations[index]); 
</script>


