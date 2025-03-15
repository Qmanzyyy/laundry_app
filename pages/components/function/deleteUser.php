<?php
error_reporting(E_ALL);
ob_start();
require_once "../../../config/db.php";
header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    ob_clean();
    echo "Error: ID tidak ditemukan.";
    exit();
}

$id = intval($_POST['id']);
error_log("deleteUser.php: ID diterima = " . $id);

$conn->begin_transaction();
try {
    $stmt1 = $conn->prepare("DELETE FROM tb_karyawan WHERE id_user = ?");
    if (!$stmt1) {
        error_log("Gagal menyiapkan statement tb_karyawan: " . $conn->error);
        throw new Exception("Gagal menyiapkan statement tb_karyawan");
    }
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    if ($stmt1->error) {
        error_log("Eksekusi gagal untuk tb_karyawan: " . $stmt1->error);
        throw new Exception($stmt1->error);
    }
    
    $stmt2 = $conn->prepare("DELETE FROM tb_user WHERE id = ?");
    if (!$stmt2) {
        error_log("Gagal menyiapkan statement tb_user: " . $conn->error);
        throw new Exception("Gagal menyiapkan statement tb_user");
    }
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    if ($stmt2->error) {
        error_log("Eksekusi gagal untuk tb_user: " . $stmt2->error);
        throw new Exception($stmt2->error);
    }
    
    $conn->commit();
    ob_clean();
    echo "Success: Data karyawan berhasil dihapus.";
} catch (Exception $e) {
    $conn->rollback();
    ob_clean();
    error_log("deleteUser.php: Exception ditangkap: " . $e->getMessage());
    echo "Error: Terjadi kesalahan: " . $e->getMessage();
}
?>
