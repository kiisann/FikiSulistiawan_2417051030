<?php
session_start();
require 'koneksi.php';

// Hanya admin yang boleh mengakses
if (!isset($_SESSION['nama']) || $_SESSION['nama'] !== "admin") {
    header("Location: dashboard.php");
    exit();
}

// Cek apakah parameter ID tersedia
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = intval($_GET['id']);

// Jika ID tidak valid, kembali ke dashboard
if ($id <= 0) {
    header("Location: dashboard.php");
    exit();
}

// Ambil data user berdasarkan ID
$stmt = $conn->prepare("SELECT id, nama FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $stmt->close();
    header("Location: dashboard.php");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();
$pesan = "";

// Update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_baru = trim($_POST['nama']);
    $password_baru = $_POST['password'];

    if (empty($nama_baru) || empty($password_baru)) {
        $pesan = "Nama dan password baru wajib diisi.";
    } elseif (strlen($password_baru) < 6) {
        $pesan = "Password baru minimal 6 karakter.";
    } else {
        $hashed_password = password_hash($password_baru, PASSWORD_BCRYPT);
        $stmt_update = $conn->prepare("UPDATE users SET nama = ?, password = ? WHERE id = ?");
        $stmt_update->bind_param("ssi", $nama_baru, $hashed_password, $id);

        if ($stmt_update->execute()) {
            $stmt_update->close();

            header("Location: dashboard.php");
            exit();
        } else {
            $pesan = "Gagal memperbarui data pengguna.";
        }
        $stmt_update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Pengguna</title>
</head>
<body>
    <h2>Edit Data Pengguna</h2>

    <?php if ($pesan != ""): ?>
        <h3><?php echo htmlspecialchars($pesan); ?></h3>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Nama Pengguna</label><br>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
        <br><br>
        <label>Password Baru</label><br>
        <input type="password" name="password" placeholder="Masukkan password baru" required>
        <br><br>
        <button type="submit">Simpan Perubahan</button>
    </form>
    <br>
    <a href="dashboard.php"><button>Batal</button></a>
</body>
</html>