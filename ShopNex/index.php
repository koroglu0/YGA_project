<?php
session_start();
require_once 'config.php';

// Popüler ürünleri getir (kadın ve erkek kategorisi hariç, sadece genel ürünler)
$sql = "SELECT * FROM products WHERE image LIKE 'https%' AND (category_id IS NULL OR (category_id != 1 AND category_id != 2)) ORDER BY id DESC LIMIT 12";
$result = $conn->query($sql);
$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Flaş ürünleri getir (kadın ve erkek kategorisi hariç)
$flash_sql = "SELECT * FROM products WHERE image LIKE 'https%' AND (category_id IS NULL OR (category_id != 1 AND category_id != 2)) ORDER BY id DESC LIMIT 9 OFFSET 12";
$flash_result = $conn->query($flash_sql);
$flash_products = [];
if ($flash_result->num_rows > 0) {
    while($row = $flash_result->fetch_assoc()) {
        $flash_products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopNex - Online Alışveriş</title>
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
        
        /* Header Styles */
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
        
        /* Logo */
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
        
        /* Search Area */
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
        
        .search-box::placeholder {
            color: #888;
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
        
        /* Header Buttons */
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
        
        /* Navbar */
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
        
        .nav-btn:hover {
            background-color: #f8f8f8;
            color: #dc2626;
        }
        
        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .welcome-section {
            text-align: center;
            padding: 60px 20px;
            background-color: #ffff;
            border-radius: 12px;
            margin-bottom: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .welcome-title {
            font-size: 36px;
            color: #333;
            margin-bottom: 15px;
            font-weight: 300;
        }
        
        .welcome-subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }
        
        .cta-button {
            background-color: #dc2626;
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s ease;
        }
        
        .cta-button:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
        }
        
        /* Popular Products */
        .popular-products {
            margin-top: 40px;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 24px;
            color: #333;
            margin: 0;
            font-weight: 600;
        }
        
        .view-all-btn {
            color: #dc2626;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .view-all-btn:hover {
            color: #dc2626;
        }
        
        .products-container {
            position: relative;
        }
        
        .products-grid {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            overflow-y: hidden;
            scroll-behavior: smooth;
            padding-bottom: 10px;
        }
        
        .products-grid::-webkit-scrollbar {
            height: 6px;
        }
        
        .products-grid::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .products-grid::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }
        
        .products-grid::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }
        
        .product-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            min-width: 280px;
            flex-shrink: 0;
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
            margin-bottom: 10px;
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
            color: #dc2626;
            font-weight: 600;
        }
        
        .product-old-price {
            font-size: 14px;
            color: #999;
            text-decoration: line-through;
            margin-left: 10px;
        }
        
        /* Popular Categories */
        .popular-categories {
            margin-top: 60px;
        }
        
        .categories-container {
            position: relative;
        }
        
        .categories-grid {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            overflow-y: hidden;
            scroll-behavior: smooth;
            padding-bottom: 10px;
        }
        
        .categories-grid::-webkit-scrollbar {
            height: 6px;
        }
        
        .categories-grid::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .categories-grid::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }
        
        .categories-grid::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }
        
        .category-card {
            min-width: 200px;
            height: 120px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }
        
        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .category-card.tech {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .category-card.hair-care {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .category-card.personal-care {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .category-card.clothing {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        /* Flash Products */
        .flash-products {
            margin-top: 60px;
        }
        
        .flash-title {
            text-align: center;
            font-size: 38px;
            color: #dc2626;
            margin-bottom: 40px;
            font-weight: 900;
        }
        .flash-urunler {
            text-align: center;
            font-size: 38px;
            color: #1e3a8a;
            margin-bottom: 40px;
            font-weight: 900;
        }
        
        .flash-products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .flash-product-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: box-shadow 0.3s ease;
        }
        
        .flash-product-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .flash-product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #f8f9fa;
        }
        
        .flash-product-info {
            padding: 15px;
        }
        
        .flash-product-name {
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
        
        .flash-product-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        
        .flash-product-price {
            font-size: 18px;
            color: #dc2626;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .flash-btn {
            background-color: #1e3a8a;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.2s ease;
        }
        
        .flash-btn:hover {
            background-color: #1e3a8a;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-container {
                order: 3;
                max-width: 100%;
            }
            
            .header-buttons {
                order: 2;
            }
            
            .welcome-title {
                font-size: 28px;
            }
          
            
        }
        .text1Shop{
                color: #1e3a8a;
                font-size:35px;
                font-weight:bold;
            }
            .text1Nex{
                color: #dc2626;
                font-size:35px;
                font-weight:bold;
            }
            .textHosgeldiniz{
                color:#373737;
                font-size:35px;
                font-weight:bold;
            }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <a href="index.php" class="logo">
            <img src="admin/uploads/shoppingbag.png" alt="Sepet İkonu" class="logo-icon" />
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
                    <a href="register.php" class="header-btn">🛒 Sepete Ekle</a>
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
            <a href="electronics.php" class="nav-btn">Elektronik</a>
            <a href="home-living.php" class="nav-btn">Ev & Yaşam</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <section class="welcome-section">
            <span class="text1Shop">Shop</span>
            <span class="text1Nex">Nex'e</span>
            <span class="textHosgeldiniz">Hoşgeldiniz</span>
            <?php if (isset($_SESSION['user_id'])): ?>
                <p class="welcome-subtitle" style="margin-top: 15px; font-size: 20px; color: #333; font-weight: 600;">
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </p>
                <p class="welcome-subtitle">Sevimli dostlarınız için en kaliteli ürünleri keşfedin</p>
                <a href="electronics.php" class="cta-button">Haydi başlayalım</a>
            <?php else: ?>
                <p class="welcome-subtitle">"Binlerce ürünü tek tıkla keşfedin. ShopNex sizi bekliyor!"</p>
                <a href="register.php" class="cta-button">Hemen Başlayın</a>
            <?php endif; ?>
        </section>
        <div class="popular-products">
            <div class="section-header">
                <h2 class="section-title">Popüler Ürünler</h2>
                <a href="electronics.php" class="view-all-btn">Tümünü Gör</a>
            </div>
            <div class="products-container">
                <div class="products-grid">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product-card" onclick="location.href='electronics.php'">
                                <img class="product-image" src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                             
                                <div class="product-info">
                                    <h3 class="product-name"><?php echo htmlspecialchars($product['title']); ?></h3>
                                    <p class="product-price"><?php echo number_format($product['price'], 2); ?> TL</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="text-align: center; padding: 40px; color: #666;">
                            <h3>Henüz ürün bulunmuyor</h3>
                            <p>Yakında yeni ürünler eklenecek!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Popular Categories -->
        <div class="popular-categories">
            <div class="section-header">
                <h2 class="section-title">Popüler Kategoriler</h2>
                <a href="electronics.php" class="view-all-btn">Tümünü Gör</a>
            </div>
            <div class="categories-container">
                <div class="categories-grid">
                    <a href="electronics.php" class="category-card tech">
                       
                        <span>Teknoloji</span>
                    </a>
                    <a href="personal-care.php" class="category-card hair-care">
                        <span>Saç Bakım</span>
                    </a>
                   
                    <a href="men.php" class="category-card clothing">
                        <span>Giyim</span>
                    </a>
                    <a href="electronics.php" class="category-card tech">
                        <span>Elektronik</span>
                    </a>
                   
                    <a href="sports.php" class="category-card personal-care">
                        <span>Spor</span>
                    </a>
                   
                </div>
            </div>
        </div>
        
        <!-- Flash Products -->
        <div class="flash-products">
            <h2 class="flash-title">Flaş Ürünler</h2>
            <div class="flash-products-grid">
                <?php if (!empty($flash_products)): ?>
                    <?php foreach ($flash_products as $product): ?>
                        <div class="flash-product-card">
                            <img class="flash-product-image" src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                            <div class="flash-product-info">
                                <h3 class="flash-product-name"><?php echo htmlspecialchars($product['title']); ?></h3>
                                <p class="flash-product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="flash-product-price"><?php echo number_format($product['price'], 2); ?> TL</p>
                                <button class="flash-btn" onclick="location.href='electronics.php'">Hemen İncele</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="text-align: center; padding: 40px; color: #666; grid-column: 1/-1;">
                        <h3>Henüz flaş ürün bulunmuyor</h3>
                        <p>Yakında yeni flaş ürünler eklenecek!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html> 