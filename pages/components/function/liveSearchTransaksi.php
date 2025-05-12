<?php
$query = "
    SELECT 
        t.id, t.tgl,m.nama, j.jenis_cuci, p.jumlah, p.harga, t.deleted_at
    FROM tb_transaksi t
    JOIN tb_paket p ON t.id = p.id
    JOIN tb_jenis_cuci j ON t.id_jenis_cuci = j.id
    JOIN tb_member m ON t.id_member = m.id
    WHERE t.deleted_at IS NULL
";

$result = mysqli_query($conn, $query);

$dataTransaksi = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataTransaksi[] = $row;
}
?>
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
            <?php if ($_SESSION['user_role'] != 'kasir'): ?>
              <th class="px-4 py-2 text-center font-semibold whitespace-nowrap">Aksi</th>
            <?php endif; ?>
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
              <?php if ($_SESSION['user_role'] != 'kasir'): ?>
                <td class="px-4 py-2 whitespace-nowrap text-center">
                  <a href="#"
                    onclick="softDelete(<?= $row['id'] ?>)"
                    class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M6 9V2h12v7M6 18h12v4H6v-4zM6 14h12v2H6v-2zM6 10h12v2H6v-2z" />
                     </svg>
                    cetak
                  </a>
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
                </td>
              <?php endif; ?>
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