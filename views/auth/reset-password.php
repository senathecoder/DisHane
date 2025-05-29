<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['reset_user_id'])) {
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
            <div class="alert alert-danger py-2"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <form method="POST" action="index.php?page=handleResetPassword" autocomplete="off">
            <div class="mb-3">
                <label class="form-label" for="password">Yeni Şifre</label>
                <input type="password" name="password" id="password" required minlength="6" class="form-control" placeholder="Yeni şifre">
            </div>
            <div class="mb-3">
                <label class="form-label" for="confirm_password">Şifre Tekrar</label>
                <input type="password" name="confirm_password" id="confirm_password" required minlength="6" class="form-control" placeholder="Yeni şifre tekrar">
            </div>
            <button type="submit" class="btn login-btn w-100 mb-1">Şifreyi Güncelle</button>
        </form>
        <div class="mt-3 text-center">
            <a href="index.php?page=login" style="color: #b02a37;"><i class="bi bi-arrow-left"></i> Girişe Dön</a>
        </div>
    </div>
</div>
