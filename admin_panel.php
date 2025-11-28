<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
    <div class="admin-container">
        <h1>Hoşgeldin, <?php echo $_SESSION['admin']; ?>!</h1>
        <div class="admin-links">
            <a href="index.html" class="button logout-button">Çıkış Yap</a>
            <a href="urun_ekle.php" class="button">Ürün Ekle</a>
            <a href="urunler.php" class="button">Ürünleri Yönet</a>
            <a href="kategori.php" class="button">Kategorileri Yönet</a>
        </div>
    </div>
</body>
</html>
