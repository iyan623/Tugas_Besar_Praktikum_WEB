<?php
session_start();
include 'config.php';

// Cek jika bukan admin, alihkan ke halaman login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Proses Tambah Produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_produk'])) {
    $nama_makanan = $_POST['nama_makanan'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $gambar = $_FILES['gambar']['name'];

    if ($gambar) {
        $target_file = "assets/images/" . $gambar;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file);
    }

    $query = "INSERT INTO tb_kuliner (nama_makanan, deskripsi, harga, gambar) VALUES ('$nama_makanan', '$deskripsi', '$harga', '$gambar')";
    mysqli_query($conn, $query);

    header("Location: kelola_produk.php");
    exit;
}

// Ambil daftar produk
$query = "SELECT * FROM tb_kuliner";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo.png">
    <title>Kelola Produk</title>
    <link rel="stylesheet" href="css/kelola_produk.css">
</head>

<body>
    <!-- Header -->
    <header>
        <h1>Kelola Produk</h1>
        <a href="dashboard_admin.php" class="back-link">Kembali ke Dashboard</a>
    </header>

    <!-- Bagian Form Tambah Produk -->
    <main>
        <section class="form-section">
            <h3>Tambah Produk</h3>
            <form method="POST" enctype="multipart/form-data">
                <label for="nama_makanan">Nama Makanan</label>
                <input type="text" name="nama_makanan" required>
                <br>
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" rows="3" required></textarea>
                <br>
                <label for="harga">Harga</label>
                <input type="number" name="harga" min="0" required>
                <br>
                <label for="gambar">Gambar</label>
                <input type="file" name="gambar" accept="image/*" required>
                <br>
                <button type="submit" name="tambah_produk" class="submit-btn">Tambah Produk</button>
            </form>
        </section>

        <!-- Tabel Produk -->
        <section class="produk-section">
            <h3>Daftar Produk</h3>
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
                                    <img src="assets/images/<?php echo $row['gambar']; ?>"
                                        alt="<?php echo htmlspecialchars($row['nama_makanan']); ?>" width="100">
                                </td>
                                <td>
                                    <a href="edit_produk.php?id=<?php echo $row['id']; ?>" class="action-btn-edit">Edit</a>
                                    <a href="hapus_produk.php?id=<?php echo $row['id']; ?>&foto=<?php echo $row['gambar']; ?>" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="action-btn">Hapus</a>
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

    <!-- Footer -->
    <footer>
        <p>&copy; 2023 Kuliner Nusantara</p>
    </footer>

</body>

</html>