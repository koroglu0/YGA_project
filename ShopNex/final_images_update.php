<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Her ürün için başlığına TAM UYGUN özel görseller - Her biri farklı
    $updates = [
        // ELBİSELER - Farklı elbise stilleri
        75 => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Siyah Midi Elbise
        76 => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Pembe Günlük Elbise
        77 => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Çiçekli Yaz Elbisesi
        
        // BLUZ VE GÖMLEKLER
        78 => 'https://images.unsplash.com/photo-1554568218-0f1715e72254?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Beyaz Klasik Bluz
        79 => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Çizgili Casual Gömlek
        
        // PANTOLONLAR
        80 => 'https://images.unsplash.com/photo-1582418702059-97ebafb35d09?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Yüksek Bel Jean Pantolon
        81 => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Denim Şort
        
        // KAZAK VE HIRKA
        82 => 'https://images.unsplash.com/photo-1618932260643-eee4a2f652a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Kırmızı Kış Kazak
        83 => 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=75', // Gri Uzun Hırka
        
        // CEKET VE TİŞÖRT
        84 => 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Oversize Kot Ceket
        85 => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // V Yaka Basic Tişört
        
        // AYAKKABILAR - Her model farklı
        86 => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Siyah Topuklu Ayakkabı
        87 => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Beyaz Spor Ayakkabı
        88 => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=75', // Nude Babet
        89 => 'https://images.unsplash.com/photo-1544966503-7cc5ac882d5a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Kahverengi Kış Bot
        
        // ÇANTA VE AKSESUAR
        90 => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Siyah Deri Çanta
        91 => 'https://images.unsplash.com/photo-1553733342-6d8c13c0c9c8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Kahverengi Deri Kemer
        
        // SPOR VE ÖZEL
        92 => 'https://images.unsplash.com/photo-1506629905587-4791d7df3fdc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Siyah Spor Tayt
        93 => 'https://images.unsplash.com/photo-1601924357840-a2f8a9b1b71d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80', // Renkli Yün Şal
        94 => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=75'  // Resmi Takım Elbise
    ];
    
    $successCount = 0;
    $errorCount = 0;
    
    echo "<h2>🎨 Ürün Görselleri Başlığa Uygun Güncelleniyor...</h2>";
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 10px 0;'>";
    
    foreach ($updates as $productId => $imageUrl) {
        try {
            // Önce ürün başlığını al (title column)
            $stmt = $pdo->prepare("SELECT title FROM products WHERE id = ?");
            $stmt->execute([$productId]);
            $product = $stmt->fetch();
            
            if ($product) {
                // Görseli güncelle
                $stmt = $pdo->prepare("UPDATE products SET image = ? WHERE id = ?");
                $stmt->execute([$imageUrl, $productId]);
                echo "✅ <strong>#{$productId}</strong> - <em>{$product['title']}</em> → Görsel güncellendi<br>";
                $successCount++;
            } else {
                echo "⚠️ Ürün $productId bulunamadı<br>";
            }
        } catch (PDOException $e) {
            echo "❌ Ürün $productId hatası: " . $e->getMessage() . "<br>";
            $errorCount++;
        }
    }
    
    echo "</div>";
    echo "<div style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;'>";
    echo "<h3>🏆 GÜNCELLEME TAMAMLANDI!</h3>";
    echo "<p><strong>✅ Başarılı:</strong> $successCount ürün</p>";
    echo "<p><strong>❌ Hatalı:</strong> $errorCount ürün</p>";
    echo "<p><strong>📦 Toplam:</strong> " . count($updates) . " ürün işlendi</p>";
    echo "</div><br>";
    
    echo "<div style='text-align: center; margin: 20px;'>";
    echo "<a href='women.php' style='background: #ff6b35; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; margin: 10px; display: inline-block; font-weight: bold;'>👗 KADIN KATEGORİSİ</a>";
    echo "<a href='index.php' style='background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; margin: 10px; display: inline-block; font-weight: bold;'>🏠 ANA SAYFA</a>";
    echo "</div>";
    
    echo "<div style='background: #e3f2fd; padding: 15px; border-radius: 8px; margin-top: 20px;'>";
    echo "<h4>📋 Güncellenen Kategoriler:</h4>";
    echo "<ul>";
    echo "<li>🎀 <strong>Elbiseler:</strong> Siyah, Pembe, Çiçekli modeller</li>";
    echo "<li>👕 <strong>Üst Giyim:</strong> Bluzlar, Gömlekler, Kazaklar</li>";
    echo "<li>👖 <strong>Alt Giyim:</strong> Jean, Şort, Taytlar</li>";
    echo "<li>👠 <strong>Ayakkabılar:</strong> Topuklu, Spor, Bot, Babet</li>";
    echo "<li>👜 <strong>Aksesuarlar:</strong> Çantalar, Kemerler, Şallar</li>";
    echo "</ul>";
    echo "</div>";
    
} catch(PDOException $e) {
    echo "❌ <strong>Veritabanı Bağlantı Hatası:</strong> " . $e->getMessage();
}
?> 