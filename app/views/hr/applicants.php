<div class="card">
    <h1>Pelamar: <?= e($job['title']) ?></h1>
    <p><a href="<?= BASE_URL ?>/hr/jobs">← Kembali ke daftar lowongan</a></p>
</div>
<?php if (empty($applicants)): ?>
    <div class="card">Belum ada pelamar.</div>
<?php else: ?>
    <div class="card">
        <table>
            <thead>
                <tr><th>Nama</th><th>Email</th><th>No. HP</th><th>CV</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($applicants as $a): ?>
                    <tr>
                        <td><?= e($a['name']) ?></td>
                        <td><?= e($a['email']) ?></td>
                        <td><?= e($a['phone'] ?? '-') ?></td>
                        <td><?php if (!empty($a['cv_path'])): ?>
                            <a href="<?= BASE_URL ?>/index.php?url=download/cv&id=<?= (int)$a['id'] ?>">Unduh</a>
                        <?php else: ?>—<?php endif; ?></td>
                        <td><span class="badge badge-<?= e($a['status']) ?>"><?= e($a['status']) ?></span></td>
                        <td>
                            <form method="post" action="<?= BASE_URL ?>/index.php?url=hr/applications/update-status" style="display: inline;">
                                <input type="hidden" name="application_id" value="<?= (int)$a['id'] ?>">
                                <select name="status" onchange="this.form.submit()">
                                    <option value="pending" <?= $a['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="accepted" <?= $a['status'] === 'accepted' ? 'selected' : '' ?>>Accepted</option>
                                    <option value="rejected" <?= $a['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <?php if (!empty($a['address'])): ?>
                    <tr><td colspan="6" style="font-size: 0.9rem; color: #666;">Alamat: <?= e($a['address']) ?></td></tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
