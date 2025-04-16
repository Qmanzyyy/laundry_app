<?php 
// Jika tombol submit ditekan
require_once "./components/function/registerProccess.php";
$outlet = query("SELECT * FROM tb_outlet ORDER BY nama ASC");
?>
<main class="md:p-8 px-6 pt-24">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Register Akun Karyawan</h1>
        <p class="text-gray-500 text-center mb-6 md:text-base text-sm">Silakan isi form berikut untuk mendaftarkan akun karyawan baru.</p>
    
        <form action="" method="post" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label for="nama" class="block text-gray-600 font-semibold">Nama</label>
                        <input type="text" name="nama" id="nama" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
                    </div>
                    <div>
                        <label for="alamat" class="block text-gray-600 font-semibold">Alamat</label>
                        <input type="text" name="alamat" id="alamat" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
                    </div>
                    <div>
                        <label for="tlp" class="block text-gray-600 font-semibold">Telepon</label>
                        <input type="tel" pattern="^(?:\+62|62|08)\d{8,11}$" title="Masukkan nomor telepon dengan format +62, 62, atau 08 diikuti 8-11 digit angka." name="tlp" id="tlp" required minlength="9" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
                    </div>
                    <div>
                        <label for="shift" class="block text-gray-600 font-semibold">Shift</label>
                        <select name="shift" id="shift" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
                            <option disabled selected class="text-gray-500">-- Pilih Shift ---</option>
                            <option value="pagi">Pagi</option>
                            <option value="malam">Malam</option>
                        </select>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                          <label for="username" class="block text-gray-600 font-semibold">Username</label>
                          <input type="text" name="username" id="username" required 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
                      </div>
                      <div class="relative">
                      <label for="password" class="block text-gray-600 font-semibold">Password</label>
                      <input type="password" name="password" id="password" required 
                          class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
                      <img class="w-5 absolute top-1/2 translate-y-1 right-3 transform cursor-pointer" 
                          src="./../img/eye-close.png" alt="Toggle Password" id="eyeicon" />
                    </div>

                  <div>
                        <label for="photo" class="block text-gray-600 font-semibold">Foto Profil</label>
                        <input id="photo" type="file" name="foto" accept="image/*" class="hidden">
                        <div id="croppie-container" class="my-4 hidden"></div>
                        <button type="button" id="cropButton" class="mt-4 bg-black text-white py-2 px-4 rounded-lg hidden hover:bg-gray-800 transition">Crop & Simpan</button>
                        <button type="button" id="uploadButton" class="w-full bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition">Pilih Foto</button>
                        <input type="hidden" name="cropped_image" id="cropped_image">
                  </div>
                  <div>
                        <label for="role" class="block text-gray-600 font-semibold">Level</label>
                        <select name="role" id="role" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
                            <option disabled selected>-- Pilih Level --</option>
                            <?php if($_SESSION['user_role'] == 'owner'):?>
                            <option value="admin">Admin</option>
                            <?php endif;?>
                            <option value="kasir">Kasir</option>
                        </select>
                    </div>
                    <div>
                        <label for="outlet" class="block text-gray-600 font-semibold">Outlet</label>
                        <select name="outlet" id="outlet" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#211C84] focus:outline-none">
                            <?php foreach ($outlet as $o) : ?>
                                <option value="<?= $o['id'] ?>"><?= $o['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-center">
                <button type="submit" name="submit" 
                    class="w-full md:w-1/2 bg-[#211C84] text-white py-3 rounded-lg font-semibold hover:bg-[#1a166b] transition duration-300 shadow-md">
                    Register
                </button>
            </div>
        </form>
    </div>
</main>
<script src="./components/js/loginToggle.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var croppieInstance;
    var croppieContainer = document.getElementById("croppie-container");
    var photoInput = document.getElementById("photo");
    var uploadButton = document.getElementById("uploadButton");
    var cropButton = document.getElementById("cropButton");
    var croppedImageInput = document.getElementById("cropped_image");

    uploadButton.addEventListener("click", function () {
        photoInput.click();
    });

    photoInput.addEventListener("change", function (event) {
        if (event.target.files.length) {
            var reader = new FileReader();
            reader.onload = function (e) {
                if (croppieInstance) {
                    croppieInstance.destroy();
                }

                croppieInstance = new Croppie(croppieContainer, {
                    viewport: { width: 200, height: 200, type: 'square' },
                    boundary: { width: 300, height: 300 },
                    showZoomer: true
                });

                croppieInstance.bind({
                    url: e.target.result
                });

                croppieContainer.classList.remove("hidden");
                cropButton.classList.remove("hidden");
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    });

    cropButton.addEventListener("click", function () {
        croppieInstance.result({ type: "base64", size: "viewport" }).then(function (base64) {
            croppedImageInput.value = base64;
            croppieContainer.innerHTML = `<img src="${base64}" class="rounded-full w-32 h-32 mx-auto">`;
            cropButton.classList.add("hidden");
        });
    });
});
</script>
