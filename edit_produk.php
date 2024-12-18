<?php
include "config.php";

// Periksa jika ID produk ada
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM tb_kuliner WHERE id='$id_produk'");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        echo "<script>alert('Produk tidak ditemukan');</script>";
        echo "<meta http-equiv='refresh' content='0; url=kelola_produk.php'>";
        exit;
    }
}

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_makanan = $_POST['nama_makanan'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    // Periksa jika gambar diunggah
    $gambar = $data['gambar']; // Gunakan gambar lama sebagai default
    if ($_FILES['gambar']['name']) {
        $target_dir = "assets/images/";
        $target_file = $target_dir . basename($_FILES['gambar']['name']);

        // Pindahkan file yang diunggah
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $gambar = $_FILES['gambar']['name'];
            // Hapus gambar lama jika perlu
            if (file_exists($target_dir . $data['gambar'])) {
                unlink($target_dir . $data['gambar']);
            }
        }
    }

    // Perbarui database
    $update_query = mysqli_query($conn, "UPDATE tb_kuliner SET nama_makanan='$nama_makanan', deskripsi='$deskripsi', harga='$harga', gambar='$gambar' WHERE id='$id_produk'");

    if ($update_query) {
        echo "<script>alert('Produk berhasil diperbarui');</script>";
        echo "<meta http-equiv='refresh' content='0; url=kelola_produk.php'>";
    } else {
        echo "<script>alert('Gagal memperbarui produk');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="css/dashboard_admin.css">
</head>

<body>
    <header>
        <h2>Edit Produk</h2>
        <a href="kelola_produk.php" class="back-btn">Kembali ke Kelola Produk</a>
    </header>

    <main>
        <section class="edit-form-container">
            <form method="POST" enctype="multipart/form-data">
                <label for="nama_makanan">Nama Makanan:</label>
                <input type="text" name="nama_makanan" id="nama_makanan" value="<?php echo htmlspecialchars($data['nama_makanan']); ?>" required>
                <br>
                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" id="deskripsi" required><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
                <br>
                <label for="harga">Harga:</label>
                <input type="number" name="harga" id="harga" value="<?php echo htmlspecialchars($data['harga']); ?>" required>
                <br>
                <label for="gambar">Gambar (Opsional):</label>
                <input type="file" name="gambar" id="gambar">
                <p>Gambar lama: <img src="assets/images/<?php echo $data['gambar']; ?>" alt="<?php echo htmlspecialchars($data['nama_makanan']); ?>" width="100"></p>
                <br>
                <button type="submit" class="btn">Perbarui Produk</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Kuliner Nusantara. All Rights Reserved.</p>
    </footer>
</body>

</html>
