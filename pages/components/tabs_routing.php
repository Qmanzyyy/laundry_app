<?php

// Tentukan default tab
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'home';

// Daftar tab yang dilarang untuk kasir
$kasir_dilarang = ['admin', 'register', 'kelolaUser', 'registrasiAkun', 'tambahOutlet'];

if ($_SESSION['user_role'] == 'kasir' && in_array($tab, $kasir_dilarang)) {
    include_once 'views/access_denied.php';
    exit();
}

// Routing ke file view berdasarkan tab yang diminta
$views = [
    'home' => 'views/home.php',
    'admin' => 'views/admin.php',
    'kasir' => 'views/kasir.php',
    'registerAkun' => 'views/registerAkun.php',
    'tambahOutlet' => 'views/tambahOutlet.php',
    'kelolaUser' => 'views/kelolaUser.php',
    'riwayatTransaksi' => 'views/riwayatTransaksi.php'
];

if (isset($views[$tab])) {
    include $views[$tab];
} else {
    include 'views/404.php';
}
?>
