<?php
include("db.php");

if (isset($_POST['kategori_id'])) {
    $kategori_id = $_POST['kategori_id'];
    $alt_kategori_sorgu = $conn->query("SELECT * FROM subcategories WHERE category_id = $kategori_id");

    echo '<option value="">Alt Kategori Seç</option>';
    while ($alt_kategori = $alt_kategori_sorgu->fetch_assoc()) {
        echo '<option value="'.$alt_kategori['id'].'">'.$alt_kategori['name'].'</option>';
    }
}
?>
