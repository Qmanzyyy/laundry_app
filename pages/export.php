<?php
session_start();
require_once "../config/db.php";
require_once "./components/function/searchTransaksi.php";

if (!empty($_POST['tanggal_awal']) && !empty($_POST['tanggal_akhir'])) {

    $tanggalAwal = mysqli_real_escape_string($conn, $_POST['tanggal_awal']);
    $tanggalAkhir = mysqli_real_escape_string($conn, $_POST['tanggal_akhir']);

    // Bangun query SQL dulu dalam bentuk string
    $sql = "SELECT 
                t.id, t.tgl, m.nama, j.jenis_cuci, p.jumlah, p.harga, 
                jc.harga_cuci, pc.harga_paket, u.id_outlet, o.nama AS outlet, o.id AS outlet_id
            FROM tb_detail_transaksi dt
            JOIN tb_transaksi t ON dt.id = t.id
            JOIN tb_paket p ON t.id = p.id
            JOIN tb_jenis_cuci j ON t.id_jenis_cuci = j.id
            JOIN tb_member m ON t.id_member = m.id
            JOIN tb_jenis_cuci jc ON t.id_jenis_cuci = jc.id
            JOIN tb_paket_cuci pc ON t.id_jenis_paket = pc.id
            JOIN tb_user u ON t.id_user = u.id
            JOIN tb_outlet o ON u.id_outlet = o.id
            WHERE t.deleted_at IS NULL
            AND t.tgl BETWEEN '$tanggalAwal 00:00:00' AND '$tanggalAkhir 23:59:59'";

    // Filter outlet jika user kasir
    if ($_SESSION['user_role'] == 'kasir') {
        $outlet = mysqli_real_escape_string($conn, $_SESSION['user_outlet']);
        $sql .= " AND o.id = '$outlet'";
    }elseif(isset($_GET['outlet']) && $_SESSION['user_role'] != "kasir" && !empty($_GET['outlet'])){
        $outlet = $_GET['outlet'];
        $sql .= " AND o.id = '$outlet'";
    }

    $sql .= " ORDER BY t.tgl ASC";

    // Eksekusi query
    $query = query($sql);

    if (!$query) {
        die("Gagal mengambil data transaksi: " . mysqli_error($conn));
    }

    // Kelompokkan data per outlet
    $grouped = [];
    foreach ($query as $row) {
        $id_outlet = $row['id_outlet'];
        $grouped[$id_outlet]['nama_outlet'] = $row['outlet'];
        $grouped[$id_outlet]['data'][] = $row;
    }

    // Lanjutkan HTML dan cetakan...
?>

    <!DOCTYPE html>
<html>
<head>
  <title>Data Transaksi</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      font-family: sans-serif;
    }

    th, td {
      border: 1px solid #999;
      padding: 8px;
      text-align: left;
    }
    .no-border{
        border:none;
    }
    .no-print {
      margin: 10px;
    }

    /* CSS Khusus saat print */
    @media print {
      .no-print {
        display: none;
      }

      body {
        margin: 0;
        font-size: 12pt;
      }

      table {
        width: 100%;
      }
    }
  </style>
</head>
<body onload="window.print()">

  <h2 class="">Laporan Transaksi</h2>
   <?php foreach ($grouped as $outlet): ?>
  <h4><?= "laporan dari outlet: ". $outlet['nama_outlet'] ?></h4>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Pelanggan</th>
        <th>Tanggal</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; $grandTotal = 0; foreach ($outlet['data'] as $qr): ?>
        <?php 
          $paket = $qr['harga_paket'];
          $jenis = $qr['harga_cuci'];
          $total = $paket + $jenis;
          $grandTotal += $total;
        ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= $qr['nama'] ?></td>
          <td><?= $qr['tgl'] ?></td>
          <td><?= number_format($total, 0, ',', '.') ?></td>
        </tr>
      <?php endforeach; ?>
      <tr>
        <td class="no-border"></td>
        <td class="no-border"></td>
        <td><strong>Total Semua</strong></td>
        <td><strong>Rp <?= number_format($grandTotal, 0, ',', '.') ?></strong></td>
      </tr>
    </tbody>
  </table>
  <hr>
<?php endforeach; ?>

  <button class="no-print" onclick="window.print()">Cetak Lagi</button>
  <button class="no-print" onclick="window.location.href='./dashboard.php?tab=riwayatTransaksi'">kembali</button>

</body>
</html>

    <?php
}
else{
    header("Location: ./dashboard.php?tab=riwayatTransaksi");
}
?>
