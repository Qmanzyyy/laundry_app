<?php if ($_SESSION['user_role'] === 'owner'):?>
<main class="flex items-center justify-center bg-gray-100 p-6">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <h1 class="text-2xl font-semibold text-gray-800">Create a New Account</h1>
        <hr class="my-4 border-gray-300">
        <p class="text-gray-600">Create a New Account For Your New Employee</p>
        <a href="register.php" class="mt-6 inline-block bg-blue-600 text-white py-2 px-6 rounded-lg shadow hover:bg-blue-700 transition">Register Now</a>
    </div>
</main>
<?php endif;?>