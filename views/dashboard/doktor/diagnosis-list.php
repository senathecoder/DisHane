<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.tani-history-card {
    max-width: 510px;
    margin: 38px auto 36px auto;
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 8px 36px 0 rgba(176, 42, 55, 0.09);
    padding: 2.1rem 2.2rem 1.7rem 2.2rem;
}
.tani-history-card h2 {
    color: #b02a37;
    font-weight: 700;
    letter-spacing: .4px;
    margin-bottom: 1.25rem;
    text-align: center;
}
.tani-history-card .alert-info {
    background: #f7eafd;
    color: #9a4e8e;
    border: none;
    border-radius: 13px;
    font-size: 1.03rem;
    font-weight: 500;
    margin-bottom: 1.2rem;
    text-align: center;
}
.tani-history-card .list-group-item {
    border-radius: 11px;
    background: #fbeaec;
    color: #b02a37;
    border: 1px solid #f4d3d9;
    margin-bottom: 9px;
    font-size: 1.09rem;
    font-weight: 500;
}
.tani-history-card .btn-outline-primary {
    color: #b02a37 !important;
    border-color: #b02a37 !important;
    border-radius: 12px;
    font-weight: 600;
    transition: background .13s, color .13s;
    padding: .49em 1.4em;
    font-size: 1.06rem;
}
.tani-history-card .btn-outline-primary:hover,
.tani-history-card .btn-outline-primary:focus {
    background: #fae2e7 !important;
    color: #871823 !important;
    outline: none;
}
</style>

<div class="tani-history-card">
    <h2 class="mb-4">Tanı Geçmişi</h2>
    <?php if (empty($diagnoses)): ?>
        <div class="alert alert-info">Bu tıbbi kayıt için henüz tanı eklenmemiş.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($diagnoses as $diag): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($diag['created_at']) ?>:</strong>
                    <?= htmlspecialchars($diag['diagnosis']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <div class="mt-3 text-center">
        <a href="index.php?page=medicalRecordsDoctor" class="btn btn-outline-primary">Tıbbi Kayıtlar'a Geri Dön</a>
    </div>
</div>
