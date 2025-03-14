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
    mysqli_stmt_close($stmt_check); // Tutup statement pengecekan

    // ✅ **Proses upload foto jika ada**
    if (!empty($_FILES["foto"]["name"])) {
        $target_dir = "./profilesPicture/";
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $max_size = 3 * 1024 * 1024; // 3MB
        $max_width = 3840;
        $max_height = 2160;

        $file_info = pathinfo($_FILES["foto"]["name"]);
        $file_ext = strtolower($file_info['extension']);
        $foto = time() . "_" . bin2hex(random_bytes(5)) . "." . $file_ext;
        $target_file = $target_dir . $foto;

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (!is_writable($target_dir)) {
            die("Folder tujuan tidak memiliki izin tulis. Coba jalankan: <code>chmod 777 profilesPicture</code>");
        }

        $file_mime = mime_content_type($_FILES["foto"]["tmp_name"]);
        $valid_mime = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file_mime, $valid_mime)) {
            die("Format file tidak diizinkan: " . $file_mime);
        }

        if ($_FILES["foto"]["size"] > $max_size) {
            die("Ukuran file terlalu besar! Maks 3MB.");
        }

        list($width, $height) = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($width > $max_width || $height > $max_height) {
            die("Resolusi gambar terlalu besar! Maks 3840x2160.");
        }

        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            die("Gagal memindahkan file. Cek izin folder dan pastikan direktori ada.");
        }

        $foto = $target_file; // Update nama file foto yang diupload
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
