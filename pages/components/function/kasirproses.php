<?php
require_once "./../config/db.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['submit'])) {
    // var_dump($_POST);
    // exit;
    // Perbarui nama field: quantity menjadi "qty" dan total harga menjadi "total"
    $required = ['nama', 'alamat', 'jeniskelamin', 'tlp', 'jenis', 'qty', 'namapaket', 'total'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Semua kolom wajib diisi!',
                    icon: 'error'
                }).then(() => window.history.back());
            </script>";
            exit;
        }
    }

    // Sanitize input
    $nama         = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat       = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jeniskelamin = mysqli_real_escape_string($conn, $_POST['jeniskelamin']);
    $tlp          = mysqli_real_escape_string($conn, $_POST['tlp']);
    $jenis        = mysqli_real_escape_string($conn, $_POST['jenis']);
    $namapaket    = mysqli_real_escape_string($conn, $_POST['namapaket']);
    // Ambil total harga dari field "total"
    $harga        = floatval($_POST['total']);
    // Ambil quantity dari field "qty"
    $jumlah       = filter_var($_POST['qty'], FILTER_VALIDATE_INT);
    $status       = "baru";
    if($_POST['carabayar'] == "CASH"){
        $dibayar = "dibayar";
        $uang = $_POST['bayar'];
        $caraBayar = $_POST['carabayar'];
        if ($uang < 0) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'jumlah yang di bayar kurang!',
                    icon: 'error'
                }).then(() => window.history.back());
            </script>";
            exit;
        }
        $kembalian = $_POST['kembalian'];
        if ($kembalian < 0) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'jumlah yang di bayar kurang!',
                    icon: 'error'
                }).then(() => window.history.back());
            </script>";
            exit;
        }
    }else{
        $dibayar        = "belum_dibayar";
        $uang = "belum_dibayar";
        $caraBayar = $_POST['carabayar'];
        $kembalian    = NULL;
    }
    // Session data
    $idoutlet = $_SESSION['user_outlet'] ?? null;
    $iduser   = $_SESSION['user_id'] ?? null;
    $deleted_at = null;
    if (!$idoutlet || !$iduser || $jumlah === false) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Data sesi tidak lengkap atau jumlah tidak valid!',
                icon: 'error'
            }).then(() => window.history.back());
        </script>";
        exit;
    }
    elseif ($jumlah < 1) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'qty tidak bisa negatif atau nol',
                icon: 'error'
            }).then(() => window.history.back());
        </script>";
        exit;
    }

    // Waktu & kode invoice
    date_default_timezone_set('Asia/Jakarta');
    $tanggal      = date("Y-m-d H:i:s");
    $batas_waktu  = date("Y-m-d H:i:s", strtotime("+3 days")); // Contoh batas waktu 3 hari
    $kode_invoice = "INV" . date("YmdHis").$idoutlet.$iduser;

    // nilai kosong
    $diskon         = 0;
    $pajak          = 0;
    mysqli_begin_transaction($conn);
    // var_dump($_POST);
    // exit;
    try {
        // Insert member ke tb_member
        $stmt_member = mysqli_prepare($conn, "INSERT INTO tb_member (nama, alamat, jenis_kelamin, tlp) VALUES (?, ?, ?, ?)");
        if (!$stmt_member) {
            throw new Exception("Prepared Statement Error (tb_member): " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt_member, "ssss", $nama, $alamat, $jeniskelamin, $tlp);
        if (!mysqli_stmt_execute($stmt_member)) {
            throw new Exception("Gagal insert tb_member: " . mysqli_stmt_error($stmt_member));
        }
        $id_member = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt_member);

        // Insert paket ke tb_paket
        $stmt_paket = mysqli_prepare($conn, "INSERT INTO tb_paket (id_outlet, jenis, jumlah, nama_paket, harga) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt_paket) {
            throw new Exception("Prepared Statement Error (tb_paket): " . mysqli_error($conn));
        }
        // Binding dengan tipe: id_outlet (i), jenis (s), jumlah (i), nama_paket (s), harga (d)
        mysqli_stmt_bind_param($stmt_paket, "isisd", $idoutlet, $jenis, $jumlah, $namapaket, $harga);
        if (!mysqli_stmt_execute($stmt_paket)) {
            throw new Exception("Gagal insert tb_paket: " . mysqli_stmt_error($stmt_paket));
        }
        $id_paket = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt_paket);

        // Insert transaksi ke tb_transaksi 
        $stmt_transaksi = mysqli_prepare($conn, "INSERT INTO tb_transaksi (id_outlet, kode_invoice, id_member, tgl, batas_waktu, tgl_bayar, id_jenis_paket,id_jenis_cuci, diskon, pajak, status,cara_bayar, dibayar,uang,kembalian, id_user,deleted_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?)");
        if (!$stmt_transaksi) {
            throw new Exception("Prepared Statement Error (tb_transaksi): " . mysqli_error($conn));
        }
            mysqli_stmt_bind_param($stmt_transaksi, "isisssiiddsssiiis",
            $idoutlet,          // i
            $kode_invoice,     // s
            $id_member,        // i
            $tanggal,          // s (tgl)
            $batas_waktu,      // s
            $tanggal,          // s (tgl_bayar)
            $namapaket,        // i ✅
            $jenis,            // i ✅
            $diskon,           // d
            $pajak,            // d
            $status,           // s
            $caraBayar,       // s  
            $dibayar,            // s 
            $uang,             // i n
            $kembalian,        // i n
            $iduser,           // i
            $deleted_at        // s
        );    
        if (!mysqli_stmt_execute($stmt_transaksi)) {
            throw new Exception("Gagal insert tb_transaksi: " . mysqli_stmt_error($stmt_transaksi));
        }
        $id_transaksi = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt_transaksi);

        // Insert detail transaksi ke tb_detail_transaksi
        $stmt_detailtransaksi = mysqli_prepare($conn, "INSERT INTO tb_detail_transaksi (id_transaksi, id_paket, qty, keterangan) VALUES (?, ?, ?, ?)");
        if (!$stmt_detailtransaksi) {
            throw new Exception("Prepared Statement Error (tb_detail_transaksi): " . mysqli_error($conn));
        }
        mysqli_stmt_bind_param($stmt_detailtransaksi, "iiis", $id_transaksi, $id_paket, $jumlah, $status);
        if (!mysqli_stmt_execute($stmt_detailtransaksi)) {
            throw new Exception("Gagal insert tb_detail_transaksi: " . mysqli_stmt_error($stmt_detailtransaksi));
        }
        $id_detail_transaksi = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt_detailtransaksi);

        mysqli_commit($conn);

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Member, paket, dan transaksi berhasil ditambahkan!',
                icon: 'success'
            }).then(() => window.location.href = './components/function/printInvoice.php?success=$id_detail_transaksi');
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
?>
