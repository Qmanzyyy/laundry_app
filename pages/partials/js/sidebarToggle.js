  // Ambil elemen tombol 1 dan tombol 2
  const menuBtn = document.getElementById('menuBtn');
  const menuBtn2 = document.getElementById('menuBtn2');  // ganti 'menbuBtn2' menjadi 'menuBtn2'

  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebar-overlay');

  // Fungsi toggle sidebar
  function toggleSidebar() {
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
  }

  // Event listener tombol 1
  menuBtn.addEventListener('click', toggleSidebar);

  // Event listener tombol 2
  menuBtn2.addEventListener('click', toggleSidebar);

  // Klik overlay untuk menutup sidebar
  overlay.addEventListener('click', () => {
    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
  });
  
