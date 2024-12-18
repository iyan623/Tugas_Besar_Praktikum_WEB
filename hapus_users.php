<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];

    $query = "DELETE FROM users WHERE id='$user_id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pengguna berhasil dihapus.'); window.location.href='kelola_users.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus pengguna.'); window.location.href='kelola_users.php';</script>";
    }
}
?>
