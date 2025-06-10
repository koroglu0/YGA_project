<?php
session_start();

$admin_user = "admin";
$admin_pass = "123456"; 

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $errors[] = "Kullanıcı adı veya parola yanlış.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Admin Giriş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5" style="max-width: 400px;">
    <h3>Admin Giriş</h3>
    <?php if ($errors): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error) echo "<p>$error</p>"; ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label>Kullanıcı Adı</label>
            <input type="text" name="username" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Parola</label>
            <input type="password" name="password" class="form-control" required />
        </div>
        <button class="btn btn-primary w-100">Giriş</button>
    </form>
</div>
</body>
</html>
