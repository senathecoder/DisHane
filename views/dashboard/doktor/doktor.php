<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
    header("Location: ../../public/index.php?page=login");
    exit;
}
?>

<!-- Stil -->
<style>
.doctor-panel-card {
    max-width: 510px;
    margin: 44px auto 44px auto;
    background: #fff;
    border-radius: 23px;
    box-shadow: 0 8px 36px 0 rgba(176, 42, 55, 0.11);
    padding: 2.3rem 2.4rem 2rem 2.4rem;
    text-align: center;
}
.doctor-panel-card h2 {
    color: #b02a37;
    font-weight: 700;
    letter-spacing: .6px;
    margin-bottom: 1.35rem;
}
.doctor-panel-card p {
    font-size: 1.09rem;
    color: #4d393b;
    margin-bottom: .65rem;
}
.doctor-panel-card .btn {
    border-radius: 12px;
    font-weight: 600;
    font-size: 1.07rem;
    box-shadow: 0 1px 7px 0 rgba(176,42,55,0.06);
    padding: .50em 1.4em;
    letter-spacing: .01em;
    transition: background .14s, box-shadow .13s, color .14s;
}
.doctor-panel-card .btn-outline-secondary {
    border-color: #f8cdd7;
    color: #b02a37;
    background: #fde5eb;
}
.doctor-panel-card .btn-outline-secondary:hover,
.doctor-panel-card .btn-outline-secondary:focus {
    background: #fad5dd;
    color: #871823;
    border-color: #f4b8c5;
}
.doctor-panel-card .btn-outline-danger {
    border-color: #f6c2c6;
    color: #b02a37;
    background: #fff0f1;
}
.doctor-panel-card .btn-outline-danger:hover,
.doctor-panel-card .btn-outline-danger:focus {
    background: #f6ccd2;
    color: #871823;
    border-color: #e7a7af;
}
@media (max-width: 600px) {
    .doctor-panel-card { padding: 1.1rem 0.6rem; }
    .doctor-panel-card h2 { font-size: 1.3rem; }
}
</style>

<div class="doctor-panel-card">
    <h2>Doktor Paneli</h2>
    <p class="mb-3">Hoş geldiniz, <strong><?php echo $_SESSION['full_name']; ?></strong>!</p>
    <p>Bu sayfa sadece doktor kullanıcıları içindir.</p>
    <p>Burada hasta listelerinizi ve randevularınızı yönetebilirsiniz.</p>
    <p>Randevularınızı görmek için aşağıdaki butona tıklayabilirsiniz.</p>

    <div class="d-flex flex-column gap-2 mt-4">
        <a href="index.php?page=doctorAppointments" class="btn btn-outline-secondary">📋 Randevu Takvimi</a>
        <a href="index.php?page=searchMedicalRecordsDoctor" class="btn btn-outline-secondary">🩺 Tıbbi Kayıtlar</a>
        <a href="index.php?page=logout" class="btn btn-outline-danger">Çıkış Yap</a>
    </div>
</div>
