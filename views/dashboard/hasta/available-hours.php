<?php
$doctors = $_SESSION['doctors'] ?? [];
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />

<style>
body {
    background: #fafbff;
}
.randevu-header {
    color: #b02a37;
    font-weight: 700;
    font-size: 2rem;
    letter-spacing: .7px;
    margin-bottom: .8rem;
    display: flex;
    align-items: center;
    gap: .7rem;
}
.randevu-box {
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 8px 40px 0 rgba(176, 42, 55, 0.09);
    padding: 2.4rem 2.5rem 2rem 2.5rem;
    max-width: 760px;
    margin: 38px auto 36px auto;
}
@media (max-width: 900px) {
    .randevu-box { max-width: 98vw; padding: 2.2rem 1rem; }
}
.randevu-form .form-label {
    color: #b02a37;
    font-weight: 500;
    margin-bottom: .3rem;
}
.randevu-form .form-control,
.randevu-form .form-select {
    border-radius: 13px;
    min-height: 44px;
    font-size: 1.09rem;
}

.saatleri-goster-btn {
    display: flex;
    justify-content: center;
    width: 100%;
    margin: 22px 0 26px 0; /* üst ve alt boşluk genişletildi */
}

.show-times-btn {
    background: #b02a37;
    color: #fff;
    border-radius: 12px;
    padding: .61rem 2.3rem;
    font-weight: 600;
    font-size: 1.11rem;
    border: none;
    box-shadow: 0 2px 10px 0 rgba(176,42,55, 0.09);
    transition: background .13s, box-shadow .13s;
    letter-spacing: .08px;
    min-width: 140px;
    min-height: 39px;
    display: flex;
    align-items: center;
    gap: 0.53em;
}
.show-times-btn:hover,
.show-times-btn:focus {
    background: #8e1c27;
    color: #fff;
    box-shadow: 0 8px 20px 0 rgba(176,42,55, 0.13);
    outline: none;
}

.saat-group {
    display: flex;
    flex-wrap: wrap;
    gap: 19px 25px;   /* Yatay ve dikeyde daha fazla ve eşit boşluk */
    margin-top: 16px;
    justify-content: center; /* Tüm kutuları ortala */
}

.saat-radio {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #fbeaec;
    padding: 9px 26px 9px 16px;
    border-radius: 18px;
    border: 1.2px solid #e0bfc2;
    font-weight: 500;
    cursor: pointer;
    min-width: 110px;
    font-size: 1.17rem;
    transition: border .15s, background .13s;
    margin-bottom: 0 !important; /* Alt boşluk olmasın, gap ile kontrol */
}
.saat-radio input[type=radio] { accent-color: #b02a37; }
.saat-radio:has(input:checked) {
    border: 1.5px solid #b02a37;
    background: #fff1f2;
}
.saat-radio.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    background: #f9ecee;
    border-color: #edd3d5;
}
.saat-label-kapali { color: #aaa; font-weight: bold; }
.saat-label-dolu { color: #ef6d6d; font-weight: bold; }
.saat-label-bos { color: #b02a37; font-weight: bold; }  


.randevu-btn {
    background: #b02a37;
    color: #fff;
    border-radius: 12px;
    padding: .59rem 2.3rem;
    font-weight: 600;
    font-size: 1.11rem;
    border: none;
    box-shadow: 0 2px 10px 0 rgba(176,42,55, 0.09);
    transition: background .13s, box-shadow .13s;
    letter-spacing: .08px;
    min-width: 140px;
    min-height: 39px;
}
.randevu-btn:hover,
.randevu-btn:focus {
    background: #8e1c27;
    color: #fff;
    box-shadow: 0 8px 20px 0 rgba(176,42,55, 0.13);
    outline: none;
}

/* Alert (Uyarı) kutularını özelleştir */
.custom-alert {
    border-radius: 16px;
    font-size: 1.08rem;
    font-weight: 500;
    border: none;
    padding: 1.1rem 1.2rem;
    margin-bottom: 1.2rem;
    background: #fce4ec;  /* Hafif pembe */
    color: #b02a37;
    box-shadow: 0 1px 6px 0 rgba(176,42,55,0.06);
}
.custom-alert.info {
    background: #e7e6fd;
    color: #5852a7;
}
.custom-alert.success {
    background: #e3f6e9;
    color: #2bbf8b;
}
.custom-alert.danger {
    background: #ffe5ea;
    color: #b02a37;
}
.custom-alert.warning {
    background: #fff5d2;
    color: #a48915;
}
@media (max-width: 600px) {
    .randevu-header { font-size: 1.4rem; gap:.3rem; }
    .randevu-box { padding: 1.1rem .4rem; }
    .saatleri-goster-btn button { width: 100%; font-size: .98rem; }
}
</style>

<div class="randevu-box">
    <div class="randevu-header mb-4">
        <i class="bi bi-calendar-plus"></i>
        Randevu Al
    </div>
    <form id="appointment-form" class="randevu-form row g-3 align-items-end">
        <div class="col-md-6">
            <label class="form-label">Doktor</label>
            <select id="doctor-select" name="doctor_id" class="form-select" required>
                <option value="">Seçiniz</option>
                <?php foreach ($doctors as $d): ?>
                    <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['full_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Tarih</label>
            <input type="date" name="date" class="form-control" min="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="saatleri-goster-btn">
            <button type="button" id="show-available-times" class="show-times-btn">
                <i class="bi bi-clock-history me-2"></i>
                Saatleri Göster
            </button>
        </div>

    </form>
    <div id="available-times" class="mt-4"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
new TomSelect("#doctor-select", {
    create: false,
    sortField: {
        field: "text",
        direction: "asc"
    },
    placeholder: "Doktor ara..."
});
</script>

<script>
document.getElementById('show-available-times').addEventListener('click', function () {
    const form = document.getElementById('appointment-form');
    const formData = new FormData(form);
    const doctorId = formData.get('doctor_id');
    const date = formData.get('date');

    if (!doctorId || !date) {
        showAlert("Lütfen doktor ve tarih seçiniz.", 'warning');
        return;
    }

    fetch('index.php?page=ajax-get-available-hours', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `doctor_id=${doctorId}&date=${date}`
    })
    .then(response => {
        if (!response.ok) throw new Error('Sunucu hatası: ' + response.status);
        return response.json();
    })
    .then(res => {
        const container = document.getElementById('available-times');
        container.innerHTML = '';

        // Daha önce randevu varsa
        if (res.has_appointment && res.data && res.data.appointment_time) {
            container.innerHTML = `
                <div class="custom-alert danger">
                    <strong>Bu tarihte zaten bir randevunuz var.</strong>
                    <br>Saat: <span class="fw-bold">${res.data.appointment_time}</span>
                </div>
                <button class="btn btn-outline-danger btn-sm mt-2" id="cancel-btn">Randevuyu İptal Et</button>
            `;
            document.getElementById('cancel-btn').onclick = function () {
                if (!confirm('Bu randevuyu iptal etmek istediğinize emin misiniz?')) return;
                fetch('index.php?page=cancelAppointmentAjax', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `appointment_id=${res.data.id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('Randevunuz başarıyla iptal edildi.', 'success');
                        setTimeout(() => document.getElementById("show-available-times").click(), 1000);
                    } else {
                        showAlert('İptal işlemi başarısız.', 'danger');
                    }
                });
            };
            return;
        }

        const data = Array.isArray(res.data) ? res.data : [];
        if (data.length === 0) {
            showAlert('Bu tarihte uygun saat bulunamadı.', 'info');
            return;
        }

        let html = `<form method="POST" action="index.php?page=bookAppointment" class="mt-2">`;
        html += `<input type="hidden" name="doctor_id" value="${doctorId}">`;
        html += `<input type="hidden" name="date" value="${date}">`;

        html += `<div class="saat-group">`;
        data.forEach(hour => {
            let labelClass = hour.closed
                ? 'saat-label-kapali'
                : (hour.available ? 'saat-label-bos' : 'saat-label-dolu');
            let disabled = (hour.closed || !hour.available) ? 'disabled' : '';
            html += `
                <label class="saat-radio ${disabled}">
                    <input type="radio" name="time" value="${hour.time}" ${disabled}>
                    <span class="${labelClass}">${hour.time}</span>
                    <span style="font-size: .92em;">
                        ${hour.closed ? '(Kapalı)' : (!hour.available ? '(Dolu)' : '')}
                    </span>
                </label>
            `;
        });
        html += `</div>`;
        html += `<div class="mt-3"><button type="submit" class="randevu-btn">Randevu Al</button></div></form>`;
        container.innerHTML = html;
    })
    .catch(err => {
        showAlert('Bir hata oluştu. Lütfen tekrar deneyin.', 'danger');
    });
});

function showAlert(message, type) {
    // type = 'danger', 'success', 'info', 'warning'
    document.getElementById('available-times').innerHTML = `<div class="custom-alert ${type}">${message}</div>`;
}
</script>
