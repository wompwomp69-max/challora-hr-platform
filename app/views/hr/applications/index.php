<div class="card mb-3">
    <div class="card-body">
        <h1 class="card-title h4">Pelamar: <?= e($job['title']) ?></h1>
        <a href="<?= BASE_URL ?>/hr/jobs" class="btn btn-outline-secondary btn-sm">← Kembali ke daftar lowongan</a>
    </div>
</div>
<?php if (empty($applicants)): ?>
    <div class="card">
        <div class="card-body">Belum ada pelamar.</div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr><th>Nama</th><th>Email</th><th>No. HP</th><th>CV</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applicants as $a): ?>
                            <tr>
                                <td><?= e($a['name']) ?></td>
                                <td><?= e($a['email']) ?></td>
                                <td><?= e($a['phone'] ?? '-') ?></td>
                                <td>
                                    <?php if (!empty($a['cv_path'])): ?>
                                        <a href="<?= BASE_URL ?>/index.php?url=download/cv&id=<?= (int)$a['id'] ?>" class="btn btn-sm btn-outline-primary">Unduh</a>
                                    <?php else: ?>—<?php endif; ?>
                                </td>
                                <td>
                                    <?php $badgeClass = $a['status'] === 'pending' ? 'bg-primary' : ($a['status'] === 'accepted' ? 'bg-success' : ($a['status'] === 'rejected' ? 'bg-danger' : 'bg-secondary')); ?>
                                    <span class="badge <?= $badgeClass ?>"><?= e($a['status']) ?></span>
                                </td>
                                <td>
                                    <form method="post" action="<?= BASE_URL ?>/index.php?url=hr/applications/update-status" class="d-inline">
                                        <input type="hidden" name="application_id" value="<?= (int)$a['id'] ?>">
                                        <select name="status" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                                            <option value="pending" <?= $a['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="accepted" <?= $a['status'] === 'accepted' ? 'selected' : '' ?>>Accepted</option>
                                            <option value="rejected" <?= $a['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            <?php if (!empty($a['address'])): ?>
                            <tr>
                                <td colspan="6" class="text-muted small">Alamat: <?= e($a['address']) ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
