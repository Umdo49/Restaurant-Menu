<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Kategorileri çek
$kategori_sorgu = $conn->query("SELECT * FROM categories");
$kategori_adlari = [];
while ($kat = $kategori_sorgu->fetch_assoc()) {
    $kategori_adlari[$kat['id']] = $kat['name'];
}

// Alt kategorileri çek
$alt_kategori_sorgu = $conn->query("SELECT * FROM subcategories");
$alt_kategori_adlari = [];
while ($alt_kat = $alt_kategori_sorgu->fetch_assoc()) {
    $alt_kategori_adlari[$alt_kat['id']] = $alt_kat['name'];
}

// Ürünleri çek
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Listesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn {
            padding: 5px 10px;
            font-size: 14px;
        }
        a {
            text-align: center;
            color:orange;
            margin-bottom: 20px;
            text-decoration-line: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Ürün Listesi</h2>

    <input type="text" id="search" class="form-control mb-3" placeholder="Ürünlerde Ara...">

    <a href="menu.php"><h4>Menü'ye Geri Dön</h4></a>
    <hr>
    <a href="admin_panel.php"><h4>Üst Menüye Dön</h4></a>

    <div class="table-container">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>İsim</th>
                    <th>Fiyat</th>
                    <th>Kategori</th>
                    <th>Alt Kategori</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody id="urunTablosu">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['price'] ?> TL</td>
                        <td><?= isset($kategori_adlari[$row['category_id']]) ? $kategori_adlari[$row['category_id']] : "Bilinmiyor" ?></td>
                        <td><?= isset($alt_kategori_adlari[$row['subcategory_id']]) ? $alt_kategori_adlari[$row['subcategory_id']] : "Bilinmiyor" ?></td>
                        <td>
                            <a href="urun_guncelle.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Güncelle</a>
                            <a href="urun_sil.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Sil</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#search").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#urunTablosu tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
