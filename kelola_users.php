<?php
session_start();
include 'config.php';

// Cek jika bukan admin, alihkan ke halaman login
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Ambil data pengguna
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <link rel="stylesheet" href="css/kelola_users.css">
</head>

<body>
    <!-- Header -->
    <header>
        <h1>Kelola Pengguna</h1>
        <a href="dashboard_admin.php" class="back-link">Kembali ke Dashboard</a>
    </header>

    <!-- Area Konten -->
    <main>
        <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Peran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['nama_lengkap']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['gmail']); ?></td>
                            <td>
                                <form method="POST" action="update_role.php">
                                    <select name="role">
                                        <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                    </select>
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="update-btn">Ubah Peran</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="hapus_users.php" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="hapus-btn">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2023 Kuliner Nusantara</p>
    </footer>
</body>

</html>
