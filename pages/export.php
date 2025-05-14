<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_transaksi.xls");
header("Pragma: no-cache");
header("Expires: 0");
require_once "../config/db.php"; // Pastikan koneksi database di-*require*
require_once "./components/function/searchTransaksi.php"; // Pastikan fungsi searchTransaksi di-*require*
// Cek apakah tanggal awal dan tanggal akhir ada di dalam request
if (isset($_POST['tanggal_awal']) && isset($_POST['tanggal_akhir'])) {
    $tanggalAwal = mysqli_real_escape_string($conn, $_POST['tanggal_awal']);
    $tanggalAkhir = mysqli_real_escape_string($conn, $_POST['tanggal_akhir']);
} else {
    die("Tanggal awal dan akhir harus diisi.");
}

// Query untuk mengambil data transaksi berdasarkan rentang tanggal
$query = "
    SELECT 
        t.id, t.tgl, m.nama, j.jenis_cuci, p.jumlah, p.harga
    FROM tb_transaksi t
    JOIN tb_paket p ON t.id = p.id
    JOIN tb_jenis_cuci j ON t.id_jenis_cuci = j.id
    JOIN tb_member m ON t.id_member = m.id
    WHERE t.deleted_at IS NULL
    AND t.tgl BETWEEN '$tanggalAwal' AND '$tanggalAkhir'
    ORDER BY t.tgl ASC
";

$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Gagal mengambil data transaksi: " . mysqli_error($conn));
}

// Cek apakah ada data transaksi
if (mysqli_num_rows($result) === 0) {
    die("Tidak ada data transaksi pada rentang tanggal yang dipilih.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <p>Tanggal Awal: <?= htmlspecialchars($tanggalAwal) ?></p>
    <p>Tanggal Akhir: <?= htmlspecialchars($tanggalAkhir) ?></p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal & Waktu</th>
                <th>Pemesan</th>
                <th>Jenis Cuci</th>
                <th>Jumlah (kg)</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['tgl']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['jenis_cuci']) ?></td>
                    <td><?= htmlspecialchars($row['jumlah']) ?></td>
                    <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>