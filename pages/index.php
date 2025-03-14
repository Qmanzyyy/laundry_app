<?php 
session_start();

// Cek role
    if (!isset($_SESSION['user_id'])) {
        // Arahkan ke dashboard
        header("Location: login.php");
        exit;
    }