<?php
session_start();
include 'config.php';

// Cek jika bukan admin, alihkan ke halaman login
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
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/dashboard_admin.css">
</head>

<body>
    <!-- Header -->
    <header>
        <h1>Dashboard Admin</h1>
        <!-- Tombol Keluar -->
        <div class="logout-container">
            <button onclick="window.location.href='logout.php'">Keluar</button>
        </div>
    </header>

    <!-- Area Utama dengan 2 Widget -->
    <main>
        <div class="widgets-container">
            <!-- Widget Kelola Produk -->
            <div class="widget" onclick="window.location.href='kelola_produk.php'">
                <h3>Kelola Produk</h3>
                <p>Kelola daftar produk yang akan ditampilkan di menu Kuliner Nusantara.</p>
            </div>

            <!-- Widget Kelola Pengguna -->
            <div class="widget" onclick="window.location.href='kelola_users.php'">
                <h3>Kelola Pengguna</h3>
                <p>Kelola akses pengguna dan peran yang mereka miliki di sistem ini.</p>
            </div>
        </div>


    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2023 Kuliner Nusantara</p>
    </footer>
</body>

</html>