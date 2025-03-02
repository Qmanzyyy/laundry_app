<?php 
session_start();
require_once './../config/db.php';

if (isset($_POST["kirim"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query untuk memeriksa username
    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($password == $row["password"]) {
            $_SESSION['user_id'] = $row["id"]; // Simpan ID pengguna dalam session
            header("Location: ./../index.php"); // Arahkan ke halaman dashboard
            exit;
        } else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function(){
                        document.getElementById('error-message-password').innerHTML = 'Password salah!';
                    });
                  </script>";
        }
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function(){
                    document.getElementById('error-message-username').innerHTML = 'Username tidak ditemukan!';
                });
              </script>";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="./../style/output.css" />
</head>
<body class="h-screen flex justify-center items-center bg-blue-50">
  <form action="" method="post" class="bg-white shadow-lg rounded-lg">
    <div class="w-64 p-6 text-center">
      <h1 class="font-bold mb-4 text-blue-600 text-3xl">Login</h1>

      <label for="username" class="block text-left text-gray-700">Username</label>
      <div class="bg-white flex justify-center items-center rounded-lg border border-gray-300">
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

      <label for="password" class="block text-left text-gray-700 mt-4">Password</label>
      <div class="bg-white flex justify-center items-center rounded-lg border border-gray-300">
        <input
          class="placeholder-gray-500 w-full p-2 rounded-l-lg"
          type="password"
          id="password"
          name="password"
          placeholder="Masukkan Password"
          required
          value="<?= isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>"
        />
        <img class="w-5 m-2 cursor-pointer" src="./../img/eye-close.png" alt="" id="eyeicon" />
      </div>
      <label id="error-message-password" class="text-red-500 text-xs min-h-5 block text-left mt-1"></label>

      <button name="kirim" class="active:bg-blue-800 hover:bg-blue-600 border w-full bg-blue-500 text-white p-2 mt-6 rounded-lg" type="submit">
        Login
      </button>
    </div>
  </form>
  <script>
    let eyeicon = document.getElementById("eyeicon");
    let password = document.getElementById("password");

    eyeicon.onclick = function () {
      if (password.type == "password") {
        password.type = "text";
        eyeicon.src = "./../img/eye-open.png";
      } else {
        password.type = "password";
        eyeicon.src = "./../img/eye-close.png";
      }
    };
  </script>
</body>
</html>
