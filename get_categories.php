<?php
require_once 'db.php'; // Veritabanı bağlantısı

$query = "SELECT * FROM categories";
$result = $conn->query($query);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

echo json_encode($categories);
?>
