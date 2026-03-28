<div class="max-w-3xl mx-auto bg-surface rounded-2xl shadow-sm p-5 md:p-7">
    <div class="mb-4">
        <?php if (!empty($job['is_urgent'])): ?><span class="inline-flex items-center px-3 py-1 rounded-full bg-danger-soft text-danger text-xs font-semibold mb-2">Urgent</span><?php endif; ?>
        <h1 class="text-xl md:text-2xl font-semibold mb-1"><?= e($job['title']) ?></h1>
        <p class="text-sm text-muted">Lokasi: <?= e($job['location'] ?? '-') ?> | Gaji: <?= e($job['salary_range'] ?? '-') ?></p>
        <?php
        $jobSkills = !empty($job['skills_json']) ? json_decode($job['skills_json'], true) : [];
        $jobBenefits = !empty($job['benefits_json']) ? json_decode($job['benefits_json'], true) : [];
        ?>
        <?php if (is_array($jobSkills) && !empty($jobSkills)): ?>
        <div class="mb-1 text-sm">
            <span class="font-semibold">Skill:</span>
            <?php foreach ($jobSkills as $s): ?><span class="inline-flex items-center px-2 py-0.5 rounded-full bg-muted text-default text-xs mr-1 mb-1"><?= e($s) ?></span><?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if (is_array($jobBenefits) && !empty($jobBenefits)): ?>
        <div class="mb-3 text-sm">
            <span class="font-semibold">Benefit:</span>
            <?php foreach ($jobBenefits as $b): ?><span class="inline-flex items-center px-2 py-0.5 rounded-full bg-sky-soft text-sky text-xs mr-1 mb-1"><?= e($b) ?></span><?php endforeach; ?>
        </div>
        <?php endif; ?>
        <p class="font-semibold mb-1 mt-3 text-sm">Deskripsi</p>
        <div class="mb-5 text-sm leading-relaxed text-default"><?= nl2br(e($job['description'])) ?></div>
        <?php if (isLoggedIn() && currentRole() === 'user'): ?>
            <?php if ($alreadyApplied): ?>
                <div class="mb-4 flex flex-wrap items-center gap-2 text-sm">
                    <?php if ($isSaved ?? false): ?>
                    <form method="post" action="<?= BASE_URL ?>/jobs/unsave" class="inline">
                        <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                        <input type="hidden" name="redirect" value="/jobs/show?id=<?= (int)$job['id'] ?>">
                        <button type="submit" class="px-3 py-1.5 rounded-full bg-muted text-default text-xs font-medium hover:bg-muted">Hapus dari simpan</button>
                    </form>
                    <?php else: ?>
                    <form method="post" action="<?= BASE_URL ?>/jobs/save" class="inline">
                        <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                        <input type="hidden" name="redirect" value="/jobs/show?id=<?= (int)$job['id'] ?>">
                        <button type="submit" class="px-3 py-1.5 rounded-full bg-primary text-secondary text-xs font-medium hover:bg-primary-hover">Simpan lowongan</button>
                    </form>
                    <?php endif; ?>
                    <span class="text-muted">Anda sudah melamar lowongan ini.</span>
                </div>
            <?php elseif ($canApply): ?>
                <form id="apply-job-form" method="post" action="<?= BASE_URL ?>/index.php?url=jobs/apply">
                    <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                </form>
                <?php if (!($hasRequiredDocs ?? true)): ?>
                    <div class="mb-3 rounded-xl border border-warning/30 bg-warning-soft px-3 py-2 text-xs text-warning">
                        Lengkapi dokumen di Pengaturan terlebih dahulu: <?= e(implode(', ', $missingDocs ?? [])) ?>.
                        <a href="<?= BASE_URL ?>/user/settings" class="font-semibold underline">Buka Pengaturan</a>
                    </div>
                <?php endif; ?>
                <div class="flex flex-wrap gap-2 mb-4 items-center">
                    <?php if (($hasRequiredDocs ?? true)): ?>
                        <button type="button" id="open-apply-confirm" class="px-4 py-2 rounded-full bg-accent text-primary text-sm font-semibold">Lamar Sekarang</button>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/user/settings" class="px-4 py-2 rounded-full bg-primary text-secondary text-sm font-semibold hover:bg-primary-hover">Lengkapi Dokumen</a>
                    <?php endif; ?>
                    <?php if ($isSaved ?? false): ?>
                    <form method="post" action="<?= BASE_URL ?>/jobs/unsave" class="inline mb-0">
                        <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                        <input type="hidden" name="redirect" value="/jobs/show?id=<?= (int)$job['id'] ?>">
                        <button type="submit" class="px-4 py-2 rounded-full bg-muted text-default text-sm font-semibold hover:bg-muted">Hapus dari simpan</button>
                    </form>
                    <?php else: ?>
                    <form method="post" action="<?= BASE_URL ?>/jobs/save" class="inline mb-0">
                        <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                        <input type="hidden" name="redirect" value="/jobs/show?id=<?= (int)$job['id'] ?>">
                        <button type="submit" class="px-4 py-2 rounded-full bg-primary text-secondary text-sm font-semibold">Simpan lowongan</button>
                    </form>
                    <?php endif; ?>
                </div>
                <?php if (($hasRequiredDocs ?? true)): ?>
                    <div id="apply-confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
                        <div class="w-full max-w-md rounded-2xl border border-muted bg-surface p-5 shadow-lg">
                            <p class="text-sm text-default mb-4">
                                Kamu akan melamar <span class="font-semibold"><?= e($job['title']) ?></span>
                            </p>
                            <div class="flex justify-end gap-2">
                                <button type="button" id="close-apply-confirm" class="px-4 py-2 rounded-full border border-default text-sm text-default hover:bg-muted">Batal</button>
                                <button type="submit" form="apply-job-form" class="px-4 py-2 rounded-full bg-primary text-white text-sm font-semibold hover:bg-primary-hover">Ya, kirim lamaran</button>
                            </div>
                        </div>
                    </div>
                    <script>
                    (function () {
                        const openBtn = document.getElementById('open-apply-confirm');
                        const closeBtn = document.getElementById('close-apply-confirm');
                        const modal = document.getElementById('apply-confirm-modal');
                        if (!openBtn || !closeBtn || !modal) return;
                        openBtn.addEventListener('click', function () {
                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                        });
                        closeBtn.addEventListener('click', function () {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                        });
                        modal.addEventListener('click', function (event) {
                            if (event.target === modal) {
                                modal.classList.add('hidden');
                                modal.classList.remove('flex');
                            }
                        });
                    })();
                    </script>
                <?php endif; ?>
            <?php else: ?>
                <div class="mb-4">
                    <?php if ($isSaved ?? false): ?>
                    <form method="post" action="<?= BASE_URL ?>/jobs/unsave" class="inline">
                        <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                        <input type="hidden" name="redirect" value="/jobs/show?id=<?= (int)$job['id'] ?>">
                        <button type="submit" class="px-3 py-1.5 rounded-full bg-muted text-default text-xs font-medium hover:bg-muted">Hapus dari simpan</button>
                    </form>
                    <?php else: ?>
                    <form method="post" action="<?= BASE_URL ?>/jobs/save" class="inline">
                        <input type="hidden" name="job_id" value="<?= (int)$job['id'] ?>">
                        <input type="hidden" name="redirect" value="/jobs/show?id=<?= (int)$job['id'] ?>">
                        <button type="submit" class="px-3 py-1.5 rounded-full bg-primary text-white text-xs font-medium hover:bg-primary-hover">Simpan lowongan</button>
                    </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <hr class="my-4">
        <a href="<?= BASE_URL ?>/jobs" class="inline-flex items-center px-3 py-1.5 rounded-full border border-default text-xs text-muted hover:bg-muted">← Kembali ke daftar lowongan</a>
    </div>
</div>
