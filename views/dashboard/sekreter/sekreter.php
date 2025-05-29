<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
    header("Location: index.php?page=login");
    exit;
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: #f5f6fa;
}
.sekreter-panel-kapsul {
    max-width: 600px;
    margin: 48px auto 0 auto;
    background: #fff;
    border-radius: 30px;
    box-shadow: 0 10px 44px 0 rgba(176, 42, 55, 0.14);
    padding: 2.6rem 2.4rem 2.2rem 2.4rem;
}
.sekreter-panel-kapsul h2 {
    color: #b02a37;
    font-weight: 700;
    text-align: center;
    margin-bottom: 1.1rem;
    letter-spacing: .8px;
}
.sekreter-panel-kapsul p {
    color: #444;
    text-align: center;
    margin-bottom: 0.5rem;
}
.sekreter-menu-list {
    margin-top: 2.2rem;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.sekreter-menu-list a {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
    font-weight: 600;
    font-size: 1.11rem;
    color: #b02a37;
    background: #fff6f7;
    border: 1.4px solid #f1d2d8;
    border-radius: 16px;
    padding: 0.75rem 1.3rem;
    text-decoration: none;
    transition: background 0.14s, box-shadow 0.12s, color 0.12s;
    box-shadow: 0 2px 12px 0 rgba(176,42,55,0.03);
}
.sekreter-menu-list a:hover, .sekreter-menu-list a:focus {
    background: #fae4e6;
    color: #871823;
    box-shadow: 0 8px 24px 0 rgba(176,42,55,0.08);
    text-decoration: none;
}
.sekreter-menu-list a:last-child {
    color: #fff;
    background: #b02a37;
    border: 1.4px solid #b02a37;
}
.sekreter-menu-list a:last-child:hover {
    background: #871823;
    color: #fff;
}
@media (max-width: 700px) {
    .sekreter-panel-kapsul { padding: 1.1rem 0.6rem; }
    .sekreter-menu-list a { font-size: 1rem; padding: 0.8rem 0.7rem;}
}
</style>

<div class="sekreter-panel-kapsul">
    <h2>Sekreter Paneli</h2>
    <p class="mb-2">Hoş geldiniz, <strong><?php echo $_SESSION['full_name']; ?></strong>!</p>
    <p>Bu sayfa sadece sekreter kullanıcıları içindir.<br>Buradan randevu oluşturabilir ve ödeme işlemlerini takip edebilirsiniz.</p>

    <div class="sekreter-menu-list">
        <a href="index.php?page=medicalRecordsSekreter">🩺 Tıbbi Kayıtlar</a>
        <a href="index.php?page=doctorWorkingHours">⏰ Doktor Çalışma Saatleri</a>
        <a href="index.php?page=appointmentsList">📅 Randevuları Görüntüle</a>
        <a href="index.php?page=addAppointment">➕ Randevu Ekle</a>
        <a href="index.php?page=inventory">📦 Stok Malzeme Yönetimi</a>
        <a href="index.php?page=daily-usage">📅 Günlük Malzeme Özeti</a>
        <a href="index.php?page=logout">Çıkış Yap</a>
    </div>
</div>
