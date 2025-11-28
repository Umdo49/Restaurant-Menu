<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kategori_id = intval($_POST['kategori']);
    $alt_kategori_id = intval($_POST['alt_kategori']);
    $urun_adi = trim($_POST['urun_adi']);
    $fiyat = floatval($_POST['fiyat']);
    $aciklama = !empty($_POST['aciklama']) ? trim($_POST['aciklama']) : null;
    $gorsel = null;

    // Görsel yükleme işlemi
    if (!empty($_FILES["gorsel"]["name"])) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // klasör yoksa oluştur
        }

        $dosya_adi = basename($_FILES["gorsel"]["name"]);
        $uzanti = pathinfo($dosya_adi, PATHINFO_EXTENSION);
        $yeni_dosya_adi = uniqid('urun_', true) . '.' . strtolower($uzanti); // benzersiz isim
        $hedef_yol = $upload_dir . $yeni_dosya_adi;

        // Sadece resim dosyalarını kabul et
        $izinli_uzantilar = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array(strtolower($uzanti), $izinli_uzantilar)) {
            if (move_uploaded_file($_FILES["gorsel"]["tmp_name"], $hedef_yol)) {
                $gorsel = $hedef_yol;
            } else {
                $message = "Görsel yüklenirken hata oluştu!";
            }
        } else {
            $message = "Sadece jpg, jpeg, png, gif veya webp dosyaları yükleyebilirsiniz!";
        }
    }

    if (!isset($message)) { // Eğer yukarıda hata yoksa devam et
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, img, category_id, subcategory_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssii", $urun_adi, $fiyat, $aciklama, $gorsel, $kategori_id, $alt_kategori_id);
        
        if ($stmt->execute()) {
            $message = "Ürün başarıyla eklendi!";
        } else {
            $message = "Veritabanı hatası: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ekleme Sonucu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="container text-center">
        <div class="alert alert-<?php echo (isset($message) && str_contains($message, 'Hata')) ? 'danger' : 'success'; ?>" role="alert">
            <?php echo $message; ?>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <a href="menu.php" class="btn btn-primary">Menüye Dön</a>
            <a href="urun_ekle.php" class="btn btn-success">Ürün Eklemeye Devam Et</a>
            <a href="urunler.php" class="btn btn-warning">Ürünleri Görüntüle</a>
        </div>
    </div>
</body>
</html>
