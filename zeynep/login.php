<?php
session_start();
require_once "config.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $password_hash);
        $stmt->fetch();

        if (password_verify($password, $password_hash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: user/shop.php");
            exit;
        } else {
            $errors[] = "Kullanıcı adı veya parola yanlış.";
        }
    } else {
        $errors[] = "Kullanıcı adı veya parola yanlış.";
    }
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>  Bi Nevi Baykuş Alışveriş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5" style="max-width: 400px;">
    <h3>  Bi Nevi Baykuş`a Hoşgeldiniz Giriş Yapın</h3>
    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error) echo "<p>$error</p>"; ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Kullanıcı Adı</label>
            <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" />
        </div>
        <div class="mb-3">
            <label>Parola</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <button class="btn btn-primary w-100">Giriş Yap</button>
        <br><br>
        <a href="register.php" class="btn btn-info w-100">Kayıt Ol</a>
    </form>
</div>
</body>
</html>
