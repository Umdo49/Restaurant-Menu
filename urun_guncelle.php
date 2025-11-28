<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$id = intval($_GET['id']);
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();

$categories = $conn->query("SELECT * FROM categories");
$subcategories = $conn->query("SELECT * FROM subcategories");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $subcategory_id = $_POST['subcategory_id'];
    $delete_image = isset($_POST['delete_image']);

    // Mevcut resim adını koru
    $img = $product['img']; 

    if ($delete_image) {
        // "Görseli sil" kutucuğu işaretlendiyse
        if (!empty($img) && file_exists("uploads/" . $img)) {
            unlink("uploads/" . $img);
        }
        $img = null;
    }

    // --- DEĞİŞİKLİK BAŞLANGICI ---

    // Yeni bir resim yüklendiyse
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        // 1. Dosya adını, zaman damgası olmadan, doğrudan orijinal adıyla al
        // basename() kullanımı güvenlik için (örn: ../../) dizin yollarını temizler
        $filename = basename($_FILES['img']['name']);
        $target_path = $upload_dir . $filename;
        
        // 2. Güvenlik kontrolü: Sadece izin verilen resim uzantılarını kabul et
        $imageFileType = strtolower(pathinfo($target_path, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

        if (!in_array($imageFileType, $allowed_types)) {
            // İzin verilmeyen dosya türü
            echo "<script>alert('Hata: Yalnızca JPG, JPEG, PNG, GIF, WEBP, AVIF dosyalarına izin verilmektedir.');</script>";
        } else {
            // Güvenli, dosyayı yeni hedefe taşı
            if (move_uploaded_file($_FILES['img']['tmp_name'], $target_path)) {
                
                // 3. Hata düzeltmesi: Eski resmi SADECE yeni resmin adı farklıysa sil.
                // Bu, 'menemen.webp' dosyasını 'menemen.webp' ile güncellerken
                // yeni yüklenen dosyanın silinmesini engeller.
                if (!empty($product['img']) && file_exists('uploads/' . $product['img']) && $product['img'] != $filename) {
                    unlink('uploads/' . $product['img']);
                }
                
                // Veritabanına kaydedilecek dosya adını yeni adla güncelle
                $img = $filename; 
            
            } else {
                 echo "<script>alert('Hata: Dosya yüklenirken bir sorun oluştu.');</script>";
            }
        }
    }
    // --- DEĞİŞİKLİK SONU ---


    // Veritabanını güncelle
    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, description=?, category_id=?, subcategory_id=?, img=? WHERE id=?");
    $stmt->bind_param("sdsissi", $name, $price, $description, $category_id, $subcategory_id, $img, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Ürün başarıyla güncellendi.'); window.location.href='urunler.php';</script>";
    } else {
        echo "<script>alert('Güncelleme hatası oluştu.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ürün Güncelle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 40px; max-width: 700px; }
        .card {
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .preview {
            max-width: 300px;
            max-height: 200px;
            object-fit: cover;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h3 class="text-center mb-4">Ürün Güncelle</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Ürün Adı</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Fiyat (TL)</label>
                <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Açıklama</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-select" required>
                    <?php while ($cat = $categories->fetch_assoc()): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $product['category_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Alt Kategori</label>
                <select name="subcategory_id" class="form-select" required>
                    <?php 
                    // Alt kategorileri tekrar çekmek için sorguyu başa al (mysqli result'ı seek etmek yerine)
                    $subcategories->data_seek(0); 
                    while ($sub = $subcategories->fetch_assoc()): 
                    ?>
                        <option value="<?= $sub['id'] ?>" <?= ($sub['id'] == $product['subcategory_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sub['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Ürün Görseli</label><br>
                <?php
                // "uploads/" klasörünü kontrol et, eğer resim orada değilse "default.png" göster
                $image_path = 'uploads/default.png'; // Varsayılan
                if (!empty($product['img'])) {
                    $potential_path = 'uploads/' . htmlspecialchars($product['img']);
                    if (file_exists($potential_path)) {
                        $image_path = $potential_path;
                    }
                }
                ?>
                <img src="<?= $image_path ?>" alt="Ürün Görseli" class="preview">
                
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="delete_image" id="delete_image">
                    <label class="form-check-label" for="delete_image">Görseli sil</label>
                </div>
                
                <input type="file" name="img" class="form-control mt-2">
                <small class="text-muted">Yeni bir görsel seçerek değiştirebilirsiniz.</small>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-3">Güncelle</button>
            <a href="urunler.php" class="btn btn-secondary w-100 mt-2">Ürün Listesine Dön</a>
            <a href="menu.php" class="btn btn-secondary w-100 mt-2">Menüye Dön</a>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>