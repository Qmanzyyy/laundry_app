<?php

require_once "../config/db.php";

if (isset($_POST["submit"])) {
    $nama = $_POST["Nama"];
    $alamat = $_POST["alamat"];
    $no_telp = $_POST["no_telp"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $foto = isset($_POST["foto"]) ? $_POST["foto"] : '';
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Simpan data outlet dulu
    $stmt_outlet = mysqli_prepare($conn, "INSERT INTO tb_outlet (nama, alamat, tlp) VALUES (?, ?, ?)");
    if ($stmt_outlet) {
        mysqli_stmt_bind_param($stmt_outlet, "sss", $nama, $alamat, $no_telp);
        mysqli_stmt_execute($stmt_outlet);

        // Ambil ID outlet yang baru dibuat
        $outlet_id = mysqli_insert_id($conn);

        // Simpan data user dengan outlet_id
        $stmt_user = mysqli_prepare($conn, "INSERT INTO tb_user (nama, foto, username, password, id_outlet, role) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt_user) {
            mysqli_stmt_bind_param($stmt_user, "ssssis", $nama, $foto, $username, $password, $outlet_id, $role);
            mysqli_stmt_execute($stmt_user);

            if (mysqli_stmt_affected_rows($stmt_user) > 0) {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'User berhasil ditambahkan!',
                                icon: 'success'
                            }).then(() => {
                                window.location.href = './dashboard.php';
                            });
                        });
                      </script>";
            } else {
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Gagal menambahkan user!',
                                icon: 'error'
                            });
                        });
                      </script>";
            }
        } else {
            die("Prepared Statement Error (User): " . mysqli_error($conn));
        }
    } else {
        die("Prepared Statement Error (Outlet): " . mysqli_error($conn));
    }
}
?>

<!-- Tambahkan SweetAlert di bawah -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
