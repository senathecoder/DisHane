<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.tani-container {
    max-width: 750px;
    margin: 38px auto 0 auto;
    padding: 0 1.2rem 2.5rem 1.2rem;
}
.tani-card {
    border-radius: 22px;
    background: #fff;
    box-shadow: 0 8px 32px 0 rgba(176,42,55,0.09);
    padding: 2rem 2.2rem;
    margin-top: 14px;
}
.tani-title {
    color: #b02a37;
    font-weight: 700;
    font-size: 1.43rem;
    letter-spacing: .7px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: .52rem;
}
.geri-btn-kapsayici {
    margin-bottom: 0.8rem;
    margin-top: 1.2rem;
}
.geri-btn-mini {
    display: inline-flex;
    align-items: center;
    gap: .4em;
    background: #fae2e7;
    color: #b02a37;
    font-weight: 600;
    font-size: 1.07rem;
    border: none;
    border-radius: 15px;
    padding: 5px 15px 5px 12px;
    text-decoration: none;
    box-shadow: 0 1px 5px 0 rgba(176,42,55,0.02);
    transition: background .15s, color .13s;
    height: 33px;
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
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 20px 0 rgba(176,42,55,0.06);
    margin-bottom: 1.6rem;
}
.table thead th {
    background: #f8e9ec;
    color: #b02a37;
    font-weight: 700;
    border-bottom: 2px solid #e0bfc2 !important;
    font-size: 1.05rem;
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
.alert-info {
    background: #f7eafd;
    color: #9a4e8e;
    border: none;
    border-radius: 13px;
    font-size: 1.06rem;
    font-weight: 500;
    box-shadow: 0 1px 6px 0 rgba(176,42,55,0.04);
    margin-top: 1.2rem;
    margin-bottom: 1.2rem;
}
@media (max-width: 800px) {
    .tani-card { padding: 1.1rem .6rem; }
    .tani-container { padding: 0 .4rem 1.3rem .4rem; }
}
</style>

<div class="tani-container">

    <div class="geri-btn-kapsayici">
        <a href="index.php?page=medicalRecords" class="geri-btn-mini">
            <span class="geri-ikon">&#8592;</span> Geri
        </a>
    </div>

    <div class="tani-card">
        <div class="tani-title">
            <i class="bi bi-clipboard2-pulse" style="font-size:1.2rem;vertical-align:middle;margin-right:.5rem;"></i>
            Tanı Geçmişi
        </div>
        <?php if (empty($diagnoses)): ?>
            <div class="alert alert-info">Bu teste ait tanı bulunamadı.</div>
        <?php else: ?>
            <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Tanı</th>
                        <th>Doktor ID</th>
                        <th>Tarih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($diagnoses as $diag): ?>
                    <tr>
                        <td><?= htmlspecialchars($diag['diagnosis']) ?></td>
                        <td><?= htmlspecialchars($diag['doctor_id']) ?></td>
                        <td><?= htmlspecialchars($diag['diagnosis_date']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        <?php endif; ?>
    </div>
</div>
