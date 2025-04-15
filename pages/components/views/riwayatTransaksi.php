<?php
$query = "
    SELECT 
     t.id, t.tgl, p.jenis, p.jumlah, p.harga
     FROM tb_transaksi t
     JOIN tb_paket p ON t.id = p.id
";
$result = mysqli_query($conn, $query);
?>
<main>
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold text-center mb-6">Riwayat Transaksi</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">No</th>
                        <th class="py-2 px-4 border-b">Tanggal</th>
                        <th class="py-2 px-4 border-b">Nama Produk</th>
                        <th class="py-2 px-4 border-b">Jumlah</th>
                        <th class="py-2 px-4 border-b">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                <?php
$no = 1;
while ($transaksi = mysqli_fetch_assoc($result)) :
?>
<tr>
    <td class="py-2 px-4 border-b"><?= $no++ ?></td>
    <td class="py-2 px-4 border-b"><?= $transaksi['tgl'] ?></td>
    <td class="py-2 px-4 border-b"><?= $transaksi['jenis'] ?></td>
    <td class="py-2 px-4 border-b"><?= $transaksi['jumlah'] ?></td>
    <td class="py-2 px-4 border-b"><?= $transaksi['harga'] ?></td>
</tr>
<?php endwhile; ?>

                </tbody>
            </table>
        </div>
    </div>    
</main>