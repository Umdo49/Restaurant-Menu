<?php
session_start();
include("db.php");

$message = '';

// Kategori ekleme
if (isset($_POST['add_category'])) {
    $kategori_adlari = $_POST['kategori_adi'];
    $alt_kategori_adlari = $_POST['alt_kategori_adi'];

    foreach ($kategori_adlari as $i => $kategori_adi) {
        $kategori_adi = trim($kategori_adi);
        if ($kategori_adi !== '') {
            // Yeni sıralama değeri: max(order_no) + 1
            $result = $conn->query("SELECT MAX(order_no) AS max_order FROM categories");
            $row = $result->fetch_assoc();
            $next_order = ($row['max_order'] ?? 0) + 1;

            $stmt = $conn->prepare("INSERT INTO categories (name, order_no) VALUES (?, ?)");
            $stmt->bind_param("si", $kategori_adi, $next_order);
            $stmt->execute();
            $kategori_id = $stmt->insert_id;

            // Alt kategori kontrolü
            if (isset($alt_kategori_adlari[$i]) && trim($alt_kategori_adlari[$i]) !== '') {
                $alt_adi = trim($alt_kategori_adlari[$i]);
                $stmt2 = $conn->prepare("INSERT INTO subcategories (name, category_id) VALUES (?, ?)");
                $stmt2->bind_param("si", $alt_adi, $kategori_id);
                $stmt2->execute();
            } else {
                $stmt2 = $conn->prepare("INSERT INTO subcategories (name, category_id) VALUES (?, ?)");
                $stmt2->bind_param("si", $kategori_adi, $kategori_id);
                $stmt2->execute();
                $message .= "<div class='alert alert-warning'>\"$kategori_adi\" için otomatik alt kategori eklendi.</div>";
            }
        }
    }
    $message .= "<div class='alert alert-success'>Kategori(ler) başarıyla eklendi.</div>";
}

// Sıralama güncelleme
if (isset($_POST['update_order'])) {
    foreach ($_POST['order'] as $id => $sira) {
        $stmt = $conn->prepare("UPDATE categories SET order_no = ? WHERE id = ?");
        $stmt->bind_param("ii", $sira, $id);
        $stmt->execute();
    }
    $message = "<div class='alert alert-success'>Sıralamalar güncellendi.</div>";
}

// Silme işlemleri
if (isset($_POST['delete_category'])) {
    $cat_id = intval($_POST['delete_category']);
    $conn->query("DELETE FROM products WHERE category_id = $cat_id");
    $conn->query("DELETE FROM subcategories WHERE category_id = $cat_id");
    $conn->query("DELETE FROM categories WHERE id = $cat_id");
    $message = "<div class='alert alert-danger'>Kategori ve tüm alt kategori ve ürünleri silindi.</div>";
}

if (isset($_POST['delete_subcategory'])) {
    $subcat_id = intval($_POST['delete_subcategory']);
    $conn->query("DELETE FROM products WHERE subcategory_id = $subcat_id");
    $conn->query("DELETE FROM subcategories WHERE id = $subcat_id");
    $message = "<div class='alert alert-danger'>Alt kategori ve bağlı ürünler silindi.</div>";
}

$kategoriler = $conn->query("SELECT * FROM categories ORDER BY order_no IS NULL, order_no ASC, id ASC");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kategori Yönetimi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f3f6;
        }
        .kategori-box {
            background: #fff;
            padding: 20px;
            border-left: 5px solid #0d6efd;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            margin-bottom: 15px;
        }
        .card-header {
            font-weight: bold;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.15rem rgba(13,110,253,.25);
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between mb-4">
        <a href="admin_panel.php" class="btn btn-outline-primary">Admin Panel</a>
        <a href="oyku_menu.php" class="btn btn-outline-secondary">Menü Sayfası</a>
    </div>

    <?php echo $message; ?>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">Yeni Kategori Ekle</div>
        <div class="card-body">
            <form method="POST">
                <div id="category-container">
                    <div class="kategori-box">
                        <label>Kategori Adı:</label>
                        <input type="text" name="kategori_adi[]" class="form-control mb-2" required>
                        <label>Alt Kategori Adı (Opsiyonel):</label>
                        <input type="text" name="alt_kategori_adi[]" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-info mb-3" onclick="addCategoryBox()">+ Yeni Kategori</button>
                <br>
                <button type="submit" name="add_category" class="btn btn-success">Kategori(leri) Ekle</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">Kategori Sıralaması ve Silme</div>
        <div class="card-body">
            <form method="POST">
                <?php while ($kategori = $kategoriler->fetch_assoc()): ?>
                    <div class="row align-items-center border-bottom py-2">
                        <div class="col-md-4 fw-bold"><?php echo htmlspecialchars($kategori['name']); ?></div>
                        <div class="col-md-2">
                            <input type="number" name="order[<?php echo $kategori['id']; ?>]" value="<?php echo $kategori['order_no']; ?>" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="delete_category" value="<?php echo $kategori['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu kategori ve tüm bağlı veriler silinecek. Emin misiniz?')">Sil</button>
                        </div>
                    </div>
                    <?php
                    $altkats = $conn->query("SELECT * FROM subcategories WHERE category_id = " . $kategori['id']);
                    while ($alt = $altkats->fetch_assoc()): ?>
                        <div class="row ms-3 ps-4 border-start border-2">
                            <div class="col-md-6 text-muted">↳ <?php echo htmlspecialchars($alt['name']); ?></div>
                            <div class="col-md-3">
                                <button type="submit" name="delete_subcategory" value="<?php echo $alt['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu alt kategoriye ait ürünler silinecek. Emin misiniz?')">Alt Kategori Sil</button>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endwhile; ?>
                <div class="mt-4">
                    <button type="submit" name="update_order" class="btn btn-primary">Sıralamayı Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function addCategoryBox() {
    const container = document.getElementById('category-container');
    const div = document.createElement('div');
    div.className = 'kategori-box';
    div.innerHTML = `
        <label>Kategori Adı:</label>
        <input type="text" name="kategori_adi[]" class="form-control mb-2" required>
        <label>Alt Kategori Adı (Opsiyonel):</label>
        <input type="text" name="alt_kategori_adi[]" class="form-control">
    `;
    container.appendChild(div);
}
</script>
</body>
</html>
<?php $conn->close(); ?>
