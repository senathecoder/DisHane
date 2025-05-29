<!-- Bootstrap + Tom Select CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />

<!-- Geri Butonu Yukarıda Kalacak -->
<div style="max-width: 600px; margin: 28px auto -14px auto;">
  <a href="index.php?page=dashboard" class="geri-btn-mini">
    <span class="geri-ikon">&#8592;</span> Geri
  </a>
</div>

<div class="container my-3" style="max-width: 600px;">
    <div class="card shadow-sm p-4" style="border-radius: 20px;">
        <!-- Bordo başlık -->
        <h5 class="mb-4 fw-bold d-flex align-items-center" style="color: #b02a37; font-size: 1.21rem; letter-spacing: .1px;">
            <i class="bi bi-clipboard2-pulse me-2" style="color: #b02a37;"></i>
            Günlük Malzeme Kullanım Özeti
        </h5>
        <!-- Tarih & Göster Buton grubu -->
        <form id="usage-form" class="d-flex gap-2 align-items-center mb-3 flex-wrap">
            <input type="date" id="usage-date" name="date" class="form-control" style="max-width: 180px; border-radius: 13px; border-color: #e0bfc2; font-size: 1.08rem;"
                value="<?= htmlspecialchars($date ?? date('Y-m-d')) ?>">
            <button class="btn btn-goster" type="submit">
                <i class="bi bi-search"></i> Göster
            </button>
        </form>
        <div id="usage-table-container">
            <?php include BASE_PATH . '/views/dashboard/sekreter/daily-usage-table.php'; ?>
        </div>
    </div>
</div>

<!-- Stil -->
<style>
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
/* Göster Butonu */
.btn-goster {
    background: #b02a37;
    color: #fff;
    border-radius: 11px;
    font-weight: 600;
    padding: .38em 1.36em;
    font-size: 1.06rem;
    border: none;
    transition: background .13s, box-shadow .13s;
    box-shadow: 0 1px 6px 0 rgba(176,42,55, 0.08);
    display: flex;
    align-items: center;
    gap: 0.46em;
}
.btn-goster:hover, .btn-goster:focus {
    background: #871823;
    color: #fff;
    box-shadow: 0 4px 12px 0 rgba(176,42,55, 0.13);
    outline: none;
}
</style>

<script>
document.getElementById('usage-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const selectedDate = document.getElementById('usage-date').value;
    fetch(`index.php?page=daily-usage-ajax&date=${selectedDate}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('usage-table-container').innerHTML = html;
        });
});
</script>
