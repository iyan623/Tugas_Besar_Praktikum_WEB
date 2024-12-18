<?php
session_start();
include 'config.php';

// Cek jika form di-submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari form
    $nama = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pesan = trim($_POST['message']);

    // Validasi input
    if ($nama && $email && $pesan) {
        // Insert data ke database
        $query = "INSERT INTO tb_pesan (nama, email, pesan) VALUES ('$nama', '$email', '$pesan')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Pesan berhasil dikirim!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.'); window.location.href='dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Semua bidang harus diisi!'); window.location.href='dashboard.php';</script>";
    }
} else {
    // Jika bukan POST, redirect kembali
    header('Location: dashboard.php');
}
?>
