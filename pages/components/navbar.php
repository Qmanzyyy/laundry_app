      <!-- NAVBAR -->
      <header class="flex items-center justify-between bg-white h-16 px-4 shadow">
        <!-- Left: Hamburger menu (untuk mobile) -->
        <button id="menuBtn" class="md:hidden text-blue-900 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>

        <!-- Middle: Search bar (opsional) -->
        <div class="flex-1 mx-4">
          <div class="relative">
            <!-- <input type="search" placeholder="Type to search..."
                   class="w-full border border-gray-300 rounded-lg pl-8 pr-4 py-2 focus:outline-none focus:border-blue-500">
            <svg class="w-4 h-4 text-gray-400 absolute left-2 top-2" fill="none"
                 stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
              <path d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 
                       1110.5 3a7.5 7.5 0 016.15 11.65z"></path>
            </svg> -->
          </div>
        </div>

        <!-- Right: User info -->
        <div class="flex items-center space-x-4">
          <span class="text-sm font-semibold"><?= $_SESSION['user_name'];?></span>
          <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path d="M5.121 17.804A13.966 13.966 
                       0 0112 15c2.574 0 4.969.652 6.879 1.804M15 
                       10a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
          </div>
        </div>
      </header>