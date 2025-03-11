<?php 
  session_start();
  require_once './../config/db.php'; // Koneksi database
  require_once './components/function/registerProccess.php'; // proses Register
    if (!isset($_SESSION['user_id'])) {
        header("Location: ./login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register | Employee Management</title>
  <link rel="shortcut icon" href="./../favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="./../style/tailwind.css" />
</head>
<body class="h-screen flex justify-center items-center bg-gray-100">
  <form action="" method="post" class="bg-white shadow-lg rounded-lg border-2 border-blue-700 p-8 max-w-lg w-full">
    <h1 class="text-2xl font-semibold text-gray-800 text-center">Register New Employee</h1>
    <hr class="my-4 border-gray-300">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label for="Nama" class="block text-gray-700 font-medium">Nama</label>
        <input class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300" type="text" id="Nama" name="Nama" placeholder="Masukkan Nama" required>
      </div>
      
      <div>
        <label for="alamat" class="block text-gray-700 font-medium">Alamat</label>
        <input class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300" type="text" id="alamat" name="alamat" placeholder="Masukkan Alamat" required>
      </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
      <div>
        <label for="no_telp" class="block text-gray-700 font-medium">No. Telp</label>
        <input class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300" type="text" id="no_telp" name="no_telp" placeholder="Masukkan No. Telp" required>
      </div>
      
      <div>
        <label for="username" class="block text-gray-700 font-medium">Username</label>
        <input class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300" type="text" id="username" name="username" placeholder="Masukkan Username" required>
      </div>
    </div>
    
    <div class="mt-3">
      <label for="password" class="block text-gray-700 font-medium">Password</label>
      <div class="relative flex items-center">
        <input class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300 pr-10" type="password" id="password" name="password" placeholder="Masukkan Password" required>
        <img class="absolute right-3 w-5 cursor-pointer" src="./../img/eye-close.png" alt="Toggle Password" id="eyeicon">
      </div>
      <label id="error-message-password" class="text-red-500 text-xs min-h-5 block mt-1"></label>
    </div>
    
    <div class="">
      <label for="role" class="block text-gray-700 font-medium">Role</label>
      <select id="role" name="role" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300" required>
        <option value="kasir">Kasir</option>
        <option value="admin">Admin</option>
        <option value="owner">Owner</option>
      </select>
    </div>
    
    <button name="submit" class="w-full mt-6 bg-blue-700 hover:bg-blue-800 text-white font-medium py-2 rounded-lg transition" type="submit">
      Register
    </button>
  </form>
  <script src="./components/js/loginToggle.js"></script>
</body>
</html>