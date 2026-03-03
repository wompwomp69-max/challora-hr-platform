<h1 class="mb-4">Status Lamaran</h1>
<p><a href="<?= BASE_URL ?>/jobs" class="btn btn-outline-secondary btn-sm mb-3">← Kembali ke daftar lowongan</a></p>
<?php if (empty($applications)): ?>
    <div class="card">
        <div class="card-body">Belum ada lamaran. <a href="<?= BASE_URL ?>/jobs">Cari lowongan</a></div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr><th>Lowongan</th><th>Status</th><th>Tanggal</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $a): ?>
                            <tr>
                                <td><?= e($a['job_title']) ?></td>
                                <td>
                                    <?php
                                    $badgeClass = $a['status'] === 'pending' ? 'bg-primary' : ($a['status'] === 'accepted' ? 'bg-success' : ($a['status'] === 'rejected' ? 'bg-danger' : 'bg-secondary'));
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= e($a['status']) ?></span>
                                </td>
                                <td><?= e($a['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
