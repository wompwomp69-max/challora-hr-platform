<div class="card">
    <h1><?= e($job['title']) ?></h1>
    <p><strong>Lokasi:</strong> <?= e($job['location'] ?? '-') ?> | <strong>Gaji:</strong> <?= e($job['salary_range'] ?? '-') ?></p>
    <p><strong>Deskripsi:</strong></p>
    <div><?= nl2br(e($job['description'])) ?></div>
    <?php if (isLoggedIn() && currentRole() === 'user'): ?>
        <p style="margin-top: 1rem;">
            <?php if ($alreadyApplied): ?>
                <span>Anda sudah melamar lowongan ini.</span>
            <?php elseif ($canApply): ?>
                <form method="post" action="<?= BASE_URL ?>/index.php?url=jobs/apply" enctype="multipart/form-data">
                    <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                    <label>Upload CV (PDF atau DOCX, max 2 MB)</label>
                    <input type="file" name="cv" accept=".pdf,.docx" required>
                    <p style="margin-top: 0.5rem;"><button type="submit" class="btn">Lamar Sekarang</button></p>
                </form>
            <?php endif; ?>
        </p>
    <?php endif; ?>
    <p style="margin-top: 1rem;"><a href="<?= BASE_URL ?>/jobs">← Kembali ke daftar lowongan</a></p>
</div>
