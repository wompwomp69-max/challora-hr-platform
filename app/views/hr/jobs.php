<h1>Dashboard HR — Lowongan Saya</h1>
<p><a href="<?= BASE_URL ?>/hr/jobs/create" class="btn">+ Buat Lowongan</a></p>
<?php if (empty($jobs)): ?>
    <div class="card">Belum ada lowongan. <a href="<?= BASE_URL ?>/hr/jobs/create">Buat pertama kali</a></div>
<?php else: ?>
    <div class="card">
        <table>
            <thead>
                <tr><th>Judul</th><th>Lokasi</th><th>Pelamar</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $j): ?>
                    <tr>
                        <td><?= e($j['title']) ?></td>
                        <td><?= e($j['location'] ?? '-') ?></td>
                        <td><a href="<?= BASE_URL ?>/hr/jobs/applicants?id=<?= (int)$j['id'] ?>"><?= (int)($j['applicant_count'] ?? 0) ?> pelamar</a></td>
                        <td>
                            <a href="<?= BASE_URL ?>/hr/jobs/edit?id=<?= (int)$j['id'] ?>" class="btn btn-sm">Edit</a>
                            <form method="post" action="<?= BASE_URL ?>/index.php?url=hr/jobs/delete" style="display: inline;" onsubmit="return confirm('Hapus lowongan ini?');">
                                <input type="hidden" name="id" value="<?= (int)$j['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
