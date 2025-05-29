<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.edit-diagnosis-card {
    max-width: 510px;
    margin: 38px auto 36px auto;
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 8px 36px 0 rgba(176, 42, 55, 0.09);
    padding: 2.1rem 2.2rem 1.7rem 2.2rem;
}
.edit-diagnosis-card h2 {
    color: #b02a37;
    font-weight: 700;
    letter-spacing: .4px;
    margin-bottom: 1.25rem;
    text-align: center;
}
.edit-diagnosis-card .form-label {
    color: #b02a37;
    font-weight: 600;
    margin-bottom: .3rem;
}
.edit-diagnosis-card .form-control {
    border-radius: 14px;
    border: 1.1px solid #e0bfc2;
    font-size: 1.08rem;
    background: #fff;
}
.edit-diagnosis-card .form-control:focus {
    border-color: #b02a37;
    box-shadow: 0 0 0 2px #b02a3712;
    outline: none;
}
.edit-diagnosis-card .btn-success {
    background: #b02a37 !important;
    color: #fff !important;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    padding: .52em 1.38em;
    font-size: 1.07rem;
    margin-top: 6px;
    box-shadow: 0 1px 7px 0 rgba(176,42,55, 0.09);
    transition: background .14s, box-shadow .13s;
}
.edit-diagnosis-card .btn-success:hover,
.edit-diagnosis-card .btn-success:focus {
    background: #871823 !important;
    color: #fff !important;
    box-shadow: 0 4px 14px 0 rgba(176,42,55, 0.10);
}
.edit-diagnosis-card .btn-outline-secondary {
    color: #b02a37 !important;
    border-color: #b02a37 !important;
    border-radius: 12px;
    font-weight: 600;
    margin-left: 8px;
    transition: background .15s, color .13s;
}
.edit-diagnosis-card .btn-outline-secondary:hover {
    background: #fae2e7 !important;
    color: #871823 !important;
}
</style>

<div class="edit-diagnosis-card">
    <h2 class="mb-4">Tanıyı Düzenle</h2>
    <form method="post" action="index.php?page=editDiagnosis">
        <input type="hidden" name="diagnosis_id" value="<?= htmlspecialchars($diagnosis['id']) ?>">
        <input type="hidden" name="test_id" value="<?= htmlspecialchars($diagnosis['test_id']) ?>">
        <div class="mb-3">
            <label class="form-label fw-semibold">Tanı</label>
            <textarea class="form-control" name="diagnosis" required rows="3"><?= htmlspecialchars($diagnosis['diagnosis'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Kaydet</button>
        <a href="index.php?page=viewDiagnosis&test_id=<?= htmlspecialchars($diagnosis['test_id']) ?>" class="btn btn-outline-secondary ms-2">Tanı Geçmişine Dön</a>
    </form>
</div>
