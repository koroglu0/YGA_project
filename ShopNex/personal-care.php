<?php
session_start();
require_once 'config.php';

// Filtreleme parametrelerini al
$size_filter = $_GET['size'] ?? '';
$color_filter = $_GET['color'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$sort_by = $_GET['sort'] ?? 'newest';

// Mock Kişisel Bakım Ürünleri - Veritabanına kaydetmeden test için
$mockProducts = [
    // Cilt Bakımı
    ['id' => 2001, 'title' => 'Hyaluronic Acid Serum', 'description' => 'Nemlendirici ve yaşlanma karşıtı serum', 'price' => 189.99, 'image' => 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 45, 'category_id' => 4],
    ['id' => 2002, 'title' => 'Vitamin C Face Cream', 'description' => 'Aydınlatıcı vitamin C kremi', 'price' => 129.99, 'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 60, 'category_id' => 4],
    ['id' => 2003, 'title' => 'Retinol Night Cream', 'description' => 'Gece kullanımı için retinol kremi', 'price' => 219.99, 'image' => 'https://images.unsplash.com/photo-1598460880248-71ec6d2d582b?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8UmV0aW5vbCUyME5pZ2h0JTIwQ3JlYW18ZW58MHx8MHx8fDA%3D', 'stock' => 30, 'category_id' => 4],
    ['id' => 2004, 'title' => 'Micellar Cleansing Water', 'description' => 'Hassas ciltler için misellar su', 'price' => 79.99, 'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 80, 'category_id' => 4],
    ['id' => 2005, 'title' => 'Clay Face Mask', 'description' => 'Arındırıcı kil maskesi', 'price' => 99.99, 'image' => 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 50, 'category_id' => 4],
    
    // Saç Bakımı
    ['id' => 2006, 'title' => 'Keratin Hair Shampoo', 'description' => 'Onarıcı keratin şampuan', 'price' => 89.99, 'image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 70, 'category_id' => 4],
    ['id' => 2007, 'title' => 'Argan Oil Hair Mask', 'description' => 'Besleyici argan yağı saç maskesi', 'price' => 149.99, 'image' => 'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 35, 'category_id' => 4],
    ['id' => 2008, 'title' => 'Anti-Dandruff Shampoo', 'description' => 'Kepeğe karşı etkili şampuan', 'price' => 69.99, 'image' => 'https://images.unsplash.com/photo-1580870069867-74c57ee1bb07?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 55, 'category_id' => 4],
    
    // Kişisel Hijyen
    ['id' => 2009, 'title' => 'Natural Deodorant', 'description' => 'Doğal içerikli deodorant', 'price' => 49.99, 'image' => 'https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 90, 'category_id' => 4],
    ['id' => 2010, 'title' => 'Electric Toothbrush', 'description' => 'Şarjlı elektrikli diş fırçası', 'price' => 5299.99, 'image' => 'https://images.unsplash.com/photo-1559671216-bda69517c47f?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8RWxlY3RyaWMlMjBUb290aGJydXNofGVufDB8fDB8fHww', 'stock' => 25, 'category_id' => 4],
    ['id' => 2011, 'title' => 'Whitening Toothpaste', 'description' => 'Beyazlatıcı diş macunu', 'price' => 39.99, 'image' => 'https://images.unsplash.com/photo-1706520636650-024a369fbcdf?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8d2hpdGVuaW4lMjB0b290aHBhc3RlfGVufDB8fDB8fHww', 'stock' => 100, 'category_id' => 4],
    
    // Parfüm ve Kozmetik
    ['id' => 2012, 'title' => 'Eau de Parfum 50ml', 'description' => 'Lüks kadın parfümü, 50ml', 'price' => 389.99, 'image' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 20, 'category_id' => 4],
    ['id' => 2013, 'title' => 'Matte Lipstick Set', 'description' => '5\'li mat ruj seti', 'price' => 159.99, 'image' => 'https://images.unsplash.com/photo-1585519356004-2bd6527d9cbe?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8TWF0dGUlMjBMaXBzdGljayUyMFNldHxlbnwwfHwwfHx8MA%3D%3D', 'stock' => 40, 'category_id' => 4],
    ['id' => 2014, 'title' => 'BB Cream SPF 30', 'description' => 'Güneş koruyuculu BB krem', 'price' => 619.99, 'image' => 'https://images.unsplash.com/photo-1661346379735-1b47433530b6?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTZ8fGJiJTIwY3JlYW18ZW58MHx8MHx8fDA%3D', 'stock' => 65, 'category_id' => 4],
    ['id' => 2015, 'title' => 'Nail Polish Set', 'description' => '10\'lu oje seti, farklı renkler', 'price' => 889.99, 'image' => 'https://images.unsplash.com/photo-1667242196599-d2869afe3c3e?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8TmFpbCUyMFBvbGlzaCUyMFNldHxlbnwwfHwwfHx8MA%3D%3D', 'stock' => 75, 'category_id' => 4]
];

// Filtreleri uygula
$products = $mockProducts;

// Fiyat filtreleri
if (!empty($min_price)) {
    $products = array_filter($products, function($product) use ($min_price) {
        return $product['price'] >= $min_price;
    });
}

if (!empty($max_price)) {
    $products = array_filter($products, function($product) use ($max_price) {
        return $product['price'] <= $max_price;
    });
}

// Sıralama
switch($sort_by) {
    case 'price_asc':
        usort($products, function($a, $b) {
            return $a['price'] <=> $b['price'];
        });
        break;
    case 'price_desc':
        usort($products, function($a, $b) {
            return $b['price'] <=> $a['price'];
        });
        break;
    case 'name_asc':
        usort($products, function($a, $b) {
            return strcmp($a['title'], $b['title']);
        });
        break;
    case 'newest':
    default:
        // Varsayılan sıralama (mock data için id'ye göre ters)
        usort($products, function($a, $b) {
            return $b['id'] <=> $a['id'];
        });
        break;
}

// Array'i tekrar indeksle
$products = array_values($products);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopNex - Kişisel Bakım</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #FBFBFB;
            min-height: 100vh;
        }
        
        /* Header Styles - Same as homepage */
        .header {
            background-color: white;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-bottom: 1px solid #e0e0e0;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            gap: 30px;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            text-decoration: none;
            min-width: 140px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .logo-icon {
            width: 54px;
            height: 54px;
            object-fit: contain;
        }
        
        .logo-shop {
            color: #1e3a8a;
        }
        
        .logo-nex {
            color: #dc2626;
        }
        
        .search-container {
            flex: 1;
            max-width: 500px;
            position: relative;
        }
        
        .search-box {
            width: 100%;
            padding: 12px 50px 12px 15px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #dc2626;
        }
        
        .header-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .header-btn {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #e9ecef;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            min-width: 100px;
            justify-content: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .header-btn:hover {
            background-color: #dc2626;
            color: white;
            border-color: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        
        /* Navbar - Same as homepage */
        .navbar {
            background-color: white;
            border-top: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            padding: 1px 0;
        }
        
        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
            gap: 30px;
        }
        
        .nav-btn {
            background-color: white;
            color: black;
            border: none;
            padding: 15px 25px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            border-radius: 0;
        }
        
        .nav-btn:hover, .nav-btn.active {
            background-color: #f8f8f8;
            color: #dc2626;
        }
        
        /* Main Content Layout */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            gap: 30px;
        }
        
        /* Filter Sidebar */
        .filter-sidebar {
            width: 280px;
            background: white;
            border-radius: 12px;
            padding: 25px;
            height: fit-content;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            position: sticky;
            top: 20px;
        }
        
        .filter-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .filter-section {
            margin-bottom: 25px;
        }
        
        .filter-section-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 12px;
        }
        
        .filter-options {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .filter-option {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #666;
        }
        
        .filter-option:hover, .filter-option.active {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
            text-decoration: none;
        }
        
        .price-range {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .price-input {
            width: 80px;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .sort-section {
            border-top: 2px solid #f0f0f0;
            padding-top: 20px;
        }
        
        .sort-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }
        
        .filter-apply-btn {
            width: 100%;
            background: #dc2626;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.2s ease;
        }
        
        .filter-apply-btn:hover {
            background: #dc2626;
        }
        
        /* Products Section */
        .products-section {
            flex: 1;
        }
        
        .page-title {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .results-info {
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .product-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-color: #dc2626;
        }
        
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #f8f9fa;
        }
        
        .product-info {
            padding: 15px;
        }
        
        .product-name {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            font-weight: 500;
            line-height: 1.3;
            height: 40px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        .product-price {
            font-size: 18px;
            color: #1e3a8a;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .add-to-cart-btn {
            width: 100%;
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        
        .add-to-cart-btn:hover {
            background: #dc2626;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .main-container {
                flex-direction: column;
                padding: 15px;
            }
            
            .filter-sidebar {
                width: 100%;
                position: static;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <a href="index.php" class="logo">
                <img src="admin/uploads/shoppingbag.png" alt="ShopNex Logo" class="logo-icon">
                <span class="logo-shop">Shop</span>
                <span class="logo-nex">Nex</span>
            </a>
            
            <div class="search-container">
                <form action="search.php" method="GET" style="display: flex; width: 100%;">
                    <input type="text" name="q" class="search-box" placeholder="Aradığınız ürün, kategori veya markayı yazınız">
                    <button type="submit" class="search-btn">🔍</button>
                </form>
            </div>
            
            <div class="header-buttons">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span style="color: black; margin-right: 10px;">Merhaba, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="user/cart.php" class="header-btn">🛒 Sepetim</a>
                    <a href="logout.php" class="header-btn">Çıkış Yap</a>
                <?php else: ?>
                    <a href="login.php" class="header-btn">👤 Giriş Yap</a>
                    <a href="register.php" class="header-btn"> 🛒 Sepete Ekle</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="nav-btn">AnaSayfa</a>
            <a href="women.php" class="nav-btn">Kadın</a>
            <a href="men.php" class="nav-btn">Erkek</a>
            <a href="sports.php" class="nav-btn">Spor</a>
            <a href="personal-care.php" class="nav-btn active">Kişisel Bakım</a>
            <a href="electronics.php" class="nav-btn">Elektronik</a>
            <a href="home-living.php" class="nav-btn">Ev & Yaşam</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Filter Sidebar -->
        <aside class="filter-sidebar">
            <h3 class="filter-title">Filtreler</h3>
            
            <form method="GET" action="">
                <!-- Beden Filtresi -->
                <div class="filter-section">
                    <h4 class="filter-section-title">Beden</h4>
                    <div class="filter-options">
                        <a href="?size=XS<?php echo !empty($_GET['color']) ? '&color='.$_GET['color'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $size_filter == 'XS' ? 'active' : ''; ?>">XS</a>
                        <a href="?size=S<?php echo !empty($_GET['color']) ? '&color='.$_GET['color'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $size_filter == 'S' ? 'active' : ''; ?>">S</a>
                        <a href="?size=M<?php echo !empty($_GET['color']) ? '&color='.$_GET['color'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $size_filter == 'M' ? 'active' : ''; ?>">M</a>
                        <a href="?size=L<?php echo !empty($_GET['color']) ? '&color='.$_GET['color'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $size_filter == 'L' ? 'active' : ''; ?>">L</a>
                        <a href="?size=XL<?php echo !empty($_GET['color']) ? '&color='.$_GET['color'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $size_filter == 'XL' ? 'active' : ''; ?>">XL</a>
                        <a href="?size=XXL<?php echo !empty($_GET['color']) ? '&color='.$_GET['color'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $size_filter == 'XXL' ? 'active' : ''; ?>">XXL</a>
                    </div>
                </div>

                <!-- Renk Filtresi -->
                <div class="filter-section">
                    <h4 class="filter-section-title">Renk</h4>
                    <div class="filter-options">
                        <a href="?color=Siyah<?php echo !empty($_GET['size']) ? '&size='.$_GET['size'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $color_filter == 'Siyah' ? 'active' : ''; ?>">Siyah</a>
                        <a href="?color=Beyaz<?php echo !empty($_GET['size']) ? '&size='.$_GET['size'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $color_filter == 'Beyaz' ? 'active' : ''; ?>">Beyaz</a>
                        <a href="?color=Kırmızı<?php echo !empty($_GET['size']) ? '&size='.$_GET['size'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $color_filter == 'Kırmızı' ? 'active' : ''; ?>">Kırmızı</a>
                        <a href="?color=Mavi<?php echo !empty($_GET['size']) ? '&size='.$_GET['size'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $color_filter == 'Mavi' ? 'active' : ''; ?>">Mavi</a>
                        <a href="?color=Yeşil<?php echo !empty($_GET['size']) ? '&size='.$_GET['size'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $color_filter == 'Yeşil' ? 'active' : ''; ?>">Yeşil</a>
                        <a href="?color=Pembe<?php echo !empty($_GET['size']) ? '&size='.$_GET['size'] : ''; ?><?php echo !empty($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>" 
                           class="filter-option <?php echo $color_filter == 'Pembe' ? 'active' : ''; ?>">Pembe</a>
                    </div>
                </div>

                <!-- Fiyat Aralığı -->
                <div class="filter-section">
                    <h4 class="filter-section-title">Fiyat Aralığı</h4>
                    <div class="price-range">
                        <input type="number" name="min_price" class="price-input" placeholder="Min" value="<?php echo htmlspecialchars($min_price); ?>">
                        <span>-</span>
                        <input type="number" name="max_price" class="price-input" placeholder="Max" value="<?php echo htmlspecialchars($max_price); ?>">
                        <span>TL</span>
                    </div>
                </div>

                <!-- Sıralama -->
                <div class="filter-section sort-section">
                    <h4 class="filter-section-title">Sıralama</h4>
                    <select name="sort" class="sort-select" onchange="this.form.submit()">
                        <option value="newest" <?php echo $sort_by == 'newest' ? 'selected' : ''; ?>>En Yeni</option>
                        <option value="price_asc" <?php echo $sort_by == 'price_asc' ? 'selected' : ''; ?>>Fıyat (Düşükten Yükseğe)</option>
                        <option value="price_desc" <?php echo $sort_by == 'price_desc' ? 'selected' : ''; ?>>Fiyat (Yüksekten Düşüğe)</option>
                        <option value="name_asc" <?php echo $sort_by == 'name_asc' ? 'selected' : ''; ?>>İsim (A-Z)</option>
                    </select>
                </div>

                <button type="submit" class="filter-apply-btn">Filtreleri Uygula</button>
            </form>
        </aside>

        <!-- Products Section -->
        <main class="products-section">
            <h1 class="page-title">🧴 Kişisel Bakım</h1>
            <p class="results-info"><?php echo count($products); ?> ürün bulundu</p>

            <div class="products-grid">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img class="product-image" src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                            <div class="product-info">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['title']); ?></h3>
                                <p class="product-price"><?php echo number_format($product['price'], 2); ?> TL</p>
                                <button class="add-to-cart-btn">Sepete Ekle</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px; color: #666;">
                        <h3>Ürün bulunamadı</h3>
                        <p>Aradığınız kriterlere uygun ürün bulunmamaktadır. Filtreleri değiştirmeyi deneyin.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html> 