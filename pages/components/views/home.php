<main class="p-6">
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-blue-500 text-white rounded-full">
                <!-- Contoh ikon -->
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">
                    Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?>!
                </h1>
                <p class="text-gray-600 text-sm">
                    Your Role: <span class="font-semibold text-blue-500"><?= htmlspecialchars($_SESSION['user_role']); ?></span>
                </p>
            </div>
        </div>
        <hr class="my-4 border-gray-200">
        <p class="text-gray-500">How can we assist you today? Choose an option from the menu.</p>
    </div>
</main>
