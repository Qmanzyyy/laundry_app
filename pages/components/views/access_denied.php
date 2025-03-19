<div class="h-full flex flex-col items-center justify-center bg-red-500 text-white text-center font-bold pt-24 md:pt-6 px-6">
    <p>⚠️ Akses Ditolak! Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <p>Anda akan dialihkan dalam <span id="countdown3">5</span> detik...</p>
</div>

<script>
    let countdown3 = 5;
    let countdown3Element = document.getElementById("countdown3");

    // Set nilai awal biar langsung tampil
    countdown3Element.textContent = countdown3;

    let interval = setInterval(function() {
        countdown3--;
        countdown3Element.textContent = countdown3;
        
        if (countdown3 <= 0) {
            clearInterval(interval);
            window.location.href = "dashboard.php?tab=home"; // Ganti dengan halaman tujuan
        }
    }, 1000); // 1000 ms = 1 detik
</script>
