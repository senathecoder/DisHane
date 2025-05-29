<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background: #fff9fa !important;
    }
    .patient-panel-card {
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 8px 32px 0 rgba(176,42,55,0.12);
        padding: 2.2rem 2.1rem 2rem 2.1rem;
        max-width: 480px;
        margin: 0 auto;
    }
    .panel-title {
        color: #b02a37;
        font-weight: bold;
        font-size: 2rem;
        letter-spacing: 1px;
        text-align: center;
        margin-bottom: 1.6rem;
    }
    .panel-section {
        margin-bottom: 1.6rem;
        text-align: center;
    }
    .patient-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 1.12rem;
        color: #b02a37;
        font-weight: 500;
        text-decoration: none;
        background: #fff4f4;
        border-radius: 14px;
        padding: .7rem 1.2rem;
        margin-bottom: 1rem;
        transition: background .14s;
    }
    .patient-link:hover {
        background: #fae0e5;
        color: #8e1c27;
        text-decoration: none;
    }
    .logout-btn {
        background: #b02a37;
        color: #fff;
        border-radius: 14px;
        padding: .65rem 1.3rem;
        font-weight: 500;
        letter-spacing: .5px;
        border: none;
        transition: box-shadow .2s, background .2s;
        box-shadow: 0 2px 8px 0 rgba(176, 42, 55, 0.11);
        margin-top: .5rem;
        width: 100%;
    }
    .logout-btn:hover, .logout-btn:focus {
        background: #8e1c27;
        color: #fff;
        box-shadow: 0 8px 18px 0 rgba(176, 42, 55, 0.13);
        outline: none;
    }
</style>

<div class="container" style="min-height: 100vh; display: flex; align-items: center;">
    <div class="patient-panel-card w-100">
        <div class="panel-title">
            <i class="bi bi-person-heart" style="font-size:1.5rem;vertical-align:middle;margin-right:.5rem;"></i>
            Hasta Paneli
        </div>
        <div class="panel-section">
            <span>Hoş geldiniz, <strong><?= htmlspecialchars($_SESSION['full_name'] ?? '') ?></strong>!</span>
        </div>
        <div class="panel-section">
            <a href="index.php?page=available-hours" class="patient-link">
                <i class="bi bi-calendar-plus"></i> Randevu Al
            </a>
            <a href="index.php?page=myAppointments" class="patient-link">
                <i class="bi bi-calendar-check"></i> Randevularımı Görüntüle
            </a>
            <a href="index.php?page=medicalRecords" class="patient-link">
                <i class="bi bi-journal-medical"></i> Tıbbi Kayıtlarım
            </a>
        </div>
        <form action="index.php?page=logout" method="post" class="text-center">
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right me-1"></i> Çıkış Yap
            </button>
        </form>
    </div>
</div>
