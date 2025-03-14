    
<?php
// Daftar foto default
$default_images = [
    './../img/pp1.png',
    './../img/pp2.png',
    './../img/pp3.png'
];

// Jika foto user kosong, pilih foto default secara acak
if ($_SESSION['user_photo'] === "default.png" || $_SESSION['user_photo'] === "") {
    $random_index = array_rand($default_images);
    $photo = $default_images[$random_index];
} else {
    $photo = $_SESSION['user_photo'];
}
?>
