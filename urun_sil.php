<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Hata: Silinecek ürün belirtilmedi!");
}

$id = intval($_GET['id']); // ID'yi integer yaparak güvenliği artırdık

$sql = "DELETE FROM products WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: urunler.php?success=1");
    exit(); // Redirect sonrası kod çalışmasını önlemek için exit ekledik
} else {
    echo "Hata: " . $conn->error;
}

$conn->close();
?>
