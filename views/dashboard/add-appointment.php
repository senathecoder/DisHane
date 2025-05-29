<!-- Bootstrap + Tom Select CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet" />

<style>
body {
    background: #fafbff;
    min-height: 100vh;
}
.form-container {
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 8px 40px 0 rgba(176,42,55,0.10);
    padding: 2.2rem 2.4rem 2rem 2.4rem;
    max-width: 520px;
    width: 100%;
    margin: 48px auto 0 auto; /* Ortalar! */
    /* Eğer daha dikey ortalamak istersen aşağıdaki satırı aktif et */
    /* position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); */
}
.geri-btn-kapsayici {
    margin-bottom: .5rem;
}
.geri-btn-mini {
    display: inline-flex;
    align-items: center;
    gap: .38em;
    background: #fae2e7;
    color: #b02a37;
    font-weight: 600;
    font-size: 1.01rem;
    border: none;
    border-radius: 16px;
    padding: 4px 13px 4px 10px;
    text-decoration: none;
    box-shadow: 0 1px 5px 0 rgba(176,42,55,0.025);
    transition: background .15s, color .13s;
    height: 31px;
    min-width: 54px;
}
.geri-btn-mini:hover, .geri-btn-mini:focus {
    background: #f8cad3;
    color: #871823;
    outline: none;
}
.geri-btn-mini .geri-ikon {
    font-size: 1.06em;
    vertical-align: middle;
    margin-right: 3px;
    margin-left: 1px;
}
.form-label {
    color: #b02a37;
    font-weight: 600;
}
.form-control, .form-select {
    border-radius: 13px;
    border: 1.1px solid #e0bfc2;
    font-size: 1.07rem;
    min-height: 43px;
    background: #fff;
}
.form-control:focus, .form-select:focus {
    border-color: #b02a37;
    box-shadow: 0 0 0 2px #b02a3721;
}
.btn-primary {
    background: #b02a37 !important;
    border: none;
    border-radius: 13px;
    font-weight: 600;
    font-size: 1.05rem;
    padding: .58em 2.1em;
    letter-spacing: .03em;
    transition: background .15s;
    margin-top: 5px;
    box-shadow: 0 2px 12px 0 rgba(176,42,55, 0.06);
}
.btn-primary:hover, .btn-primary:focus {
    background: #8e1c27 !important;
}
@media (max-width: 650px) {
    body { padding: 12px; }
    .form-container { padding: 1.2rem .7rem; }
}
</style>

<div class="form-container">
    <!-- Geri Dön Butonu -->
    <div class="geri-btn-kapsayici">
        <a href="index.php?page=appointmentsList" class="geri-btn-mini">
            <span class="geri-ikon">&#8592;</span> Geri
        </a>
    </div>

    <h2 class="mb-4">Randevu Ekle</h2>
    <form method="POST" action="index.php?page=handleAddAppointment">
        <div class="mb-3">
            <label for="patient_id" class="form-label">Hasta Seç</label>
            <select id="patient_id" name="patient_id" class="form-select" required>
                <option value="">Hasta Seçiniz</option>
                <?php foreach ($patients as $patient): ?>
                    <option value="<?= $patient['id'] ?>"><?= htmlspecialchars($patient['full_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="doctor_id" class="form-label">Doktor Seç</label>
            <select id="doctor_id" name="doctor_id" class="form-select" required>
                <option value="">Doktor Seçiniz</option>
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?= $doctor['id'] ?>"><?= htmlspecialchars($doctor['full_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="appointment_date" class="form-label">Tarih</label>
            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required min="2024-01-01" max="2030-12-31">
        </div>
        <div class="mb-3">
            <label for="appointment_time" class="form-label">Saat</label>
            <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="notes" class="form-label">Planlanan İşlem</label>
            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Örn: Diş çekimi, dolgu, implant..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Randevuyu Kaydet</button>
    </form>
</div>

<!-- Tom Select JS -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
new TomSelect("#patient_id", {
    create: false,
    sortField: {
        field: "text",
        direction: "asc"
    },
    placeholder: "Hasta Seçiniz"
});
new TomSelect("#doctor_id", {
    create: false,
    sortField: {
        field: "text",
        direction: "asc"
    },
    placeholder: "Doktor Seçiniz"
});
</script>
