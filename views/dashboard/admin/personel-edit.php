<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit;
}
?>

<div class="container py-4" style="max-width: 540px;">
    <div class="card border-0 shadow-sm" style="background: #fff9fa; border-radius: 20px;">
        <div class="card-body">
            <div class="fw-bold mb-3" style="color:#b02a37; font-size:1.24rem;">
                <i class="bi bi-pencil-fill me-2"></i>
                Personel Bilgilerini Düzenle
            </div>
            <form method="post" action="index.php?page=personelUpdate" class="row g-3">
                <input type="hidden" name="id" value="<?= htmlspecialchars($personel['id']) ?>">
                <div class="col-12">
                    <label class="form-label mb-1" style="color:#b02a37;">Ad Soyad</label>
                    <input type="text" name="full_name" value="<?= htmlspecialchars($personel['full_name']) ?>"
                        required class="form-control form-control-sm rounded-3 shadow-sm">
                </div>
                <div class="col-6">
                    <label class="form-label mb-1" style="color:#b02a37;">TC Kimlik No</label>
                    <input type="text" name="tc_no" value="<?= htmlspecialchars($personel['tc_no']) ?>"
                        required pattern="^\d{11}$" maxlength="11"
                        class="form-control form-control-sm rounded-3 shadow-sm">
                </div>
                <div class="col-6">
                    <label class="form-label mb-1" style="color:#b02a37;">Telefon</label>
                    <input type="tel" name="phone" value="<?= htmlspecialchars($personel['phone']) ?>"
                        required pattern="^0\d{10}$" maxlength="11"
                        class="form-control form-control-sm rounded-3 shadow-sm">
                </div>
                <div class="col-6">
                    <label class="form-label mb-1" style="color:#b02a37;">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($personel['email']) ?>"
                        required class="form-control form-control-sm rounded-3 shadow-sm">
                </div>
                <div class="col-6">
                    <label class="form-label mb-1" style="color:#b02a37;">Rol</label>
                    <select name="role" class="form-select form-select-sm rounded-3 shadow-sm" required>
                        <option value="doktor" <?= $personel['role'] === 'doktor' ? 'selected' : '' ?>>Doktor</option>
                        <option value="sekreter" <?= $personel['role'] === 'sekreter' ? 'selected' : '' ?>>Sekreter</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label mb-1" style="color:#b02a37;">Yeni Şifre (değiştirmek için doldurun)</label>
                    <input type="password" name="password" minlength="6"
                        class="form-control form-control-sm rounded-3 shadow-sm" placeholder="••••••">
                </div>
                <div class="col-12 d-flex justify-content-between mt-2">
                    <a href="index.php?page=personelList" class="btn btn-outline-secondary px-4 rounded-pill">
                        Vazgeç
                    </a>
                    <button type="submit" class="btn fw-semibold rounded-pill px-4"
                        style="background:#b02a37; color:#fff;">
                        Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
