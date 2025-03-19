<?php
// Konfigurasi koneksi database
$host = "localhost";
$username = "root";
$password = "nilou";
$db = "laundry";

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi untuk menjalankan query dan mengembalikan hasilnya
function query($query) {
    global $conn;
    
    if (!$conn) {
        die("Koneksi database tidak tersedia.");
    }

    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error dalam query: " . mysqli_error($conn));
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


// Tidak ada `mysqli_close($conn);` agar koneksi tetap bisa digunakan selama aplikasi berjalan
?>
