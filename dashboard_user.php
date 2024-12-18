<?php
session_start();

// Jika belum login, arahkan kembali ke halaman login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/dashboard_user.css">
</head>

<body>
    <!-- Wrapper Utama -->
    <div class="container">

        <!-- Bagian Selamat Datang Kiri -->
        <div class="welcome-section">
            <h1>Selamat Datang,</h1>
            <h2><?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>!</h2>
            <p>Selamat menikmati layanan kami di Kuliner Nusantara. Jelajahi menu dan layanan kami.</p>
            <br>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/FjYOfN3VlF4?si=EJ7bzHStMDlp1Z99" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

        <!-- Bagian Widget di Kanan -->

        <aside class="widgets">
            <div class="widget">
                <h3>Menu Produk</h3>
                <p>Akses menu produk untuk melihat berbagai pilihan hidangan.</p>
                <a href="produk.php" class="btn">Lihat Produk</a>
            </div>

            <div class="widget">
                <h3>Profil</h3>
                <p>Lihat dan edit informasi profil Anda.</p>
                <a href="profil.php" class="btn">Lihat Profil</a>
            </div>

            <div class="widget">
                <h3>Keluar</h3>
                <p>Keluar dari akun Anda dengan mudah.</p>
                <a href="logout.php" class="btn btn-logout">Keluar</a>
            </div>
        </aside>
    </div>

    <!-- Bagian Footer -->
    <footer>
        &copy; <?php echo date('Y'); ?> Kuliner Nusantara
    </footer>
</body>

</html>