<?php 
 include_once 'function/loginChecker.php';
?>
<!-- SIDEBAR -->
    <!-- Untuk mobile, sidebar disembunyikan (hidden) dan digantikan dengan menu toggle -->
    <!-- md:block berarti sidebar akan tampil di layar menengah (>=768px) ke atas -->
    <aside id="sidebar" class="fixed z-20 inset-0 flex-none w-64 bg-blue-900 text-white transform -translate-x-full md:translate-x-0 md:relative md:transform-none transition-transform duration-200 ease-in-out">
      <div class="flex flex-col h-full">
        <!-- Brand / Logo -->
        <div class="flex items-center justify-center h-16 bg-blue-800 shadow-md">
          <span class="text-xl font-bold">Laundry Rml</span>
          <a id="menuBtn2"></a>
        </div>
        
        <!-- Menu -->
        <nav class="flex-1 overflow-y-auto mt-4">
          <ul class="px-2 space-y-2">
            <?php if ($_SESSION['user_role'] === 'admin' || $_SESSION['user_role'] === 'owner'):?>
            <li>
              <a href="#" class="flex items-center p-2 rounded hover:bg-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 
                           01-1 1h-3m-6 0h6"></path>
                </svg>
                Dashboard
              </a>
            </li>
            <?php endif;?>
            <li>
              <a href="#" class="flex items-center p-2 rounded hover:bg-blue-800">
                <svg class="w-5 h-5 mr-2 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path fill="currentColor" d="M4 19v2c0 .5523.44772 1 1 1h14c.5523 0 1-.4477 1-1v-2H4Z"/>
                  <path fill="currentColor" fill-rule="evenodd" d="M9 3c0-.55228.44772-1 1-1h8c.5523 0 1 .44772 1 1v3c0 .55228-.4477 1-1 1h-2v1h2c.5096 0 .9376.38314.9939.88957L19.8951 17H4.10498l.90116-8.11043C5.06241 8.38314 5.49047 8 6.00002 8H12V7h-2c-.55228 0-1-.44772-1-1V3Zm1.01 8H8.00002v2.01H10.01V11Zm.99 0h2.01v2.01H11V11Zm5.01 0H14v2.01h2.01V11Zm-8.00998 3H10.01v2.01H8.00002V14ZM13.01 14H11v2.01h2.01V14Zm.99 0h2.01v2.01H14V14ZM11 4h6v1h-6V4Z" clip-rule="evenodd"/>
                </svg>
                kasir Menu
              </a>
            </li>
            <li>
              <a href="logout.php" class="flex items-center p-2 rounded hover:bg-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                Logout
              </a>
            </li>
          </ul>
        </nav>
         <!-- Footer Sidebar
         <div class="p-4 bg-blue-800">
          <p class="text-sm text-center">© 2023 TailAdmin</p>
        </div> -->
      </div>
    </aside>
    <div
    id="sidebar-overlay"
    class="hidden fixed inset-0 bg-black/25 z-10 md:hidden"
  ></div>