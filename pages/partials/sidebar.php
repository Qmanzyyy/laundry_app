<!-- SIDEBAR -->
    <!-- Untuk mobile, sidebar disembunyikan (hidden) dan digantikan dengan menu toggle -->
    <!-- md:block berarti sidebar akan tampil di layar menengah (>=768px) ke atas -->
    <aside id="sidebar" class="fixed z-20 inset-0 flex-none w-64 bg-blue-900 text-white transform -translate-x-full md:translate-x-0 md:relative md:transform-none transition-transform duration-200 ease-in-out">
      <div class="flex flex-col h-full">
        <!-- Brand / Logo -->
        <div class="flex items-center justify-center h-16 bg-blue-800 shadow-md">
          <span class="text-xl font-bold">launAdmin</span>
          <button id="menuBtn2">close</button>
        </div>
        
        <!-- Menu -->
        <nav class="flex-1 overflow-y-auto mt-4">
          <ul class="px-2 space-y-2">
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
            <li>
              <a href="logout.php" class="flex items-center p-2 rounded hover:bg-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                </svg>
                Logout
              </a>
            </li>
            <li>
              <a href="#" class="flex items-center p-2 rounded hover:bg-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M9 17v-2a4 4 0 018 0v2m-4 4a2 2 0 
                           100-4 2 2 0 000 4zM8 9h8m-4-4v4"></path>
                </svg>
                Analytics
              </a>
            </li>
            <li>
              <a href="#" class="flex items-center p-2 rounded hover:bg-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M19 9l-7 7-7-7"></path>
                </svg>
                More
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