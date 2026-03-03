<h1>Status Lamaran</h1>
<p><a href="<?= BASE_URL ?>/jobs">← Kembali ke daftar lowongan</a></p>
<?php if (empty($applications)): ?>
    <div class="card">Belum ada lamaran. <a href="<?= BASE_URL ?>/jobs">Cari lowongan</a></div>
<?php else: ?>
    <div class="card">
        <table>
            <thead>
                <tr><th>Lowongan</th><th>Status</th><th>Tanggal</th></tr>
            </thead>
            <tbody>
                <?php foreach ($applications as $a): ?>
                    <tr>
                        <td><?= e($a['job_title']) ?></td>
                        <td><span class="badge badge-<?= e($a['status']) ?>"><?= e($a['status']) ?></span></td>
                        <td><?= e($a['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
