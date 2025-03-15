
<?php 
session_start();

include_once './components/function/randomProfile.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum akan redirect ke halaman login
    header("Location: ./login.php");
    exit;
} else {
    // Cek apakah ini adalah pertama kali login dalam sesi ini
    if (!isset($_SESSION['login_success'])) {
        // Tandai bahwa user sudah login agar notifikasi tidak muncul lagi dalam sesi ini
        $_SESSION['login_success'] = true;

        // Tampilkan notifikasi hanya sekali
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "bottom-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });

                    Toast.fire({
                        icon: "success",
                        title: "Signed in successfully"
                    });
                });
              </script>';
    }
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
 <link rel="stylesheet" href="./../style/scrollbar.css" />
    <link rel="stylesheet" href="./../style/mian.css" />
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
<!-- Croppie CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
<!-- Croppie JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

</body>
</html>