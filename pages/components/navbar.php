<?php
$sql = "
    SELECT o.nama AS outlet
    FROM tb_user u
    JOIN tb_outlet o ON u.id_outlet = o.id
";

if (isset($_SESSION['user_outlet'])) {
    $outlet = (int) $_SESSION['user_outlet'];
    $sql .= " WHERE o.id = $outlet";
}

$userOutlet = query($sql); // Misal hasilnya array of rows
$namaOutlet = isset($userOutlet[0]['outlet']) ? $userOutlet[0]['outlet'] : 'Tidak diketahui';
?>
<!-- NAVBAR -->

<header id="navbar" class="sticky top-0 z-20 bg-white shadow-sm transition-all duration-300 ease-in-out flex items-center justify-between py-4 px-6">
  <!-- Left: Hamburger menu (untuk mobile) -->
  <button id="menuBtn" class="cursor-pointer hover:text-white p-2 rounded-full hover:bg-blue-600 focus:outline-none">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>

  <!-- Middle: Search bar (opsional) -->
  <!-- <div class="flex-1 mx-4">
    <div class="relative">
      <input type="search" placeholder="Type to search...">
    </div>
  </div> -->

  <!-- Right: User info -->
  <div class="flex items-center space-x-4">
    <div class="flex flex-col">
      <span class="text-sm font-semibold"><?= $_SESSION['user_name']; ?></span>
      <div>
        <span class="text-xs text-blue-500 font-light"><?= ucfirst($_SESSION['user_role']); ?></span>
        <span class="text-xs text-gray-500 font-light">outlet: <?= $namaOutlet; ?></span>
      </div>
      
    </div>
    <!-- Foto profil jadi tombol untuk buka modal -->
    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
      <img class="rounded-full cursor-pointer" src="<?= htmlspecialchars($photo); ?>" alt="Profile Photo" onclick="toggleModal('profileModal')"/>
    </div>
  </div>
</header>

<!-- MODAL: Detail User -->
<div id="profileModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50" onclick="closeModal(event)">
  <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-2" onclick="event.stopPropagation()">
    <h2 class="text-lg font-semibold mb-2">User Profile</h2>
    <div class="flex flex-col items-center">
      <div class="relative w-20 h-20 mb-4 group">
        <img class="cursor-pointer rounded-full w-full h-full ring-2 ring-transparent transition duration-200 group-hover:ring-blue-300" src="<?= htmlspecialchars($photo); ?>" alt="Profile Photo" onclick="editPhoto()"/>
        <button type="button" class="absolute top-0 right-0 bg-white rounded-full p-1 text-gray-600 group-hover:bg-blue-500 group-hover:text-white transition transform translate-x-1/4 -translate-y-1/4 shadow " onclick="editPhoto()">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M15.232 5.232l3.536 3.536M2 18.768l4.243-4.243M14.768 2.768a2.828 2.828 0 014 0l2.464 2.464a2.828 2.828 0 010 4l-10 10a4 4 0 01-2.828 1.172H4a1 1 0 01-1-1v-4a4 4 0 011.172-2.828l10-10z"></path>
          </svg>
        </button>
      </div>
      <p class="text-sm font-semibold"><?= $_SESSION['user_name']; ?></p>
      <p class="text-xs text-gray-500"><?= ucfirst($_SESSION['user_role']); ?></p>
    </div>
    <button type="button" onclick="toggleModal('profileModal')" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Close</button>
  </div>
</div>

<script>
  function editPhoto() {
    alert('Fitur ubah foto profil belum diimplementasikan!');
  }
  
  function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.toggle('hidden');
    modal.classList.toggle('flex');
  }
  
  function closeModal(event) {
    if (event.target === event.currentTarget) {
      toggleModal('profileModal');
    }
  }
</script>
<script>
  const navbar = document.getElementById('navbar');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 10) {
      navbar.classList.add('shadow-2xl');
      navbar.classList.remove('shadow-sm');
    } else {
      navbar.classList.remove('shadow-2xl');
      navbar.classList.add('shadow-sm');
    }
  });
</script>

