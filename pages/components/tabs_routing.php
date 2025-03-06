<?php

// Tentukan default tab
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'home';

// Cek hak akses terlebih dahulu untuk tab admin
if ($tab == 'admin' && $_SESSION['user_role'] == 'kasir') {
    include_once 'views/access_denied.php';
    exit();
}

// Routing ke file view berdasarkan tab yang diminta
switch ($tab) {
    case 'home':
        include 'views/home.php';
        break;
    case 'admin':
        include 'views/admin.php';
        break;
    case 'kasir':
        include 'views/kasir.php';
        break;
    default:
        include 'views/404.php';
        break;
}