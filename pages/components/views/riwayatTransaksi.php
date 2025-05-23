<?php
$role = $_SESSION['user_role'];
$id_outlet = $_SESSION['user_outlet'];

$query = "
    SELECT 
        t.id, t.tgl, m.nama, t.id_user, j.jenis_cuci, p.jumlah, p.harga, t.deleted_at, u.id_outlet
    FROM tb_transaksi t
    JOIN tb_paket p ON t.id = p.id
    JOIN tb_jenis_cuci j ON t.id_jenis_cuci = j.id
    JOIN tb_member m ON t.id_member = m.id
    JOIN tb_user u ON t.id_user = u.id
    WHERE t.deleted_at IS NULL
";

// Jika bukan admin atau owner, batasi berdasarkan outlet
if ($role != 'admin' && $role != 'owner') {
    $query .= " AND u.id_outlet = $id_outlet";
}

// Filter berdasarkan GET (tanggal dan outlet)
if (isset($_GET['date1']) && isset($_GET['date2'])) {
    $tanggalAwal = $_GET['date1'];
    $tanggalAkhir = $_GET['date2'];

    if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
        $query .= " AND t.tgl BETWEEN '$tanggalAwal 00:00:00' AND '$tanggalAkhir 23:59:59'";
    } else {
        echo "<script>alert('Tanggal tidak boleh kosong!');</script>";
    }

    // Filter berdasarkan outlet jika ada
    if (isset($_GET['outlet']) && !empty($_GET['outlet'])) {
        $id_outlet = $_GET['outlet'];
        $query .= " AND u.id_outlet = $id_outlet";
    }
}
// Filter berdasarkan outlet jika ada
    if (isset($_GET['outlet']) && !empty($_GET['outlet'])) {
        $id_outlet = $_GET['outlet'];
        $query .= " AND u.id_outlet = $id_outlet";
    }
// Filter berdasarkan POST (tanggal)
if (!empty($_POST['tanggal_awal']) && !empty($_POST['tanggal_akhir'])) {
    $tanggalAwal = $_POST['tanggal_awal'];
    $tanggalAkhir = $_POST['tanggal_akhir'];

    if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
        $query .= " AND t.tgl BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
    } else {
        echo "<script>alert('Tanggal tidak boleh kosong!');</script>";
    }
}

// Jalankan query
$result = mysqli_query($conn, $query);

// Ambil data hasil
$dataTransaksi = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataTransaksi[] = $row;
}

// Ambil data outlet untuk dropdown/filter
$outlet = query("SELECT * FROM tb_outlet ORDER BY nama ASC");
?>

<main class="min-h-dvh overflow-x-auto py-6 px-6">
  <div class="mx-auto rounded-md p-4 sm:p-6 max-w-screen">
    <h1 class="text-2xl font-bold text-center mb-6 text-blue-600">Riwayat Transaksi</h1>
<form method="GET" action="">
  <input type="hidden" name="tab" value="riwayatTransaksi">
    <!-- Filter Tanggal -->
    <div class="flex flex-wrap sm:flex-nowrap items-end justify-center gap-4 sm:gap-6 p-4 sm:p-6 mb-6">
      <div class="flex flex-col w-full sm:w-auto">
        <label for="date" class="text-sm text-gray-600 font-medium mb-2">Cetak dari tanggal</label>
        <input type="date" name="date1" id="tanggal_awal"
          class="w-full sm:w-56 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" value="<?php if(isset($_GET['date1'])){echo $_GET['date1'];}?>">
      </div>

      <div class="hidden sm:flex items-center text-gray-400 text-xl font-semibold">→</div>

      <div class="flex flex-col w-full sm:w-auto">
        <label for="sdate" class="text-sm text-gray-600 font-medium mb-2">Sampai tanggal</label>
        <input type="date" name="date2" id="tanggal_akhir"
          class="w-full sm:w-56 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"  value="<?php if(isset($_GET['date2'])){echo $_GET['date2'];}?>">
      </div>
      <?php if(isset($_GET['outlet'])):?><input type="hidden" name="outlet" value="<?php if (!empty($_GET['outlet'])){echo $_GET['outlet'];}?>"><?php endif;?>
      <button
        id="tampilkan"
        type="submit"
        class="self-end inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M6 9V2h12v7M6 18h12v4H6v-4zM6 14h12v2H6v-2zM6 10h12v2H6v-2z" />
        </svg>
        tampilkan
      </button>
</form>
      <form action="export.php?outlet=<?php if(isset($_GET['outlet'])){echo $_GET['outlet'];} ?>" method="post">
      <input type="hidden" name="tanggal_awal" value="<?php if(isset($_GET['date1'])){echo $_GET['date1'];}  ?>">
      <input type="hidden" name="tanggal_akhir" value="<?php if(isset($_GET['date2'])){echo $_GET['date2'];} ?>"
       id="tanggal_akhir_input">
      <button
        id="cetak"
        class="self-end inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M6 9V2h12v7M6 18h12v4H6v-4zM6 14h12v2H6v-2zM6 10h12v2H6v-2z" />
        </svg>
        Cetak
      </button>
      </form>
      <!-- Outlet -->
       <?php if ($_SESSION['user_role'] != "kasir"):?>
      <form action="" method="get">
        <input type="hidden" name="tab" value="riwayatTransaksi">
        <?php if (isset($_GET['date1'])):?><input type="hidden" name="date1" value="<?php if (isset($_GET['date1'])) {echo $_GET['date1'];}?>"><?php endif;?>
        <?php if (isset($_GET['date2'])):?><input type="hidden" name="date2" value="<?php if (isset($_GET['date2'])) {echo $_GET['date2'];}?>"><?php endif;?>
          <div class="flex flex-col">
  <label for="outlet" class="text-sm text-gray-600 font-medium mb-2">Pilih Outlet</label>
  <select name="outlet" id="outlet" onchange="this.form.submit()" class="w-full sm:w-56 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
    <option disabled selected hidden>
      <?php
        if (isset($_GET['outlet'])) {
          echo empty($_GET['outlet']) ? 'Semua Outlet' : htmlspecialchars($_GET['outlet']);
        } else {
          echo 'Pilih Outlet';
        }
      ?>
    </option>

    <!-- Opsi untuk menampilkan semua -->
    <option value="">Tampilkan Semua</option>
    <!-- Daftar outlet -->
    <?php foreach ($outlet as $ot) : ?>
      <option value="<?= $ot['id'] ?>" <?= (isset($_GET['outlet']) && $_GET['outlet'] == $ot['id']) ? 'selected' : '' ?>>
        <?= $ot['nama'] ?>
      </option>
    <?php endforeach; ?>

  </select>
</div>
      </form>
      <?php endif;?>
    </div>

    <!-- Tabel Transaksi (Desktop) -->
    <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 hidden md:block">
      <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow text-sm">
        <thead class="bg-gray-500 text-white">
          <tr>
            <th class="px-4 py-2 text-left font-semibold whitespace-nowrap">No</th>
            <th class="px-4 py-2 text-left font-semibold whitespace-nowrap">Tanggal & Waktu</th>
            <th class="px-4 py-2 text-left font-semibold whitespace-nowrap">Pemesan</th>
            <th class="px-4 py-2 text-left font-semibold whitespace-nowrap">Jenis Cuci</th>
            <th class="px-4 py-2 text-left font-semibold whitespace-nowrap">Jumlah(kg)</th>
            <th class="px-4 py-2 text-left font-semibold whitespace-nowrap">Total Harga</th>
              <th class="px-4 py-2 text-center font-semibold whitespace-nowrap">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($dataTransaksi as $row): ?>
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-2 whitespace-nowrap"><?= $no++ ?></td>
              <td class="px-4 py-2 whitespace-nowrap"><?= $row['tgl'] ?></td>
              <td class="px-4 py-2 whitespace-nowrap"><?= $row['nama'] ?></td>
              <td class="px-4 py-2 whitespace-nowrap"><?= $row['jenis_cuci'] ?></td>
              <td class="px-4 py-2 whitespace-nowrap"><?= $row['jumlah'] ?></td>
              <td class="px-4 py-2 whitespace-nowrap">Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
              
                <td class="px-4 py-2 whitespace-nowrap text-center">
                  
                  <a href="./components/function/printInvoice.php?success=<?= $row['id'] ?>"
                    class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M6 9V2h12v7M6 18h12v4H6v-4zM6 14h12v2H6v-2zM6 10h12v2H6v-2z" />
                     </svg>
                    cetak
                  </a>
 
                  <?php if ($_SESSION['user_role'] != 'kasir'): ?>
                  <a href="#"
                    onclick="softDelete(<?= $row['id'] ?>)"
                    class="inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd"
                        d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 
                        2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 
                        2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 
                        0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 
                        0-2 0v8a1 1 0 1 0 2 0v-8Z"
                        clip-rule="evenodd" />
                    </svg>
                    Hapus
                  </a>
                  <?php endif; ?>
                </td>
              
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <!-- Mobile Card View -->
    <div class="block md:hidden">
      <?php foreach ($dataTransaksi as $row) : ?>
        <div class="bg-white shadow-md rounded-lg p-4 mb-4 text-sm">
          <div class="grid grid-cols-2 gap-y-2">
            <p class="font-semibold text-gray-600">Tanggal:</p>
            <p><?= $row['tgl'] ?></p>

            <p class="font-semibold text-gray-600">Nama:</p>
            <p><?= $row['nama'] ?></p>

            <p class="font-semibold text-gray-600">Jenis Cuci:</p>
            <p><?= $row['jenis_cuci'] ?></p>

            <p class="font-semibold text-gray-600">Jumlah:</p>
            <p><?= $row['jumlah'] ?> kg</p>

            <p class="font-semibold text-gray-600">Total:</p>
            <p>Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
          </div>

          <?php if ($_SESSION['user_role'] != 'kasir'): ?>
          <div class="text-white flex justify-end gap-2 mt-4">
            <button class="p-2 rounded-lg bg-blue-600 hover:bg-blue-700 transition">Cetak</button>
            <button onclick="softDelete(<?= $row['id'] ?>)" class="p-2 rounded-lg bg-red-600 hover:bg-red-700 transition">Hapus</button>
          </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</main>
