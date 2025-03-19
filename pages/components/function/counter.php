<?php 
require_once "./../config/db.php";

// Total Pegawai (Kecuali Owner)
$pegawai = query("SELECT COUNT(*) AS total FROM tb_karyawan WHERE posisi != 'owner'");
$totalPegawai = $pegawai[0]['total'];

// Role Counter
$usersByRole = query("SELECT role, COUNT(*) AS total FROM tb_user GROUP BY role");

// Total akun yang terdaftar
$user = query("SELECT Count(*) AS total FROM tb_user");
$totalUser = $user[0]['total'];

// Total outlet yang terdaftar
$outlet = query("SELECT Count(*) AS total FROM tb_outlet");
$totaloutlet = $outlet[0]['total'];

// Total transaksi yang terdaftar
$transaksi = query("SELECT Count(*) AS total FROM tb_transaksi");
$totaltransaksi = $transaksi[0]['total'];
?>