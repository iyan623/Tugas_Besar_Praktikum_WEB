<?php
session_start();
include 'config.php';

// Tangani formulir saat dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama_lengkap = $_POST['nama_lengkap'];
    $gmail = $_POST['gmail'];
    $asal = $_POST['asal'];
    $no_telepon = $_POST['no_telepon'];

    // Validasi username unik
    $check_query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        $insert_query = "INSERT INTO users (username, password, nama_lengkap, gmail, asal, no_telepon, role) VALUES (?, ?, ?, ?, ?, ?, 'user')";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param('ssssss', $username, $password, $nama_lengkap, $gmail, $asal, $no_telepon);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        } else {
            $_SESSION['error'] = "Terjadi kesalahan saat melakukan registrasi. Coba lagi.";
        }
    }

    header('Location: register.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Form Registrasi</title>
</head>

<body>

    <div class="container">
        <h2>Form Registrasi</h2>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" required>
            <label for="gmail">Gmail:</label>
            <input type="email" name="gmail" id="gmail" required>
            <label for="asal">Asal:</label>
            <input type="text" name="asal" id="asal" required>
            <label for="no_telepon">No Telepon:</label>
            <input type="text" name="no_telepon" id="no_telepon" required>
            <button type="submit">Daftar</button>
            <p>Sudah memiliki akun? <a href="login.php">Login di sini</a></p>
        </form>
    </div>

    <!-- Popup Sukses/Error dengan JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            <?php if (isset($_SESSION['success'])): ?>
                alert("<?= $_SESSION['success'] ?>");
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                alert("<?= $_SESSION['error'] ?>");
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        });
    </script>
</body>

</html>