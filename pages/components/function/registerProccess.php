<?php
require_once "./../config/db.php";

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $tlp = mysqli_real_escape_string($conn, $_POST['tlp']);
    $shift = mysqli_real_escape_string($conn, $_POST['shift']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $outlet = mysqli_real_escape_string($conn, $_POST['outlet']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $foto = "default.png"; // Foto default jika tidak diupload

    // Menentukan gaji berdasarkan role
    $gaji = match ($role) {
        'kasir'   => 2500000.00,
        'admin'   => 3000000.00,
        'petugas' => 2000000.00,
        default   => NULL // Owner tidak memiliki gaji
    };

    // ✅ **Cek apakah username sudah ada di database**
    $stmt_check = mysqli_prepare($conn, "SELECT id FROM tb_user WHERE username = ?");
    mysqli_stmt_bind_param($stmt_check, "s", $username);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Username sudah digunakan. Silakan pilih username lain.',
                icon: 'error'
            }).then(() => {
                window.history.back();
            });
        </script>";
        exit; // Hentikan proses jika username sudah ada
    }
    mysqli_stmt_close($stmt_check);

    // ✅ **Proses upload foto jika ada cropped image (Base64)**
    if (!empty($_POST['cropped_image'])) {
        $cropped_image = $_POST['cropped_image'];
        
        // Validasi format Base64
        $image_parts = explode(";base64,", $cropped_image);
        if (count($image_parts) !== 2) {
            die("Format gambar tidak valid.");
        }

        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = strtolower($image_type_aux[1]);
        $allowed_types = ['jpeg', 'jpg', 'png', 'gif'];

        if (!in_array($image_type, $allowed_types)) {
            die("Format gambar harus JPG, PNG, atau GIF.");
        }

        // Decode Base64 menjadi file gambar
        $image_base64 = base64_decode($image_parts[1]);
        $foto = time() . "_" . bin2hex(random_bytes(5)) . "." . $image_type;
        $file_path = "./profilesPicture/" . $foto;

        // Simpan gambar ke folder
        if (!file_put_contents($file_path, $image_base64)) {
            die("Gagal menyimpan gambar.");
        }
    }

    // ✅ **Mulai transaksi database**
    mysqli_begin_transaction($conn);
    try {
        // Insert ke tb_user
        $stmt_user = mysqli_prepare($conn, "INSERT INTO tb_user (nama, foto, username, password, id_outlet, role) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt_user) {
            throw new Exception("Error pada query tb_user: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt_user, "ssssis", $nama, $foto, $username, $password, $outlet, $role);
        mysqli_stmt_execute($stmt_user);
        
        // Simpan ID user yang baru dibuat sebelum menutup statement
        $id_user = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt_user);

        // Jika bukan owner, tambahkan ke tb_karyawan
        if ($role !== 'owner') {
            $stmt_karyawan = mysqli_prepare($conn, "INSERT INTO tb_karyawan (nama, alamat, no_telp, posisi, id_user, gaji, shift_kerja) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt_karyawan) {
                throw new Exception("Error pada query tb_karyawan: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt_karyawan, "ssssids", $nama, $alamat, $tlp, $role, $id_user, $gaji, $shift);
            mysqli_stmt_execute($stmt_karyawan);
            mysqli_stmt_close($stmt_karyawan);
        }

        // Commit transaksi jika semua berhasil
        mysqli_commit($conn);

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'User berhasil ditambahkan!',
                icon: 'success'
            }).then(() => {
                window.location.href = './dashboard.php?tab=registerAkun';
            });
        </script>";
    } catch (Exception $e) {
        // Jika ada error, rollback semua perubahan
        mysqli_rollback($conn);
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: '" . addslashes($e->getMessage()) . "',
                icon: 'error'
            });
        </script>";
    }
}
?>
