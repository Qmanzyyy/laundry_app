<?php
// Menampilkan semua pesan error untuk membantu debugging
error_reporting(E_ALL);
// Mulai output buffering untuk mengendalikan output
ob_start();
// Memanggil file konfigurasi untuk koneksi database
require_once "../../../config/db.php";
// Mengatur header respons agar output berupa teks biasa (plain text)
header('Content-Type: text/plain');

// Memeriksa apakah request adalah POST dan apakah ada parameter 'id' yang dikirimkan
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    // Jika tidak ada ID, hentikan output dan tampilkan pesan error
    ob_clean();
    echo "Error: ID tidak ditemukan.";
    exit(); // Menghentikan eksekusi lebih lanjut
}

// Mengambil nilai ID dari data POST dan memastikan ID adalah integer
$id = intval($_POST['id']);
// Menyimpan informasi tentang ID yang diterima di log untuk keperluan debugging
error_log("deleteUser.php: ID diterima = " . $id);

// Memulai transaksi database untuk memastikan operasi ini dilakukan secara atomik
$conn->begin_transaction();

try {
    // Query untuk menghapus data karyawan berdasarkan ID user
    $sql1 = "DELETE FROM tb_karyawan WHERE id_user = $id";
    // Mengeksekusi query pertama dan memeriksa apakah berhasil
    if (!$conn->query($sql1)) {
        // Jika gagal, log error dan lemparkan pengecualian dengan pesan error
        error_log("Eksekusi gagal untuk tb_karyawan: " . $conn->error);
        throw new Exception($conn->error); // Melempar exception agar transaksi dibatalkan
    }

    // Query untuk menghapus data user berdasarkan ID
    $sql2 = "DELETE FROM tb_user WHERE id = $id";
    // Mengeksekusi query kedua dan memeriksa apakah berhasil
    if (!$conn->query($sql2)) {
        // Jika gagal, log error dan lemparkan pengecualian dengan pesan error
        error_log("Eksekusi gagal untuk tb_user: " . $conn->error);
        throw new Exception($conn->error); // Melempar exception agar transaksi dibatalkan
    }

    // Jika kedua query berhasil, commit transaksi untuk menyimpan perubahan
    $conn->commit();
    ob_clean(); // Membersihkan output buffer sebelum menampilkan hasil
    echo "Success: Data karyawan berhasil dihapus."; // Menampilkan pesan sukses

} catch (Exception $e) {
    // Jika terjadi kesalahan, rollback transaksi untuk membatalkan semua perubahan
    $conn->rollback();
    
    ob_clean(); // Membersihkan output buffer sebelum menampilkan pesan error
    // Mencatat pesan error pada log untuk keperluan debugging
    error_log("deleteUser.php: Exception ditangkap: " . $e->getMessage());
    // Menampilkan pesan kesalahan kepada pengguna
    echo "Error: Terjadi kesalahan: " . $e->getMessage();
}
?>
