<?php
// Mulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum akan redirect ke halaman login
    header("Location: ./pages/login.php");
    exit();
}

// elseif(isset($_SESSION['user_id'])){
//     // Jika sudah login akan redirect ke halaman dashboard
//     header("Location: ./pages/dashboard.php");
//     exit();
// }