<?php
session_start();
require_once "config.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (strlen($username) < 3) $errors[] = "Kullanıcı adı en az 3 karakter olmalıdır.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Geçerli bir e-posta giriniz.";
    if (strlen($password) < 6) $errors[] = "Parola en az 6 karakter olmalıdır.";
    if ($password !== $password_confirm) $errors[] = "Parolalar uyuşmuyor.";

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors[] = "Bu kullanıcı adı veya e-posta zaten kullanılıyor.";
    }

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $insert = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $username, $email, $password_hash);
        if ($insert->execute()) {
            $_SESSION['user_id'] = $insert->insert_id;
            $_SESSION['username'] = $username;
            header("Location: user/shop.php");
            exit;
        } else {
            $errors[] = "Kayıt sırasında hata oluştu.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5" style="max-width: 400px;">
    <h3>Kayıt Ol</h3>
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
            <label>E-posta</label>
            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
        </div>
        <div class="mb-3">
            <label>Parola</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Parola Tekrar</label>
            <input type="password" name="password_confirm" class="form-control" required />
        </div>
        <button class="btn btn-primary w-100">Kayıt Ol</button>
        <a href="login.php" class="btn btn-link mt-2">Zaten üye misiniz? Giriş Yapın</a>
    </form>
</div>
</body>
</html>
