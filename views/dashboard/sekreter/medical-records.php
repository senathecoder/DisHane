<!-- Tom Select CSS & Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />

<style>
.medical-form-card {
    max-width: 510px;
    margin: 38px auto 36px auto;
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 8px 36px 0 rgba(176, 42, 55, 0.12);
    padding: 2.1rem 2.2rem 1.7rem 2.2rem;
}
.medical-form-card h3 {
    color: #b02a37;
    font-weight: 700;
    letter-spacing: .4px;
    margin-bottom: 1.25rem;
    text-align: center;
}
.medical-form-card .form-label {
    color: #b02a37;
    font-weight: 600;
    margin-bottom: .33rem;
}
.medical-form-card .form-select,
.medical-form-card .form-control {
    border-radius: 14px;
    border: 1.1px solid #e0bfc2;
    min-height: 42px;
    font-size: 1.08rem;
    background: #fff;
}
.medical-form-card .form-select:focus,
.medical-form-card .form-control:focus {
    border-color: #b02a37;
    box-shadow: 0 0 0 2px #b02a3712;
    outline: none;
}
.medical-form-card .btn-success,
.medical-form-card .btn-success:visited {
    background: #b02a37 !important;
    color: #fff !important;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    padding: .53em 1.38em;
    font-size: 1.07rem;
    margin-top: 6px;
    box-shadow: 0 1px 7px 0 rgba(176,42,55, 0.09);
    transition: background .14s, box-shadow .13s;
}
.medical-form-card .btn-success:hover,
.medical-form-card .btn-success:focus {
    background: #871823 !important;
    color: #fff !important;
    box-shadow: 0 4px 14px 0 rgba(176,42,55, 0.10);
}
.medical-form-card .alert-success {
    border-radius: 13px;
    font-size: 1.03rem;
    background: #f1fce7;
    color: #339a4c;
    border: none;
    margin-bottom: 1.2rem;
    text-align: center;
}

.geri-btn-mini {
    display: inline-flex;
    align-items: center;
    gap: .4em;
    background: #fae2e7;
    color: #b02a37;
    font-weight: 600;
    font-size: 1.02rem;
    border: none;
    border-radius: 16px;
    padding: 5px 14px 5px 11px;
    text-decoration: none;
    box-shadow: 0 1px 5px 0 rgba(176,42,55,0.03);
    transition: background .15s, color .13s;
    height: 34px;
    min-width: 62px;
}
.geri-btn-mini:hover, .geri-btn-mini:focus {
    background: #f8cad3;
    color: #871823;
    outline: none;
}
.geri-btn-mini .geri-ikon {
    font-size: 1.06em;
    line-height: 1;
    vertical-align: middle;
    margin-right: 4px;
    margin-left: 1px;
}

</style>
<div style="max-width: 510px; margin: 32px auto -18px auto;">
  <a href="index.php?page=dashboard" class="geri-btn-mini">
    <span class="geri-ikon">&#8592;</span> Geri
  </a>
</div>
<div class="medical-form-card">
    <h3 class="mb-3">Yeni Tıbbi Kayıt Ekle</h3>
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=addMedicalRecord">
        <div class="mb-3">
            <label class="form-label fw-semibold">Hasta</label>
            <select class="form-select" name="patient_id" id="select-patient" required>
                <option value="">Seçiniz</option>
                <?php foreach ($patients as $p): ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['full_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Doktor</label>
            <select class="form-select" name="doctor_id" id="select-doctor" required>
                <option value="">Seçiniz</option>
                <?php foreach ($doctors as $d): ?>
                    <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['full_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Tahlil Türü</label>
            <input type="text" class="form-control" name="test_type" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Sonuç</label>
            <textarea class="form-control" name="result" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Kayıt Tarihi</label>
            <input type="date" class="form-control" name="record_date" value="<?= date('Y-m-d') ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Kaydı Ekle</button>
    </form>
</div>

<!-- Tom Select JS -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
new TomSelect("#select-patient", {
    create: false,
    sortField: { field: "text", direction: "asc" },
    placeholder: "Hasta ara..."
});
new TomSelect("#select-doctor", {
    create: false,
    sortField: { field: "text", direction: "asc" },
    placeholder: "Doktor ara..."
});
</script>
