<?php
$query = "
    SELECT 
        t.id, t.tgl, p.jenis, p.jumlah, p.harga, t.deleted_at
    FROM tb_transaksi t
    JOIN tb_paket p ON t.id = p.id
    WHERE t.deleted_at IS NULL
";

$result = mysqli_query($conn, $query);

$dataTransaksi = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataTransaksi[] = $row;
}
?>

<main class=" min-h-screen">
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold text-center mb-6">Riwayat Transaksi</h1>

        <!-- Filter Tanggal -->
        <div class="flex flex-col sm:flex-row items-end justify-center gap-6 p-6 mb-6">
            <div class="flex flex-col w-full sm:w-auto">
                <label for="date" class="text-sm text-gray-600 font-medium mb-2">Cetak dari tanggal</label>
                <input type="date" name="date" id="date"
                    class="w-full sm:w-56 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <div class="hidden sm:flex items-center text-gray-400 text-xl font-semibold">→</div>

            <div class="flex flex-col w-full sm:w-auto">
                <label for="sdate" class="text-sm text-gray-600 font-medium mb-2">Sampai tanggal</label>
                <input type="date" name="date" id="sdate"
                    class="w-full sm:w-56 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <button
                class="self-end inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 9V2h12v7M6 18h12v4H6v-4zM6 14h12v2H6v-2zM6 10h12v2H6v-2z" />
                </svg>
                Cetak
            </button>
        </div>

        <!-- Tabel Transaksi -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">No</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Tanggal & Waktu</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Jenis Cuci</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Jumlah</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Total Harga</th>
                        <?php if ($_SESSION['user_role'] != 'kasir'):?>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($dataTransaksi as $row): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm"><?= $no++ ?></td>
                            <td class="px-4 py-2 text-sm"><?= $row['tgl'] ?></td>
                            <td class="px-4 py-2 text-sm"><?= $row['jenis'] ?></td>
                            <td class="px-4 py-2 text-sm"><?= $row['jumlah'] ?></td>
                            <td class="px-4 py-2 text-sm">Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <?php if ($_SESSION['user_role'] != 'kasir'):?>
                            <td class="px-4 py-2 text-sm">
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
                                              clip-rule="evenodd"/>
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
    </div>
</main>
