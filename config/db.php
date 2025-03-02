<?php
// variabel mysqli_connect 
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "laundry";

// koneksi ke database
    $conn = mysqli_connect($host,$username,$password,$db);

// test apakah databse terkoneksi atau tidak
    // if ($conn->connect_error){
    //     die("koneksi gagal;". $conn->connect_error);
    // }else{
    //     echo "koneksi berhasil";
    // }
?>