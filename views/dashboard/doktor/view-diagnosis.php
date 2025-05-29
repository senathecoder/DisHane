<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.diagnosis-card {
    max-width: 820px;
    margin: 32px auto 36px auto;
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 8px 36px 0 rgba(176, 42, 55, 0.09);
    padding: 2.1rem 2.2rem 1.7rem 2.2rem;
    position: relative;
}
.diagnosis-card h2 {
    color: #b02a37;
    font-weight: 700;
    letter-spacing: .41px;
    margin-bottom: 1.08rem;
    text-align: center;
}
.diagnosis-card .alert-info {
    background: #fde4e7;
    color: #b02a37;
    border: none;
    border-radius: 12px;
    font-size: 1.03rem;
    text-align: center;
}
.diagnosis-card .table th {
    background: #f8e9ec;
    color: #b02a37;
    font-weight: 700;
    border-bottom: 2.2px solid #e0bfc2 !important;
    font-size: 1.05rem;
    letter-spacing: .16px;
}
.diagnosis-card .table td {
    background: #fff9fa;
    color: #713339;
    font-size: 0.99rem;
    vertical-align: middle;
}
.diagnosis-card .btn-outline-warning {
    color: #b68a11 !important;
    border-color: #ffe173 !important;
    font-weight: 600;
    border-radius: 9px;
    background: #fff;
}
.diagnosis-card .btn-outline-warning:hover {
    background: #fff5d2 !important;
    color: #a48915 !important;
}
.diagnosis-card .btn-outline-danger {
    color: #b02a37 !important;
    border-color: #b02a37 !important;
    font-weight: 600;
    border-radius: 9px;
    background: #fff;
}
.diagnosis-card .btn-outline-danger:hover {
    background: #fae2e7 !important;
    color: #871823 !important;
    border-color: #b02a37 !important;
}
.diagnosis-card .geri-btn-kapsayici {
    margin-bottom: 0.7rem;
    margin-top: -0.2rem;
}
.diagnosis-card .geri-btn-mini {
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
.diagnosis-card .geri-btn-mini:hover, .diagnosis-card .geri-btn-mini:focus {
    background: #f8cad3;
    color: #871823;
    outline: none;
}
.diagnosis-card .geri-btn-mini .geri-ikon {
    font-size: 1.08em;
    vertical-align: middle;
    margin-right: 4px;
    margin-left: 1px;
}
@media (max-width: 800px) {
    .diagnosis-card { padding: 9px 3px; }
}
</style>

<div class="diagnosis-card">
    <div class="geri-btn-kapsayici">
        <a href="index.php?page=searchMedicalRecordsDoctor" class="geri-btn-mini">
            <span class="geri-ikon">&#8592;</span> Tıbbi Kayıtlara Dön
        </a>
    </div>
    <h2 class="mb-4">Tanı Geçmişi</h2>
    <?php if (empty($diagnoses)): ?>
        <div class="alert alert-info">Bu kayda ait tanı yok.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanı</th>
                        <th>Doktor</th>
                        <th>Tarih</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($diagnoses as $diag): ?>
                        <tr>
                            <td><?= htmlspecialchars($diag['diagnosis'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($diag['doctor_id'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($diag['diagnosis_date'] ?? '-') ?></td>
                            <td>
                                <a href="index.php?page=editDiagnosis&diagnosis_id=<?= $diag['id'] ?>&test_id=<?= $diag['test_id'] ?>" class="btn btn-outline-warning btn-sm">Düzenle</a>
                                <a href="index.php?page=deleteDiagnosis&diagnosis_id=<?= $diag['id'] ?>&test_id=<?= $diag['test_id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Silmek istediğinize emin misiniz?')">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
