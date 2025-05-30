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
<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<div class="d-flex justify-content-center align-items-center min-vh-100" style="background: #fff9fa;">
    <div class="login-card">
        <div class="text-center mb-3">
            <i class="bi bi-key-fill" style="color:#b02a37; font-size:2.1rem"></i>
            <div class="login-title">Şifremi Unuttum</div>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger py-2"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=handleForgotPassword" autocomplete="off">
            <div class="mb-3">
                <label class="form-label" for="tc_no" style="font-weight: 600; color: #b02a37;">TC Kimlik No</label>
                <input type="text" name="tc_no" id="tc_no" class="form-control" maxlength="11" required
                       placeholder="11 haneli" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11);">
            </div>
            <button type="submit" class="btn login-btn w-100 mb-1">Devam Et</button>
        </form>

        <div class="mt-3 text-center">
            <a href="index.php?page=login" style="color: #b02a37; text-decoration: underline; font-weight: 500;">
                <i class="bi bi-arrow-left"></i> Giriş Ekranına Dön
            </a>
        </div>
    </div>
</div>
