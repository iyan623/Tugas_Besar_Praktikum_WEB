<?php
session_start();
include 'config.php';

// Ambil data produk dari database
$query = "SELECT * FROM tb_kuliner";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo.png">
    <title>Produk Kuliner</title>
    <link rel="stylesheet" href="css/produk.css">
</head>

<body>
    <header>
        <h2>Daftar Produk Kuliner</h2>
        <nav>
            <a href="dashboard_user.php">Kembali ke Dashboard</a>
        </nav>
    </header>

    <main>
        <section class="produk-container">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nama Makanan</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nama_makanan']); ?></td>
                                <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                                <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <img src="assets/images/<?php echo $row['gambar']; ?>" alt="<?php echo htmlspecialchars($row['nama_makanan']); ?>" width="100">
                                </td>
                                <td>
                                    <?php if (isset($_SESSION['username'])): ?>
                                        <form method="POST" action="#">
                                            <input type="hidden" name="id_produk" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="beli-btn">Beli</button>
                                        </form>
                                    <?php else: ?>
                                        <a href="login.php" class="login-btn">Login untuk membeli</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada produk yang tersedia saat ini.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Kuliner Nusantara. All Rights Reserved.</p>
    </footer>
</body>

</html>
