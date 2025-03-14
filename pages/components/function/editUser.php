<?php
require_once "./../config/db.php";

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $shift_kerja = $_POST['shift_kerja'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Update user
    $updateUser = "UPDATE tb_user SET nama=?, username=?, role=? WHERE id=?";
    $stmt = $conn->prepare($updateUser);
    $stmt->bind_param("sssi", $nama, $username, $role, $id);
    $stmt->execute();

    // Update karyawan
    $updateKaryawan = "UPDATE tb_karyawan SET alamat=?, no_telp=?, shift_kerja=? WHERE id_user=?";
    $stmt = $conn->prepare($updateKaryawan);
    $stmt->bind_param("sssi", $alamat, $no_telp, $shift_kerja, $id);
    $stmt->execute();

    // Redirect kembali
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'User berhasil di edit!',
                icon: 'success'
            }).then(() => {
                window.location.href = './dashboard.php?tab=kelolaUser';
            });
        </script>";
}
?>
