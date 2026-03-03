<div class="card">
    <div class="card-body">
        <h1 class="card-title h4"><?= e($job['title']) ?></h1>
        <p class="text-muted">Lokasi: <?= e($job['location'] ?? '-') ?> | Gaji: <?= e($job['salary_range'] ?? '-') ?></p>
        <p class="fw-bold">Deskripsi:</p>
        <div class="mb-4"><?= nl2br(e($job['description'])) ?></div>
        <?php if (isLoggedIn() && currentRole() === 'user'): ?>
            <?php if ($alreadyApplied): ?>
                <p class="text-muted">Anda sudah melamar lowongan ini.</p>
            <?php elseif ($canApply): ?>
                <form method="post" action="<?= BASE_URL ?>/index.php?url=jobs/apply" enctype="multipart/form-data">
                    <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Upload CV (PDF atau DOCX, max 2 MB)</label>
                        <input type="file" class="form-control" name="cv" accept=".pdf,.docx" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Lamar Sekarang</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
        <hr>
        <a href="<?= BASE_URL ?>/jobs" class="btn btn-outline-secondary btn-sm">← Kembali ke daftar lowongan</a>
    </div>
</div>
