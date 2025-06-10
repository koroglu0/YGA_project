<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Erkek ürünlerini kontrol et
    echo "<h2>🔍 Erkek Ürünleri Görsel Kontrol</h2>";
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = 2 ORDER BY id ASC");
    $stmt->execute();
    $menProducts = $stmt->fetchAll();
    
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 10px 0;'>";
    echo "<h3>Mevcut Erkek Ürünleri:</h3>";
    
    foreach ($menProducts as $product) {
        $imageStatus = !empty($product['image']) && strpos($product['image'], 'https') === 0 ? '✅' : '❌';
        echo "<div style='border: 1px solid #ddd; padding: 10px; margin: 5px 0; border-radius: 5px;'>";
        echo "<strong>#{$product['id']}</strong> - {$product['title']}<br>";
        echo "<span style='font-size: 12px; color: #666;'>{$product['description']}</span><br>";
        echo "<span style='color: #f27a1a; font-weight: bold;'>{$product['price']} TL</span><br>";
        echo "$imageStatus Görsel: " . (!empty($product['image']) ? substr($product['image'], 0, 50) . '...' : 'YOK') . "<br>";
        echo "</div>";
    }
    echo "</div>";
    
    // Düzeltilecek görseller
    $imageUpdates = [
        // T-Shirt ve Polo - Gerçek erkek tişört görselleri
        'Erkek Siyah Basic T-Shirt' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Beyaz Polo Yaka T-Shirt' => 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Lacivert Uzun Kollu T-Shirt' => 'https://images.unsplash.com/photo-1581803118522-7b72a50f7e9f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        
        // Gömlek - Gerçek erkek gömlek görselleri
        'Erkek Beyaz Klasik Gömlek' => 'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Mavi Casual Gömlek' => 'https://images.unsplash.com/photo-1589310243389-96a5483213a8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Siyah Smoking Gömlek' => 'https://images.unsplash.com/photo-1594212951363-b1b1078a7b9c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        
        // Pantolon - Gerçek erkek pantolon görselleri
        'Erkek Siyah Klasik Pantolon' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Mavi Jean Pantolon' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Kargo Pantolon' => 'https://images.unsplash.com/photo-1506629905587-4791d7df3fdc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        
        // Kazak ve Sweatshirt - Gerçek erkek üst giyim görselleri
        'Erkek Gri Kapüşonlu Sweatshirt' => 'https://images.unsplash.com/photo-1556821840-3a9b5bbdeac1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Siyah Kazak' => 'https://images.unsplash.com/photo-1618932260643-eee4a2f652a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Lacivert Cardigan' => 'https://images.unsplash.com/photo-1566479179817-c0c43c5dec4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        
        // Ceket ve Mont - Gerçek erkek ceket görselleri
        'Erkek Siyah Blazer Ceket' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Denim Ceket' => 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Kış Montu' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        
        // Ayakkabı - Gerçek erkek ayakkabı görselleri
        'Erkek Siyah Klasik Ayakkabı' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Beyaz Spor Ayakkabı' => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Kahverengi Bot' => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        
        // Aksesuar - Gerçek erkek aksesuar görselleri
        'Erkek Siyah Deri Kemer' => 'https://images.unsplash.com/photo-1553733342-6d8c13c0c9c8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        'Erkek Deri Cüzdan' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'
    ];
    
    $updateCount = 0;
    echo "<br><h3>🔧 Görseller Güncelleniyor...</h3>";
    echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 8px; margin: 10px 0;'>";
    
    foreach ($imageUpdates as $title => $newImageUrl) {
        try {
            $stmt = $pdo->prepare("UPDATE products SET image = ? WHERE title LIKE ? AND category_id = 2");
            $stmt->execute([$newImageUrl, "%$title%"]);
            
            if ($stmt->rowCount() > 0) {
                echo "✅ <strong>$title</strong> görseli güncellendi<br>";
                $updateCount++;
            } else {
                echo "⚠️ <strong>$title</strong> bulunamadı<br>";
            }
        } catch (PDOException $e) {
            echo "❌ <strong>$title</strong> güncelleme hatası: {$e->getMessage()}<br>";
        }
    }
    
    echo "</div>";
    echo "<div style='background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;'>";
    echo "<h3>🎉 GÖRSEL GÜNCELLEMESİ TAMAMLANDI!</h3>";
    echo "<p><strong>✅ Güncellenen:</strong> $updateCount ürün</p>";
    echo "<p><strong>📦 Toplam Kontrol:</strong> " . count($imageUpdates) . " ürün</p>";
    echo "</div><br>";
    
    echo "<div style='text-align: center; margin: 20px;'>";
    echo "<a href='men.php' style='background: #007bff; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; margin: 10px; display: inline-block; font-weight: bold;'>👨 ERKEK KATEGORİSİ</a>";
    echo "<a href='index.php' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; margin: 10px; display: inline-block; font-weight: bold;'>🏠 ANA SAYFA</a>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "❌ <strong>Veritabanı Hatası:</strong> " . $e->getMessage();
}
?> 