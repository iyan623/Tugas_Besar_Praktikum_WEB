<?php
session_start();
include 'config.php';

// Cek apakah form login telah dikirim
if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    // Ambil data user dari database langsung, berdasarkan username
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $login_success = false;

    if ($result && $user = mysqli_fetch_assoc($result)) {
        // Periksa password menggunakan password_verify
        if (password_verify($password, $user['password'])) {
            $login_success = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
            $_SESSION['role'] = $user['role'];
            

             // Simpan peran pengguna di sesi

            // Jika "Remember Me" dicentang, buat cookie
            if ($remember) {
                setcookie('username', $user['username'], time() + (86400 * 30), '/');
            }

            // Redirect berdasarkan peran pengguna
            if ($user['role'] === 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_user.php");
            }
            exit;
        }
    }

    if (!$login_success) {
        // Login gagal, tampilkan popup error dengan JavaScript
        echo "<script>
                alert('Username atau Password salah!');
                window.location.href = 'login.php';
              </script>";
        exit;
    }
}

// Cek jika sudah login melalui cookie
if (isset($_COOKIE['username']) && !isset($_SESSION['username'])) {
    $username = $_COOKIE['username'];
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $user = mysqli_fetch_assoc($result)) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        

        if ($user['role'] === 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: dashboard_user.php");
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="assets/images/logo.png">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="remember">
                <input type="checkbox" name="remember" id="remember"> Remember Me
            </label>
            <button type="submit" name="login">Login</button>
        </form>

        <div class="login-footer">
            <a href="index.php">Kembali ke Dashboard</a> |
            <a href="register.php">Register</a>
        </div>
    </div>
</body>

</html>