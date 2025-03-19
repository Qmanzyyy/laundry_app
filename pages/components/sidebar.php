<?php 
// cek login
  include_once 'function/loginChecker.php';
// menu sidebar
  require 'components/function/definition.php';
// role identifier
  $userRole = $_SESSION['user_role'];
?>
<!-- SIDEBAR -->
    <aside id="sidebar" class="fixed z-20 inset-0 flex-none w-64 bg-blue-900 text-white transform -translate-x-full md:translate-x-0 md:relative md:transform-none transition-transform duration-200 ease-in-out">
      <div class="flex flex-col h-full">
        <!-- Brand / Logo -->
        <div class="flex items-center md:justify-center justify-around h-16 bg-blue-800 shadow-md">
          <span class="text-xl font-bold">Laundry Rml</span>
          <button id="menuBtn2" class="rounded-lg hover:bg-blue-950 p-2 cursor-pointer md:hidden">
            <svg class="w-6 h-6 text-gray-800 dark:text-white md:hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
            </svg>
          </button>
        </div>
        
        <!-- Menu -->
        <nav class="flex-1 overflow-y-auto mt-4">
          <ul class="px-2 space-y-2">
            <?php foreach($menuItems as $menu):?>
            <?php if(in_array($userRole, $menu['role'])):?>
            <li>
              <a href="?tab=<?= $menu['tab']?>" class="flex items-center px-4 py-2 text-white hover:bg-blue-800">
                <?= $icon[$menu['icon']]?>
                <span><?= $menu['label']?></span>
              </a>
            </li>
            <?php endif;?>
            <?php endforeach;?>
            <li>
              <a href="logout.php" class="flex items-center px-4 py-2 text-white hover:bg-blue-800">
                <svg class="w-5 h-5 mr-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                </svg>
                <span>Logout</span>
              </a>
            </li>
          </ul>
        </nav>
        <div class="p-4 bg-blue-800">
          <p class="text-sm text-center">© 2025 RML</p>
        </div>
      </div>
    </aside>
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/25 z-10 md:hidden"></div>