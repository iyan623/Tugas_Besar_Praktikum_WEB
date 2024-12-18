<?php
session_start();
include 'config.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil data pengguna berdasarkan username dari session
$username = $_SESSION['username'];
$query = "SELECT id, username, nama_lengkap, gmail, asal, no_telepon FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $gmail = $_POST['gmail'];
    $asal = $_POST['asal'];
    $no_telepon = $_POST['no_telepon'];

    $updateQuery = "UPDATE users SET nama_lengkap = ?, gmail = ?, asal = ?, no_telepon = ? WHERE username = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssss", $nama_lengkap, $gmail, $asal, $no_telepon, $username);
    if ($stmt->execute()) {
        $success = "Profil berhasil diperbarui!";
        // Perbarui session jika diperlukan
    } else {
        $error = "Terjadi kesalahan saat memperbarui profil.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profil.css">
    <link rel="icon" href="assets/images/logo.png">
    <title>Profil Pengguna</title>
</head>

<body>
    <header>
        <h2>Profil Saya</h2>
        <nav>
            <a href="dashboard_user.php">Kembali ke Dashboard</a>
        </nav>
    </header>

    <main>
        <section class="profil-container">
            <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

            <form method="POST">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>" required>
                <br>

                <label for="gmail">Gmail:</label>
                <input type="email" id="gmail" name="gmail" value="<?php echo htmlspecialchars($user['gmail']); ?>" required>
                <br>

                <label for="asal">Asal:</label>
                <input type="text" id="asal" name="asal" value="<?php echo htmlspecialchars($user['asal']); ?>" required>
                <br>

                <label for="no_telepon">No Telepon:</label>
                <input type="text" id="no_telepon" name="no_telepon" value="<?php echo htmlspecialchars($user['no_telepon']); ?>" required>
                <br>

                <button type="submit">Perbarui Profil</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 Kuliner Nusantara. All Rights Reserved.</p>
    </footer>
</body>

</html>
