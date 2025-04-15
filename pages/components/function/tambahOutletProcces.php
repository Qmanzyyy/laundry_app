<?php
require_once "./../config/db.php";

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tlp = $_POST['tlp'];

    $query = "INSERT INTO tb_outlet (nama, alamat, tlp) VALUES ('$nama', '$alamat', '$tlp')";
    $result = mysqli_query($conn, $query);

    if(mysqli_affected_rows($conn) > 0){
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Outlet berhasil ditambahkan!',
            }).then(() => {
                window.location.href = './dashboard.php?tab=tambahOutlet';
            });
        </script>";
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Outlet gagal ditambahkan!',
            }).then(() => {
                window.location.href = './dashboard.php?tab=tambahOutlet';
            });
        </script>";
    }
}
?>
