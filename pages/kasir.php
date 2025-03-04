<?php 
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum akan redirect ke halaman login
    header("Location: ./login.php");
    exit;
}

// Cek role
if ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'owner'&& $_SESSION['user_role'] !== 'kasir'){
    // Arahkan ke login jika role tidak sesuai
    header("Location: ./login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kasir</title>
</head>
<body>
    ini kasir
    <a href="./logout.php">logout</a>
</body>
</html>