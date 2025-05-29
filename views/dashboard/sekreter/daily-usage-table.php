<?php if (!empty($logs)): ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle table-bordered text-center mb-0">
            <thead class="table-light">
                <tr>
                    <th>Malzeme</th>
                    <th>Adet</th>
                    <th>Doktor</th>
                    <th>Saat</th>
                    <th>Açıklama</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= htmlspecialchars($log['item_name']) ?></td>
                        <td><span class="badge bg-danger"><?= abs($log['change_quantity']) ?></span></td>
                        <td><?= htmlspecialchars($log['doctor']) ?></td>
                        <td><?= htmlspecialchars(substr($log['appointment_time'], 0, 5)) ?></td>
                        <td><?= $log['reason'] ? htmlspecialchars($log['reason']) : '<span class="text-muted">-</span>' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-warning mt-3">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        Seçilen tarihe ait malzeme kullanımı kaydı bulunamadı.
    </div>
<?php endif; ?>
