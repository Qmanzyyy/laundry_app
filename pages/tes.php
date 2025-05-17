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

  <h2 class="no-print">Laporan Transaksi</h2>

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
      <tr>
        <td>1</td>
        <td>Miftahur</td>
        <td>2025-05-17</td>
        <td>Rp 20.000</td>
      </tr>
      <tr>
        <td>2</td>
        <td>Yula</td>
        <td>2025-05-16</td>
        <td>Rp 35.000</td>
      </tr>
    </tbody>
  </table>

  <button class="no-print" onclick="window.print()">Cetak Lagi</button>

</body>
</html>
