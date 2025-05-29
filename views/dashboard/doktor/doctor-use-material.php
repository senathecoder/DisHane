<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.material-card {
    max-width: 670px;
    margin: 38px auto 36px auto;
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 8px 36px 0 rgba(176, 42, 55, 0.11);
    padding: 2.3rem 2.2rem 1.7rem 2.2rem;
    position: relative;
}
.material-card h2 {
    color: #b02a37;
    font-weight: 700;
    letter-spacing: .4px;
    margin-bottom: 1.15rem;
    text-align: center;
}
.material-card .form-label {
    color: #b02a37;
    font-weight: 600;
    margin-bottom: .28rem;
}
.material-card .form-select,
.material-card .form-control {
    border-radius: 12px;
    border: 1.1px solid #e0bfc2;
    min-height: 40px;
    font-size: 1.07rem;
    background: #fff;
}
.material-card .form-select:focus,
.material-card .form-control:focus {
    border-color: #b02a37;
    box-shadow: 0 0 0 2px #b02a3712;
    outline: none;
}
.material-card .btn-primary,
.material-card .btn-primary:visited {
    background: #b02a37 !important;
    color: #fff !important;
    border: none;
    border-radius: 11px;
    font-weight: 600;
    padding: .52em 1.35em;
    font-size: 1.06rem;
    box-shadow: 0 1px 7px 0 rgba(176,42,55, 0.07);
    transition: background .14s, box-shadow .13s;
}
.material-card .btn-primary:hover,
.material-card .btn-primary:focus {
    background: #871823 !important;
    color: #fff !important;
    box-shadow: 0 4px 14px 0 rgba(176,42,55, 0.10);
}
.material-card .alert-success {
    border-radius: 13px;
    font-size: 1.02rem;
    background: #f1fce7;
    color: #339a4c;
    border: none;
    margin-bottom: 1.18rem;
    text-align: center;
}
.material-card .alert-danger {
    border-radius: 13px;
    font-size: 1.02rem;
    background: #ffe7ed;
    color: #b02a37;
    border: none;
    margin-bottom: 1.18rem;
    text-align: center;
}
.material-card .alert-info {
    background: #fde4e7;
    color: #b02a37;
    border: none;
    border-radius: 12px;
    font-size: 1.02rem;
    text-align: center;
}
.material-card hr {
    margin: 1.3rem 0 .8rem 0;
    border-top: 1.5px solid #f0d7d9;
}
.material-card table th {
    background: #f8e9ec;
    color: #b02a37;
    font-weight: 700;
    border-bottom: 2.2px solid #e0bfc2 !important;
    font-size: 1.03rem;
    letter-spacing: .2px;
}
.material-card table td {
    background: #fff9fa;
    color: #713339;
    font-size: 0.98rem;
    vertical-align: middle;
}
.material-card h5 {
    color: #b02a37;
    margin-top: 1.1rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.geri-btn-kapsayici {
    margin-bottom: 0.6rem;
    margin-top: -0.3rem;
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
</style>

<div class="material-card">
    <div class="geri-btn-kapsayici">
        <a href="index.php?page=doctorAppointments" class="geri-btn-mini">
            <span class="geri-ikon">&#8592;</span> Geri
        </a>
    </div>
    <h2 class="mb-4">Malzeme Kullanımı</h2>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success">Kayıt başarıyla oluşturuldu!</div>
    <?php elseif (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Malzeme Kullanımı Formu -->
    <form method="POST" action="index.php?page=doctor-use-material" class="row g-3 align-items-end mb-4">
        <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($appointment_id) ?>">
        <div class="col-md-4">
            <label class="form-label">Malzeme Seç</label>
            <select name="item_id" class="form-select" required>
                <?php foreach ($materials as $item): ?>
                    <option value="<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Kullanılan Adet</label>
            <input type="number" name="quantity" class="form-control" min="1" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Açıklama</label>
            <input type="text" name="reason" class="form-control" placeholder="İsteğe bağlı">
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </div>
    </form>

    <hr>
    <h5>Bu randevunun malzeme kullanımı:</h5>
    <?php if (!empty($usage_logs)): ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Malzeme</th>
                        <th>Kullanılan Adet</th>
                        <th>Açıklama</th>
                        <th>Tarih</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usage_logs as $log): ?>
                        <tr>
                            <td><?= htmlspecialchars($log['name']) ?></td>
                            <td><?= abs($log['used_quantity']) ?></td>
                            <td><?= htmlspecialchars($log['reason']) ?></td>
                            <td><?= htmlspecialchars($log['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Bu randevu için henüz malzeme kaydı yok.</div>
    <?php endif; ?>
</div>
