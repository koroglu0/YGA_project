<?php
$host = "localhost";
$db   = "shopping_db";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
