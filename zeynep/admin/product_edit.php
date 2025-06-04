<?php
session_start();
require_once "../config.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: admin_dashboard.php");
    exit;
}

$errors = [];

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header("Location: admin_dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);

    if (strlen($title) < 2) $errors[] = "Başlık en az 2 karakter olmalıdır.";
    if ($price <= 0) $errors[] = "Fiyat sıfırdan büyük olmalıdır.";
    if ($stock < 0) $errors[] = "Stok negatif olamaz.";

  
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = "uploads/";  
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['image']['type'];
        $fileTmpName = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $newFileName = uniqid('img_', true) . '.' . $fileExt;
        $uploadFilePath = $uploadDir . $newFileName;

        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Sadece JPG, PNG ve GIF formatlarında dosya yükleyebilirsiniz.";
        } else {

            if (!empty($product['image']) && file_exists($uploadDir . $product['image'])) {
                unlink($uploadDir . $product['image']);
            }

            if (!move_uploaded_file($fileTmpName, $uploadFilePath)) {
                $errors[] = "Resim yüklenirken bir hata oluştu.";
            }
        }
    } else {
        
        $newFileName = $product['image'];
    }

    if (empty($errors)) {
        $update = $conn->prepare("UPDATE products SET title = ?, description = ?, price = ?, stock = ?, image = ? WHERE id = ?");
        $update->bind_param("ssdisi", $title, $description, $price, $stock, $newFileName, $id);
        if ($update->execute()) {
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $errors[] = "Güncelleme sırasında hata oluştu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Ürün Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4" style="max-width: 600px;">
    <h3>Ürün Düzenle</h3>
    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error) echo "<p>$error</p>"; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Başlık</label>
            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($_POST['title'] ?? $product['title']) ?>" />
        </div>

        <div class="mb-3">
            <label>Açıklama</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($_POST['description'] ?? $product['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Fiyat (₺)</label>
            <input type="number" step="0.01" name="price" class="form-control" required value="<?= htmlspecialchars($_POST['price'] ?? $product['price']) ?>" />
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stock" class="form-control" min="0" required value="<?= htmlspecialchars($_POST['stock'] ?? $product['stock']) ?>" />
        </div>

        <div class="mb-3">
            <label>Mevcut Resim</label><br />
            <?php if (!empty($product['image']) && file_exists("uploads/" . $product['image'])): ?>
                <img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="Ürün Resmi" style="max-width:200px; max-height:150px; border:1px solid #ccc; padding:5px;">
            <?php else: ?>
                <p>Resim bulunamadı.</p>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label>Yeni Resim Yükle (İsterseniz)</label>
            <input type="file" name="image" accept="image/*" class="form-control" />
        </div>

        <button class="btn btn-primary">Güncelle</button>
        <a href="admin_dashboard.php" class="btn btn-secondary ms-2">Geri</a>
    </form>
</div>
</body>
</html>
