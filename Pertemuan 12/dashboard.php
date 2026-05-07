<?php
session_start();

// Validasi session: Cegah akses jika belum login
if (!isset($_SESSION['nama'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Selamat Datang di Dashboard</h2>
    <p>Halo, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</p>

    <a href="logout.php"><button>Logout</button></a>
</body>
</html>