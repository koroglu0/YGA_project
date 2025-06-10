<?php
session_start();
require_once 'config.php';

// Filtreleme parametrelerini al
$size_filter = $_GET['size'] ?? '';
$color_filter = $_GET['color'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$sort_by = $_GET['sort'] ?? 'newest';

// Mock Elektronik Ürünleri - Veritabanına kaydetmeden test için
$mockProducts = [
    // Telefon & Tablet
    ['id' => 3001, 'title' => 'iPhone 15 Pro Max 256GB', 'description' => 'Apple iPhone 15 Pro Max, 256GB depolama', 'price' => 97999.99, 'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 15, 'category_id' => 5],
    ['id' => 3002, 'title' => 'Samsung Galaxy S24 Ultra', 'description' => 'Samsung Galaxy S24 Ultra, 512GB', 'price' => 59999.99, 'image' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8c2Ftc3VuZyUyMGdhbGF4eXxlbnwwfHwwfHx8MA%3D%3D', 'stock' => 20, 'category_id' => 5],
    ['id' => 3003, 'title' => 'iPad Pro 12.9" M2 256GB', 'description' => 'Apple iPad Pro 12.9 inç M2 çip', 'price' => 45999.99, 'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 12, 'category_id' => 5],
    ['id' => 3004, 'title' => 'Xiaomi Redmi Note 12 Pro', 'description' => 'Xiaomi Redmi Note 12 Pro 128GB', 'price' => 8999.99, 'image' => 'https://images.unsplash.com/photo-1673718423569-27ce5b3857c2?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fFhpYW9taSUyMFJlZG1pJTIwTm90ZSUyMDEyJTIwUHJvfGVufDB8fDB8fHww', 'stock' => 35, 'category_id' => 5],
    
    // Bilgisayar & Laptop
    ['id' => 3005, 'title' => 'MacBook Pro 14" M3 Pro', 'description' => 'Apple MacBook Pro 14 inç M3 Pro çip', 'price' => 89999.99, 'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 8, 'category_id' => 5],
    ['id' => 3006, 'title' => 'ASUS ROG Gaming Laptop', 'description' => 'ASUS ROG Strix G15, RTX 4060, 16GB RAM', 'price' => 35999.99, 'image' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 10, 'category_id' => 5],
    ['id' => 3007, 'title' => 'Gaming PC RTX 4070 Super', 'description' => 'Özel Gaming PC, RTX 4070 Super, 32GB RAM', 'price' => 55999.99, 'image' => 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 5, 'category_id' => 5],
    
    // TV & Ses Sistemleri
    ['id' => 3008, 'title' => 'LG OLED 65" 4K Smart TV', 'description' => 'LG OLED 65 inç 4K Ultra HD Smart TV', 'price' => 42999.99, 'image' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 7, 'category_id' => 5],
    ['id' => 3009, 'title' => 'Sony WH-1000XM5 Kulaklık', 'description' => 'Sony WH-1000XM5 Noise Cancelling Kulaklık', 'price' => 12999.99, 'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 25, 'category_id' => 5],
    ['id' => 3010, 'title' => 'JBL Charge 5 Bluetooth Hoparlör', 'description' => 'JBL Charge 5 Portable Bluetooth Speaker', 'price' => 3499.99, 'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 30, 'category_id' => 5],
    
    // Akıllı Ev
    ['id' => 3011, 'title' => 'Amazon Echo Dot 5. Nesil', 'description' => 'Amazon Echo Dot 5. Nesil Akıllı Hoparlör', 'price' => 1899.99, 'image' => 'https://images.unsplash.com/photo-1518444065439-e933c06ce9cd?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 40, 'category_id' => 5],
    ['id' => 3012, 'title' => 'Philips Hue Akıllı Ampul Seti', 'description' => 'Philips Hue Color Akıllı LED Ampul 4\'lü Set', 'price' => 2999.99, 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 20, 'category_id' => 5],
    ['id' => 3013, 'title' => 'Ring Video Doorbell Pro', 'description' => 'Ring Video Doorbell Pro Akıllı Kapı Zili', 'price' => 5999.99, 'image' => 'https://images.unsplash.com/photo-1641853256879-bd786e77d852?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8UmluZyUyMFZpZGVvJTIwRG9vcmJlbGwlMjBQcm98ZW58MHx8MHx8fDA%3D', 'stock' => 15, 'category_id' => 5],
    
    // Aksesuarlar
    ['id' => 3014, 'title' => 'Anker PowerBank 20000mAh', 'description' => 'Anker PowerCore 20000mAh Taşınabilir Şarj', 'price' => 1299.99, 'image' => 'https://images.unsplash.com/photo-1614399113305-a127bb2ca893?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cG93ZXJiYW5rfGVufDB8fDB8fHww', 'stock' => 50, 'category_id' => 5],
    ['id' => 3015, 'title' => 'Logitech MX Master 3S Mouse', 'description' => 'Logitech MX Master 3S Wireless Mouse', 'price' => 2799.99, 'image' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 'stock' => 30, 'category_id' => 5]
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
    <title>ShopNex - Elektronik</title>
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
            background:rgb(213, 65, 65);
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
            background:rgb(217, 67, 67);
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
                    <span style="color: white; margin-right: 10px;">Merhaba, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
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
            <a href="personal-care.php" class="nav-btn">Kişisel Bakım</a>
            <a href="electronics.php" class="nav-btn active">Elektronik</a>
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
            <h1 class="page-title">📱 Elektronik</h1>
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