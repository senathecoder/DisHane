<style>
/* -- STOK YÖNETİMİ GÖRSEL DÜZEN -- */
h2.text-primary, .card-header.fw-bold {
    color: #b02a37 !important;
}
.card-header.fw-bold {
    background: #fbeaec;
    border-bottom: 1.2px solid #e6b5bf;
    font-size: 1.1rem;
    letter-spacing: .03em;
}
h2.text-primary {
    font-weight: 700;
    letter-spacing: .6px;
    margin-bottom: 1.3rem !important;
}
.alert-danger {
    background: #ffe8ee;
    color: #b02a37;
    border: none;
    border-radius: 14px;
    font-size: 1.02rem;
    font-weight: 500;
    box-shadow: 0 1px 6px 0 rgba(176,42,55,0.04);
}
.btn-success, .btn-success:visited {
    background: #b02a37 !important;
    color: #fff !important;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    box-shadow: 0 1px 7px 0 rgba(176,42,55, 0.09);
    transition: background .14s, box-shadow .13s;
}
.btn-success:hover, .btn-success:focus {
    background: #871823 !important;
    color: #fff !important;
    box-shadow: 0 4px 14px 0 rgba(176,42,55, 0.10);
}
/* Card düzenleri */
.card {
    border-radius: 19px !important;
    box-shadow: 0 6px 38px 0 rgba(176, 42, 55, 0.11) !important;
    border: none !important;
}
.table > thead > tr > th {
    background: #f8e9ec !important;
    color: #b02a37 !important;
    border-bottom: 2.2px solid #e0bfc2 !important;
    font-weight: 700;
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background: #fff7fa !important;
}
.table-striped > tbody > tr:nth-of-type(even) {
    background: #fff !important;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container mt-5">
    <!-- Geri tuşu-->
<div class="geri-btn-kapsayici">
  <a href="index.php?page=dashboard" class="geri-btn-mini">
    <span class="geri-ikon">&#8592;</span> Geri
  </a>
</div>

<style>
.geri-btn-kapsayici {
    margin-top: 0.2rem !important;  /* Çok daha yakınlaştırıldı */
    margin-bottom: 0.7rem;
    /* Sayfanın ortasında, başlığa yapışık durması için genişlik ayarı kaldırıldı */
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
    line-height: 1;
    vertical-align: middle;
    margin-right: 4px;
    margin-left: 1px;
}
</style>

    <h2 class="mb-4 text-primary">Stok Malzeme Yönetimi</h2>

    <?php if (!empty($lowStockItems)): ?>
    <div class="alert alert-danger">
        <strong>⚠ Kritik Stok Uyarısı:</strong>
        <ul class="mb-0">
            <?php foreach ($lowStockItems as $item): ?>
                <li><strong><?= htmlspecialchars($item['name']) ?></strong> — <?= $item['quantity'] ?> adet kaldı</li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

    <!-- Yeni Malzeme Ekle -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold">➕ Yeni Malzeme Ekle</div>
        <div class="card-body">
            <form method="POST" action="index.php?page=inventory-add" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Malzeme Adı</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Adet</label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">Ekle</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stok Artır (Sekreter için) -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold">📦 Var Olan Ürüne Yeni Stok Ekle</div>
        <div class="card-body">
            <form method="POST" action="index.php?page=inventory-increase" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Malzeme Seç</label>
                    <select name="item_id" id="material-select" class="form-select" required>
                        <?php foreach ($items as $item): ?>
                            <option value="<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Artış Miktarı</label>
                    <input type="number" name="increase_quantity" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Not</label>
                    <input type="text" name="reason" class="form-control" placeholder="örn: Yeni alım">
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-success">Stok Artır</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Mevcut Malzemeler -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold">📋 Mevcut Malzemeler</div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Malzeme</th>
                        <th>Adet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Grafikler -->
    <div class="row">
        <!-- Top Kullanım -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header fw-bold">🏆 En Çok Kullanılan Malzemeler</div>
                <div class="card-body">
                    <canvas id="topUsedChart" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>
        <!-- Başlangıç vs Kalan -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header fw-bold">📈 Stok Durumu Karşılaştırması</div>
                <div class="card-body">
                    <canvas id="lineStockChart" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
new TomSelect('#material-select', {
    create: false,
    sortField: {
        field: "text",
        direction: "asc"
    },
    placeholder: "Malzeme ara..."
});
</script>

<?php
$topLabels = [];
$topValues = [];
foreach ($topUsedItems ?? [] as $item) {
    $topLabels[] = $item['name'];
    $topValues[] = $item['total_used'];
}

$lineLabels = [];
$lineInitials = [];
$lineCurrents = [];
foreach ($chartItems ?? [] as $item) {
    $lineLabels[] = $item['name'];
    $lineInitials[] = $item['initial_stock'];
    $lineCurrents[] = $item['current_stock'];
}
?>

<script>
const ctx2 = document.getElementById('topUsedChart').getContext('2d');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: <?= json_encode($topLabels) ?>,
        datasets: [{
            label: 'Toplam Kullanım',
            data: <?= json_encode($topValues) ?>,
            backgroundColor: 'rgba(220, 53, 69, 0.6)',
            borderRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

const ctx3 = document.getElementById('lineStockChart').getContext('2d');
new Chart(ctx3, {
    type: 'line',
    data: {
        labels: <?= json_encode($lineLabels) ?>,
        datasets: [
            {
                label: 'Başlangıç Stoğu',
                data: <?= json_encode($lineInitials) ?>,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.3,
                borderWidth: 2,
                pointRadius: 0
            },
            {
                label: 'Kalan Stok',
                data: <?= json_encode($lineCurrents) ?>,
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.3,
                borderWidth: 2,
                pointRadius: 0
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>