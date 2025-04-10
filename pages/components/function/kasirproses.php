<?php
require_once "./../config/db.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Hanya panggil jika sesi belum dimulai
}
// echo '<pre>';
//     var_dump($_POST);
//     var_dump($_SESSION);
//     echo '</pre>';
//     exit;
if (isset($_POST['submit'])) {
    // Validasi awal (semua field harus ada)
    $required = ['nama', 'alamat', 'jeniskelamin', 'tlp', 'jenis', 'jumlah', 'namapaket', 'harga'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Semua kolom wajib diisi!',
                    icon: 'error'
                }).then(() => {
                    window.history.back();
                });
            </script>";
            exit;
        }
    }

    // Ambil dan amankan data input
    $nama         = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat       = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jeniskelamin = mysqli_real_escape_string($conn, $_POST['jeniskelamin']);
    $tlp          = mysqli_real_escape_string($conn, $_POST['tlp']);
    $idoutlet     = $_SESSION['user_outlet'] ?? null;
    $jenis        = mysqli_real_escape_string($conn, $_POST['jenis']);
    // Validasi jumlah dan harga
    $jumlah = filter_var($_POST['jumlah'], FILTER_VALIDATE_INT);
    $harga = $_POST['harga'];
    
    if ($jumlah === false || $harga === false) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Jumlah atau harga tidak valid!',
                icon: 'error'
            }).then(() => {
                window.history.back();
            });
        </script>";
        exit;
    }
    
    $namapaket    = mysqli_real_escape_string($conn, $_POST['namapaket']);

    if (!$idoutlet) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'ID outlet tidak ditemukan di sesi.',
                icon: 'error'
            }).then(() => {
                window.history.back();
            });
        </script>";
        exit;
    }

    mysqli_begin_transaction($conn);
    try {
        // Insert ke tb_member
        $stmt_member = mysqli_prepare($conn, "INSERT INTO tb_member (nama, alamat, jenis_kelamin, tlp) VALUES (?, ?, ?, ?)");
        if (!$stmt_member) {
            throw new Exception("Prepared Statement Error: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt_member, "ssss", $nama, $alamat, $jeniskelamin, $tlp);
        if (!mysqli_stmt_execute($stmt_member)) {
            throw new Exception("Error executing statement for tb_member: " . mysqli_stmt_error($stmt_member));
        }
        mysqli_stmt_close($stmt_member);

        // Insert ke tb_paket
        $stmt_paket = mysqli_prepare($conn, "INSERT INTO tb_paket (id_outlet, jenis, jumlah, nama_paket, harga) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt_paket) {
            throw new Exception("Prepared Statement Error: " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt_paket, "isiss", $idoutlet, $jenis, $jumlah, $namapaket, $harga);
        if (!mysqli_stmt_execute($stmt_paket)) {
            throw new Exception("Error executing statement for tb_paket: " . mysqli_stmt_error($stmt_paket));
        }
        mysqli_stmt_close($stmt_paket);

        mysqli_commit($conn);

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Member dan paket berhasil ditambahkan!',
                icon: 'success'
            }).then(() => {
                window.location.href = './dashboard.php?tab=kasir';
            });
        </script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: '" . addslashes($e->getMessage()) . "',
                icon: 'error'
            }).then(() => {
                window.history.back();
            });
        </script>";
    }
}
?>
