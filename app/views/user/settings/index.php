<div class="card mb-4">
    <div class="card-body">
        <h1 class="card-title h4 mb-4">Profil Saya</h1>
        <p><strong>Nama:</strong> <?= e($user['name']) ?></p>
        <p><strong>Email:</strong> <?= e($user['email']) ?></p>
        <p><strong>No. HP:</strong> <?= e($user['phone'] ?? '-') ?></p>
        <p><strong>Alamat:</strong> <?= e($user['address'] ?? '-') ?></p>
        <a href="<?= BASE_URL ?>/user/settings/edit" class="btn btn-primary">Edit Profil</a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h2 class="card-title h5 mb-4">Lamaran Saya</h2>
        <?php if (empty($applications)): ?>
            <p class="text-muted">Belum ada lamaran.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr><th>Lowongan</th><th>Lokasi</th><th>Status</th><th>Tanggal</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $a): ?>
                            <tr>
                                <td><?= e($a['job_title']) ?></td>
                                <td><?= e($a['location'] ?? '-') ?></td>
                                <td>
                                    <?php $badgeClass = $a['status'] === 'pending' ? 'bg-primary' : ($a['status'] === 'accepted' ? 'bg-success' : ($a['status'] === 'rejected' ? 'bg-danger' : 'bg-secondary')); ?>
                                    <span class="badge <?= $badgeClass ?>"><?= e($a['status']) ?></span>
                                </td>
                                <td><?= e($a['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
