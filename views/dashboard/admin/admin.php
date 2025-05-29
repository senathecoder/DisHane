<div style="
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #fff;
">
    <div class="card border-0 shadow-lg" style="
        border-radius: 26px;
        background: #fff9fa;
        width: 40vw;
        min-width: 420px;
        max-width: 740px;
        padding: 0 2.5rem;
    ">
        <div class="card-body px-2 py-4">
            <div class="d-flex align-items-center mb-4">
                <i class="bi bi-person-badge-fill me-3" style="color: #b02a37; font-size: 2.1rem;"></i>
                <div>
                    <div class="fw-bold" style="font-size:1.55rem; color:#b02a37;">
                        Klinik Yönetim Paneli
                    </div>
                    <div style="color:#b02a37; font-size:1rem; letter-spacing:.2px;">
                        <span style="font-size:1.1rem;">👑</span>
                        Hoş geldiniz, <strong><?= htmlspecialchars($_SESSION['full_name'] ?? "Dişhane Admin") ?></strong>
                    </div>
                </div>
            </div>
            <div class="mb-4" style="color:#6e232a; font-size:1.05rem;">
                Bu panelde kliniğinizin <b>istatistiklerini</b> görebilir, <b>personel ekleyebilir</b> ve sistem ayarlarını kolayca yönetebilirsiniz.
            </div>
            <div class="d-grid gap-3">
                <a href="index.php?page=clinicStats" class="btn fw-semibold py-3"
                   style="background: #f7d6dc; color:#b02a37; border: none; border-radius: 14px; font-size:1.08rem; box-shadow:0 2px 10px #eecad6;">
                   <i class="bi bi-bar-chart-fill me-2"></i> Genel Klinik İstatistikleri
                </a>
                <a href="index.php?page=personelList" class="btn fw-semibold py-3"
                   style="background: #faf9f9; color:#b02a37; border: 1.5px solid #eecad6; border-radius: 14px; font-size:1.03rem;">
                   <i class="bi bi-people-fill me-2"></i> Personel İşlemleri
                </a>
                <a href="index.php?page=logout" class="btn fw-semibold py-3"
                   style="background: #fff; color: #b02a37; border: 1.5px solid #b02a37; border-radius: 14px; font-size:1rem;">
                   <i class="bi bi-box-arrow-right me-2"></i> Çıkış Yap
                </a>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
.btn {
    transition: background 0.22s, color 0.22s, box-shadow 0.18s;
}

/* Klinik İstatistikleri (üstteki pembe buton) */
.btn[style*="background: #f7d6dc"] {
    background: #f7d6dc;
    color: #b02a37;
}
.btn[style*="background: #f7d6dc"]:hover,
.btn[style*="background: #f7d6dc"]:focus {
    background: #b02a37 !important;
    color: #fff !important;
    box-shadow: 0 3px 14px #efbfcf8c;
}

/* Personel Ekle (beyaz/krem zeminli) */
.btn[style*="background: #faf9f9"] {
    background: #faf9f9;
    color: #b02a37;
    border: 1.5px solid #eecad6;
}
.btn[style*="background: #faf9f9"]:hover,
.btn[style*="background: #faf9f9"]:focus {
    background: #b02a37 !important;
    color: #fff !important;
    border-color: #b02a37 !important;
    box-shadow: 0 3px 12px #b02a372a;
}

/* Çıkış (beyaz zemin bordo kenar) */
.btn[style*="background: #fff"] {
    background: #fff;
    color: #b02a37;
    border: 1.5px solid #b02a37;
}
.btn[style*="background: #fff"]:hover,
.btn[style*="background: #fff"]:focus {
    background: #b02a37 !important;
    color: #fff !important;
    border-color: #b02a37;
    box-shadow: 0 3px 12px #b02a37a7;
}
</style>


