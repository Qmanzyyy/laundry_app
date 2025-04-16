<?php
// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum akan redirect ke halaman login
    header("Location: ./pages/login.php");
    exit;
} else {
    // Cek apakah ini adalah pertama kali login dalam sesi ini
    if (!isset($_SESSION['login_success'])) {
        // Tandai bahwa user sudah login agar notifikasi tidak muncul lagi dalam sesi ini
        $_SESSION['login_success'] = true;

        // Tampilkan notifikasi hanya sekali
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });

                    Toast.fire({
                        icon: "success",
                        title: "Login berhasil!"
                    });
                });
              </script>';
    }
}