<?php 
    session_start();

// redirect ke halaman login jika belum login
    if(!isset($_SESSION['user_id'])){
        header("location: ./pages/login.php");
        exit;
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./style/output.css">
</head>
<body>
    
</body>
</html>