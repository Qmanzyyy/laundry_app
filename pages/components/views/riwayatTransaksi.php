<?php
$query = "
    SELECT 
     t.id, t.tgl, p.jenis, p.jumlah, p.harga, t.deleted_at
     FROM tb_transaksi t
     JOIN tb_paket p ON t.id = p.id
     WHERE t.deleted_at IS NULL
";

$result = mysqli_query($conn, $query);
// Fetch semua data ke array
$dataTransaksi = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataTransaksi[] = $row;
}
?>

<main>
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold text-center mb-6">Riwayat Transaksi</h1>
        <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">No</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Tanggal & Waktu</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Nama Produk</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Jumlah</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Total Harga</th>
            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; 
        foreach ($dataTransaksi as $transaksi): ?>
        <tr class=" hover:bg-gray-50">
            <td class="px-4 py-2 text-sm"><?= $no++ ?></td>
            <td class="px-4 py-2 text-sm"><?= $transaksi['tgl'] ?></td>
            <td class="px-4 py-2 text-sm"><?= $transaksi['jenis'] ?></td>
            <td class="px-4 py-2 text-sm"><?= $transaksi['jumlah'] ?></td>
            <td class="px-4 py-2 text-sm">Rp<?= number_format($transaksi['harga'], 0, ',', '.') ?></td>
            <td class="px-4 py-2 text-sm">
                <a href="#"
                   onclick="softDelete(<?= $transaksi['id'] ?>)"
                   class="inline-flex items-center px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                              d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 
                              2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 
                              .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 
                              0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 
                              0-2 0v8a1 1 0 1 0 2 0v-8Z"
                              clip-rule="evenodd"/>
                    </svg>
                    Hapus
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        </div>
    </div>    
</main>