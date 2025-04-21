<?php
require_once "./../config/db.php";

if (isset($_POST['updateJenisCuci'])) {
    $id_jenis_cuci = $_POST['id'];
    $jenis_cuci = $_POST['jenis_cuci'];
    $harga_cuci = $_POST['harga_cuci'];

    // Update user
    $updateUser = "UPDATE tb_jenis_cuci SET jenis_cuci=?, harga_cuci=? WHERE id=?";
    $stmt = $conn->prepare($updateUser);
    $stmt->bind_param("sii", $jenis_cuci, $harga_cuci, $id_jenis_cuci);
    $stmt->execute();

    // Redirect kembali
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Jenis Cuci berhasil di edit!',
                icon: 'success'
            }).then(() => {
                window.location.href = './dashboard.php?tab=kelolaProdukPaket';
            });
        </script>";
}
if (isset($_POST['updateJenisPaket'])) {
    $id_jenis_cuci = $_POST['id'];
    $jenis_cuci = $_POST['paket_cuci'];
    $harga_cuci = $_POST['harga_paket'];

    // Update user
    $updateUser = "UPDATE tb_paket_cuci SET paket_cuci=?, harga_paket=? WHERE id=?";
    $stmt = $conn->prepare($updateUser);
    $stmt->bind_param("sii", $jenis_cuci, $harga_cuci, $id_jenis_cuci);
    $stmt->execute();

    // Redirect kembali
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Jenis Paket berhasil di edit!',
                icon: 'success'
            }).then(() => {
                window.location.href = './dashboard.php?tab=kelolaPaket';
            });
        </script>";
}
?>
