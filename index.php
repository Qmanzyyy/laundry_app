<?php 
session_start();

// cek apakah sudah login atau belum
    include_once './pages/partials/function/loginChecker.php';

// Cek role
    if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'owner' || $_SESSION['user_role'] === 'kasir') {
        // Arahkan ke dashboard
        header("Location: ./pages/dashboard.php");
        exit;
    }