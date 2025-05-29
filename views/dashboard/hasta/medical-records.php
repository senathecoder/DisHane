<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #fafbff;
}
.records-container {
    max-width: 950px;
    margin: 36px auto 0 auto;
    padding: 0 1.2rem 3rem 1.2rem;
}
.records-card {
    border-radius: 24px;
    background: #fff;
    box-shadow: 0 8px 40px 0 rgba(176, 42, 55, 0.12);
    padding: 2.2rem 2.6rem;
    margin-top: 16px;
}
.records-title {
    color: #b02a37;
    font-weight: bold;
    font-size: 1.62rem;
    letter-spacing: .8px;
    text-align: left;
    margin-bottom: 1.6rem;
    display: flex;
    align-items: center;
    gap: .55rem;
}
.geri-btn-kapsayici {
    margin-top: 1.2rem;
    margin-bottom: .7rem;
}
.geri-btn-mini {
    display: inline-flex;
    align-items: center;
    gap: .38em;
    background: #fae2e7;
    color: #b02a37;
    font-weight: 600;
    font-size: 1.08rem;
    border: none;
    border-radius: 16px;
    padding: 5px 15px 5px 12px;
    text-decoration: none;
    box-shadow: 0 1px 5px 0 rgba(176,42,55,0.02);
    transition: background .15s, color .13s;
    height: 34px;
    min-width: 61px;
    cursor: pointer;
}
.geri-btn-mini:hover, .geri-btn-mini:focus {
    background: #f8cad3;
    color: #871823;
    outline: none;
}
.geri-btn-mini .geri-ikon {
    font-size: 1.14em;
    line-height: 1;
    vertical-align: middle;
    margin-right: 4px;
    margin-left: 1px;
}
.table {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 32px 0 rgba(176,42,55,0.07);
    margin-bottom: 2rem;
}
.table thead th {
    background: #f8e9ec;
    color: #b02a37;
    font-weight: 700;
    border-bottom: 2px solid #e0bfc2 !important;
    font-size: 1.08rem;
    letter-spacing: .2px;
}
.table tbody tr {
    border-bottom: 1px solid #f0d7d9;
}
.table tbody tr:last-child {
    border-bottom: none;
}
.table tbody tr:hover {
    background: #fff2f5 !important;
}
.btn-outline-primary.btn-sm {
    border-radius: 9px;
    border-width: 1.3px;
    color: #b02a37;
    border-color: #e0bfc2;
    font-weight: 600;
    background: #fff;
    transition: background .15s, color .13s, border-color .13s;
    padding: .3em 1em;
}
.btn-outline-primary.btn-sm:hover, .btn-outline-primary.btn-sm:focus {
    background: #b02a37;
    color: #fff;
    border-color: #b02a37;
    outline: none;
}
.alert-info {
    background: #f7eafd;
    color: #9a4e8e;
    border: none;
    border-radius: 13px;
    font-size: 1.06rem;
    font-weight: 500;
    box-shadow: 0 1px 6px 0 rgba(176,42,55,0.04);
    margin-top: 1.7rem;
    margin-bottom: 1.4rem;
}
@media (max-width: 900px) {
    .records-card { padding: 1.4rem .4rem; }
    .records-container { padding: 0 .3rem 1.8rem .3rem; }
}
</style>

<div class="records-container">

  <!-- Geri tuşu -->
  <div class="geri-btn-kapsayici">
    <a href="index.php?page=dashboard" class="geri-btn-mini">
        <span class="geri-ikon">&#8592;</span> Geri
    </a>

  </div>

  <div class="records-card">
    <div class="records-title">
        <i class="bi bi-journal-medical" style="font-size:1.5rem;vertical-align:middle;margin-right:.5rem;"></i>
        Tıbbi Kayıtlarım
    </div>
    
    <?php if (empty($records)): ?>
        <div class="alert alert-info">Henüz tıbbi kaydınız yok.</div>
    <?php else: ?>
        <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Test Türü</th>
                    <th>Sonuç</th>
                    <th>Tanı Geçmişi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($records as $rec): ?>
                <tr>
                    <td><?= htmlspecialchars($rec['record_date']) ?></td>
                    <td><?= htmlspecialchars($rec['test_type']) ?></td>
                    <td><?= htmlspecialchars($rec['result']) ?></td>
                    <td>
                        <a href="index.php?page=viewDiagnosisPatient&test_id=<?= $rec['id'] ?>" class="btn btn-outline-primary btn-sm">Tanı Geçmişi</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    <?php endif; ?>
  </div>
</div>
