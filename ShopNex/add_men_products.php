<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Erkek ürünleri - Her başlığa uygun görsel
    $menProducts = [
        // T-Shirt ve Polo Yaka
        ['Erkek Siyah Basic T-Shirt', 'Pamuklu siyah basic t-shirt, günlük kullanım için ideal', 89.99, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 50],
        ['Erkek Beyaz Polo Yaka T-Shirt', 'Klasik beyaz polo yaka t-shirt, şık ve rahat', 129.99, 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 45],
        ['Erkek Lacivert Uzun Kollu T-Shirt', 'Pamuklu lacivert uzun kollu t-shirt', 99.99, 'https://images.unsplash.com/photo-1581803118522-7b72a50f7e9f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 40],
        
        // Gömlek ve Formal
        ['Erkek Beyaz Klasik Gömlek', 'İş hayatı için beyaz klasik gömlek', 179.99, 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 35],
        ['Erkek Mavi Casual Gömlek', 'Günlük kullanım için mavi casual gömlek', 159.99, 'https://images.unsplash.com/photo-1589310243389-96a5483213a8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 30],
        ['Erkek Siyah Smoking Gömlek', 'Özel günler için siyah smoking gömlek', 249.99, 'https://images.unsplash.com/photo-1520975954732-35dd22299614?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 25],
        
        // Pantolon
        ['Erkek Siyah Klasik Pantolon', 'İş hayatı için siyah klasik pantolon', 199.99, 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 40],
        ['Erkek Mavi Jean Pantolon', 'Slim fit mavi jean pantolon, modern kesim', 169.99, 'https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 55],
        ['Erkek Kargo Pantolon', 'Rahat kargo pantolon, çok cepli', 139.99, 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 35],
        
        // Kazak ve Sweatshirt
        ['Erkek Gri Kapüşonlu Sweatshirt', 'Pamuklu gri kapüşonlu sweatshirt', 149.99, 'https://images.unsplash.com/photo-1556821840-3a9b5bbdeac1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 45],
        ['Erkek Siyah Kazak', 'Yünlü siyah kazak, kış için ideal', 199.99, 'https://images.unsplash.com/photo-1618932260643-eee4a2f652a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 30],
        ['Erkek Lacivert Cardigan', 'Düğmeli lacivert cardigan, şık ve rahat', 229.99, 'https://images.unsplash.com/photo-1556821840-3a9b5bbdeac1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=75', 25],
        
        // Ceket ve Mont
        ['Erkek Siyah Blazer Ceket', 'Slim fit siyah blazer ceket, formal', 399.99, 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 20],
        ['Erkek Denim Ceket', 'Vintage mavi denim ceket', 179.99, 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 30],
        ['Erkek Kış Montu', 'Su geçirmez kış montu, kapüşonlu', 459.99, 'https://images.unsplash.com/photo-1520975954732-35dd22299614?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=75', 15],
        
        // Ayakkabı
        ['Erkek Siyah Klasik Ayakkabı', 'Deri siyah klasik ayakkabı, ofis için', 299.99, 'https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 25],
        ['Erkek Beyaz Spor Ayakkabı', 'Günlük beyaz spor ayakkabı, rahat', 219.99, 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 40],
        ['Erkek Kahverengi Bot', 'Deri kahverengi bot, kış için ideal', 349.99, 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 20],
        
        // Aksesuar
        ['Erkek Siyah Deri Kemer', 'Gerçek deri siyah kemer, metal tokali', 79.99, 'https://images.unsplash.com/photo-1553733342-6d8c13c0c9c8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 60],
        ['Erkek Deri Cüzdan', 'Siyah deri cüzdan, çok bölmeli', 119.99, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', 35]
    ];
    
    $successCount = 0;
    $errorCount = 0;
    
    echo "<h2>👨 Erkek Ürünleri Ekleniyor...</h2>";
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 10px 0;'>";
    
    foreach ($menProducts as $product) {
        try {
            $stmt = $pdo->prepare("INSERT INTO products (title, description, price, image, stock, category_id) VALUES (?, ?, ?, ?, ?, 2)");
            $stmt->execute($product);
            echo "✅ <strong>{$product[0]}</strong> - {$product[1]} → Eklendi (Fiyat: {$product[2]} TL)<br>";
            $successCount++;
        } catch (PDOException $e) {
            echo "❌ {$product[0]} eklenirken hata: " . $e->getMessage() . "<br>";
            $errorCount++;
        }
    }
    
    echo "</div>";
    echo "<div style='background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;'>";
    echo "<h3>🏆 ERKEK ÜRÜNLERİ EKLENDİ!</h3>";
    echo "<p><strong>✅ Başarılı:</strong> $successCount ürün</p>";
    echo "<p><strong>❌ Hatalı:</strong> $errorCount ürün</p>";
    echo "<p><strong>📦 Toplam:</strong> " . count($menProducts) . " ürün işlendi</p>";
    echo "</div><br>";
    
    echo "<div style='text-align: center; margin: 20px;'>";
    echo "<a href='men.php' style='background: #007bff; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; margin: 10px; display: inline-block; font-weight: bold;'>👨 ERKEK KATEGORİSİ</a>";
    echo "<a href='index.php' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; margin: 10px; display: inline-block; font-weight: bold;'>🏠 ANA SAYFA</a>";
    echo "</div>";
    
    echo "<div style='background: #e3f2fd; padding: 15px; border-radius: 8px; margin-top: 20px;'>";
    echo "<h4>📋 Eklenen Erkek Kategorileri:</h4>";
    echo "<ul>";
    echo "<li>👕 <strong>T-Shirt & Polo:</strong> Basic, Polo Yaka, Uzun Kollu modeller</li>";
    echo "<li>👔 <strong>Gömlek:</strong> Klasik, Casual, Smoking modelleri</li>";
    echo "<li>👖 <strong>Pantolon:</strong> Klasik, Jean, Kargo modelleri</li>";
    echo "<li>🧥 <strong>Üst Giyim:</strong> Sweatshirt, Kazak, Cardigan</li>";
    echo "<li>🧥 <strong>Ceket & Mont:</strong> Blazer, Denim, Kış Montu</li>";
    echo "<li>👞 <strong>Ayakkabı:</strong> Klasik, Spor, Bot modelleri</li>";
    echo "<li>🔗 <strong>Aksesuar:</strong> Kemer, Cüzdan</li>";
    echo "</ul>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "❌ <strong>Veritabanı Bağlantı Hatası:</strong> " . $e->getMessage();
}
?> 