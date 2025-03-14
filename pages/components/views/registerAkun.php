<?php 

// Menghubungkan ke database
require './../config/db.php';

// Jika tombol submit ditekan
require_once "./components/function/registerProccess.php";
$outlet = query("SELECT * FROM tb_outlet ORDER BY nama ASC");
?>
<main class="md:p-6 px-6 pt-24 ">
    <div class="bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">👤Register Akun Karyawan</h1>
        <p class="text-gray-500">Silahkan isi form berikut untuk mendaftarkan akun karyawan baru.</p>
    <form action="" method="post" enctype="multipart/form-data" class="mt-6 space-y-4">
      <!-- Grid Layout -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Kolom Kiri -->
        <div class="space-y-4">
          <div>
            <label for="nama" class="block text-gray-600 font-medium">Nama</label>
            <input type="text" name="nama" id="nama" required 
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
          </div>

          <div>
            <label for="alamat" class="block text-gray-600 font-medium">Alamat</label>
            <input type="text" name="alamat" id="alamat" required 
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
          </div>

          <div>
            <label for="tlp" class="block text-gray-600 font-medium">Telepon</label>
            <input type="text" name="tlp" id="tlp" required 
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
          </div>
          
          <div>
            <label for="shift" class="block text-gray-600 font-medium">Shift</label>
            <select name="shift" id="shift" required
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
              <option value="pagi">Pagi</option>
              <option value="malam">Malam</option>
            </select>
          </div>
        </div>

        <!-- Kolom Kanan -->
        <div class="space-y-4">
          <div>
            <label for="username" class="block text-gray-600 font-medium">Username</label>
            <input type="text" name="username" id="username" required 
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
          </div>

          <div>
            <label for="password" class="block text-gray-600 font-medium">Password</label>
            <input type="password" name="password" id="password" required 
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
          </div>

                  <!-- Foto Profil -->
        <div>
          <label for="photo" class="block text-gray-600 font-medium">Foto Profil</label>
          <input id="photo" type="file" name="foto" accept="image/*" 
                 class="block w-full text-sm text-gray-500 
                        file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm 
                        file:font-semibold file:bg-gray-300 file:text-blue-700 hover:file:text-white hover:file:bg-blue-700">
        </div>

          <div>
            <label for="role" class="block text-gray-600 font-medium">Role</label>
            <select name="role" id="role" required
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
              
              <option value="admin">Admin</option>
              <option value="kasir">Kasir</option>
              <option value="petugas">Petugas</option>
            </select>
          </div>
          
          <div>
            <label for="outlet" class="block text-gray-600 font-medium">Outlet</label>
            <select name="outlet" id="outlet" required
              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
              <?php foreach ($outlet as $o) : ?>
                <option value="<?= $o['id'] ?>"><?= $o['nama'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

      </div> <!-- End Grid -->

      <!-- Tombol Submit -->
      <div class="mt-6 flex justify-center">
        <button type="submit" name="submit" 
          class="w-full md:w-1/2 bg-[#211C84] text-white py-3 rounded-lg font-semibold hover:bg-[#1a166b] transition duration-300">
          Register
        </button>
      </div>
      
    </form>
        



<script src="./components/js/loginToggle.js"></script>
