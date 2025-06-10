<?php
session_start();
require_once "../config.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);

    $image_path = ''; 
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
    
        $fileTmpPath = $_FILES['image_file']['tmp_name'];
        $fileName = basename($_FILES['image_file']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
    
        if (!in_array($fileExt, $allowedExts)) {
            $errors[] = "Sadece JPG, PNG ve GIF formatında dosya yükleyebilirsiniz.";
        } else {
            $newFileName = uniqid('img_') . '.' . $fileExt;
            $destPath = $uploadDir . $newFileName;
    
            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                $errors[] = "Dosya yüklenemedi. PHP upload_tmp_dir: " . ini_get('upload_tmp_dir') . " | Dosya geçici yolu: $fileTmpPath | Hedef yol: $destPath";
            } else {
                $image_path = 'uploads/' . $newFileName;
            }
        }
    } else {
        $errors[] = "Lütfen bir görsel dosyası seçin. Hata kodu: " . ($_FILES['image_file']['error'] ?? 'Dosya seçilmedi');
    }

    if (strlen($title) < 2) $errors[] = "Başlık en az 2 karakter olmalıdır.";
    if ($price <= 0) $errors[] = "Fiyat sıfırdan büyük olmalıdır.";
    if ($stock < 0) $errors[] = "Stok negatif olamaz.";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO products (title, description, price, image, stock) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsi", $title, $description, $price, $image_path, $stock);
        if ($stmt->execute()) {
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $errors[] = "Ürün eklenirken hata oluştu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Ürün Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4" style="max-width: 600px;">
    <h3>Yeni Ürün Ekle</h3>
    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error) echo "<p>$error</p>"; ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Başlık</label>
            <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" />
        </div>
        <div class="mb-3">
            <label>Açıklama</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>
        <div class="mb-3">
            <label>Fiyat (₺)</label>
            <input type="number" step="0.01" name="price" class="form-control" required value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" />
        </div>
        <div class="mb-3">
            <label>Stok Adedi</label>
            <input type="number" name="stock" class="form-control" required min="0" value="<?= htmlspecialchars($_POST['stock'] ?? '0') ?>" />
        </div>
        <div class="mb-3">
            <label>Ürün Görseli (Dosya Yükle)</label>
            <input type="file" name="image_file" class="form-control" accept=".jpg,.jpeg,.png,.gif" required />
        </div>
        <button class="btn btn-success">Kaydet</button>
        <a href="admin_dashboard.php" class="btn btn-secondary ms-2">Geri</a>
    </form>
</div>
</body>
</html>
