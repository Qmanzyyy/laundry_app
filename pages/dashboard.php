<?php 
session_start();

include_once './components/function/randomProfile.php';
// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum akan redirect ke halaman login
    header("Location: ./login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'owner'){
      echo '<title>Dashboard</title>';
    } else {
      echo '<title>Kasir</title>';
      }?>
<!-- ======= favicon ======== -->
    <link rel="shortcut icon" href="./../favicon.ico" type="image/x-icon">
<!-- ======= koneksi css ======= -->
    <link rel="stylesheet" href="./../style/output.css" />
</head>
<body class="bg-gray-200 text-gray-800 relative ">

  <!-- ======== Wrapper utama: sidebar + konten ======== -->
  <div class="flex min-h-screen">

    <!-- ======== sidebar ======== -->
    <?php include './components/sidebar.php';?>
    
    <!-- ======== MAIN CONTENT (Navbar + Content) ======== -->
    <div class="flex-1 flex flex-col">
        <!-- ======== Navbar ======== -->
        <?php include './components/navbar.php';?>
          <!-- ======== Main Content ======== -->
             <?php include './components/tabs_routing.php'; ?>
     </div>

    </div>
  <!-- ======== Sidebar Function ======= -->
  <script src="./components/js/sidebarToggle.js"></script>

</body>
</html>