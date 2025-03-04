<?php 
  session_start();
// koneksi database
  require_once './../config/db.php';

// function dari sebuah login form php
  require_once './partials/function/loginHandler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

<!-- ======= koneksi css ======= -->
  <link rel="stylesheet" href="./../style/main.css" />

</head>
<body class="h-screen flex justify-center items-center bg-blue-50">
  <form action="" method="post" class="bg-white shadow-[0_4px_10px_rgba(33,28,132,1)] rounded-lg border-2 border-[#211C84]">
    <div class="w-64 p-6 text-center">
      <h1 class="font-bold mb-4 text-[#211C84] text-3xl ">Login</h1>

      <label for="username" class="block text-left text-[#211C84]">Username</label>
      <div class="bg-white flex justify-center items-center rounded-lg border border-[#7A73D1]">
        <input
          class="placeholder-gray-500 w-full p-2 rounded-l-lg"
          type="text"
          id="username"
          name="username"
          placeholder="Masukkan Username"
          required
          value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
        />
        <img class="w-5 m-2" src="./../img/user.png" alt="usr.png" />
      </div>
      <label id="error-message-username" class="text-red-500 text-xs min-h-5 block text-left mt-1"></label>

      <label for="password" class="block text-left text-[#211C84] mt-4">Password</label>
      <div class="bg-white flex justify-center items-center rounded-lg border border-[#7A73D1]">
        <input
          class="placeholder-gray-500 w-full p-2 rounded-l-lg"
          type="password"
          id="password"
          name="password"
          placeholder="Masukkan Password"
          required
        />
        <img class="w-5 m-2 cursor-pointer" src="./../img/eye-close.png" alt="" id="eyeicon" />
      </div>
      <label id="error-message-password" class="text-red-500 text-xs min-h-5 block text-left mt-1"></label>

      <button name="submit" class="active:bg-[#211C84] focus:outline-2 focus:outline-offset-2 focus:outline-violet-500 hover:bg-[#4D55CC] border text-white w-full bg-[#7A73D1] p-2 mt-6 rounded-lg" type="submit">
        Login
      </button>
    </div>
  </form>

<!-- ======== hide/show password ======== -->
  <script src="./partials/js/loginToggle.js"></script>
</body>
</html>
