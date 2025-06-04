<?php
// Hata gösterimini açalım - geliştirme aşaması için
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "../config.php";  // config.php yolunun doğru olduğundan emin ol

// Kullanıcı giriş yapmamışsa login sayfasına gönder
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Sepete ürün ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Ürün stok bilgisini alalım
    $stock_stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
    if (!$stock_stmt) {
        die("Prepare hatası (stok kontrol): " . $conn->error);
    }
    $stock_stmt->bind_param("i", $product_id);
    $stock_stmt->execute();
    $stock_result = $stock_stmt->get_result();
    $product = $stock_result->fetch_assoc();

    if (!$product) {
        die("Ürün bulunamadı.");
    }

    if (intval($product['stock']) <= 0) {
        // Stok yok, sepete eklenemez
        $_SESSION['error'] = "Üzgünüz, bu ürünün stokları tükendi.";
        header("Location: shop.php");
        exit;
    }

    // Sepette ürün var mı kontrol et
    $stmt = $conn->prepare("SELECT quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
    if (!$stmt) {
        die("Prepare hatası: " . $conn->error);
    }
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Ürün varsa miktarı artır
        $new_quantity = $row['quantity'] + 1;

        // Stoktan fazla ekleme yapılmasın (opsiyonel)
        if ($new_quantity > intval($product['stock']) + $row['quantity']) {
            // Burada dikkat: stok güncel ama sepette var, toplam stok+sepetteki miktar karşılaştırılır.
            $_SESSION['error'] = "Bu üründen stokta yeterli miktar yok.";
            header("Location: shop.php");
            exit;
        }

        $update = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
        if (!$update) {
            die("Prepare hatası (update): " . $conn->error);
        }
        $update->bind_param("iii", $new_quantity, $user_id, $product_id);
        $update->execute();
    } else {
        // Ürün yoksa yeni ekle
        $insert = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, 1)");
        if (!$insert) {
            die("Prepare hatası (insert): " . $conn->error);
        }
        $insert->bind_param("ii", $user_id, $product_id);
        $insert->execute();
    }

    // Stoktan 1 azalt
    $new_stock = intval($product['stock']) - 1;
    $stock_update = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
    if (!$stock_update) {
        die("Prepare hatası (stok güncelleme): " . $conn->error);
    }
    $stock_update->bind_param("ii", $new_stock, $product_id);
    $stock_update->execute();

    // İşlem sonrası sayfayı yenile
    header("Location: shop.php");
    exit;
}

// Ürünleri listeleme kısmı (kategori filtresi dahil)
$filterCategory = $_GET['category'] ?? '';

if ($filterCategory) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $filterCategory);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM products ORDER BY created_at DESC";
    $result = $conn->query($sql);
    if (!$result) {
        die("Ürün sorgu hatası: " . $conn->error);
    }
}

// Kullanıcının sepetindeki ürünleri al
$cart_stmt = $conn->prepare("SELECT product_id FROM cart_items WHERE user_id = ?");
if (!$cart_stmt) {
    die("Prepare hatası (cart): " . $conn->error);
}
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();

$cart_product_ids = [];
while ($row = $cart_result->fetch_assoc()) {
    $cart_product_ids[] = $row['product_id'];
}

// Kategorileri al
$categories_result = $conn->query("SELECT DISTINCT category FROM products ORDER BY category ASC");
$categories = [];
if ($categories_result) {
    while ($cat = $categories_result->fetch_assoc()) {
        $categories[] = $cat['category'];
    }
}


$search = $_GET['search'] ?? '';

if (!empty($search)) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE title LIKE ?");
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("s", $searchTerm);
} else {
    $stmt = $conn->prepare("SELECT * FROM products");
}

$stmt->execute();
$result = $stmt->get_result();
?>



<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Alışveriş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        
        body {
  min-height: 100vh;
  position: relative;
  padding-bottom: 100px; 
  box-sizing: border-box;
  background-color: #f8f9fa;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0; 
}

footer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100px; 
  background-color: #343a40;
  color: #adb5bd;
  padding: 15px 30px;
  display: flex;
  align-items: center; 
  box-shadow: 0 -2px 8px rgba(0,0,0,0.2);
  z-index: 9999;
  margin: 0;
}


        nav.navbar {
          box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        a.btn-outline-primary {
          border-width: 2px;
          font-weight: 600;
        }
        a.btn-outline-primary:hover {
          background-color: #0d6efd;
          color: white !important;
        }
        a.btn-outline-danger {
          border-width: 2px;
          font-weight: 600;
        }
        a.btn-outline-danger:hover {
          background-color: #dc3545;
          color: white !important;
        }
        .card {
          border-radius: 12px;
          box-shadow: 0 4px 12px rgba(0,0,0,0.1);
          transition: transform 0.2s ease, box-shadow 0.2s ease;
          position: relative;
        }
        .card:hover {
          transform: translateY(-6px);
          box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .card-img-top {
          height: 200px;
          object-fit: cover;
          border-radius: 12px 12px 0 0;
          width: 100%;
        }
        .card-title {
          font-weight: 700;
          color: #0d6efd;
          margin-bottom: 0.75rem;
        }
        .card-text.flex-grow-1 {
          color: #555;
          font-size: 0.95rem;
        }
        .card-text.fw-bold {
          font-size: 1.15rem;
          color: #198754;
          margin-top: auto;
          margin-bottom: 1rem;
        }
        button.btn-success {
          font-weight: 600;
          background-color: #198754;
          border: none;
        }
        button.btn-primary {
          font-weight: 600;
          padding-left: 1.2rem;
          padding-right: 1.2rem;
        }
        .container {
          max-width: 1140px;
        }
        p {
          font-size: 1.1rem;
          color: #666;
        }

        /* Logo */
        .navbar-brand img {
          height: 40px;
          width: auto;
          margin-right: 10px;
        }

        .search-input {
          max-width: 250px;
        }
      
        .filter-select {
          max-width: 180px;
          margin-left: 15px;
        }

        .out-of-stock-label {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #dc3545;
            color: white;
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 6px;
            z-index: 10;
            font-size: 0.9rem;
            user-select: none;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
    <a class="navbar-brand d-flex align-items-center" href="#">
    Bi Nevi Baykuş Alışveriş    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navContent">
    <form class="d-flex ms-auto" method="GET" action="shop.php" role="search">
    <input
        class="form-control me-2 search-input"
        type="search"
        name="search"
        placeholder="Ürün ara..."
        aria-label="Ara"
        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
    />
    <button class="btn btn-outline-primary" type="submit">Ara</button>
</form>


   

        <div class="ms-3 d-flex align-items-center">
            <span class="me-3">Hoşgeldin, <?= htmlspecialchars($_SESSION['username'] ?? 'Misafir') ?></span>
            <a href="cart.php" class="btn btn-outline-primary me-2">Sepet (<?= count($cart_product_ids) ?>)</a>
            <a href="../logout.php" class="btn btn-outline-danger">Çıkış</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
<div class="row">
<?php

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">'.htmlspecialchars($_SESSION['error']).'</div>';
    unset($_SESSION['error']);
}
?>

<div class="row">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($product = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if (intval($product['stock']) <= 0): ?>
                        <div class="out-of-stock-label">Stokta Yok</div>
                    <?php endif; ?>
                    <img 
                        src="../admin/uploads/<?= htmlspecialchars(basename($product['image'])) ?>" 
                        alt="<?= htmlspecialchars($product['title']) ?>" 
                        class="card-img-top mb-3" 
                        style="max-height: 200px; object-fit: contain; width: 100%;"
                    />
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($product['title']) ?></h5>
                        <p class="card-text flex-grow-1"><?= htmlspecialchars($product['description']) ?></p>
                        <p class="card-text fw-bold"><?= number_format($product['price'], 2, ',', '.') ?> ₺</p>

                        <?php if (intval($product['stock']) > 0): ?>
                            <p class="card-text text-muted"> Stok Adedi: <strong><?= intval($product['stock']) ?></strong></p>
                        <?php endif; ?>

                        <?php if (in_array($product['id'], $cart_product_ids)): ?>
                            <button class="btn btn-success" disabled>Sepete Eklendi</button>
                        <?php else: ?>
                            <form method="POST" action="">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>" />
                                <button 
                                    type="submit" 
                                    class="btn btn-primary" 
                                    <?= (intval($product['stock']) <= 0) ? 'disabled' : '' ?>
                                >Sepete Ekle</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Henüz ürün bulunmamaktadır.</p>
    <?php endif; ?>
</div>

<footer>
    <div class="footer-container d-flex justify-content-between flex-wrap align-items-center">
        <div>
            &copy; <?= date('Y') ?> Tüm hakları saklıdır.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>