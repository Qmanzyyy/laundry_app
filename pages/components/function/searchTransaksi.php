<?php
function searchTransaksi($tanggalAwal, $tanggalAkhir){
    require_once "./../config/db.php";

    $query = "SELECT 
        t.id, t.tgl,m.nama, j.jenis_cuci, p.jumlah, p.harga, t.deleted_at
    FROM tb_transaksi t
    JOIN tb_paket p ON t.id = p.id
    JOIN tb_jenis_cuci j ON t.id_jenis_cuci = j.id
    JOIN tb_member m ON t.id_member = m.id
    WHERE t.deleted_at IS NULL &&
        t.tgl BETWEEN $tanggalAwal AND $tanggalAkhir
    ";
    return query($query);
}