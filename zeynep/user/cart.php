<?php
session_start();
require_once "../config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Geçersiz CSRF tokeni.");
    }


    if (isset($_POST['remove'])) {
        $remove_id = intval($_POST['remove']);

        $stmt = $conn->prepare("SELECT quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $remove_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $qty_in_cart = $row['quantity'];

            $stmt2 = $conn->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
            $stmt2->bind_param("ii", $qty_in_cart, $remove_id);
            $stmt2->execute();
        }


        $stmt3 = $conn->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
        $stmt3->bind_param("ii", $user_id, $remove_id);
        $stmt3->execute();

        header("Location: cart.php");
        exit;
    }


    if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $product_id => $new_quantity) {
            $product_id = intval($product_id);
            $new_quantity = intval($new_quantity);

            $stmt = $conn->prepare("SELECT quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                $old_quantity = $row['quantity'];
            } else {
                $old_quantity = 0;
            }


            $stmt_stock = $conn->prepare("SELECT stock FROM products WHERE id = ?");
            $stmt_stock->bind_param("i", $product_id);
            $stmt_stock->execute();
            $res_stock = $stmt_stock->get_result();

            if ($res_stock->num_rows == 0) {
                continue; 
            }

            $product_stock = $res_stock->fetch_assoc()['stock'];

            $difference = $new_quantity - $old_quantity;

            if ($new_quantity > 0) {
                if ($difference > 0) {
                    if ($product_stock < $difference) {
                        continue;
                    }
                    $stmt_update_stock = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                    $stmt_update_stock->bind_param("ii", $difference, $product_id);
                    $stmt_update_stock->execute();

                } elseif ($difference < 0) {
                    $diff_abs = abs($difference);
                    $stmt_update_stock = $conn->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
                    $stmt_update_stock->bind_param("ii", $diff_abs, $product_id);
                    $stmt_update_stock->execute();
                }

                if ($old_quantity > 0) {
                    $stmt_update_cart = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?");
                    $stmt_update_cart->bind_param("iii", $new_quantity, $user_id, $product_id);
                    $stmt_update_cart->execute();
                } else {
                    $stmt_insert_cart = $conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
                    $stmt_insert_cart->bind_param("iii", $user_id, $product_id, $new_quantity);
                    $stmt_insert_cart->execute();
                }
            } else {
                if ($old_quantity > 0) {
                    $stmt_update_stock = $conn->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
                    $stmt_update_stock->bind_param("ii", $old_quantity, $product_id);
                    $stmt_update_stock->execute();

                    $stmt_delete_cart = $conn->prepare("DELETE FROM cart_items WHERE user_id = ? AND product_id = ?");
                    $stmt_delete_cart->bind_param("ii", $user_id, $product_id);
                    $stmt_delete_cart->execute();
                }
            }
        }
    }

    header("Location: cart.php");
    exit;
}

$sql = "SELECT c.product_id, c.quantity, p.title, p.price 
        FROM cart_items c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Sepetim</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
    <a class="navbar-brand" href="shop.php">Alışveriş Sitesi</a>
    <div class="ms-auto">
        <span class="me-3">Hoşgeldin, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="shop.php" class="btn btn-outline-primary me-2">Alışverişe Devam Et</a>
        <a href="../logout.php" class="btn btn-outline-danger">Çıkış</a>
    </div>
</nav>

<div class="container mt-4">
    <h3>Sepetim</h3>
    <?php if ($result && $result->num_rows > 0): ?>
    <form method="post" action="cart.php">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="table-responsive">
        <table class="table align-middle">
            <thead>
            <tr>
                <th>Ürün</th>
                <th>Adet</th>
                <th>Birim Fiyat</th>
                <th>Toplam</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()):
                $line_total = $row['price'] * $row['quantity'];
                $total_price += $line_total;
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td style="width: 100px;">
                        <input type="number" name="quantities[<?= $row['product_id'] ?>]" value="<?= $row['quantity'] ?>" min="0" class="form-control" />
                    </td>
                    <td><?= number_format($row['price'], 2) ?> ₺</td>
                    <td><?= number_format($line_total, 2) ?> ₺</td>
                    <td>
                        <form method="post" action="cart.php" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <button type="submit" name="remove" value="<?= $row['product_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu ürünü sepetten silmek istediğinizden emin misiniz?');">
                                Sil
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3" class="text-end fw-bold">Genel Toplam:</td>
                <td colspan="2" class="fw-bold"><?= number_format($total_price, 2) ?> ₺</td>
            </tr>
            </tbody>
        </table>
        </div>
        <button type="submit" class="btn btn-primary">Sepeti Güncelle</button>
    </form>
    <?php else: ?>
        <p>Sepetiniz boş.</p>
    <?php endif; ?>
</div>
</body>
</html>
