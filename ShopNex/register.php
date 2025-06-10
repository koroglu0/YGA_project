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
            header("Location: index.php");
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopNex - Kayıt Ol</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #FBFBFB;
            min-height: 100vh;
        }
        
        /* Header Styles */
        .header {
            background-color:rgb(255, 255, 255);
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            gap: 30px;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            text-decoration: none;
            min-width: 140px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .logo-icon {
            width: 54px;
            height: 54px;
            object-fit: contain;
        }
        
        .logo-shop {
            color: #1e3a8a;
        }
        
        .logo-nex {
            color: #dc2626;
        }
        
        .search-container {
            flex: 1;
            max-width: 500px;
            position: relative;
        }
        
        .search-box {
            width: 100%;
            padding: 12px 50px 12px 15px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .search-box::placeholder {
            color: #888;
        }
        
        .search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #f27a1a;
        }
        
        .header-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .header-btn {
            background-color: white;
            color: black;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            min-width: 100px;
            justify-content: center;
        }
        
        .header-btn:hover {
            background-color: #f5f5f5;
            transform: translateY(-1px);
        }
        
        /* Navbar */
        .navbar {
            background-color: white;
            border-top: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            padding: 1px 0;
        }
        
        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 20px;
            gap: 30px;
        }
        
        .nav-btn {
            background-color: white;
            color: black;
            border: none;
            padding: 15px 25px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            border-radius: 0;
        }
        
        .nav-btn:hover {
            background-color: #f8f8f8;
            color: #dc2626;
        }
        
        /* Register Card */
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 200px);
            padding: 40px 20px;
        }
        
        .register-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }
        
        .register-title {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #dc2626;
        }
        
        .register-btn {
            width: 100%;
            background-color: #dc2626;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-bottom: 20px;
        }
        
        .register-btn:hover {
            background-color:rgb(243, 46, 46);
        }
        
        .login-text {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }
        
        .login-link {
            width: 100%;
            background-color: white;
            color: #dc2626;
            border: 2px solid #dc2626;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .login-link:hover {
            background-color:rgb(241, 54, 54);
            color: white;
            text-decoration: none;
        }
        
        .error-message {
            background-color: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-container {
                order: 3;
                max-width: 100%;
            }
            
            .header-btn {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #e9ecef;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            min-width: 100px;
            justify-content: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .header-btn:hover {
            background-color: #dc2626;
            color: white;
            border-color: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
        <a href="index.php" class="logo">
            <img src="admin/uploads/shoppingbag.png" alt="Sepet İkonu" class="logo-icon" />
                <span class="logo-shop">Shop</span>
                <span class="logo-nex">Nex</span>
            </a>
            
            <div class="search-container">
                <form action="search.php" method="GET" style="display: flex; width: 100%;">
                    <input type="text" name="q" class="search-box" placeholder="Aradığınız ürün, kategori veya markayı yazınız">
                    <button type="submit" class="search-btn">🔍</button>
                </form>
            </div>
            
            <div class="header-buttons">
                <a href="login.php" class="header-btn">👤 Giriş Yap</a>
                <a href="register.php" class="header-btn">🛒 Sepete Ekle</a>
            </div>
        </div>
    </header>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="nav-btn">AnaSayfa</a>
            <a href="women.php" class="nav-btn">Kadın</a>
            <a href="men.php" class="nav-btn">Erkek</a>
            <a href="sports.php" class="nav-btn">Spor</a>
            <a href="personal-care.php" class="nav-btn">Kişisel Bakım</a>
            <a href="electronics.php" class="nav-btn">Elektronik</a>
            <a href="home-living.php" class="nav-btn">Ev & Yaşam</a>
        </div>
    </nav>

    <!-- Register Card -->
    <div class="register-container">
        <div class="register-card">
            <h2 class="register-title">Kayıt Ol</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo htmlspecialchars($error); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" required 
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                           placeholder="Email adresinizi girin">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Kullanıcı Adı</label>
                    <input type="text" name="username" class="form-input" required 
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" 
                           placeholder="Kullanıcı adınızı girin">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Parola</label>
                    <input type="password" name="password" class="form-input" required 
                           placeholder="Parolanızı girin">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Parola Tekrar</label>
                    <input type="password" name="password_confirm" class="form-input" required 
                           placeholder="Parolanızı tekrar girin">
                </div>
                
                <button type="submit" class="register-btn">Kayıt Ol</button>
                
                <div class="login-text">Zaten hesabın var mı?</div>
                
                <a href="login.php" class="login-link">Giriş Yap</a>
            </form>
        </div>
    </div>
</body>
</html>
