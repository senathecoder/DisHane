<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>


<div class="container my-5">
    <style>
.geri-btn-kapsayici {
    margin-bottom: 0.7rem;
    margin-top: 1.1rem;
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
    font-size: 1.07em;
    vertical-align: middle;
    margin-right: 4px;
    margin-left: 1px;
}
</style>

<div class="geri-btn-kapsayici">
  <a href="index.php?page=dashboard" class="geri-btn-mini">
    <span class="geri-ikon">&#8592;</span> Geri
  </a>
</div>

    <div class="d-flex align-items-center mb-4">
        <i class="bi bi-clock-history fs-3" style="color: #b02a37;"></i>
        <h2 class="m-0 ms-2" style="color: #b02a37;">Doktor Çalışma Saatleri</h2>
    </div>

    <!-- Çalışma Saati Ekleme Formu -->
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-semibold" style="background: #fbeaec; color: #b02a37;">➕ Çalışma Saati Ekle</div>
        <div class="card-body">
            <form method="POST" action="index.php?page=doctorWorkingHours" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label" style="color: #b02a37;">Doktor</label>
                    <select name="doctor_id" class="form-select" required>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= $doctor['id'] ?>">
                                <?= htmlspecialchars($doctor['full_name'] ?? $doctor['username'] ?? 'Doktor') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: #b02a37;">Gün</label>
                    <select name="weekday" class="form-select" required>
                        <?php foreach (['Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi','Pazar'] as $day): ?>
                            <option value="<?= $day ?>"><?= $day ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: #b02a37;">Başlangıç</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label" style="color: #b02a37;">Bitiş</label>
                    <input type="time" name="end_time" class="form-control" required>
                </div>
                <div class="col-md-2 d-flex align-items-center pt-3">
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                        <label class="form-check-label" for="is_active" style="color: #b02a37;">Aktif</label>
                    </div>
                </div>
                <div class="col-md-1 d-grid">
                    <button type="submit" class="btn fw-semibold shadow-sm" style="background: #b02a37; color: #fff;">Kaydet</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tanımlı Çalışma Saatleri Tablosu -->
    <div class="card shadow-sm">
        <div class="card-header fw-semibold" style="background: #fbeaec; color: #b02a37;">
            <i class="bi bi-list-check"></i> Tanımlı Çalışma Saatleri
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Doktor</th>
                            <th>Gün</th>
                            <th>Başlangıç</th>
                            <th>Bitiş</th>
                            <th>Durum</th>
                            <th class="text-center">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($working_hours as $wh): ?>
                            <tr>
                                <td><?= htmlspecialchars($wh['doctor_name']) ?></td>
                                <td><?= htmlspecialchars($wh['weekday']) ?></td>
                                <td><?= htmlspecialchars($wh['start_time']) ?></td>
                                <td><?= htmlspecialchars($wh['end_time']) ?></td>
                                <td>
                                    <?php if ($wh['is_active']): ?>
                                        <span class="badge" style="background:#e7f8f1;color:#57b894;">Açık</span>
                                    <?php else: ?>
                                        <span class="badge" style="background:#fce4ec;color:#b02a37;">Kapalı</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <!-- Modal ile Düzenle -->
                                    <button type="button"
                                            class="btn btn-sm btn-outline-primary me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal"
                                            data-id="<?= $wh['id'] ?>"
                                            data-doctor="<?= htmlspecialchars($wh['doctor_name']) ?>"
                                            data-weekday="<?= $wh['weekday'] ?>"
                                            data-start="<?= $wh['start_time'] ?>"
                                            data-end="<?= $wh['end_time'] ?>"
                                            data-active="<?= $wh['is_active'] ?>">
                                        <i class="bi bi-pencil"></i> Düzenle
                                    </button>
                                    <a href="index.php?page=deleteDoctorWorkingHour&id=<?= $wh['id'] ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Bu çalışma saatini silmek istediğinize emin misiniz?')">
                                        <i class="bi bi-trash"></i> Sil
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($working_hours)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tanımlı çalışma saati yok.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- EDIT MODAL (değişiklik yok, sadece düğmelerin rengini yukarıda düzelttik) -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="index.php?page=doctorWorkingHours">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Çalışma Saatini Düzenle</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="edit_id" id="edit-id">
          <div class="mb-3">
            <label>Doktor</label>
            <input type="text" class="form-control" id="edit-doctor" disabled>
          </div>
          <div class="mb-3">
            <label>Gün</label>
            <input type="text" class="form-control" id="edit-weekday" name="edit_weekday" required>
          </div>
          <div class="mb-3">
            <label>Başlangıç</label>
            <input type="time" class="form-control" id="edit-start" name="edit_start_time" required>
          </div>
          <div class="mb-3">
            <label>Bitiş</label>
            <input type="time" class="form-control" id="edit-end" name="edit_end_time" required>
          </div>
          <div class="mb-3">
            <label>Aktif mi?</label>
            <input type="checkbox" id="edit-active" name="edit_is_active">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
          <button type="submit" name="save_edit" class="btn btn-primary">Kaydet</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
var editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function (event) {
  var button = event.relatedTarget;
  document.getElementById('edit-id').value = button.getAttribute('data-id');
  document.getElementById('edit-doctor').value = button.getAttribute('data-doctor');
  document.getElementById('edit-weekday').value = button.getAttribute('data-weekday');
  document.getElementById('edit-start').value = button.getAttribute('data-start');
  document.getElementById('edit-end').value = button.getAttribute('data-end');
  document.getElementById('edit-active').checked = button.getAttribute('data-active') == 1;
});
</script>
