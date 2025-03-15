<?php

// Tentukan default tab
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'home';

// cek role user kasir di setiap tab
if ($tab == 'admin' && $_SESSION['user_role'] == 'kasir') {
    include_once 'views/access_denied.php';
    exit();
}elseif ($tab == 'register' && $_SESSION['user_role'] == 'kasir') {
    include_once 'views/access_denied.php';
    exit();
}elseif($tab == 'kelolaUser' && $_SESSION['user_role'] == 'kasir'){
    include_once 'views/access_denied.php';
    exit();
}elseif($tab == 'registrasiAkun' && $_SESSION['user_role'] == 'kasir'){
    include_once 'views/access_denied.php';
    exit();
}elseif($tab == 'tambahOutlet' && $_SESSION['user_role'] == 'kasir'){
    include_once 'views/access_denied.php';
    exit();
}

// Cek role user admin di setiap tab
if ($tab == 'tambahOutlet' && $_SESSION['user_role'] == 'admin') {
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
    case 'registerAkun':
        include 'views/registerAkun.php';
        break;
    case 'tambahOutlet':
        include 'views/tambahOutlet.php';
        break;
    case 'kelolaUser':
        include 'views/kelolaUser.php';
        break;
    default:
        include 'views/404.php';
        break;
}
