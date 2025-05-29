<!-- Bootstrap CSS ekli olmalı -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.tani-ekle-card {
    max-width: 510px;
    margin: 38px auto 36px auto;
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 8px 36px 0 rgba(176, 42, 55, 0.09);
    padding: 2.1rem 2.2rem 1.7rem 2.2rem;
}
.tani-ekle-card h2 {
    color: #b02a37;
    font-weight: 700;
    letter-spacing: .4px;
    margin-bottom: 1.25rem;
    text-align: center;
}
.tani-ekle-card .form-label {
    color: #b02a37;
    font-weight: 600;
    margin-bottom: .33rem;
}
.tani-ekle-card .form-control {
    border-radius: 14px;
    border: 1.1px solid #e0bfc2;
    min-height: 42px;
    font-size: 1.09rem;
    background: #fff;
}
.tani-ekle-card .form-control:focus {
    border-color: #b02a37;
    box-shadow: 0 0 0 2px #b02a3712;
    outline: none;
}
/* Özel bordo buton: */
.tani-ekle-card .btn-bordo {
    background: #b02a37 !important;
    color: #fff !important;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    padding: .53em 1.38em;
    font-size: 1.07rem;
    margin-top: 6px;
    box-shadow: 0 1px 7px 0 rgba(176,42,55, 0.09);
    transition: background .14s, box-shadow .13s;
}
.tani-ekle-card .btn-bordo:hover,
.tani-ekle-card .btn-bordo:focus {
    background: #871823 !important;
    color: #fff !important;
    box-shadow: 0 4px 14px 0 rgba(176,42,55, 0.10);
}
.tani-ekle-card .btn-outline-secondary {
    color: #b02a37 !important;
    border-color: #b02a37 !important;
    border-radius: 12px;
    font-weight: 600;
    transition: background .13s, color .13s;
    padding: .49em 1.3em;
    font-size: 1.05rem;
    margin-left: 8px;
}
.tani-ekle-card .btn-outline-secondary:hover,
.tani-ekle-card .btn-outline-secondary:focus {
    background: #fae2e7 !important;
    color: #871823 !important;
    outline: none;
}
</style>

<div class="tani-ekle-card">
    <h2 class="mb-4">Tanı Ekle</h2>
    <form method="post" action="index.php?page=addDiagnosis">
        <input type="hidden" name="test_id" value="<?= htmlspecialchars($_GET['test_id'] ?? $_POST['test_id'] ?? '') ?>">
        <div class="mb-3">
            <label class="form-label fw-semibold">Tanı</label>
            <textarea class="form-control" name="diagnosis" required rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-bordo">Kaydet</button>
        <a href="javascript:history.back()" class="btn btn-outline-secondary ms-2">İptal</a>
    </form>
</div>
