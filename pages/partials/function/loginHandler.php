<?php

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Menggunakan prepared statement untuk mencegah SQL injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM tb_user WHERE username = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            // Menggunakan password_verify() untuk mencocokkan password yang di-hash
            if (password_verify($password, $row["password"])) {
                $_SESSION['user_id'] = $row["id"];
                $_SESSION['user_role'] = $row["role"];
                header("Location: ./../index.php");
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
    } else {
        die("Prepared Statement Error: " . mysqli_error($conn));
    }
}
