<main class="pt-24 md:pt-6 px-6 h-full ">
    <div class="bg-white p-6 rounded-lg shadow text-center ">
        <h1 class="text-3xl font-bold text-red-500">404 Not Found</h1>
        <p class="text-gray-600">
            Maaf, halaman yang Anda cari tidak ditemukan. Anda akan dialihkan dalam 
            <span id="countdown2">5</span> detik...
        </p>
        <a href="?tab=home" class="text-blue-500 hover:underline mt-4 inline-block">Kembali ke Home</a>
    </div>
    <script>
        let countdown2 = 5;
        let countdown2Element = document.getElementById("countdown2");

        // Set nilai awal biar langsung tampil
        countdown2Element.textContent = countdown2;

        let interval = setInterval(function() {
            countdown2--;
            countdown2Element.textContent = countdown2;
            
            if (countdown2 <= 0) {
                clearInterval(interval);
                window.location.href = "dashboard.php?tab=home"; // Ganti dengan halaman tujuan
            }
        }, 1000); // 1000 ms = 1 detik
    </script>
</main>
