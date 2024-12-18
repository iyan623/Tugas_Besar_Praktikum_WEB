<?php
// Mulai sesi
session_start();
include 'config.php';

// Ambil data makanan dari database
$query = "SELECT * FROM tb_kuliner";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kuliner</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <!-- Logo dan Navbar -->
    <header>
        <div class="logo"><img src="assets/images/logo.png" alt="logo">Kuliner Kab. Takalar</div>
        <nav>
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="#makanan">Produk</a></li>
                <li><a href="#contact-us">Contact Us</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>

    <div class="hero-content">
        <h1>Selamat Datang di Kuliner Nusantara</h1>
        <p>Menikmati berbagai hidangan khas dari Kabupaten Takalar</p>
    </div>

    <!-- Tampilan Makanan -->
    <section class="makanan" id="makanan">
        <h1>Menu Makanan</h1>
        <div class="container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card">
                        <img src="assets/images/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_makanan']; ?>">
                        <h3><?php echo $row['nama_makanan']; ?></h3>
                        <p><?php echo $row['deskripsi']; ?></p>
                        <p><strong>Harga:</strong> Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                        <!-- Tombol Beli -->
                        <?php if (isset($_SESSION['username'])): ?>
                            <a href="beli.php?id=<?php echo $row['id']; ?>" class="btn beli">Beli</a>
                        <?php else: ?>
                            <a href="login.php" class="btn beli">Login untuk Beli</a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-data">Makanan belum tersedia. Silakan tambahkan menu makanan terlebih dahulu.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Bagian Contact Us -->
    <section class="contact-us" id="contact-us">
        <h2>Contact Us</h2>
        <form action="send_message.php" method="POST">
            <input type="text" name="name" placeholder="Nama" required>
            <input type="email" name="email" placeholder="Email" required>
            <textarea name="message" placeholder="Pesan Dan Kesan" required></textarea>
            <button type="submit">Kirim Pesan</button>
        </form>
    </section>

    <!-- Bagian Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Kuliner Nusantara. All Rights Reserved.</p>
    </footer>

</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const links = document.querySelectorAll('a[href^="#"]');

        for (let i = 0; i < links.length; i++) {
            links[i].addEventListener('click', function (event) {
                const targetId = this.getAttribute('href');

                if (targetId.startsWith("#")) {
                    event.preventDefault();
                    document.querySelector(targetId).scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        }
    });
</script>

</html>