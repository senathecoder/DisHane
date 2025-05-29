<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.records-card {
    max-width: 980px;
    margin: 36px auto 32px auto;
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 8px 36px 0 rgba(176, 42, 55, 0.10);
    padding: 2.1rem 2.2rem 1.7rem 2.2rem;
    position: relative;
}
.records-card h2 {
    color: #b02a37;
    font-weight: 700;
    letter-spacing: .44px;
    margin-bottom: 1.15rem;
    text-align: center;
}
.records-card .form-control,
.records-card .btn-primary {
    border-radius: 13px;
    font-size: 1.06rem;
}
.records-card .btn-primary,
.records-card .btn-primary:visited {
    background: #b02a37 !important;
    color: #fff !important;
    border: none;
    font-weight: 600;
    box-shadow: 0 1px 7px 0 rgba(176,42,55, 0.08);
    transition: background .14s, box-shadow .13s;
}
.records-card .btn-primary:hover,
.records-card .btn-primary:focus {
    background: #871823 !important;
    color: #fff !important;
}
.records-card .btn-success {
    background: #2bbf8b !important;
    border: none;
    font-weight: 600;
    border-radius: 8px;
    font-size: 1.03rem;
    padding: .32em 1.12em;
}
.records-card .btn-success:hover { background: #18986a !important; }
.records-card .btn-outline-primary {
    border-radius: 8px;
    font-size: 1.03rem;
    color: #b02a37 !important;
    border: 1.2px solid #b02a37 !important;
    background: #fff !important;
    font-weight: 600;
}
.records-card .btn-outline-primary:hover {
    background: #fae2e7 !important;
    color: #871823 !important;
    border-color: #b02a37 !important;
}
.records-card .alert-info {
    background: #fde4e7;
    color: #b02a37;
    border: none;
    border-radius: 12px;
    font-size: 1.02rem;
    text-align: center;
}
.records-card table th {
    background: #f8e9ec;
    color: #b02a37;
    font-weight: 700;
    border-bottom: 2.2px solid #e0bfc2 !important;
    font-size: 1.05rem;
    letter-spacing: .19px;
}
.records-card table td {
    background: #fff9fa;
    color: #713339;
    font-size: 0.99rem;
    vertical-align: middle;
}

/* Geri Butonu */
.geri-btn-kapsayici {
    margin-bottom: 0.7rem;
    margin-top: -0.4rem;
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
    font-size: 1.08em;
    vertical-align: middle;
    margin-right: 4px;
    margin-left: 1px;
}
@media (max-width: 800px) {
    .records-card { padding: 9px 3px; }
}
</style>

<div class="records-card">
    <div class="geri-btn-kapsayici">
        <a href="index.php?page=doctorAppointments" class="geri-btn-mini">
            <span class="geri-ikon">&#8592;</span> Geri
        </a>
    </div>
    <h2 class="mb-4">Tıbbi Kayıtlar (Arama)</h2>

    <form class="mb-2 row g-2" method="get" action="index.php">
        <input type="hidden" name="page" value="searchMedicalRecordsDoctor">
        <div class="col-md-6">
            <input type="text" name="search" class="form-control" placeholder="Hasta adı ile ara..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary" type="submit">Ara</button>
        </div>
    </form>

    <?php if (empty($records)): ?>
        <div class="alert alert-info">Kayıt bulunamadı.</div>
    <?php else: ?>
        <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Hasta Adı</th>
                    <th>Tarih</th>
                    <th>Test Sonucu</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $rec): ?>
                    <tr>
                        <td><?= htmlspecialchars($rec['patient_name'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($rec['record_date'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($rec['result'] ?? '-') ?></td>
                        <td>
                            <a href="index.php?page=addDiagnosis&test_id=<?= $rec['id'] ?>" class="btn btn-success btn-sm">Tanı Ekle</a>
                            <a href="index.php?page=viewDiagnosis&test_id=<?= $rec['id'] ?>" class="btn btn-outline-primary btn-sm">Tanı Geçmişi</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    <?php endif; ?>
</div>
