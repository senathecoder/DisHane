<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<div class="d-flex justify-content-center align-items-center min-vh-100" style="background: #fff9fa;">
    <div class="login-card">
        <div class="text-center mb-3">
            <i class="bi bi-key-fill" style="color:#b02a37; font-size:2.1rem"></i>
            <div class="login-title">Şifre Sıfırlama</div>
        </div>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger py-2"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success py-2"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <form method="POST" action="index.php?page=handleForgotPassword" autocomplete="off">
            <div class="mb-3">
                <label class="form-label" for="tc_no">TC Kimlik No</label>
                <input type="text" name="tc_no" id="tc_no" class="form-control" maxlength="11" required
                       placeholder="11 haneli" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,11);">
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">E-posta</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="E-posta adresiniz">
            </div>
            <button type="submit" class="btn login-btn w-100 mb-1">Şifre Sıfırla</button>
        </form>
        <div class="mt-3 text-center">
            <a href="index.php?page=login" style="color: #b02a37;"><i class="bi bi-arrow-left"></i> Girişe Dön</a>
        </div>
    </div>
</div>
