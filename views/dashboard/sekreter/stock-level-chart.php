<div class="container mt-4">
    <h4 class="mb-3 text-primary">📈 En Çok Kullanılan 10 Ürünün Stok Seviyesi</h4>
    <canvas id="stockChart" style="max-height: 300px;"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const stockChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [
            {
                label: 'Başlangıç',
                data: <?= json_encode($initials) ?>,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                pointRadius: 0
            },
            {
                label: 'Kalan',
                data: <?= json_encode($currents) ?>,
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                pointRadius: 0
            }
        ]
    },
    options: {
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 12
                }
            },
            tooltip: {
                backgroundColor: '#fff',
                bodyColor: '#000',
                titleColor: '#000'
            }
        },
        scales: {
            x: {
                grid: { display: false }
            },
            y: {
                beginAtZero: true,
                grid: { color: '#e0e0e0' }
            }
        },
        maintainAspectRatio: false,
        responsive: true
    }
});

</script>
