<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $role = $_POST['role'];

    $query = "UPDATE users SET role='$role' WHERE id='$user_id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Peran pengguna berhasil diperbarui.'); window.location.href='kelola_users.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui peran.'); window.location.href='kelola_users.php';</script>";
    }
}
?>
