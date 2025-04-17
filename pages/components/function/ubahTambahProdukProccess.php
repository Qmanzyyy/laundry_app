<?php 
if (isset($_POST['submit'])) {
    $produk = $_POST['Produk'];
    $harga_produk = $_POST['HargaProduk'];
    

    // Validasi dasar
    if ($produk == '' || !is_numeric($harga_produk)) {
        echo "<script>
            alert('Input tidak valid!');
            window.history.back();
        </script>";
        exit();
    }

    mysqli_begin_transaction($conn);

    try {
        // Insert ke tb_jenis_cuci
        $stmt_tb_jenis_cuci = mysqli_prepare($conn, "INSERT INTO tb_jenis_cuci (jenis_cuci, harga_cuci) VALUES (?, ?)");
        if (!$stmt_tb_jenis_cuci) {
            throw new Exception("Prepared Statement Error (tb_jenis_cuci): " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt_tb_jenis_cuci, "si", $produk, $harga_produk);
        if (!mysqli_stmt_execute($stmt_tb_jenis_cuci)) {
            throw new Exception("Gagal insert tb_jenis_cuci: " . mysqli_stmt_error($stmt_tb_jenis_cuci));
        }
        mysqli_stmt_close($stmt_tb_jenis_cuci);

        mysqli_commit($conn);

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Produk dan paket berhasil ditambahkan!',
                icon: 'success'
            }).then(() => window.location.href = './dashboard.php?tab=tambahProdukPaket');
        </script>";

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: '" . addslashes($e->getMessage()) . "',
                icon: 'error'
            }).then(() => window.history.back());
        </script>";
    }
}

if (isset($_POST['submitPaket'])) {
    $paket = $_POST['Paket'];
    $harga_paket = $_POST['HargaPaket'];
    

    // Validasi dasar
    if ($paket == '' || !is_numeric($harga_paket)) {
        echo "<script>
            alert('Input tidak valid!');
            window.history.back();
        </script>";
        exit();
    }

    mysqli_begin_transaction($conn);

    try {
        // Insert ke tb_paket_cuci
        $stmt_paket_cuci = mysqli_prepare($conn, "INSERT INTO tb_paket_cuci (paket_cuci, harga_paket) VALUES (?, ?)");
        if (!$stmt_paket_cuci) {
            throw new Exception("Prepared Statement Error (tb_paket_cuci): " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt_paket_cuci, "si", $paket, $harga_paket);
        if (!mysqli_stmt_execute($stmt_paket_cuci)) {
            throw new Exception("Gagal insert tb_paket_cuci: " . mysqli_stmt_error($stmt_paket_cuci));
        }
        mysqli_stmt_close($stmt_paket_cuci);

        mysqli_commit($conn);

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'paket berhasil ditambahkan!',
                icon: 'success'
            }).then(() => window.location.href = './dashboard.php?tab=tambahProdukPaket');
        </script>";

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: '" . addslashes($e->getMessage()) . "',
                icon: 'error'
            }).then(() => window.history.back());
        </script>";
    }
}
