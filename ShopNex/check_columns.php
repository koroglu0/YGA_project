<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopping_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h3>Products tablosu yapısı:</h3>";
    $stmt = $pdo->query("DESCRIBE products");
    while ($row = $stmt->fetch()) {
        echo "- <strong>{$row['Field']}</strong> ({$row['Type']})<br>";
    }
    
    echo "<br><h3>Örnek birkaç ürün:</h3>";
    $stmt = $pdo->query("SELECT * FROM products WHERE id BETWEEN 75 AND 78 LIMIT 4");
    while ($row = $stmt->fetch()) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 5px;'>";
        foreach ($row as $key => $value) {
            if (!is_numeric($key)) {
                echo "<strong>$key:</strong> $value<br>";
            }
        }
        echo "</div>";
    }
    
} catch(PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?> 