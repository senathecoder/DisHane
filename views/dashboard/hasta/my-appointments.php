<!-- Tom Select & Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />

    <style>
    body {
        background: #fafbff;
    }
    .container {
        max-width: 1000px;
        margin: 38px auto 36px auto;
        background: #fff;
        border-radius: 22px;
        box-shadow: 0 8px 40px 0 rgba(176,42,55,0.09);
        padding: 2.4rem 2.5rem 2rem 2.5rem;
    }
    h2 {
        color: #b02a37;
        font-weight: bold;
        letter-spacing: .5px;
        margin-top: .3rem;
    }
    .form-label {
        color: #b02a37;
        font-weight: 600;
    }
    .form-select, .form-control {
        border-radius: 13px;
        border: 1.1px solid #e0bfc2;
        font-size: 1.07rem;
        min-height: 42px;
        background: #fff;
    }
    .form-select:focus, .form-control:focus {
        border-color: #b02a37;
        box-shadow: 0 0 0 2px #b02a3720;
        outline: none;
    }
    .table {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 32px 0 rgba(176,42,55,0.07);
        margin-bottom: 2rem;
    }
    .table thead th {
        background: #f8e9ec;
        color: #b02a37;
        font-weight: 700;
        border-bottom: 2.2px solid #e0bfc2 !important;
        font-size: 1.08rem;
        letter-spacing: .2px;
    }
    .table tbody tr {
        border-bottom: 1px solid #f0d7d9;
    }
    .table tbody tr:last-child {
        border-bottom: none;
    }
    .table-hover tbody tr:hover {
        background: #fff2f5 !important;
    }

    /* Durum Rozetleri */
    .badge {
        border-radius: 8px;
        font-size: 1.00rem;
        padding: 0.28em 0.85em;
        font-weight: 600;
        letter-spacing: .03em;
        border: none;
        box-shadow: none;
        background: #f5d7dd;
        color: #b02a37;
        display: inline-block;
        vertical-align: middle;
    }
    .bg-warning {
        background: #fffbe2 !important;
        color: #c89613 !important;
        border: none !important;
    }
    .bg-success {
        background: #e3f6e9 !important;
        color: #21a97b !important;
        border: none !important;
    }
    .bg-secondary,
    .bg-light {
        background: #f5d7dd !important;
        color: #b02a37 !important;
        border: none !important;
    }

/* İptal Et Butonu */
.btn-danger, .btn-danger:visited {
    background: #b02a37 !important;
    color: #fff !important;
    border: none;
    border-radius: 13px;
    font-weight: 600;
    padding: .42em 1.25em;
    font-size: 1.01rem;
    box-shadow: 0 2px 10px 0 rgba(176,42,55, 0.12);
    margin-bottom: 2px;
    outline: none !important;
    transition: background .14s, box-shadow .13s;
}
.btn-danger:hover, .btn-danger:focus {
    background: #8e1c27 !important;
    color: #fff !important;
    box-shadow: 0 6px 18px 0 rgba(176,42,55, 0.12);
}

    /* ---- İptal Edilmiş Yazısı ---- */
    em.text-muted {
        color: #bda9ad !important;
        font-style: normal;
        font-size: .98em;
    }

    /* ---- Bilgilendirme Alerti ---- */
    .alert-info {
        background: #f7eafd;
        color: #9a4e8e;
        border: none;
        border-radius: 13px;
        font-size: 1.05rem;
        font-weight: 500;
        box-shadow: 0 1px 6px 0 rgba(176,42,55,0.04);
    }

    /* ---- Geçmiş Satır ---- */
    .table-secondary {
        background: #f9f4f4 !important;
    }
    .text-muted {
        color: #9c9c9c !important;
    }

    /* ---- Geri Butonu ---- */
    .geri-btn-kapsayici {
        margin-bottom: 0.7rem;
        margin-top: 0;
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
        font-size: 1.06em;
        line-height: 1;
        vertical-align: middle;
        margin-right: 4px;
        margin-left: 1px;
    }

    @media (max-width: 767px) {
        .container { padding-left: .5rem; padding-right: .5rem;}
        .table { font-size: .96rem;}
        h2 { font-size: 1.23rem; }
        .form-label { font-size: .97rem;}
    }
    </style>
</head>
<body>
<div class="container">

    <div class="geri-btn-kapsayici">
      <a href="index.php?page=dashboard" class="geri-btn-mini">
        <span class="geri-ikon">&#8592;</span> Geri
      </a>
    </div>

    <h2 class="mb-4">Randevularım</h2>
    
    <!-- Filtreler -->
    <div class="row row-cols-1 row-cols-md-3 g-3 mb-4">
        <div class="col">
            <label for="doctorFilter" class="form-label">Doktor Ara</label>
            <select id="doctorFilter" class="form-select">
                <option value="">Tümü</option>
                <?php
                $names = array_unique(array_column($appointments, 'doctor_name'));
                foreach ($names as $name) {
                    echo "<option value=\"" . htmlspecialchars($name) . "\">$name</option>";
                }
                ?>
            </select>
        </div>
        <div class="col">
            <label for="startDate" class="form-label">Başlangıç Tarihi</label>
            <input type="date" id="startDate" class="form-control" min="2020-01-01" max="2030-12-31">
        </div>
        <div class="col">
            <label for="endDate" class="form-label">Bitiş Tarihi</label>
            <input type="date" id="endDate" class="form-control" min="2020-01-01" max="2030-12-31">
        </div>
    </div>

    <?php if (empty($appointments)): ?>
        <div class="alert alert-info">Henüz hiç randevu almadınız.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle" id="appointmentTable">
                <thead class="table-light">
                    <tr>
                        <th>Doktor</th>
                        <th>Tarih</th>
                        <th>Saat</th>
                        <th>Durum</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $today = date('Y-m-d');
                    foreach ($appointments as $appt): 
                        $isPast = strtotime($appt['appointment_date']) < strtotime($today);
                        $rowClass = $isPast ? 'table-secondary text-muted' : '';
                    ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= htmlspecialchars($appt['doctor_name']) ?></td>
                            <td><?= htmlspecialchars($appt['appointment_date']) ?></td>
                            <td><?= htmlspecialchars($appt['appointment_time']) ?></td>
                            <td>
                                <?php
                                $status = $appt['status'];
                                $badgeClass = match ($status) {
                                    'beklemede' => 'bg-warning text-dark',
                                    'iptal' => 'bg-secondary',
                                    'tamamlandı' => 'bg-success',
                                    default => 'bg-light'
                                };
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($status) ?></span>
                            </td>
                            <td>
                                <?php if ($status !== 'iptal'): ?>
                                    <form method="POST" action="index.php?page=cancelAppointment" onsubmit="return confirm('Bu randevuyu iptal etmek istediğinize emin misiniz?');">
                                        <input type="hidden" name="appointment_id" value="<?= $appt['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">İptal Et</button>
                                    </form>
                                <?php else: ?>
                                    <em class="text-muted">İptal edilmiş</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
new TomSelect("#doctorFilter", {
    allowEmptyOption: true,
    placeholder: "Doktor seçiniz"
});

function filterTable() {
    const selectedDoctor = document.getElementById("doctorFilter").value.toLowerCase();
    const startDate = document.getElementById("startDate").value;
    const endDate = document.getElementById("endDate").value;
    const rows = document.querySelectorAll("#appointmentTable tbody tr");

    rows.forEach(row => {
        const doctor = row.children[0].textContent.toLowerCase();
        const date = row.children[1].textContent;

        let matchesDoctor = !selectedDoctor || doctor.includes(selectedDoctor);
        let matchesDate = true;

        if (startDate && date < startDate) matchesDate = false;
        if (endDate && date > endDate) matchesDate = false;

        row.style.display = (matchesDoctor && matchesDate) ? "" : "none";
    });
}

document.getElementById("doctorFilter").addEventListener("change", filterTable);
document.getElementById("startDate").addEventListener("change", filterTable);
document.getElementById("endDate").addEventListener("change", filterTable);
</script>
</body>
</html>