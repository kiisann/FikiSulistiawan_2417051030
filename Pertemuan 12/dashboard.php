<?php
session_start();
require 'koneksi.php';

// Validasi session: Cegah akses jika belum login
if (!isset($_SESSION['nama'])) {
    header("Location: auth.php");
    exit();
}

// Cek apakah user adalah admin
$isAdmin = ($_SESSION['nama'] === "admin");

// Hapus data user
if (isset($_GET['hapus'])) {
    if (!isAdmin) {
        header("Location: dashboard.php");
        exit();
    }

    $id = intval($_GET['hapus']);

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: dashboard.php");
    exit();
}

// Ambil semua data user untuk admin
$users = [];

if ($isAdmin) {
    $result = $conn->query("SELECT id, nama FROM users ORDER BY id ASC");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <?php if ($isAdmin): ?>

        <h2>Selamat Datang, admin!</h2>
        <a href="logout.php"><button>Logout</button></a>
        <hr>

        <h3>Menu Admin: Kelola Pengguna</h3>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['nama']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $user['id']; ?>"><button>Edit</button></a>
                        <a href="dashboard.php?hapus=<?php echo $user['id']; ?>" onclick="return confirm('Yakin ingin menghapus pengguna ini?');"><button>Hapus</button></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php else: ?>
        <h2>Selamat Datang, user!</h2>
        <a href="logout.php"><button>Logout</button></a>
        <hr>
    <?php endif; ?>

</body>
</html>