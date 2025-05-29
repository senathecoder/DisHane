<?php
// Güvenlik: sadece admin erişsin
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?page=login");
    exit;
}
?>

<div class="container py-4" style="max-width: 1100px;">
    <div class="card border-0 shadow-sm mb-4" style="background: #fcf9f9; border-radius: 20px;">
        <div class="card-body pb-2">
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2" style="background:#f7d6dc; border-radius:16px; padding: 10px 18px;">
                <div class="d-flex align-items-center gap-2">
                    <a href="index.php?page=dashboard"
                    class="btn btn-sm fw-semibold rounded-pill px-3 py-2"
                    style="background:#fff; color:#b02a37; border:none; font-size:.99rem;">
                        <i class="bi bi-arrow-left-short" style="font-size:1.25rem;"></i> Geri
                    </a>
                    <span class="fw-bold" style="font-size:1.34rem; color:#b02a37;">
                        <i class="bi bi-people-fill me-2"></i> Personel İşlemleri
                    </span>
                </div>
                <button class="btn btn-sm fw-semibold px-3 py-2 rounded-pill" id="addPersonnelBtn"
                        style="background: #fff; color: #b02a37; border: none; font-size:.99rem;">
                    <i class="bi bi-person-plus-fill me-1"></i> Personel Ekle
                </button>
            </div>


            <!-- Ekleme formu (gizli, butona basınca açılacak) -->
            <form id="addPersonnelForm" method="post" action="index.php?page=personelAdd"
                    class="row g-2 align-items-end mb-4" style="display:none;">
                <div class="col-md-2">
                    <label class="form-label mb-1" style="color:#b02a37;">Ad Soyad</label>
                    <input type="text" name="full_name" required class="form-control form-control-sm rounded-3 shadow-sm">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1" style="color:#b02a37;">TC Kimlik No</label>
                    <input type="text" name="tc_no" required pattern="^\d{11}$" maxlength="11"
                        class="form-control form-control-sm rounded-3 shadow-sm"
                        placeholder="11 haneli"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1" style="color:#b02a37;">Telefon</label>
                    <input type="tel" name="phone" required pattern="^0\d{10}$" maxlength="11"
                        class="form-control form-control-sm rounded-3 shadow-sm"
                        placeholder="05xxxxxxxxx"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1" style="color:#b02a37;">Email</label>
                    <input type="email" name="email" required class="form-control form-control-sm rounded-3 shadow-sm">
                </div>
                <div class="col-md-1">
                    <label class="form-label mb-1" style="color:#b02a37;">Rol</label>
                    <select name="role" class="form-select form-select-sm rounded-3 shadow-sm" required>
                        <option value="doktor">Doktor</option>
                        <option value="sekreter">Sekreter</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label mb-1" style="color:#b02a37;">Şifre</label>
                    <input type="password" name="password" required minlength="6"
                        class="form-control form-control-sm rounded-3 shadow-sm">
                </div>
                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn btn-sm fw-semibold rounded-pill"
                            style="background:#b02a37; color:#fff; border:none;">Ekle</button>
                </div>
            </form>


            <!-- Personel Listesi -->
            <div class="table-responsive">
                <table class="table align-middle text-center table-sm mb-0" style="background:#fff; border-radius: 12px;">
                    <thead style="background:#f7d6dc;">
                        <tr>
                            <th style="color:#b02a37;">Ad Soyad</th>
                            <th style="color:#b02a37;">TC</th>
                            <th style="color:#b02a37;">Telefon</th>
                            <th style="color:#b02a37;">E-mail</th>
                            <th style="color:#b02a37;">Rol</th>
                            <th style="color:#b02a37;">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($personelList)): ?>
                        <?php foreach($personelList as $personel): ?>
                            <tr>
                                <td><?= htmlspecialchars($personel['full_name']) ?></td>
                                <td><?= htmlspecialchars($personel['tc_no']) ?></td>
                                <td><?= htmlspecialchars($personel['phone']) ?></td>
                                <td><?= htmlspecialchars($personel['email']) ?></td>
                                <td>
                                    <span class="badge rounded-pill" style="background:<?= $personel['role'] === 'doktor' ? '#d6e7f7' : '#f7e6d6'; ?>; color:#b02a37;">
                                        <?= ucfirst($personel['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <!-- Sil Butonu -->
                                    <form method="post" action="index.php?page=personelDelete" class="d-inline" 
                                          onsubmit="return confirm('Bu personeli silmek istediğinizden emin misiniz?');">
                                        <input type="hidden" name="user_id" value="<?= $personel['id'] ?>">
                                        <button type="submit" class="btn btn-sm px-3 rounded-pill"
                                            style="background:#fff2f2; color:#b02a37; border:1.2px solid #eecad6;">
                                            <i class="bi bi-trash-fill"></i> Sil
                                        </button>
                                    </form>
                                    <!-- Düzenle Butonu -->
                                    <a href="index.php?page=personelEdit&id=<?= $personel['id'] ?>"
                                       class="btn btn-sm px-3 ms-1 rounded-pill"
                                       style="background:#f7d6dc; color:#b02a37; border:1.2px solid #eecad6;">
                                        <i class="bi bi-pencil-fill"></i> Düzenle
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-muted py-3">Personel bulunamadı.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
// Form aç/kapa
document.getElementById('addPersonnelBtn').onclick = function() {
    var f = document.getElementById('addPersonnelForm');
    f.style.display = (f.style.display === "none" || f.style.display === "") ? "flex" : "none";
};
</script>

<style>
.btn-light:hover, .btn-light:focus {
    background: #f7d6dc !important;
    color: #b02a37 !important;
    box-shadow: 0 3px 14px #efbfcf20;
}
</style>

