<div class="card">
    <h1>Profil Saya</h1>
    <p><strong>Nama:</strong> <?= e($user['name']) ?></p>
    <p><strong>Email:</strong> <?= e($user['email']) ?></p>
    <p><strong>No. HP:</strong> <?= e($user['phone'] ?? '-') ?></p>
    <p><strong>Alamat:</strong> <?= e($user['address'] ?? '-') ?></p>
    <p><a href="<?= BASE_URL ?>/user/profile/edit" class="btn">Edit Profil</a></p>
</div>
<div class="card">
    <h2>Lamaran Saya</h2>
    <?php if (empty($applications)): ?>
        <p>Belum ada lamaran.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr><th>Lowongan</th><th>Lokasi</th><th>Status</th><th>Tanggal</th></tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $a): ?>
                    <tr>
                        <td><?= e($a['job_title']) ?></td>
                        <td><?= e($a['location'] ?? '-') ?></td>
                        <td><span class="badge badge-<?= e($a['status']) ?>"><?= e($a['status']) ?></span></td>
                        <td><?= e($a['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
