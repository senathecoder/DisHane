<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background: #fff9fa !important;
    }
    .register-card {
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 8px 40px 0 rgba(176, 42, 55, 0.12);
        padding: 2.4rem 2.2rem;
        min-width: 420px;
        max-width: 470px;
    }
    .register-title {
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
        border-color: #b02a37;
        box-shadow: 0 0 0 2px #b02a3722;
    }
    .btn-register {
        background: #b02a37;
        color: #fff;
        border-radius: 16px;
        padding: .8rem 1.2rem;
        font-weight: 500;
        letter-spacing: .5px;
        margin-top: 1rem;
        width: 100%;
        transition: box-shadow .2s;
        box-shadow: 0 2px 8px 0 rgba(176, 42, 55, 0.09);
    }
    .btn-register:hover, .btn-register:focus {
        background: #8e1c27;
        color: #fff;
        box-shadow: 0 8px 18px 0 rgba(176, 42, 55, 0.16);
    }
    .text-link {
        color: #b02a37;
        font-size: 0.95rem;
        display: inline-block;
        margin-top: 1rem;
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="register-card">
        <div class="register-title">
            <i class="bi bi-person-plus" style="font-size:1.7rem;vertical-align:middle;margin-right:.6rem;"></i>
            Kayıt Ol
        </div>
        <form method="POST" action="index.php?page=handleRegister">
            <div class="mb-3">
                <label for="full_name" class="form-label">Ad Soyad</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="tc_no" class="form-label">TC Kimlik No</label>
                <input type="text" class="form-control" id="tc_no" name="tc_no" maxlength="11" required autocomplete="off" inputmode="numeric" pattern="[0-9]*">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-posta</label>
                <input type="email" class="form-control" id="email" name="email" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Telefon</label>
                <input type="text" class="form-control" id="phone" name="phone" maxlength="11" required autocomplete="off" inputmode="numeric" pattern="[0-9]*">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <!-- role alanı gizli şekilde hasta olarak gönderilecek -->
            <input type="hidden" name="role" value="hasta">
            <button type="submit" class="btn btn-register">Kayıt Ol</button>
            <a href="index.php?page=login" class="text-link d-block text-center mt-3">Zaten bir hesabın var mı? Giriş yap</a>
        </form>
    </div>
</div>
<script>
function onlyNumbers(id, max) {
    const el = document.getElementById(id);
    if (el) {
        el.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, max);
        });
    }
}
// TC ve telefon için sayı filtresi
onlyNumbers('tc_no', 11);
onlyNumbers('phone', 11);
</script>
