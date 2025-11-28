<?php
$host = 'localhost:3306'; 
$username = 'root'; 
$password = ''; 
$dbname = 'menu_db';  

// Veritabanı bağlantısı
$conn = new mysqli($host, $username, $password, $dbname);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı Hatası: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
