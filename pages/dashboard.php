<?php 
session_start();

// default Profile Picture
include_once './components/function/randomProfile.php';

// login Checker
include_once './components/function/loginChecker.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- ======== dynamic title ======== -->
    <?php if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'owner'){
      echo '<title>Dashboard</title>';
    } else {
      echo '<title>Kasir</title>';
      }?>

  <!-- ======= favicon ======== -->
  <link rel="shortcut icon" href="./../favicon.ico" type="image/x-icon">

  <!-- ======= koneksi css ======= -->
  <link rel="stylesheet" href="./../style/isi.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
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
    <!-- ======= koneksi js ======= -->
    <script src="./components/js/action.js"></script>
    <script src="./components/js/sidebarToggle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    
</body>
</html>