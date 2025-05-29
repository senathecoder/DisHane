<div class="container" style="max-width:1120px;">
    <div class="d-flex align-items-center gap-2 mb-2" style="margin-top: 14px;">
        <a href="index.php?page=dashboard"
           class="btn btn-sm fw-semibold px-3 py-2 rounded-pill"
           style="background: #faf9f9; color: #b02a37; border: 1.3px solid #eecad6; font-size:1.05rem;">
            <i class="bi bi-arrow-left-short" style="font-size: 1.18rem;"></i>
            Geri
        </a>
        <h3 class="fw-bold mb-0" style="font-size:1.32rem; color: #b02a37;">
            Genel Klinik İstatistikleri
        </h3>
    </div>
</div>
<!-- Admin Paneli - Bilgi Kartları -->
<div class="row mb-4 g-3 justify-content-center">
    <?php
    $stats = [
        ["count" => $totalDoctors, "label" => "Doktor"],
        ["count" => $totalPatients, "label" => "Hasta"],
        ["count" => $totalSecretaries, "label" => "Sekreter"],
        ["count" => $newPatientsThisMonth, "label" => "Bu Ay Eklenen Hasta"],
        ["count" => $totalAppointments, "label" => "Toplam Randevu"],
    ];
    foreach ($stats as $item): ?>
        <div class="col-auto">
            <div class="card text-center border-0 shadow-sm" style="background: #f8f8f8; min-width: 120px;">
                <div class="card-body py-2">
                    <div class="fw-bold" style="color:#b02a37; font-size:1.35rem;"><?= $item['count'] ?></div>
                    <div style="font-size:.96rem; color:#b02a37;"><?= $item['label'] ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Ortada TABLO + GRAFİK birleşik kart -->
<div class="container" style="max-width:1120px;">
    <div class="card border-0 shadow-sm mb-4 px-0" style="background:#fcf9f9; border-radius:22px; overflow:hidden;">
        <div class="px-4 pt-4 pb-0">
            <h5 class="fw-bold text-center mb-3" style="font-size:1.17rem; color: #b02a37;">
                Doktor Bazında Aylık Hasta Sayısı
            </h5>
            <form method="get" class="row justify-content-center g-2 align-items-end mb-3">
                <input type="hidden" name="page" value="clinicStats">
                <div class="col-auto">
                    <label for="year" class="form-label fw-semibold mb-1" style="font-size:.99rem; color: #b02a37;">Yıl</label>
                    <input type="number" id="year" name="year" value="<?= htmlspecialchars($_GET['year'] ?? date('Y')) ?>"
                        class="form-control form-control-sm rounded-3 shadow-sm" style="width: 95px; border: 1px solid #e3a3ad;">
                </div>
                <div class="col-auto">
                    <label for="month" class="form-label fw-semibold mb-1" style="font-size:.99rem; color: #b02a37;">Ay</label>
                    <input type="number" id="month" name="month" value="<?= htmlspecialchars($_GET['month'] ?? date('m')) ?>"
                        class="form-control form-control-sm rounded-3 shadow-sm" min="1" max="12" style="width: 60px; border: 1px solid #e3a3ad;">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn px-3 btn-sm rounded-pill shadow-sm"
                        style="background: #b02a37; color: #fff; border:none;">
                        <i class="bi bi-search"></i> Filtrele
                    </button>
                </div>
                <?php if (isset($_GET['year']) || isset($_GET['month'])): ?>
                    <div class="col-auto">
                        <a href="index.php?page=clinicStats" class="btn btn-sm rounded-pill shadow-sm"
                        style="color: #b02a37; border: 1px solid #b02a37; background: #fff;">Temizle</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
        <div class="row g-0 justify-content-center align-items-stretch px-3 pb-4">
            <!-- TABLO -->
            <div class="col-12 col-md-6 d-flex align-items-center" style="border-right:1.5px solid #e5c6ca;">
                <?php if (isset($clinicStats)): ?>
                    <div class="w-100 px-2 py-2">
                        <table class="table table-sm align-middle text-center mb-0" style="font-size:1rem;">
                            <thead style="background:#f7d6dc;">
                                <tr>
                                    <th class="py-2 fw-semibold" style="width:65%; color:#b02a37;">Doktor</th>
                                    <th class="py-2 fw-semibold" style="width:35%; color:#b02a37;">Bakılan Hasta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($clinicStats)): ?>
                                    <?php foreach($clinicStats as $stat): ?>
                                        <tr>
                                            <td class="py-2"><?= htmlspecialchars($stat['doctor_name']) ?></td>
                                            <td class="py-2">
                                                <span class="badge"
                                                    style="font-size:1.04rem; padding:.45em 1em;
                                                    background:<?= $stat['patient_count'] > 0 ? '#f7d6dc' : '#ededed'; ?>;
                                                    color: #b02a37; border: 1px solid #e3a3ad;">
                                                    <?= $stat['patient_count'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">Kayıt bulunamadı.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
            <!-- GRAFİK -->
            <div class="col-12 col-md-6 d-flex align-items-center">
                <div class="w-100 px-2 py-2">
                    <div class="fw-semibold mb-2" style="font-size: 1.07rem; color:#b02a37;">
                        <i class="bi bi-cash-coin me-2" style="font-size: 1.05rem; color:#b02a37;"></i>
                        Doktorların Aylık Maaşı
                    </div>
                    <canvas id="salaryChart" style="height:210px;max-height:230px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ALTTA: Yan Yana Grafikler -->
<div class="container" style="max-width:1120px;">
    <div class="row g-4 justify-content-center align-items-stretch mb-2">
        <!-- Çizgi Grafik -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: #faf9f9;">
                <div class="card-body pb-3 pt-4">
                    <div class="d-flex align-items-center mb-1">
                        <i class="bi bi-graph-up me-2" style="font-size: 1.13rem; color:#b02a37;"></i>
                        <span style="font-size: 1.05rem; color: #b02a37; font-weight: 500;">
                            Zaman İçinde Hasta Artışı (<?= date('Y') ?>)
                        </span>
                    </div>
                    <canvas id="patientGrowthChart" style="height:230px; max-height:260px; width:100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Donut Grafik -->
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="background: #faf9f9;">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-pie-chart-fill me-2" style="color:#b02a37; font-size:1.15rem;"></i>
                        <span style="color: #b02a37; font-size: 1.07rem; font-weight: 500;">
                            Randevu Durumu Dağılımı
                        </span>
                    </div>
                    <canvas id="appointmentStatusChart" style="height:160px;max-height:180px; width:100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<script>
// Bar Chart - Doktorların Maaşı
const doctorSalaries = <?= json_encode($doctorSalaries) ?>;
const labels = doctorSalaries.map(item => item.doctor_name);
const data = doctorSalaries.map(item => item.salary);

const ctx = document.getElementById('salaryChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Aylık Maaş (₺)',
            data: data,
            borderRadius: 10,
            backgroundColor: 'rgba(247,214,220,0.8)',
            borderColor: 'rgba(176,42,55,0.82)',
            borderWidth: 2
        }]
    },
    options: {
        animation: { duration: 1100, easing: 'easeOutQuart' },
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ctx.parsed.y.toLocaleString('tr-TR') + " ₺"
                }
            }
        },
        scales: {
            x: { grid: { display: false } },
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 500,
                    callback: value => value.toLocaleString('tr-TR')
                }
            }
        }
    }
});

// Çizgi Grafik
const monthlyPatientGrowth = <?= json_encode($monthlyPatientGrowth) ?>;
const growthLabels = monthlyPatientGrowth.map(item => item.month);
const growthData = monthlyPatientGrowth.map(item => item.patient_count);

const ctxGrowth = document.getElementById('patientGrowthChart').getContext('2d');
new Chart(ctxGrowth, {
    type: 'line',
    data: {
        labels: growthLabels,
        datasets: [{
            label: 'Yeni Hasta',
            data: growthData,
            fill: true,
            borderColor: 'rgba(176,42,55,0.7)',
            backgroundColor: 'rgba(247,214,220,0.18)',
            tension: 0.35,
            pointRadius: 4,
            pointBackgroundColor: 'rgba(176,42,55,0.9)'
        }]
    },
    options: {
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ctx.parsed.y + " yeni hasta"
                }
            }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } },
            x: { grid: { display: false } }
        },
        animation: { duration: 1200, easing: 'easeOutQuart' }
    }
});

// Donut Grafik
const statusData = <?= json_encode(array_values($statusData)) ?>;
const statusLabels = <?= json_encode(array_keys($statusData)) ?>;
const statusColors = ['#b02a37','#f7d6dc','#eee'];

const ctxStatus = document.getElementById('appointmentStatusChart').getContext('2d');
new Chart(ctxStatus, {
    type: 'doughnut',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusData,
            backgroundColor: statusColors,
            borderColor: '#fff',
            borderWidth: 2,
        }]
    },
    options: {
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
                labels: { color: '#b02a37', font: { size: 13 } }
            },
            datalabels: {
                color: function(ctx) {
                    // Eğer koyu bordo ise beyaz, açık bordo ise bordo
                    return ctx.dataset.backgroundColor[ctx.dataIndex] === '#b02a37' ? '#fff' : '#b02a37';
                },
                font: { weight: 'bold', size: 15 },
                formatter: function(value, ctx) {
                    let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    let pct = sum ? Math.round(value / sum * 100) : 0;
                    return pct > 0 ? pct + '%' : '';
                }
            }
        },
        cutout: '60%'
    },
    plugins: [ChartDataLabels]
});
</script>

<!-- ALTTA: Yan Yana Grafikler -->
<div class="container" style="max-width:1120px; margin-top: 22px;"> <!-- DİKKAT: YUKARIYA BOŞLUK EKLENDİ -->
  <div class="row g-4 justify-content-center align-items-stretch mb-2">
    <!-- Kritik Stoklar -->
    <div class="col-12 col-md-6">
      <div class="card border-0 shadow-sm h-100" style="background: #faf9f9; border-radius:18px;">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <i class="bi bi-exclamation-triangle-fill me-2" style="color:#b02a37; font-size:1.15rem;"></i>
            <span style="color: #b02a37; font-size: 1.07rem; font-weight: 500;">Kritik Stoklar</span>
          </div>
          <canvas id="criticalStocksChart" style="height:155px; max-height:170px;"></canvas>
        </div>
      </div>
    </div>
    <!-- En Çok Kullanılan Malzemeler -->
    <div class="col-12 col-md-6">
      <div class="card border-0 shadow-sm h-100" style="background: #faf9f9; border-radius:18px;">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <i class="bi bi-bar-chart-fill me-2" style="color:#b02a37; font-size:1.15rem;"></i>
            <span style="color: #b02a37; font-size: 1.07rem; font-weight: 500;">
              En Çok Kullanılan Malzemeler (30 Gün)
            </span>
          </div>
          <canvas id="mostUsedItemsChart" style="height:155px; max-height:170px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
/* Kritik Stoklar BAR */
const criticalStocks = <?= json_encode($criticalStocks) ?>;
const criticalLabels = criticalStocks.map(item => item.name);
const criticalData = criticalStocks.map(item => item.quantity);
const criticalColors = criticalStocks.map(item => item.quantity <= 0 ? 'rgba(176,42,55,0.8)' : 'rgba(176,42,55,0.22)'); // Kritikse bordo, diğerleri açık

const ctxCritical = document.getElementById('criticalStocksChart').getContext('2d');
new Chart(ctxCritical, {
    type: 'bar',
    data: {
        labels: criticalLabels,
        datasets: [{
            data: criticalData,
            backgroundColor: criticalColors,
            borderRadius: 7,
            maxBarThickness: 18,
        }]
    },
    options: {
        indexAxis: 'y',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return "Kalan: " + context.parsed.x;
                    }
                }
            }
        },
        scales: {
            y: {
                ticks: { font: { size: 14 }, color: "#b02a37" },
            },
            x: {
                beginAtZero: true,
                ticks: { font: { size: 13 }, color: "#b02a37", stepSize: 1 },
            }
        }
    }
});

/* EN ÇOK KULLANILAN BAR */
const mostUsed = <?= json_encode($mostUsedItems) ?>;
const mostUsedLabels = mostUsed.map(item => item.name);
const mostUsedData = mostUsed.map(item => item.used_amount);

const ctxUsed = document.getElementById('mostUsedItemsChart').getContext('2d');
new Chart(ctxUsed, {
    type: 'bar',
    data: {
        labels: mostUsedLabels,
        datasets: [{
            data: mostUsedData,
            backgroundColor: 'rgba(247,214,220,0.7)',
            borderRadius: 7,
            maxBarThickness: 18,
        }]
    },
    options: {
        indexAxis: 'y',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return "Kullanım: " + context.parsed.x;
                    }
                }
            }
        },
        scales: {
            y: {
                ticks: { font: { size: 14 }, color: "#b02a37" },
            },
            x: {
                beginAtZero: true,
                ticks: { font: { size: 13 }, color: "#b02a37", stepSize: 1 },
            }
        }
    }
});
</script>


