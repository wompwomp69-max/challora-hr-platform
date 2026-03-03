<h1 class="mb-4">Dashboard HR — Lowongan Saya</h1>
<p><a href="<?= BASE_URL ?>/hr/jobs/create" class="btn btn-primary mb-3">+ Buat Lowongan</a></p>
<?php if (empty($jobs)): ?>
    <div class="card">
        <div class="card-body">Belum ada lowongan. <a href="<?= BASE_URL ?>/hr/jobs/create">Buat pertama kali</a></div>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr><th>Judul</th><th>Lokasi</th><th>Pelamar</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $j): ?>
                            <tr>
                                <td><?= e($j['title']) ?></td>
                                <td><?= e($j['location'] ?? '-') ?></td>
                                <td><a href="<?= BASE_URL ?>/hr/jobs/applicants?id=<?= (int)$j['id'] ?>"><?= (int)($j['applicant_count'] ?? 0) ?> pelamar</a></td>
                                <td class="d-flex gap-1">
                                    <a href="<?= BASE_URL ?>/hr/jobs/edit?id=<?= (int)$j['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="post" action="<?= BASE_URL ?>/index.php?url=hr/jobs/delete" class="d-inline" onsubmit="return confirm('Hapus lowongan ini?');">
                                        <input type="hidden" name="id" value="<?= (int)$j['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
