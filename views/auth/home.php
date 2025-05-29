<?php

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit;
}

echo "Hoşgeldin, " . htmlspecialchars($_SESSION['user_name']);
echo '<br><a href="/logout">Çıkış Yap</a>';


// session_start() yalnızca bir kez olmalı
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Eğer kullanıcı giriş yapmamışsa login sayfasına yönlendir
if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login.php");
    exit();
}

// Kullanıcı bilgilerini al
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Misafir';  // Eğer session boşsa 'Misafir' göster
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Bilinmiyor';  // Eğer session boşsa 'Bilinmiyor' göster
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ana Sayfa</title>
</head>
<body>
    <h2>Hoşgeldiniz, <?php echo htmlspecialchars($username); ?>!</h2>
    <p>Rolünüz: <?php echo htmlspecialchars($role); ?></p>
    <a href="/public/logout.php">Çıkış Yap</a>
</body>
</html>

