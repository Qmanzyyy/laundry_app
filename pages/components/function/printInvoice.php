<?php 
    require_once "./../../../config/db.php";
if (isset($_GET['success'])) {
    $transaksi = $_GET['success'];
    $query = query("SELECT * FROM 
    tb_detail_transaksi dt
    JOIN tb_transaksi t ON dt.id_transaksi = t.id
    JOIN tb_jenis_cuci jc ON t.id_jenis_cuci = jc.id
    JOIN tb_paket_cuci pc ON t.id_jenis_paket = pc.id
    JOIN tb_member m ON t.id_member = m.id 
    WHERE dt.id = '$transaksi'");

    if (!empty($query)) {
        $data = $query[0];
        $paket = $data['harga_paket'];
        $jenis = $data['harga_cuci'];
        $sum = $paket + $jenis;
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }
}

function rupiah($angka) {
  return 'Rp' . number_format($angka, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Invoice</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      color: #333;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }

    .logo {
      font-size: 24px;
      color: blue;
      font-weight: bold;
    }

    .invoice-number {
      text-align: right;
      font-size: 14px;
    }

    .section {
      margin-top: 20px;
    }

    .section h4 {
      border-bottom: 1px solid #999;
      padding-bottom: 5px;
      margin-bottom: 10px;
      color: #555;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #aaa;
      padding: 8px;
      text-align: left;
      font-size: 14px;
    }

    .right {
      text-align: right;
    }

    .total {
      font-weight: bold;
    }

    @media print {
      .no-print {
        display: none;
      }

     body {
  font-family: Arial, sans-serif;
  margin: 20px;
  color: #333;
  position: relative; /* <--- Tambahan penting */
}
    }
    #keterangan {
  position: absolute;
  top: 20%;
  left: 0;
  width: 100%;
  height: 100%;
  font-size: 100px;
  color: blue;
  font-weight: bold;
  display: flex;
  justify-content: center;
  align-items: center;
  opacity: 0.1;
  z-index: 999;
  transform: rotate(-30deg);
  pointer-events: none;
  white-space: nowrap;
}
#z{
    z-index: 1;
}
.center {
  text-align: center;
  vertical-align: middle;
}

.no-border {
  border: none;
  color: #555;
}
.border-s{
  border-right: 1px solid #aaa;
  border-left: 1px solid #aaa;
}
.border-b{
  border-bottom: 1px solid #aaa;
}
  </style>
</head>
<body onload="window.print()">
    
<main id="z">
  <div class="header">
    <div class="logo">RML Laundry</div>
    <div class="invoice-number">
      <strong>INVOICE</strong><br>
      <?= $data['kode_invoice'] ?>
      
    </div>
  </div>

  <h1 id="keterangan"><?= $data['dibayar'] ?></h1>

  <div class="section">
    <strong>UNTUK</strong><br>
    Pembeli: <?= $data['nama']; ?><br>
    Tanggal Pembelian: <?= $data['tgl'] ?><br>
    Alamat: <?= $data['alamat'] ?><br>
    Cara Bayar: <strong><?= $data['cara_bayar'] ?></strong>
    
    
  </div>

  <div class="section">
    <h4>INFO CUCIAN</h4>
    <table>
      <thead>
        <tr>
          <th>Jenis&Paket Cuci</th>
          <th>Harga</th>
          <th>Jumlah(kg)</th>
          <th>Total Cuci</th>
          <?php if($data['cara_bayar'] == 'CASH'):?>
          <th>Uang Tunai</th>
          <th>kembalian</th>
          <?php endif;?>
        </tr>
      </thead>
 <tbody>
  <tr>
    <td class="center">Jenis: <?= $data['jenis_cuci'] ?></td>
    <td class="right"><?= rupiah($data['harga_cuci']) ?></td>
    <td class="center no-border border-s border-b" rowspan="2"><?= $data['qty'] ?></td>
    <td class="center no-border border-s border-b" rowspan="2"><?= rupiah($sum) ?></td>
    <?php if($data['cara_bayar'] == 'CASH'):?>
      <td  class="center no-border border-s border-b" rowspan="2"><?= rupiah($data['uang']) ?></td>
      <td  class="center no-border border-s border-b" rowspan="2"><?= rupiah($data['kembalian']) ?></td>
    <?php endif;?>            
  </tr>
  <tr>
    <td class="center">Paket: <?= $data['paket_cuci'] ?></td>
    <td class="right"><?= rupiah($data['harga_paket']) ?></td>        
  </tr>
</tbody>

    </table>
  </div>

  <div class="section">
    <table>
      <tr>
        <?php if($data['cara_bayar'] == 'COD'){
            echo '<td colspan="3" class="right total">TOTAL YANG HARUS DI BAYAR</td>';
        }else {
            echo '<td colspan="3" class="right total">TOTAL BAYAR</td>';
        }?>
        
        <td class="right total"><?= rupiah($sum) ?></td>
      </tr>
    </table>
  </div>

  <button class="no-print" onclick="window.print()">Cetak Ulang</button>
  <button class="no-print" onclick="window.location.href='../../dashboard.php?tab=kasir'">kembali</button>
</main>
</body>
</html>
