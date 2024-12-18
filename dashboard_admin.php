<?php
session_start();

// Jika belum login atau bukan admin, arahkan kembali ke halaman login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <header>
        <h2>Selamat Datang, Admin <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    </header>
    <section>
        <p>Ini adalah halaman Dashboard untuk Admin.</p>
        <a href="logout.php">Logout</a>
    </section>
</body>
</html>
