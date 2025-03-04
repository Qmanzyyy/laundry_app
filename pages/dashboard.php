<?php 
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum akan redirect ke halaman login
    header("Location: ./login.php");
    exit;
}

// Cek role
if ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'owner') {
    header("Location: ./login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./../style/main.css" />
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- ======== Wrapper utama: sidebar + konten ======== -->
  <div class="flex h-screen">

    <!-- ======== sidebar ======== -->
    <?php include './partials/sidebar.php';?>
    
    <!-- ======== MAIN CONTENT (Navbar + Content) ======== -->
    <div class="flex-1 flex flex-col">
        <!-- ======== Navbar ======== -->
        <?php include './partials/navbar.php';?>

        <!-- ======== Main Content ======== -->
        <?php include './partials/mainDashboard.php';?>
     </div>

    </div>
  <!-- ======== Sidebar Function ======= -->
  <script src="./partials/js/sidebarToggle.js"></script>
</body>
</html>