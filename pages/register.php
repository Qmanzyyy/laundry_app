<?php 
  // Memulai sesi
  session_start();

  // Menghubungkan ke database
  require_once './../config/db.php';

  // Memanggil file yang menangani proses registrasi
  require_once './components/function/registerProccess.php'; 

  // Mengecek apakah pengguna sudah login, jika tidak maka diarahkan ke halaman login
  if (!isset($_SESSION['user_id'])) {
      header("Location: ./login.php");
      exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | Employee Management</title>
    <!-- ======= favicon ======== -->
    <link rel="shortcut icon" href="./../favicon.ico" type="image/x-icon">
    <!-- ======= koneksi css ======= -->
    <link rel="stylesheet" href="./../style/style.css" />
</head>
<body class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-300 to-purple-500">
  <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden grid grid-cols-1 md:grid-cols-2 border-2 border-blue-700">
    
    <!-- Profile Section -->
    <div class="p-8">
      <h2 class="text-xl font-semibold text-blue-700 mb-4">Profile</h2>
      <form action="" method="post" class="">
        <label class="text-blue-700 " for="nama">Nama</label>
        <input id="nama" type="text" name="Nama" placeholder="Masukkan Nama" class="w-full p-2 bg-[#ddd] focus:outline-none focus:bg-[#b1b1b1]" required>
        <label class="text-blue-700 " for="alamat">Alamat</label>
        <input id="alamat" type="text" name="alamat" placeholder="Masukkan Alamat" class="w-full p-2 bg-[#ddd] focus:outline-none focus:bg-[#b1b1b1]" required>
        <label class="text-blue-700 " for="no_telp">No. Telp</label>
        <input id="no_telp" type="text" name="no_telp" placeholder="Masukkan No. Telp" class="w-full p-2 bg-[#ddd] focus:outline-none focus:bg-[#b1b1b1]" required>
    </div>
    
    <!-- Account Section -->
    <div class="p-8 bg-blue-700 text-white">
      <h2 class="text-xl font-semibold mb-4">Akun</h2>
      <label for="username">Username</label>
      <input id="username" type="text" name="username" placeholder="Masukkan Username" class="focus:outline-none focus:bg-gray-200 w-full p-2 border rounded-lg text-gray-800 bg-white" required>
      <label for="password">Password</label>
      <div class="bg-white flex justify-center items-center rounded-lg border border-[#7A73D1]">
        <input class="text-black focus:outline-none focus:bg-gray-200 placeholder-gray-500 w-full p-2 rounded-l-lg" type="password" id="password" name="password" placeholder="Masukkan Password" required/>
        <img class="w-5 m-2 cursor-pointer" src="./../img/eye-close.png" alt="" id="eyeicon" />
      </div>
      <label for="role">Role</label>
      <select id="role" name="role" class="focus:outline-none focus:bg-gray-200 bg-white w-full p-2 border rounded-lg text-gray-800" required>
        <option value="kasir">Kasir</option>
        <option value="admin">Admin</option>
        <option value="owner">Owner</option>
      </select>
      <button type="submit" name="submit" class="w-full bg-white text-blue-700 font-semibold py-2 rounded-lg mt-4 hover:bg-gray-200">Register</button>
      </form>
    </div>
  </div>
  
  <script src="./components/js/loginToggle.js"></script>
</body>
</html>
