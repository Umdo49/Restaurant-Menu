<?php
include("db.php");

// Kategorileri çek
$kategori_sorgu = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        a {
            text-align: center;
            color:white;
            margin-bottom: 20px;
            text-decoration-line: none;
        }
        label {
            font-weight: bold;
            margin-top: 10px;
        }
        .btn-primary {
            width: 100%;
            font-weight: bold;
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        select, input, textarea {
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2>Ürün Ekle</h2>
        <form action="urun_ekle_islem.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="kategori">Kategori Seç:</label>
                <select class="form-select" name="kategori" id="kategori">
                    <option value="">Kategori Seç</option>
                    <?php while ($kategori = $kategori_sorgu->fetch_assoc()): ?>
                        <option value="<?= $kategori['id'] ?>"><?= $kategori['name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="alt_kategori">Alt Kategori Seç:</label>
                <select class="form-select" name="alt_kategori" id="alt_kategori">
                    <option value="">Önce Kategori Seçin</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="urun_adi">Ürün Adı:</label>
                <input type="text" class="form-control" name="urun_adi" required>
            </div>

            <div class="mb-3">
                <label for="fiyat">Fiyat:</label>
                <input type="number" step="0.01" class="form-control" name="fiyat" required>
            </div>

            <div class="mb-3">
                <label for="aciklama">Açıklama (Opsiyonel):</label>
                <textarea class="form-control" name="aciklama"></textarea>
            </div>

            <div class="mb-3">
                <label for="gorsel">Görsel (Opsiyonel):</label>
                <input type="file" class="form-control" name="gorsel">
            </div>

            <button type="submit" class="btn btn-primary">Ürünü Ekle</button>
            
            
        </form>
        <br>
        <hr>
        <br>
        <button type="submit" class="btn btn-primary"><a href="admin_panel.php"><h4>Üst Menüye Dön</h4></a></button>
        <hr>
        <button type="submit" class="btn btn-primary"><a href="menu.php"><h4>Menü'ye Dön</h4></a></button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $("#kategori").change(function () {
            var kategori_id = $(this).val();
            $.ajax({
                url: "get_subcategories.php",
                type: "POST",
                data: { kategori_id: kategori_id },
                success: function (data) {
                    $("#alt_kategori").html(data);
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
