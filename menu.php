<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('db.php'); // Veritabanı bağlantısı

// Kategorileri al
$category_query = "SELECT * FROM categories ORDER BY order_no ASC, id ASC";
$category_result = $conn->query($category_query);
$all_categories = $category_result->fetch_all(MYSQLI_ASSOC);

// Seçilen kategori ID
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : null;

// Varsayılan Kategori
if ($category_id === null && !empty($all_categories)) {
    $category_id = $all_categories[0]['id'];
}

// Alt kategorileri al
$subcategories = [];
if ($category_id) {
    $subcategory_query = "SELECT * FROM subcategories WHERE category_id = ?";
    $stmt = $conn->prepare($subcategory_query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $subcategory_result = $stmt->get_result();
    $subcategories = $subcategory_result->fetch_all(MYSQLI_ASSOC);
}

// Seçilen alt kategori ID
$subcategory_id = isset($_GET['subcategory_id']) ? intval($_GET['subcategory_id']) : null;

// Ürünleri al
$product_result = null;
if ($subcategory_id) {
    // Alt kategori seçiliyse
    $product_query = "SELECT * FROM products WHERE subcategory_id = ?";
    $stmt = $conn->prepare($product_query);
    $stmt->bind_param("i", $subcategory_id);
    $stmt->execute();
    $product_result = $stmt->get_result();
} elseif ($category_id) {
    if (!empty($subcategories)) {
        // Alt kategori seçilmemişse ilk alt kategoriyi al (varsa)
        $current_subcategory_id_to_fetch = $subcategory_id ?? $subcategories[0]['id'];
        $product_query = "SELECT * FROM products WHERE subcategory_id = ?";
        $stmt = $conn->prepare($product_query);
        $stmt->bind_param("i", $current_subcategory_id_to_fetch);
        $stmt->execute();
        $product_result = $stmt->get_result();
    } else {
        // Alt kategorisi olmayan kategori için
        $product_query = "SELECT * FROM products WHERE category_id = ?";
        $stmt = $conn->prepare($product_query);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $product_result = $stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Munzur Baba Menü</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome (İkonlar için) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Tailwind'in varsayılan font ailesini Inter ile genişletiyoruz */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a; /* Kurumsal Koyu Slate */
            color: #e2e8f0; /* Ana Metin Rengi (Slate-200) */
            overflow-x: hidden;
        }

        /* --- Profesyonel Arka Plan Animasyonu --- */
        #background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -10;
            overflow: hidden;
            background: linear-gradient(-45deg, #0f172a, #1e293b, #0f172a, #334155);
            background-size: 400% 400%;
            animation: subtleFlow 25s ease infinite;
        }

        @keyframes subtleFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* İçeriklerin animasyonun üzerinde kalması için */
        .content-wrapper {
            position: relative;
            z-index: 10;
        }

        /* Yatay kaydırma çubuğu stilleri */
        .horizontal-scroll-nav::-webkit-scrollbar {
            height: 4px;
        }
        .horizontal-scroll-nav::-webkit-scrollbar-thumb {
            background-color: #eab308; /* Sarı */
            border-radius: 20px;
        }
        .horizontal-scroll-nav::-webkit-scrollbar-track {
            background-color: #334155; /* Slate-700 */
        }
        .horizontal-scroll-nav {
            scrollbar-width: thin; /* Firefox */
            scrollbar-color: #eab308 #334155; /* Firefox */
        }

    </style>
</head>
<body class="text-slate-200">

<!-- Arka Plan Animasyon Alanı -->
<div id="background-animation"></div>

<!-- İçerik Alanı -->
<div class="content-wrapper">

    <!-- Header (menu.php'ye özel) -->
    <header class="text-center py-12 px-4">
        <div class="container mx-auto max-w-7xl">
            <h1 class="text-5xl md:text-6xl font-bold text-yellow-500">Menümüz</h1>
            <p class="text-lg text-slate-400 mt-2 mb-6">Munzur'un en taze lezzetleri</p>
            
            <hr class="border-slate-700 my-6 w-full max-w-lg mx-auto">
            
            <div class="admin-link space-x-4">
                <a href="login.php" class="inline-block text-black bg-yellow-500 hover:bg-yellow-600 transition-all duration-300 font-bold px-6 py-2 rounded-full shadow-lg text-sm">
                    <i class="fas fa-user-shield mr-1"></i> Admin Girişi
                </a>
                <a href="index.html" class="inline-block text-white bg-slate-700 hover:bg-slate-600 transition-all duration-300 font-bold px-6 py-2 rounded-full shadow-lg text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Ana Sayfaya Dön
                </a>
            </div>
        </div>
    </header>

    <!-- Kategori Navigasyonu -->
    <nav class="bg-slate-800 bg-opacity-90 backdrop-blur-sm py-3 sticky top-0 z-50 border-y border-slate-700">
        <ul class="flex justify-start overflow-x-auto whitespace-nowrap p-2 container mx-auto max-w-7xl horizontal-scroll-nav">
            <?php foreach ($all_categories as $category): ?>
                <li class="mr-3">
                    <a href="?category_id=<?php echo $category['id']; ?>"
                       class="py-2 px-5 rounded-full font-semibold transition duration-300 block
                       <?php echo ($category['id'] == $category_id) ? 'bg-yellow-500 text-black' : 'bg-slate-700 text-slate-200 hover:bg-slate-600'; ?>">
                        <?php echo htmlspecialchars($category['name'] ?? ''); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <!-- Alt Kategori Navigasyonu -->
    <?php if (!empty($subcategories)): ?>
        <div class="bg-slate-900 py-2 sticky top-[76px] z-40 border-b border-slate-700"> <!-- [76px] yaklaşık üst nav yüksekliği -->
            <ul class="flex justify-start overflow-x-auto whitespace-nowrap p-2 container mx-auto max-w-7xl horizontal-scroll-nav">
                <?php foreach ($subcategories as $index => $subcategory): ?>
                    <li class="mr-2">
                        <?php
                            $is_active_sub = false;
                            $current_active_sub_id = $subcategory_id ?? $subcategories[0]['id'];
                            if ($subcategory['id'] == $current_active_sub_id) {
                                $is_active_sub = true;
                            }
                        ?>
                        <a href="?category_id=<?php echo $category_id; ?>&subcategory_id=<?php echo $subcategory['id']; ?>"
                           class="py-1 px-4 rounded-full text-sm font-medium transition duration-300 block
                           <?php echo $is_active_sub ? 'bg-slate-600 text-yellow-500' : 'bg-slate-700 text-slate-300 hover:bg-slate-600'; ?>">
                            <?php echo htmlspecialchars($subcategory['name'] ?? ''); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Ürün Kartları -->
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <?php if ($product_result && $product_result->num_rows > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                <?php while ($product = $product_result->fetch_assoc()): ?>
                    <div class="bg-slate-800 rounded-lg shadow-lg overflow-hidden transition duration-300 hover:border-yellow-500 border border-slate-700 flex flex-col">
                        <img src="uploads/<?php echo htmlspecialchars($product['img'] ?? 'default.png'); ?>"
                             alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?>"
                             class="w-full h-64 object-cover"
                             onerror="this.onerror=null; this.src='https://placehold.co/600x400/0f172a/eab308?text=Görsel+Yok';"> <!-- Hata durumunda placeholder -->
                        
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-2xl font-bold text-yellow-500 mb-2"><?php echo htmlspecialchars($product['name'] ?? ''); ?></h3>
                            <p class="text-slate-400 mb-4 min-h-[40px] flex-grow"><?php echo htmlspecialchars($product['description'] ?? ''); ?></p>
                            <p class="text-2xl font-bold text-right text-yellow-500 mt-4">
                                <?php
                                    $price_text = $product['price'] ?? '0';
                                    preg_match('/(\d+(\.\d+)?)/', $price_text, $matches);
                                    $price_value = $matches[0] ?? '0';
                                    echo htmlspecialchars(number_format((float)$price_value, 2, ',', '.')) . ' ₺';
                                ?>
                            </p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <!-- Ürün Yok Mesajı -->
            <div class="text-center py-20 px-4 col-span-1 sm:col-span-2 lg:col-span-4">
                <i class="fas fa-box-open fa-4x text-slate-600 mb-4"></i>
                <h2 class="text-3xl font-bold text-yellow-500 mb-2">Ürün Bulunamadı</h2>
                <p class="text-lg text-slate-400">Bu kategoride henüz lezzetimiz bulunmuyor.</p>
            </div>
        <?php endif; ?>
    </div>

    <hr class="border-slate-700 my-12 w-4/5 mx-auto">

    <!-- FOOTER (index.html ile aynı) -->
    <footer class="bg-slate-900 py-16">
        <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center md:text-left">
                <!-- Footer Sol Taraf (Logo/İsim) -->
                <div>
                    <h3 class="text-3xl font-bold text-yellow-500 mb-4">
                        Munzur Baba
                    </h3>
                    <p class="text-slate-400">
                        Doğanın kalbinde, lezzetin zirvesinde. Munzur'un eşsiz manzarası eşliğinde unutulmaz bir deneyim.
                    </p>
                </div>

                <!-- Footer Orta (Hızlı Bağlantılar) -->
                <div>
                    <h4 class="text-xl font-bold text-slate-100 mb-4">Hızlı Bağlantılar</h4>
                    <ul class="space-y-2">
                        <li><a href="index.html#hero" class="text-slate-400 hover:text-yellow-500 transition">Ana Sayfa</a></li>
                        <li><a href="index.html#about" class="text-slate-400 hover:text-yellow-500 transition">Hakkımızda</a></li>
                        <li><a href="menu.php" class="text-slate-400 hover:text-yellow-500 transition">Menü</a></li>
                        <li><a href="index.html#gallery" class="text-slate-400 hover:text-yellow-500 transition">Galeri</a></li>
                        <li><a href="index.html#team" class="text-slate-400 hover:text-yellow-500 transition">Ekibimiz</a></li>
                        <li><a href="index.html#contact" class="text-slate-400 hover:text-yellow-500 transition">İletişim</a></li>
                        <li><a href="index.html#reservation" class="text-slate-400 hover:text-yellow-500 transition">Rezervasyon</a></li>
                    </ul>
                </div>

                <!-- Footer Sağ Taraf (İletişim) -->
                <div>
                    <h4 class="text-xl font-bold text-slate-100 mb-4">Bize Ulaşın</h4>
                    <ul class="space-y-3 text-slate-400">
                        <li class="flex items-center justify-center md:justify-start">
                            <i class="fas fa-map-marker-alt w-6 text-yellow-500"></i>
                            <span>Munzur Kenarı, No:123, Tunceli/Dersim</span>
                        </li>
                        <li class="flex items-center justify-center md:justify-start">
                            <i class="fas fa-phone-alt w-6 text-yellow-500"></i>
                            <span>+90 555 123 45 67</span>
                        </li>
                        <li class="flex items-center justify-center md:justify-start">
                            <i class="fas fa-envelope w-6 text-yellow-500"></i>
                            <span>info@munzurbaba.com</span>
                        </li>
                    </ul>
                    <!-- Sosyal Medya İkonları -->
                    <div class="flex justify-center md:justify-start space-x-5 mt-6">
                        <a href="#" class="text-slate-300 hover:text-yellow-500 text-2xl transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-slate-300 hover:text-yellow-500 text-2xl transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-slate-300 hover:text-yellow-500 text-2xl transition"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-slate-700 mt-12 pt-8 text-center text-slate-500">
                &copy; <?php echo date("Y"); ?> Munzur Baba Restaurant. Tüm hakları saklıdır.
            </div>
        </div>
    </footer>

</div> <!-- .content-wrapper sonu -->

<!-- Ses ve interaksiyon JS kodları kurumsal temaya uymadığı için kaldırıldı -->

</body>
</html>

<?php
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
