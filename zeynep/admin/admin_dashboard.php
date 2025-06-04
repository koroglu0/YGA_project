<?php
session_start();
require_once "../config.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Ürünleri listele
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Admin Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="#">Admin Paneli</a>
    <div class="ms-auto">
        <a href="product_add.php" class="btn btn-success me-2">Ürün Ekle</a>
        <a href="logout.php" class="btn btn-danger">Çıkış</a>
    </div>
</nav>

<div class="container mt-4">
    <h3>Ürün Listesi</h3>
    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Başlık</th>
                <th>Fiyat</th>
                <th>İşlemler</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($product = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['title']) ?></td>
                    <td><?= number_format($product['price'], 2) ?> ₺</td>
                    <td>
                        <a href="product_edit.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-sm">Düzenle</a>
                        <a href="product_delete.php?id=<?= $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silinsin mi?');">Sil</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Henüz ürün yok.</p>
    <?php endif; ?>
</div>
</body>
</html>
