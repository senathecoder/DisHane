<style>
.login-card {
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 8px 40px 0 rgba(176, 42, 55, 0.12);
    padding: 2.4rem 2.2rem;
    max-width: 400px;
    width: 100%;
}

.login-title {
    color: #b02a37;
    font-weight: bold;
    font-size: 1.7rem;
    letter-spacing: 1px;
    margin-bottom: 1rem;
}
.login-btn {
    background-color: #b02a37;
    color: white;
    font-weight: bold;
    border-radius: 16px;
    padding: 10px 16px;
    border: none;
    transition: all 0.3s ease-in-out;
    font-size: 1.08rem;
}
.login-btn:hover {
    background-color: #961e2b;
    color: #fff;
}
</style>
<?php if (session_status() === PHP_SESSION_NONE) session_start();
$tc = $_GET['tc'] ?? $_POST['tc'] ?? '';
if (!$tc) {
    header("Location: index.php?page=login");
    exit;
}
?>
<div class="d-flex justify-content-center align-items-center min-vh-100" style="background: #fff9fa;">
    <div class="login-card">
        <div class="text-center mb-3">
            <i class="bi bi-shield-lock-fill" style="color:#b02a37; font-size:2.1rem"></i>
            <div class="login-title">Yeni Şifre Belirle</div>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger py-2"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success py-2"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=handleResetPassword" autocomplete="off">
            <input type="hidden" name="tc" value="<?= htmlspecialchars($tc) ?>">

            <div class="mb-3">
                <label class="form-label" for="password" style="font-weight: 600; color: #b02a37;">Yeni Şifre</label>
                <input type="password" name="password" id="password" required minlength="6"
                       class="form-control" placeholder="Yeni şifre">
            </div>

            <div class="mb-3">
                <label class="form-label" for="confirm_password" style="font-weight: 600; color: #b02a37;">Şifre Tekrar</label>
                <input type="password" name="confirm_password" id="confirm_password" required minlength="6"
                       class="form-control" placeholder="Yeni şifre tekrar">
            </div>

            <button type="submit" class="btn login-btn w-100 mb-1">Şifreyi Güncelle</button>
        </form>

        <div class="mt-3 text-center">
            <a href="index.php?page=login" style="color: #b02a37; text-decoration: underline; font-weight: 500;">
                <i class="bi bi-arrow-left"></i> Giriş Ekranına Dön
            </a>
        </div>
    </div>
</div>
