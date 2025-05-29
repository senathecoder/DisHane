<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background: #fff9fa !important;
    }
    .login-card {
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 8px 40px 0 rgba(176, 42, 55, 0.12);
        padding: 2.4rem 2.2rem;
        min-width: 440px;
        max-width: 500px;
    }
    .login-title {
        color: #b02a37;
        font-weight: bold;
        font-size: 1.7rem;
        letter-spacing: 1px;
        text-align: center;
        margin-bottom: 1.7rem;
    }
    .form-label {
        color: #b02a37;
        font-weight: 500;
        margin-bottom: .35rem;
    }
    .form-control {
        border-radius: 16px;
        border: 1px solid #e7c4c7;
        min-height: 42px;
    }
    .form-control:focus {
        border-color: #b02a37 !important;
        box-shadow: 0 0 0 2px #b02a3722 !important;
        outline: none !important;
    }
    .btn-login {
        background: #b02a37;
        color: #fff;
        border-radius: 16px;
        padding: .8rem 1.2rem;
        font-weight: 600;
        letter-spacing: .5px;
        margin-top: 1rem;
        width: 100%;
        border: none;
        transition: box-shadow .2s, background .2s;
        box-shadow: 0 4px 16px 0 rgba(176, 42, 55, 0.16);
    }
    .btn-login:hover, .btn-login:focus {
        background: #a12831;
        color: #fff;
        box-shadow: 0 8px 24px 0 rgba(176, 42, 55, 0.22);
        outline: none;
    }
    .text-link {
        color: #b02a37;
        font-size: 0.95rem;
        display: inline-block;
        margin-top: 1rem;
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="login-card">
        <div class="login-title">
            <i class="bi bi-person-circle" style="font-size:1.7rem;vertical-align:middle;margin-right:.6rem;"></i>
            Giriş Yap
        </div>
        <form method="POST" action="index.php?page=handleLogin">
            <div class="mb-3">
                <label for="tc" class="form-label">TC Kimlik No</label>
                <input type="text" class="form-control" id="tc" name="tc_no" maxlength="11" required autocomplete="off" inputmode="numeric" pattern="[0-9]*">
            </div>

            <script>
            document.getElementById('tc').addEventListener('input', function (e) {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
            });
            </script>

            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class=" btn-login">Giriş Yap</button>
            <a href="index.php?page=register" class="text-link d-block text-center mt-3">Hesabın yok mu? Kayıt ol</a>
        </form>
    </div>
</div>
