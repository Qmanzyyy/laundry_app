<?php 
session_start();

// Cek apakah user sudah login
    if (!isset($_SESSION['user_id'])) {
        // Jika belum akan redirect ke halaman login
        header("Location: ./pages/login.php");
        exit;
    }

// Cek role
    if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'owner') {
        // Arahkan ke dashboard
        header("Location: ./pages/dashboard.php");
        exit;
    } else {
        // Selain admin/owner ke kasir
        header("Location: ./page/kasir.php");
        exit;
    }
