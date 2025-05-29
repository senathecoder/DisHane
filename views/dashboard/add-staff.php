<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit;
}
?>

<h2>Personel Kaydı</h2>

<form method="POST" action="index.php?page=handleStaffRegister">
    <div class="mb-3">
        <label for="full_name" class="form-label">Ad Soyad</label>
        <input type="text" name="full_name" id="full_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="tc_no" class="form-label">TC Kimlik No</label>
        <input type="text" name="tc_no" id="tc_no" class="form-control" maxlength="11" required
               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">E-posta</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Telefon</label>
        <input type="text" name="phone" id="phone" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Şifre</label>
        <input type="password" name="password" id="password" class="form-control" required minlength="4">
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Rol Seçiniz</label>
        <select name="role" id="role" class="form-select" required>
            <option value="">Seçiniz</option>
            <option value="doktor">Doktor</option>
            <option value="sekreter">Sekreter</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Personel Ekle</button>
</form>
