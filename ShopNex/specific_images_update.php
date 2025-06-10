<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Her ürün için başlığına tam uygun özel görseller
    $updates = [
        // ELBİSELER - Farklı elbise modelleri
        75 => 'https://images.unsplash.com/photo-1566479179817-c0c43c5dec4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Siyah Elbise
        76 => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Pembe Elbise
        77 => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Çiçekli Elbise
        
        // BLUZ VE GÖMLEKLER
        78 => 'https://images.unsplash.com/photo-1551488831-00ddcb6c6bd3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Beyaz Bluz
        79 => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Çizgili Gömlek
        
        // PANTOLONLAR
        80 => 'https://images.unsplash.com/photo-1582418702059-97ebafb35d09?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Jean Pantolon
        81 => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Şort
        
        // KAZAK VE HIRKA
        82 => 'https://images.unsplash.com/photo-1618932260643-eee4a2f652a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Kırmızı Kazak
        83 => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=85', // Gri Hırka
        
        // CEKET VE TİŞÖRT
        84 => 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Kot Ceket
        85 => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // V Yaka Tişört
        
        // AYAKKABILAR - Her biri farklı model
        86 => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Topuklu Ayakkabı
        87 => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Spor Ayakkabı
        88 => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Babet
        89 => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Kış Bot
        
        // ÇANTA VE AKSESUAR
        90 => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Deri Çanta
        91 => 'https://images.unsplash.com/photo-1553733342-6d8c13c0c9c8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Deri Kemer
        
        // SPOR VE TAKIM
        92 => 'https://images.unsplash.com/photo-1506629905587-4791d7df3fdc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Spor Tayt
        93 => 'https://images.unsplash.com/photo-1601924357840-a2f8a9b1b71d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Yün Şal
        94 => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=85'  // Takım Elbise
    ];
    
    $successCount = 0;
    $errorCount = 0;
    
    echo "<h2>🛍️ Ürün Görselleri Güncelleniyor...</h2>";
    
    foreach ($updates as $productId => $imageUrl) {
        try {
            // Önce ürün adını al
            $stmt = $pdo->prepare("SELECT name FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $product = $stmt->fetch();
            
            if ($product) {
                // Görseli güncelle
                $stmt = $pdo->prepare("UPDATE products SET image = ? WHERE id = ?");
                $stmt->execute([$imageUrl, $productId]);
                echo "✅ <strong>$productId</strong> - {$product['name']} güncellendi<br>";
                $successCount++;
            }
        } catch (PDOException $e) {
            echo "❌ Ürün $productId güncelleme hatası: " . $e->getMessage() . "<br>";
            $errorCount++;
        }
    }
    
    echo "<br><div style='background: #f0f8ff; padding: 15px; border-radius: 8px;'>";
    echo "<h3>📊 Güncelleme Sonucu:</h3>";
    echo "<p>✅ <strong>Başarılı:</strong> $successCount ürün</p>";
    echo "<p>❌ <strong>Hatalı:</strong> $errorCount ürün</p>";
    echo "<p>📦 <strong>Toplam:</strong> " . count($updates) . " ürün işlendi</p>";
    echo "</div><br>";
    
    echo "<div style='text-align: center; margin: 20px;'>";
    echo "<a href='women.php' style='background: #ff6b35; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px;'>👗 Kadın Kategorisi</a>";
    echo "<a href='index.php' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px;'>🏠 Ana Sayfa</a>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "❌ Bağlantı hatası: " . $e->getMessage();
}
?> 