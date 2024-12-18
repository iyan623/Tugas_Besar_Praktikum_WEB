<?php
include "config.php";

// Periksa apakah parameter id dan foto ada
if (isset($_GET['id']) && isset($_GET['foto'])) {
    $id_produk = $_GET['id'];
    $foto_produk = $_GET['foto'];

    // Periksa dan hapus file gambar dari direktori
    if (file_exists("assets/images/$foto_produk")) {
        unlink("assets/images/$foto_produk");
    }

    // Hapus data dari tabel
    $query = mysqli_query($conn, "DELETE FROM tb_kuliner WHERE id='$id_produk'");
    if ($query) {
        echo "<script>alert('Produk berhasil dihapus');</script>";
        echo "<meta http-equiv='refresh' content='0; url=kelola_produk.php'>";
    } else {
        echo "<script>alert('Gagal menghapus produk');</script>";
        echo mysqli_error($conn);
    }
} else {
    echo "<script>alert('Data tidak valid');</script>";
    echo "<meta http-equiv='refresh' content='0; url=kelola_produk.php'>";
}
?>
